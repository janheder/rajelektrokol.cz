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
class FsCustomHtmlHelperForm extends FsCustomHtmlHelperFormAbstract
{
    public function setForms($forms)
    {
        parent::setForms($forms);
        $this->enable_multishop = $this->hasAssoShopField();

        return $this;
    }

    public function hasAssoShopField()
    {
        foreach (array_keys($this->fields_form) as $id_fieldset) {
            foreach ($this->fields_form[$id_fieldset]['form']['input'] as $field) {
                if ($field['type'] == 'shop') {
                    return true;
                }
            }
        }

        return false;
    }

    public function getCopyFieldsName()
    {
        $names = [];
        foreach (array_keys($this->fields_form) as $id_fieldset) {
            foreach ($this->fields_form[$id_fieldset]['form']['input'] as $field) {
                $names[] = $field['name'];
            }
        }

        return array_unique($names);
    }

    public function postProcess()
    {
        $this->fields_value = [];

        foreach ($this->getCopyFieldsName() as $field_name) {
            if ($this->isFieldMultilang($field_name)) {
                $this->fields_value[$field_name] = $this->fshelper->getValueMultilang($field_name);
            } else {
                $this->fields_value[$field_name] = $this->fshelper->getValue($field_name);
            }

            $field_info = $this->getFieldInfo($field_name);
            if (($field_info['type'] == 'textarea') && isset($field_info['editors'])) {
                $this->fields_value[$field_name . '_editor'] = $this->fshelper->getValue($field_name . '_editor');
            }
        }

        return $this->validate();
    }

    // ############### ASSO SHOP ################

    public function getSelectedAssoShop()
    {
        $assos = [];
        if ($this->fshelper->isSubmit('checkBoxShopAsso_' . $this->table)) {
            foreach (array_keys($this->fshelper->getValue('checkBoxShopAsso_' . $this->table, [])) as $id_shop) {
                $assos[] = (int) $id_shop;
            }
        }

        return $assos;
    }

    public function updateAssoShop()
    {
        if (!Shop::isFeatureActive()) {
            $assos_data = [$this->context->shop->id];
        } else {
            $assos_data = $this->getSelectedAssoShop();
        }

        // Get list of shop id we want to exclude from asso deletion
        $exclude_ids = $assos_data;
        foreach (Db::getInstance()->executeS('SELECT id_shop FROM ' . _DB_PREFIX_ . 'shop') as $row) {
            if (!$this->context->employee->hasAuthOnShop($row['id_shop'])) {
                $exclude_ids[] = $row['id_shop'];
            }
        }
        Db::getInstance()->delete($this->table . '_shop', '`' . pSQL($this->identifier) . '` = ' . (int) $this->id .
            ($exclude_ids ? ' AND id_shop NOT IN (' . implode(', ', array_map('intval', $exclude_ids)) . ')' : ''));

        $insert = [];
        foreach ($assos_data as $id_shop) {
            $insert[] = [
                $this->identifier => (int) $this->id,
                'id_shop' => (int) $id_shop,
            ];
        }

        return Db::getInstance()->insert($this->table . '_shop', $insert, false, true, Db::INSERT_IGNORE);
    }
}
