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
class FsCustomHtmlHelperList extends HelperList
{
    /**
     * @var FsCustomHtmlHelper
     */
    public $fshelper;

    /**
     * @var FsCustomHtml
     */
    public $module;

    protected $object_definition;

    protected $filter_fields;

    protected $tab_section;

    protected $currentIndexNoTab;

    protected $default_order_by;

    public function init($module, $title, $tab_section = null)
    {
        $this->module = $module;
        $this->fshelper = $this->module->fshelper;
        $this->title[] = $title;
        $this->simple_header = false;
        $this->show_toolbar = true;
        $this->imageType = 'jpg';
        $this->shopLinkType = '';
        $this->token = Tools::getAdminTokenLite('AdminModules');
        $this->currentIndex = AdminController::$currentIndex . '&configure=' . $this->module->name;
        $this->currentIndexNoTab = $this->currentIndex;
        if ($tab_section) {
            $this->currentIndex = $this->currentIndexNoTab . '&tab_section=' . $tab_section;
        }

        return $this;
    }

    public function getFilters()
    {
        $id = $this->table;
        $pagination_default = 50;
        $filter = [
            'page' => Tools::getValue('submitFilter' . $id, 1),
            'limit' => Tools::getValue($id . '_pagination', $pagination_default),
            'order_by' => Tools::getValue($id . 'Orderby', $this->default_order_by),
            'order_way' => Tools::strtoupper(Tools::getValue($id . 'Orderway', 'ASC')),
        ];

        if (Tools::isSubmit('submitFilter' . $id)) {
            if (Tools::isSubmit('submitReset' . $id)) {
                // clear
                foreach ($this->filter_fields as $filter_field) {
                    $filter[$filter_field] = '';
                }

                $filter['page'] = 1;
                $filter['limit'] = Tools::getValue($id . '_pagination', $pagination_default);

                foreach ($this->filter_fields as $filter_field) {
                    $this->context->cookie->{$id . 'Filter_' . $filter_field} = $filter[$filter_field];
                }

                $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab());
            } else {
                // Update
                foreach ($this->filter_fields as $filter_field) {
                    $filter[$filter_field] = Tools::getValue($id . 'Filter_' . $filter_field, '');
                }

                foreach ($this->filter_fields as $filter_field) {
                    $this->context->cookie->{$id . 'Filter_' . $filter_field} = $filter[$filter_field];
                }

                $filter['order_by'] = $this->context->cookie->{$id . 'Orderby'};
                $filter['order_way'] = $this->context->cookie->{$id . 'Orderway'};
            }
        } else {
            // retrieve
            foreach ($this->filter_fields as $filter_field) {
                if (isset($this->context->cookie->{$id . 'Filter_' . $filter_field}) &&
                    $this->context->cookie->{$id . 'Filter_' . $filter_field}) {
                    $filter[$filter_field] = $this->context->cookie->{$id . 'Filter_' . $filter_field};
                }
            }

            $this->context->cookie->{$id . 'Orderby'} = $filter['order_by'];
            $this->context->cookie->{$id . 'Orderway'} = $filter['order_way'];
        }

        if (!$filter['page']) {
            $filter['page'] = 1;
        }

        $this->orderBy = $filter['order_by'];
        $this->orderWay = $filter['order_way'];

        return $filter;
    }

    public function setFilterIdLang($filter_id_lang)
    {
        $this->filter_id_lang = $filter_id_lang;

        return $this;
    }

    public function setObjectDefinition($object_definition)
    {
        $this->object_definition = $object_definition;
        $this->setIdentifier($this->object_definition['primary']);
        $this->setTable($this->object_definition['table']);
        $this->addToolbarButton('new', [
            'href' => $this->fshelper->getAdminModuleUrlTab($this->getTabSection()) . '&add' . $this->table,
            'desc' => $this->module->l('Add new'),
        ]);

        return $this;
    }

    public function setFilterFields($filter_fields)
    {
        $this->filter_fields = $filter_fields;

        return $this;
    }

    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function setTitle($title)
    {
        $this->title[] = $title;

        return $this;
    }

    public function setTabSection($tab_section)
    {
        $this->tab_section = $tab_section;
        $this->currentIndex = $this->currentIndexNoTab . '&tab_section=' . $tab_section;

        return $this;
    }

    public function getTabSection()
    {
        return $this->tab_section;
    }

    public function setActions($actions)
    {
        $this->actions = $actions;

        return $this;
    }

    public function addToolbarButton($name, $params)
    {
        $this->toolbar_btn[$name] = $params;

        return $this;
    }

    public function setDefaultOrderBy($order_by)
    {
        $this->default_order_by = $order_by;

        return $this;
    }

    public function setListTotal($list_total)
    {
        $this->listTotal = $list_total;

        return $this;
    }

    public function displayCloneLink($token = null, $id = 0, $name = null)
    {
        $duplicate = $this->currentIndex . '&' . $this->identifier . '=' . $id . '&clone' . $this->table;

        $this->fshelper->smartyAssign([
            'href' => $duplicate . '&token=' . ($token != null ? $token : $this->token),
            'action' => $this->module->l('Duplicate'),
            'confirm_duplication' => $this->module->l('Are you sure you want to duplicate?'),
            'fsch_name' => $name,
        ]);

        return $this->fshelper->smartyFetch('admin/list_action_duplicate.tpl');
    }
}
