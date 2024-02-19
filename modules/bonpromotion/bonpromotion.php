<?php
/**
 * 2015-2019 Bonpresta
 *
 * Promotion Discount Countdown Banner & Slider
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
 *  @copyright 2015-2019 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

include_once _PS_MODULE_DIR_ . 'bonpromotion/classes/ClassPromotion.php';

class Bonpromotion extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bonpromotion';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Bonpresta';
        $this->module_key = '2bf50709bc02d448d30b7bafa27db0e4';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Promotion Discount Countdown Banner');
        $this->description = $this->l('Display promotion banners');
        $this->confirmUninstall = $this->l('This module  Uninstall');
        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
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
                $tab->name[$language['id_lang']] = 'bonpromotion';
            }
        }
        $tab->class_name = 'AdminAjaxPromotion';
        $tab->module = $this->name;
        $tab->id_parent = -1;

        return (bool) $tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int) Tab::getIdFromClassName('AdminAjaxPromotion')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {
        include dirname(__FILE__) . '/sql/install.php';
        $this->installSamples();
        $settings = $this->getModuleSettings();

        foreach ($settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        return parent::install() &&
        $this->registerHook('header') &&
        $this->createAjaxController() &&
        $this->registerHook('displayBackOfficeHeader') &&
        $this->registerHook('displayPromotion') &&
        $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        include dirname(__FILE__) . '/sql/uninstall.php';

        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            Configuration::deleteByName($name);
        }

        return parent::uninstall()
        && $this->removeAjaxContoller();
    }

    protected function getModuleSettings()
    {
        $settings = [
            'BON_PROMOTION_LIMIT' => 4,
            'BON_PROMOTION_DISPLAY_CAROUSEL' => false,
            'BON_PROMOTION_DISPLAY_ITEM_NB' => 6,
            'BON_PROMOTION_CAROUSEL_NB' => 3,
            'BON_PROMOTION_CAROUSEL_MARGIN' => 5000,
            'BON_PROMOTION_CAROUSEL_LOOP' => false,
            'BON_PROMOTION_CAROUSEL_NAV' => true,
            'BON_PROMOTION_CAROUSEL_DOTS' => true,
            'BON_PROMOTION_CAROUSEL_AUTOPLAY' => true,
        ];

        return $settings;
    }

    protected function installSamples()
    {
        $now = date('Y-m-d H:i:00');
        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 1; ++$i) {
            $item = new ClassPromotion();
            $item->id_shop = (int) $this->context->shop->id;
            $item->status = 1;
            $item->type = 'image';
            $item->sort_order = $i;
            $item->data_start = $now;
            $item->data_end = (new DateTime('+1 month'))->format('Y-m-d H:i:00');
            foreach ($languages as $language) {
                $item->title[$language['id_lang']] = 'parallax';
                $item->url[$language['id_lang']] = '6-accessories';
                $item->image[$language['id_lang']] = 'sample-1.png';
                $item->description[$language['id_lang']] = '
                <div class="box-promotion-title">
                    <h3>Limited offer</h3>
                </div>
                <div class="box-promotion-subtitle">
                    <h4><span>Get Your helmet with 30% discount</span></h4>
                </div>';
            }

            $item->add();
        }
    }

    public function getContent()
    {
        $output = '';
        $result = '';

        if (((bool) Tools::isSubmit('submitBonpromotionSettingModule')) == true) {
            if (!$errors = $this->validateSettings()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Settings updated successful.'));
            } else {
                $output .= $errors;
            }
        }

        if ((bool) Tools::isSubmit('submitUpdatePromotion')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addPromotion();
            } else {
                $output = $result;
                $output .= $this->renderPromotionForm();
            }
        }

        if ((bool) Tools::isSubmit('statusbonpromotion')) {
            $output .= $this->updateStatusTab();
        }

        if ((bool) Tools::isSubmit('deletebonpromotion')) {
            $output .= $this->deletePromotion();
        }

        if (Tools::getIsset('updatebonpromotion') || Tools::getValue('updatebonpromotion')) {
            $output .= $this->renderPromotionForm();
        } elseif ((bool) Tools::isSubmit('addbonpromotion')) {
            $output .= $this->renderPromotionForm();
        } elseif (!$result) {
            $output .= $this->renderPromotionList();
            // $output .= $this->renderFormSettings();
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
        $helper->submit_action = 'submitBonpromotionSettingModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = [
            'image_path' => $this->_path . 'views/img',
            'fields_value' => $this->getConfigFormValuesSettings(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        ];

        return $helper->generateForm([$this->getConfigForm()]);
    }

    protected function getConfigForm()
    {
        return [
            'form' => [
                'legend' => [
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Display item'),
                        'name' => 'BON_PROMOTION_LIMIT',
                        'col' => 2,
                        'required' => true,
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Carousel:'),
                        'name' => 'BON_PROMOTION_DISPLAY_CAROUSEL',
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'form_group_class' => 'display-block',
                        'type' => 'text',
                        'label' => $this->l('Items:'),
                        'name' => 'BON_PROMOTION_CAROUSEL_NB',
                        'col' => 2,
                        'desc' => $this->l('The number of items you want to see on the screen.'),
                    ],
                    [
                        'form_group_class' => 'display-block',
                        'type' => 'switch',
                        'label' => $this->l('Loop:'),
                        'name' => 'BON_PROMOTION_CAROUSEL_LOOP',
                        'desc' => $this->l('Infinity loop. Duplicate last and first items to get loop illusion.'),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'form_group_class' => 'display-block',
                        'type' => 'switch',
                        'label' => $this->l('Nav:'),
                        'name' => 'BON_PROMOTION_CAROUSEL_NAV',
                        'desc' => $this->l('Show next/prev buttons.'),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'form_group_class' => 'display-block',
                        'type' => 'switch',
                        'label' => $this->l('Dots:'),
                        'name' => 'BON_PROMOTION_CAROUSEL_DOTS',
                        'desc' => $this->l('Show dots navigation.'),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'form_group_class' => 'display-block',
                        'type' => 'switch',
                        'label' => $this->l('Autoplay:'),
                        'name' => 'BON_PROMOTION_CAROUSEL_AUTOPLAY',
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'form_group_class' => 'display-block',
                        'type' => 'text',
                        'label' => $this->l('Autoplay Speed:'),
                        'name' => 'BON_PROMOTION_CAROUSEL_MARGIN',
                        'col' => 2,
                        'suffix' => 'millisecond',
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];
    }

    protected function validateSettings()
    {
        $errors = [];

        if (Tools::isEmpty(Tools::getValue('BON_PROMOTION_LIMIT'))) {
            $errors[] = $this->l('Limit is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_PROMOTION_LIMIT'))) {
                $errors[] = $this->l('Bad limit format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_PROMOTION_CAROUSEL_NB'))) {
            $errors[] = $this->l('Item is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_PROMOTION_CAROUSEL_NB'))) {
                $errors[] = $this->l('Bad item format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BON_PROMOTION_CAROUSEL_MARGIN'))) {
            $errors[] = $this->l('Autoplay is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_PROMOTION_CAROUSEL_MARGIN'))) {
                $errors[] = $this->l('Bad autoplay format');
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
        $filled_settings = [];
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

    protected function getPromotionSettings()
    {
        $settings = $this->getModuleSettings();
        $get_settings = [];
        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = ['value' => $data, 'type' => $this->getStringValueType($data)];
        }

        return $get_settings;
    }

    protected function renderPromotionForm()
    {
        $fields_form = [
            'form' => [
                'legend' => [
                    'title' => ((int) Tools::getValue('id_tab') ? $this->l('Update promotion') : $this->l('Add promotion')),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 3,
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->l('Type:'),
                        'name' => 'type',
                        'options' => [
                            'query' => [
                                [
                                    'id' => 'image',
                                    'name' => $this->l('Image')],
                                [
                                    'id' => 'video',
                                    'name' => $this->l('Video')],
                            ],
                            'id' => 'id',
                            'name' => 'name',
                        ],
                    ],
                    [
                        'type' => 'files_lang',
                        'label' => $this->l('Image'),
                        'name' => 'image',
                        'lang' => true,
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Enter URL'),
                        'name' => 'url',
                        'required' => true,
                        'lang' => true,
                        'col' => 3,
                    ],
                    [
                        'type' => 'textarea',
                        'label' => $this->l('Content'),
                        'name' => 'description',
                        'autoload_rte' => true,
                        'lang' => true,
                    ],
                    [
                        'type' => 'datetime',
                        'label' => $this->l('Start Date'),
                        'name' => 'data_start',
                        'col' => 6,
                        'required' => true,
                    ],
                    [
                        'type' => 'datetime',
                        'label' => $this->l('End Date'),
                        'name' => 'data_end',
                        'col' => 6,
                        'required' => true,
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name' => 'status',
                        'is_bool' => true,
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled'),
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled'),
                            ],
                        ],
                    ],
                    [
                        'col' => 2,
                        'type' => 'text',
                        'name' => 'sort_order',
                        'class' => 'hidden',
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
                'buttons' => [
                    [
                        'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back',
                    ],
                ],
            ],
        ];

        if ((bool) Tools::getIsset('updatebonpromotion') && (int) Tools::getValue('id_tab') > 0) {
            $tab = new ClassPromotion((int) Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = ['type' => 'hidden', 'name' => 'id_tab', 'value' => (int) $tab->id];
            $fields_form['form']['images'] = $tab->image;
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdatePromotion';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = [
            'fields_value' => $this->getConfigPromotionFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
        ];

        return $helper->generateForm([$fields_form]);
    }

    protected function getConfigPromotionFormValues()
    {
        if ((bool) Tools::getIsset('updatebonpromotion') && (int) Tools::getValue('id_tab') > 0) {
            $tab = new ClassPromotion((int) Tools::getValue('id_tab'));
        } else {
            $tab = new ClassPromotion();
        }

        $fields_values = [
            'id_tab' => Tools::getValue('id_tab'),
            'title' => Tools::getValue('title', $tab->title),
            'url' => Tools::getValue('url', $tab->url),
            'image' => Tools::getValue('image', $tab->image),
            'type' => Tools::getValue('type', $tab->type),
            'data_start' => Tools::getValue('data_start', $tab->data_start),
            'data_end' => Tools::getValue('data_end', $tab->data_end),
            'status' => Tools::getValue('status', $tab->status),
            'sort_order' => Tools::getValue('sort_order', $tab->sort_order),
        ];

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $fields_values['description'][$lang['id_lang']] = Tools::getValue(
                'description_' . (int) $lang['id_lang'],
                isset($tab->description[$lang['id_lang']]) ? $tab->description[$lang['id_lang']] : ''
            );
        }

        return $fields_values;
    }

    public function renderPromotionList()
    {
        if (!$tabs = ClassPromotion::getPromotionList()) {
            $tabs = [];
        }

        $fields_list = [
            'id_tab' => [
                'title' => $this->l('Id'),
                'type' => 'text',
                'col' => 6,
                'search' => false,
                'orderby' => false,
            ],
            'title' => [
                'title' => $this->l('Title'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ],
            'images' => [
                'title' => $this->l('Label'),
                'type' => 'box_image',
                'align' => 'center',
                'search' => false,
            ],
            'data_start' => [
                'title' => $this->l('Start Data'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ],
            'data_end' => [
                'title' => $this->l('End Data'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
            ],
            'status' => [
                'title' => $this->l('Status'),
                'type' => 'bool',
                'active' => 'status',
                'search' => false,
                'orderby' => false,
            ],
            'sort_order' => [
                'title' => $this->l('Position'),
                'type' => 'text',
                'search' => false,
                'orderby' => false,
                'class' => 'pointer dragHandle',
            ],
        ];

        $helper = new HelperList();

        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_tab';
        $helper->table = 'bonpromotion';
        $helper->actions = ['edit', 'delete'];
        $helper->show_toolbar = true;
        $helper->module = $this;
        $helper->title = $this->displayName;
        $helper->listTotal = count($tabs);
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->toolbar_btn['new'] = [
            'href' => AdminController::$currentIndex
                . '&configure=' . $this->name . '&add' . $this->name
                . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Add new item'),
        ];
        $helper->currentIndex = AdminController::$currentIndex
            . '&configure=' . $this->name . '&id_shop=' . (int) $this->context->shop->id;

        $helper->tpl_vars = [
            'link' => new Link(),
            'base_dir' => $this->ssl,
            'ps_version' => _PS_VERSION_,
            'lang_iso' => $this->context->language->iso_code,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'image_baseurl' => $this->_path . 'views/img/',
        ];

        return $helper->generateList($tabs, $fields_list);
    }

    protected function addPromotion()
    {
        $errors = [];

        if ((int) Tools::getValue('id_tab') > 0) {
            $item = new ClassPromotion((int) Tools::getValue('id_tab'));
        } else {
            $item = new ClassPromotion();
        }

        $item->id_shop = (int) $this->context->shop->id;
        $item->status = (int) Tools::getValue('status');
        $item->data_start = Tools::getValue('data_start');
        $item->data_end = Tools::getValue('data_end');
        $item->type = Tools::getValue('type');

        if ((int) Tools::getValue('id_tab') > 0) {
            $item->sort_order = Tools::getValue('sort_order');
        } else {
            $item->sort_order = $item->getMaxSortOrder((int) $this->id_shop);
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $item->title[$language['id_lang']] = Tools::getValue('title_' . $language['id_lang']);
            $item->description[$language['id_lang']] = Tools::getValue('description_' . $language['id_lang']);
            $item->url[$language['id_lang']] = Tools::getValue('url_' . $language['id_lang']);

            $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image_' . $language['id_lang']]['name'], '.'), 1));

            if ('video' == Tools::getValue('type')) {
                $salt = sha1(microtime());
                if (!move_uploaded_file($_FILES['image_' . $language['id_lang']]['tmp_name'], dirname(__FILE__) . '/views/img/' . $salt . '_' . $_FILES['image_' . $language['id_lang']]['name'])) {
                } else {
                    if (isset($_FILES['image_' . $language['id_lang']], $_FILES['image_' . $language['id_lang']]['tmp_name']) && !empty($_FILES['image_' . $language['id_lang']]['tmp_name'])) {
                        $item->image[$language['id_lang']] = $salt . '_' . $_FILES['image_' . $language['id_lang']]['name'];
                    } elseif ('' != Tools::getValue('image_old_' . $language['id_lang'])) {
                        $item->image[$language['id_lang']] = Tools::getValue('image_old_' . $language['id_lang']);
                    }
                }
            } elseif ('image' == Tools::getValue('type')) {
                $imagesize = '' != $_FILES['image_' . $language['id_lang']]['tmp_name'] ? @getimagesize($_FILES['image_' . $language['id_lang']]['tmp_name']) : '';
                if (isset($_FILES['image_' . $language['id_lang']], $_FILES['image_' . $language['id_lang']]['tmp_name'])
                    && !empty($_FILES['image_' . $language['id_lang']]['tmp_name'])
                    && !empty($imagesize)
                    && in_array(
                        Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)),
                        ['jpg', 'gif', 'jpeg', 'png', 'webp']
                    )
                    && in_array($type, ['jpg', 'gif', 'jpeg', 'png', 'webp'])) {
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
                } elseif ('' != Tools::getValue('image_old_' . $language['id_lang'])) {
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
        $errors = [];
        $languages = Language::getLanguages(false);
        $from = Tools::getValue('data_start');
        $to = Tools::getValue('data_end');
        $class = new ClassPromotion((int) Tools::getValue('id_tab'));

        $old_image = $class->image;

        if (!$old_image && (!isset($_FILES['image_' . $this->default_language['id_lang']]) || Tools::isEmpty($_FILES['image_' . $this->default_language['id_lang']]['tmp_name']))) {
            $errors[] = $this->l('The image is required.');
        }

        // foreach ($languages as $lang) {
        //     if (!empty($_FILES['image_' . $lang['id_lang']]['type'])) {
        //         if (ImageManager::validateUpload($_FILES['image_' . $lang['id_lang']], 4000000)) {
        //             $errors[] = $this->l('Image format not recognized, allowed format is: .gif, .jpg, .png');
        //         }
        //     }
        // }

        if (Tools::isEmpty(Tools::getValue('data_start'))) {
            $errors[] = $this->l('The data start is required.');
        }

        if (Tools::isEmpty(Tools::getValue('data_end'))) {
            $errors[] = $this->l('The data end is required.');
        }

        if (!Validate::isDate($to) || !Validate::isDate($from)) {
            $errors[] = $this->l('Invalid date field');
        } elseif (strtotime($to) <= strtotime($from)) {
            $errors[] = $this->l('Invalid date range');
        }

        if (Tools::isEmpty(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The title is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad title format.');
        }

        if (Tools::isEmpty(Tools::getValue('url_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('The url is required.');
        } elseif (!Validate::isUrl(Tools::getValue('url_' . $this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad url format.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function deletePromotion()
    {
        $tab = new ClassPromotion(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassPromotion(Tools::getValue('id_tab'));

        if (1 == $tab->status) {
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

        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxPromotion'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxPromotion'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path . 'views/js/promotion_back.js');
        $this->context->controller->addCSS($this->_path . 'views/css/promotion_back.css');
    }

    public function hookHeader()
    {
        if ('index' == $this->context->controller->php_self) {
            $this->context->controller->addJS($this->_path . '/views/js/promotion_front.js');
            $this->context->controller->addJS($this->_path . '/views/js/promotion_paralax.js');
            $this->context->controller->addCSS($this->_path . '/views/css/promotion_front.css');
            $this->context->controller->addJS($this->_path . 'views/js/slick.js');
            $this->context->controller->addJS($this->_path . 'views/js/jquery.countdown.js');
            $this->context->controller->addCSS($this->_path . 'views/css/slick.css', 'all');
            $this->context->controller->addCSS($this->_path . 'views/css/slick-theme.css', 'all');
            $this->context->smarty->assign('settings', $this->getPromotionSettings());

            Media::addJsDefL('boncountdown_days', $this->l('day'));
            Media::addJsDefL('boncountdown_hr', $this->l('hr'));
            Media::addJsDefL('boncountdown_min', $this->l('min'));
            Media::addJsDefL('boncountdown_sec', $this->l('sec'));

            return $this->display($this->_path, '/views/templates/hook/promotion-header.tpl');
        }
    }

    public function hookDisplayHome()
    {
        $promotion_front = new ClassPromotion();
        $tabs = $promotion_front->getTopFrontItems($this->id_shop, true);
        $result = [];

        foreach ($tabs as $key => $tab) {
            $result[$key]['title'] = $tab['title'];
            $result[$key]['description'] = $tab['description'];
            $result[$key]['image'] = $tab['image'];
            $result[$key]['type'] = $tab['type'];
            $result[$key]['url'] = $tab['url'];
            $result[$key]['data_end'] = $tab['data_end'];
        }

        if (isset($result[0])) {
            $image = $result[0]['image'];
            Media::addJsDefL('image_baseurl', $this->_path . 'views/img/');
            Media::addJsDefL('image', $image);

            $this->context->smarty->assign('image_baseurl', $this->_path . 'views/img/');
            $this->context->smarty->assign('items', $result);
            $this->smarty->assign([
                'display_carousel' => Configuration::get('BON_PROMOTION_DISPLAY_CAROUSEL'),
            ]);

            $this->context->smarty->assign('limit', Configuration::get('BON_PROMOTION_LIMIT'));

            return $this->display(__FILE__, 'views/templates/hook/promotion-front.tpl');
        }
    }

    public function hookdisplayWrapperBottom()
    {
        return $this->hookDisplayHome();
    }

    public function hookdisplayPromotion()
    {
        return $this->hookDisplayHome();
    }
}
