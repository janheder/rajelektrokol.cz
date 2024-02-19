<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Whatsapp Chat
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

include_once(_PS_MODULE_DIR_.'bonwhatsappchat/classes/ClassWhatsappchat.php');

class Bonwhatsappchat extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bonwhatsappchat';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Bonpresta';
        $this->module_key = '8fb5e16d605e1901bf50e1c4606780b3';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->languages = Language::getLanguages();
        $this->displayName = $this->l('Whatsapp');
        $this->description = $this->l('Display Whatsapp Chat');
        $this->confirmUninstall = $this->l('This module Uninstall');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    protected function getModuleSettings()
    {
        $settings = array(
            'BONWHATSAPP_ENABLE' => true,
            'BONWHATSAPP_POSITION' => 'left',
            'BONWHATSAPP_COLOR' => '#505050',
            'BONWHATSAPP_BACKGROUND' => '#F4F4F4',
        );

        return $settings;
    }

    public function createAjaxController()
    {
        $tab = new Tab();
        $tab->active = 1;
        $languages = Language::getLanguages(false);
        if (is_array($languages)) {
            foreach ($languages as $language) {
                $tab->name[$language['id_lang']] = 'bonwhatsappchat';
            }
        }
        $tab->class_name = 'AdminAjaxWhatsappchat';
        $tab->module = $this->name;
        $tab->id_parent = - 1;
        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxWhatsappchat')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');
        $settings = $this->getModuleSettings();

        foreach ($settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        $this->installSamples();

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayWrapperBottom') &&
            $this->registerHook('displayFooter') &&
            $this->createAjaxController() &&
            $this->registerHook('displayBackOfficeHeader');
    }

    protected function installSamples()
    {
        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 3; ++$i) {
            $item = new ClassWhatsappchat();
            $item->id_shop = (int)$this->context->shop->id;
            $item->specific_class = '';
            $item->status = 1;
            $item->blank = 1;
            $item->sort_order = $i;
            foreach ($languages as $language) {
                $item->title[$language['id_lang']] = 'Manager';
                $item->url[$language['id_lang']] = '384928321';
                $item->image[$language['id_lang']] = 'avatar-'.$i.'.png';
                $item->subtitle[$language['id_lang']] = 'Amanda Brown';
                $item->description[$language['id_lang']] = 'Online from 09:00 - 19:00 GMT+1';
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

    public function getContent()
    {

        $output = '';
        $result ='';

        if ((bool)Tools::isSubmit('submitUpdateWhatsappchat')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addWhatsappchat();
            } else {
                $output = $result;
                $output .= $this->renderWhatsappchatForm();
            }
        }
        if (((bool)Tools::isSubmit('submitBonWhatsAppSettingModule')) == true) {
            if (!$errors = $this->validateSettings()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Settings updated successful.'));
            } else {
                $output .= $errors;
            }
        }

        if ((bool)Tools::isSubmit('statusbonwhatsappchat')) {
            $output .= $this->updateStatusTab();
        }

        if ((bool)Tools::isSubmit('deletebonwhatsappchat')) {
            $output .= $this->deleteWhatsappchat();
        }

        if (Tools::getIsset('updatebonwhatsappchat') || Tools::getValue('updatebonwhatsappchat')) {
            $output .= $this->renderWhatsappchatForm();
        } elseif ((bool)Tools::isSubmit('addbonwhatsappchat')) {
            $output .= $this->renderWhatsappchatForm();
        } elseif (!$result) {
            $output .= $this->renderWhatsappchatList();
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
        $helper->submit_action = 'submitBonWhatsAppSettingModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValuesSettings(),
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
                        'label' => $this->l('Enable:'),
                        'name' => 'BONWHATSAPP_ENABLE',
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
                        'label' => $this->l('Position:'),
                        'name' => 'BONWHATSAPP_POSITION',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'left',
                                    'name' => $this->l('Left')),
                                array(
                                    'id' => 'right',
                                    'name' => $this->l('Right')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Text color:'),
                        'name' => 'BONWHATSAPP_COLOR',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background color:'),
                        'name' => 'BONWHATSAPP_BACKGROUND',
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

        if (!Validate::isColor(Tools::getValue('BONWHATSAPP_COLOR'))) {
            $errors[] = $this->l('"Text color" format error.');
        }

        if (!Validate::isColor(Tools::getValue('BONWHATSAPP_BACKGROUND'))) {
            $errors[] = $this->l('"Background color" format error.');
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

    protected function postProcess()
    {
        $form_values = $this->getConfigFormValuesSettings();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function renderWhatsappchatForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ? $this->l('Update') : $this->l('Add')),
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
                        'type' => 'textarea',
                        'label' => $this->l('Description'),
                        'name' => 'description',
                        'autoload_rte' => true,
                        'lang' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Subtitle'),
                        'name' => 'subtitle',
                        'autoload_rte' => true,
                        'lang' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Enter Phone'),
                        'name' => 'url',
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
                        'href' => AdminController::$currentIndex.'&configure='.$this->name
                            .'&token='.Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updatebonwhatsappchat') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassWhatsappchat((int)Tools::getValue('id_tab'));
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
        $helper->submit_action = 'submitUpdateWhatsappchat';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigWhatsappchatFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path.'views/img/'
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigWhatsappchatFormValues()
    {
        if ((bool)Tools::getIsset('updatebonwhatsappchat') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassWhatsappchat((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassWhatsappchat();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'title' => Tools::getValue('title', $tab->title),
            'url' => Tools::getValue('url', $tab->url),
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
            $fields_values['subtitle'][$lang['id_lang']] = Tools::getValue(
                'subtitle_' . (int) $lang['id_lang'],
                isset($tab->subtitle[$lang['id_lang']]) ? $tab->subtitle[$lang['id_lang']] : ''
            );
        }

        return $fields_values;
    }

    public function renderWhatsappchatList()
    {
        if (!$tabs = ClassWhatsappchat::getWhatsappchatList()) {
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
        $helper->table = 'bonwhatsappchat';
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

    protected function addWhatsappchat()
    {
        $errors = array();

        if ((int)Tools::getValue('id_tab') > 0) {
            $whatsappchat = new ClassWhatsappchat((int)Tools::getValue('id_tab'));
        } else {
            $whatsappchat = new ClassWhatsappchat();
        }

        $whatsappchat->specific_class = pSql(Tools::getValue('specific_class'));
        $whatsappchat->id_shop = (int)$this->context->shop->id;
        $whatsappchat->status = (int)Tools::getValue('status');

        if ((int)Tools::getValue('id_tab') > 0) {
            $whatsappchat->sort_order = Tools::getValue('sort_order');
        } else {
            $whatsappchat->sort_order = $whatsappchat->getMaxSortOrder((int)$this->id_shop);
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $whatsappchat->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
            $whatsappchat->url[$language['id_lang']] = Tools::getValue('url_'.$language['id_lang']);
            $whatsappchat->public_title[$language['id_lang']] = Tools::getValue('public_title_'.$language['id_lang']);
            $whatsappchat->description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang']);
            $whatsappchat->subtitle[$language['id_lang']] = Tools::getValue('subtitle_'.$language['id_lang']);
            $whatsappchat->blank = (int)Tools::getValue('blank');

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
                } elseif (!$temp_name ||
                    !move_uploaded_file($_FILES['image_'.$language['id_lang']]['tmp_name'], $temp_name)) {
                    return false;
                } elseif (!ImageManager::resize($temp_name, dirname(__FILE__)
                    .'/views/img/'.$salt.'_'.$_FILES['image_'.$language['id_lang']]['name'], null, null, $type)) {
                    $errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
                }

                if (isset($temp_name)) {
                    @unlink($temp_name);
                }
                $whatsappchat->image[$language['id_lang']] = $salt.'_'.$_FILES['image_'.$language['id_lang']]['name'];
            } elseif (Tools::getValue('image_old_'.$language['id_lang']) != '') {
                $whatsappchat->image[$language['id_lang']] = Tools::getValue('image_old_'.$language['id_lang']);
            }
        }

        if (!$errors) {
            if (!Tools::getValue('id_tab')) {
                if (!$whatsappchat->add()) {
                    return $this->displayError($this->l('The item could not be added.'));
                }
            } elseif (!$whatsappchat->update()) {
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
        $whatsappchat = new ClassWhatsappchat(Tools::getValue('id_tab'));
      
        $old_image = $whatsappchat->image;

        if (!Tools::isEmpty(Tools::getValue('specific_class'))) {
            if (!$this->isSpecificClass(Tools::getValue('specific_class'))) {
                $errors[] = $this->l('Bad specific class format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('url_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Phone field is required.');
        } elseif (!Validate::isPhoneNumber(Tools::getValue('url_' . $this->default_language['id_lang']))) {
                $errors[] = $this->l('Bad phone format.');
        }

        if (Tools::getValue('image_'
                .$this->default_language['id_lang']) != null &&
            !Validate::isFileName(Tools::getValue('image_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Invalid filename.');
        }

        if (!$old_image && (!isset($_FILES['image_' .  $this->default_language['id_lang']]) || Tools::isEmpty($_FILES['image_' .  $this->default_language['id_lang']]['tmp_name'])))  {

            $errors[] = $this->l('The item image is required.');
        }

        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The item title is required.');
        } elseif (!Validate::isName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad title format');
        }

        foreach ($this->languages as $lang) {
            $title = Tools::getValue('title_' . $lang['id_lang']);
            $url = Tools::getValue('url_' . $lang['id_lang']);
            if ($title && !Validate::isCleanHtml($title)) {
                $errors[] = sprintf($this->l('%s - item title is invalid.'), $lang['iso_code']);
            } elseif ($title && Tools::strlen($title) > 128) {
                $errors[] = sprintf($this->l('%s - item title is too long.'), $lang['iso_code']);
            }
            if ($url && !Validate::isUrl($url)) {
                $errors[] = sprintf($this->l('%s - item url is invalid.'), $lang['iso_code']);
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

    protected function deleteWhatsappchat()
    {
        $tab = new ClassWhatsappchat(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassWhatsappchat(Tools::getValue('id_tab'));

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
        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxWhatsappchat'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxWhatsappchat'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path.'views/js/back_whatsappchat.js');
        $this->context->controller->addCSS($this->_path.'views/css/back_whatsappchat.css');
    }

    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front_whatsappchat.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front_whatsappchat.css');
        Media::addJsDefL('bonwhatsapp_position', Configuration::get('BONWHATSAPP_POSITION'));
        Media::addJsDefL('bonwhatsapp_color', Configuration::get('BONWHATSAPP_COLOR'));
        Media::addJsDefL('bonwhatsapp_background', Configuration::get('BONWHATSAPP_BACKGROUND'));
    }

    public function hookDisplayFooter()
    {
        $whatsappchat_front = new ClassWhatsappchat();
        $tabs = $whatsappchat_front->getFrontItems($this->id_shop, true);
        $result = array();
        $type = new Mobile_Detect;
        $whatsapp_device = ($type->isMobile() ? ($type->isTablet() ? 'tablet' : 'phone') : 'desktop');

        foreach ($tabs as $key => $tab) {
            $result[$key]['title'] = $tab['title'];
            $result[$key]['description'] = $tab['description'];
            $result[$key]['subtitle'] = $tab['subtitle'];
            $result[$key]['url'] = $tab['url'];
            $result[$key]['image'] = $tab['image'];
            $result[$key]['specific_class'] = $tab['specific_class'];
            $result[$key]['blank'] = $tab['blank'];
        }

        $this->context->smarty->assign(array(
            'bonwhatsapp_enable' => Configuration::get('BONWHATSAPP_ENABLE'),
            'bonwhatsapp_position' => Configuration::get('BONWHATSAPP_POSITION'),
            'bonwhatsapp_color' => Configuration::get('BONWHATSAPP_COLOR'),
            'bonwhatsapp_background' => Configuration::get('BONWHATSAPP_BACKGROUND'),
            'image_baseurl'=> $this->_path.'views/img/',
            'items'=> $result,
            'whatsapp_device' => $whatsapp_device,
        ));

        return $this->display(__FILE__, 'views/templates/hook/front_whatsappchat.tpl');
    }

    public function hookdisplayWrapperBottom()
    {
        return $this->hookDisplayFooter();
    }
}
