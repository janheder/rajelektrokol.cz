<?php

/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */


include_once(_PS_MODULE_DIR_ . '/bonmegamenu/bonmegamenu.php');

class ClassBonmegamenuConstructor
{
    public static function renderChoicesSelect()
    {
        $module = new Bonmegamenu();

        $spacer = str_repeat('&nbsp;', '5');
        $items = ClassBonmegamenuConstructor::getMenuItems((int)Tools::getValue('id_tab'));

        $html = '<select multiple="multiple" id="availableItems" style="width: 300px; height: 160px;">';
        $html .= '<optgroup label="' . $module->l('CMS') . '">';
        $html .= ClassBonmegamenuConstructor::getCMSOptions(0, 1, (int)Context::getContext()->language->id, $items);
        $html .= '</optgroup>';

        // BEGIN SUPPLIER
        $html .= '<optgroup label="' . $module->l('Supplier') . '">';
        // Option to show all Suppliers
        $html .= '<option value="ALLSUP0">' . $module->l('All suppliers') . '</option>';
        $suppliers = Supplier::getSuppliers(false, (int)Context::getContext()->language->id);
        foreach ($suppliers as $supplier) {
            if (!in_array('SUP' . $supplier['id_supplier'], $items)) {
                $html .= '<option value="SUP' . $supplier['id_supplier'] . '">' . $spacer . $supplier['name'] . '</option>';
            }
        }
        $html .= '</optgroup>';

        // BEGIN Manufacturer
        $html .= '<optgroup label="' . $module->l('Brand') . '">';
        // Option to show all Manufacturers
        $html .= '<option value="ALLMAN0">' . $module->l('All brands') . '</option>';
        $manufacturers = Manufacturer::getManufacturers(false, (int)Context::getContext()->language->id);
        foreach ($manufacturers as $manufacturer) {
            if (!in_array('MAN' . $manufacturer['id_manufacturer'], $items)) {
                $html .= '<option value="MAN' . $manufacturer['id_manufacturer'] . '">' . $spacer . $manufacturer['name'] . '</option>';
            }
        }
        $html .= '</optgroup>';

        // BEGIN Categories
        $shop = new Shop((int) Shop::getContextShopID());
        $html .= '<optgroup label="' . $module->l('Categories') . '">';

        $shops_to_get = Shop::getContextListShopID();

        foreach ($shops_to_get as $shop_id) {
            $html .= ClassBonmegamenuConstructor::generateCategoriesOption(ClassBonmegamenuConstructor::customGetNestedCategories($shop_id, null, (int) (int)Context::getContext()->language->id, false), $items);
        }
        $html .= '</optgroup>';

        // BEGIN Shops
        if (Shop::isFeatureActive()) {
            $html .= '<optgroup label="' . $module->l('Shops') . '">';
            $shops = Shop::getShopsCollection();
            /** @var Shop $shop */
            foreach ($shops as $shop) {
                if (!$shop->setUrl() && !$shop->getBaseURL()) {
                    continue;
                }

                if (!in_array('SHOP' . (int) $shop->id, $items)) {
                    $html .= '<option value="SHOP' . (int) $shop->id . '">' . $spacer . $shop->name . '</option>';
                }
            }
            $html .= '</optgroup>';
        }

        // BEGIN Products
        $html .= '<optgroup label="' . $module->l('Products') . '">';
        $html .= '<option value="PRODUCT" style="font-style:italic">' . $spacer . $module->l('Choose product ID') . '</option>';
        $html .= '</optgroup>';

        // BEGIN Menu Top Links
        $html .= '<optgroup label="' . $module->l('Menu Top Links') . '">';

        $linksClass = new ClassBonmegamenuLinks((int)Tools::getValue('id_tab'));
        $links = $linksClass->getBonmegamenuLinksList((int)Tools::getValue('id_tab'));
    
        $links = $links ? $links : [];

        if (count($links) > 0) {
            foreach ($links as $link) {
                $html .= '<option value="LNK' . (int) $link['id_sub'] . '">' . $spacer . Tools::safeOutput($link['label']) . '</option>';
            }
        }
        
        $html .= '</optgroup>';
        $html .= '</select>';

        return $html;
    }

    public static function getMenuItems($id_tab)
    {
        $tab = new ClassBonmegamenu($id_tab);
        $menu_items = Tools::getValue('menu_items', $tab->menu_items);
        if (!is_array($menu_items)) {
            $menu_items = explode(",", (string)$menu_items);
        }
        if (is_array($menu_items) && count($menu_items)) {
            return $menu_items;
        } else {
            $shops = Shop::getContextListShopID();
            $conf = null;

            if (count($shops) > 1) {
                foreach ($shops as $key => $shop_id) {
                    $shop_group_id = Shop::getGroupFromShop($shop_id);
                    $conf .= (string) ($key > 1 ? ',' : '') . $menu_items;
                }
            } else {
                $shop_id = (int) $shops[0];
                $shop_group_id = Shop::getGroupFromShop($shop_id);
                $conf = $menu_items;
            }

            if (strlen($conf)) {
                return explode(',', $conf);
            } else {
                return [];
            }
        }
    }

    public static function getCMSOptions($parent = 0, $depth = 1, $id_lang = false, $items_to_skip = null, $id_shop = false)
    {
        $html = '';
        $id_lang = $id_lang ? (int) $id_lang : (int) Context::getContext()->language->id;
        $id_shop = ($id_shop !== false) ? $id_shop : Context::getContext()->shop->id;
        $categories = ClassBonmegamenuConstructor::getCMSCategories(false, (int) $parent, (int) $id_lang, (int) $id_shop);
        $pages = ClassBonmegamenuConstructor::getCMSPages((int) $parent, (int) $id_shop, (int) $id_lang);

        $spacer = str_repeat('&nbsp;', '5' * (int) $depth);

        foreach ($categories as $category) {
            if (isset($items_to_skip) && !in_array('CMS_CAT' . $category['id_cms_category'], $items_to_skip)) {
                $html .= '<option value="CMS_CAT' . $category['id_cms_category'] . '" style="font-weight: bold;">' . $spacer . $category['name'] . '</option>';
            }
            $html .= ClassBonmegamenuConstructor::getCMSOptions($category['id_cms_category'], (int) $depth + 1, (int) $id_lang, $items_to_skip);
        }

        foreach ($pages as $page) {
            if (isset($items_to_skip) && !in_array('CMS' . $page['id_cms'], $items_to_skip)) {
                $html .= '<option value="CMS' . $page['id_cms'] . '">' . $spacer . $page['meta_title'] . '</option>';
            }
        }

        return $html;
    }

    public static function getCMSCategories($recursive = false, $parent = 1, $id_lang = false, $id_shop = false)
    {
        $id_lang = $id_lang ? (int) $id_lang : (int)Context::getContext()->language->id;
        $id_shop = ($id_shop !== false) ? $id_shop : Context::getContext()->shop->id;
        $join_shop = '';
        $where_shop = '';

        if (Tools::version_compare(_PS_VERSION_, '1.6.0.12', '>=') == true) {
            $join_shop = ' INNER JOIN `' . _DB_PREFIX_ . 'cms_category_shop` cs
   ON (bcp.`id_cms_category` = cs.`id_cms_category`)';
            $where_shop = ' AND cs.`id_shop` = ' . (int) $id_shop . ' AND cl.`id_shop` = ' . (int) $id_shop;
        }

        if ($recursive === false) {
            $sql = 'SELECT bcp.`id_cms_category`, bcp.`id_parent`, bcp.`level_depth`, bcp.`active`, bcp.`position`, cl.`name`, cl.`link_rewrite`
    FROM `' . _DB_PREFIX_ . 'cms_category` bcp' .
                $join_shop . '
    INNER JOIN `' . _DB_PREFIX_ . 'cms_category_lang` cl
    ON (bcp.`id_cms_category` = cl.`id_cms_category`)
    WHERE cl.`id_lang` = ' . (int) $id_lang . '
    AND bcp.`id_parent` = ' . (int) $parent .
                $where_shop;

            return Db::getInstance()->executeS($sql);
        } else {
            $sql = 'SELECT bcp.`id_cms_category`, bcp.`id_parent`, bcp.`level_depth`, bcp.`active`, bcp.`position`, cl.`name`, cl.`link_rewrite`
    FROM `' . _DB_PREFIX_ . 'cms_category` bcp' .
                $join_shop . '
    INNER JOIN `' . _DB_PREFIX_ . 'cms_category_lang` cl
    ON (bcp.`id_cms_category` = cl.`id_cms_category`)
    WHERE cl.`id_lang` = ' . (int) $id_lang . '
    AND bcp.`id_parent` = ' . (int) $parent .
                $where_shop;

            $results = Db::getInstance()->executeS($sql);
            foreach ($results as $result) {
                $sub_categories = ClassBonmegamenuConstructor::getCMSCategories(true, $result['id_cms_category'], (int) $id_lang);
                if ($sub_categories && count($sub_categories) > 0) {
                    $result['sub_categories'] = $sub_categories;
                }
                $categories[] = $result;
            }

            return isset($categories) ? $categories : false;
        }
    }

    public static function getCMSPages($id_cms_category, $id_shop = false, $id_lang = false)
    {
        $id_shop = ($id_shop !== false) ? (int) $id_shop : (int) Context::getContext()->shop->id;
        $id_lang = $id_lang ? (int) $id_lang : (int) Context::getContext()->language->id;

        $where_shop = '';
        if (Tools::version_compare(_PS_VERSION_, '1.6.0.12', '>=') == true) {
            $where_shop = ' AND cl.`id_shop` = ' . (int) $id_shop;
        }

        $sql = 'SELECT c.`id_cms`, cl.`meta_title`, cl.`link_rewrite`
   FROM `' . _DB_PREFIX_ . 'cms` c
   INNER JOIN `' . _DB_PREFIX_ . 'cms_shop` cs
   ON (c.`id_cms` = cs.`id_cms`)
   INNER JOIN `' . _DB_PREFIX_ . 'cms_lang` cl
   ON (c.`id_cms` = cl.`id_cms`)
   WHERE c.`id_cms_category` = ' . (int) $id_cms_category . '
   AND cs.`id_shop` = ' . (int) $id_shop . '
   AND cl.`id_lang` = ' . (int) $id_lang .
            $where_shop . '
   AND c.`active` = 1
   ORDER BY `position`';

        return Db::getInstance()->executeS($sql);
    }

    public static function generateCategoriesOption($categories, $items_to_skip = null)
    {
        $html = '';

        foreach ($categories as $key => $category) {
            if (isset($items_to_skip) /*&& !in_array('CAT'.(int)$category['id_category'], $items_to_skip)*/) {
                $shop = (object) Shop::getShop((int) $category['id_shop']);
                $html .= '<option value="CAT' . (int) $category['id_category'] . '">'
                    . str_repeat('&nbsp;', '5' * (int) $category['level_depth']) . $category['name'] . ' (' . $shop->name . ')</option>';
            }

            if (isset($category['children']) && !empty($category['children'])) {
                $html .= ClassBonmegamenuConstructor::generateCategoriesOption($category['children'], $items_to_skip);
            }
        }

        return $html;
    }

    public static function customGetNestedCategories($shop_id, $root_category = null, $id_lang = false, $active = false, $groups = null, $use_shop_restriction = true, $sql_filter = '', $sql_sort = '', $sql_limit = '')
    {
        if (isset($root_category) && !Validate::isInt($root_category)) {
            exit(Tools::displayError());
        }

        if (!Validate::isBool($active)) {
            exit(Tools::displayError());
        }

        if (isset($groups) && Group::isFeatureActive() && !is_array($groups)) {
            $groups = (array) $groups;
        }

        $cache_id = 'Category::getNestedCategories_' . md5((int) $shop_id . (int) $root_category . (int) $id_lang . (int) $active . (int) $active
            . (isset($groups) && Group::isFeatureActive() ? implode('', $groups) : ''));

        if (!Cache::isStored($cache_id)) {
            $result =
            Db::getInstance()->executeS('SELECT c.*, cl.*
            FROM `' . _DB_PREFIX_ . 'category` c
            INNER JOIN `' . _DB_PREFIX_ . 'category_shop` category_shop ON (category_shop.`id_category` = c.`id_category` AND category_shop.`id_shop` = "' . (int) $shop_id . '")
            LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (c.`id_category` = cl.`id_category` AND cl.`id_shop` = "' . (int) $shop_id . '")
            WHERE 1 ' . $sql_filter . ' ' . ($id_lang ? 'AND cl.`id_lang` = ' . (int) $id_lang : '') . '
            ' . ($active ? ' AND (c.`active` = 1 OR c.`is_root_category` = 1)' : '') . '
            ' . (isset($groups) && Group::isFeatureActive() ? ' AND cg.`id_group` IN (' . implode(',', $groups) . ')' : '') . '
            ' . (!$id_lang || (isset($groups) && Group::isFeatureActive()) ? ' GROUP BY c.`id_category`' : '') . '
            ' . ($sql_sort != '' ? $sql_sort : ' ORDER BY c.`level_depth` ASC') . '
            ' . ($sql_sort == '' && $use_shop_restriction ? ', category_shop.`position` ASC' : '') . '
            ' . ($sql_limit != '' ? $sql_limit : ''));

            $categories = [];
            $buff = [];

            foreach ($result as $row) {
                $current = &$buff[$row['id_category']];
                $current = $row;

                if ($row['id_parent'] == 0) {
                    $categories[$row['id_category']] = &$current;
                } else {
                    $buff[$row['id_parent']]['children'][$row['id_category']] = &$current;
                }
            }

            Cache::store($cache_id, $categories);
        }

        return Cache::retrieve($cache_id);
    }

    /* Selected items */

    public static function makeMenuOption()
    {
        $module = new Bonmegamenu();
        $id_shop = (int) Shop::getContextShopID();
        $pattern = '/^([A-Z_]*)[0-9]+/';
        $menu_item = ClassBonmegamenuConstructor::getMenuItems((int)Tools::getValue('id_tab'));

        $id_lang = (int) (int)Context::getContext()->language->id;

        $html = '<select multiple="multiple" name="menu_items[]" id="menu_items" style="width: 300px; height: 160px;">';
        foreach ($menu_item as $item) {
            if (!$item) {
                continue;
            }

            preg_match($pattern, $item, $values);
            $id = (int) substr($item, strlen($values[1]), strlen($item));

            switch (substr($item, 0, strlen($values[1]))) {
                case 'CAT':
                    $category = new Category((int) $id, (int) $id_lang);
                    if (Validate::isLoadedObject($category)) {
                        $html .= '<option selected="selected" value="CAT' . $id . '">' . $category->name . '</option>' . PHP_EOL;
                    }
                    break;

                case 'PRD':
                    $product = new Product((int) $id, true, (int) $id_lang);
                    if (Validate::isLoadedObject($product)) {
                        $html .= '<option selected="selected" value="PRD' . $id . '">' . $product->name . '</option>' . PHP_EOL;
                    }
                    break;

                case 'CMS':
                    $cms = new CMS((int) $id, (int) $id_lang);
                    if (Validate::isLoadedObject($cms)) {
                        $html .= '<option selected="selected" value="CMS' . $id . '">' . $cms->meta_title . '</option>' . PHP_EOL;
                    }
                    break;

                case 'CMS_CAT':
                    $category = new CMSCategory((int) $id, (int) $id_lang);
                    if (Validate::isLoadedObject($category)) {
                        $html .= '<option selected="selected" value="CMS_CAT' . $id . '">' . $category->name . '</option>' . PHP_EOL;
                    }
                    break;

                // Case to handle the option to show all Manufacturers
                case 'ALLMAN':
                    $html .= '<option selected="selected" value="ALLMAN0">' . $module->l('All brands') . '</option>' . PHP_EOL;
                    break;

                case 'MAN':
                    $manufacturer = new Manufacturer((int) $id, (int) $id_lang);
                    if (Validate::isLoadedObject($manufacturer)) {
                        $html .= '<option selected="selected" value="MAN' . $id . '">' . $manufacturer->name . '</option>' . PHP_EOL;
                    }
                    break;

                // Case to handle the option to show all Suppliers
                case 'ALLSUP':
                    $html .= '<option selected="selected" value="ALLSUP0">' . $module->l('All suppliers') . '</option>' . PHP_EOL;
                    break;

                case 'SUP':
                    $supplier = new Supplier((int) $id, (int) $id_lang);
                    if (Validate::isLoadedObject($supplier)) {
                        $html .= '<option selected="selected" value="SUP' . $id . '">' . $supplier->name . '</option>' . PHP_EOL;
                    }
                    break;

                case 'LNK':
                    $linksClass = new ClassBonmegamenuLinks((int)Tools::getValue('id_tab'));
                    $link = $linksClass->getBonmegamenuLink($id);

                    if (count($link)) {
                        $html .= '<option selected="selected" value="LNK' . (int) $link[0]['id_sub'] . '">' . Tools::safeOutput($link[0]['label']) . '</option>';
                    }

                    break;

                case 'SHOP':
                    $shop = new Shop((int) $id);
                    if (Validate::isLoadedObject($shop)) {
                        $html .= '<option selected="selected" value="SHOP' . (int) $id . '">' . $shop->name . '</option>' . PHP_EOL;
                    }
                    break;
            }
        }

        return $html . '</select>';
    }


    public static function getCacheDirectory()
    {
        $dir = _PS_CACHE_DIR_ . 'bonmegamenu';

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        return $dir;
    }

    public static function makeNode(array $fields)
    {
        $defaults = [
            'type' => '',
            'label' => '',
            'url' => '',
            'children' => [],
            'open_in_new_window' => false,
            'image_urls' => [],
            'description' => '',
            'page_identifier' => null,
        ];

        return array_merge($defaults, $fields);
    }

    public static function getCurrentPageIdentifier()
    {
        $controllerName = Dispatcher::getInstance()->getController();
        if ($controllerName === 'cms' && ($id = Tools::getValue('id_cms'))) {
            return 'cms-page-' . $id;
        } elseif ($controllerName === 'category' && ($id = Tools::getValue('id_category'))) {
            return 'category-' . $id;
        } elseif ($controllerName === 'cms' && ($id = Tools::getValue('id_cms_category'))) {
            return 'cms-category-' . $id;
        } elseif ($controllerName === 'manufacturer' && ($id = Tools::getValue('id_manufacturer'))) {
            return 'manufacturer-' . $id;
        } elseif ($controllerName === 'manufacturer') {
            return 'manufacturers';
        } elseif ($controllerName === 'supplier' && ($id = Tools::getValue('id_supplier'))) {
            return 'supplier-' . $id;
        } elseif ($controllerName === 'supplier') {
            return 'suppliers';
        } elseif ($controllerName === 'product' && ($id = Tools::getValue('id_product'))) {
            return 'product-' . $id;
        } elseif ($controllerName === 'index') {
            return 'shop-' . Context::getContext()->shop->id;
        } else {
            $scheme = 'http';
            if (array_key_exists('REQUEST_SCHEME', $_SERVER)) {
                $scheme = $_SERVER['REQUEST_SCHEME'];
            }

            return "$scheme://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }
    }

    public static function mapTree(callable $cb, array $node, $depth = 0)
    {
        $node['children'] = array_map(function ($child) use ($cb, $depth) {
            return ClassBonmegamenuConstructor::mapTree($cb, $child, $depth + 1);
        }, $node['children']);

        return $cb($node, $depth);
    }


    public static function makeMenu($id_tab)
    {
        $module = new Bonmegamenu();

        $root_node = ClassBonmegamenuConstructor::makeNode([
            'label' => null,
            'type' => 'root',
            'children' => [],
        ]);
        
        $menu_items = ClassBonmegamenuConstructor::getMenuItems($id_tab);
        $pattern = '/^([A-Z_]*)[0-9]+/';
        $id_lang = (int) (int)Context::getContext()->language->id;
        $id_shop = (int) Shop::getContextShopID();

        foreach ($menu_items as $item) {
            if (!$item) {
                continue;
            }

            preg_match($pattern, $item, $value);
            $id = (int) substr($item, strlen($value[1]), strlen($item));

            switch (substr($item, 0, strlen($value[1]))) {
                case 'CAT':
                    $categories = ClassBonmegamenuConstructor::generateCategoriesMenu(
                        Category::getNestedCategories($id, $id_lang, false)
                    );
                    $root_node['children'] = array_merge($root_node['children'], $categories);
                    
                    break;

                case 'PRD':
                    $product = new Product((int) $id, true, (int) $id_lang);
                    if ($product->id) {
                        $root_node['children'][] = ClassBonmegamenuConstructor::makeNode([
                            'type' => 'product',
                            'page_identifier' => 'product-' . $product->id,
                            'label' => $product->name,
                            'url' => $product->getLink(),
                        ]);
                    }
                    break;

                case 'CMS':
                    $cms = CMS::getLinks((int) $id_lang, [$id]);
                    if (count($cms)) {
                        $root_node['children'][] = ClassBonmegamenuConstructor::makeNode([
                            'type' => 'cms-page',
                            'page_identifier' => 'cms-page-' . $id,
                            'label' => $cms[0]['meta_title'],
                            'url' => $cms[0]['link'],
                        ]);
                    }
                    break;

                case 'CMS_CAT':
                    $root_node['children'][] = ClassBonmegamenuConstructor::generateCMSCategoriesMenu((int) $id, (int) $id_lang);
                    break;

                // Case to handle the option to show all Manufacturers
                case 'ALLMAN':
                    $children = array_map(function ($manufacturer) use ($id_lang) {
                        return ClassBonmegamenuConstructor::makeNode([
                            'type' => 'manufacturer',
                            'page_identifier' => 'manufacturer-' . $manufacturer['id_manufacturer'],
                            'label' => $manufacturer['name'],
                            'url' => Context::getContext()->link->getManufacturerLink(
                                new Manufacturer($manufacturer['id_manufacturer'], $id_lang),
                                null,
                                $id_lang
                            ),
                        ]);
                    }, Manufacturer::getManufacturers());

                    $root_node['children'][] = ClassBonmegamenuConstructor::makeNode([
                        'type' => 'manufacturers',
                        'page_identifier' => 'manufacturers',
                        'label' => $module->l('All brands'),
                        'url' => Context::getContext()->link->getPageLink('manufacturer'),
                        'children' => $children,
                    ]);
                    break;

                case 'MAN':
                    $manufacturer = new Manufacturer($id, $id_lang);
                    if ($manufacturer->id) {
                        $root_node['children'][] = ClassBonmegamenuConstructor::makeNode([
                            'type' => 'manufacturer',
                            'page_identifier' => 'manufacturer-' . $manufacturer->id,
                            'label' => $manufacturer->name,
                            'url' => Context::getContext()->link->getManufacturerLink(
                                $manufacturer,
                                null,
                                $id_lang
                            ),
                        ]);
                    }
                    break;

                // Case to handle the option to show all Suppliers
                case 'ALLSUP':
                    $children = array_map(function ($supplier) use ($id_lang) {
                        return ClassBonmegamenuConstructor::makeNode([
                            'type' => 'supplier',
                            'page_identifier' => 'supplier-' . $supplier['id_supplier'],
                            'label' => $supplier['name'],
                            'url' => Context::getContext()->link->getSupplierLink(
                                new Supplier($supplier['id_supplier'], $id_lang),
                                null,
                                $id_lang
                            ),
                        ]);
                    }, Supplier::getSuppliers());

                    $root_node['children'][] = ClassBonmegamenuConstructor::makeNode([
                        'type' => 'suppliers',
                        'page_identifier' => 'suppliers',
                        'label' => $module->l('All suppliers'),
                        'url' => Context::getContext()->link->getPageLink('supplier'),
                        'children' => $children,
                    ]);
                    break;

                case 'SUP':
                    $supplier = new Supplier($id, $id_lang);
                    if ($supplier->id) {
                        $root_node['children'][] = ClassBonmegamenuConstructor::makeNode([
                            'type' => 'supplier',
                            'page_identifier' => 'supplier-' . $supplier->id,
                            'label' => $supplier->name,
                            'url' => Context::getContext()->link->getSupplierLink(
                                $supplier,
                                null,
                                $id_lang
                            ),
                        ]);
                    }
                    break;

                case 'SHOP':
                    $shop = new Shop((int) $id);
                    if (Validate::isLoadedObject($shop)) {
                        $root_node['children'][] = ClassBonmegamenuConstructor::makeNode([
                            'type' => 'shop',
                            'page_identifier' => 'shop-' . $id,
                            'label' => $shop->name,
                            'url' => $shop->getBaseURL(),
                        ]);
                    }
                    break;
                case 'LNK':
                    $link = ClassBonmegamenuLinks::getBonmegamenuLink($id);
                    if (!empty($link)) {
                        if (!isset($link[0]['label']) || ($link[0]['label'] == '')) {
                            $default_language = Configuration::get('PS_LANG_DEFAULT');
                        }
                        $root_node['children'][] = ClassBonmegamenuConstructor::makeNode([
                            'type' => 'link',
                            'page_identifier' => 'lnk-' . Tools::str2url($link[0]['label']),
                            'label' => $link[0]['label'],
                            'url' => $link[0]['link'],
                            'open_in_new_window' => $link[0]['new_window'],
                        ]);
                    }
                    break;
            }
        }

        return ClassBonmegamenuConstructor::mapTree(function ($node, $depth) {
            $node['depth'] = $depth;

            return $node;
        }, $root_node);
    }

    public static function generateCMSCategoriesMenu($id_cms_category, $id_lang)
    {
        $category = new CMSCategory($id_cms_category, $id_lang);

        $rawSubCategories = ClassBonmegamenuConstructor::getCMSCategories(false, $id_cms_category, $id_lang);
        $rawSubPages = ClassBonmegamenuConstructor::getCMSPages($id_cms_category);

        $subCategories = array_map(function ($category) use ($id_lang) {
            return ClassBonmegamenuConstructor::generateCMSCategoriesMenu($category['id_cms_category'], $id_lang);
        }, $rawSubCategories);

        $subPages = array_map(function ($page) use ($id_lang) {
            return ClassBonmegamenuConstructor::makeNode([
                'type' => 'cms-page',
                'page_identifier' => 'cms-page-' . $page['id_cms'],
                'label' => $page['meta_title'],
                'url' => Context::getContext()->link->getCMSLink(new CMS($page['id_cms'], $id_lang), null, null, $id_lang)]);
        }, $rawSubPages);

        $node = ClassBonmegamenuConstructor::makeNode([
            'type' => 'cms-category',
            'page_identifier' => 'cms-category-' . $id_cms_category,
            'label' => $category->name,
            'url' => $category->getLink(),
            'children' => array_merge($subCategories, $subPages),
            'description' => $category->description,
        ]);

        return $node;
    }


    public static function generateCategoriesMenu($categories, $is_children = 0)
    {
        $nodes = [];

        foreach ($categories as $key => $category) {
            $node = ClassBonmegamenuConstructor::makeNode([]);
            if ($category['level_depth'] > 1) {
                $cat = new Category($category['id_category']);
                $link = $cat->getLink();
                // Check if customer is set and check access
                if (Validate::isLoadedObject(Context::getContext()->customer) && !$cat->checkAccess(Context::getContext()->customer->id)) {
                    continue;
                }
            } else {
                $link = Context::getContext()->link->getPageLink('index');
            }

            $node['url'] = $link;
            $node['type'] = 'category';
            $node['page_identifier'] = 'category-' . $category['id_category'];
            $node['level_depth'] = $category['level_depth'];

            /* Whenever a category is not active we shouldnt display it to customer */
            if ((bool) $category['active'] === false) {
                continue;
            }
            $module = new Bonmegamenu();
 
            $current = $module->page_name == 'category' && (int) Tools::getValue('id_category') == (int) $category['id_category'];
            $node['current'] = $current;
            $node['label'] = $category['name'];
            $node['image_urls'] = [];
            $node['description'] = $category['description'];
            
            
            if (isset($category['children']) && !empty($category['children'])) {
                $node['children'] = ClassBonmegamenuConstructor::generateCategoriesMenu($category['children'], 1);
            }
            
            $imageFiles = null;
            
            if ($imageFiles === null) {
                $imageFiles = scandir(_PS_CAT_IMG_DIR_);
            }
            $pattern = '/^' . $category['id_category'] . '-category_default.jpg/i';

            foreach ($imageFiles as $file) {
                if (preg_match($pattern, $file) === 1) {
                    $image_url = Context::getContext()->link->getMediaLink(_THEME_CAT_DIR_ . $file);
                    $node['image_urls'][] = $image_url;
                }
            }

            $nodes[] = $node;
        }


        return $nodes;
    }

    public static function cacheFileRewrite($id_tab, $cache_key)
    {
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = Context::getContext()->shop->id;
        $module_name = 'bonmegamenu';
        $key = $cache_key . '_' . $id_lang . '_' . $id_shop . '_tab_' . $id_tab . '.json';

        $cacheDir = ClassBonmegamenuConstructor::getCacheDirectory();
        $cacheFile = $cacheDir . DIRECTORY_SEPARATOR . $key;
       

        $menu = json_decode(@file_get_contents($cacheFile), true);

        if (Tools::getValue('configure') == $module_name || !is_array($menu) || json_last_error() !== JSON_ERROR_NONE) {
            $menu = ClassBonmegamenuConstructor::makeMenu($id_tab);
            if (!is_dir($cacheDir)) {
                mkdir($cacheDir);
            }
            file_put_contents($cacheFile, json_encode($menu));
        }

        return $menu;
    }
}
