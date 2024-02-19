<?php
/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Responsive banners
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

include_once(_PS_MODULE_DIR_.'bonbanner/classes/ClassBanners.php');

class Bonbanner extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bonbanner';
        $this->tab = 'front_office_features';
        $this->version = '1.0.2';
        $this->author = 'Bonpresta';
        $this->module_key = '8fb5e16d605e1901bf50e1c4606780b3';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->languages = Language::getLanguages();
        $this->displayName = $this->l('Responsive banners');
        $this->description = $this->l('Display responsive banners');
        $this->confirmUninstall = $this->l('This module  Uninstall');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function createAjaxController()
    {
        $tab = new Tab();
        $tab->active = 1;
        $languages = Language::getLanguages(false);
        if (is_array($languages)) {
            foreach ($languages as $language) {
                $tab->name[$language['id_lang']] = 'bonbanner';
            }
        }
        $tab->class_name = 'AdminAjaxBanner';
        $tab->module = $this->name;
        $tab->id_parent = - 1;
        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxBanner')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
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
            $this->createAjaxController() &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayHome');
    }

    protected function installSamples()
    {
        $languages = Language::getLanguages(false);
            $item = new ClassBanners();
            $item->id_shop = (int)$this->context->shop->id;
            $item->specific_class = '';
            $item->status = 1;
            $item->blank = 1;
            $item->sort_order = 1;
            foreach ($languages as $language) {
                $item->title[$language['id_lang']] = '30% off';
                $item->subtitle[$language['id_lang']] = 'Under the hood sales';
                $item->url[$language['id_lang']] = '6-accessories';
                $item->facebook_url[$language['id_lang']] = 'https://www.facebook.com/prestashop/';
                $item->youtube_url[$language['id_lang']] = 'https://www.youtube.com/prestashop';
                $item->twitter_url[$language['id_lang']] = 'https://twitter.com/prestashop';
                $item->instagram_url[$language['id_lang']] = 'https://www.instagram.com/prestashop/';
                $item->image[$language['id_lang']] = 'sample-1.png';
                $item->description[$language['id_lang']] = '
                    <p>
                    Proin ut diam sed ipsum ullamcorper feugiat et vitae diam. Aliquam mollis quam 
                    in porta placerat. Nam et nisl rutrum, egestas turpis vitae
                    </p>';
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

        return parent::uninstall()
        && $this->removeAjaxContoller();
    }
    protected function getModuleSettings()
    {
        $settings = array(
            'BON_BANNER_SOCIAL' => 0,
        );

        return $settings;
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
        $helper->submit_action = 'submitBonbannerSettingModule';
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
                        'type' => 'switch',
                        'label' => $this->l('Activate social link:'),
                        'name' => 'BON_BANNER_SOCIAL',
                        'desc' => $this->l('activates the display of social icons in elements.'),
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
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }
    protected function bonbannerProcess()
    {
        $form_values = $this->getConfigFormValuesSettings();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
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
    protected function getBonbannerSettings()
    {
        $settings = $this->getModuleSettings();
        $get_settings = array();
        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = array('value' => $data, 'type' => $this->getStringValueType($data));
        }

        return $get_settings;
    }
    public function getContent()
    {

        $output = '';
        $result ='';

        if (((bool)Tools::isSubmit('submitBonbannerSettingModule')) == true) {
            $this->bonbannerProcess();
            $output .= $this->displayConfirmation($this->l('Settings updated successful.'));
        }

        if ((bool)Tools::isSubmit('submitUpdateBanner')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addBanner();
            } else {
                $output = $result;
                $output .= $this->renderBannerForm();
            }
        }

        if ((bool)Tools::isSubmit('statusbonbanner')) {
            $output .= $this->updateStatusTab();
            $output .= $this->renderFormSettings();
        }

        if ((bool)Tools::isSubmit('deletebonbanner')) {
            $output .= $this->deleteBanner();
            $output .= $this->renderFormSettings();
        }

        if (Tools::getIsset('updatebonbanner') || Tools::getValue('updatebonbanner')) {
            $output .= $this->renderBannerForm();
        } elseif ((bool)Tools::isSubmit('addbonbanner')) {
            $output .= $this->renderBannerForm();
        } elseif (!$result) {
            $output .= $this->renderBannerList();
            $output .= $this->renderFormSettings();
        }

        return $output;
    }

    protected function renderBannerForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ? $this->l('Update banner') : $this->l('Add banner')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'files_lang',
                        'label' => $this->l('Select a file'),
                        'name' => 'image',
                        'required' => true,
                        'lang' => true,
                        'desc' => sprintf($this->l('Maximum image size: %s.'), ini_get('upload_max_filesize'))
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Enter Title'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Enter subtitle'),
                        'name' => 'subtitle',
                        'lang' => true,
                        'required' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Enter Banner URL'),
                        'name' => 'url',
                        'required' => true,
                        'lang' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Description'),
                        'name' => 'description',
                        'autoload_rte' => true,
                        'lang' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Enter Facebook URL'),
                        'name' => 'facebook_url',
                        'required' => true,
                        'lang' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Enter Youtube URL'),
                        'name' => 'youtube_url',
                        'required' => true,
                        'lang' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Enter Twitter URL'),
                        'name' => 'twitter_url',
                        'required' => true,
                        'lang' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Enter Instagram URL'),
                        'name' => 'instagram_url',
                        'required' => true,
                        'lang' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Specific class'),
                        'name' => 'specific_class',
                        'col' => 3
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Open in new window'),
                        'name' => 'blank',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        ),
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

        if ((bool)Tools::getIsset('updatebonbanner') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBanners((int)Tools::getValue('id_tab'));
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
        $helper->submit_action = 'submitUpdateBanner';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigBannerFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path.'views/img/'
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigBannerFormValues()
    {
        if ((bool)Tools::getIsset('updatebonbanner') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassBanners((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassBanners();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'title' => Tools::getValue('title', $tab->title),
            'subtitle' => Tools::getValue('title', $tab->subtitle),
            'url' => Tools::getValue('url', $tab->url),
            'facebook_url' => Tools::getValue('facebook_url', $tab->facebook_url),
            'youtube_url' => Tools::getValue('youtube_url', $tab->youtube_url),
            'twitter_url' => Tools::getValue('twitter_url', $tab->twitter_url),
            'instagram_url' => Tools::getValue('instagram_url', $tab->instagram_url),
            'image' => Tools::getValue('image', $tab->image),
            'specific_class' => Tools::getValue('specific_class', $tab->specific_class),
            'status' => Tools::getValue('status', $tab->status),
            'blank' => Tools::getValue('blank', $tab->blank),
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

    public function renderBannerList()
    {
        if (!$tabs = ClassBanners::getBannerList()) {
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
                'title' => $this->l('Banner title'),
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
        $helper->table = 'bonbanner';
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

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addBanner()
    {
        $errors = array();

        if ((int)Tools::getValue('id_tab') > 0) {
            $banner = new ClassBanners((int)Tools::getValue('id_tab'));
        } else {
            $banner = new ClassBanners();
        }

        $banner->specific_class = pSql(Tools::getValue('specific_class'));
        $banner->id_shop = (int)$this->context->shop->id;
        $banner->status = (int)Tools::getValue('status');

        if ((int)Tools::getValue('id_tab') > 0) {
            $banner->sort_order = Tools::getValue('sort_order');
        } else {
            $banner->sort_order = $banner->getMaxSortOrder((int)$this->id_shop);
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $banner->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
            $banner->subtitle[$language['id_lang']] = Tools::getValue('subtitle_'.$language['id_lang']);
            $banner->url[$language['id_lang']] = Tools::getValue('url_'.$language['id_lang']);
            $banner->facebook_url[$language['id_lang']] = Tools::getValue('facebook_url_'.$language['id_lang']);
            $banner->youtube_url[$language['id_lang']] = Tools::getValue('youtube_url_'.$language['id_lang']);
            $banner->twitter_url[$language['id_lang']] = Tools::getValue('twitter_url_'.$language['id_lang']);
            $banner->instagram_url[$language['id_lang']] = Tools::getValue('instagram_url_'.$language['id_lang']);
            $banner->public_title[$language['id_lang']] = Tools::getValue('public_title_'.$language['id_lang']);
            $banner->description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang']);
            $banner->blank = (int)Tools::getValue('blank');


            $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_'.$language['id_lang']]['name'], '.'), 1));


            $imagesize = $_FILES['image_'.$language['id_lang']]["tmp_name"] != '' ? @getimagesize($_FILES['image_'.$language['id_lang']]["tmp_name"]) : '';
            if (isset($_FILES['image_' . $language['id_lang']])
                && isset($_FILES['image_' . $language['id_lang']]['tmp_name'])
                && !empty($_FILES['image_' . $language['id_lang']]['tmp_name'])
                && !empty($imagesize)
                && in_array(
                    Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)),
                    array('jpg', 'gif', 'jpeg', 'png', 'webp')
                )
                && in_array($type, array('jpg', 'gif', 'jpeg', 'png', 'webp'))) {
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
                $banner->image[$language['id_lang']] = $salt . '_' . $_FILES['image_' . $language['id_lang']]['name'];
            } elseif (Tools::getValue('image_old_' . $language['id_lang']) != '') {
                $banner->image[$language['id_lang']] = Tools::getValue('image_old_' . $language['id_lang']);
            }
        }

        if (!$errors) {
            if (!Tools::getValue('id_tab')) {
                if (!$banner->add()) {
                    return $this->displayError($this->l('The banner could not be added.'));
                }
            } elseif (!$banner->update()) {
                return $this->displayError($this->l('The banner could not be updated.'));
            }

            return $this->displayConfirmation($this->l('The banner is saved.'));
        } else {
            return $this->displayError($this->l('Unknown error occurred.'));
        }
    }

    protected function preValidateForm()
    {
        $errors = array();
        $banner = new ClassBanners(Tools::getValue('id_tab'));
        $old_image = $banner->image;

        if (!Tools::isEmpty(Tools::getValue('specific_class'))) {
            if (!$this->isSpecificClass(Tools::getValue('specific_class'))) {
                $errors[] = $this->l('Bad specific class format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('url_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The Banner url is required.');
        }

        if (Tools::getValue('image_' . $this->default_language['id_lang']) != null && !Validate::isFileName(Tools::getValue('image_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Invalid filename.');
        }

        if (!$old_image && (!isset($_FILES['image_' .  $this->default_language['id_lang']]) || Tools::isEmpty($_FILES['image_' .  $this->default_language['id_lang']]['tmp_name'])))  {
            $errors[] = $this->l('The Banner image is required.');
        }

        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The Banner title is required.');
        } elseif (!Validate::isName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad title format');
        }

        foreach ($this->languages as $lang) {
            $title = Tools::getValue('title_' . $lang['id_lang']);
            $url = Tools::getValue('url_' . $lang['id_lang']);
            if ($title && !Validate::isCleanHtml($title)) {
                $errors[] = sprintf($this->l('%s - banner title is invalid.'), $lang['iso_code']);
            } elseif ($title && Tools::strlen($title) > 128) {
                $errors[] = sprintf($this->l('%s - banner title is too long.'), $lang['iso_code']);
            }
            if ($url && !Validate::isUrl($url)) {
                $errors[] = sprintf($this->l('%s - banner url is invalid.'), $lang['iso_code']);
            }
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function isSpecificClass($class)
    {
        if (!ctype_alpha(Tools::substr($class, 0, 1)) || preg_match('/[\'^?$%&*()}{\x20@#~?><>,|=+¬]/', $class)) {
            return false;
        }

        return true;
    }

    protected function deleteBanner()
    {
        $tab = new ClassBanners(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassBanners(Tools::getValue('id_tab'));

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
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBanner'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxBanner'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path.'views/js/back.js');
        $this->context->controller->addCSS($this->_path.'views/css/back.css');
    }

    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookDisplayHome()
    {
        $banner_front = new ClassBanners();
        $tabs = $banner_front->getFrontItems($this->id_shop, true);
        $result = array();

        foreach ($tabs as $key => $tab) {
            $result[$key]['title'] = $tab['title'];
            $result[$key]['subtitle'] = $tab['subtitle'];
            $result[$key]['description'] = $tab['description'];
            $result[$key]['url'] = $tab['url'];
            $result[$key]['facebook_url'] = $tab['facebook_url'];
            $result[$key]['youtube_url'] = $tab['youtube_url'];
            $result[$key]['twitter_url'] = $tab['twitter_url'];
            $result[$key]['instagram_url'] = $tab['instagram_url'];
            $result[$key]['image'] = $tab['image'];
            $result[$key]['specific_class'] = $tab['specific_class'];
            $result[$key]['blank'] = $tab['blank'];
        }
        $image = $result[0]['image'];
        Media::addJsDefL('image', $image);

        $this->context->smarty->assign('image_baseurl', $this->_path.'views/img/');
        $this->context->smarty->assign('items', $result);
        $this->context->smarty->assign('settings', $this->getBonbannerSettings());

        return $this->display(__FILE__, 'views/templates/hook/front.tpl');
    }

    public function hookdisplayCustomSlick()
    {
        return $this->hookDisplayHome();
    }
}
