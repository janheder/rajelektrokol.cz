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

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Core\Product\ProductExtraContent;

require_once dirname(__FILE__) . '/vendor/autoload.php';

class FsCustomHtml extends Module implements WidgetInterface
{
    private static $smarty_registered = false;

    protected static $hooks;

    protected static $custom_hooks;

    protected static $shop_variables;

    public $contact_us_url;

    public $fshelper;

    public function __construct()
    {
        $this->fshelper = FsCustomHtmlHelper::getInstance();
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        $this->bootstrap = true;
        $this->author = 'ModuleFactory';

        $this->name = 'fscustomhtml';
        $this->tab = 'front_office_features';
        $this->version = '3.2.1';
        $this->ps_versions_compliancy['min'] = '1.7';
        $this->module_key = '5e60181294dd36237fbd1e8e6d40c0a0';
        $this->contact_us_url = 'https://addons.prestashop.com/en/contact-us?id_product=13292';
        $this->displayName = $this->l('Custom HTML Block');
        $this->description = $this->l('Add multiple custom HTML/JavaScript block to your webshop.');

        $this->fshelper->addHooks(array_keys($this->getHooksForFilterSelector(false)));

        $this->fshelper->addDefaultConfig([
            'FSCH_CUSTOM_SMARTY_WIDGET' => true,
            'FSCH_ENABLE_SMARTY' => false,
        ]);

        foreach (FsCustomHtmlBlockModel::$sql_tables as $sql_table) {
            $this->fshelper->addSqlTable($sql_table);
        }
        foreach (FsCustomHtmlFilterModel::$sql_tables as $sql_table) {
            $this->fshelper->addSqlTable($sql_table);
        }
        foreach (FsCustomHtmlHookModel::$sql_tables as $sql_table) {
            $this->fshelper->addSqlTable($sql_table);
        }
        foreach (FsCustomHtmlTemplateModel::$sql_tables as $sql_table) {
            $this->fshelper->addSqlTable($sql_table);
        }

        $this->fshelper->setTabSection(Tools::getValue('tab_section', FsCustomHtmlHelper::DEFAULT_TAB_SECTION));

        parent::__construct();

        if (!self::$smarty_registered && Configuration::get('FSCH_CUSTOM_SMARTY_WIDGET')) {
            smartyRegisterFunction(
                $this->context->smarty,
                'function',
                'fscustomhtml',
                [$this, 'renderWidgetSmarty'],
                false
            );
            self::$smarty_registered = true;
        }
    }

    public function install()
    {
        $return = parent::install() && $this->fshelper->install();

        $tab = Tab::getInstanceFromClassName('AdminFsCustomHtmlFilter');
        if (!Validate::isLoadedObject($tab)) {
            $tab = new Tab();
            $tab->id_parent = 0;
            $tab->position = 0;
            $tab->module = $this->name;
            $tab->class_name = 'AdminFsCustomHtmlFilter';
            $tab->active = 1;
            $tab->name = $this->fshelper->generateMultilangField($this->displayName);
            $tab->save();
        }

        Configuration::updateValue('FSCH_INSTALLED', 1);

        $this->installSample();

        return $return;
    }

    public function installSample()
    {
        $template = new FsCustomHtmlTemplateModel();
        $template->title = $this->l('Home Page Block');
        $template->template = Tools::file_get_contents(dirname(__FILE__) . '/sample/template-1.sample');
        $template->save();

        $template = new FsCustomHtmlTemplateModel();
        $template->title = $this->l('Side Column Block');
        $template->template = Tools::file_get_contents(dirname(__FILE__) . '/sample/template-2.sample');
        $template->save();

        $template = new FsCustomHtmlTemplateModel();
        $template->title = $this->l('Product Page Block');
        $template->template = Tools::file_get_contents(dirname(__FILE__) . '/sample/template-3.sample');
        $template->save();

        $template = new FsCustomHtmlTemplateModel();
        $template->title = $this->l('Success Wrapper');
        $template->template = Tools::file_get_contents(dirname(__FILE__) . '/sample/template-4.sample');
        $template->save();

        $template = new FsCustomHtmlTemplateModel();
        $template->title = $this->l('Info Wrapper');
        $template->template = Tools::file_get_contents(dirname(__FILE__) . '/sample/template-5.sample');
        $template->save();

        $template = new FsCustomHtmlTemplateModel();
        $template->title = $this->l('Warning Wrapper');
        $template->template = Tools::file_get_contents(dirname(__FILE__) . '/sample/template-6.sample');
        $template->save();

        $template = new FsCustomHtmlTemplateModel();
        $template->title = $this->l('Error Wrapper');
        $template->template = Tools::file_get_contents(dirname(__FILE__) . '/sample/template-7.sample');
        $template->save();

        $template = new FsCustomHtmlTemplateModel();
        $template->title = $this->l('Bootstrap Collapse - Default Open');
        $template->template = Tools::file_get_contents(dirname(__FILE__) . '/sample/template-8.sample');
        $template->save();

        $template = new FsCustomHtmlTemplateModel();
        $template->title = $this->l('Bootstrap Collapse - Default Close');
        $template->template = Tools::file_get_contents(dirname(__FILE__) . '/sample/template-9.sample');
        $template->save();

        $template = new FsCustomHtmlTemplateModel();
        $template->title = $this->l('Responsive Video');
        $template->template = Tools::file_get_contents(dirname(__FILE__) . '/sample/template-10.sample');
        $template->save();

        $template = new FsCustomHtmlTemplateModel();
        $template->title = $this->l('Responsive Video With Title');
        $template->template = Tools::file_get_contents(dirname(__FILE__) . '/sample/template-11.sample');
        $template->save();

        $template = new FsCustomHtmlTemplateModel();
        $template->title = $this->l('Responsive Video With Title and Box');
        $template->template = Tools::file_get_contents(dirname(__FILE__) . '/sample/template-12.sample');
        $template->save();

        /*foreach (Shop::getShops(true, null, true) as $id_shop) {
            Db::getInstance()->insert(FsCustomHtmlBlockModel::$definition['table'].'_shop', array(
                'id_fsch_block' => '',
                'id_shop' => $id_shop,
            ), false, true, Db::INSERT_IGNORE);
        }*/
    }

    public function uninstall()
    {
        $return = $this->fshelper->uninstall() && parent::uninstall();

        return $return;
    }

    // ################### ADMIN ####################

    public function getContent()
    {
        $this->fshelper->addCSS('fsch-font-awesome.min.css');
        $this->fshelper->addCSS('admin.css');
        $this->fshelper->addJS('admin.js');

        $html = $this->fshelper->getMessagesHtml();

        $general_settings_form = $this->initGeneralSettingsForm();
        $html_block_form = $this->initBlockForm();
        $custom_hook_form = $this->initHookForm();
        $template_form = $this->initTemplateForm();

        if ($general_settings_form->isSubmitted()) {
            if ($general_settings_form->postProcess()) {
                $this->fshelper->addSuccessMessage($this->l('Update successful'));
            }
            $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab($general_settings_form->getTabSection()));

        // HTML block save
        } elseif ($html_block_form->isSubmit('save')) {
            $id_fsch_block = $this->fshelper->getValue('id_fsch_block', null);
            $fsch_block = new FsCustomHtmlBlockModel($id_fsch_block);
            if ($html_block_form->setId($id_fsch_block)->setFieldsValue($fsch_block->toArray())->postProcess()) {
                $fsch_block->fill($html_block_form->getFieldsValue());
                $is_new = $fsch_block->isNew();

                // Validate the entire object
                if ($fsch_block->validateFields(false) && $fsch_block->validateFieldsLang(false)) {
                    $fsch_block->save();
                    $html_block_form->setId($fsch_block->id);
                    $html_block_form->updateAssoShop();

                    $filters = $html_block_form->getPostedFilters('filter');
                    if ($filters) {
                        $filter_helper = new FsCustomHtmlBlockFilterModel();
                        $filter_helper->bulkSave($fsch_block->id, $filters);
                    }

                    if ($is_new) {
                        $this->fshelper->addSuccessMessage($this->l('Creation successful'));
                        if ($html_block_form->isStay()) {
                            $new_url = '&updatefsch_block&id_fsch_block=' . $fsch_block->id;
                            $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab('fsch_block_tab') . $new_url);
                        } else {
                            $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab('fsch_block_tab'));
                        }
                    } else {
                        $this->fshelper->addSuccessMessage($this->l('Update successful'));
                        if ($html_block_form->isStay()) {
                            $this->fshelper->redirectBack($this->fshelper->getAdminModuleUrlTab(
                                $html_block_form->getTabSection()
                            ));
                        } else {
                            $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab('fsch_block_tab'));
                        }
                    }
                } else {
                    $this->fshelper->addErrorMessage($this->l('Unknown error occurred!'));
                }
            }

            $this->fshelper->setTransferData($fsch_block->fill($html_block_form->getFieldsValue())->toArray());
            $this->fshelper->redirectBack($this->fshelper->getAdminModuleUrlTab(
                $html_block_form->getTabSection()
            ));

        // HTML block add
        } elseif ($html_block_form->isSubmit('add')) {
            $fsch_block = new FsCustomHtmlBlockModel();
            $html .= $html_block_form->setFieldsValue($fsch_block->toArray())->renderForm();

        // HTML block update
        } elseif ($html_block_form->isSubmit('update')) {
            $id_fsch_block = $this->fshelper->getValue('id_fsch_block', null);
            $fsch_block = new FsCustomHtmlBlockModel($id_fsch_block);
            $html .= $html_block_form->setId($id_fsch_block)->setFieldsValue($fsch_block->toArray())->renderForm();

        // HTML block delete
        } elseif ($html_block_form->isSubmit('delete')) {
            $id_fsch_block = $this->fshelper->getValue('id_fsch_block');
            $filter_helper = new FsCustomHtmlBlockFilterModel();
            $filter_helper->deleteFilters($id_fsch_block);
            $fsch_block = new FsCustomHtmlBlockModel($id_fsch_block);
            if (Validate::isLoadedObject($fsch_block)) {
                $fsch_block->delete();
            }

            $this->fshelper->addSuccessMessage($this->l('Deletion successful'));
            $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab($html_block_form->getTabSection()));

        // HTML block toggle status
        } elseif ($html_block_form->isSubmit('status')) {
            $id_fsch_block = $this->fshelper->getValue('id_fsch_block', null);
            if ($id_fsch_block) {
                $fsch_block = new FsCustomHtmlBlockModel((int) $id_fsch_block);
                if (Validate::isLoadedObject($fsch_block)) {
                    $fsch_block->toggleStatus();
                    $this->fshelper->addSuccessMessage($this->l('Update successful'));
                }
            }

            $this->fshelper->redirectBack($this->fshelper->getAdminModuleUrlTab($html_block_form->getTabSection()));

        // HTML block duplicate
        } elseif ($html_block_form->isSubmit('clone')) {
            $id_fsch_block = $this->fshelper->getValue('id_fsch_block', null);
            if ($id_fsch_block) {
                $fsch_block = new FsCustomHtmlBlockModel((int) $id_fsch_block);
                if (Validate::isLoadedObject($fsch_block)) {
                    $fsch_block->duplicate($this->l('Copy'));
                    $this->fshelper->addSuccessMessage($this->l('Duplicate successful'));
                }
            }

            $this->fshelper->redirectBack($this->fshelper->getAdminModuleUrlTab($html_block_form->getTabSection()));
        // Custom hook save
        } elseif ($custom_hook_form->isSubmit('save')) {
            $id_fsch_hook = $this->fshelper->getValue('id_fsch_hook', null);
            $fsch_hook = new FsCustomHtmlHookModel($id_fsch_hook);
            if ($custom_hook_form->setId($id_fsch_hook)->setFieldsValue($fsch_hook->toArray())->postProcess()) {
                $fsch_hook->fill($custom_hook_form->getFieldsValue());
                $is_new = $fsch_hook->isNew();

                // Validate the entire object
                if ($fsch_hook->validateFields(false) && $fsch_hook->validateFieldsLang(false)) {
                    $fsch_hook->save();
                    $custom_hook_form->setId($fsch_hook->id);

                    if ($is_new) {
                        $this->fshelper->addSuccessMessage($this->l('Creation successful'));
                        if ($custom_hook_form->isStay()) {
                            $new_url = '&updatefsch_hook&id_fsch_hook=' . $fsch_hook->id;
                            $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab(
                                $custom_hook_form->getTabSection()
                            ) . $new_url);
                        } else {
                            $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab(
                                $custom_hook_form->getTabSection()
                            ));
                        }
                    } else {
                        $this->fshelper->addSuccessMessage($this->l('Update successful'));
                        if ($custom_hook_form->isStay()) {
                            $this->fshelper->redirectBack($this->fshelper->getAdminModuleUrlTab(
                                $custom_hook_form->getTabSection()
                            ));
                        } else {
                            $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab(
                                $custom_hook_form->getTabSection()
                            ));
                        }
                    }
                } else {
                    $this->fshelper->addErrorMessage($this->l('Unknown error occurred!'));
                }
            }

            $this->fshelper->setTransferData($fsch_hook->fill($custom_hook_form->getFieldsValue())->toArray());
            $this->fshelper->redirectBack($this->fshelper->getAdminModuleUrlTab(
                $custom_hook_form->getTabSection()
            ));

        // Custom hook add
        } elseif ($custom_hook_form->isSubmit('add')) {
            $fsch_hook = new FsCustomHtmlHookModel();
            $html .= $custom_hook_form->setFieldsValue($fsch_hook->toArray())->renderForm();

        // Custom hook update
        } elseif ($custom_hook_form->isSubmit('update')) {
            $id_fsch_hook = $this->fshelper->getValue('id_fsch_hook', null);
            $fsch_hook = new FsCustomHtmlHookModel($id_fsch_hook);
            $html .= $custom_hook_form->setId($id_fsch_hook)->setFieldsValue($fsch_hook->toArray())->renderForm();

        // Custom hook delete
        } elseif ($custom_hook_form->isSubmit('delete')) {
            $id_fsch_hook = $this->fshelper->getValue('id_fsch_hook');
            $fsch_hook = new FsCustomHtmlHookModel($id_fsch_hook);
            if (Validate::isLoadedObject($fsch_hook)) {
                $fsch_hook->delete();
            }

            $this->fshelper->addSuccessMessage($this->l('Deletion successful'));
            $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab($custom_hook_form->getTabSection()));

        // Template save
        } elseif ($template_form->isSubmit('save')) {
            $id_fsch_template = $this->fshelper->getValue('id_fsch_template', null);
            $fsch_template = new FsCustomHtmlTemplateModel($id_fsch_template);
            if ($template_form->setId($id_fsch_template)->setFieldsValue($fsch_template->toArray())->postProcess()) {
                $fsch_template->fill($template_form->getFieldsValue());
                $is_new = $fsch_template->isNew();

                // Validate the entire object
                if ($fsch_template->validateFields(false) && $fsch_template->validateFieldsLang(false)) {
                    $fsch_template->save();
                    $template_form->setId($fsch_template->id);

                    if ($is_new) {
                        $this->fshelper->addSuccessMessage($this->l('Creation successful'));
                        if ($template_form->isStay()) {
                            $new_url = '&updatefsch_template&id_fsch_template=' . $fsch_template->id;
                            $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab(
                                $template_form->getTabSection()
                            ) . $new_url);
                        } else {
                            $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab(
                                $template_form->getTabSection()
                            ));
                        }
                    } else {
                        $this->fshelper->addSuccessMessage($this->l('Update successful'));
                        if ($template_form->isStay()) {
                            $this->fshelper->redirectBack($this->fshelper->getAdminModuleUrlTab(
                                $template_form->getTabSection()
                            ));
                        } else {
                            $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab(
                                $template_form->getTabSection()
                            ));
                        }
                    }
                } else {
                    $this->fshelper->addErrorMessage($this->l('Unknown error occurred!'));
                }
            }

            $this->fshelper->setTransferData($fsch_template->fill($template_form->getFieldsValue())->toArray());
            $this->fshelper->redirectBack($this->fshelper->getAdminModuleUrlTab(
                $template_form->getTabSection()
            ));

        // Template add
        } elseif ($template_form->isSubmit('add')) {
            $fsch_template = new FsCustomHtmlTemplateModel();
            $html .= $template_form->setFieldsValue($fsch_template->toArray())->renderForm();

        // Template update
        } elseif ($template_form->isSubmit('update')) {
            $id_fsch_template = $this->fshelper->getValue('id_fsch_template', null);
            $fsch_template = new FsCustomHtmlTemplateModel($id_fsch_template);
            $html .= $template_form->setId($id_fsch_template)->setFieldsValue($fsch_template->toArray())->renderForm();

        // Template delete
        } elseif ($template_form->isSubmit('delete')) {
            $id_fsch_template = $this->fshelper->getValue('id_fsch_template');
            $fsch_template = new FsCustomHtmlTemplateModel($id_fsch_template);
            if (Validate::isLoadedObject($fsch_template)) {
                $fsch_template->delete();
            }

            $this->fshelper->addSuccessMessage($this->l('Deletion successful'));
            $this->fshelper->redirect($this->fshelper->getAdminModuleUrlTab($template_form->getTabSection()));

        // Display
        } else {
            if (Configuration::get('FSCH_INSTALLED')) {
                $this->fshelper->setTabSection('fsch_help_tab');
                Configuration::deleteByName('FSCH_INSTALLED');
            }

            $error_string = $this->l('Please turn off "%s" option in "%s" -> "%s" -> "%s" panel!');
            $menu_1 = $this->l('Advanced Parameters');
            $menu_2 = $this->l('Performance');
            $panel = $this->l('Debug Mode');

            if (Configuration::get('PS_DISABLE_NON_NATIVE_MODULE')) {
                $html .= $this->displayError(sprintf(
                    $error_string,
                    'Disable non PrestaShop modules',
                    $menu_1,
                    $menu_2,
                    $panel
                ));
            }

            $tab_content = [];
            $forms_fields_value = $this->fshelper->getAdminConfig();

            $tab_content_block = $this->renderBlockList();
            $tab_content[] = [
                'id' => 'fsch_block_tab',
                'title' => $this->l('HTML Blocks'),
                'content' => $tab_content_block,
            ];

            $tab_content_hook = $this->renderHookList();
            $tab_content_hook .= $this->fshelper->smartyFetch('admin/help_custom_hook.tpl');
            $tab_content[] = [
                'id' => 'fsch_hook_tab',
                'title' => $this->l('Custom Hooks'),
                'content' => $tab_content_hook,
            ];

            $tab_content_template = $this->renderTemplateList();
            $tab_content[] = [
                'id' => 'fsch_template_tab',
                'title' => $this->l('Templates'),
                'content' => $tab_content_template,
            ];

            $tab_content[] = [
                'id' => $general_settings_form->getTabSection(),
                'title' => $this->l('Settings'),
                'content' => $general_settings_form->setFieldsValue($forms_fields_value)->renderForm(),
            ];

            $simple_rules = $html_block_form->getFilterRules(false);
            foreach ($simple_rules as $id_rule => $rule) {
                if (!(isset($rule['help']) && $rule['help'])) {
                    unset($simple_rules[$id_rule]);
                }
            }

            $hooks = $this->getHooks(false);
            $this->fshelper->smartyAssign([
                'fsch_contact_us_url' => $this->contact_us_url,
                'fsch_page_names' => $html_block_form->getAllPage(),
                'fsch_filter_rules_first_half' => array_slice($simple_rules, 0, ceil(count($simple_rules) / 2)),
                'fsch_filter_rules_second_half' => array_slice($simple_rules, ceil(count($simple_rules) / 2)),
                'fsch_hooks_first_half' => array_slice($hooks, 0, ceil(count($hooks) / 2)),
                'fsch_hooks_second_half' => array_slice($hooks, ceil(count($hooks) / 2)),
            ]);

            $tab_content_help = $this->fshelper->smartyFetch('admin/help.tpl');
            $tab_content[] = [
                'id' => 'fsch_help_tab',
                'title' => $this->l('Help'),
                'content' => $tab_content_help,
            ];

            $html .= $this->fshelper->renderTabLayout($tab_content, $this->fshelper->getTabSection());
        }

        return $html;
    }

    public function renderBlockList()
    {
        $fields = [
            'id_fsch_block' => [
                'title' => $this->l('ID'),
                'width' => 50,
            ],
            'name' => [
                'title' => $this->l('Name'),
            ],
            'hook' => [
                'title' => $this->l('Hook'),
                'type' => 'select',
                'list' => $this->getHooksForFilterSelector(),
                'filter_key' => 'hook',
            ],
            'filters' => [
                'title' => $this->l('Display Rules'),
                'align' => 'center',
                'class' => 'fixed-width-md',
                'orderby' => false,
                'search' => false,
            ],
            'position' => [
                'title' => $this->l('Position'),
                'align' => 'center',
                'class' => 'fixed-width-md',
            ],
            'active' => [
                'title' => $this->l('Active'),
                'width' => 20,
                'type' => 'bool',
                'active' => 'status',
                'align' => 'center',
                'class' => 'fixed-width-sm',
            ],
        ];

        $helper = new FsCustomHtmlHelperList();
        $helper->init($this, $this->l('HTML Blocks'), 'fsch_block_tab');
        $helper->setObjectDefinition(FsCustomHtmlBlockModel::$definition);
        $helper->setFilterFields(FsCustomHtmlBlockModel::$filter_fields);
        $helper->setDefaultOrderBy('position');
        $helper->setActions(['edit', 'clone', 'delete']);

        $filters = $helper->getFilters();
        $items = FsCustomHtmlBlockModel::getListContent($this->context->language->id, $filters);
        if ($items) {
            $helper->setListTotal(FsCustomHtmlBlockModel::getListCount($filters));

            $filter_helper = new FsCustomHtmlBlockFilterModel();
            $block_form = $this->initBlockForm();
            $hooks = $this->getHooksForFilterSelector();
            foreach ($items as &$item) {
                if (isset($hooks[$item['hook']])) {
                    $item['hook'] = $hooks[$item['hook']];

                    $content_filters = $filter_helper->getFiltersForForm($item['id_fsch_block']);
                    $grouped = [];
                    $filter_count = 0;
                    foreach ($content_filters as $content_filter_group) {
                        $group = [];
                        foreach ($content_filter_group as $content_filter) {
                            $str = $block_form->getTypeText($content_filter['type']);
                            if ($content_filter['parameter']) {
                                $str .= ': ' . $content_filter['parameter'];
                            }
                            if ($content_filter['condition']) {
                                $str .= ' ' . $block_form->getConditionText(
                                    $content_filter['type'],
                                    $content_filter['condition']
                                );
                            }
                            $str .= ' ' . $block_form->getValueText(
                                $content_filter['type'],
                                $content_filter['value']
                            );
                            $group[] = smartyEscape($str);
                            ++$filter_count;
                        }
                        $grouped[] = implode(' --- (' . $this->l('AND') . ') <br />', $group);
                    }

                    $this->fshelper->smartyAssign([
                        'filters' => '<p>' . implode('</p><p>--- (' . $this->l('OR') . ') ---</p><p>', $grouped) . '</p>',
                        'filter_count' => $filter_count,
                    ]);

                    $item['filters'] = $this->fshelper->smartyFetch('admin/tooltip.tpl');
                }
            }
        }

        return $helper->generateList($items, $fields);
    }

    public function initBlockForm()
    {
        $input_fields = [0 => []];

        $input_fields[0][] = [
            'type' => 'hidden',
            'name' => 'id_fsch_block',
        ];

        $input_fields[0][] = [
            'type' => 'text',
            'label' => $this->l('Internal Name') . ':',
            'name' => 'name',
            'desc' => $this->l('Only displays in the admin as a short summary of the block.'),
            'required' => true,
            'validate' => FsCustomHtmlBlockModel::$definition['fields']['name']['validate'],
            'error_message' => $this->l('Please provide valid name!'),
        ];

        $input_fields[0][] = [
            'type' => 'select',
            'label' => $this->l('Hook') . ':',
            'name' => 'hook',
            'required' => true,
            'options' => [
                'optiongroup' => [
                    'query' => $this->getHooksForSelector(),
                    'label' => 'title',
                ],
                'options' => [
                    'query' => 'hooks',
                    'id' => 'name',
                    'name' => 'title',
                ],
                'default' => [
                    'value' => 'selectsomething',
                    'label' => $this->l('Select Hook'),
                ],
            ],
            'desc' => $this->l('Select where to display the HTML block.'),
            'validate' => 'isSelected',
            'error_message' => $this->l('Please select a hook!'),
            'select2' => true,
        ];

        $input_fields[0][] = [
            'type' => 'text',
            'label' => $this->l('Position') . ':',
            'name' => 'position',
            'class' => 'fixed-width-xs',
            'desc' => $this->l('Enter the position number of this HTML block within the selected hook.'),
            'required' => true,
            'validate' => FsCustomHtmlBlockModel::$definition['fields']['position']['validate'],
            'error_message' => $this->l('Please enter a valid position for this HTML block!'),
        ];

        $input_fields[0][] = [
            'type' => 'fsch_filter',
            'label' => $this->l('Display Rules') . ':',
            'name' => 'filter',
            'hint' => $this->l('Create a set of rules to determine where the block will display.'),
        ];

        $templates = FsCustomHtmlTemplateModel::getListContent([
            'order_by' => 'title',
            'order_way' => 'ASC',
        ]);
        if ($templates) {
            $input_fields[0][] = [
                'type' => 'select',
                'label' => $this->l('Template') . ':',
                'name' => 'id_fsch_template',
                'options' => [
                    'query' => $templates,
                    'id' => 'id_fsch_template',
                    'name' => 'title',
                    'default' => [
                        'value' => 0,
                        'label' => $this->l('Select Template'),
                    ],
                ],
                'select2' => true,
            ];
        }

        $input_fields[0][] = [
            'type' => 'text',
            'label' => $this->l('Title') . ':',
            'name' => 'title',
            'lang' => true,
        ];

        $input_fields[0][] = [
            'type' => 'textarea',
            'label' => $this->l('Content') . ':',
            'name' => 'content',
            'lang' => true,
            'editors' => [
                'tinymce' => [
                    'basic' => true,
                    'advanced' => true,
                    'templates_url' => $this->fshelper->getAdminControllerUrl(
                        'AdminFsCustomHtmlFilter',
                        [
                            'ajax' => '1',
                            'action' => 'templates',
                        ]
                    ),
                ],
                'codemirror' => [
                    'mode' => 'htmlmixed', // htmlmixed, javascript, css, xml, smartymixed, smarty
                ],
            ],
            'hide_selector' => false,
            'desc' => $this->l('Enter the HTML or Javascript code here for this HTML block.') . '<br /><br />' .
                $this->fshelper->smartyFetch('admin/help_variables.tpl'),
        ];

        $input_fields[0][] = [
            'type' => 'switch',
            'label' => $this->l('Active') . ':',
            'name' => 'active',
            'class' => 't',
            'is_bool' => true,
            'values' => [
                [
                    'id' => 'active_on',
                    'value' => 1,
                    'label' => $this->l('Yes'),
                ],
                [
                    'id' => 'active_off',
                    'value' => 0,
                    'label' => $this->l('No'),
                ],
            ],
        ];

        if (Shop::isFeatureActive()) {
            $input_fields[0][] = [
                'type' => 'shop',
                'label' => $this->l('Shop association') . ':',
                'name' => 'checkBoxShopAsso',
                'desc' => $this->l('Please select each shop where you want to display this block.'),
            ];
        }

        $forms = [0 => []];
        $forms[0]['form'] = [
            'legend' => [
                'title' => $this->l('HTML Block'),
            ],
            'input' => $input_fields[0],
            'save_button' => true,
            'save_and_stay_button' => true,
            'back_button' => true,
        ];

        $helper = new FsCustomHtmlHelperFormFilter();
        $helper->init($this);
        $helper->setFilterFormInitFunction('initBlockForm');
        $helper->setObjectDefinition(FsCustomHtmlBlockModel::$definition);
        $helper->setTabSection('fsch_block_tab');
        $helper->setForms($forms);

        return $helper;
    }

    public function renderHookList()
    {
        $fields = [
            'id_fsch_hook' => [
                'title' => $this->l('ID'),
                'width' => 50,
            ],
            'title' => [
                'title' => $this->l('Title'),
            ],
            'name' => [
                'title' => $this->l('Hook Name'),
            ],
        ];

        $helper = new FsCustomHtmlHelperList();
        $helper->init($this, $this->l('Custom Hooks'), 'fsch_hook_tab');
        $helper->setObjectDefinition(FsCustomHtmlHookModel::$definition);
        $helper->setFilterFields(FsCustomHtmlHookModel::$filter_fields);
        $helper->setDefaultOrderBy('id_fsch_hook');
        $helper->setActions(['edit', 'delete']);

        $filters = $helper->getFilters();
        $items = FsCustomHtmlHookModel::getListContent($filters);
        if ($items) {
            $helper->setListTotal(FsCustomHtmlHookModel::getListCount($filters));
        }

        return $helper->generateList($items, $fields);
    }

    public function initHookForm()
    {
        $input_fields = [0 => []];

        $input_fields[0][] = [
            'type' => 'hidden',
            'name' => 'id_fsch_hook',
        ];

        $input_fields[0][] = [
            'type' => 'text',
            'label' => $this->l('Title') . ':',
            'name' => 'title',
            'desc' => $this->l('Only displays in the admin as a short summary of the custom hook.'),
            'required' => true,
            'validate' => FsCustomHtmlHookModel::$definition['fields']['title']['validate'],
            'error_message' => $this->l('Please provide valid title!'),
        ];

        $input_fields[0][] = [
            'type' => 'text',
            'label' => $this->l('Hook Name') . ':',
            'name' => 'name',
            'desc' => $this->l('The identifier used in the widget, like: displayFSCH1'),
            'required' => true,
            'validate' => FsCustomHtmlHookModel::$definition['fields']['name']['validate'],
            'error_message' => $this->l('Please provide valid hook name!'),
        ];

        $forms = [0 => []];
        $forms[0]['form'] = [
            'legend' => [
                'title' => $this->l('Custom Hook'),
            ],
            'input' => $input_fields[0],
            'save_button' => true,
            'save_and_stay_button' => true,
            'back_button' => true,
        ];

        $helper = new FsCustomHtmlHelperFormFilter();
        $helper->init($this);
        $helper->setFilterFormInitFunction('initHookForm');
        $helper->setObjectDefinition(FsCustomHtmlHookModel::$definition);
        $helper->setTabSection('fsch_hook_tab');
        $helper->setForms($forms);

        return $helper;
    }

    public function renderTemplateList()
    {
        $fields = [
            'id_fsch_template' => [
                'title' => $this->l('ID'),
                'width' => 50,
            ],
            'title' => [
                'title' => $this->l('Name'),
            ],
        ];

        $helper = new FsCustomHtmlHelperList();
        $helper->init($this, $this->l('Templates'), 'fsch_template_tab');
        $helper->setObjectDefinition(FsCustomHtmlTemplateModel::$definition);
        $helper->setFilterFields(FsCustomHtmlTemplateModel::$filter_fields);
        $helper->setDefaultOrderBy('id_fsch_template');
        $helper->setActions(['edit', 'delete']);

        $filters = $helper->getFilters();
        $items = FsCustomHtmlTemplateModel::getListContent($filters);
        if ($items) {
            $helper->setListTotal(FsCustomHtmlTemplateModel::getListCount($filters));
        }

        return $helper->generateList($items, $fields);
    }

    public function initTemplateForm()
    {
        $input_fields = [0 => []];

        $input_fields[0][] = [
            'type' => 'hidden',
            'name' => 'id_fsch_template',
        ];

        $input_fields[0][] = [
            'type' => 'text',
            'label' => $this->l('Internal Name') . ':',
            'name' => 'title',
            'desc' => $this->l('Only displays in the admin as a short summary of the template.'),
            'required' => true,
            'validate' => FsCustomHtmlTemplateModel::$definition['fields']['title']['validate'],
            'error_message' => $this->l('Please provide valid name!'),
        ];

        $input_fields[0][] = [
            'type' => 'textarea',
            'label' => $this->l('Template') . ':',
            'name' => 'template',
            'editors' => [
                'tinymce' => [
                    'basic' => true,
                    'advanced' => true,
                ],
                'codemirror' => [
                    'mode' => 'htmlmixed', // htmlmixed, javascript, css, xml, smartymixed, smarty
                ],
            ],
            'hide_selector' => false,
            'desc' => $this->fshelper->smartyFetch('admin/help_variables_template.tpl'),
        ];

        $forms = [0 => []];
        $forms[0]['form'] = [
            'legend' => [
                'title' => $this->l('Template'),
            ],
            'input' => $input_fields[0],
            'save_button' => true,
            'save_and_stay_button' => true,
            'back_button' => true,
        ];

        $helper = new FsCustomHtmlHelperFormFilter();
        $helper->init($this);
        $helper->setFilterFormInitFunction('initTemplateForm');
        $helper->setObjectDefinition(FsCustomHtmlTemplateModel::$definition);
        $helper->setTabSection('fsch_template_tab');
        $helper->setForms($forms);

        return $helper;
    }

    public function initGeneralSettingsForm()
    {
        $input_fields = [0 => []];
        $input_fields[0][] = [
            'type' => 'switch',
            'label' => $this->l('Enable Custom Widget Code:'),
            'name' => 'FSCH_CUSTOM_SMARTY_WIDGET',
            'class' => 't',
            'is_bool' => true,
            'values' => [
                [
                    'id' => 'FSCH_CUSTOM_SMARTY_WIDGET_on',
                    'value' => 1,
                    'label' => $this->l('Yes'),
                ],
                [
                    'id' => 'FSCH_CUSTOM_SMARTY_WIDGET_off',
                    'value' => 0,
                    'label' => $this->l('No'),
                ],
            ],
            'desc' => $this->l('When enabled, you can use a shorter widget format in templates for custom hooks.'),
            'auto_save' => true,
            // 'validate' => 'isAnything',
            // 'error_message' => $this->l('Please provide valid css classes!'),
        ];

        $input_fields[0][] = [
            'type' => 'switch',
            'label' => $this->l('Enable Smarty:'),
            'name' => 'FSCH_ENABLE_SMARTY',
            'class' => 't',
            'is_bool' => true,
            'values' => [
                [
                    'id' => 'FSCH_ENABLE_SMARTY_on',
                    'value' => 1,
                    'label' => $this->l('Yes'),
                ],
                [
                    'id' => 'FSCH_ENABLE_SMARTY_off',
                    'value' => 0,
                    'label' => $this->l('No'),
                ],
            ],
            'desc' => $this->l('When enabled, you can use every assigned smarty variables in custom HTML blocks.') . ' ' .
                $this->l('Also you can use every smarty functions.') . ' ' .
                $this->l('This is for more advanced users. We do not support on help using smarty.'),
            'auto_save' => true,
            // 'validate' => 'isAnything',
            // 'error_message' => $this->l('Please provide valid css classes!'),
        ];

        $forms = [0 => []];
        $forms[0]['form'] = [
            'legend' => [
                'title' => $this->l('Settings'),
            ],
            'input' => $input_fields[0],
        ];

        $helper = new FsCustomHtmlHelperConfig();
        $helper->init($this);
        $helper->setIdentifier('fsch_general_settings');
        $helper->setTabSection('fsch_general_tab');
        $helper->setForms($forms);

        return $helper;
    }

    // ################### FUNCTIONS ####################

    public function getHooks($load_custom = true)
    {
        if (!isset(self::$hooks)) {
            self::$hooks = [];

            // Global
            self::$hooks['global']['title'] = $this->l('Global');
            self::$hooks['global']['hooks']['displayHeader'] = [
                'title' => $this->l('Page header'),
                'desc' => $this->l('This hook displays additional elements in the header of your pages'),
            ];
            self::$hooks['global']['hooks']['displayAfterBodyOpeningTag'] = [
                'title' => $this->l('Very top of pages'),
                'desc' => $this->l('Use this hook for advertisement or modals you want to load first.'),
            ];
            self::$hooks['global']['hooks']['displayNav1'] = [
                'title' => $this->l('Top navigation left'),
                'desc' => $this->l('This hook displays additional elements in the top navigation left side.'),
            ];
            self::$hooks['global']['hooks']['displayNav2'] = [
                'title' => $this->l('Top navigation right'),
                'desc' => $this->l('This hook displays additional elements in the top navigation right side.'),
            ];
            self::$hooks['global']['hooks']['displayTop'] = [
                'title' => $this->l('Top of pages'),
                'desc' => $this->l('This hook displays additional elements at the top of your pages.'),
            ];
            self::$hooks['global']['hooks']['displayNavFullWidth'] = [
                'title' => $this->l('Full width navigation'),
                'desc' => $this->l('This hook displays full width space at the top of your pages.'),
            ];
            self::$hooks['global']['hooks']['displayLeftColumn'] = [
                'title' => $this->l('Left column'),
                'desc' => $this->l('This hook displays additional elements in the left-hand column.'),
            ];
            self::$hooks['global']['hooks']['displayRightColumn'] = [
                'title' => $this->l('Right column'),
                'desc' => $this->l('This hook displays additional elements in the right-hand column.'),
            ];
            self::$hooks['global']['hooks']['displayFooterBefore'] = [
                'title' => $this->l('Before footer'),
                'desc' => $this->l('This hook displays additional elements before the footer.'),
            ];
            self::$hooks['global']['hooks']['displayFooter'] = [
                'name' => 'displayFooter',
                'title' => $this->l('Footer'),
                'desc' => $this->l('This hook displays additional elements in the footer.'),
            ];
            self::$hooks['global']['hooks']['displayFooterAfter'] = [
                'title' => $this->l('After footer'),
                'desc' => $this->l('This hook displays additional elements after the footer.'),
            ];
            self::$hooks['global']['hooks']['displayBeforeBodyClosingTag'] = [
                'title' => $this->l('Very bottom of pages'),
                'desc' => $this->l('Use this hook for your modals or any content you want to load at the very end.'),
            ];

            // Home
            self::$hooks['index']['title'] = $this->l('Home Page');
            self::$hooks['index']['hooks']['displayHome'] = [
                'title' => $this->l('Home page content'),
                'desc' => $this->l('This hook displays additional elements on the homepage.'),
            ];

            // Product
            self::$hooks['product']['title'] = $this->l('Product Page');
            self::$hooks['product']['hooks']['displayLeftColumnProduct'] = [
                'title' => $this->l('Product left column'),
                'desc' => $this->l('This hook displays additional elements in the left-hand column of the product page.'),
            ];
            self::$hooks['product']['hooks']['displayRightColumnProduct'] = [
                'title' => $this->l('Product right column'),
                'desc' => $this->l('This hook displays additional elements in the right-hand column of the product page.'),
            ];
            self::$hooks['product']['hooks']['displayAfterProductThumbs'] = [
                'title' => $this->l('Product under thumbnail'),
                'desc' => $this->l('This hook displays additional element on the product page under the thumbnails..'),
            ];
            self::$hooks['product']['hooks']['displayProductButtons'] = [
                'title' => $this->l('Product actions'),
                'desc' => $this->l('This hook displays additional action buttons on the product page.'),
            ];
            self::$hooks['product']['hooks']['displayProductAdditionalInfo'] = [
                'title' => $this->l('Product addition info'),
                'desc' => $this->l('This hook displays additional elements on the product page after the cart button.'),
            ];
            self::$hooks['product']['hooks']['displayReassurance'] = [
                'title' => $this->l('Product reassurance'),
                'desc' => $this->l('This hook displays additional reassurance information on the product page.'),
            ];
            self::$hooks['product']['hooks']['displayProductExtraContent'] = [
                'title' => $this->l('Product extra tab'),
                'desc' => $this->l('This hook displays additional tab content on the product page.'),
            ];
            self::$hooks['product']['hooks']['displayFooterProduct'] = [
                'title' => $this->l('Product footer'),
                'desc' => $this->l('This hook displays additional elements after the product\'s description.'),
            ];

            // CMS
            self::$hooks['cms']['title'] = $this->l('CMS Page');
            self::$hooks['cms']['hooks']['displayCMSDisputeInformation'] = [
                'title' => $this->l('After CMS content'),
                'desc' => $this->l('This hook displays additional elements after the CMS content.'),
            ];

            // Maintenance
            self::$hooks['maintenance']['title'] = $this->l('Maintenance Page');
            self::$hooks['maintenance']['hooks']['displayMaintenance'] = [
                'title' => $this->l('Maintenance'),
                'desc' => $this->l('This hook displays additional elements on the maintenance page.'),
            ];

            // Account
            self::$hooks['account']['title'] = $this->l('Account Page');
            self::$hooks['account']['hooks']['displayCustomerLoginFormAfter'] = [
                'title' => $this->l('After login form'),
                'desc' => $this->l('This hook displays additional elements after the login forms.'),
            ];
            self::$hooks['account']['hooks']['displayCustomerAccount'] = [
                'title' => $this->l('Customer account'),
                'desc' => $this->l('This hook displays additional elements on the customer account page.'),
            ];

            // Order Confirmation
            self::$hooks['orderconfirmation']['title'] = $this->l('Order Confirmation Page');
            self::$hooks['orderconfirmation']['hooks']['displayOrderConfirmation'] = [
                'title' => $this->l('Top'),
                'desc' => $this->l('This hook displays additional elements on the top of the page.'),
            ];
            self::$hooks['orderconfirmation']['hooks']['displayOrderConfirmation1'] = [
                'title' => $this->l('After payment info'),
                'desc' => $this->l('This hook displays additional elements after the payment information.'),
            ];
            self::$hooks['orderconfirmation']['hooks']['displayOrderConfirmation2'] = [
                'title' => $this->l('After content'),
                'desc' => $this->l('This hook displays additional elements after the order confirmation content.'),
            ];

            // Not Found
            self::$hooks['notfound']['title'] = $this->l('Not Found Page');
            self::$hooks['notfound']['hooks']['displayNotFound'] = [
                'title' => $this->l('Not found page'),
                'desc' => $this->l('This hook displays additional elements on the page not found page.'),
            ];
            self::$hooks['notfound']['hooks']['displaySearch'] = [
                'title' => $this->l('After search field'),
                'desc' => $this->l('This hook displays additional elements on the not found page after search field.'),
            ];

            // Cart
            self::$hooks['cart']['title'] = $this->l('Cart Page');
            self::$hooks['cart']['hooks']['displayShoppingCart'] = [
                'title' => $this->l('Shopping cart top'),
                'desc' => $this->l('This hook displays additional elements on the top of the shopping cart block.'),
            ];
            self::$hooks['cart']['hooks']['displayShoppingCartFooter'] = [
                'title' => $this->l('After shopping cart'),
                'desc' => $this->l('This hook displays additional elements after the shopping cart content.'),
            ];

            // Checkout
            self::$hooks['checkout']['title'] = $this->l('Checkout Page');
            self::$hooks['checkout']['hooks']['displayCheckoutSummaryTop'] = [
                'title' => $this->l('Shopping cart top'),
                'desc' => $this->l('This hook displays additional elements on the top of the shopping cart block.'),
            ];
            self::$hooks['checkout']['hooks']['displayPaymentByBinaries'] = [
                'title' => $this->l('After payment step content'),
                'desc' => $this->l('This hook displays additional elements after the payment step content.'),
            ];

            // Notification
            self::$hooks['notification']['title'] = $this->l('Notification Bar');
            self::$hooks['notification']['hooks']['displayNotificationError'] = [
                'title' => $this->l('Error notification'),
                'desc' => $this->l('This hook displays an error notification in the notification bar.'),
            ];
            self::$hooks['notification']['hooks']['displayNotificationWarning'] = [
                'title' => $this->l('Warning notification'),
                'desc' => $this->l('This hook displays a warning notification in the notification bar.'),
            ];
            self::$hooks['notification']['hooks']['displayNotificationSuccess'] = [
                'title' => $this->l('Success notification'),
                'desc' => $this->l('This hook displays a success notification in the notification bar.'),
            ];
            self::$hooks['notification']['hooks']['displayNotificationInfo'] = [
                'title' => $this->l('Info notification'),
                'desc' => $this->l('This hook displays an info notification in the notification bar.'),
            ];

            foreach (self::$hooks as $type_name => &$type_item) {
                $type_item['name'] = $type_name;
                foreach ($type_item['hooks'] as $hook_name => &$hook) {
                    $hook['name'] = $hook_name;
                }
            }
        }

        if ($load_custom) {
            if (!isset(self::$custom_hooks)) {
                self::$custom_hooks = [];

                $custom_hooks = FsCustomHtmlHookModel::getListContent();
                if ($custom_hooks) {
                    foreach ($custom_hooks as $custom_hook) {
                        self::$custom_hooks[$custom_hook['name']] = [
                            'title' => $custom_hook['title'],
                            'desc' => '',
                            'name' => $custom_hook['name'],
                        ];
                    }
                }
            }

            $custom_hooks = [
                'title' => $this->l('Custom'),
                'hooks' => self::$custom_hooks,
                'name' => 'custom',
            ];

            if (self::$custom_hooks) {
                return array_merge(self::$hooks, ['custom' => $custom_hooks]);
            }
        }

        return self::$hooks;
    }

    public function getHooksForSelector($load_custom = true)
    {
        $options = $this->getHooks($load_custom);
        foreach ($options as &$group) {
            foreach ($group['hooks'] as &$hook) {
                $hook['title'] .= ' (' . $hook['name'] . ')';
            }
        }

        return $options;
    }

    public function getHooksForFilterSelector($load_custom = true)
    {
        $hooks = $this->getHooksForSelector($load_custom);
        $return = [];
        foreach ($hooks as $group) {
            foreach ($group['hooks'] as $hook => $info) {
                $return[$hook] = $info['title'];
            }
        }

        return $return;
    }

    public function getShopVariables()
    {
        if (self::$shop_variables) {
            return self::$shop_variables;
        } else {
            $shop_variables = [];
            $shop_variables['id_lang'] = $this->context->language->id;
            $shop_variables['lang_iso_code'] = $this->context->language->iso_code;
            $shop_variables['content_only_url_param'] = '';
            if (Tools::getValue('content_only')) {
                $shop_variables['content_only_url_param'] = '?content_only=1';
            }
            $shop_variables['shop_url'] = $this->context->shop->getBaseURL(true);
            $shop_variables['shop_name'] = $this->context->shop->name;
            $shop_variables['page_name'] = $this->context->controller->getPageName();
            $shop_variables['customer_lastname'] = $this->context->customer->lastname;
            $shop_variables['customer_firstname'] = $this->context->customer->firstname;

            self::$shop_variables = $shop_variables;
        }

        return self::$shop_variables;
    }

    public function getBlockFinalContent(array $block)
    {
        $shop_variables = $this->getShopVariables();
        $shop_variables['id_html_block'] = $block['id_fsch_block'];

        $block_content = $block['content'];
        if ($block['id_fsch_template'] && $block_content) {
            $template = FsCustomHtmlTemplateModel::getCached($block['id_fsch_template']);
            $block_content = str_replace(
                ['{title}', '{content}'],
                [$block['title'], $block_content],
                $template
            );
        }

        foreach ($shop_variables as $key => $value) {
            $block_content = str_replace('{' . $key . '}', $value, $block_content);
        }

        if (Configuration::get('FSCH_ENABLE_SMARTY')) {
            return $this->context->smarty->fetch('string:' . $block_content);
        }

        return $block_content;
    }

    // ################### WIDGET ####################

    /**
     * @usage {widget name="fscustomhtml" hook='displayFSCH1'}
     */
    public function renderWidget($hookName, array $configuration)
    {
        if (is_null($hookName)) {
            if (isset($configuration['hook'])) {
                $hookName = $configuration['hook'];
            } else {
                return '';
            }
        }

        $content = [];
        $blocks = $this->getWidgetVariables($hookName, $configuration);
        if ($blocks) {
            foreach ($blocks as $block) {
                $content[] = $this->getBlockFinalContent($block);
            }
        }

        if (isset($configuration['fsch_as_array']) && $configuration['fsch_as_array']) {
            return $content;
        }

        return implode('', $content);
    }

    /**
     * @usage {fscustomhtml hook='displayFSCH1'}
     */
    public function renderWidgetSmarty($params, $smarty)
    {
        if (isset($params['hook'])) {
            return $this->renderWidget($params['hook'], ['smarty' => $smarty]);
        }

        return '';
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        $filter = [
            'order_by' => 'position',
            'order_way' => 'ASC',
            'active' => 1,
            'hook' => $hookName,
            'id_shop' => $this->context->shop->id,
            'widget_configuration' => $configuration,
        ];

        $filter_helper = new FsCustomHtmlBlockFilterModel();
        $blocks = FsCustomHtmlBlockModel::getListContent($this->context->language->id, $filter);

        $display_blocks = [];
        if ($blocks) {
            foreach ($blocks as $block) {
                if ($filter_helper->test($block['id_fsch_block'])) {
                    $display_blocks[] = $block;
                }
            }
        }

        return $display_blocks;
    }

    // ################### HOOKS ####################

    public function hookDisplayHeader($params)
    {
        $error_notifications = $this->renderWidget('displayNotificationError', ['fsch_as_array' => true]);
        if ($error_notifications) {
            foreach ($error_notifications as $error_notification) {
                $this->context->controller->errors[] = $error_notification;
            }
        }

        $warning_notifications = $this->renderWidget('displayNotificationWarning', ['fsch_as_array' => true]);
        if ($warning_notifications) {
            foreach ($warning_notifications as $warning_notification) {
                $this->context->controller->warning[] = $warning_notification;
            }
        }

        $success_notifications = $this->renderWidget('displayNotificationSuccess', ['fsch_as_array' => true]);
        if ($success_notifications) {
            foreach ($success_notifications as $success_notification) {
                $this->context->controller->success[] = $success_notification;
            }
        }

        $info_notifications = $this->renderWidget('displayNotificationInfo', ['fsch_as_array' => true]);
        if ($info_notifications) {
            foreach ($info_notifications as $info_notification) {
                $this->context->controller->info[] = $info_notification;
            }
        }

        if (Configuration::get('FSCH_ENABLE_SMARTY')) {
            if (is_callable([$this->context->controller, 'getProduct'])) {
                $product = $this->context->controller->getProduct();
                if ($product->id_manufacturer) {
                    $manufacturer = new Manufacturer($product->id_manufacturer, $this->context->language->id);
                    $this->fshelper->smartyAssign(['manufacturer' => (array) $manufacturer]);
                }
                if ($product->id_supplier) {
                    $supplier = new Supplier($product->id_supplier, $this->context->language->id);
                    $this->fshelper->smartyAssign(['supplier' => (array) $supplier]);
                }
            }
        }

        // $this->fshelper->addCSS('fsch-font-awesome.min.css');
        // $this->fshelper->addCSS('front.css');
        // $this->fshelper->addJS('front.js');
        return $this->renderWidget('displayHeader', $params);
    }

    public function hookDisplayProductExtraContent($params)
    {
        $tabs = [];
        $blocks = $this->getWidgetVariables('displayProductExtraContent', $params);
        if ($blocks) {
            foreach ($blocks as $block) {
                $product_extra_content = new ProductExtraContent();
                $product_extra_content->setTitle($block['title']);
                $product_extra_content->setContent($this->getBlockFinalContent($block));
                $product_extra_content->addAttr(['id' => 'fsch-product-tab', 'class' => 'fsch-product-tab']);
                $tabs[] = $product_extra_content;
            }
        }

        return $tabs;
    }
}
