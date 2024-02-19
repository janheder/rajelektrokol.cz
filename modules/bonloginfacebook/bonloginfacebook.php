<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Facebook login
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

class Bonloginfacebook extends Module
{
    public function __construct()
    {
        $this->name = 'bonloginfacebook';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '41ab177289d8e25d96cbb46325e817a8';
        parent::__construct();
        $this->displayName = $this->l('Facebook logins');
        $this->description = $this->l('Display Facebook login');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        if (!Configuration::get('bonloginfacebook'));
    }

    protected function getModuleSettings()
    {
        $res = array(
            'BONFACEBOOKLOGIN_APP' => '',
            'BONFACEBOOKLOGIN_SECRET' => '',
            'BONGOOGLELOGIN_APP' => '',
            'BONGOOGLELOGIN_SECRET' => '',
        );

        return $res;
    }


    public function install()
    {
        $settings = $this->getModuleSettings();

        foreach ($settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        return parent::install() && 
            $this->registerHook('displayBonLogFacebookimg') &&
            $this->registerHook('displayBonLogFacebook') &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayBeforeBodyClosingTag') &&
            $this->createFacebookCustomersTbl() &&
            $this->moveOverriteFile();
    }

    public function uninstall()
    {
        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            Configuration::deleteByName($name);
        }

        return parent::uninstall();
    }


    public function getContent()
    {
        $output = '';

        if ((bool)Tools::isSubmit('submitSettings')) {
            if (!$errors = $this->checkItemFields()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Save all settings.'));
            } else {
                $output .= $errors;
            }
        }

        return $output.$this->renderForm();
    }

    protected function postProcess()
    {
        $form_values = $this->getConfigFieldsValues();
        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function checkItemFields()
    {
        $errors = array();

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function getConfigFacebook()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings Instagram'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Facebook App ID:'),
                        'name' => 'BONFACEBOOKLOGIN_APP',
                        'size' => '50',
                        'desc' => $this->l('You will need to register a new application(This app is in development mode - https://developers.facebook.com/).')
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Facebook App Secret:'),
                        'name' => 'BONFACEBOOKLOGIN_SECRET',
                        'size' => '50',
                        'desc' => $this->l('The App Secret is used in some of the Login flows to generate access tokens and the Secret itself is intended to secure usage of your App.')
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Google client ID:'),
                        'name' => 'BONGOOGLELOGIN_APP',     
                        'size' => '100',
                        'desc' => $this->l('You will need to create authorization credentials (Go to the Credentials page - https://console.developers.google.com/apis/credentials).')

                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Google client secret code:'),
                        'name' => 'BONGOOGLELOGIN_SECRET',
                        'size' => '100'
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );
    }

    public function renderForm()
    {
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitSettings';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).
            '&configure='.$this->name.
            '&tab_module='.$this->tab.
            '&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($this->getConfigFacebook()));
    }

    protected function getConfigFieldsValues()
    {
        $filled_settings = array();
        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            $filled_settings[$name] = Configuration::get($name);
        }

        return $filled_settings;
    }

    public function  hookDisplayTop()
    {
         return $this->display(__FILE__, 'bonloginfacebook.tpl');

    }

    public function  hookDisplayBonLogFacebook()
    {
         return $this->display(__FILE__, 'bonloginfacebook.tpl');

    }

    public function  hookDisplayBonLogFacebookImg()
    {
         return $this->display(__FILE__, 'bonloginfacebookimg.tpl');

    }

 

    public function hookDisplayBeforeBodyClosingTag()
    {
            $fb_user_id = '';
            $fb_user_connected = 0;

            if (isset(Context::getContext()->cookie->fb_user_id)) {
                $fb_user_id = (int)Context::getContext()->cookie->fb_user_id;
                $fb_user_connected = 1;
            }

            $is_logged = (int)$this->context->customer->isLogged();
            $this->context->smarty->assign(array(
                'bon_facebook_app_id' => Configuration::get('BONFACEBOOKLOGIN_APP'),
                'facebook_app_secret' => Configuration::get('BONFACEBOOKLOGIN_SECRET'),
                'bon_google_app_id' => Configuration::get('BONGOOGLELOGIN_APP'),
                'google_app_secret' => Configuration::get('BONGOOGLELOGIN_SECRET')
            ));

            $this->context->smarty->assign('islogged', $is_logged);
            $this->context->smarty->assign('fb_user_connected', $fb_user_connected);
            $this->context->smarty->assign('fb_user_id', $fb_user_id);
            $this->context->smarty->assign('mod_dir', _MODULE_DIR_);

        return $this->display(__FILE__, 'script.tpl');

    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'views/css/bonloginfacebook.css', 'all');
    }

    public function curPageURL()
    {
        $pageURL = 'http';

        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }

        $pageURL .= "://";

        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }

        return $pageURL;
    }

    public function createFacebookCustomersTbl()
    {
        $db = Db::getInstance();
        $query = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'fbconnect_customer (
          `cust_id` int(10) NOT NULL,
          `fb_id` bigint(20) NOT NULL,
          UNIQUE KEY `FB_CUSTOMER` (`cust_id`,`fb_id`)
        ) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8';
        $db->Execute($query);
        return true;
    }

    public function dropFacebookCustomersTbl()
    {
        $db = Db::getInstance();
        $query = 'DROP TABLE '._DB_PREFIX_.'fbconnect_customer';
        $db->Execute($query);
        return true;
    }

    public function bonupsshippinglabel_filewrite($destination, $source)
    {
        $data = Tools::file_get_contents($source);
        $handle = fopen($destination, "w");

        if (!fwrite($handle, $data)) {
            return false;
        }

        fclose($handle);
        return true;
    }

    public function moveOverriteFile()
    {
        $path1 = _PS_ROOT_DIR_.'/override/classes/controller/FrontController.php';
        $path2 = _PS_ROOT_DIR_.'/modules/bonloginfacebook/bonoverride/classes/FrontController.php';
        $path3 = _PS_ROOT_DIR_.'/modules/bonloginfacebook/bonoverride/classes/backup/FrontController.php';

        if (file_exists($path1)) {
            $this->bonupsshippinglabel_filewrite($path3, $path1);
        }

        if (!$this->bonupsshippinglabel_filewrite($path1, $path2)) {
            return false;
        }

        return true;
    }
}
