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
class FsCustomHtmlHelperConfig extends FsCustomHtmlHelperFormAbstract
{
    public function __construct()
    {
        parent::__construct();

        if (Shop::isFeatureActive()) {
            if (Shop::getContext() != Shop::CONTEXT_ALL) {
                $this->enable_multishop = true;
            }
        }
    }

    public function getAutoSaveFieldsName()
    {
        $names = [];
        foreach (array_keys($this->fields_form) as $id_fieldset) {
            foreach ($this->fields_form[$id_fieldset]['form']['input'] as $field) {
                if (!(isset($field['auto_save']) && $field['auto_save'])) {
                    continue;
                }

                if ($this->enable_multishop) {
                    if (!(isset($field['disable_multistore']) && $field['disable_multistore'])) {
                        $names[] = $field['name'];
                    }
                } else {
                    $names[] = $field['name'];
                }
            }
        }

        return array_unique($names);
    }

    public function generateForm($fields_form)
    {
        foreach (array_keys($fields_form) as $id_fieldset) {
            // Add a save button to every panel
            $fields_form[$id_fieldset]['form']['submit'] = ['title' => $this->module->l('Save')];

            if ($this->enable_multishop) {
                $fields_form[$id_fieldset]['form']['legend']['show_multishop_header'] = true;
            }

            // Loadup width default values
            foreach ($fields_form[$id_fieldset]['form']['input'] as $input) {
                if (isset($input['default_value'])) {
                    $field_name = $input['name'];
                    $field_value = $this->fields_value[$field_name];
                    if (is_array($field_value)) {
                        foreach ($field_value as $id_lang => $value) {
                            if (!$value) {
                                $field_value[$id_lang] = $input['default_value'];
                            }
                        }
                    } else {
                        if (!$field_value) {
                            $field_value = $input['default_value'];
                        }
                    }

                    $this->fields_value[$field_name] = $field_value;
                }
            }
        }

        return parent::generateForm($fields_form);
    }

    public function generate()
    {
        foreach ($this->fields_form as &$fieldset) {
            if (isset($fieldset['form']['input'])) {
                foreach ($fieldset['form']['input'] as $key => &$params) {
                    $label = '';
                    if (isset($params['label'])) {
                        $label = $params['label'];
                    }

                    if ($this->enable_multishop) {
                        $disable_multistore = false;
                        if (isset($params['disable_multistore']) && $params['disable_multistore']) {
                            $disable_multistore = true;
                        }

                        if (!$disable_multistore) {
                            $is_disabled = false;
                            if (!Configuration::isOverridenByCurrentContext($params['name'])) {
                                $is_disabled = true;
                            }

                            $params['disabled'] = $is_disabled;
                            $params['multishop_group_prefix'] = $this->identifier;
                            $this->module->fshelper->smartyAssign(['params' => $params]);
                            $params['label'] = $this->module->fshelper->smartyFetch(
                                'admin/multishop_form_extension.tpl'
                            ) . ' ' . $label;

                            $params['form_group_class'] = ' conf_id_' . $params['name'];
                        } else {
                            unset($fieldset['form']['input'][$key]);
                        }
                    }
                }
            }
        }

        return parent::generate();
    }

    public function postProcess()
    {
        $multishop_override_enabled = Tools::getValue($this->identifier . '_multishop_override_enabled', []);
        $this->fields_value = [];

        $rendered_fields = $this->getAutoSaveFieldsName();
        if ($rendered_fields) {
            foreach ($rendered_fields as $field_name) {
                if ($this->isFieldMultilang($field_name)) {
                    $this->fields_value[$field_name] = $this->fshelper->getValueMultilang($field_name);
                } else {
                    $this->fields_value[$field_name] = $this->fshelper->getValue($field_name);
                }

                $field_info = $this->getFieldInfo($field_name);
                if (($field_info['type'] == 'textarea') && isset($field_info['editors'])) {
                    $this->fields_value[$field_name . '_editor'] = $this->fshelper->getValue($field_name . '_editor');
                    if ($this->enable_multishop && in_array($field_name, $multishop_override_enabled)) {
                        $multishop_override_enabled[] = $field_name . '_editor';
                    }
                }

                if ($this->enable_multishop) {
                    if (!in_array($field_name, $multishop_override_enabled)) {
                        unset($this->fields_value[$field_name]);
                        Configuration::deleteFromContext($field_name);
                    }
                }
            }
        }

        $valid = $this->validate();
        if ($valid) {
            foreach ($this->fields_value as $field_name => $field_value) {
                Configuration::updateValue($field_name, $field_value, true);
            }
        }

        return $valid;
    }
}
