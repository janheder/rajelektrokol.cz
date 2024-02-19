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
class AdminFsCustomHtmlFilterController extends ModuleAdminController
{
    /**
     * @var FsCustomHtmlHelper
     */
    public $fshelper;

    /**
     * @var FsCustomHtml
     */
    public $module;

    public function __construct()
    {
        parent::__construct();
        $this->fshelper = $this->module->fshelper;
    }

    public function ajaxProcessSearch()
    {
        $this->json = true;
        $this->status = 'ok';

        if (!$this->hasAccess('view')) {
            $this->errors[] = $this->module->l('Access denied');
        }

        $q = Tools::getValue('q');
        $page = Tools::getValue('page', 1);
        $limit = Tools::getValue('limit', 10);
        $filter_form_init_function = Tools::getValue('filter_form_init_function', false);
        if (!count($this->errors) && !$q) {
            $this->errors[] = $this->module->l('Please type at least 1 character');
        }

        if (!count($this->errors) && $filter_form_init_function) {
            $content_type = Tools::getValue('content_type');
            $helper = call_user_func([$this->module, $filter_form_init_function]);
            $this->content = $helper->autocompleteSearch($content_type, $q, $page, $limit);
        }
    }

    public function ajaxProcessGenerate()
    {
        $this->json = true;
        $this->status = 'ok';

        if (!$this->hasAccess('view')) {
            $this->errors[] = $this->module->l('Access denied');
        }

        $filter_form_init_function = Tools::getValue('filter_form_init_function', false);
        $input_name = Tools::getValue('input_name', false);
        if (!count($this->errors) && $filter_form_init_function && $input_name) {
            $filter_type = Tools::getValue('filter_type', 'page_type');
            $helper = call_user_func([$this->module, $filter_form_init_function]);
            $this->content = $helper->generateFilterHtml($input_name, $filter_type);
        }
    }

    public function ajaxProcessTemplates()
    {
        $this->json = true;
        $this->status = 'ok';

        if (!$this->hasAccess('view')) {
            $this->errors[] = $this->module->l('Access denied');
        }

        $result = [];

        $templates = FsCustomHtmlTemplateModel::getListContent([
            'order_by' => 'title',
            'order_way' => 'ASC',
        ]);
        if ($templates) {
            foreach ($templates as $template) {
                $result[] = [
                    'title' => $template['title'],
                    'description' => '',
                    'content' => str_replace(
                        ['{title}', '{content}'],
                        [$this->module->l('Dummy title'), $this->module->l('Dummy content')],
                        $template['template']
                    ),
                ];
            }
        }

        exit(json_encode($result));
    }

    private function hasAccess($type)
    {
        $tabAccess = Profile::getProfileAccesses(Context::getContext()->employee->id_profile, 'class_name');
        if (isset($tabAccess['AdminFsCustomHtmlFilter'][$type])) {
            if ($tabAccess['AdminFsCustomHtmlFilter'][$type] === '1') {
                return true;
            }
        }

        return false;
    }

    public function displayAjax()
    {
        $response = [
            'status' => $this->status,
            'error' => $this->errors,
            'warnings' => $this->warnings,
            'informations' => $this->informations,
            'confirmations' => $this->confirmations,
            'content' => $this->content,
        ];

        header('Content-type: application/json; charset=utf-8');
        exit(json_encode($response));
    }
}
