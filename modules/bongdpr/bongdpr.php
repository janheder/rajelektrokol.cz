<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta GDPR EU Cookie Law Banner
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 *  @author    Bonpresta
 *  @copyright 2015-2020 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once(_PS_MODULE_DIR_.'bongdpr/classes/ClassGdpr.php');

class Bongdpr extends Module
{
    public function __construct()
    {
        $this->name = 'bongdpr';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Bonpresta';
        $this->module_key = 'fb3a2d11a66d9c223d07d7114d352cf0';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('GDPR EU Cookie Law Banner');
        $this->description = $this->l('Display GDPR EU Cookie Law Banner');
        $this->confirmUninstall = $this->l('This module  Uninstall');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }


    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');
        $this->installSamples();
        $settings = $this->getModuleSettings();

        foreach ($settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        return parent::install() &&
        $this->registerHook('header') &&
        $this->registerHook('displayCustomBanner');
    }

    protected function installSamples()
    {
        $now = date('Y-m-d H:i:00');
        $languages = Language::getLanguages(false);
        $item = new ClassGdpr();
        $item->data_start = $now;
        $item->data_end = (new DateTime("+1 month"))->format("Y-m-d H:i:00");
        $item->id_shop = (int)$this->context->shop->id;

        foreach ($languages as $language) {
            $item->description[$language['id_lang']] = '<p>We use cookies to give you the best possible experience on our website. By clicking OK, you agree to our cookie policy. If you would like to change your cookie preferences you may do so</p>';
            $item->link[$language['id_lang']] = 'content/3-terms-and-conditions-of-use';
        }

        $item->add();
    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');

        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            Configuration::deleteByName($name);
        }

        return parent::uninstall();
    }

    protected function getModuleSettings()
    {
        $settings = array(
            'BON_GDPR_BACKGROUND' => '#3b3b3b',
            'BON_GDPR_OPACITY' => 0.9,
            'BON_GDPR_POSITION' => 'top',
            'BON_GDPR_STYLE' => 'style_2',
        );
        return $settings;
    }

    public function getContent()
    {

        $output = '';
        $result ='';

        if (((bool)Tools::isSubmit('submitBongdprSettingModule')) == true) {
            if (!$errors = $this->validateSettings()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Settings updated successful.'));
            } else {
                $output .= $errors;
            }
        }

        if ((bool)Tools::isSubmit('submitUpdateGdpr')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addGdpr();
            } else {
                $output = $result;
                $output .= $this->renderGdprForm();
            }
        }

        if (!$result) {
            $output .= $this->renderGdprForm();
            $output .= $this->renderFormSettings();
        }

        return $output;
    }

    protected function renderFormSettings()
    {
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitBongdprSettingModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&module_tab=1';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'image_path' => $this->_path.'views/img',
            'fields_value' => $this->getConfigFormValuesSettings(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Format'),
                        'name' => 'BON_GDPR_POSITION',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'top',
                                    'name' => $this->l('Top')),
                                array(
                                    'id' => 'bottom',
                                    'name' => $this->l('Bottom')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background:'),
                        'name' => 'BON_GDPR_BACKGROUND',
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Opacity:'),
                        'name' => 'BON_GDPR_OPACITY',
                        'col' => 1,
                        'required' => true,
                    ),
                    /*array(
                        'type' => 'select',
                        'label' => $this->l('Style:'),
                        'name' => 'BON_GDPR_STYLE',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'style_1',
                                    'name' => $this->l('Style 1')),
                                array(
                                    'id' => 'style_2',
                                    'name' => $this->l('Style 2')),
                                array(
                                    'id' => 'style_3',
                                    'name' => $this->l('Style 3')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),*/
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    protected function validateSettings()
    {
        $errors = array();

        if (!Validate::isColor(Tools::getValue('BON_GDPR_BACKGROUND'))) {
            $errors[] = $this->l('"Background" format error.');
        }

        if (Tools::isEmpty(Tools::getValue('BON_GDPR_OPACITY'))) {
            $errors[] = $this->l('Opacity is required.');
        } else {
            if (!Validate::isUnsignedFloat(Tools::getValue('BON_GDPR_OPACITY'))) {
                $errors[] = $this->l('Opacity limit format');
            }
        }

        if ($errors) {
            return $this->displayError(implode('<br />', $errors));
        } else {
            return false;
        }
    }

    protected function getConfigFormValuesSettings()
    {
        $filled_settings = array();
        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            $filled_settings[$name] = Configuration::get($name);
        }

        return $filled_settings;
    }

    protected function postProcess()
    {
        $form_values = $this->getConfigFormValuesSettings();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function renderGdprForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('GDPR'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Content'),
                        'name' => 'description',
                        'autoload_rte' => true,
                        'lang' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Link'),
                        'name' => 'link',
                        'lang' => true,
                    ),
                    array(
                        'type' => 'datetime',
                        'label' => $this->l('Start Date'),
                        'name' => 'data_start',
                        'col' => 6,
                        'required' => true
                    ),
                    array(
                        'type' => 'datetime',
                        'label' => $this->l('End Date'),
                        'name' => 'data_end',
                        'col' => 6,
                        'required' => true
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateGdpr';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name.'&module_tab=1';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigGdprFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigGdprFormValues()
    {
        $tab = new ClassGdpr(1);

        $fields_values = array(
            'link' => Tools::getValue('link', $tab->link),
            'data_start' => Tools::getValue('data_start', $tab->data_start),
            'data_end' => Tools::getValue('data_end', $tab->data_end),
        );

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $fields_values['description'][$lang['id_lang']] = Tools::getValue(
                'description_' . (int) $lang['id_lang'],
                isset($tab->description[$lang['id_lang']]) ? $tab->description[$lang['id_lang']] : ''
            );
        }

        return $fields_values;
    }

    protected function addGdpr()
    {
        $errors = array();
        $item = new ClassGdpr((int)Tools::getValue('module_tab'));

        $item->id_shop = (int)$this->context->shop->id;
        $item->data_start = Tools::getValue('data_start');
        $item->data_end = Tools::getValue('data_end');

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang']);
            $item->link[$language['id_lang']] = Tools::getValue('link_'.$language['id_lang']);
        }
        
        if (!$errors) {
            if (!$item->id_tab) {
                if (!$item->add()) {
                    return $this->displayError($this->l('The item could not be added.'));
                }
            } elseif (!$item->update()) {
                return $this->displayError($this->l('The item could not be updated.'));
            }

            return $this->displayConfirmation($this->l('The item is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    protected function preValidateForm()
    {
        $errors = array();

        $from = Tools::getValue('data_start');
        $to = Tools::getValue('data_end');

        if (Tools::isEmpty(Tools::getValue('data_start'))) {
            $errors[] = $this->l('The data start is required.');
        }

        if (Tools::isEmpty(Tools::getValue('data_end'))) {
            $errors[] = $this->l('The data end is required.');
        }

        if (!Validate::isDate($to) || !Validate::isDate($from)) {
            $errors[] = $this->l('Invalid date field');
        } elseif (strtotime($to) <= strtotime($from)) {
            $errors[] = $this->l('Invalid date range');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    public function hookHeader()
    {
        $this->context->controller->addCSS($this->_path.'views/css/gdpr_front.css');
        $this->context->controller->addJS($this->_path.'views/js/gdpr_front.js');
        $this->context->controller->addJS($this->_path.'views/js/jquery.cookie.js');
    }

    public function hookDisplayFooter()
    {
        $gdpr_front = new ClassGdpr();
        $tabs = $gdpr_front->getTopFrontGdpr($this->id_shop);
        $result = array();

        foreach ($tabs as $key => $tab) {
            $result[$key]['description'] = $tab['description'];
            $result[$key]['link'] = $tab['link'];
        }

        $this->context->smarty->assign('items', $result);

        if (_PS_VERSION_ >= 1.7) {
            $front_class = 'version_1_7';
        } else {
            $front_class = 'version_1_6';
        }

        $this->smarty->assign(array(
            'front_class' => $front_class,
            'front_background' => Configuration::get('BON_GDPR_BACKGROUND'),
            'front_opacity' => Configuration::get('BON_GDPR_OPACITY'),
            'front_position' => Configuration::get('BON_GDPR_POSITION'),
            'front_style_gdpr' => Configuration::get('BON_GDPR_STYLE'),
        ));

        return $this->display(__FILE__, 'views/templates/hook/gdpr-front.tpl');
    }

    public function hookdisplayCustomBanner()
    {
        return $this->hookDisplayFooter();
    }

    public function hookdisplayHome()
    {
        return $this->hookDisplayFooter();
    }
}
