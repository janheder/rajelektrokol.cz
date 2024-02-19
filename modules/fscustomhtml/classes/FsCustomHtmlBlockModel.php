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
class FsCustomHtmlBlockModel extends ObjectModel
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $hook;

    /** @var bool */
    public $active = true;

    /** @var int */
    public $position;

    /** @var string */
    public $content_editor;

    /** @var int */
    public $id_fsch_template = 0;

    /** @var string */
    public $date_add;

    /** @var string */
    public $date_upd;

    /** @var string */
    public $title;

    /** @var string */
    public $content;

    public static $sql_tables = [
        [
            'name' => 'fsch_block',
            'columns' => [
                [
                    'name' => 'id_fsch_block',
                    'params' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
                    'is_primary_key' => true,
                ],
                [
                    'name' => 'name',
                    'params' => 'varchar(100) NOT NULL',
                ],
                [
                    'name' => 'hook',
                    'params' => 'varchar(100) NOT NULL',
                    'is_key' => true,
                ],
                [
                    'name' => 'position',
                    'params' => 'int(10) unsigned NOT NULL DEFAULT \'0\'',
                    'is_key' => true,
                ],
                [
                    'name' => 'active',
                    'params' => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\'',
                    'is_key' => true,
                ],
                [
                    'name' => 'content_editor',
                    'params' => 'varchar(100) NOT NULL',
                ],
                [
                    'name' => 'id_fsch_template',
                    'params' => 'int(10) unsigned NOT NULL',
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
        [
            'name' => 'fsch_block_lang',
            'columns' => [
                [
                    'name' => 'id_fsch_block',
                    'params' => 'int(10) unsigned NOT NULL',
                    'is_primary_key' => true,
                ],
                [
                    'name' => 'id_lang',
                    'params' => 'int(10) unsigned NOT NULL',
                    'is_primary_key' => true,
                ],
                [
                    'name' => 'title',
                    'params' => 'varchar(255) NOT NULL',
                ],
                [
                    'name' => 'content',
                    'params' => 'text NOT NULL',
                ],
            ],
        ],
        [
            'name' => 'fsch_block_shop',
            'columns' => [
                [
                    'name' => 'id_fsch_block',
                    'params' => 'int(10) unsigned NOT NULL',
                    'is_primary_key' => true,
                ],
                [
                    'name' => 'id_shop',
                    'params' => 'int(10) unsigned NOT NULL',
                    'is_primary_key' => true,
                    'is_key' => true,
                ],
            ],
        ],
    ];

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'fsch_block',
        'primary' => 'id_fsch_block',
        'multilang' => true,
        'fields' => [
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true],
            'hook' => ['type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true],
            'position' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true],
            'active' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool'],
            'content_editor' => ['type' => self::TYPE_STRING, 'validate' => 'isGenericName'],
            'id_fsch_template' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'],
            'date_add' => ['type' => self::TYPE_DATE, 'validate' => 'isDateFormat'],
            'date_upd' => ['type' => self::TYPE_DATE, 'validate' => 'isDateFormat'],

            'title' => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isAnything'],
            'content' => ['type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isAnything'],
        ],
    ];

    public static $filter_fields = [
        'id_lang',
        'id_fsch_block',
        'name',
        'hook',
        'position',
        'active',
    ];

    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        Shop::addTableAssociation(self::$definition['table'], ['type' => 'shop']);
        parent::__construct($id, $id_lang, $id_shop);
    }

    public function isNew()
    {
        return !Validate::isLoadedObject($this);
    }

    public function toArray()
    {
        $array = [
            'id_fsch_block' => $this->id,
            'name' => $this->name,
            'hook' => $this->hook,
            'position' => $this->position,
            'active' => $this->active,
            'content_editor' => $this->content_editor,
            'id_fsch_template' => $this->id_fsch_template,

            'title' => $this->title,
            'content' => $this->content,
        ];

        $filter_helper = new FsCustomHtmlBlockFilterModel();
        $array['filter'] = $filter_helper->getFiltersForForm($this->id);

        return $array;
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

        return $this;
    }

    public static function getListContent($id_lang, $filter = [])
    {
        $where = [];
        $where[] = 'l.`id_lang` = \'' . pSQL($id_lang) . '\'';

        if (isset($filter['id_fsch_block']) && $filter['id_fsch_block'] != '') {
            $where[] = 'c.`id_fsch_block` = \'' . pSQL($filter['id_fsch_block']) . '\'';
        }

        if (isset($filter['name']) && $filter['name'] != '') {
            $where[] = 'c.`name` LIKE \'%' . pSQL($filter['name']) . '%\'';
        }

        if (isset($filter['hook']) && $filter['hook'] != '') {
            $where[] = 'c.`hook` = \'' . pSQL($filter['hook']) . '\'';
        }

        if (isset($filter['position']) && $filter['position'] != '') {
            $where[] = 'c.`position` = \'' . pSQL($filter['position']) . '\'';
        }

        if (isset($filter['active']) && $filter['active'] != '') {
            $where[] = 'c.`active` = \'' . pSQL($filter['active']) . '\'';
        }

        if ($where) {
            $where = ' WHERE ' . implode(' AND ', $where);
        } else {
            $where = '';
        }

        // Order by sql protection
        if (isset($filter['order_by'])) {
            if (!in_array($filter['order_by'], self::$filter_fields)) {
                $filter['order_by'] = self::$definition['primary'];
            }

            if ($filter['order_by'] == 'position') {
                $filter['order_by'] = 'c.`hook`, c.`' . $filter['order_by'] . '`';
            } else {
                $filter['order_by'] = 'c.`' . $filter['order_by'] . '`';
            }
        }

        // Order way sql protection
        if (isset($filter['order_way'])) {
            $filter['order_way'] = Tools::strtoupper($filter['order_way']);
            if (!in_array($filter['order_way'], ['ASC', 'DESC'])) {
                $filter['order_way'] = 'ASC';
            }
        }

        $sql = 'SELECT * FROM `' . _DB_PREFIX_ . pSQL(self::$definition['table']) . '` c ';
        $sql .= 'LEFT JOIN `' . _DB_PREFIX_ . pSQL(self::$definition['table']) . '_lang` l ';
        $sql .= 'ON (c.`' . pSQL(self::$definition['primary']) . '` = l.`' . pSQL(self::$definition['primary']) . '`)';
        if (isset($filter['id_shop'])) {
            $sql .= ' INNER JOIN `' . _DB_PREFIX_ . pSQL(self::$definition['table']) . '_shop` s';
            $sql .= ' ON (s.`id_' . pSQL(self::$definition['table']) . '` = c.`id_' . pSQL(self::$definition['table']) . '`';
            $sql .= ' AND s.`id_shop` = ' . (int) $filter['id_shop'] . ')';
        }
        $sql .= $where;

        if (isset($filter['order_by']) && isset($filter['order_way'])) {
            $sql .= ' ORDER BY ' . $filter['order_by'] . ' ' . $filter['order_way'];
        }
        if (isset($filter['page']) && isset($filter['limit'])) {
            $sql .= ' LIMIT ' . (int) (($filter['page'] - 1) * $filter['limit']) . ', ' . (int) $filter['limit'];
        }

        return Db::getInstance()->executeS($sql);
    }

    public static function getListCount($filter)
    {
        $where = [];
        if (isset($filter['id_fsch_block']) && $filter['id_fsch_block'] != '') {
            $where[] = 'c.`id_fsch_block` = \'' . pSQL($filter['id_fsch_block']) . '\'';
        }

        if (isset($filter['name']) && $filter['name'] != '') {
            $where[] = 'c.`name` LIKE \'%' . pSQL($filter['name']) . '%\'';
        }

        if (isset($filter['hook']) && $filter['hook'] != '') {
            $where[] = 'c.`hook` = \'' . pSQL($filter['hook']) . '\'';
        }

        if (isset($filter['position']) && $filter['position'] != '') {
            $where[] = 'c.`position` = \'' . pSQL($filter['position']) . '\'';
        }

        if (isset($filter['active']) && $filter['active'] != '') {
            $where[] = 'c.`active` = \'' . pSQL($filter['active']) . '\'';
        }

        if ($where) {
            $where = ' WHERE ' . implode(' AND ', $where);
        } else {
            $where = '';
        }

        $sql = 'SELECT COUNT(*) as `count` FROM `' . _DB_PREFIX_ . pSQL(self::$definition['table']) . '` c ';
        $sql .= 'LEFT JOIN `' . _DB_PREFIX_ . pSQL(self::$definition['table']) . '_lang` l ';
        $sql .= 'ON (c.`' . pSQL(self::$definition['primary']) . '` = ';
        $sql .= 'l.`' . pSQL(self::$definition['primary']) . '`)' . $where;
        $sql .= 'GROUP BY `id_lang` ORDER BY count DESC';

        return Db::getInstance()->getValue($sql);
    }

    public function duplicate($name_extra = null)
    {
        $data = $this->toArray();
        $id_current = $data[self::$definition['primary']];
        unset($data[self::$definition['primary']]);
        if ($name_extra) {
            $data['name'] .= ' - ' . $name_extra;
        }

        // Base Object
        $cloned = new self();
        $cloned->fill($data);
        $cloned->save();

        // Filters
        $filter_helper = new FsCustomHtmlBlockFilterModel();
        $filters_raw = $filter_helper->getFilters($id_current);
        $filters = [];
        if ($filters_raw) {
            foreach ($filters_raw as $filter) {
                unset($filter['id_filter']);
                unset($filter['id_content']);
                unset($filter['date_add']);
                unset($filter['date_upd']);
                $filters[$filter['id_filter_group']][] = $filter;
            }
        }
        $filter_helper->bulkSave($cloned->id, $filters);

        // Shops
        $sql = 'SELECT * FROM `' . _DB_PREFIX_ . pSQL(self::$definition['table']) . '_shop` s ';
        $sql .= 'WHERE s.`' . pSQL(self::$definition['primary']) . '` =  ' . (int) $id_current;
        $shops = Db::getInstance()->executeS($sql);
        foreach ($shops as $shop) {
            $shop[self::$definition['primary']] = $cloned->id;
            Db::getInstance()->insert(self::$definition['table'] . '_shop', $shop, false, true, Db::INSERT_IGNORE);
        }
    }
}
