<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Information Banner
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

include_once(_PS_MODULE_DIR_.'boninfoban/classes/InfoBan.php');

class BonInfoBan extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'boninfoban';
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
        $this->displayName = $this->l('Information Banner');
        $this->description = $this->l('Display the banner carousel in the left column');
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
                $tab->name[$language['id_lang']] = 'boninfoban';
            }
        }
        $tab->class_name = 'AdminAjaxInfoBan';
        $tab->module = $this->name;
        $tab->id_parent = - 1;
        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxInfoBan')) {
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
        $this->registerHook('displayLeftColumn');
    }

    protected function installSamples()
    {
        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 2; ++$i) {
            $item = new InfoBan();
            $item->id_shop = (int)$this->context->shop->id;
            $item->status = 1;
            $item->type = 'image';
            $item->sort_order = $i;
            foreach ($languages as $language) {
                $item->title[$language['id_lang']] = 'banner';
                $item->url[$language['id_lang']] = '6-accessories';
                $item->image[$language['id_lang']] = 'sample-' . $i . '.jpg';
                $item->description[$language['id_lang']] = '<h4>new arrivals</h4><h3>Parts From Honda</h3><p>best quality and price</p>';
            }
            $item->add();
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

    protected function getModuleSettings()
    {
        $settings = array(
            'BON_INFOBAN_LIMIT' => 4,
            'BON_INFOBAN_DISPLAY_CAROUSEL' => true,
            'BON_INFOBAN_DISPLAY_ITEM_NB' => 6,
            'BON_INFOBAN_CAROUSEL_NB' => 1,
            'BON_INFOBAN_CAROUSEL_LOOP' => true,
            'BON_INFOBAN_CAROUSEL_AUTOPLAY' => 1,
            'BON_INFOBAN_CAROUSEL_AUTOPLAY_SPEED' => 3000,
            'BON_INFOBAN_CAROUSEL_DOTS' => true,
        );
        return $settings;
    }

    public function getContent()
    {

        $output = '';
        $result ='';

        if (((bool)Tools::isSubmit('submitBonInfoBanSettingModule')) == true) {
            if (!$errors = $this->validateSettings()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Settings updated successful.'));
            } else {
                $output .= $errors;
            }
        }

        if ((bool)Tools::isSubmit('submitUpdateInfoBan')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addInfoBan();
            } else {
                $output = $result;
                $output .= $this->renderInfoBanForm();
            }
        }

        if ((bool)Tools::isSubmit('statusboninfoban')) {
            $output .= $this->updateStatusTab();
        }

        if ((bool)Tools::isSubmit('deleteboninfoban')) {
            $output .= $this->deleteInfoBan();
        }

        if (Tools::getIsset('updateboninfoban') || Tools::getValue('updateboninfoban')) {
            $output .= $this->renderInfoBanForm();
        } elseif ((bool)Tools::isSubmit('addboninfoban')) {
            $output .= $this->renderInfoBanForm();
        } elseif (!$result) {
            $output .= $this->renderInfoBanList();
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
        $helper->submit_action = 'submitBonInfoBanSettingModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'image_path' => $this->_path.'views/img',
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
                        'label' => $this->l('Display item'),
                        'name' => 'BON_INFOBAN_LIMIT',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Carousel:'),
                        'name' => 'BON_INFOBAN_DISPLAY_CAROUSEL',
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
                        'form_group_class' => 'display-block',
                        'type' => 'text',
                        'label' => $this->l('Items:'),
                        'name' => 'BON_INFOBAN_CAROUSEL_NB',
                        'col' => 2,
                        'desc' => $this->l('The number of items you want to see on the screen.'),
                    ),
                    array(
                        'form_group_class' => 'display-block',
                        'type' => 'switch',
                        'label' => $this->l('Loop:'),
                        'name' => 'BON_INFOBAN_CAROUSEL_LOOP',
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
                        'form_group_class' => 'display-block',
                        'type' => 'switch',
                        'label' => $this->l('Autoplay:'),
                        'name' => 'BON_INFOBAN_CAROUSEL_AUTOPLAY',
                        'desc' => $this->l('Slider autoplay. Activates automatic slide switching.'),
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
                        'label' => $this->l('Autoplay speed:'),
                        'name' => 'BON_INFOBAN_CAROUSEL_AUTOPLAY_SPEED',
                        'desc' => $this->l('Sets the speed of autoplay carousel in milliseconds.'),
                        'col' => 2,
                    ),
                    array(
                        'form_group_class' => 'display-block',
                        'type' => 'switch',
                        'label' => $this->l('Dots:'),
                        'name' => 'BON_INFOBAN_CAROUSEL_DOTS',
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

        if (Tools::isEmpty(Tools::getValue('BON_INFOBAN_LIMIT'))) {
            $errors[] = $this->l('Limit is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_INFOBAN_LIMIT'))) {
                $errors[] = $this->l('Bad limit format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_INFOBAN_CAROUSEL_NB'))) {
            $errors[] = $this->l('Item is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_INFOBAN_CAROUSEL_NB'))) {
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

    protected function getInfoBanSettings()
    {
        $settings = $this->getModuleSettings();
        $get_settings = array();
        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = array('value' => $data, 'type' => $this->getStringValueType($data));
        }

        return $get_settings;
    }

    protected function renderInfoBanForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab')
                        ? $this->l('Update information banner')
                        : $this->l('Add information banner')),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
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
                        'type' => 'files_lang_cover',
                        'label' => $this->l('Cover image'),
                        'name' => 'cover',
                        'lang' => true,
                        'form_group_class' => 'files_lang_cover',
                    ),
                    array(
                        'type' => 'files_lang',
                        'label' => $this->l('Image'),
                        'name' => 'image',
                        'lang' => true,
                        'desc' => $this->l('If the content`s type is an image - file 
                        format .png, .jpg, .gif. If the content type is video - file
                        in .gif .mp4, .webm, .ogv format.'),
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Enter URL'),
                        'name' => 'url',
                        'required' => true,
                        'lang' => true,
                        'col' => 3
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Content'),
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
                        'href' => AdminController::$currentIndex.
                            '&configure='.$this->name.'&token='.
                            Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updateboninfoban') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new InfoBan((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
            $fields_form['form']['images'] = $tab->image;
            $fields_form['form']['cover'] = $tab->cover;
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateInfoBan';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigInfoBanFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path.'views/img/',
            'image_baseurl_video' => $this->_path.'views/img/'
        );
   
        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigInfoBanFormValues()
    {
        if ((bool)Tools::getIsset('updateboninfoban') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new InfoBan((int)Tools::getValue('id_tab'));
        } else {
            $tab = new InfoBan();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'title' => Tools::getValue('title', $tab->title),
            'url' => Tools::getValue('url', $tab->url),
            'image' => Tools::getValue('image', $tab->image),
            'cover' => Tools::getValue('cover', $tab->cover),
            'type' => Tools::getValue('type', $tab->type),
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

    public function renderInfoBanList()
    {
        if (!$tabs = InfoBan::getInfoBanList()) {
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
        $helper->table = 'boninfoban';
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
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path.'views/img/',
            'image_baseurl_video' => $this->_path.'views/img/'

        );

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addInfoBan()
    {
        $errors = array();

        if ((int)Tools::getValue('id_tab') > 0) {
            $item = new InfoBan((int)Tools::getValue('id_tab'));
        } else {
            $item = new InfoBan();
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
            $type_cover = Tools::strtolower(Tools::substr(strrchr($_FILES['cover_'.
                                                          $language['id_lang']]['name'], '.'), 1));

            if (isset($_FILES['cover_'.$language['id_lang']])
            && in_array($type_cover, array('jpg', 'gif', 'jpeg', 'png', 'webp'))) {
                $salt = sha1(microtime());
                if (!move_uploaded_file($_FILES['cover_' . $language['id_lang']]
                ['tmp_name'], dirname(__FILE__) . '/views/img/' . $salt.
                '_' . $_FILES['cover_' . $language['id_lang']]['name'])) {
                } else {
                    if (isset($_FILES['cover_' . $language['id_lang']])
                        && isset($_FILES['cover_' . $language['id_lang']]['tmp_name'])
                        && !empty($_FILES['cover_' . $language['id_lang']]['tmp_name'])) {
                        $item->cover[$language['id_lang']] = $salt . '_'.
                            $_FILES['cover_' . $language['id_lang']]['name'];
                    } elseif (Tools::getValue('cover_old_' . $language['id_lang']) != '') {
                        $item->cover[$language['id_lang']] = Tools::getValue('cover_old_' . $language['id_lang']);
                    }
                }
            }

            if (Tools::getValue('type') == 'video') {
                $salt = sha1(microtime());
                if (!move_uploaded_file(
                    $_FILES['image_' . $language['id_lang']]['tmp_name'],
                    dirname(__FILE__) . '/views/img/' . $salt . '_' . $_FILES['image_' . $language['id_lang']]['name']
                )) {
                } else {
                    if (isset($_FILES['image_' . $language['id_lang']])
                        && isset($_FILES['image_' . $language['id_lang']]['tmp_name'])
                        && !empty($_FILES['image_' . $language['id_lang']]['tmp_name'])) {
                        $item->image[$language['id_lang']] = $salt . '_' .
                            $_FILES['image_' . $language['id_lang']]['name'];
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
                    } elseif (!$temp_name
                        || !move_uploaded_file($_FILES['image_'.$language['id_lang']]['tmp_name'], $temp_name)) {
                        return false;
                    } elseif (!ImageManager::resize($temp_name, dirname(__FILE__).
                        '/views/img/'.$salt.'_'.$_FILES['image_'.$language['id_lang']]['name'], null, null, $type)) {
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
                    return $this->displayError($this->l('Item cannot be added.'));
                }
            } elseif (!$item->update()) {
                return $this->displayError($this->l('The item cannot be updated.'));
            }

            return $this->displayConfirmation($this->l('Item saved.'));
        } else {
            return $this->displayError($this->l('An unknown error has occurred.'));
        }
    }

    protected function preValidateForm()
    {
        $errors = array();
        $languages = Language::getLanguages(false);

        $class = new InfoBan((int)Tools::getValue('id_tab'));
        $old_image = $class->image;
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');

        if (!$old_image && (!isset($_FILES['image_' . $id_lang_default]) ||
                Tools::isEmpty($_FILES['image_' . $id_lang_default]['tmp_name']))) {
            $errors[] = $this->l('The file is required.');
        }

        foreach ($languages as $lang) {
            if (!empty($_FILES['cover_' . $lang['id_lang']]['type'])) {
                if (ImageManager::validateUpload($_FILES['cover_' . $lang['id_lang']], 4000000)) {
                    $errors[] = $this->l('Image format not recognized, valid format: .gif, .jpg, .png');
                }
            }
        }

        if (Tools::getValue('type') == 'image') {
            foreach ($languages as $lang) {
                if (!Tools::isEmpty($_FILES['image_' . $lang['id_lang']]['type'])) {
                    if (ImageManager::validateUpload($_FILES['image_' . $lang['id_lang']], 4000000)) {
                        $errors[] = $this->l('Image format not recognized, valid format: .gif, .jpg, .png');
                    }
                }
            }
        }

        if (Tools::getValue('type') == 'video') {
            $info = new SplFileInfo($_FILES['image_' . $this->default_language['id_lang']]['name']);
            if ($_FILES['image_' . $this->default_language['id_lang']]['name'] != '') {
                if ($info->getExtension() != 'mp4' && $info->getExtension() != 'gif'
                    && $info->getExtension() != 'webm' && $info->getExtension() != 'ogv') {
                    $errors[] = $this->l('Video format not recognized, valid format: .gif .mp4, .webm, .ogv');
                }
            }
        }

        if (Tools::isEmpty(Tools::getValue('title_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('Title is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('Invalid title format.');
        }

        if (Tools::isEmpty(Tools::getValue('url_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('URL is required.');
        } elseif (!Validate::isUrl(Tools::getValue('url_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('Invalid URL format.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }
        return false;
    }

    protected function deleteInfoBan()
    {
        $tab = new InfoBan(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error while deleting tab'));
        }

        return $this->displayConfirmation($this->l('Tab successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new InfoBan(Tools::getValue('id_tab'));

        if ($tab->status == 1) {
            $tab->status = 0;
        } else {
            $tab->status = 1;
        }

        if (!$tab->update()) {
            return $this->displayError($this->l('The tab status could not be updated.'));
        }

        return $this->displayConfirmation($this->l('Tab status updated successfully.'));
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') != $this->name) {
            return;
        }
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxInfoBan'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxInfoBan'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path.'views/js/ban_back.js');
        $this->context->controller->addCSS($this->_path.'views/css/ban_back.css');
    }

    public function hookHeader()
    {
        if ($this->context->controller->php_self == "category") {

            $this->context->controller->addJS($this->_path . 'views/js/slick.js');
            $this->context->controller->addCSS($this->_path . 'views/css/slick.css', 'all');
            $this->context->controller->addCSS($this->_path . 'views/css/slick-theme.css', 'all');
            $this->context->controller->addJS($this->_path . '/views/js/ban_front.js');
            $this->context->controller->addCSS($this->_path . '/views/css/ban_front.css');

            $this->context->smarty->assign('settings', $this->getInfoBanSettings());

            return $this->display($this->_path, '/views/templates/hook/ban-header.tpl');
        }
    }

    public function hookdisplayLeftColumn()
    {
        $ban_front = new InfoBan();
        $tabs = $ban_front->getTopFrontItems($this->id_shop, true);
        $result = array();

        foreach ($tabs as $key => $tab) {
            $result[$key]['title'] = $tab['title'];
            $result[$key]['description'] = $tab['description'];
            $result[$key]['image'] = $tab['image'];
            $result[$key]['type'] = $tab['type'];
            $result[$key]['url'] = $tab['url'];
            $result[$key]['cover'] = $tab['cover'];
        }

        $this->context->smarty->assign('image_baseurl', $this->_path.'views/img/');
        $this->context->smarty->assign('items', $result);
        $this->smarty->assign(array(
            'display_carousel' => Configuration::get('BON_INFOBAN_DISPLAY_CAROUSEL'),
        ));
        $this->context->smarty->assign('limit', Configuration::get('BON_INFOBAN_LIMIT'));

        return $this->display(__FILE__, 'views/templates/hook/ban-front.tpl');
    }
    
    public function hookdisplayTop()
    {
        return $this->hookdisplayLeftColumn();
    }

    public function hookdisplayTopColumn()
    {
        return $this->hookdisplayLeftColumn();
    }

    public function hookDisplayHome()
    {
        return $this->hookdisplayLeftColumn();
    }
}
