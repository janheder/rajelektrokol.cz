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
abstract class FsCustomHtmlHelperFormAbstract extends HelperForm
{
    abstract public function postProcess();

    /**
     * @var FsCustomHtmlHelper
     */
    public $fshelper;

    /**
     * @var FsCustomHtml
     */
    public $module;

    protected $object_definition;

    protected $enable_multishop = false;

    protected $tab_section;

    protected static $smarty_registered = false;

    public function __construct()
    {
        parent::__construct();

        $context = Context::getContext();
        if (!self::$smarty_registered) {
            smartyRegisterFunction(
                $context->smarty,
                'modifier',
                'fschRemoveClass',
                [$this, 'removeClass'],
                false
            );
            smartyRegisterFunction(
                $context->smarty,
                'modifier',
                'fschOnLangChange',
                [$this, 'onLangChange'],
                false
            );
            self::$smarty_registered = true;
        }
    }

    public function validate()
    {
        $valid = true;
        if ($this->fields_value) {
            foreach ($this->fields_value as $field_name => $field_value) {
                $field_info = $this->getFieldInfo($field_name);
                if (isset($field_info['validate']) && is_callable([
                        'FsCustomHtmlValidate',
                        $field_info['validate'],
                    ])) {
                    if ($this->isFieldMultilang($field_name)) {
                        foreach (Language::getIDs() as $id_lang) {
                            if (isset($field_info['required']) && $field_info['required']) {
                                if (!is_numeric($field_value[$id_lang]) && !(bool) $field_value[$id_lang]) {
                                    $valid = false;

                                    $error_message = $field_info['label'] . ' (' . Language::getIsoById($id_lang) . ') ';
                                    $this->fshelper->addErrorMessage(
                                        $error_message . $this->module->l('Please fill the required field!')
                                    );
                                }
                            }

                            if (!call_user_func(
                                ['FsCustomHtmlValidate', $field_info['validate']],
                                $field_value[$id_lang]
                            )) {
                                $valid = false;

                                $error_message = $field_info['label'] . ' (' . Language::getIsoById($id_lang) . ') ';
                                if (isset($field_info['error_message']) && $field_info['error_message']) {
                                    $this->fshelper->addErrorMessage($error_message . $field_info['error_message']);
                                } else {
                                    $this->fshelper->addErrorMessage($error_message . $this->module->l('Invalid value!'));
                                }
                            }
                        }
                    } else {
                        if (isset($field_info['required']) && $field_info['required']) {
                            if (!is_numeric($field_value) && !(bool) $field_value) {
                                $valid = false;

                                $error_message = $field_info['label'] . ' ';
                                $this->fshelper->addErrorMessage(
                                    $error_message . $this->module->l('Please fill the required field!')
                                );
                            }
                        }

                        if (!call_user_func(['FsCustomHtmlValidate', $field_info['validate']], $field_value)) {
                            $valid = false;

                            $error_message = $field_info['label'] . ' ';
                            if (isset($field_info['error_message']) && $field_info['error_message']) {
                                $this->fshelper->addErrorMessage($error_message . $field_info['error_message']);
                            } else {
                                $this->fshelper->addErrorMessage($error_message . $this->module->l('Invalid value!'));
                            }
                        }
                    }
                }
            }
        }

        return $valid;
    }

    // ############### SETTER ################

    public function init($module)
    {
        $this->module = $module;
        $this->fshelper = $module->fshelper;
        $this->name_controller = $this->module->name;
        $this->token = Tools::getAdminTokenLite('AdminModules');
        $this->languages = $this->getLanguagesForForm();
        $this->currentIndex = AdminController::$currentIndex . '&configure=' . $this->module->name;
        $this->default_form_language = (int) Configuration::get('PS_LANG_DEFAULT');
        $this->allow_employee_form_lang = (int) Configuration::get('PS_LANG_DEFAULT');
        $this->show_toolbar = false;

        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;

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
        $this->submit_action = 'submit_' . $identifier;

        return $this;
    }

    public function setSubmitAction($submit_action)
    {
        $this->submit_action = $submit_action;

        return $this;
    }

    public function setTabSection($tab_section)
    {
        $this->tab_section = $tab_section;

        return $this;
    }

    public function setFieldsValue($fields_value)
    {
        $this->fields_value = $fields_value;

        $data_transfer = $this->fshelper->getTransferData();
        if ($data_transfer) {
            $this->fields_value = array_merge($this->fields_value, $data_transfer);
        }

        return $this;
    }

    public function setObjectDefinition($object_definition)
    {
        $this->object_definition = $object_definition;
        $this->setIdentifier($this->object_definition['primary']);
        $this->setSubmitAction('save' . $this->object_definition['table']);
        $this->setTable($this->object_definition['table']);

        return $this;
    }

    public function setForms($forms)
    {
        $this->fields_form = $forms;

        return $this;
    }

    // ############### GETTER ################

    public function getTabSection()
    {
        return $this->tab_section;
    }

    public function getFieldInfo($field_name)
    {
        foreach (array_keys($this->fields_form) as $id_fieldset) {
            foreach ($this->fields_form[$id_fieldset]['form']['input'] as $field) {
                if ($field_name == $field['name']) {
                    return $field;
                }
            }
        }

        return false;
    }

    public function isFieldMultilang($field_name)
    {
        $field = $this->getFieldInfo($field_name);
        if (isset($field['lang']) && $field['lang']) {
            return true;
        }

        return false;
    }

    public function getFieldsValue()
    {
        return $this->fields_value;
    }

    // ############### RENDERING ################

    public function renderForm()
    {
        return $this->generateForm($this->fields_form);
    }

    public function generateForm($fields_form)
    {
        foreach ($fields_form as $id_fieldset => $fieldset) {
            if (isset($fieldset['form']['save_button']) && $fieldset['form']['save_button']) {
                $fields_form[$id_fieldset]['form']['submit'] = ['title' => $this->module->l('Save')];
            }

            if (isset($fieldset['form']['back_button']) && $fieldset['form']['back_button']) {
                $fields_form[$id_fieldset]['form']['buttons'][] = [
                    'title' => '<i class="process-icon-back"></i>' . $this->module->l('Back'),
                    'href' => $this->fshelper->getAdminModuleUrlTab($this->getTabSection()),
                ];
            }

            if (isset($fieldset['form']['save_and_stay_button']) && $fieldset['form']['save_and_stay_button']) {
                $fields_form[$id_fieldset]['form']['buttons'][] = [
                    'type' => 'submit',
                    'icon' => 'process-icon-save',
                    'class' => 'pull-right',
                    'name' => 'save_and_stay' . $this->object_definition['table'],
                    'title' => $this->module->l('Save and Stay'),
                ];
            }
        }

        return parent::generateForm($fields_form);
    }

    public function generate()
    {
        $this->fshelper->addJS('form.js');

        foreach ($this->fields_form as &$fieldset) {
            if (isset($fieldset['form']['input'])) {
                foreach ($fieldset['form']['input'] as &$params) {
                    switch ($params['type']) {
                        case 'select':
                            if (isset($params['select2']) && $params['select2']) {
                                $this->fshelper->addCSS('select2.min.css');
                                $this->fshelper->addJS('select2.full.min.js');
                                $this->fshelper->addJS('select2.js');
                            }
                            break;

                        case 'textarea':
                            if (isset($params['editors']) && $params['editors']) {
                                $this->fshelper->addCSS('codemirror/codemirror.css');
                                $this->fshelper->addCSS('codemirror/material.css');
                                $this->fshelper->addCSS('codemirror/addon/show-hint.css');
                                $this->fshelper->addJS('codemirror/codemirror.js');
                                $this->fshelper->addJS('codemirror/addon/selection/active-line.js');
                                $this->fshelper->addJS('codemirror/addon/edit/matchbrackets.js');
                                $this->fshelper->addJS('codemirror/addon/fold/xml-fold.js');
                                $this->fshelper->addJS('codemirror/addon/edit/matchtags.js');
                                $this->fshelper->addJS('codemirror/addon/hint/show-hint.js');
                                $this->fshelper->addJS('codemirror/addon/hint/xml-hint.js');
                                $this->fshelper->addJS('codemirror/addon/hint/html-hint.js');
                                $this->fshelper->addJS('codemirror/addon/hint/css-hint.js');
                                $this->fshelper->addJS('codemirror/addon/hint/javascript-hint.js');
                                $this->fshelper->addJS('codemirror/mode/htmlmixed.js');
                                $this->fshelper->addJS('codemirror/mode/javascript.js');
                                $this->fshelper->addJS('codemirror/mode/css.js');
                                $this->fshelper->addJS('codemirror/mode/xml.js');
                                $this->fshelper->addJS('codemirror/mode/smartymixed.js');
                                $this->fshelper->addJS('codemirror/mode/smarty.js');

                                $params['selector'] = '#' . $params['name'];
                                if (isset($params['lang']) && $params['lang']) {
                                    $ids = [];
                                    foreach ($this->languages as $lang) {
                                        $ids[] = '#' . $params['name'] . '_' . $lang['id_lang'];
                                    }
                                    $params['selector'] = implode(', ', $ids);
                                }
                            }
                            break;
                    }
                }
            }
        }

        return parent::generate();
    }

    // ############### SAVE ################

    public function isSubmit($action)
    {
        if ($this->fshelper->isSubmit($action . $this->object_definition['table'])) {
            return true;
        }
        if ($action == 'save') {
            if ($this->fshelper->isSubmit('save_and_stay' . $this->object_definition['table'])) {
                return true;
            }
        }

        return false;
    }

    public function isSubmitted()
    {
        if ($this->fshelper->isSubmit($this->submit_action)) {
            return true;
        }

        return false;
    }

    public function isStay()
    {
        if ($this->fshelper->isSubmit('save_and_stay' . $this->object_definition['table'])) {
            return true;
        }

        return false;
    }

    // ############### OTHER ################

    public function getLanguagesForForm()
    {
        return $this->fshelper->getLanguagesForForm();
    }

    public function removeClass($html, $class_name)
    {
        return str_replace($class_name, '', $html);
    }

    public function onLangChange($html, $extra_action)
    {
        foreach ($this->languages as $lang) {
            $action = 'javascript:hideOtherLanguage(' . $lang['id_lang'] . ');';

            $html = str_replace($action, $action . $extra_action, $html);
        }

        return $html;
    }
}
