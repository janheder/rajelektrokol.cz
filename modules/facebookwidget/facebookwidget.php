<?php
/**
 * 2015-2017 Bonpresta
 *
 * Bonpresta Facebook Like Box
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
 *  @copyright 2015-2017 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Facebookwidget extends Module
{
    public function __construct()
    {
        $this->name = 'facebookwidget';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '0c50f9a293bce7d2c219d8ea420d9131';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Facebook Like Box');
        $this->description = $this->l('Display facebook like box.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    protected function getConfigurations()
    {
        $configurations = array(
            'FACEBOOK_ITEM_STATUS' => true,
            'FACEBOOK_ITEM_SELECT' => 'timeline',
            'FACEBOOK_ITEM_USER_NAME' => 'https://www.facebook.com/prestashop/',
            'FACEBOOK_ITEM_WIDTH' => 350,
            'FACEBOOK_ITEM_HEIGHT' => 650,
            'FACEBOOK_ITEM_HEADER' => true,
            'FACEBOOK_ITEM_COVER' => true,
            'FACEBOOK_ITEM_FACES' => true,
        );

        return $configurations;
    }

    public function install()
    {
        $this->clearCache();

        $configurations = $this->getConfigurations();

        foreach ($configurations as $name => $config) {
            Configuration::updateValue($name, $config);
        }

        return parent::install() &&
        $this->registerHook('displayHeader') &&
        $this->registerHook('displayWrapperBottom');
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
                $this->clearCache();
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
                        'label' => $this->l('Enable'),
                        'name' => 'FACEBOOK_ITEM_STATUS',
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
                        'label' => $this->l('Select'),
                        'name' => 'FACEBOOK_ITEM_SELECT',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'timeline',
                                    'name' => $this->l('timeline')),
                                array(
                                    'id' => 'messages',
                                    'name' => $this->l('messages')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'text',
                        'required' => true,
                        'label' => $this->l('Facebook link:'),
                        'name' => 'FACEBOOK_ITEM_USER_NAME',
                        'col' => 2
                    ),
                    array(
                        'type' => 'text',
                        'required' => true,
                        'label' => $this->l('Width:'),
                        'name' => 'FACEBOOK_ITEM_WIDTH',
                        'col' => 2
                    ),
                    array(
                        'type' => 'text',
                        'required' => true,
                        'label' => $this->l('Height:'),
                        'name' => 'FACEBOOK_ITEM_HEIGHT',
                        'col' => 2
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Small header'),
                        'name' => 'FACEBOOK_ITEM_HEADER',
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
                        'label' => $this->l('Hide cover'),
                        'name' => 'FACEBOOK_ITEM_COVER',
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
                        'label' => $this->l('Show faces'),
                        'name' => 'FACEBOOK_ITEM_FACES',
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
            'fields_value' => $this->getConfigFieldsValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form));
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

        if (Tools::isEmpty(Tools::getValue('FACEBOOK_ITEM_USER_NAME'))) {
            $errors[] = $this->l('The Name is required.');
        }

        if (Tools::isEmpty(Tools::getValue('FACEBOOK_ITEM_WIDTH'))) {
            $errors[] = $this->l('Width is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('FACEBOOK_ITEM_WIDTH'))) {
                $errors[] = $this->l('Bad width format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('FACEBOOK_ITEM_HEIGHT'))) {
            $errors[] = $this->l('Height is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('FACEBOOK_ITEM_HEIGHT'))) {
                $errors[] = $this->l('Bad height format');
            }
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function getSmartyConfigurations()
    {
        return array(
            'status' => Configuration::get('FACEBOOK_ITEM_STATUS'),
            'name' => Configuration::get('FACEBOOK_ITEM_USER_NAME'),
            'tabs' => Configuration::get('FACEBOOK_ITEM_SELECT'),
            'width' => Configuration::get('FACEBOOK_ITEM_WIDTH'),
            'height' => Configuration::get('FACEBOOK_ITEM_HEIGHT'),
            'header' => Configuration::get('FACEBOOK_ITEM_HEADER'),
            'cover' => Configuration::get('FACEBOOK_ITEM_COVER'),
            'faces' => Configuration::get('FACEBOOK_ITEM_FACES')
        );
    }

    protected function langCode($code)
    {
        $expcode = explode('-', $code);
        if (count($expcode) > 1) {
            $code_upper = Tools::strtoupper($expcode[1]);
            $code = $expcode[0].'_'.$code_upper;
        } else {
            $code = Tools::strtoupper($code);
        }
        return $code;
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addJS($this->_path . '/views/js/facebook.js');
         $this->context->controller->addCSS($this->_path . '/views/css/bonfacebook.css');
        Media::addJsDefL('l_code', $this->langCode($this->context->language->language_code));
    }

    protected function clearCache()
    {
        $this->_clearCache('facebook-footer.tpl');
        $this->_clearCache('facebook-column.tpl');
        $this->_clearCache('facebook-home.tpl');
    }

    public function hookDisplayFooter()
    {
        if (Configuration::get('FACEBOOK_ITEM_STATUS')) {
            if (!$this->isCached('facebook-footer.tpl', $this->getCacheId())) {
                $this->context->smarty->assign('configurations', $this->getSmartyConfigurations());
            }

            return $this->display($this->_path, '/views/templates/hook/facebook-footer.tpl', $this->getCacheId());
        }
    }

    public function hookDisplayLeftColumn()
    {
        if (Configuration::get('FACEBOOK_ITEM_STATUS')) {
            if (!$this->isCached('facebook-column.tpl', $this->getCacheId())) {
                $this->context->smarty->assign('configurations', $this->getSmartyConfigurations());
            }

            return $this->display($this->_path, '/views/templates/hook/facebook-column.tpl', $this->getCacheId());
        }
    }

    public function hookRightColumn($params)
    {
        return $this->hookLeftColumn($params);
    }

    public function hookDisplayWrapperBottom($params)
    {
        if (Configuration::get('FACEBOOK_ITEM_STATUS')) {
              if (!$this->isCached('facebook-home.tpl', $this->getCacheId())) {
                  $this->context->smarty->assign('configurations', $this->getSmartyConfigurations());
              }

              return $this->display($this->_path, '/views/templates/hook/facebook-home.tpl', $this->getCacheId());
          }
    }

    public function hookDisplayHome()
    {
        if (Configuration::get('FACEBOOK_ITEM_STATUS')) {
            if (!$this->isCached('facebook-home.tpl', $this->getCacheId())) {
                $this->context->smarty->assign('configurations', $this->getSmartyConfigurations());
            }

            return $this->display($this->_path, '/views/templates/hook/facebook-home.tpl', $this->getCacheId());
        }
    }
}
