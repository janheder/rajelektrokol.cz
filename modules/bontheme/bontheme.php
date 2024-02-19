<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Theme
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
 *  @copyright 2015-2021 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Bontheme extends Module
{
    public function __construct()
    {
        $this->name = 'bontheme';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Theme Settings');
        $this->description = $this->l('Enable theme settings');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    protected function getConfigurations()
    {
        $configurations = array(
            'THEME_ENABLE' => true,
            'THEME_STICKY_HEADER' => true,
            'THEME_STICKY_FOOTER' => true,
            'THEME_STICKY_CART' => true,
            'THEME_ENABLE_COLOR' => false,
            'THEME_ENABLE_DEMO' => false,
            'THEME_ENABLE_SETTINGS' => true,
            'THEME_ENABLE_LANGUAGE_SETTINGS' => true,
            'THEME_COLOR' => '#525252',
            'THEME_ENABLE_PROMO' => false,
            'THEME_PROMO' => '#motoHome',
            'THEME_PROMO_LINK' => '',
            'THEME_SELECTION_FONTS' => 'Inter'
        );

        return $configurations;
    }

    public function install()
    {
        $configurations = $this->getConfigurations();

        foreach ($configurations as $name => $config) {
            Configuration::updateValue($name, $config);
        }

        return parent::install() &&
            $this->registerHook('displayGridButton') &&
            $this->registerHook('displayWrapperBottom') &&
            $this->registerHook('displayTop') &&
            $this->registerHook('displayHeader');
    }

    public function uninstall()
    {
        $configurations = $this->getConfigurations();

        foreach (array_keys($configurations) as $config) {
            Configuration::deleteByName($config);
        }

        return parent::uninstall();
    }

    public function getContent()
    {
        $output = '';
        $result = '';

        if ((bool)Tools::isSubmit('submitSettings')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Save all settings.'));
            } else {
                $output = $result;
                $output .= $this->renderTabForm();
            }
        }

        if (!$result) {
            $output .= $this->renderTabForm();
        }

        return $output;
    }

    protected function renderTabForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Settings:'),
                        'name' => 'THEME_ENABLE_SETTINGS',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Sticky header:'),
                        'name' => 'THEME_STICKY_HEADER',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Sticky footer:'),
                        'name' => 'THEME_STICKY_FOOTER',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Sticky Cart:'),
                        'name' => 'THEME_STICKY_CART',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Language Settings:'),
                        'name' => 'THEME_ENABLE_LANGUAGE_SETTINGS',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Demo Color Picker:'),
                        'name' => 'THEME_ENABLE_DEMO',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Custom Color:'),
                        'name' => 'THEME_ENABLE_COLOR',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color theme:'),
                        'name' => 'THEME_COLOR',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Promo:'),
                        'name' => 'THEME_ENABLE_PROMO',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Code:'),
                        'name' => 'THEME_PROMO',
                        'col' => 2,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Link:'),
                        'name' => 'THEME_PROMO_LINK',
                        'col' => 2,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Select Theme Fonts:'),
                        'name' => 'THEME_SELECTION_FONTS',
                        'col' => 2,
                        'options' => array(
                            'query' => $this->getFonts(),
                            'id' => 'fonts_id_option',
                            'name' => 'name'
                        )
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
        $helper->submit_action = 'submitSettings';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getFonts()
    {
        $bonfonts = array(
            array('fonts_id_option' => 'Inter', 'name' => 'Inter'),
            array('fonts_id_option' => 'Lato', 'name' => 'Lato'),
            array('fonts_id_option' => 'Raleway', 'name' => 'Raleway'),
            array('fonts_id_option' => 'OpenSans', 'name' => 'OpenSans'),
            array('fonts_id_option' => 'Roboto', 'name' => 'Roboto'),
            array('fonts_id_option' => 'Ubuntu', 'name' => 'Ubuntu'),
            array('fonts_id_option' => 'Playfair', 'name' => 'Playfair'),
            array('fonts_id_option' => 'Lora', 'name' => 'Lora'),
            array('fonts_id_option' => 'Indie', 'name' => 'Indie'),
            array('fonts_id_option' => 'Hind', 'name' => 'Hind'),
        );

        return $bonfonts;
    }

    public function getConfigFieldsValues()
    {
        $fields = array();
        $configurations = $this->getConfigurations();

        foreach (array_keys($configurations) as $config) {
            $fields[$config] = Configuration::get($config);
        }

        return $fields;
    }

    protected function postProcess()
    {
        $form_values = $this->getConfigFieldsValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function preValidateForm()
    {
        $errors = array();

        if (!Validate::isColor(Tools::getValue('THEME_COLOR'))) {
            $errors[] = $this->l('Theme color format error.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    public function hookDisplayHeader()
    {

        Media::addJsDefL('theme_sticky_header', Configuration::get('THEME_STICKY_HEADER'));
        Media::addJsDefL('theme_sticky_footer', Configuration::get('THEME_STICKY_FOOTER'));
        Media::addJsDefL('theme_sticky_cart', Configuration::get('THEME_STICKY_CART'));
        Media::addJsDefL('theme_fonts', Configuration::get('THEME_SELECTION_FONTS'));

        $this->context->controller->addJS($this->_path . '/views/js/bontheme.js');
        $this->context->controller->addCSS($this->_path . '/views/css/bontheme.css');
    }

    public function hookDisplayFooter()
    {

//        if (Configuration::get('THEME_ENABLE_SETTINGS')) {
        $this->context->smarty->assign(array(
            'theme_color' => Configuration::get('THEME_COLOR'),
            'theme_color_enable' => Configuration::get('THEME_ENABLE_COLOR'),
            'theme_color_demo' => Configuration::get('THEME_ENABLE_DEMO'),
            'theme_enable_setting' => Configuration::get('THEME_ENABLE_SETTINGS'),
            'theme_sticky_footer' => Configuration::get('THEME_STICKY_FOOTER'),
            'theme_enable_promo' => Configuration::get('THEME_ENABLE_PROMO'),
            'theme_promo' => Configuration::get('THEME_PROMO'),
            'theme_promo_link' => Configuration::get('THEME_PROMO_LINK'),
        ));

        return $this->display($this->_path, '/views/templates/hook/bontheme.tpl');
//        }
    }

    public function hookdisplayWrapperBottom()
    {
        return $this->hookDisplayFooter();
    }

    public function hookDisplayTop()
    {
        if (Configuration::get('THEME_ENABLE_LANGUAGE_SETTINGS')) {
            return $this->display($this->_path, '/views/templates/hook/bontheme_language.tpl');
        }
    }
    public function hookdisplayGridButton()
    {
        return $this->display($this->_path, '/views/templates/hook/bontheme-grid-button.tpl');
    }
}