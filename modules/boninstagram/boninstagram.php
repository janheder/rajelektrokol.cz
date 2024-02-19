<?php

/**
 * 2015-2022 Bonpresta
 *
 * Bonpresta Instagram Gallery Feed Photos & Videos User
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

class Boninstagram extends Module
{
    public function __construct()
    {
        $this->name = 'boninstagram';
        $this->tab = 'front_office_features';
        $this->version = '6.5.0';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '326408ef23a0f027bd72253a6f8b70b9';
        $this->site_url = _PS_BASE_URL_ . __PS_BASE_URI__;
        parent::__construct();
        $this->displayName = $this->l('Instagram Gallery Feed Photos & Videos User');
        $this->description = $this->l('Display instagram carousel feed photos and videos');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->controllers = array(
            'instagram'
        );
    }

    protected function getModuleSettings()
    {
        $res = array(
            'BONINSTAGRAM_DISPLAY' => true,
            'BONINSTAGRAM_CACHE' => false,
            'BONINSTAGRAM_ACCESS_TOKEN' => '',
            'BONINSTAGRAM_LIMIT' => 8,
            'BONINSTAGRAM_DISPLAY_CAROUSEL' => true,
            'BONINSTAGRAM_NB' => 4,
            'BONINSTAGRAM_SPEED' => 5000,
            'BONINSTAGRAM_MARGIN' => 30,
            'BONINSTAGRAM_LOOP' => true,
            'BONINSTAGRAM_NAV' => true,
            'BONINSTAGRAM_DOTS' => false,
            'BONINSTAGRAM_USER' => true,
            'BONINSTAGRAM_DATE' => true,
            'BONINSTAGRAM_ICON' => true,
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
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('moduleRoutes') &&
            $this->registerHook('displayBonInstagram') &&
            $this->registerHook('displayHome');
    }

    public function hookModuleRoutes()
    {
        return array(
            'module-boninstagram-instagram' => array(
                'controller' => 'instagram',
                'rule'       => 'instagram',
                'keywords'   => array(),
                'params'     => array(
                    'fc'     => 'module',
                    'module' => 'boninstagram',
                ),
            ),
        );
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
        } elseif (Tools::isSubmit('bonRefreshToken')) {
            $token = $this->refreshAccessToken();
            if ($token) {
                die(json_encode(array(
                    'success' => true,
                    'token' => $token,
                    'message' => $this->l('Token successfully updated')
                )));
            }
            die(json_encode(array(
                'success' => false,
                'message' => $this->l('Token has not been updated')
            )));
        }



        return $output . $this->renderForm();
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

        if (Tools::isEmpty(Tools::getValue('BONINSTAGRAM_LIMIT'))) {
            $errors[] = $this->l('Limit is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BONINSTAGRAM_LIMIT'))) {
                $errors[] = $this->l('Bad limit format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BONINSTAGRAM_NB'))) {
            $errors[] = $this->l('Item is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BONINSTAGRAM_NB'))) {
                $errors[] = $this->l('Bad item format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BONINSTAGRAM_ACCESS_TOKEN'))) {
            $errors[] = $this->l('Access token is required.');
        }

        if (Tools::isEmpty(Tools::getValue('BONINSTAGRAM_MARGIN'))) {
            $errors[] = $this->l('Autoplay Speed is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BONINSTAGRAM_MARGIN'))) {
                $errors[] = $this->l('Bad autoplay speed format');
            }
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function getConfigInstagram()
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
                        'label' => $this->l('Access token'),
                        'name' => 'BONINSTAGRAM_ACCESS_TOKEN',
                        'col' => 2,
                        'desc'=> 'Images will be taken from the account that owns the token',
                        'required' => true,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Instagram Feed'),
                        'name' => 'BONINSTAGRAM_DISPLAY',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'enable',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'disable',
                                'value' => 0,
                                'label' => $this->l('No')
                            ),
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Activate image caching'),
                        'name' => 'BONINSTAGRAM_CACHE',
                        'is_bool' => true,
                        'desc'=> 'when activated, the images will be cached, and the cache will be cleared once a day',
                        'values' => array(
                            array(
                                'id' => 'enable',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'disable',
                                'value' => 0,
                                'label' => $this->l('No')
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Display item'),
                        'name' => 'BONINSTAGRAM_LIMIT',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Display username on hover'),
                        'name' => 'BONINSTAGRAM_USER',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'enable',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'disable',
                                'value' => 0,
                                'label' => $this->l('No')
                            ),
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Display post creation date on hover'),
                        'name' => 'BONINSTAGRAM_DATE',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'enable',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'disable',
                                'value' => 0,
                                'label' => $this->l('No')
                            ),
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show instagram icon on hover'),
                        'name' => 'BONINSTAGRAM_ICON',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'enable',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'disable',
                                'value' => 0,
                                'label' => $this->l('No')
                            ),
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Carousel:'),
                        'name' => 'BONINSTAGRAM_DISPLAY_CAROUSEL',
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
                        'form_group_class' => 'display',
                        'type' => 'text',
                        'required' => true,
                        'label' => $this->l('Number of items in the carousel:'),
                        'name' => 'BONINSTAGRAM_NB',
                        'col' => 2,
                        'desc' => $this->l('The number of items you want to see on the screen.'),
                    ),
                    array(
                        'form_group_class' => 'display',
                        'type' => 'text',
                        'required' => true,
                        'label' => $this->l('Autoplay Speed:'),
                        'name' => 'BONINSTAGRAM_SPEED',
                        'col' => 2,
                        'suffix' => 'milliseconds',
                    ),
                    array(
                        'form_group_class' => 'display',
                        'type' => 'text',
                        'label' => $this->l('Indent between pictures:'),
                        'name' => 'BONINSTAGRAM_MARGIN',
                        'suffix' => 'pixels',
                        'col' => 2,
                    ),
                    array(
                        'form_group_class' => 'display',
                        'type' => 'switch',
                        'label' => $this->l('Infinite:'),
                        'name' => 'BONINSTAGRAM_LOOP',
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
                        'form_group_class' => 'display',
                        'type' => 'switch',
                        'label' => $this->l('Navigation:'),
                        'name' => 'BONINSTAGRAM_NAV',
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
                        'form_group_class' => 'display',
                        'type' => 'switch',
                        'label' => $this->l('Pagination:'),
                        'name' => 'BONINSTAGRAM_DOTS',
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

    public function renderForm()
    {
        $helper = new HelperForm();
        $helper->module = $this;
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ?
            Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitSettings';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) .
            '&configure=' . $this->name .
            '&tab_module=' . $this->tab .
            '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'linkAjax' => $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name,
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($this->getConfigInstagram()));
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

    public function getInstagramImages()
    {
        $request = $this->getInstagramRequest();
        $result = json_decode($request, true);
        $data = array();
        $index = 1;

        if ($result && isset($result['data']) && $result['data']) {
            foreach ($result['data'] as $post) {
                $data[] = array(
                    'url' => isset($post['media_url']) ? $post['media_url'] : '',
                    'is_video' => $post['media_type'] === 'VIDEO' ? true : false,
                    'comment' => isset($post['caption']) && $post['caption'] ? $post['caption'] : false,
                    'thumbnail' => isset($post['thumbnail_url']) ? $post['thumbnail_url'] : $post['media_url'],
                    'username' => $post['username'],
                    'posted_date' => date_format(date_create($post['timestamp']), 'F j, Y')
                );

                $sourcecode = $this->GetImageFromUrl(isset($post['media_url']) ? $post['media_url'] : '');

                if ($post['media_type'] === 'VIDEO') {
                    $savefile = fopen(_PS_MODULE_DIR_ . 'boninstagram/views/img/sample-' . $index++ . '.mp4', 'w');
                } else {
                    $savefile = fopen(_PS_MODULE_DIR_ . 'boninstagram/views/img/sample-' . $index++ . '.jpg', 'w');
                }

                fwrite($savefile, $sourcecode);
                fclose($savefile);
            }
        }

        return $data;
    }
    public function getInstagramRequest()
    {
        $token = Configuration::get('BONINSTAGRAM_ACCESS_TOKEN');
        $fields = '&fields=caption,media_type,media_url,permalink,thumbnail_url,timestamp,username';
        $requestUrl = 'https://graph.instagram.com/me/media?access_token=' . $token . $fields;

        return $this->postRequest($requestUrl);
    }

    public function postRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function refreshAccessToken()
    {
        $token = Configuration::get('BONINSTAGRAM_ACCESS_TOKEN');
        $requestUrl = 'https://graph.instagram.com/refresh_access_token'
            .'?grant_type=ig_refresh_token&access_token=' . $token;
        $result = $this->postRequest($requestUrl);
        $json = json_decode($result, true);

        if (isset($json['access_token'])) {
            Configuration::updateValue('BONINSTAGRAM_ACCESS_TOKEN', $json['access_token']);

            return $json['access_token'];
        }
        return null;
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') != $this->name) {
            return;
        }
        $this->context->controller->addJquery();
        $this->context->controller->addJS($this->_path . 'views/js/boninstagram_admin.js');
        $this->context->controller->addCSS($this->_path . 'views/css/boninstagram-back.css');
        Media::addJsDefL('base_dir', _MODULE_DIR_);
        Media::addJsDefL('BONINSTAGRAM_LIMIT', Configuration::get('BONINSTAGRAM_LIMIT'));
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path . 'views/css/boninstagram.css', 'all');
        Media::addJsDefL('base_dir', _MODULE_DIR_);
        Media::addJsDefL('BONINSTAGRAM_LIMIT', Configuration::get('BONINSTAGRAM_LIMIT'));
        Media::addJsDefL('BONINSTAGRAM_DISPLAY_CAROUSEL', Configuration::get('BONINSTAGRAM_DISPLAY_CAROUSEL'));
        $this->context->controller->addJS($this->_path . '/views/js/boninstagram_front.js');

        if (Configuration::get('BONINSTAGRAM_DISPLAY_CAROUSEL')) {
            $this->context->controller->addCSS($this->_path . 'views/css/slick.css', 'all');
            $this->context->controller->addCSS($this->_path . 'views/css/slick-theme.css', 'all');
            $this->context->controller->addJS($this->_path . 'views/js/slick.js');
            $this->context->controller->addJS($this->_path . '/views/js/slick-front.js');
            Media::addJsDefL('BONINSTAGRAM_NB', Configuration::get('BONINSTAGRAM_NB'));
            Media::addJsDefL('BONINSTAGRAM_SPEED', Configuration::get('BONINSTAGRAM_SPEED'));
            Media::addJsDefL('BONINSTAGRAM_MARGIN', Configuration::get('BONINSTAGRAM_MARGIN'));
            Media::addJsDefL('BONINSTAGRAM_LOOP', Configuration::get('BONINSTAGRAM_LOOP'));
            Media::addJsDefL('BONINSTAGRAM_NAV', Configuration::get('BONINSTAGRAM_NAV'));
            Media::addJsDefL('BONINSTAGRAM_DOTS', Configuration::get('BONINSTAGRAM_DOTS') == 1 ? 1 : 0);
        }
    }

    protected function getStringValueType($data)
    {
        if (Validate::isInt($data)) {
            return 'int';
        } elseif (Validate::isFloat($data)) {
            return 'float';
        } elseif (Validate::isBool($data)) {
            return 'bool';
        } else {
            return 'string';
        }
    }

    protected function getBlankSettings()
    {
        $settings = $this->getModuleSettings();
        $get_settings = array();

        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = array('value' => $data, 'type' => $this->getStringValueType($data));
        }

        return $get_settings;
    }
    public function GetImageFromUrl($link)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function hookDisplayHome()
    {
        if (Configuration::get('BONINSTAGRAM_CACHE')) {
            $images = Configuration::get('BONINSTAGRAM_CACHE_'.$this->context->language->id);
            $date = json_decode(Configuration::get('BONINSTAGRAM_DATE_CACHE_'.$this->context->language->id));

            if ($date == '') {
                $date = true;
            } else {
                // converting the received date from a string to a date object
                $date_cache = datetime::createfromformat('Y-m-d-h-i-s', $date);
                // the current date
                $now_date = date_create_from_format('Y-m-d-h-i-s', date('Y-m-d-h-i-s'));
                // comparing dates
                $diff = (array) date_diff($date_cache, $now_date);

                if ($diff['d'] >= 1) {
                    $date = true;
                } else {
                    $date = false;
                }
            }

            if ($images == '' || $date)
            {
                // cache creation date
                $date_cache = date_create_from_format('Y-m-d-h-i-s', date('Y-m-d-h-i-s'));
                // convert date to cache entry format
                $date_cache = json_encode($date_cache->format('Y-m-d-h-i-s'));
                $images = json_encode($this->getInstagramImages());

                Configuration::updateValue('BONINSTAGRAM_CACHE_'.$this->context->language->id, $images);
                Configuration::updateValue('BONINSTAGRAM_DATE_CACHE_'.$this->context->language->id, $date_cache);
            }

            $images = json_decode($images, true);

        } else {
            $images = $this->getInstagramImages();
        }

        if (Configuration::get('BONINSTAGRAM_DISPLAY')) {
            $this->context->smarty->assign(array(
                'display_carousel' => Configuration::get('BONINSTAGRAM_DISPLAY_CAROUSEL'),
                'baseurl' =>  _MODULE_DIR_ . '/boninstagram/views/',
                'images' => $images,
                'show_user' => Configuration::get('BONINSTAGRAM_USER'),
                'show_date' => Configuration::get('BONINSTAGRAM_DATE'),
                'show_icon' => Configuration::get('BONINSTAGRAM_ICON'),
                'limit' => Configuration::get('BONINSTAGRAM_LIMIT'),
            ));
            return $this->display(__FILE__, 'boninstagram.tpl');
        }
    }

    public function hookdisplayBonInstagram()
    {
        return $this->hookDisplayHome();
    }

    public function hookdisplayFooterBefore()
    {
        return $this->hookDisplayHome();
    }
}
