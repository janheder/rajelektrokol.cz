<?php

/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Slider Manager with Photos and Videos
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

include_once(_PS_MODULE_DIR_ . 'bonslider/classes/ClassBonslider.php');
include_once(_PS_MODULE_DIR_ . 'bonslider/classes/ClassBonsliderSubcategory.php');

class Bonslider extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bonslider';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Bonpresta';
        $this->module_key = '2a9a35bb078c36832bef985c8939911c';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Slider Manager with Photos and Videos');
        $this->description = $this->l(
            'Allows you to create multifunctional sliders with videos 
            and images, displays a carousel with sliders on the home page.'
        );
        $this->confirmUninstall = $this->l('This module  Uninstall');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
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
                $tab->name[$language['id_lang']] = 'bonslider';
            }
        }
        $tab->class_name = 'AdminAjaxBonslider';
        $tab->module = $this->name;
        $tab->id_parent = -1;

        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxBonslider')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {
        include(dirname(__FILE__) . '/sql/install.php');
        $this->installSamples();
        $settings = $this->getModuleSettings();

        foreach ($settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        return parent::install() &&
            $this->registerHook('header') &&
            $this->createAjaxController() &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayHome');
    }

    protected function installSamples()
    {
        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 2; ++$i) {
            $item = new ClassBonslider();
            $item->id_shop = (int)$this->context->shop->id;
            $item->status = 1;
            $item->type = "image";
            $item->sort_order = $i;
            foreach ($languages as $language) {
                $item->title[$language['id_lang']] = 'New colorful';
                $item->url[$language['id_lang']] = '6-accessories';
                $item->image[$language['id_lang']] = 'sample-' . $i . '.jpg';
                if ($i == 1) {
                    $item->description[$language['id_lang']] = '
                        <p class="h1"><span class="h1-dark">All motorbike</span> accessories</p>
                        <p class="h2">Proin ut diam sed ipsum ullamcorper feugiat et vitae diam. Aliquam mollis quam in porta placerat. Nam et nisl rutrum, egestas turpis vitae, sagittis dui. Proin aliquet non quam vel finibus</p>
                        <p><span class="padding-primary btn btn-primary">Shop Now!</span></p>';
                } else {
                    $item->description[$language['id_lang']] = '
                        <p class="h1"><span class="h1-dark">discount</span> on all goods</p>
                        <p class="h2">Proin ut diam sed ipsum ullamcorper feugiat et vitae diam. Aliquam mollis quam in porta placerat. Nam et nisl rutrum, egestas turpis vitae, sagittis dui. Proin aliquet non quam vel finibus</p>
                        <p><span class="padding-primary btn btn-primary">Shop Now!</span></p>';
                }
            }
            $item->add();
            for ($j = 1; $j <= 5; ++$j) {
                $sub = new ClassBonsliderSubcategory();
                $sub->id_shop = (int)$this->context->shop->id;
                $sub->id_tab = $i;
                $sub->status = 1;
                $sub->sort_order = $j;
                if ($i == 1 && $j == 1) {
                    $sub->top = -27;
                    $sub->right = -56;
                    $sub->animation = "bonsliderFadeInRight";
                    $sub->zindex = 0;
                    $sub->animation_delay = 300;
                } else if ($i == 1 && $j == 2) {
                    $sub->top = 24;
                    $sub->right = 9;
                    $sub->animation = "bonsliderFadeInLeft";
                    $sub->zindex = 4;
                    $sub->animation_delay = 600;
                } else if ($i == 1 && $j == 3) {
                    $sub->top = 80;
                    $sub->right = 4;
                    $sub->animation = "bonsliderRotate";
                    $sub->zindex = 1;
                    $sub->animation_delay = 0;
                } else if ($i == 1 && $j == 4) {
                    $sub->top = 68;
                    $sub->right = 84;
                    $sub->animation = "bonsliderFadeInUp";
                    $sub->zindex = 1;
                    $sub->animation_delay = 1000;
                } else if ($i == 1 && $j == 5) {
                    $sub->top = 78;
                    $sub->right = 73;
                    $sub->animation = "bonsliderFadeInDown";
                    $sub->zindex = 84;
                    $sub->animation_delay = 800;
                    $sub->description = '<p class="sub-title">AGV Sports <span class="text-dark">Modular</span></p>
                                        <p class="sub-text">The Sportmodular is a new, top-of-the-line, modular helmet from AGV that provides the performance of a full-face helmet with the comfort of a modular helmet.</p>';
                } else if ($i == 2 && $j == 1) {
                    $sub->top = -27;
                    $sub->right = -51;
                    $sub->animation = "bonsliderFadeInRight";
                    $sub->zindex = 0;
                    $sub->animation_delay = 300;
                } else if ($i == 2 && $j == 2) {
                    $sub->top = 8;
                    $sub->right = 16;
                    $sub->animation = "bonsliderFadeInLeft";
                    $sub->zindex = 4;
                    $sub->animation_delay = 600;
                } else if ($i == 2 && $j == 3) {
                    $sub->top = 80;
                    $sub->right = 4;
                    $sub->animation = "bonsliderRotate";
                    $sub->zindex = 1;
                    $sub->animation_delay = 0;
                } else if ($i == 2 && $j == 4) {
                    $sub->top = 68;
                    $sub->right = 84;
                    $sub->animation = "bonsliderFadeInUp";
                    $sub->zindex = 1;
                    $sub->animation_delay = 1000;
                } else if ($i == 2 && $j == 5) {
                    $sub->top = 78;
                    $sub->right = 73;
                    $sub->animation = "bonsliderFadeInDown";
                    $sub->zindex = 84;
                    $sub->animation_delay = 800;
                    $sub->description = '<p class="sub-title">Shock <span class="text-dark">Absorber</span></p>
                                        <p class="sub-text">The Sportmodular is a new, top-of-the-line, modular helmet from AGV that provides the performance of a full-face helmet with the comfort of a modular helmet.</p>';
                }

                foreach ($languages as $language) {
                    $sub->title[$language['id_lang']] = 'subimg-' . $i . "-" . $j;
                    if ($j !== 5) {
                        $sub->image[$language['id_lang']] = 'sub-' . $i . "-" . $j . '.png';
                    }
                }
                $sub->add();
            }
        }
    }

    public function uninstall()
    {
        include(dirname(__FILE__) . '/sql/uninstall.php');

        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            Configuration::deleteByName($name);
        }

        return parent::uninstall()
            && $this->removeAjaxContoller();
    }

    protected function getModuleSettings()
    {
        $settings = array(
            'BON_SLIDER_LIMIT' => 3,
            'BON_SLIDER_DISPLAY_CAROUSEL' => true,
            'BON_SLIDER_CAROUSEL_AUTOPLAYTIME' => 5000,
            'BON_SLIDER_CAROUSEL_AUTOPLAY' => true,
            'BON_SLIDER_CAROUSEL_LOOP' => true,
            'BON_SLIDER_CAROUSEL_DRAG' => true,
            'BON_SLIDER_CAROUSEL_NAV' => true,
            'BON_SLIDER_CAROUSEL_DOTS' => true,
            'BON_SLIDER_CAROUSEL_ANIMATION' => 'fade',
            'BON_SLIDER_CAROUSEL_SOC_TITLE' => 'Our social',
            'BON_SLIDER_CAROUSEL_TWITTER' => '',
            'BON_SLIDER_CAROUSEL_FACEBOOK' => '',
            'BON_SLIDER_CAROUSEL_INSTAGRAM' => '',
        );

        return $settings;
    }

    public function getContent()
    {

        $output = '';
        $result = '';

        if (((bool)Tools::isSubmit('submitBonsliderSettingModule')) == true) {
            if (!$errors = $this->validateSettings()) {
                $this->sliderProcess();
                $output .= $this->displayConfirmation($this->l('Settings updated successful.'));
            } else {
                $output .= $errors;
            }
        } elseif ((bool)Tools::isSubmit('submitUpdateBonslider')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addBonslider();
            } else {
                $output = $result;
                $output .= $this->renderBonsliderCategoryForm();
            }
        } elseif ((bool)Tools::isSubmit('submitUpdateBonsliderSub')) {
            if (!$result = $this->preValidateFormSub()) {
                $output .= $this->addBonsliderSub();
            } else {
                $output = $result;
                $output .= $this->renderBonsliderSubcategoryForm();
            }
        }
        if (Tools::getIsset('updatebonslider') || Tools::getValue('updatebonslider')) {
            $output .= $this->renderBonsliderCategoryForm();
        } elseif ((bool)Tools::isSubmit('addbonslider')) {
            $output .= $this->renderBonsliderCategoryForm();
        } elseif ((bool)Tools::isSubmit('viewbonslider')) {
            $output .= $this->renderBonsliderSubcategoryList();
        } elseif (Tools::getIsset('updatebonslider_sub') || Tools::getValue('updatebonslider_sub')) {
            $output .= $this->renderBonsliderSubcategoryForm();
        } elseif ((bool)Tools::isSubmit('addsubbonslider')) {
            $output .= $this->renderBonsliderSubcategoryForm();
        } elseif ((bool)Tools::isSubmit('statusbonslider')) {
            $output .= $this->updateStatusTab();
            $output .= $this->renderBonsliderCategoryList();
            $output .= $this->renderFormSettings();
        } elseif ((bool)Tools::isSubmit('statusbonslider_sub')) {
            $output .= $this->updateStatusSubcategory();
            $output .= $this->renderBonsliderSubcategoryList();
        } elseif ((bool)Tools::isSubmit('deletebonslider')) {
            $output .= $this->deleteBonslider();
            $output .= $this->renderBonsliderCategoryList();
            $output .= $this->renderFormSettings();
        } elseif ((bool)Tools::isSubmit('deletebonslider_sub')) {
            $output .= $this->deleteBonsliderSub();
            $output .= $this->renderBonsliderSubcategoryList();
        } elseif (!$result) {
            $output .= $this->renderBonsliderCategoryList();
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
        $helper->submit_action = 'submitBonsliderSettingModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'image_path' => $this->_path . 'views/img',
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
                        'type' => 'text',
                        'label' => $this->l('Social media header'),
                        'name' => 'BON_SLIDER_CAROUSEL_SOC_TITLE',
                        'col' => 2,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Twitter link'),
                        'name' => 'BON_SLIDER_CAROUSEL_TWITTER',
                        'col' => 2,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Facebook link'),
                        'name' => 'BON_SLIDER_CAROUSEL_FACEBOOK',
                        'col' => 2,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Instagram link'),
                        'name' => 'BON_SLIDER_CAROUSEL_INSTAGRAM',
                        'col' => 2,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Carousel on home page:'),
                        'name' => 'BON_SLIDER_DISPLAY_CAROUSEL',
                        'desc' => $this->l('Activates the display of the slide carousel.'),
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
                        'form_group_class' => 'display-slider-block',
                        'type' => 'text',
                        'label' => $this->l('Display item on home page'),
                        'name' => 'BON_SLIDER_LIMIT',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'form_group_class' => 'display-slider-block',
                        'type' => 'select',
                        'label' => $this->l('Select slider animation effect'),
                        'name' => 'BON_SLIDER_CAROUSEL_ANIMATION',
                        'desc' => $this->l('Responsible for the animation effect when switching the slide.'),
                        'col' => 2,
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'fade',
                                    'name' => $this->l('Fade')),
                                array(
                                    'id' => 'coverflow',
                                    'name' => $this->l('Coverflow')),
                                array(
                                    'id' => 'flip',
                                    'name' => $this->l('Flip')),
                                array(
                                    'id' => 'cube',
                                    'name' => $this->l('Cube')),
                                array(
                                    'id' => 'cards',
                                    'name' => $this->l('Cards')),
                                array(
                                    'id' => 'creative',
                                    'name' => $this->l('Creative')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'form_group_class' => 'display-slider-block',
                        'type' => 'switch',
                        'label' => $this->l('Slider autoplay:'),
                        'name' => 'BON_SLIDER_CAROUSEL_AUTOPLAY',
                        'desc' => $this->l('Activates automatic slide play.'),
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
                        'form_group_class' => 'display-slider-block',
                        'type' => 'text',
                        'label' => $this->l('Automatic switching speed:'),
                        'name' => 'BON_SLIDER_CAROUSEL_AUTOPLAYTIME',
                        'desc' => $this->l(
                            'The slide will switch at a given speed
                             (if the autoplay option is active).'
                        ),
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'form_group_class' => 'display-slider-block',
                        'type' => 'switch',
                        'label' => $this->l('Drag-and-drop slide switching:'),
                        'name' => 'BON_SLIDER_CAROUSEL_DRAG',
                        'desc' => $this->l('Enables drag-and-drop slide switching.'),
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
                        'form_group_class' => 'display-slider-block',
                        'type' => 'switch',
                        'label' => $this->l('Loop:'),
                        'name' => 'BON_SLIDER_CAROUSEL_LOOP',
                        'desc' => $this->l('Infinity loop. Duplicate last and first items to get loop illusion.'),
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
                        'form_group_class' => 'display-slider-block',
                        'type' => 'switch',
                        'label' => $this->l('Nav:'),
                        'name' => 'BON_SLIDER_CAROUSEL_NAV',
                        'desc' => $this->l('Show next/prev buttons.'),
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
                        'form_group_class' => 'display-slider-block',
                        'type' => 'switch',
                        'label' => $this->l('Dots:'),
                        'name' => 'BON_SLIDER_CAROUSEL_DOTS',
                        'desc' => $this->l('Show dots navigation.'),
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


        if (Tools::isEmpty(Tools::getValue('BON_SLIDER_LIMIT'))) {
            $errors[] = $this->l('The "Display item on home page" field is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_SLIDER_LIMIT'))) {
                $errors[] = $this->l('The "Display item on home page" field must be a numeric value.');
            }
        }
        if (Tools::isEmpty(Tools::getValue('BON_SLIDER_CAROUSEL_AUTOPLAYTIME'))) {
            $errors[] = $this->l('The "Automatic switching speed" field is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_SLIDER_CAROUSEL_AUTOPLAYTIME'))) {
                $errors[] = $this->l('The "Automatic switching speed" field must be a numeric value.');
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

    protected function sliderProcess()
    {
        $form_values = $this->getConfigFormValuesSettings();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function getBonsliderSettings()
    {
        $settings = $this->getModuleSettings();
        $get_settings = array();
        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = array('value' => $data, 'type' => $this->getStringValueType($data));
        }

        return $get_settings;
    }

    // Slider Category Settings
    protected function renderBonsliderCategoryForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ?
                        $this->l('Update slider category') :
                        $this->l('Add slider category')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Name'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Link'),
                        'name' => 'url',
                        'required' => true,
                        'lang' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Type:'),
                        'name' => 'type',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'image',
                                    'name' => $this->l('Image')),
                                array(
                                    'id' => 'video',
                                    'name' => $this->l('Video')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'files_lang',
                        'label' => $this->l('Image'),
                        'name' => 'image',
                        'lang' => true,
                        'col' => 6,
                        'desc' => $this->l(
                            'If the parallax type image - format file .png, 
                            .jpg, .gif. If the parallax type video - format file .mp4, .webm, .ogv.'
                        ),
                        'required' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Description'),
                        'name' => 'description',
                        'autoload_rte' => true,
                        'lang' => true,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name' => 'status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'col' => 2,
                        'type' => 'text',
                        'name' => 'sort_order',
                        'class' => 'hidden'
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
                'buttons' => array(
                    array(
                        'href' => AdminController::$currentIndex . '&configure=' .
                            $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updatebonslider') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBonslider((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
            $fields_form['form']['images'] = $tab->image;
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonslider';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBonsliderFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
            'image_baseurl_video' => $this->_path.'views/img/'
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBonsliderFormValues()
    {
        if ((bool)Tools::getIsset('updatebonslider') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBonslider((int)Tools::getValue('id_tab'));
            $fields_values = array(
                'id_tab' => Tools::getValue('id_tab'),
                'title' => Tools::getValue('title', $tab->title),
                'url' => Tools::getValue('url', $tab->url),
                'type' => Tools::getValue('type', $tab->type),
                'image' => Tools::getValue('image', $tab->image),
                'description' => Tools::getValue('description', $tab->description),
                'status' => Tools::getValue('status', $tab->status),
                'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
            );
        } else {
            $tab = new ClassBonslider();
            $languages = Language::getLanguages(false);
            $description = [];
            foreach ($languages as $key => $language) {
                $key++;
                $description[$key] = 'description';
            }
            $fields_values = array(
                'id_tab' => '',
                'title' => '',
                'url' => '',
                'type' => 'image',
                'image' => '',
                'description' => $description,
                'status' => false,
                'sort_order' => '',
            );
        }


        return $fields_values;
    }

    public function renderBonsliderCategoryList()
    {
        if (!$tabs = ClassBonslider::getBonsliderCategoryList()) {
            $tabs = array();
        }

        $fields_list = array(
            'id_tab' => array(
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ),
            'title' => array(
                'title' => $this->l('Title'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'images' => array(
                'title' => $this->l('Label'),
                'type'  => 'box_image_category',
                'align' => 'center',
                'search' => false,
            ),
            'status' => array(
                'title' => $this->l('Status'),
                'type' => 'bool',
                'active' => 'status',
                'search' => false,
                'orderby' => false,
            ),
            'sort_order' => array(
                'title' => $this->l('Position'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
                'class' => 'pointer dragHandle'
            )
        );

        $helper = new HelperList();

        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_tab';
        $helper->table = 'bonslider';
        $helper->actions = array('view', 'edit', 'delete');
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->displayName;
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex
                . '&configure=' . $this->name . '&add' . $this->name
                . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Add new item')
        );
        $helper->currentIndex = AdminController::$currentIndex
            . '&configure=' . $this->name . '&id_shop=' . (int)$this->context->shop->id;

        $helper->tpl_vars = array(
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
            'image_baseurl_video' => $this->_path.'views/img/'
        );

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addBonslider()
    {
        $errors = array();
        
        if ((int)Tools::getValue('id_tab') > 0) {
            $item = new ClassBonslider((int)Tools::getValue('id_tab'));
        } else {
            $item = new ClassBonslider();
        }

        $item->id_shop = (int)$this->context->shop->id;
        $item->status = (int)Tools::getValue('status');
        $item->type = Tools::getValue('type');
 

        if ((int)Tools::getValue('id_tab') > 0) {
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item->sort_order = $item->getMaxSortOrder((int)$this->id_shop);
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
            $item->description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang']);
            $item->url[$language['id_lang']] = Tools::getValue('url_'.$language['id_lang']);
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_'.$language['id_lang']]['name'], '.'), 1));

            if (Tools::getValue('type') == 'video') {
                $salt = sha1(microtime());
                if (!move_uploaded_file($_FILES['image_' . $language['id_lang']]['tmp_name'], dirname(__FILE__) .
                    '/views/img/' . $salt . '_' . $_FILES['image_' . $language['id_lang']]['name'])) {
                } else {
                    if (isset($_FILES['image_' . $language['id_lang']]) && isset($_FILES['image_' .
                            $language['id_lang']]['tmp_name']) && !empty($_FILES['image_' .
                            $language['id_lang']]['tmp_name'])) {
                        $item->image[$language['id_lang']] = $salt .
                            '_' . $_FILES['image_' . $language['id_lang']]['name'];
                    } elseif (Tools::getValue('image_old_' . $language['id_lang']) != '') {
                        $item->image[$language['id_lang']] = Tools::getValue('image_old_' . $language['id_lang']);
                    }
                }
            } elseif (Tools::getValue('type') == 'image') {
                $imagesize = $_FILES['image_'.$language['id_lang']]["tmp_name"] != '' ? @getimagesize($_FILES['image_'.$language['id_lang']]["tmp_name"]) : '';
                if (isset($_FILES['image_'.$language['id_lang']])
                    && isset($_FILES['image_'.$language['id_lang']]['tmp_name'])
                    && !empty($_FILES['image_'.$language['id_lang']]['tmp_name'])
                    && !empty($imagesize)
                    && in_array(
                        Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)),
                        array('jpg', 'gif', 'jpeg', 'png', 'webp')
                    )
                    && in_array($type, array('jpg', 'gif', 'jpeg', 'png', 'webp'))) {
                    $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                    $salt = sha1(microtime());
                    if ($error = ImageManager::validateUpload($_FILES['image_'.$language['id_lang']])) {
                        $errors[] = $error;
                    } elseif (!$temp_name || !move_uploaded_file($_FILES['image_'.
                        $language['id_lang']]['tmp_name'], $temp_name)) {
                        return false;
                    } elseif (!ImageManager::resize($temp_name, dirname(__FILE__).
                        '/views/img/'.$salt.'_'.$_FILES['image_'.
                        $language['id_lang']]['name'], null, null, $type)) {
                        $errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
                    }

                    if (isset($temp_name)) {
                        @unlink($temp_name);
                    }
                    $item->image[$language['id_lang']] = $salt.'_'.$_FILES['image_'.$language['id_lang']]['name'];
                } elseif (Tools::getValue('image_old_'.$language['id_lang']) != '') {
                    $item->image[$language['id_lang']] = Tools::getValue('image_old_'.$language['id_lang']);
                }
            }
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
        $errors = array();
        $languages = Language::getLanguages(false);

        $class = new ClassBonslider((int)Tools::getValue('id_tab'));
       
        $old_image = $class->image;
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');

        if (!$old_image && (!isset($_FILES['image_' .  $this->default_language['id_lang']]) || Tools::isEmpty($_FILES['image_' .  $this->default_language['id_lang']]['tmp_name'])))  {
            $errors[] = $this->l('The file is required.');
        }

        if (Tools::getValue('type') == 'image') {
            foreach ($languages as $lang) {
                if (!Tools::isEmpty($_FILES['image_' . $lang['id_lang']]['type'])) {
                    if (ImageManager::validateUpload($_FILES['image_' . $lang['id_lang']], 4000000)) {
                        $errors[] = $this->l('Image format not recognized, allowed format is: .gif, .jpg, .png');
                    }
                }
            }
        }

        if (Tools::getValue('type') == 'video') {
            $info = new SplFileInfo($_FILES['image_' . $this->default_language['id_lang']]['name']);
            if ($_FILES['image_' . $this->default_language['id_lang']]['name'] != '') {
                if ($info->getExtension() != 'mp4' && $info->getExtension()
                    != 'webm' && $info->getExtension() != 'ogv') {
                    $errors[] = $this->l('Video format not recognized, allowed format is: .mp4, .webm, .ogv');
                }
            }
        }
        
        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The name of slider is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad name of slider format.');
        }

        if (Tools::isEmpty(Tools::getValue('url_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The link is required.');
        } elseif (!Validate::isUrl(Tools::getValue('url_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad link format.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function deleteBonslider()
    {
        $tab = new ClassBonslider(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if ($tab->delete()) {
            $tabs = ClassBonsliderSubcategory::getBonsliderSubcategoryList((int)Tools::getValue('id_tab'));
            if ($tabs) {
                foreach ($tabs as $tab) {
                    $tab = new ClassBonsliderSubcategory($tab['id_tab']);
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
        $tab = new ClassBonslider(Tools::getValue('id_tab'));

        if ($tab->status == 1) {
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
    protected function renderBonsliderSubcategoryForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_sub') ?
                        $this->l('Update subcategory') :
                        $this->l('Add subcategory')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'col'   => 2,
                        'type'  => 'text',
                        'name'  => 'id_tab',
                        'class' => 'hidden'
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'files_lang_sub',
                        'label' => $this->l('Image'),
                        'name' => 'image',
                        'lang' => true,
                        'col' => 6,
                        'desc' => $this->l('Format file .png, .jpg, .gif.'),
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Description'),
                        'name' => 'description',
                        'autoload_rte' => true,
                        'lang' => true,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Animation'),
                        'name' => 'animation',
                        'desc' => $this->l('Responsible for the animation effect when switching the slide.'),
                        'col' => 2,
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'bonsliderFadeInDown',
                                    'name' => $this->l('Fade in down')),
                                array(
                                    'id' => 'bonsliderFadeInLeft',
                                    'name' => $this->l('Fade in left')),
                                array(
                                    'id' => 'bonsliderFadeInUp',
                                    'name' => $this->l('Fade in up')),
                                array(
                                    'id' => 'bonsliderFadeInRight',
                                    'name' => $this->l('Fade in right')),
                                array(
                                    'id' => 'bonsliderPulse',
                                    'name' => $this->l('Pulse')),
                                array(
                                    'id' => 'bonsliderFadeInTopLeft',
                                    'name' => $this->l('Fade in top left')),
                                array(
                                    'id' => 'bonsliderFadeInTopRight',
                                    'name' => $this->l('Fade in top right')),
                                array(
                                    'id' => 'bonsliderFadeInBottomLeft',
                                    'name' => $this->l('Fade in bottom left')),
                                array(
                                    'id' => 'bonsliderFadeInBottomRight',
                                    'name' => $this->l('Fade in bottom right')),
                                array(
                                    'id' => 'bonsliderBounce',
                                    'name' => $this->l('Bounce')),
                                array(
                                    'id' => 'bonsliderRotateIn',
                                    'name' => $this->l('Rotate in')),
                                array(
                                    'id' => 'bonsliderJackInTheBox',
                                    'name' => $this->l('Jack in the box')),
                                array(
                                    'id' => 'bonsliderRollIn',
                                    'name' => $this->l('Roll in')),
                                array(
                                    'id' => 'bonsliderZoomIn',
                                    'name' => $this->l('Zoom in')),
                                array(
                                    'id' => 'bonsliderFlipInX',
                                    'name' => $this->l('Flip in X')),
                                array(
                                    'id' => 'bonsliderRotate',
                                    'name' => $this->l('Rotating')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Top'),
                        'name' => 'top',
                        'desc' => $this->l('Sets the top coordinate in percent.'),
                        'suffix' => '%',
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Right'),
                        'name' => 'right',
                        'desc' => 'Sets the right coordinate in percent.',
                        'suffix' => '%',
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Z-index'),
                        'name' => 'zindex',
                        'desc' => 'Items with higher z-index overlap items with lower z-index.',
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Animation delay'),
                        'name' => 'animation_delay',
                        'suffix' => 'ms',
                        'desc' => '"Animation delay" sets the animation delay in milliseconds.',
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name' => 'status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'col' => 2,
                        'type' => 'text',
                        'name' => 'sort_order',
                        'class' => 'hidden'
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'type'  => 'submit',
                ),
                'buttons' => array(
                    array(
                        'href'  => AdminController::$currentIndex.'&configure='.$this->name.'&viewbonslider&id_tab='.
                            Tools::getValue('id_tab').'&token='.Tools::getAdminTokenLite('AdminModules') .
                            '&id_shop='. (int)$this->context->shop->id,
                        'title' => $this->l('Cancel'),
                        'icon'  => 'process-icon-cancel'
                    ),
                    array(
                        'href' => AdminController::$currentIndex . '&configure=' . $this->name .
                            '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to main page'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updatebonslider_sub') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonsliderSubcategory((int)Tools::getValue('id_sub'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_sub', 'value' => (int)$tab->id);
            $fields_form['form']['images'] = $tab->image;
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonsliderSub';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBonsliderSubcategoryFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBonsliderSubcategoryFormValues()
    {
        $languages = Language::getLanguages(false);

        if ((bool)Tools::getIsset('updatebonslider_sub') && (int)Tools::getValue('id_sub') > 0) {
            $tab = new ClassBonsliderSubcategory((int)Tools::getValue('id_sub'));
        } else {
            $tab = new ClassBonsliderSubcategory();
        }
        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'id_sub' => Tools::getValue('id_sub'),
            'title' => Tools::getValue('title', $tab->title),
            'top' => Tools::getValue('top', $tab->top),
            'right' => Tools::getValue('right', $tab->right),
            'zindex' => Tools::getValue('right', $tab->zindex),
            'animation' => Tools::getValue('animation', $tab->animation),
            'animation_delay' => Tools::getValue('animation_delay', $tab->animation_delay),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
            'image' => Tools::getValue('image', $tab->image),
        );

        foreach ($languages as $lang) {
            $fields_values['description'][$lang['id_lang']] = Tools::getValue(
                'description_' . (int) $lang['id_lang'],
                isset($tab->description[$lang['id_lang']]) ? $tab->description[$lang['id_lang']] : ''
            );
        }

        return $fields_values;
    }

    public function renderBonsliderSubcategoryList()
    {
        if (!$tabs = ClassBonsliderSubcategory::getBonsliderSubcategoryList(Tools::getValue('id_tab'))) {
            $tabs = array();
        }

        $fields_list = array(
            'id_sub' => array(
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ),
            'id_tab' => array(
                'title' => ($this->l('Id tab')),
                'type'  => 'text',
                'class' => 'hidden id_tab',
                'search' => false,
                'orderby' => false,
            ),
            'title' => array(
                'title' => $this->l('Title'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'images' => array(
                'title' => $this->l('Label'),
                'type'  => 'box_image',
                'align' => 'center',
                'search' => false,
            ),
            'status' => array(
                'title' => $this->l('Status'),
                'type' => 'bool',
                'active' => 'status',
                'search' => false,
                'orderby' => false,
            ),
            'sort_order' => array(
                'title' => $this->l('Position'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
                'class' => 'pointer dragHandle'
            ),
            
        );

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_sub';
        $helper->table = 'bonslider_sub';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->displayName;
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex
                . '&configure=' . $this->name . '&addsub' . $this->name
                . '&token=' . Tools::getAdminTokenLite('AdminModules')
                . '&id_shop=' . (int)$this->context->shop->id
                . '&id_tab=' .Tools::getValue('id_tab'),
            'desc' => $this->l('Add new item')
        );
        $helper->toolbar_btn['back'] = array(
            'href' => AdminController::$currentIndex.'&configure='.$this->name .
                '&token='.Tools::getAdminTokenLite('AdminModules') . '&id_shop=' . (int)$this->context->shop->id,
            'desc' => $this->l('Back to main page')
        );
        $helper->currentIndex = AdminController::$currentIndex
            . '&configure=' . $this->name . '&id_shop=' .
            (int)$this->context->shop->id . '&id_tab=' .Tools::getValue('id_tab');

        $helper->tpl_vars = array(
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
        );

        return $helper->generateList($tabs, $fields_list);
    }
  
    protected function addBonsliderSub()
    {
        $errors = array();

        if ((int)Tools::getValue('id_sub') > 0) {
            $item = new ClassBonsliderSubcategory((int)Tools::getValue('id_sub'));
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item = new ClassBonsliderSubcategory();
            $item->sort_order = $item->getMaxSortOrder((int)Tools::getValue('id_tab'));
        }

        $item->id_shop = (int)$this->context->shop->id;
        $item->id_tab = (int)Tools::getValue('id_tab');
        $item->status = (int)Tools::getValue('status');
        $item->top = (int)Tools::getValue('top');
        $item->right = (int)Tools::getValue('right');
        $item->zindex = (int)Tools::getValue('zindex');
        $item->animation = Tools::getValue('animation');
        $item->animation_delay = (int)Tools::getValue('animation_delay');

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_' . $language['id_lang']);
            $item->description[$language['id_lang']] = Tools::getValue('description_' . $language['id_lang']);
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_' . $language['id_lang']]['name'], '.'), 1));

            $imagesize = $_FILES['image_'.$language['id_lang']]["tmp_name"] != '' ? @getimagesize($_FILES['image_'.$language['id_lang']]["tmp_name"]) : '';
            if (isset($_FILES['image_' . $language['id_lang']])
                && isset($_FILES['image_' . $language['id_lang']]['tmp_name'])
                && !empty($_FILES['image_' . $language['id_lang']]['tmp_name'])
                && !empty($imagesize)
                && in_array(
                    Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)),
                    array('jpg', 'gif', 'jpeg', 'png', 'webp')
                )
                && in_array($type, array('jpg', 'gif', 'jpeg', 'png', 'webp'))
            ) {
                $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                $salt = sha1(microtime());
                if ($error = ImageManager::validateUpload($_FILES['image_' . $language['id_lang']])) {
                    $errors[] = $error;
                } elseif (!$temp_name || !move_uploaded_file($_FILES['image_' .
                    $language['id_lang']]['tmp_name'], $temp_name)) {
                    return false;
                } elseif (!ImageManager::resize($temp_name, dirname(__FILE__) .
                    '/views/img/' . $salt . '_' .
                    $_FILES['image_' . $language['id_lang']]['name'], null, null, $type)) {
                    $errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
                }

                if (isset($temp_name)) {
                    @unlink($temp_name);
                }
                $item->image[$language['id_lang']] = $salt . '_' . $_FILES['image_' . $language['id_lang']]['name'];
            } elseif (Tools::getValue('image_old_' . $language['id_lang']) != '') {
                $item->image[$language['id_lang']] = Tools::getValue('image_old_' . $language['id_lang']);
            }
        }

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

    protected function preValidateFormSub()
    {
        $errors = array();
        $languages = Language::getLanguages(false);

        $class = new ClassBonsliderSubcategory((int)Tools::getValue('id_sub'));

        if (Tools::isEmpty(Tools::getValue('top'))) {
            $errors[] = $this->l('The "Top" field is required.');
        } elseif (!Validate::isInt(Tools::getValue('top'))) {
            $errors[] = $this->l('The "Top" coordinate can only be numeric.');
        }
        if (Tools::isEmpty(Tools::getValue('right'))) {
            $errors[] = $this->l('The "Right" field is required.');
        } elseif (!Validate::isInt(Tools::getValue('right'))) {
            $errors[] = $this->l('The "Right" coordinate can only be numeric.');
        }
        if (Tools::isEmpty(Tools::getValue('zindex'))) {
            $errors[] = $this->l('The "Z-index" field is required.');
        } elseif (!Validate::isInt(Tools::getValue('zindex'))) {
            $errors[] = $this->l('"Z-index" can only be numeric.');
        }
        if (Tools::isEmpty(Tools::getValue('animation_delay'))) {
            $errors[] = $this->l('The "Animation delay" field is required.');
        } elseif (!Validate::isInt(Tools::getValue('animation_delay'))) {
            $errors[] = $this->l('"Animation delay" can only be numeric.');
        }

        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The name of item is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad name of item format.');
        }
       
        foreach ($languages as $lang) {
            if (!Tools::isEmpty($_FILES['image_' . $lang['id_lang']]['type'])) {
                if (ImageManager::validateUpload($_FILES['image_' . $lang['id_lang']], 4000000)) {
                    $errors[] = $this->l('Image format not recognized, allowed format is: .gif, .jpg, .png');
                }
            }
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function deleteBonsliderSub()
    {
        $tab = new ClassBonsliderSubcategory(Tools::getValue('id_sub'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the subcategory'));
        }

        return $this->displayConfirmation($this->l('The subcategory is successfully deleted'));
    }
    
    protected function updateStatusSubcategory()
    {
        $tab = new ClassBonsliderSubcategory(Tools::getValue('id_sub'));

        if ($tab->status == 1) {
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
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBonslider'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBonslider'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path . 'views/js/bonslider_back.js');
        $this->context->controller->addCSS($this->_path . 'views/css/bonslider_back.css');
    }

    public function hookHeader()
    {
        Media::addJsDefL('BON_SLIDER_CAROUSEL_ANIMATION', Configuration::get('BON_SLIDER_CAROUSEL_ANIMATION'));
        Media::addJsDefL('BON_SLIDER_CAROUSEL_AUTOPLAY', Configuration::get('BON_SLIDER_CAROUSEL_AUTOPLAY'));
        Media::addJsDefL('BON_SLIDER_CAROUSEL_AUTOPLAYTIME', Configuration::get('BON_SLIDER_CAROUSEL_AUTOPLAYTIME'));
        Media::addJsDefL('BON_SLIDER_CAROUSEL_DRAG', Configuration::get('BON_SLIDER_CAROUSEL_DRAG'));
        $this->context->controller->addJS($this->_path . 'views/js/swiper-bundle.min.js');
        $this->context->controller->addCSS($this->_path . 'views/css/swiper-bundle.min.css', 'all');
        $this->context->controller->addJS($this->_path . '/views/js/bonslider_front.js');
        $this->context->controller->addCSS($this->_path . '/views/css/bonslider_front.css');

        $this->context->smarty->assign('settings', $this->getBonsliderSettings());
   
        return $this->display($this->_path, '/views/templates/hook/bonslider-header.tpl');
    }

    public function hookDisplayHome()
    {
        $bonslider_front = new ClassBonslider();
        $tabs = $bonslider_front->getTopFrontItems($this->id_shop, true);
        $result = array();

        foreach ($tabs as $key => $tab) {
            $result[$key]['id'] = $tab['id_tab'];
            $result[$key]['title'] = $tab['title'];
            $result[$key]['image'] = $tab['image'];
            $result[$key]['url'] = $tab['url'];
            $result[$key]['type'] = $tab['type'];
            $result[$key]['description'] = $tab['description'];
            $result[$key]['subitems'] = ClassBonsliderSubcategory::getTopFrontItems((int)$tab['id_tab']);
        }

        $this->smarty->assign(array(
            'display_carousel' => Configuration::get('BON_SLIDER_DISPLAY_CAROUSEL'),
            'dots' => Configuration::get('BON_SLIDER_CAROUSEL_DOTS'),
            'nav' => Configuration::get('BON_SLIDER_CAROUSEL_NAV'),
            'soc_title' => Configuration::get('BON_SLIDER_CAROUSEL_SOC_TITLE'),
            'twitter_link' => Configuration::get('BON_SLIDER_CAROUSEL_TWITTER'),
            'facebook_link' => Configuration::get('BON_SLIDER_CAROUSEL_FACEBOOK'),
            'instagram_link' => Configuration::get('BON_SLIDER_CAROUSEL_INSTAGRAM'),
            'items'=> $result,
            'image_baseurl'=> $this->_path . 'views/img/',
            'limit'=> Configuration::get('BON_SLIDER_LIMIT'),
            'swiper_device' => Context::getContext()->isMobile()
        ));


        return $this->display(__FILE__, 'views/templates/hook/bonslider-home.tpl');
    }
    
    public function hookDisplayCustomBonslider()
    {
        return $this->hookDisplayHome();
    }
}
