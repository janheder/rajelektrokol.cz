<?php
/**
 * Copyright 2022 ModuleFactory
 *
 * @author    ModuleFactory
 * @copyright ModuleFactory all rights reserved.
 * @license   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
class FsCustomHtmlFilterModel extends ObjectModel
{
    /** @var int id_filter */
    public $id;

    /** @var string */
    public $content_type;

    /** @var int */
    public $id_content;

    /** @var int */
    public $id_filter_group;

    /** @var string */
    public $type;

    /** @var string */
    public $parameter;

    /** @var string */
    public $condition;

    /** @var string */
    public $value;

    /** @var string */
    public $date_add;

    /** @var string */
    public $date_upd;

    public static $sql_tables = [
        [
            'name' => 'fsch_filter',
            'columns' => [
                [
                    'name' => 'id_filter',
                    'params' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
                    'is_primary_key' => true,
                ],
                [
                    'name' => 'content_type',
                    'params' => 'varchar(100) NOT NULL',
                    'is_key' => true,
                ],
                [
                    'name' => 'id_content',
                    'params' => 'int(10) unsigned NOT NULL DEFAULT \'0\'',
                    'is_key' => true,
                ],
                [
                    'name' => 'id_filter_group',
                    'params' => 'int(10) unsigned NOT NULL DEFAULT \'0\'',
                    'is_key' => true,
                ],
                [
                    'name' => 'type',
                    'params' => 'varchar(255) NOT NULL',
                ],
                [
                    'name' => 'parameter',
                    'params' => 'varchar(255) NOT NULL',
                ],
                [
                    'name' => 'condition',
                    'params' => 'varchar(255) NOT NULL',
                ],
                [
                    'name' => 'value',
                    'params' => 'text NOT NULL',
                ],
                [
                    'name' => 'date_add',
                    'params' => 'datetime NOT NULL',
                ],
                [
                    'name' => 'date_upd',
                    'params' => 'datetime NOT NULL',
                ],
            ],
        ],
    ];

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'fsch_filter',
        'primary' => 'id_filter',
        'fields' => [
            'content_type' => ['type' => self::TYPE_STRING, 'validate' => 'isAnything', 'required' => true],
            'id_content' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true],
            'id_filter_group' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true],
            'type' => ['type' => self::TYPE_STRING, 'validate' => 'isAnything', 'required' => true],
            'parameter' => ['type' => self::TYPE_STRING, 'validate' => 'isAnything'],
            'condition' => ['type' => self::TYPE_STRING, 'validate' => 'isAnything'],
            'value' => ['type' => self::TYPE_STRING, 'validate' => 'isAnything'],
            'date_add' => ['type' => self::TYPE_DATE, 'validate' => 'isDateFormat'],
            'date_upd' => ['type' => self::TYPE_DATE, 'validate' => 'isDateFormat'],
        ],
    ];

    public function toArray()
    {
        return [
            'id_filter' => $this->id,
            'content_type' => $this->content_type,
            'id_content' => $this->id_content,
            'id_filter_group' => $this->id_filter_group,
            'type' => $this->type,
            'parameter' => $this->parameter,
            'condition' => $this->condition,
            'value' => $this->value,
        ];
    }

    public function fill($data)
    {
        foreach ($data as $field_name => $field_value) {
            if (in_array($field_name, array_keys(self::$definition['fields']))) {
                $this->{$field_name} = $field_value;
            }
        }

        if (isset($data[self::$definition['primary']])) {
            $this->id = $data[self::$definition['primary']];
        }
    }

    public function bulkSave($id_content, $bulk_filters)
    {
        $class_name = get_class($this);
        $this->deleteFilters($id_content);

        foreach ($bulk_filters as $filter_group) {
            foreach ($filter_group as $filter) {
                $new = new $class_name();
                $new->id_content = $id_content;
                $new->fill($filter);
                $new->save();
            }
        }
    }

    public function deleteFilters($id_content)
    {
        return Db::getInstance()->delete(
            self::$definition['table'],
            '`id_content` = ' . (int) $id_content . ' AND `content_type` = \'' . pSQL($this->content_type) . '\''
        );
    }

    public function getFilters($id_content)
    {
        $sql = 'SELECT * FROM `' . _DB_PREFIX_ . pSQL(self::$definition['table']) . '` WHERE';
        $sql .= ' `id_content` = ' . (int) $id_content . ' AND `content_type` = \'' . pSQL($this->content_type) . '\'';
        $sql .= ' ORDER BY id_filter_group, id_filter ASC';

        return Db::getInstance()->executeS($sql);
    }

    public function getFiltersForForm($id_content)
    {
        $filters_raw = $this->getFilters($id_content);
        $filters = [];
        if ($filters_raw) {
            foreach ($filters_raw as $filter) {
                $filters[$filter['id_filter_group']][] = $filter;
            }
        }

        return $filters;
    }

    public function test($id_content)
    {                
        $content_filters = $this->getFiltersForForm($id_content);
        if ($content_filters) {
            foreach ($content_filters as $filter_group) {
                $group_result = true;
                foreach ($filter_group as $filter) {
                    $filterTester = Tools::toCamelCase('test_' . $filter['type']);
                    if (is_callable([$this, $filterTester])) {
                        $group_result = $group_result && call_user_func(
                            [$this, $filterTester],
                            $filter
                        );
                    }
                }

                if ($group_result) {
                    return true;
                }
            }
        }

        return false;
    }

    // ############### PAGE ################

    protected function testPageType($filter)
    {
        if ($filter['value'] == 'all') {
            return true;
        }

        $context = Context::getContext();
        $page_name = $context->controller->getPageName();

        switch ($filter['condition']) {
            case 'equals':
                if ($filter['value'] == $page_name) {
                    return true;
                }
                break;
            case 'notequals':
                if ($filter['value'] != $page_name) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testPageTypeInternal($page_name)
    {
        $filter = ['value' => $page_name, 'condition' => 'equals'];

        return $this->testPageType($filter);
    }

    // ############### CATEGORY ################

    protected function testCategory($filter)
    {
        if (!$this->testPageTypeInternal('category')) {
            return false;
        }

        $context = Context::getContext();
        $id_category = 0;

        if (is_callable([$context->controller, 'getCategory'])) {
            $category = $context->controller->getCategory();
            if (Validate::isLoadedObject($category)) {
                $id_category = $category->id;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $id_category) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $id_category) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCategoryParent($filter)
    {
        if (!$this->testPageTypeInternal('category')) {
            return false;
        }

        $context = Context::getContext();
        $id_category_parent = 0;

        if (is_callable([$context->controller, 'getCategory'])) {
            $category = $context->controller->getCategory();
            if (Validate::isLoadedObject($category)) {
                $id_category_parent = $category->id_parent;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $id_category_parent) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $id_category_parent) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCategoryChildren($filter)
    {
        if (!$this->testPageTypeInternal('category')) {
            return false;
        }

        $context = Context::getContext();
        $parent_categories = [];

        if (is_callable([$context->controller, 'getCategory'])) {
            $category = $context->controller->getCategory();
            if (Validate::isLoadedObject($category)) {
                if ((int) $filter['value'] == (int) $category->id) {
                    return false;
                }

                $parent_categories_raw = $category->getParentsCategories();
                if ($parent_categories_raw) {
                    foreach ($parent_categories_raw as $parent_category_raw) {
                        $parent_categories[] = (int) $parent_category_raw['id_category'];
                    }
                }
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if (in_array((int) $filter['value'], $parent_categories)) {
                    return true;
                }
                break;
            case 'notequals':
                if (!in_array((int) $filter['value'], $parent_categories)) {
                    return true;
                }
                break;
        }

        return false;
    }

    // ############### PRODUCT ################

    protected function testProduct($filter)
    {
        if (!$this->testPageTypeInternal('product')) {
            return false;
        }

        $context = Context::getContext();
        $id_product = 0;

        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $id_product = $product->id;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $id_product) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $id_product) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductCategory($filter)
    {
        if (!$this->testPageTypeInternal('product')) {
            return false;
        }

        $context = Context::getContext();
        $categories = [];

        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $categories = Product::getProductCategories($product->id);
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if (in_array($filter['value'], $categories)) {
                    return true;
                }
                break;
            case 'notequals':
                if (!in_array($filter['value'], $categories)) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductDefaultCategory($filter)
    {
        if (!$this->testPageTypeInternal('product')) {
            return false;
        }

        $context = Context::getContext();
        $id_product_default_category = 0;

        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $id_product_default_category = $product->id_category_default;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $id_product_default_category) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $id_product_default_category) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductManufacturer($filter)
    {
        if (!$this->testPageTypeInternal('product')) {
            return false;
        }

        $context = Context::getContext();
        $id_product_manufacturer = 0;

        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $id_product_manufacturer = $product->id_manufacturer;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $id_product_manufacturer) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $id_product_manufacturer) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductSupplier($filter)
    {
        if (!$this->testPageTypeInternal('product')) {
            return false;
        }

        $context = Context::getContext();
        $id_product_supplier = 0;

        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $id_product_supplier = $product->id_supplier;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $id_product_supplier) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $id_product_supplier) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductAvailability($filter)
    {
        if (!$this->testPageTypeInternal('product')) {
            return false;
        }

        $context = Context::getContext();
        $availability = 0;

        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $availability = (int) $product->out_of_stock;
                if ($availability == 2) {
                    $availability = (int) Configuration::get('PS_ORDER_OUT_OF_STOCK');
                }
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == $availability) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != $availability) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductQuantity($filter)
    {
        if (!$this->testPageTypeInternal('product')) {
            return false;
        }

        $context = Context::getContext();
        $quantity = 0;

        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $quantity = $product->quantity;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $quantity) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $quantity) {
                    return true;
                }
                break;
            case 'less':
                if ((int) $filter['value'] > (int) $quantity) {
                    return true;
                }
                break;
            case 'greater':
                if ((int) $filter['value'] < (int) $quantity) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductPrice($filter)
    {
        if (!$this->testPageTypeInternal('product')) {
            return false;
        }

        $context = Context::getContext();
        $price = 0;

        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $price = $product->price;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((float) $filter['value'] == (float) $price) {
                    return true;
                }
                break;
            case 'notequals':
                if ((float) $filter['value'] != (float) $price) {
                    return true;
                }
                break;
            case 'less':
                if ((float) $filter['value'] > (float) $price) {
                    return true;
                }
                break;
            case 'greater':
                if ((float) $filter['value'] < (float) $price) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductPriceSpecific($filter)
    {
        $context = Context::getContext();
        $has_specific_price = false;
        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $has_specific_price = (bool) $product->specificPrice;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((bool) $filter['value'] == $has_specific_price) {
                    return true;
                }
                break;
            case 'notequals':
                if ((bool) $filter['value'] != $has_specific_price) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductAvailableForOrder($filter)
    {
        $context = Context::getContext();
        $available_for_order = false;
        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $available_for_order = (bool) $product->available_for_order;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((bool) $filter['value'] == $available_for_order) {
                    return true;
                }
                break;
            case 'notequals':
                if ((bool) $filter['value'] != $available_for_order) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductShowPrice($filter)
    {
        $context = Context::getContext();
        $show_price = false;
        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $show_price = (bool) $product->show_price || (bool) $product->available_for_order;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((bool) $filter['value'] == $show_price) {
                    return true;
                }
                break;
            case 'notequals':
                if ((bool) $filter['value'] != $show_price) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductOnlineOnly($filter)
    {
        $context = Context::getContext();
        $online_only = false;
        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $online_only = (bool) $product->online_only;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((bool) $filter['value'] == $online_only) {
                    return true;
                }
                break;
            case 'notequals':
                if ((bool) $filter['value'] != $online_only) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductOnSale($filter)
    {
        $context = Context::getContext();
        $on_sale = false;
        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $on_sale = (bool) $product->on_sale;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((bool) $filter['value'] == $on_sale) {
                    return true;
                }
                break;
            case 'notequals':
                if ((bool) $filter['value'] != $on_sale) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductCondition($filter)
    {
        $context = Context::getContext();
        $condition = '';
        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $condition = $product->condition;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ($filter['value'] == $condition) {
                    return true;
                }
                break;
            case 'notequals':
                if ($filter['value'] != $condition) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductVisibility($filter)
    {
        $context = Context::getContext();
        $visibility = '';
        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $visibility = $product->visibility;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ($filter['value'] == $visibility) {
                    return true;
                }
                break;
            case 'notequals':
                if ($filter['value'] != $visibility) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductTag($filter)
    {        
        
        if (!$this->testPageTypeInternal('product')) {
            return false;
        }

        $context = Context::getContext();
        $tags = [];

        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'product_tag`';
                //$sql .= ' WHERE `id_product` LIKE \'%' . pSQL($product->id) . '%\'';
                $sql .= ' WHERE `id_product` = ' . pSQL($product->id);
                $result = Db::getInstance()->executeS($sql);

                if ($result) {
                    foreach ($result as $row) {
                        $tags[] = $row['id_tag'];
                    }
                }
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if (in_array($filter['value'], $tags)) {
                    return true;
                }
                break;
            case 'notequals':
                if (!in_array($filter['value'], $tags)) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testProductWeight($filter)
    {
        if (!$this->testPageTypeInternal('product')) {
            return false;
        }

        $context = Context::getContext();
        $weight = 0;

        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $weight = $product->weight;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((float) $filter['value'] == (float) $weight) {
                    return true;
                }
                break;
            case 'notequals':
                if ((float) $filter['value'] != (float) $weight) {
                    return true;
                }
                break;
            case 'less':
                if ((float) $filter['value'] > (float) $weight) {
                    return true;
                }
                break;
            case 'greater':
                if ((float) $filter['value'] < (float) $weight) {
                    return true;
                }
                break;
        }

        return false;
    }

    // ############### MANUFACTURER ################

    protected function testManufacturer($filter)
    {
        if (!$this->testPageTypeInternal('manufacturer')) {
            return false;
        }

        if ($id_manufacturer = Tools::getValue('id_manufacturer')) {
            $manufacturer = new Manufacturer($id_manufacturer);
            if (!Validate::isLoadedObject($manufacturer)) {
                $id_manufacturer = 0;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $id_manufacturer) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $id_manufacturer) {
                    return true;
                }
                break;
        }

        return false;
    }

    // ############### SUPPLIER ################

    protected function testSupplier($filter)
    {
        if (!$this->testPageTypeInternal('supplier')) {
            return false;
        }

        if ($id_supplier = Tools::getValue('id_supplier')) {
            $supplier = new Supplier($id_supplier);
            if (!Validate::isLoadedObject($supplier)) {
                $id_supplier = 0;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $id_supplier) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $id_supplier) {
                    return true;
                }
                break;
        }

        return false;
    }

    // ############### CMS ################

    protected function testCmsPage($filter)
    {
        if (!$this->testPageTypeInternal('cms')) {
            return false;
        }

        if ($id_cms = Tools::getValue('id_cms')) {
            $cms = new CMS($id_cms);
            if (!Validate::isLoadedObject($cms)) {
                $id_cms = 0;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $id_cms) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $id_cms) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCmsPageCategory($filter)
    {
        if (!$this->testPageTypeInternal('cms')) {
            return false;
        }

        $id_cms_category = 0;
        if ($id_cms = Tools::getValue('id_cms')) {
            $cms = new CMS($id_cms);
            if (Validate::isLoadedObject($cms)) {
                $id_cms_category = $cms->id_cms_category;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $id_cms_category) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $id_cms_category) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCmsCategory($filter)
    {
        if (!$this->testPageTypeInternal('cms')) {
            return false;
        }

        if ($id_cms_category = Tools::getValue('id_cms_category')) {
            $cms_category = new CMSCategory($id_cms_category);
            if (!Validate::isLoadedObject($cms_category)) {
                $id_cms_category = 0;
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $id_cms_category) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $id_cms_category) {
                    return true;
                }
                break;
        }

        return false;
    }

    // ############### CUSTOMER ################

    protected function testCustomer($filter)
    {
        $context = Context::getContext();
        $id_customer = 0;
        if (Validate::isLoadedObject($context->customer)) {
            $id_customer = (int) $context->customer->id;
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == $id_customer) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != $id_customer) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCustomerGender($filter)
    {
        $context = Context::getContext();
        $id_gender = 0;
        if (Validate::isLoadedObject($context->customer)) {
            $id_gender = (int) $context->customer->id_gender;
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == $id_gender) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != $id_gender) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCustomerGroup($filter)
    {
        $context = Context::getContext();
        $groups = [];
        if (is_callable([$context->customer, 'getGroups'])) {
            $groups = $context->customer->getGroups();
        }

        switch ($filter['condition']) {
            case 'equals':
                if (in_array((int) $filter['value'], $groups)) {
                    return true;
                }
                break;
            case 'notequals':
                if (!in_array((int) $filter['value'], $groups)) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCustomerBoughtProduct($filter)
    {
        $context = Context::getContext();
        $bought_products = [];
        if (Validate::isLoadedObject($context->customer)) {
            $bought_products_raw = $context->customer->getBoughtProducts();
            if ($bought_products_raw) {
                foreach ($bought_products_raw as $bought_product_raw) {
                    $bought_products[] = (int) $bought_product_raw['product_id'];
                }
            }
            $bought_products = array_unique($bought_products);
        }

        switch ($filter['condition']) {
            case 'equals':
                if (in_array((int) $filter['value'], $bought_products)) {
                    return true;
                }
                break;
            case 'notequals':
                if (!in_array((int) $filter['value'], $bought_products)) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCustomerBoughtCategory($filter)
    {
        $context = Context::getContext();
        $bought_categories = [];
        if (Validate::isLoadedObject($context->customer)) {
            $bought_products = [];
            $bought_products_raw = $context->customer->getBoughtProducts();
            if ($bought_products_raw) {
                foreach ($bought_products_raw as $bought_product_raw) {
                    $bought_products[] = (int) $bought_product_raw['product_id'];
                }
            }
            $bought_products = array_unique($bought_products);

            if ($bought_products) {
                foreach ($bought_products as $bought_product) {
                    $product = new Product($bought_product);
                    if (Validate::isLoadedObject($product)) {
                        $categories = Product::getProductCategories($product->id);
                        $bought_categories = array_merge($bought_categories, array_values($categories));
                    }
                }
            }
            $bought_categories = array_unique($bought_categories);
        }

        switch ($filter['condition']) {
            case 'equals':
                if (in_array((int) $filter['value'], $bought_categories)) {
                    return true;
                }
                break;
            case 'notequals':
                if (!in_array((int) $filter['value'], $bought_categories)) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCustomerNewsletterSubscription($filter)
    {
        $context = Context::getContext();
        $newsletter = false;
        if (Validate::isLoadedObject($context->customer)) {
            $newsletter = (bool) $context->customer->newsletter;
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((bool) $filter['value'] == $newsletter) {
                    return true;
                }
                break;
            case 'notequals':
                if ((bool) $filter['value'] != $newsletter) {
                    return true;
                }
                break;
        }

        return false;
    }

    // ############### CART ################

    protected function testCartHasCurrentProduct($filter)
    {
        if (!$this->testPageTypeInternal('product')) {
            return false;
        }

        $context = Context::getContext();
        $id_product = 0;

        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $id_product = $product->id;
            }
        }

        $cart_products = [];
        if (Validate::isLoadedObject($context->cart)) {
            $cart_products_raw = $context->cart->getProducts();
            if ($cart_products_raw) {
                foreach ($cart_products_raw as $cart_product_raw) {
                    $cart_products[] = (int) $cart_product_raw['id_product'];
                }
            }
            $cart_products = array_unique($cart_products);
        }

        switch ($filter['condition']) {
            case 'equals':
                if (in_array((int) $id_product, $cart_products)) {
                    return true;
                }
                break;
            case 'notequals':
                if (!in_array((int) $id_product, $cart_products)) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCartHasProduct($filter)
    {
        $context = Context::getContext();
        $cart_products = [];
        if (Validate::isLoadedObject($context->cart)) {
            $cart_products_raw = $context->cart->getProducts();
            if ($cart_products_raw) {
                foreach ($cart_products_raw as $cart_product_raw) {
                    $cart_products[] = (int) $cart_product_raw['id_product'];
                }
            }
            $cart_products = array_unique($cart_products);
        }

        switch ($filter['condition']) {
            case 'equals':
                if (in_array((int) $filter['value'], $cart_products)) {
                    return true;
                }
                break;
            case 'notequals':
                if (!in_array((int) $filter['value'], $cart_products)) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCartHasCategory($filter)
    {
        $context = Context::getContext();
        $cart_categories = [];
        if (Validate::isLoadedObject($context->cart)) {
            $cart_products = [];
            $cart_products_raw = $context->cart->getProducts();
            if ($cart_products_raw) {
                foreach ($cart_products_raw as $cart_product_raw) {
                    $cart_products[] = (int) $cart_product_raw['id_product'];
                }
            }
            $cart_products = array_unique($cart_products);

            if ($cart_products) {
                foreach ($cart_products as $cart_product) {
                    $product = new Product($cart_product);
                    if (Validate::isLoadedObject($product)) {
                        $categories = Product::getProductCategories($product->id);
                        $cart_categories = array_merge($cart_categories, array_values($categories));
                    }
                }
            }
            $cart_categories = array_unique($cart_categories);
        }

        switch ($filter['condition']) {
            case 'equals':
                if (in_array((int) $filter['value'], $cart_categories)) {
                    return true;
                }
                break;
            case 'notequals':
                if (!in_array((int) $filter['value'], $cart_categories)) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCartTotal($filter)
    {
        $context = Context::getContext();
        $cart_total = 0;
        if (Validate::isLoadedObject($context->cart)) {
            $cart_total = $context->cart->getOrderTotal(false, Cart::BOTH_WITHOUT_SHIPPING);
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((float) $filter['value'] == (float) $cart_total) {
                    return true;
                }
                break;
            case 'notequals':
                if ((float) $filter['value'] != (float) $cart_total) {
                    return true;
                }
                break;
            case 'less':
                if ((float) $filter['value'] > (float) $cart_total) {
                    return true;
                }
                break;
            case 'greater':
                if ((float) $filter['value'] < (float) $cart_total) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCartWeight($filter)
    {
        $context = Context::getContext();
        $cart_weight = 0;
        if (Validate::isLoadedObject($context->cart)) {
            $cart_weight = $context->cart->getTotalWeight();
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((float) $filter['value'] == (float) $cart_weight) {
                    return true;
                }
                break;
            case 'notequals':
                if ((float) $filter['value'] != (float) $cart_weight) {
                    return true;
                }
                break;
            case 'less':
                if ((float) $filter['value'] > (float) $cart_weight) {
                    return true;
                }
                break;
            case 'greater':
                if ((float) $filter['value'] < (float) $cart_weight) {
                    return true;
                }
                break;
        }

        return false;
    }

    // ############### LOCATION ################

    protected function testLocationZone($filter)
    {
        $context = Context::getContext();
        $id_zone = 0;

        if (Validate::isLoadedObject($context->country)) {
            $id_zone = $context->country->id_zone;
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $id_zone) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $id_zone) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testLocationCountry($filter)
    {
        $context = Context::getContext();
        $id_country = 0;

        if (Validate::isLoadedObject($context->country)) {
            $id_country = $context->country->id;
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == (int) $id_country) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != (int) $id_country) {
                    return true;
                }
                break;
        }

        return false;
    }

    // ############### OTHER ################

    protected function testRequestUri($filter)
    {
        $fshelper = FsCustomHtmlHelper::getInstance();
        $request_uri = $fshelper->getRequestUri();

        switch ($filter['condition']) {
            case 'equals':
                if ($filter['value'] == $request_uri) {
                    return true;
                }
                break;
            case 'notequals':
                if ($filter['value'] != $request_uri) {
                    return true;
                }
                break;
            case 'startswith':
                if ($fshelper->startsWith($request_uri, $filter['value'])) {
                    return true;
                }
                break;
            case 'contains':
                if ($fshelper->contains($request_uri, $filter['value'])) {
                    return true;
                }
                break;
            case 'endswith':
                if ($fshelper->endsWith($request_uri, $filter['value'])) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testQueryString($filter)
    {
        $fshelper = FsCustomHtmlHelper::getInstance();
        $query_string = '';

        if (isset($_SERVER['QUERY_STRING'])) {
            $query_string = urldecode($_SERVER['QUERY_STRING']);
        }

        switch ($filter['condition']) {
            case 'equals':
                if ($filter['value'] == $query_string) {
                    return true;
                }
                break;
            case 'notequals':
                if ($filter['value'] != $query_string) {
                    return true;
                }
                break;
            case 'startswith':
                if ($fshelper->startsWith($query_string, $filter['value'])) {
                    return true;
                }
                break;
            case 'contains':
                if ($fshelper->contains($query_string, $filter['value'])) {
                    return true;
                }
                break;
            case 'endswith':
                if ($fshelper->endsWith($query_string, $filter['value'])) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testQueryParameter($filter)
    {
        $fshelper = FsCustomHtmlHelper::getInstance();
        $query_param_value = Tools::getValue($filter['parameter'], '');

        switch ($filter['condition']) {
            case 'equals':
                if ($filter['value'] == $query_param_value) {
                    return true;
                }
                break;
            case 'notequals':
                if ($filter['value'] != $query_param_value) {
                    return true;
                }
                break;
            case 'startswith':
                if ($fshelper->startsWith($query_param_value, $filter['value'])) {
                    return true;
                }
                break;
            case 'contains':
                if ($fshelper->contains($query_param_value, $filter['value'])) {
                    return true;
                }
                break;
            case 'endswith':
                if ($fshelper->endsWith($query_param_value, $filter['value'])) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testMobile($filter)
    {
        $context = Context::getContext();
        $is_mobile = $context->isMobile();

        switch ($filter['condition']) {
            case 'equals':
                if ((bool) $filter['value'] == $is_mobile) {
                    return true;
                }
                break;
            case 'notequals':
                if ((bool) $filter['value'] != $is_mobile) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testTablet($filter)
    {
        $context = Context::getContext();
        $is_tablet = $context->isTablet();

        switch ($filter['condition']) {
            case 'equals':
                if ((bool) $filter['value'] == $is_tablet) {
                    return true;
                }
                break;
            case 'notequals':
                if ((bool) $filter['value'] != $is_tablet) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testDesktop($filter)
    {
        $context = Context::getContext();
        $is_desktop = !$context->isTablet() && !$context->isMobile();

        switch ($filter['condition']) {
            case 'equals':
                if ((bool) $filter['value'] == $is_desktop) {
                    return true;
                }
                break;
            case 'notequals':
                if ((bool) $filter['value'] != $is_desktop) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testCurrency($filter)
    {
        $context = Context::getContext();
        $id_currency = 0;

        if (Validate::isLoadedObject($context->currency)) {
            $id_currency = $context->currency->id;
        }

        switch ($filter['condition']) {
            case 'equals':
                if ((int) $filter['value'] == $id_currency) {
                    return true;
                }
                break;
            case 'notequals':
                if ((int) $filter['value'] != $id_currency) {
                    return true;
                }
                break;
        }

        return false;
    }

    // ############### Date / Time ################

    protected function testDateTime($filter)
    {
        $date = date('Y-m-d H:m');
        switch ($filter['condition']) {
            case 'equals':
                if ($filter['value'] == $date) {
                    return true;
                }
                break;
            case 'notequals':
                if ($filter['value'] != $date) {
                    return true;
                }
                break;
            case 'less':
                if ($filter['value'] > $date) {
                    return true;
                }
                break;
            case 'greater':
                if ($filter['value'] < $date) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testDate($filter)
    {
        $date = date('Y-m-d');
        switch ($filter['condition']) {
            case 'equals':
                if ($filter['value'] == $date) {
                    return true;
                }
                break;
            case 'notequals':
                if ($filter['value'] != $date) {
                    return true;
                }
                break;
            case 'less':
                if ($filter['value'] > $date) {
                    return true;
                }
                break;
            case 'greater':
                if ($filter['value'] < $date) {
                    return true;
                }
                break;
        }

        return false;
    }

    protected function testTime($filter)
    {
        $time = date('H:m');
        switch ($filter['condition']) {
            case 'equals':
                if ($filter['value'] == $time) {
                    return true;
                }
                break;
            case 'notequals':
                if ($filter['value'] != $time) {
                    return true;
                }
                break;
            case 'less':
                if ($filter['value'] > $time) {
                    return true;
                }
                break;
            case 'greater':
                if ($filter['value'] < $time) {
                    return true;
                }
                break;
        }

        return false;
    }
    
    /*TOM*/
    protected function testProductFeature($filter)
    {                        
        if (!$this->testPageTypeInternal('product')) {
            return false;
        }                        
                

        $context = Context::getContext();
        $feature_value = [];

        if (is_callable([$context->controller, 'getProduct'])) {
            $product = $context->controller->getProduct();
            if (Validate::isLoadedObject($product)) {
                $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'feature_product` ';
                //$sql .= ' JOIN ps_feature_value_lang fvl ON fvl.id_feature_value=fp.id_feature_value ';                
                //$sql .= ' WHERE `id_product` = ' . pSQL($product->id) . ' and id_feature=' . pSQL($filter['parameter']);
                $sql .= ' WHERE `id_product` = ' . pSQL($product->id);
                $result = Db::getInstance()->executeS($sql);

                if ($result) {
                    foreach ($result as $row) {
                        $feature_value[] = $row['id_feature_value'];
                    }
                }
            }
        }

        switch ($filter['condition']) {
            case 'equals':
                if (in_array($filter['value'], $feature_value)) {
                    return true;
                }
                break;
            case 'notequals':
                if (!in_array($filter['value'], $feature_value)) {
                    return true;
                }
                break;
        }                

        return false;
    }
}
