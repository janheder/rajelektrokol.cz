<?php

/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta News Manager with Videos and Comments
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

include_once(_PS_MODULE_DIR_ . 'bonnews/classes/ClassBonnews.php');

class Bonnews extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bonnews';
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
        $this->displayName = $this->l('News Manager with Videos and Comments');
        $this->description = $this->l('Allows you to create multifunctional posts with videos, images and comments, displays a carousel with posts on the home page.');
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
                $tab->name[$language['id_lang']] = 'bonnews';
            }
        }
        $tab->class_name = 'AdminAjaxBonnews';
        $tab->module = $this->name;
        $tab->id_parent = -1;
        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxBonnews')) {
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
            $this->registerHook('moduleRoutes') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayHome');
    }

    public function hookModuleRoutes()
    {
        $main_route = Configuration::get('BON_NEWS_MAINE_ROUTE') ? Configuration::get('BON_NEWS_MAINE_ROUTE') : 'news';

        return array(
            'module-bonnews-main' => array(
                'controller' => 'main',
                'rule'       => $main_route,
                'keywords'   => array(),
                'params'     => array(
                    'fc'     => 'module',
                    'module' => 'bonnews',
                ),
            ),
            'module-bonnews-post' => array(
                'controller' => 'post',
                'rule'       => $main_route . '/post{/:id_tab}_{:link_rewrite}',
                'keywords' => array(
                    'id_tab' => array('regexp' => '[0-9]+', 'param' => 'id_tab'),
                    'link_rewrite' => array('regexp' => '[_a-zA-Z0-9-\pL]*'),
                ),
                'params'     => array(
                    'fc'     => 'module',
                    'module' => 'bonnews',
                ),
            ),
        );
    }

    protected function installSamples()
    {
        $now = date('Y-m-d H:i:00');
        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 3; ++$i) {
            $item = new ClassBonnews();
            $item->id_shop = (int)$this->context->shop->id;
            $item->status = 1;
            $item->type = 'image';
            $item->date_post = $now;
            $item->sort_order = $i;
            $item->author_name = 'Maria Stone';
            foreach ($languages as $language) {
                $item->title[$language['id_lang']] = 'Our best news!';
                $item->url[$language['id_lang']] = 'our best news';
                $item->image[$language['id_lang']] = 'sample-' . $i . '.jpg';
                $item->author_img[$language['id_lang']] = 'author-1.jpg';
                $item->description[$language['id_lang']] = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque lau dantium, totam rem aperiam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Laborum. consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>';
                $item->content_post[$language['id_lang']] = '<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laud antium, totam rem aperiam.| Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque lau dantium, totam rem aperiam.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed quae, ultrices eros in cursus turpis massa tincidunt consectetur adipiscing. Praesent semper feugiat nibh sed pulvinar proinetus et malesuada fames ac turpis egestas maecenas pharetra convallis</p>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque lau dantium, totam rem aperiam. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusm od tempor incididunt ut labore et dolore magna aliqua. consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. consectetur adipiscing elit, sed do eius mod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <div class="row">
                <div class="col-xs-12 col-md-6">
                <h3>Consectetur adipiscing elit!</h3>
                <ul class="bon-news-list">
                <li class="bon-news-li">lorem ipsum dolor sit amet, consectetur adipiscing elit, sed quae, elit, sed quae</li>
                <li class="bon-news-li">ultrices eros in cursus turpis massa tincidunt consectetur adipiscing tempor inci</li>
                <li class="bon-news-li">praesent semper feugiat nibh sed pulvinar proin ipsum dolor sit amet, consectetur</li>
                <li class="bon-news-li">etus et malesuada fames ac turpis egestas maecenas pharetra convallis, sed do</li>
                <li class="bon-news-li">id semper risus in hendrerit gravida rutrum quisque, ipsum dolor sit amet, sed do</li>
                </ul>
                </div>
                <div class="col-xs-12 col-md-6">
                <h3>First lorem dolor sit!</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
                </div>
                </div>';
            }
            $item->add();
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
            'BON_NEWS_MAINE_ROUTE' => 'news',
            'BON_NEWS_HOME_TITLE' => 'Our News',
            'BON_NUMBER_NEWS' => 3,
            'BON_NEWS_LIMIT' => 6,
            'BON_NEWS_DISPLAY_CAROUSEL' => true,
            'BON_NEWS_DISPLAY_ITEM_NB' => 6,
            'BON_NEWS_CAROUSEL_NB' => 3,
            'BON_NEWS_CAROUSEL_LOOP' => false,
            'BON_NEWS_CAROUSEL_NAV' => true,
            'BON_NEWS_CAROUSEL_DOTS' => false,
            'BON_ADD_SHAREBUTTONS' => true,
            'BON_ADD_DISQUS' => true,
            'DISQUS_SHORT_NAME' => 'bonpresta',
        );

        return $settings;
    }

    public function getContent()
    {

        $output = '';
        $result = '';

        if (((bool)Tools::isSubmit('submitBonnewsSettingModule')) == true) {
            if (!$errors = $this->validateSettings()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Settings updated successful.'));
            } else {
                $output .= $errors;
            }
        }

        if ((bool)Tools::isSubmit('submitUpdateBonnews')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addBonnews();
            } else {
                $output = $result;
                $output .= $this->renderBonnewsForm();
            }
        }

        if ((bool)Tools::isSubmit('statusbonnews')) {
            $output .= $this->updateStatusTab();
        }

        if ((bool)Tools::isSubmit('deletebonnews')) {
            $output .= $this->deleteBonnews();
        }

        if (Tools::getIsset('updatebonnews') || Tools::getValue('updatebonnews')) {
            $output .= $this->renderBonnewsForm();
        } elseif ((bool)Tools::isSubmit('addbonnews')) {
            $output .= $this->renderBonnewsForm();
        } elseif (!$result) {
            $output .= $this->renderBonnewsList();
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
        $helper->submit_action = 'submitBonnewsSettingModule';
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
                        'label' => $this->l('Name of main news page'),
                        'name' => 'BON_NEWS_MAINE_ROUTE',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Home Section Title'),
                        'name' => 'BON_NEWS_HOME_TITLE',
                        'col' => 2,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Number of news on the main page'),
                        'name' => 'BON_NUMBER_NEWS',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Display item on home page'),
                        'name' => 'BON_NEWS_LIMIT',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Add social media share buttons'),
                        'name' => 'BON_ADD_SHAREBUTTONS',
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
                        'label' => $this->l('Display disqus comments on post page'),
                        'name' => 'BON_ADD_DISQUS',
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
                        'label' => $this->l('Disqus short name:'),
                        'name' => 'DISQUS_SHORT_NAME',
                        'col' => 2
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Carousel on home page:'),
                        'name' => 'BON_NEWS_DISPLAY_CAROUSEL',
                        'desc' => $this->l('Display banner in the carousel.'),
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
                        'form_group_class' => 'display-block-bonnews',
                        'type' => 'text',
                        'label' => $this->l('Items:'),
                        'name' => 'BON_NEWS_CAROUSEL_NB',
                        'col' => 2,
                        'desc' => $this->l('The number of items you want to see on the screen.'),
                    ),
                    array(
                        'form_group_class' => 'display-block-bonnews',
                        'type' => 'switch',
                        'label' => $this->l('Loop:'),
                        'name' => 'BON_NEWS_CAROUSEL_LOOP',
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
                        'form_group_class' => 'display-block-bonnews',
                        'type' => 'switch',
                        'label' => $this->l('Nav:'),
                        'name' => 'BON_NEWS_CAROUSEL_NAV',
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
                        'form_group_class' => 'display-block-bonnews',
                        'type' => 'switch',
                        'label' => $this->l('Dots:'),
                        'name' => 'BON_NEWS_CAROUSEL_DOTS',
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

        if (Tools::isEmpty(Tools::getValue('BON_NEWS_MAINE_ROUTE'))) {
            $errors[] = $this->l('Name of main news page is required.');
        }

        if (Tools::isEmpty(Tools::getValue('BON_NUMBER_NEWS'))) {
            $errors[] = $this->l('Number of news on the main page is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_NUMBER_NEWS'))) {
                $errors[] = $this->l('Bad number of news format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_NEWS_LIMIT'))) {
            $errors[] = $this->l('Limit is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_NEWS_LIMIT'))) {
                $errors[] = $this->l('Bad limit format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_NEWS_CAROUSEL_NB'))) {
            $errors[] = $this->l('Item is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_NEWS_CAROUSEL_NB'))) {
                $errors[] = $this->l('Bad item format');
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

    protected function postProcess()
    {
        $form_values = $this->getConfigFormValuesSettings();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function getBonnewsSettings()
    {
        $settings = $this->getModuleSettings();
        $get_settings = array();
        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = array('value' => $data, 'type' => $this->getStringValueType($data));
        }

        return $get_settings;
    }

    protected function renderBonnewsForm()
    {


        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ? $this->l('Update banner') : $this->l('Add banner')),
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
                        'label' => $this->l('Link Rewrit'),
                        'name' => 'url',
                        'required' => true,
                        'lang' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Type:'),
                        'name' => 'type',
                        'form_group_class' => 'content_type',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'image',
                                    'name' => $this->l('Image')
                                ),
                                array(
                                    'id' => 'video',
                                    'name' => $this->l('Video')
                                ),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'files_lang_cover',
                        'label' => $this->l('Cover image'),
                        'name' => 'cover',
                        'lang' => true,
                        'form_group_class' => 'files_lang_cover',
                        'desc' => $this->l('Format file .png, .jpg, .gif.'),
                    ),
                    array(
                        'type' => 'files_lang',
                        'label' => $this->l('Image / Video'),
                        'name' => 'image',
                        'lang' => true,
                        'col' => 6,
                        'desc' => $this->l('If the content`s type is image - format file .png, .jpg, .gif. If the content`s type is video - format file .mp4, .webm, .ogv.'),
                        'required' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Short description'),
                        'name' => 'description',
                        'autoload_rte' => true,
                        'lang' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Content'),
                        'name' => 'content_post',
                        'autoload_rte' => true,
                        'lang' => true,
                    ),
                    array(
                        'type' => 'datetime',
                        'label' => $this->l('Post Date'),
                        'name' => 'date_post',
                        'col' => 6,
                        'required' => true
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Author Post'),
                        'name' => 'author_name',
                        'col' => 3,
                        'desc' => $this->l('Format file .png, .jpg, .gif.'),
                    ),
                    array(
                        'type' => 'files_lang_author',
                        'label' => $this->l('Author image'),
                        'name' => 'author_img',
                        'lang' => true,
                        'form_group_class' => 'files_lang_author',
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
                        'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updatebonnews') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBonnews((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
            $fields_form['form']['images'] = $tab->image;
            $fields_form['form']['cover'] = $tab->cover;
            $fields_form['form']['author_img'] = $tab->author_img;
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateBonnews';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBonnewsFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
            'image_baseurl_video' => $this->_path . 'views/img/'
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBonnewsFormValues()
    {
        if ((bool)Tools::getIsset('updatebonnews') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBonnews((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassBonnews();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'title' => Tools::getValue('title', $tab->title),
            'url' => Tools::getValue('url', $tab->url),
            'image' => Tools::getValue('image', $tab->image),
            'cover' => Tools::getValue('cover', $tab->cover),
            'author_img' => Tools::getValue('author_img', $tab->author_img),
            'type' => Tools::getValue('type', $tab->type),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
            'date_post' => Tools::getValue('date_post', $tab->date_post),
            'author_name' => Tools::getValue('author_name', $tab->author_name),
        );

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $fields_values['description'][$lang['id_lang']] = Tools::getValue(
                'description_' . (int) $lang['id_lang'],
                isset($tab->description[$lang['id_lang']]) ? $tab->description[$lang['id_lang']] : ''
            );
            $fields_values['content_post'][$lang['id_lang']] = Tools::getValue(
                'content_post_' . (int) $lang['id_lang'],
                isset($tab->content_post[$lang['id_lang']]) ? $tab->content_post[$lang['id_lang']] : ''
            );
        }

        return $fields_values;
    }

    public function renderBonnewsList()
    {
        if (!$tabs = ClassBonnews::getBonnewsList()) {
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
            'type' => array(
                'title' => $this->l('Type'),
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
            'date_post' => array(
                'title' => $this->l('Post Date'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
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
        $helper->table = 'bonnews';
        $helper->actions = array('edit', 'delete');
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
            'image_baseurl_video' => $this->_path . 'views/img/'

        );

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addBonnews()
    {
        $errors = array();

        if ((int)Tools::getValue('id_tab') > 0) {
            $item = new ClassBonnews((int)Tools::getValue('id_tab'));
        } else {
            $item = new ClassBonnews();
        }

        $item->id_shop = (int)$this->context->shop->id;
        $item->status = (int)Tools::getValue('status');
        $item->type = Tools::getValue('type');
        $item->date_post = Tools::getValue('date_post');
        $item->author_name = Tools::getValue('author_name');

        if ((int)Tools::getValue('id_tab') > 0) {
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item->sort_order = $item->getMaxSortOrder((int)$this->id_shop);
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_' . $language['id_lang']);
            $item->description[$language['id_lang']] = Tools::getValue('description_' . $language['id_lang']);
            $item->content_post[$language['id_lang']] = Tools::getValue('content_post_' . $language['id_lang']);
            $item->url[$language['id_lang']] = Tools::getValue('url_' . $language['id_lang']);
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_' . $language['id_lang']]['name'], '.'), 1));
            $type_cover = Tools::strtolower(Tools::substr(strrchr($_FILES['cover_' . $language['id_lang']]['name'], '.'), 1));
            $type_author_img = Tools::strtolower(Tools::substr(strrchr($_FILES['author_img_' . $language['id_lang']]['name'], '.'), 1));

            if (isset($_FILES['author_img_' . $language['id_lang']]) && in_array($type_author_img, array('jpg', 'gif', 'jpeg', 'png', 'webp'))) {
                $salt = sha1(microtime());
                if (!move_uploaded_file($_FILES['author_img_' . $language['id_lang']]['tmp_name'], dirname(__FILE__) . '/views/img/' . $salt . '_' . $_FILES['author_img_' . $language['id_lang']]['name'])) {
                } else {
                    if (isset($_FILES['author_img_' . $language['id_lang']]) && isset($_FILES['author_img_' . $language['id_lang']]['tmp_name']) && !empty($_FILES['author_img_' . $language['id_lang']]['tmp_name'])) {
                        $item->author_img[$language['id_lang']] = $salt . '_' . $_FILES['author_img_' . $language['id_lang']]['name'];
                    } elseif (Tools::getValue('author_img_old_' . $language['id_lang']) != '') {
                        $item->author_img[$language['id_lang']] = Tools::getValue('author_img_old_' . $language['id_lang']);
                    }
                }
            }
            if (isset($_FILES['cover_' . $language['id_lang']]) && in_array($type_cover, array('jpg', 'gif', 'jpeg', 'png', 'webp'))) {
                $salt = sha1(microtime());
                if (!move_uploaded_file($_FILES['cover_' . $language['id_lang']]['tmp_name'], dirname(__FILE__) . '/views/img/' . $salt . '_' . $_FILES['cover_' . $language['id_lang']]['name'])) {
                } else {
                    if (isset($_FILES['cover_' . $language['id_lang']]) && isset($_FILES['cover_' . $language['id_lang']]['tmp_name']) && !empty($_FILES['cover_' . $language['id_lang']]['tmp_name'])) {
                        $item->cover[$language['id_lang']] = $salt . '_' . $_FILES['cover_' . $language['id_lang']]['name'];
                    } elseif (Tools::getValue('cover_old_' . $language['id_lang']) != '') {
                        $item->cover[$language['id_lang']] = Tools::getValue('cover_old_' . $language['id_lang']);
                    }
                }
            }

            if (Tools::getValue('type') == 'video') {
                $salt = sha1(microtime());
                if (!move_uploaded_file($_FILES['image_' . $language['id_lang']]['tmp_name'], dirname(__FILE__) . '/views/img/' . $salt . '_' . $_FILES['image_' . $language['id_lang']]['name'])) {
                } else {
                    if (isset($_FILES['image_' . $language['id_lang']]) && isset($_FILES['image_' . $language['id_lang']]['tmp_name']) && !empty($_FILES['image_' . $language['id_lang']]['tmp_name'])) {
                        $item->image[$language['id_lang']] = $salt . '_' . $_FILES['image_' . $language['id_lang']]['name'];
                    } elseif (Tools::getValue('image_old_' . $language['id_lang']) != '') {
                        $item->image[$language['id_lang']] = Tools::getValue('image_old_' . $language['id_lang']);
                    }
                }
            } elseif (Tools::getValue('type') == 'image') {
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
                    } elseif (!$temp_name || !move_uploaded_file($_FILES['image_' . $language['id_lang']]['tmp_name'], $temp_name)) {
                        return false;
                    } elseif (!ImageManager::resize($temp_name, dirname(__FILE__) . '/views/img/' . $salt . '_' . $_FILES['image_' . $language['id_lang']]['name'], null, null, $type)) {
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

        $class = new ClassBonnews((int)Tools::getValue('id_tab'));
       
        $old_image = $class->image;
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');

        if (!$old_image && (!isset($_FILES['image_' .  $this->default_language['id_lang']]) || Tools::isEmpty($_FILES['image_' .  $this->default_language['id_lang']]['tmp_name'])))  {

            $errors[] = $this->l('The file is required.');
        }

        if (Tools::isEmpty(Tools::getValue('date_post'))) {
            $errors[] = $this->l('The date start is required.');
        }

        if (!Validate::isDate(Tools::getValue('date_post'))) {
            $errors[] = $this->l('Invalid date field');
        }

        foreach ($languages as $lang) {
            if (!empty($_FILES['cover_' . $lang['id_lang']]['type'])) {
                if (ImageManager::validateUpload($_FILES['cover_' . $lang['id_lang']], 4000000)) {
                    $errors[] = $this->l('Image format not recognized, allowed format is: .gif, .jpg, .png');
                }
            }
            if (!empty($_FILES['author_img_' . $lang['id_lang']]['type'])) {
                if (ImageManager::validateUpload($_FILES['author_img_' . $lang['id_lang']], 4000000)) {
                    $errors[] = $this->l('Author Image format not recognized, allowed format is: .gif, .jpg, .png');
                }
            }
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
                if ($info->getExtension() != 'mp4' && $info->getExtension() != 'webm' && $info->getExtension() != 'ogv') {
                    $errors[] = $this->l('Video format not recognized, allowed format is: .mp4, .webm, .ogv');
                }
            }
        }

        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The name of post is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad name of post format.');
        }

        if (Tools::isEmpty(Tools::getValue('url_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The link rewrit is required.');
        } elseif (!Validate::isUrl(Tools::getValue('url_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad link rewrit format.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function deleteBonnews()
    {
        $tab = new ClassBonnews(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassBonnews(Tools::getValue('id_tab'));

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

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') != $this->name) {
            return;
        }
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBonnews'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBonnews'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path . 'views/js/bonnews_back.js');
        $this->context->controller->addCSS($this->_path . 'views/css/bonnews_back.css');
    }

    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path . 'views/js/slick.js');
        $this->context->controller->addCSS($this->_path . 'views/css/slick.css', 'all');
        $this->context->controller->addCSS($this->_path . 'views/css/slick-theme.css', 'all');
        $this->context->controller->addJS($this->_path . '/views/js/bonnews_front.js');
        $this->context->controller->addCSS($this->_path . '/views/css/bonnews_front.css');

        $this->context->smarty->assign('settings', $this->getBonnewsSettings());

        return $this->display($this->_path, '/views/templates/hook/bonnews-header.tpl');
    }

    public function hookDisplayHome()
    {
        $bonnews_front = new ClassBonnews();
        $tabs = $bonnews_front->getTopFrontItems($this->id_shop, true);
        $result = array();

        foreach ($tabs as $key => $tab) {
            $result[$key]['id'] = $tab['id_tab'];
            $result[$key]['title'] = $tab['title'];
            $result[$key]['description'] = mb_strimwidth($tab['description'],0,80, '...');
            $result[$key]['content_post'] = $tab['content_post'];
            $result[$key]['image'] = $tab['image'];
            $result[$key]['type'] = $tab['type'];
            $result[$key]['url'] = str_replace(' ', '_', $tab['url']);
            $result[$key]['cover'] = $tab['cover'];
            $result[$key]['author_img'] = $tab['author_img'];
            $result[$key]['date_post'] = $tab['date_post'];
            $result[$key]['author_name'] = $tab['author_name'];
        }

        if (Configuration::get('BON_ADD_DISQUS')) {
            $this->smarty->assign(array(
                'add_disqus'=> Configuration::get('BON_ADD_DISQUS'),
                'disqus_name'=> Configuration::get('DISQUS_SHORT_NAME')
            ));
        }

        $this->smarty->assign(array(
            'display_carousel' => Configuration::get('BON_NEWS_DISPLAY_CAROUSEL'),
            'items'=> $result,
            'news_page'=> __PS_BASE_URI__ . Configuration::get('BON_NEWS_MAINE_ROUTE'),
            'image_baseurl'=> $this->_path . 'views/img/',
            'limit'=> Configuration::get('BON_NEWS_LIMIT'),
            'home_title'=> Configuration::get('BON_NEWS_HOME_TITLE'),
        ));

        return $this->display(__FILE__, 'views/templates/hook/bonnews-home.tpl');
    }

    public function hookdisplayTop()
    {
        return $this->hookDisplayHome();
    }

    public function hookdisplayTopColumn()
    {
        return $this->hookDisplayHome();
    }

    public function hookdisplayLeftColumn()
    {
        return $this->hookDisplayHome();
    }
}
