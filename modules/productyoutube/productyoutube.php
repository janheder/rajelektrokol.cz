<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Product Video Youtube
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

include_once(_PS_MODULE_DIR_.'productyoutube/classes/ClassProductYoutube.php');

class Productyoutube extends Module
{
    public function __construct()
    {
        $this->name = 'productyoutube';
        $this->tab = 'front_office_features';
        $this->version = '1.0.2';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '0c958148fa69ca5d43e765ae53a350d0';
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Product Video Youtube');
        $this->description = $this->l('Module display product video Youtube.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        if (Configuration::get('PS_SSL_ENABLED')) {
            $this->ssl = 'https://';
        } else {
            $this->ssl = 'http://';
        }
        $this->id_shop = Context::getContext()->shop->id;
    }

    protected function getModuleSettings()
    {
        $res = array(
            'PRODUCT_VIDEO_CONTROLS' => true,
            'PRODUCT_VIDEO_INFO' => true,
            'PRODUCT_VIDEO_LOOP' => true,
            'PRODUCT_VIDEO_THEME' => 'light',
        );

        return $res;
    }

    public function createAjaxController()
    {
        $tab = new Tab();
        $tab->active = 1;
        $languages = Language::getLanguages(false);
        if (is_array($languages)) {
            foreach ($languages as $language) {
                $tab->name[$language['id_lang']] = 'productyoutube';
            }
        }
        $tab->class_name = 'AdminAjaxProductYoutube';
        $tab->module = $this->name;
        $tab->id_parent = - 1;
        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxProductYoutube')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {
        $this->clearCache();
        include(dirname(__FILE__).'/sql/install.php');
        $settings = $this->getModuleSettings();

        foreach ($settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        if (_PS_VERSION_ >= 1.7) {
            return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->createAjaxController() &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayProductTab') &&
            $this->registerHook('displayProductTabContent') &&
            $this->registerHook('productFooter');
        } else {
            return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->createAjaxController() &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('productFooter');
        }
    }


    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');
        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            Configuration::deleteByName($name);
        }

        return parent::uninstall()
        && $this->removeAjaxContoller();
    }

    public function getContent()
    {
        $output = '';
        $result = '';

        if ((bool)Tools::isSubmit('submitSettings')) {
            if (!$errors = $this->checkItemFields()) {
                $this->postProcess();
                $this->clearCache();
                $output .= $this->displayConfirmation($this->l('Save all settings.'));
            } else {
                $output .= $errors;
            }
        }

        if ((bool)Tools::isSubmit('submitUpdate')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addTab();
            } else {
                $output = $result;
                $output .= $this->renderTabForm();
            }
        }

        if ((bool)Tools::isSubmit('statusproductyoutube')) {
            $output .= $this->updateStatusTab();
        }

        if ((bool)Tools::isSubmit('deleteproductyoutube')) {
            $output .= $this->deleteTab();
        }

        if (Tools::getIsset('updateproductyoutube') || Tools::getValue('updateproductyoutube')) {
            $output .= $this->renderTabForm();
        } elseif ((bool)Tools::isSubmit('addproductyoutube')) {
            $output .= $this->renderTabForm();
        } elseif (!$result) {
            $output .= $this->renderForm();
            $output .= $this->renderTabList();
        }

        return $output;
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

        return $helper->generateForm(array($this->getConfig()));
    }

    protected function getConfig()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Controls:'),
                        'name' => 'PRODUCT_VIDEO_CONTROLS',
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
                        'label' => $this->l('Show info:'),
                        'name' => 'PRODUCT_VIDEO_INFO',
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
                        'label' => $this->l('Loop:'),
                        'name' => 'PRODUCT_VIDEO_LOOP',
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
                        'label' => $this->l('Theme:'),
                        'name' => 'PRODUCT_VIDEO_THEME',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'light',
                                    'name' => $this->l('Light')),
                                array(
                                    'id' => 'dark',
                                    'name' => $this->l('Dark')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );
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

    protected function checkItemFields()
    {
        $errors = array();

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function postProcess()
    {
        $form_values = $this->getConfigFieldsValues();
        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function clearCache()
    {
        $this->_clearCache('productyoutube.tpl');
    }

    protected function renderTabForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ? $this->l('Update tab') : $this->l('Add tab')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'select_product',
                        'label' => $this->l('Select a product:'),
                        'class' => 'id_product',
                        'name' => 'id_product',
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
                        'type' => 'text',
                        'label' => $this->l('Video code'),
                        'name' => 'url',
                        'lang' => true,
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'files_lang',
                        'label' => $this->l('Cover image'),
                        'name' => 'image',
                        'lang' => true
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Description video'),
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
                        'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updateproductyoutube') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassProductYoutube((int)Tools::getValue('id_tab'));
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
        $helper->submit_action = 'submitUpdate';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'image_baseurl' => $this->_path.'images/',
            'pr_img_dir' => _THEME_PROD_DIR_,
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
        );
        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigFormValues()
    {
        if ((bool)Tools::getIsset('updateproductyoutube') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassProductYoutube((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassProductYoutube();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'id_product' => $tab->id_product,
            'product_name' => ClassProductYoutube::getProductName($tab->id_product),
            'link_rewrite' => ClassProductYoutube::getProductLinkRewrite($tab->id_product),
            'title' => Tools::getValue('title', $tab->title),
            'url' => Tools::getValue('url', $tab->url),
            'image' => Tools::getValue('image', $tab->image),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
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

    public function renderTabList()
    {
        if (!$tabs = ClassProductYoutube::getProductYoutubeList()) {
            $tabs = array();
        }

        $fields_list = array(
            'id_tab' => array(
                'title' => $this->l('Id tab'),
                'type'  => 'id_tab',
                'align' => 'center',
                'search' => false,
            ),
            'id_product' => array(
                'title' => $this->l('Id product'),
                'type'  => 'id_product',
                'align' => 'center',
                'search' => false,
            ),
            'title' => array(
                'title' => $this->l('Name'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ),
            'url' => array(
                'title' => $this->l('Video'),
                'type'  => 'block_video',
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
        $helper->table = 'productyoutube';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->displayName;
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex
                .'&configure='.$this->name.'&add'.$this->name
                .'&token='.Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Add new item')
        );
        $helper->currentIndex = AdminController::$currentIndex
            .'&configure='.$this->name.'&id_shop='.(int)$this->context->shop->id;

        $helper->tpl_vars = array(
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'pr_img_dir' => _THEME_PROD_DIR_,
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
        );

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addTab()
    {
        $errors = array();

        if ((int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassProductYoutube((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassProductYoutube();
        }

        $tab->id_shop = (int)$this->context->shop->id;
        $tab->status = (int)Tools::getValue('status');
        $tab->id_product = (int)Tools::getValue('id_product');

        if ((int)Tools::getValue('id_tab') > 0) {
            $tab->sort_order = (int)Tools::getValue('sort_order');
        } else {
            $tab->sort_order = $tab->getMaxSortOrder((int)$this->id_shop);
        }

        $languages = Language::getLanguages(false);
        foreach ($languages as $language) {
            $tab->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
            $tab->url[$language['id_lang']] = Tools::getValue('url_'.$language['id_lang']);
            $tab->description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang']);
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_'.$language['id_lang']]['name'], '.'), 1));
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
                } elseif (!$temp_name || !move_uploaded_file($_FILES['image_'.$language['id_lang']]['tmp_name'], $temp_name)) {
                    return false;
                } elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/images/'.$salt.'_'.$_FILES['image_'.$language['id_lang']]['name'], null, null, $type)) {
                    $errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
                }

                if (isset($temp_name)) {
                    @unlink($temp_name);
                }
                $tab->image[$language['id_lang']] = $salt.'_'.$_FILES['image_'.$language['id_lang']]['name'];
            } elseif (Tools::getValue('image_old_'.$language['id_lang']) != '') {
                $tab->image[$language['id_lang']] = Tools::getValue('image_old_'.$language['id_lang']);
            }
        }

        if (!$errors) {
            if (!Tools::getValue('id_tab')) {
                if (!$tab->add()) {
                    return $this->displayError($this->l('The tab could not be added.'));
                }
            } elseif (!$tab->update()) {
                return $this->displayError($this->l('The tab could not be updated.'));
            }
            return $this->displayConfirmation($this->l('The tab is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    protected function preValidateForm()
    {
        $errors = array();

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            if (!empty($_FILES['image_' . $lang['id_lang']]['type'])) {
                if (ImageManager::validateUpload($_FILES['image_' . $lang['id_lang']], 4000000)) {
                    $errors[] = $this->l('Image format not recognized, allowed format is: .gif, .jpg, .png');
                }
            }
        }

        if (Tools::isEmpty(Tools::getValue('title_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('The title is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad title format.');
        }

        if (Tools::isEmpty(Tools::getValue('url_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('The code is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('url_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad code format.');
        }

        if (!Validate::isCleanHtml(Tools::getValue('description_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad description format.');
        }

        if (Tools::isEmpty(Tools::getValue('id_product'))) {
            $errors[] = $this->l('The product is required.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function deleteTab()
    {
        $tab = new ClassProductYoutube(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassProductYoutube(Tools::getValue('id_tab'));

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

        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxProductYoutube'));
        Media::addJsDefL('file_theme_url', $this->_path);
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxProductYoutube'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path.'views/js/productyoutube_admin.js');
        $this->context->controller->addCSS($this->_path.'views/css/productyoutube_admin.css');
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addJS($this->_path.'views/js/productyoutube.js');
        $this->context->controller->addCSS($this->_path.'views/css/productyoutube.css');
    }

    public function hookDisplayProductTab()
    {
        $product = $this->context->controller->getProduct();
        $id_product = $product->id;

        $class = new ClassProductYoutube;
        $tabs = $class->getFrontItems($id_product, $this->id_shop, true);
        $result = array();

        if ($tabs) {
            foreach ($tabs as $key => $tab) {
                $result[$key]['id_tab'] = $tab['id_tab'];
                $result[$key]['title'] = $tab['title'];
            }

            $this->context->smarty->assign('items', $result);
        }

        return $this->display(__FILE__, 'views/templates/hook/productyoutube.tpl');
    }

    public function hookDisplayProductTabContent()
    {
        $product = $this->context->controller->getProduct();
        $id_product = $product->id;

        $class = new ClassProductYoutube;
        $tabs = $class->getFrontItems($id_product, $this->id_shop, true);
        $result = array();

        if ($tabs) {
            foreach ($tabs as $key => $tab) {
                $result[$key]['id_tab'] = $tab['id_tab'];
                $result[$key]['title'] = $tab['title'];
                $result[$key]['url'] = $tab['url'];
                $result[$key]['description'] = $tab['description'];
                $result[$key]['image'] = $tab['image'];
            }

            $this->context->smarty->assign('items', $result);
            $this->context->smarty->assign('image_baseurl', $this->_path.'images/');
            $this->smarty->assign(array(
                'item_controls' => Configuration::get('PRODUCT_VIDEO_CONTROLS'),
                'item_info' => Configuration::get('PRODUCT_VIDEO_INFO'),
                'item_loop' => Configuration::get('PRODUCT_VIDEO_LOOP'),
                'item_theme' => Configuration::get('PRODUCT_VIDEO_THEME'),
            ));
        }

        return $this->display(__FILE__, 'views/templates/hook/productyoutube-content.tpl');
    }

    public function hookProductFooter()
    {
        $product = $this->context->controller->getProduct();
        $id_product = $product->id;

        $class = new ClassProductYoutube;
        $tabs = $class->getFrontItems($id_product, $this->id_shop, true);
        $result = array();

        if ($tabs) {
            foreach ($tabs as $key => $tab) {
                $result[$key]['title'] = $tab['title'];
                $result[$key]['description'] = $tab['description'];
                $result[$key]['url'] = $tab['url'];
                $result[$key]['image'] = $tab['image'];
            }

            $this->context->smarty->assign('items', $result);
            $this->context->smarty->assign('image_baseurl', $this->_path.'images/');
            $this->smarty->assign(array(
                'item_controls' => Configuration::get('PRODUCT_VIDEO_CONTROLS'),
                'item_info' => Configuration::get('PRODUCT_VIDEO_INFO'),
                'item_loop' => Configuration::get('PRODUCT_VIDEO_LOOP'),
                'item_theme' => Configuration::get('PRODUCT_VIDEO_THEME'),
            ));
        }

        return $this->display(__FILE__, 'views/templates/hook/productyoutube-footer.tpl');
    }
}
