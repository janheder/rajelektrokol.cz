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
class FsCustomHtmlHookModel extends ObjectModel
{
    /** @var int */
    public $id;

    /** @var string */
    public $title;

    /** @var string */
    public $name;

    /** @var string */
    public $date_add;

    /** @var string */
    public $date_upd;

    public static $sql_tables = [
        [
            'name' => 'fsch_hook',
            'columns' => [
                [
                    'name' => 'id_fsch_hook',
                    'params' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
                    'is_primary_key' => true,
                ],
                [
                    'name' => 'title',
                    'params' => 'varchar(100) NOT NULL',
                ],
                [
                    'name' => 'name',
                    'params' => 'varchar(100) NOT NULL',
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
        'table' => 'fsch_hook',
        'primary' => 'id_fsch_hook',
        'fields' => [
            'title' => ['type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true],
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isHookName', 'required' => true],
            'date_add' => ['type' => self::TYPE_DATE, 'validate' => 'isDateFormat'],
            'date_upd' => ['type' => self::TYPE_DATE, 'validate' => 'isDateFormat'],
        ],
    ];

    public static $filter_fields = [
        'id_fsch_hook',
        'title',
        'name',
    ];

    public function isNew()
    {
        return !Validate::isLoadedObject($this);
    }

    public function toArray()
    {
        $array = [
            'id_fsch_hook' => $this->id,
            'title' => $this->title,
            'name' => $this->name,
        ];

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

    public static function getListContent($filter = [])
    {
        $where = [];
        if (isset($filter['id_fsch_hook']) && $filter['id_fsch_hook'] != '') {
            $where[] = 'c.`id_fsch_hook` = \'' . pSQL($filter['id_fsch_hook']) . '\'';
        }

        if (isset($filter['title']) && $filter['title'] != '') {
            $where[] = 'c.`title` LIKE \'%' . pSQL($filter['title']) . '%\'';
        }

        if (isset($filter['name']) && $filter['name'] != '') {
            $where[] = 'c.`name` LIKE \'%' . pSQL($filter['name']) . '%\'';
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

            $filter['order_by'] = 'c.`' . $filter['order_by'] . '`';
        }

        // Order way sql protection
        if (isset($filter['order_way'])) {
            $filter['order_way'] = Tools::strtoupper($filter['order_way']);
            if (!in_array($filter['order_way'], ['ASC', 'DESC'])) {
                $filter['order_way'] = 'ASC';
            }
        }

        $sql = 'SELECT * FROM `' . _DB_PREFIX_ . pSQL(self::$definition['table']) . '` c ' . $where;

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
        if (isset($filter['id_fsch_hook']) && $filter['id_fsch_hook'] != '') {
            $where[] = 'c.`id_fsch_hook` = \'' . pSQL($filter['id_fsch_hook']) . '\'';
        }

        if (isset($filter['title']) && $filter['title'] != '') {
            $where[] = 'c.`title` LIKE \'%' . pSQL($filter['title']) . '%\'';
        }

        if (isset($filter['name']) && $filter['name'] != '') {
            $where[] = 'c.`name` LIKE \'%' . pSQL($filter['name']) . '%\'';
        }

        if ($where) {
            $where = ' WHERE ' . implode(' AND ', $where);
        } else {
            $where = '';
        }

        $sql = 'SELECT COUNT(*) as `count` FROM `' . _DB_PREFIX_ . pSQL(self::$definition['table']) . '` c ' . $where;

        return Db::getInstance()->getValue($sql);
    }
}
