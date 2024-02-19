<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Product Images Zoom
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

class BonZoom extends Module
{
    public function __construct()
    {
        $this->name = 'bonzoom';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->author = 'Bonpresta';
        $this->module_key = '00d9b153c7225d198ba1459e91a5b633';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('Product Images Zoom');
        $this->description = $this->l('Display Product Images Zoom');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    protected function getConfigs()
    {
        $res = array(
            'BON_ZOOM_TYPE' => 'inner',
            'BON_ZOOM_LENS_SIZE' => 100,
            'BON_ZOOM_CURSOR' => 'default',
            'BON_ZOOM_LENS_OPACITY' => 0.5,
            'BON_ZOOM_DISPLAY' => true,
            'BON_ZOOM_SCROLL' => true,
            'BON_ZOOM_EASING' => true,
            'BON_ZOOM_LENS_FADEIN' => 1400,
            'BON_ZOOM_LENS_FADEOUT' => 500,
            'BON_ZOOM_LENS_SHAPE' => 'round',
            'BON_ZOOM_WINDOW_WIDTH' => 400,
            'BON_ZOOM_WINDOW_HEIGHT' => 400,
            'BON_ZOOM_WINDOW_BORDER' => 1,
            'BON_ZOOM_WINDOW_BORDER_COLOR' => '#333333',
        );

        return $res;
    }

    public function install()
    {
        $settings = $this->getConfigs();

        foreach ($settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        return parent::install() &&
        $this->registerHook('displayBeforeBodyClosingTag') &&
        $this->registerHook('displayHeader');
    }

    public function uninstall()
    {
        $settings = $this->getConfigs();

        foreach (array_keys($settings) as $name) {
            Configuration::deleteByName($name);
        }

        return parent::uninstall();
    }

    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submit'.$this->name)) {
            if (!$errors = $this->checkItemFields()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Save all settings.'));
            } else {
                $output .= $errors;
            }
        }

        return $output.$this->displayForm();
    }


    protected function checkItemFields()
    {
        $errors = array();

        if (Tools::isEmpty(Tools::getValue('BON_ZOOM_LENS_SIZE'))) {
            $errors[] = $this->l('Lens size is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_ZOOM_LENS_SIZE'))) {
                $errors[] = $this->l('Bad lens size format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_ZOOM_LENS_OPACITY'))) {
            $errors[] = $this->l('Opacity is required.');
        } else {
            if (!Validate::isUnsignedFloat(Tools::getValue('BON_ZOOM_LENS_OPACITY'))) {
                $errors[] = $this->l('Bad opacity format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_ZOOM_LENS_FADEIN'))) {
            $errors[] = $this->l('Lens fadein is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_ZOOM_LENS_FADEIN'))) {
                $errors[] = $this->l('Bad lens fadein format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_ZOOM_LENS_FADEOUT'))) {
            $errors[] = $this->l('Lens fadeout is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_ZOOM_LENS_FADEOUT'))) {
                $errors[] = $this->l('Bad lens fadeout format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_ZOOM_WINDOW_WIDTH'))) {
            $errors[] = $this->l('Windows width is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_ZOOM_WINDOW_WIDTH'))) {
                $errors[] = $this->l('Bad windows width format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_ZOOM_WINDOW_HEIGHT'))) {
            $errors[] = $this->l('Windows height is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_ZOOM_WINDOW_HEIGHT'))) {
                $errors[] = $this->l('Bad windows height format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_ZOOM_WINDOW_BORDER'))) {
            $errors[] = $this->l('Border is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_ZOOM_WINDOW_BORDER'))) {
                $errors[] = $this->l('Bad border format');
            }
        }

        if (!Validate::isColor(Tools::getValue('BON_ZOOM_WINDOW_BORDER_COLOR'))) {
            $errors[] = $this->l('Border color format error.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    public function displayForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Zoom Settings'),
            ),
            'input' => array(
                array(
                   'type' => 'switch',
                   'label' => $this->l('Display:'),
                   'name' => 'BON_ZOOM_DISPLAY',
                   'is_bool' => true,
                   'values' => array(
                       array(
                           'id' => 'enable',
                           'value' => 1,
                           'label' => $this->l('Yes')),
                       array(
                           'id' => 'disable',
                           'value' => 0,
                           'label' => $this->l('No')),
                   ),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Type:'),
                    'name' => 'BON_ZOOM_TYPE',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'lens',
                                'name' => $this->l('lens')),
                            array(
                                'id' => 'window',
                                'name' => $this->l('window')),
                            array(
                                'id' => 'inner',
                                'name' => $this->l('inner')),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Cursor:'),
                    'name' => 'BON_ZOOM_CURSOR',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'default',
                                'name' => $this->l('default')),
                            array(
                                'id' => 'cursor',
                                'name' => $this->l('cursor')),
                            array(
                                'id' => 'crosshair',
                                'name' => $this->l('crosshair')),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Lens Shape:'),
                    'name' => 'BON_ZOOM_LENS_SHAPE',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'round',
                                'name' => $this->l('round')),
                            array(
                                'id' => 'square',
                                'name' => $this->l('square')),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Scroll:'),
                    'name' => 'BON_ZOOM_SCROLL',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'enable',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'disable',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Easing:'),
                    'name' => 'BON_ZOOM_EASING',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'enable',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'disable',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Lens Size:'),
                    'name' => 'BON_ZOOM_LENS_SIZE',
                    'col' => 2,
                    'suffix' => 'pixels',
                    'required' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Lens Opacity:'),
                    'name' => 'BON_ZOOM_LENS_OPACITY',
                    'col' => 2,
                    'required' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Lens FadeIn:'),
                    'name' => 'BON_ZOOM_LENS_FADEIN',
                    'col' => 2,
                    'required' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Lens FadeOut:'),
                    'name' => 'BON_ZOOM_LENS_FADEOUT',
                    'col' => 2,
                    'required' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Zoom Width:'),
                    'name' => 'BON_ZOOM_WINDOW_WIDTH',
                    'col' => 2,
                    'suffix' => 'pixels',
                    'required' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Zoom Height:'),
                    'name' => 'BON_ZOOM_WINDOW_HEIGHT',
                    'col' => 2,
                    'suffix' => 'pixels',
                    'required' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Zoom Border:'),
                    'name' => 'BON_ZOOM_WINDOW_BORDER',
                    'col' => 2,
                    'suffix' => 'pixels',
                    'required' => true,
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Zoom Border Color:'),
                    'name' => 'BON_ZOOM_WINDOW_BORDER_COLOR',
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
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submit'.$this->name;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigFieldsValues()
    {
        $filled_settings = array();
        $settings = $this->getConfigs();

        foreach (array_keys($settings) as $name) {
            $filled_settings[$name] = Configuration::get($name);
        }

        return $filled_settings;
    }

    protected function postProcess()
    {
        $form_values = $this->getConfigFieldsValues();
        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }


    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'views/css/bonzoom.css', 'all');
        $this->context->controller->addJS(($this->_path).'views/js/bonzoom.js');
        if (_PS_VERSION_ < 1.7) {
            $this->context->smarty->assign(array(
                'zoom_type' => Configuration::get('BON_ZOOM_TYPE'),
                'zoom_lens_size' => Configuration::get('BON_ZOOM_LENS_SIZE'),
                'zoom_cursor_type' => Configuration::get('BON_ZOOM_CURSOR'),
                'zoom_lens_opacity' => Configuration::get('BON_ZOOM_LENS_OPACITY'),
                'zoom_display' => Configuration::get('BON_ZOOM_DISPLAY'),
                'zoom_scroll' => Configuration::get('BON_ZOOM_SCROLL'),
                'zoom_easing' => Configuration::get('BON_ZOOM_EASING'),
                'zoom_fade_in' => Configuration::get('BON_ZOOM_LENS_FADEIN'),
                'zoom_fade_out' => Configuration::get('BON_ZOOM_LENS_FADEOUT'),
                'zoom_lens_shape' => Configuration::get('BON_ZOOM_LENS_SHAPE'),
                'zoom_win_width' => Configuration::get('BON_ZOOM_WINDOW_WIDTH'),
                'zoom_win_height' => Configuration::get('BON_ZOOM_WINDOW_HEIGHT'),
                'zoom_win_border' => Configuration::get('BON_ZOOM_WINDOW_BORDER'),
                'zoom_win_border_color' => Configuration::get('BON_ZOOM_WINDOW_BORDER_COLOR'),
            ));
            return $this->display(__FILE__, 'bonzoom.tpl');
        }
    }

    public function hookDisplayBeforeBodyClosingTag()
    {
        $this->context->controller->addCSS($this->_path.'views/css/bonzoom.css', 'all');
        $this->context->controller->addJS(($this->_path).'views/js/bonzoom.js');
        $this->context->smarty->assign(array(
            'zoom_type' => Configuration::get('BON_ZOOM_TYPE'),
            'zoom_lens_size' => Configuration::get('BON_ZOOM_LENS_SIZE'),
            'zoom_cursor_type' => Configuration::get('BON_ZOOM_CURSOR'),
            'zoom_lens_opacity' => Configuration::get('BON_ZOOM_LENS_OPACITY'),
            'zoom_display' => Configuration::get('BON_ZOOM_DISPLAY'),
            'zoom_scroll' => Configuration::get('BON_ZOOM_SCROLL'),
            'zoom_easing' => Configuration::get('BON_ZOOM_EASING'),
            'zoom_fade_in' => Configuration::get('BON_ZOOM_LENS_FADEIN'),
            'zoom_fade_out' => Configuration::get('BON_ZOOM_LENS_FADEOUT'),
            'zoom_lens_shape' => Configuration::get('BON_ZOOM_LENS_SHAPE'),
            'zoom_win_width' => Configuration::get('BON_ZOOM_WINDOW_WIDTH'),
            'zoom_win_height' => Configuration::get('BON_ZOOM_WINDOW_HEIGHT'),
            'zoom_win_border' => Configuration::get('BON_ZOOM_WINDOW_BORDER'),
            'zoom_win_border_color' => Configuration::get('BON_ZOOM_WINDOW_BORDER_COLOR'),
        ));
        return $this->display(__FILE__, 'bonzoom_1_7.tpl');
    }
}
