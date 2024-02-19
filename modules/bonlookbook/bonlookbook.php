<?php

/**
 * 2015-2022 Bonpresta
 *
 * Bonpresta Lookbook gallery with products and slider
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
 *  @copyright 2015-2022 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */
if (!defined('_PS_VERSION_')) {
    exit;
}
include_once _PS_MODULE_DIR_ . 'bonlookbook/classes/ClassBonlookbook.php';
include_once _PS_MODULE_DIR_ . 'bonlookbook/classes/ClassBonlookbookPoint.php';

class Bonlookbook extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bonlookbook';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Bonpresta';
        $this->module_key = '8694d0f0fb9ed9d364922d92ff18f478';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Lookbook gallery with products and slider');
        $this->description = $this->l(
            'Allows you to create a gallery of pictures with product marks, also using a slider for display.'
        );
        $this->confirmUninstall = $this->l('This module  Uninstall');
        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
        if (Configuration::get('PS_SSL_ENABLED')) {
            $this->ssl = 'https://';
        } else {
            $this->ssl = 'http://';
        }
    }

    public function createAjaxController()
    {
        $tab = new Tab();
        $tab->active = 1;
        $languages = Language::getLanguages(false);
        if (is_array($languages)) {
            foreach ($languages as $language) {
                $tab->name[$language['id_lang']] = 'bonlookbook';
            }
        }
        $tab->class_name = 'AdminAjaxBonlookbook';
        $tab->module = $this->name;
        $tab->id_parent = -1;

        return (bool) $tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int) Tab::getIdFromClassName('AdminAjaxBonlookbook')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {
        include dirname(__FILE__) . '/sql/install.php';
        $this->installSamples();
        $settings = $this->getModuleSettings();
        $slider_settings = $this->getModuleSliderSettings();

        foreach ($settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }
        foreach ($slider_settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        return parent::install() &&
            $this->registerHook('header') &&
            $this->createAjaxController() &&
            $this->registerHook('moduleRoutes') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayHome');
    }

    public function hookModuleRoutes()
    {
        $main_route = Configuration::get('BON_LOOKBOOK_MAIN_ROUTE') ?
            Configuration::get('BON_LOOKBOOK_MAIN_ROUTE') :
            'lookbook';

        return [
            'module-bonlookbook-main' => [
                'controller' => 'main',
                'rule' => $main_route,
                'keywords' => [],
                'params' => [
                    'fc' => 'module',
                    'module' => 'bonlookbook',
                ],
            ],
        ];
    }

    protected function installSamples()
    {
        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 3; ++$i) {
            $item = new ClassBonlookbook();
            $item->id_shop = (int) $this->context->shop->id;
            $item->status = 1;
            $item->sort_order = $i;
            $item->image = 'sample-' . $i . '.jpg';
            foreach ($languages as $language) {
                $item->title[$language['id_lang']] = 'Lookbook';
                $item->description[$language['id_lang']] = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco consequat.</p>';
            }
            $item->add();
        }
    }

    public function uninstall()
    {
        include dirname(__FILE__) . '/sql/uninstall.php';

        $settings = $this->getModuleSettings();
        $slider_settings = $this->getModuleSliderSettings();

        foreach (array_keys($settings) as $name) {
            Configuration::deleteByName($name);
        }
        foreach (array_keys($slider_settings) as $name) {
            Configuration::deleteByName($name);
        }

        return parent::uninstall()
            && $this->removeAjaxContoller();
    }

    protected function getModuleSettings()
    {
        $settings = [
            'BON_LOOKBOOK_MAIN_ROUTE' => 'lookbook',
            'BON_LOOKBOOK_TITLE_TEXT' => 'It\'s a small world. But not for you.',
            'BON_LOOKBOOK_HOME_LIMIT' => 4,
            'BON_LOOKBOOK_CUSTOM_PAGE_LIMIT' => 4,
            'BON_LOOKBOOK_TITLE' => true,
            'BON_LOOKBOOK_TITLE_CUSTOM_PAGE' => false,
            'BON_LOOKBOOK_SUBTITLE' => true,
            'BON_LOOKBOOK_SUBTITLE_CUSTOM_PAGE' => false,
            'BON_LOOKBOOK_TEXT_POSITION' => 'center',
            'BON_LOOKBOOK_TITLE_COLOR' => '#E5E5E5',
            'BON_LOOKBOOK_TITLE_HOVER_COLOR' => '#3a3a3a',
            'BON_LOOKBOOK_SUBTITLE_COLOR' => '#3a3a3a',
            'BON_LOOKBOOK_POINTER_COLOR' => '#fd450c',
            'BON_LOOKBOOK_HOME_ELEM_TITLE' => false,
            'BON_LOOKBOOK_CUSTOM_ELEM_TITLE' => false,
            'BON_LOOKBOOK_HOME_TEXT' => true,
            'BON_LOOKBOOK_CUSTOM_PAGE_TEXT' => false,
        ];

        return $settings;
    }

    protected function getModuleSliderSettings()
    {
        $settings = [
            'BON_LOOKBOOK_PAGE_SLIDER_DISPLAY_CAROUSEL' => false,
            'BON_LOOKBOOK_SLIDER_DISPLAY_CAROUSEL' => true,
            'BON_LOOKBOOK_SLIDER_AUTOPLAYTIME' => 9000,
            'BON_LOOKBOOK_SLIDER_SPEED' => 800,
            'BON_LOOKBOOK_SLIDER_AUTOPLAY' => true,
            'BON_LOOKBOOK_SLIDER_LOOP' => true,
            'BON_LOOKBOOK_SLIDER_DRAG' => true,
            'BON_LOOKBOOK_SLIDER_NAV' => true,
        ];

        return $settings;
    }

    public function getContent()
    {
        $output = '';
        $result = '';

        if (((bool) Tools::isSubmit('submitBonlookbookSliderSettingsModule')) == true) {
            if (!$errors = $this->validateSliderSettings()) {
                $this->sliderFormProcess();
                $output .= $this->displayConfirmation($this->l('Slider settings updated successful.'));
            } else {
                $output .= $errors;
            }
        } elseif (((bool) Tools::isSubmit('submitBonlookbookSettingModule')) == true) {
            if (!$errors = $this->validateSettings()) {
                $this->generalSettingsProcess();
                $output .= $this->displayConfirmation($this->l('Settings updated successful.'));
            } else {
                $output .= $errors;
            }
        } elseif ((bool) Tools::isSubmit('submitUpdateBonlookbook')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addBonlookbook();
            } else {
                $output = $result;
                $output .= $this->renderBonlookbookForm();
            }
        } elseif ((bool) Tools::isSubmit('submitUpdateBonlookbookPoint')) {
            if (!$result = $this->preValidateFormPoint()) {
                $output .= $this->addBonlookbookPoint();
            } else {
                $output = $result;
                $output .= $this->renderBonlookbookPointForm();
            }
        }
        if (Tools::getIsset('updatebonlookbook') || Tools::getValue('updatebonlookbook')) {
            $output .= $this->renderBonlookbookForm();
        } elseif ((bool) Tools::isSubmit('addbonlookbook')) {
            $output .= $this->renderBonlookbookForm();
        } elseif ((bool) Tools::isSubmit('viewbonlookbook')) {
            $output .= $this->renderBonlookbookPointList();
        } elseif (Tools::getIsset('updatebonlookbook_point') || Tools::getValue('updatebonlookbook_point')) {
            $output .= $this->renderBonlookbookPointForm();
        } elseif ((bool) Tools::isSubmit('addbonlookbookpoint')) {
            $output .= $this->renderBonlookbookPointForm();
        } elseif ((bool) Tools::isSubmit('statusbonlookbook')) {
            $output .= $this->updateStatusTab();
            $output .= $this->renderBonlookbookList();
            $output .= $this->renderFormSettings();
            $output .= $this->renderFormSliderSettings();
        } elseif ((bool) Tools::isSubmit('statusbonlookbook_point')) {
            $output .= $this->updateStatusPoint();
            $output .= $this->renderBonlookbookPointList();
        } elseif ((bool) Tools::isSubmit('deletebonlookbook')) {
            $output .= $this->deleteBonlookbook();
            $output .= $this->renderBonlookbookList();
            $output .= $this->renderFormSettings();
            $output .= $this->renderFormSliderSettings();
        } elseif ((bool) Tools::isSubmit('deletebonlookbook_point')) {
            $output .= $this->deleteBonlookbookPoint();
            $output .= $this->renderBonlookbookPointList();
        } elseif (!$result) {
            $output .= $this->renderBonlookbookList();
            $output .= $this->renderFormSettings();
            $output .= $this->renderFormSliderSettings();
        }

        return $output;
    }

    protected function renderFormSliderSettings()
    {
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitBonlookbookSliderSettingsModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = [
            'image_path' => $this->_path . 'views/img',
            'fields_value' => $this->getConfigSliderFormValuesSettings(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        ];

        return $helper->generateForm([$this->getConfigSliderForm()]);
    }

    protected function getConfigSliderForm()
    {
        return [
            'form' => [
                'legend' => [
                    'title' => $this->l('Slider Settings'),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'switch',
                        'label' => $this->l('Carousel on a separate page:'),
                        'name' => 'BON_LOOKBOOK_PAGE_SLIDER_DISPLAY_CAROUSEL',
                        'desc' => $this->l('Activates the carousel on the module page.'),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Carousel on home page:'),
                        'name' => 'BON_LOOKBOOK_SLIDER_DISPLAY_CAROUSEL',
                        'desc' => $this->l('Activates the display of the slide carousel.'),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'form_group_class' => 'display-slider-block',
                        'type' => 'switch',
                        'label' => $this->l('Slider autoplay:'),
                        'name' => 'BON_LOOKBOOK_SLIDER_AUTOPLAY',
                        'desc' => $this->l('Activates automatic slide play.'),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'form_group_class' => 'display-slider-block',
                        'type' => 'text',
                        'label' => $this->l('Slideshow speed:'),
                        'name' => 'BON_LOOKBOOK_SLIDER_SPEED',
                        'col' => 2,
                        'required' => true,
                    ], [
                        'form_group_class' => 'display-slider-block',
                        'type' => 'text',
                        'label' => $this->l('Automatic switching speed:'),
                        'name' => 'BON_LOOKBOOK_SLIDER_AUTOPLAYTIME',
                        'desc' => $this->l(
                            'The slide will switch at a given speed
                             (if the autoplay option is active).'
                        ),
                        'col' => 2,
                        'required' => true,
                    ],
                    [
                        'form_group_class' => 'display-slider-block',
                        'type' => 'switch',
                        'label' => $this->l('Drag-and-drop slide switching:'),
                        'name' => 'BON_LOOKBOOK_SLIDER_DRAG',
                        'desc' => $this->l('Enables drag-and-drop slide switching.'),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'form_group_class' => 'display-slider-block',
                        'type' => 'switch',
                        'label' => $this->l('Loop:'),
                        'name' => 'BON_LOOKBOOK_SLIDER_LOOP',
                        'desc' => $this->l('Infinity loop. Duplicate last and first items to get loop illusion.'),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'form_group_class' => 'display-slider-block',
                        'type' => 'switch',
                        'label' => $this->l('Nav:'),
                        'name' => 'BON_LOOKBOOK_SLIDER_NAV',
                        'desc' => $this->l('Show next/prev buttons.'),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];
    }

    protected function validateSliderSettings()
    {
        $errors = [];

        if (Tools::isEmpty(Tools::getValue('BON_LOOKBOOK_SLIDER_AUTOPLAYTIME'))) {
            $errors[] = $this->l('The "Automatic switching speed" field is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_LOOKBOOK_SLIDER_AUTOPLAYTIME'))) {
                $errors[] = $this->l('The "Automatic switching speed" field must be a numeric value.');
            }
        }
        if (Tools::isEmpty(Tools::getValue('BON_LOOKBOOK_SLIDER_SPEED'))) {
            $errors[] = $this->l('The "Slideshow speed" field is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_LOOKBOOK_SLIDER_SPEED'))) {
                $errors[] = $this->l('The "Slideshow speed" field must be a numeric value.');
            }
        }

        if ($errors) {
            return $this->displayError(implode('<br />', $errors));
        } else {
            return false;
        }
    }

    protected function sliderFormProcess()
    {
        $form_values = $this->getConfigSliderFormValuesSettings();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function getConfigSliderFormValuesSettings()
    {
        $filled_settings = [];
        $settings = $this->getModuleSliderSettings();

        foreach (array_keys($settings) as $name) {
            $filled_settings[$name] = Configuration::get($name);
        }

        return $filled_settings;
    }

    protected function getBonlookbookSliderSettings()
    {
        $settings = $this->getModuleSliderSettings();
        $get_settings = [];
        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = ['value' => $data, 'type' => $this->getStringValueType($data)];
        }

        return $get_settings;
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
        $helper->submit_action = 'submitBonlookbookSettingModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = [
            'image_path' => $this->_path . 'views/img',
            'fields_value' => $this->getConfigFormValuesSettings(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        ];

        return $helper->generateForm([$this->getConfigForm()]);
    }

    protected function getConfigForm()
    {
        return [
            'form' => [
                'legend' => [
                    'title' => $this->l('General Settings'),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('URL path to lookbook page'),
                        'name' => 'BON_LOOKBOOK_MAIN_ROUTE',
                        'desc' => $this->l('Page link looks like this: ' .
                            _PS_BASE_URL_ . '/' . Configuration::get('BON_LOOKBOOK_MAIN_ROUTE')),
                        'col' => 2,
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Section title'),
                        'name' => 'BON_LOOKBOOK_TITLE_TEXT',
                        'desc' => $this->l('to be the theme color, wrap it with a <span>text</span> tag'),
                        'col' => 3,
                        'required' => true,
                    ],
                    [
                        'form_group_class' => 'display-slider-block',
                        'type' => 'text',
                        'label' => $this->l('Number of items on home'),
                        'desc' => $this->l('Sets a limit on the number of items displayed on the home page.'),
                        'name' => 'BON_LOOKBOOK_HOME_LIMIT',
                        'col' => 2,
                        'required' => true,
                    ],
                    [
                        'form_group_class' => 'display-slider-block',
                        'type' => 'text',
                        'label' => $this->l('Number of elements on a separate page'),
                        'desc' => $this->l('Sets a limit on the number of ' .
                                                 'displayed elements on a separate page of the module.'),
                        'name' => 'BON_LOOKBOOK_CUSTOM_PAGE_LIMIT',
                        'col' => 2,
                        'required' => true,
                    ],
                    [
                        'form_group_class' => 'title-color',
                        'type' => 'color',
                        'label' => $this->l('Pointer background color:'),
                        'name' => 'BON_LOOKBOOK_POINTER_COLOR',
                        'required' => true,
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->l('Header text position'),
                        'name' => 'BON_LOOKBOOK_TEXT_POSITION',
                        'desc' => $this->l('Sets the positioning of the text in the section header.'),
                        'col' => 2,
                        'options' => [
                            'query' => [
                                [
                                    'id' => 'left',
                                    'name' => $this->l('Left')],
                                [
                                    'id' => 'center',
                                    'name' => $this->l('Center')],
                                [
                                    'id' => 'right',
                                    'name' => $this->l('Right')],
                            ],
                            'id' => 'id',
                            'name' => 'name',
                        ],
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Title on home:'),
                        'desc' => $this->l('Allows to display the section title on the home page.'),
                        'name' => 'BON_LOOKBOOK_TITLE',
                        'values' => [
                            [
                                'id' => 'title_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'title_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Title on a separate page:'),
                        'desc' => $this->l('Allows displaying the section title on a separate page of the module.'),
                        'name' => 'BON_LOOKBOOK_TITLE_CUSTOM_PAGE',
                        'values' => [
                            [
                                'id' => 'title_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'title_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'type' => 'color',
                        'label' => $this->l('Title color:'),
                        'desc' => $this->l('Sets the color of the section header.'),
                        'name' => 'BON_LOOKBOOK_TITLE_COLOR',
                        'required' => true,
                    ],
                    [
                        'type' => 'color',
                        'label' => $this->l('Title hover color:'),
                        'desc' => $this->l('Sets the hover color of the section header.'),
                        'name' => 'BON_LOOKBOOK_TITLE_HOVER_COLOR',
                        'required' => true,
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Display the section subtitle on home:'),
                        'desc' => $this->l('Allows to display the section subtitle on the home page.'),
                        'name' => 'BON_LOOKBOOK_SUBTITLE',
                        'values' => [
                            [
                                'id' => 'subtitle_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'subtitle_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Subtitle on a separate page:'),
                        'desc' => $this->l('Allows displaying the section subtitle on a separate page of the module.'),
                        'name' => 'BON_LOOKBOOK_SUBTITLE_CUSTOM_PAGE',
                        'values' => [
                            [
                                'id' => 'subtitle_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'subtitle_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'form_group_class' => 'subtitle-color',
                        'type' => 'color',
                        'label' => $this->l('Subtitle color:'),
                        'desc' => $this->l('Sets the color of the section subtitle.'),
                        'name' => 'BON_LOOKBOOK_SUBTITLE_COLOR',
                        'required' => true,
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Display element title on home:'),
                        'desc' => $this->l('Responsible for displaying the title of the elements on the home page.'),
                        'name' => 'BON_LOOKBOOK_HOME_ELEM_TITLE',
                        'values' => [
                            [
                                'id' => 'title_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'title_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ], [
                        'type' => 'switch',
                        'label' => $this->l('Display element title on a separate page:'),
                        'desc' => $this->l('Responsible for displaying the title of the ' .
                                                 'elements on a separate page of the module.'),
                        'name' => 'BON_LOOKBOOK_CUSTOM_ELEM_TITLE',
                        'values' => [
                            [
                                'id' => 'title_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'title_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ], [
                        'type' => 'switch',
                        'label' => $this->l('Display element text on home:'),
                        'desc' => $this->l('Responsible for displaying the text of the elements on the home page.'),
                        'name' => 'BON_LOOKBOOK_HOME_TEXT',
                        'values' => [
                            [
                                'id' => 'title_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'title_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Display element text on a separate page:'),
                        'desc' => $this->l('Responsible for displaying the text of the ' .
                                                 'elements on a separate page of the module.'),
                        'name' => 'BON_LOOKBOOK_CUSTOM_PAGE_TEXT',
                        'values' => [
                            [
                                'id' => 'title_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'title_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];
    }

    protected function validateSettings()
    {
        $errors = [];
        if (Tools::isEmpty(Tools::getValue('BON_LOOKBOOK_MAIN_ROUTE'))) {
            $errors[] = $this->l('The "URL path to lookbook page" field is required.');
        }
        if (Tools::isEmpty(Tools::getValue('BON_LOOKBOOK_HOME_LIMIT'))) {
            $errors[] = $this->l('The "Number of items on home" field is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_LOOKBOOK_HOME_LIMIT'))) {
                $errors[] = $this->l('The "Number of items on home" field must be a numeric value.');
            }
        }
        if (Tools::isEmpty(Tools::getValue('BON_LOOKBOOK_CUSTOM_PAGE_LIMIT'))) {
            $errors[] = $this->l('The "Number of elements on a separate page" field is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_LOOKBOOK_CUSTOM_PAGE_LIMIT'))) {
                $errors[] = $this->l('The "Number of elements on a separate page" field must be a numeric value.');
            }
        }
        if (!Validate::isColor(Tools::getValue('BON_LOOKBOOK_TITLE_COLOR'))) {
            $errors[] = $this->l('"Title color" format error.');
        }
        if (!Validate::isColor(Tools::getValue('BON_LOOKBOOK_POINTER_COLOR'))) {
            $errors[] = $this->l('"Pointer background color" format error.');
        }
        if (!Validate::isColor(Tools::getValue('BON_LOOKBOOK_SUBTITLE_COLOR'))) {
            $errors[] = $this->l('"Subtitle color" format error.');
        }
        if ($errors) {
            return $this->displayError(implode('<br />', $errors));
        } else {
            return false;
        }
    }

    protected function getConfigFormValuesSettings()
    {
        $filled_settings = [];
        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            $filled_settings[$name] = Configuration::get($name);
        }

        return $filled_settings;
    }

    protected function getStringValueType($string)
    {
        if (Validate::isInt($string)) {
            return 'int';
        } elseif (Validate::isFloat($string)) {
            return 'float';
        } elseif (Validate::isBool($string)) {
            return 'bool';
        } else {
            return 'string';
        }
    }

    protected function generalSettingsProcess()
    {
        $form_values = $this->getConfigFormValuesSettings();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function getBonlookbookSettings()
    {
        $settings = $this->getModuleSettings();
        $get_settings = [];
        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = ['value' => $data, 'type' => $this->getStringValueType($data)];
        }

        return $get_settings;
    }

    // Slider Category Settings
    protected function renderBonlookbookForm()
    {
        $fields_form = [
            'form' => [
                'legend' => [
                    'title' => ((int) Tools::getValue('id_tab') ?
                        $this->l('Update item') :
                        $this->l('Add item')),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Name'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 3,
                    ],
                    [
                        'type' => 'textarea',
                        'label' => $this->l('Description'),
                        'name' => 'description',
                        'autoload_rte' => true,
                        'lang' => true,
                    ],
                    [
                        'type' => 'files_lang',
                        'label' => $this->l('Image'),
                        'name' => 'image',
                        'lang' => false,
                        'col' => 6,
                        'required' => true,
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name' => 'status',
                        'is_bool' => true,
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'col' => 2,
                        'type' => 'text',
                        'name' => 'sort_order',
                        'class' => 'hidden',
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
                'buttons' => [
                    [
                        'href' => AdminController::$currentIndex . '&configure=' .
                            $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back',
                    ],
                ],
            ],
        ];

        if ((bool) Tools::getIsset('updatebonlookbook') && (int) Tools::getValue('id_tab') > 0) {
            $tab = new ClassBonlookbook((int) Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = ['type' => 'hidden', 'name' => 'id_tab', 'value' => (int) $tab->id];
            $fields_form['form']['images'] = $tab->image;
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonlookbook';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = [
            'fields_value' => $this->getConfigBonlookbookFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
            'role' => 'parent',
        ];

        return $helper->generateForm([$fields_form]);
    }

    protected function getConfigBonlookbookFormValues()
    {
        if ((bool) Tools::getIsset('updatebonlookbook') && (int) Tools::getValue('id_tab') > 0) {
            $tab = new ClassBonlookbook((int) Tools::getValue('id_tab'));
        } else {
            $tab = new ClassBonlookbook();
        }

        $fields_values = [
            'id_tab' => Tools::getValue('id_tab'),
            'title' => Tools::getValue('title', $tab->title),

            'image' => Tools::getValue('image', $tab->image),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
        ];

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $fields_values['description'][$lang['id_lang']] = Tools::getValue(
                'description_' . (int) $lang['id_lang'],
                isset($tab->description[$lang['id_lang']]) ? $tab->description[$lang['id_lang']] : ''
            );
        }

        return $fields_values;
    }

    public function renderBonlookbookList()
    {
        if (!$tabs = ClassBonlookbook::getBonlookbookList()) {
            $tabs = [];
        }

        $fields_list = [
            'id_tab' => [
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ],
            'title' => [
                'title' => $this->l('Title'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ],
            'images' => [
                'title' => $this->l('Label'),
                'type' => 'box_image_category',
                'align' => 'center',
                'search' => false,
            ],
            'status' => [
                'title' => $this->l('Status'),
                'type' => 'bool',
                'active' => 'status',
                'search' => false,
                'orderby' => false,
            ],
            'sort_order' => [
                'title' => $this->l('Position'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
                'class' => 'pointer dragHandle',
            ],
        ];

        $helper = new HelperList();

        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_tab';
        $helper->table = 'bonlookbook';
        $helper->actions = ['view', 'edit', 'delete'];
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->displayName;
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = [
            'href' => AdminController::$currentIndex
                . '&configure=' . $this->name . '&add' . $this->name
                . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Add new item'),
        ];
        $helper->currentIndex = AdminController::$currentIndex
            . '&configure=' . $this->name . '&id_shop=' . (int) $this->context->shop->id;

        $helper->tpl_vars = [
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
        ];

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addBonlookbook()
    {
        $errors = [];

        if ((int) Tools::getValue('id_tab') > 0) {
            $item = new ClassBonlookbook((int) Tools::getValue('id_tab'));
        } else {
            $item = new ClassBonlookbook();
        }

        $item->id_shop = (int) $this->context->shop->id;
        $item->status = (int) Tools::getValue('status');

        if ((int) Tools::getValue('id_tab') > 0) {
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item->sort_order = $item->getMaxSortOrder((int) $this->id_shop);
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_' . $language['id_lang']);
            $item->description[$language['id_lang']] = Tools::getValue('description_' . $language['id_lang']);
        }
        $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image']['name'], '.'), 1));
        

        $imagesize = @getimagesize($_FILES['image']['tmp_name']);
        if (isset($_FILES['image'])
            && isset($_FILES['image']['tmp_name'])
            && !empty($_FILES['image']['tmp_name'])
            && !empty($imagesize)
            && in_array(
                Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)),
                array('jpg', 'gif', 'jpeg', 'png')
            )
            && in_array($type, array('jpg', 'gif', 'jpeg', 'png'))) {

            $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
            $salt = sha1(microtime());
            if ($error = ImageManager::validateUpload($_FILES['image'])) {
                $errors[] = $error;
            } elseif (!$temp_name || !move_uploaded_file($_FILES['image']['tmp_name'], $temp_name)) {
                return false;
            } elseif (!ImageManager::resize($temp_name, dirname(__FILE__).
                '/views/img/'.$salt.'_'.$_FILES['image']['name'], null, null, $type)) {
                $errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
            }

            if (isset($temp_name)) {
                @unlink($temp_name);
            }
            $item->image = $salt.'_'.$_FILES['image']['name'];
        } elseif (Tools::getValue('image_old') != '') {
            $item->image = Tools::getValue('image_old');
        }

        if (!$errors) {
            if (!Tools::getValue('id_tab')) {
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
        $errors = [];
        $languages = Language::getLanguages(false);

        $class = new ClassBonlookbook((int) Tools::getValue('id_tab'));

        $imageexists = @getimagesize($_FILES['image']['tmp_name']);
        $old_image = $class->image;
        $id_lang_default = (int) Configuration::get('PS_LANG_DEFAULT');

        if (!$old_image && (!isset($_FILES['image']) ||
        Tools::isEmpty($_FILES['image']['tmp_name']))) {
            $errors[] = $this->l('The file is required.');
        }

        if (!Tools::isEmpty($_FILES['image']['type'])) {
            if (ImageManager::validateUpload($_FILES['image'], 4000000)) {
                $errors[] = $this->l('Image format not recognized, allowed format is: .gif, .jpg, .png');
            }
        }

        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The name of slider is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad name of slider format.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function deleteBonlookbook()
    {
        $tab = new ClassBonlookbook(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if ($tab->delete()) {
            $tabs = ClassBonlookbookPoint::getBonlookbookPointList((int) Tools::getValue('id_tab'));
            if ($tabs) {
                foreach ($tabs as $tab) {
                    $tab = new ClassBonlookbookPoint($tab['id_tab']);
                    $tab->delete();
                }
            }

            $this->_confirmations = $this->l('Slider deleted.');
        }

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassBonlookbook(Tools::getValue('id_tab'));

        if (1 == $tab->status) {
            $tab->status = 0;
        } else {
            $tab->status = 1;
        }

        if (!$tab->update()) {
            return $this->displayError($this->l('The tab status could not be updated.'));
        }

        return $this->displayConfirmation($this->l('The tab status is successfully updated.'));
    }

    // Slider Subcategory Settings
    protected function renderBonlookbookPointForm()
    {
        $fields_form = [
            'form' => [
                'legend' => [
                    'title' => ((int) Tools::getValue('id_sub') ?
                        $this->l('Update pointer') :
                        $this->l('Add pointer')),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'select_product',
                        'label' => $this->l('Select a product:'),
                        'class' => 'id_product',
                        'required' => true,
                        'name' => 'id_product',
                    ],
                    [
                        'col' => 2,
                        'type' => 'text',
                        'name' => 'id_tab',
                        'class' => 'hidden',
                    ],
                    [
                        'type' => 'text',
                        'name' => 'top',
                        'default' => 50,
                        'class' => 'hidden',
                        'required' => true,
                        'col' => 2,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'left',
                        'default' => 50,
                        'class' => 'hidden',
                        'required' => true,
                        'col' => 3,
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name' => 'status',
                        'is_bool' => true,
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'col' => 2,
                        'type' => 'text',
                        'name' => 'sort_order',
                        'class' => 'hidden',
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                    'type' => 'submit',
                ],
                'buttons' => [
                    [
                        'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&viewbonlookbook&id_tab=' .
                            Tools::getValue('id_tab') . '&token=' . Tools::getAdminTokenLite('AdminModules') .
                            '&id_shop=' . (int) $this->context->shop->id,
                        'title' => $this->l('Cancel'),
                        'icon' => 'process-icon-cancel',
                    ],
                    [
                        'href' => AdminController::$currentIndex . '&configure=' . $this->name .
                            '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to main page'),
                        'icon' => 'process-icon-back',
                    ],
                ],
            ],
        ];

        $tab = new ClassBonlookbookPoint((int) Tools::getValue('id_sub'));

        if ((bool) Tools::getIsset('updatebonlookbook_point') && (int) Tools::getValue('id_sub') > 0) {
            $fields_form['form']['input'][] = ['type' => 'hidden', 'name' => 'id_sub', 'value' => (int) $tab->id];
        }

        $parent = new ClassBonlookbook((int) Tools::getValue('id_tab'));
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $this->_path . 'views/img/' . $parent->image)) {
            $fields_form['form']['images'] = $parent->image;
            $fields_form['form']['images_size'] = getimagesize($_SERVER['DOCUMENT_ROOT'] .
                $this->_path . 'views/img/' . $parent->image);
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonlookbookPoint';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = [
            'fields_value' => $this->getConfigBonlookbookPointFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'image_baseurl' => $this->_path . 'views/img/',
            'id_language' => $this->context->language->id,
            'role' => 'child',
            'base_dir' => $this->ssl,
            'link' => new Link(),
            'point_top' => $tab->top,
            'point_left' => $tab->left,
        ];

        return $helper->generateForm([$fields_form]);
    }

    protected function getConfigBonlookbookPointFormValues()
    {
        if ((bool) Tools::getIsset('updatebonlookbook_point') && (int) Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonlookbookPoint((int) Tools::getValue('id_sub'));
        } else {
            $tab = new ClassBonlookbookPoint();
        }
        $fields_values = [
            'id_tab' => Tools::getValue('id_tab'),
            'id_sub' => Tools::getValue('id_sub'),
            'product_name' => Tools::getValue('product_name', ClassBonlookbookPoint::getProductName($tab->id_product)),
            'link_rewrite' => Tools::getValue('link_rewrite', ClassBonlookbookPoint::getProductLinkRewrite(
                $tab->id_product
            )),
            'id_product' => Tools::getValue('id_product', $tab->id_product),
            'top' => Tools::getValue('top', $tab->top),
            'left' => Tools::getValue('left', $tab->left),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
        ];

        return $fields_values;
    }

    public function renderBonlookbookPointList()
    {
        if (!$tabs = ClassBonlookbookPoint::getBonlookbookPointList(Tools::getValue('id_tab'))) {
            $tabs = [];
        }

        $fields_list = [
            'id_sub' => [
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ],
            'block_image' => [
                'title' => $this->l('Product image'),
                'type' => 'block_image',
                'align' => 'center',
                'search' => false,
            ],
            'id_tab' => [
                'title' => $this->l('Id tab'),
                'type' => 'text',
                'class' => 'hidden id_tab',
                'search' => false,
                'orderby' => false,
            ],
            'status' => [
                'title' => $this->l('Status'),
                'type' => 'bool',
                'active' => 'status',
                'search' => false,
                'orderby' => false,
            ],
            'sort_order' => [
                'title' => $this->l('Position'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
                'class' => 'pointer dragHandle',
            ],
        ];

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_sub';
        $helper->table = 'bonlookbook_point';
        $helper->actions = ['edit', 'delete'];
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->displayName;
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = [
            'href' => AdminController::$currentIndex
                . '&configure=' . $this->name . '&add' . $this->name . 'point'
                . '&token=' . Tools::getAdminTokenLite('AdminModules')
                . '&id_shop=' . (int) $this->context->shop->id
                . '&id_tab=' . Tools::getValue('id_tab'),
            'desc' => $this->l('Add new pointer'),
        ];
        $helper->toolbar_btn['back'] = [
            'href' => AdminController::$currentIndex . '&configure=' . $this->name .
                '&token=' . Tools::getAdminTokenLite('AdminModules') . '&id_shop=' . (int) $this->context->shop->id,
            'desc' => $this->l('Back to main page'),
        ];
        $helper->currentIndex = AdminController::$currentIndex
            . '&configure=' . $this->name . '&id_shop=' .
            (int) $this->context->shop->id . '&id_tab=' . Tools::getValue('id_tab');

        $helper->tpl_vars = [
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'ps_version' => _PS_VERSION_,
            'pr_img_dir' => _THEME_PROD_DIR_,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'images/',
        ];

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addBonlookbookPoint()
    {
        $errors = [];

        if ((int) Tools::getValue('id_sub') > 0) {
            $item = new ClassBonlookbookPoint((int) Tools::getValue('id_sub'));
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item = new ClassBonlookbookPoint();
            $item->sort_order = $item->getMaxSortOrder((int) Tools::getValue('id_tab'));
        }

        $item->id_shop = (int) $this->context->shop->id;
        $item->id_tab = (int) Tools::getValue('id_tab');
        $item->id_product = (int) Tools::getValue('id_product');
        $item->status = (int) Tools::getValue('status');
        $item->top = (int) Tools::getValue('top');
        $item->left = (int) Tools::getValue('left');

        if (!$errors) {
            if (!Tools::getValue('id_sub')) {
                if (!$item->add()) {
                    return $this->displayError($this->l('The item could not be added.'));
                }
            } elseif (!$item->update()) {
                return $this->displayError($this->l('The item could not be updated.'));
            }

            return $this->displayConfirmation($this->l('The subcategory is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    protected function preValidateFormPoint()
    {
        $errors = [];
        $languages = Language::getLanguages(false);

        $class = new ClassBonlookbookPoint((int) Tools::getValue('id_sub'));

        if (Tools::isEmpty(Tools::getValue('top'))) {
            $errors[] = $this->l('The "Top" field is required.');
        } elseif (!Validate::isInt(Tools::getValue('top'))) {
            $errors[] = $this->l('The "Top" coordinate can only be numeric.');
        }
        if (Tools::isEmpty(Tools::getValue('id_product'))) {
            $errors[] = $this->l('The product is required.');
        }
        if (Tools::isEmpty(Tools::getValue('left'))) {
            $errors[] = $this->l('The "Left" field is required.');
        } elseif (!Validate::isInt(Tools::getValue('left'))) {
            $errors[] = $this->l('The "Left" coordinate can only be numeric.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function deleteBonlookbookPoint()
    {
        $tab = new ClassBonlookbookPoint(Tools::getValue('id_sub'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the point'));
        }

        return $this->displayConfirmation($this->l('The point is successfully deleted'));
    }

    protected function updateStatusPoint()
    {
        $tab = new ClassBonlookbookPoint(Tools::getValue('id_sub'));

        if (1 == $tab->status) {
            $tab->status = 0;
        } else {
            $tab->status = 1;
        }

        if (!$tab->update()) {
            return $this->displayError($this->l('The subcategory status could not be updated.'));
        }

        return $this->displayConfirmation($this->l('The subcategory status is successfully updated.'));
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') != $this->name) {
            return;
        }
        Media::addJsDefL('file_theme_url', $this->_path);
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBonlookbook'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBonlookbook'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.draggable');
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path . 'views/js/bonlookbook_back.js');
        $this->context->controller->addCSS($this->_path . 'views/css/bonlookbook_back.css');
    }

    public function hookHeader()
    {
        Media::addJsDefL('BON_LOOKBOOK_SLIDER_DISPLAY_CAROUSEL', Configuration::get(
            'BON_LOOKBOOK_SLIDER_DISPLAY_CAROUSEL'
        ));
        Media::addJsDefL('BON_LOOKBOOK_PAGE_SLIDER_DISPLAY_CAROUSEL', Configuration::get(
            'BON_LOOKBOOK_PAGE_SLIDER_DISPLAY_CAROUSEL'
        ));
        Media::addJsDefL('BON_LOOKBOOK_SLIDER_AUTOPLAY', Configuration::get('BON_LOOKBOOK_SLIDER_AUTOPLAY'));
        Media::addJsDefL('BON_LOOKBOOK_SLIDER_LOOP', Configuration::get('BON_LOOKBOOK_SLIDER_LOOP'));
        Media::addJsDefL('BON_LOOKBOOK_SLIDER_AUTOPLAYTIME', Configuration::get('BON_LOOKBOOK_SLIDER_AUTOPLAYTIME'));
        Media::addJsDefL('BON_LOOKBOOK_SLIDER_SPEED', Configuration::get('BON_LOOKBOOK_SLIDER_SPEED'));
        Media::addJsDefL('BON_LOOKBOOK_SLIDER_DRAG', Configuration::get('BON_LOOKBOOK_SLIDER_DRAG'));

        if (Configuration::get('BON_LOOKBOOK_SLIDER_DISPLAY_CAROUSEL') &&
            'index' === $this->context->controller->php_self ||
            Configuration::get('BON_LOOKBOOK_PAGE_SLIDER_DISPLAY_CAROUSEL') &&
            'index' !== $this->context->controller->php_self) {
            $this->context->controller->addJS($this->_path . 'views/js/swiper-bundle.min.js');
            $this->context->controller->addCSS($this->_path . 'views/css/swiper-bundle.min.css', 'all');
        }

        $this->context->controller->addJS($this->_path . '/views/js/bonlookbook_front.js');
        $this->context->controller->addCSS($this->_path . '/views/css/bonlookbook_front.css');

        $this->context->smarty->assign('settingslb', $this->getBonlookbookSettings());
        $this->context->smarty->assign('slider_settings', $this->getBonlookbookSliderSettings());

        return $this->display($this->_path, '/views/templates/hook/bonlookbook-header.tpl');
    }

    public function hookDisplayHome()
    {
        $bonlookbook_front = new ClassBonlookbook();
        $tabs = $bonlookbook_front->getTopFrontItems($this->id_shop, true);
        $result = [];
        $points = [];

        foreach ($tabs as $key => $tab) {
            $points_arr = ClassBonlookbookPoint::getTopFrontItems((int) $tab['id_tab']);
            $result[$key]['id'] = $tab['id_tab'];
            $result[$key]['title'] = $tab['title'];
            $result[$key]['description'] = $tab['description'];
            $result[$key]['image'] = $tab['image'];
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $this->_path . 'views/img/' . $tab['image'])) {
                $result[$key]['image_size'] = getimagesize($_SERVER['DOCUMENT_ROOT'] . $this->_path .
                    'views/img/' . $tab['image']);
            }
            $result[$key]['subitems'] = ClassBonlookbookPoint::getTopFrontItems((int) $tab['id_tab']);

            foreach ($points_arr as $k => $point) {
                $image = new Image();
                $points[$tab['id_tab'] . '_' . $k]['id_tab'] = $tab['id_tab'];
                $points[$tab['id_tab'] . '_' . $k]['product'] = (new ProductAssembler($this->context))->assembleProduct(
                    ['id_product' => $point['id_product']]
                );
                $points[$tab['id_tab'] . '_' . $k]['product_image'] = $image->getCover($point['id_product']);
                $points[$tab['id_tab'] . '_' . $k]['top'] = $point['top'];
                $points[$tab['id_tab'] . '_' . $k]['left'] = $point['left'];
                $points[$tab['id_tab'] . '_' . $k]['status'] = $point['status'];
            }
        }

        $this->smarty->assign([
            'items' => $result,
            'points' => $points,
            'image_baseurl' => $this->_path . 'views/img/',
        ]);

        return $this->display(__FILE__, 'views/templates/hook/bonlookbook-home.tpl');
    }

    public function hookDisplayCustomBonlookbook()
    {
        return $this->hookDisplayHome();
    }
}
