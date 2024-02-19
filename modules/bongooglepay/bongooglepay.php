<?php

/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Google Pay
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

use PrestaShop\PrestaShop\Core\Payment\PaymentOption;

class Bongooglepay extends PaymentModule
{
    public function __construct()
    {
        $this->name = 'bongooglepay';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = '6e400ebf52a2cee7b32a679fe655e78e';
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Google Pay');
        $this->description = $this->l('This module integration Google Pay.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->successAlert = $this->l('Payment was successful!');
        $this->successDescription = $this->l('We will contact you shortly.');
        $this->errorAlert = $this->l('Error payment!');
    }

    protected function getConfigurations()
    {
        $configurations = array(
            'BONGOOGLEPAY_ENABLE' => 1,
            'BON_BUTTON_COLOR' => 'black',
            'BON_PAYMENT_PROVIDER' => 'adyen',
            'BON_PROVIDER_ID' => 'exampleProviderId',
            'BON_PROVIDER_SECRET' => 'exampleGatewayMerchantSecretKey',
            'BON_MERCHANT_NAME' => 'Example Merchant',
            'BON_GOOGLE_ID' => '12345678901234567890',
            'BONSHIPPING_ADDRESS_ENABLE' => 1,
            'BONSHIPPING_DELIVERY_ENABLE' => 1,
            'BONSHIPPING_BILLING_ENABLE' => 1,
            'BON_GOOGLE_DELIVERY_FIRST' => 'Free: Standard shipping',
            'BON_GOOGLE_DELIVERY_SECOND' => '$10: Express shipping',
        );

        return $configurations;
    }

    public function install()
    {
        $configurations = $this->getConfigurations();

        foreach ($configurations as $name => $config) {
            Configuration::updateValue($name, $config);
        }

        return parent::install() &&
            $this->registerHook('displayBeforeBodyClosingTag') &&
            $this->registerHook('paymentOptions') &&
            $this->registerHook('paymentReturn') &&
            $this->registerHook('productActions') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayHeader');
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
                        'label' => $this->l('Enable:'),
                        'name' => 'BONGOOGLEPAY_ENABLE',
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
                        'type' => 'select',
                        'label' => $this->l('Select Button Color'),
                        'name' => 'BON_BUTTON_COLOR',
                        'col' => 2,
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'white',
                                    'name' => $this->l('White')),
                                array(
                                    'id' => 'black',
                                    'name' => $this->l('Black')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Select Payment Provider'),
                        'name' => 'BON_PAYMENT_PROVIDER',
                        'col' => 2,
                        'options' => array(
                            'query' => $this->getPaymentProviders(),
                            'id' => 'payment_provider',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'text',
                        'required' => true,
                        'label' => $this->l('Payment Provider Public Key (Merchant Id):'),
                        'name' => 'BON_PROVIDER_ID',
                        'col' => 2,
                    ),
                    array(
                        'type' => 'text',
                        'required' => true,
                        'label' => $this->l('Payment Provider Secret Key:'),
                        'name' => 'BON_PROVIDER_SECRET',
                        'col' => 2,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('User-visible merchant name:'),
                        'required' => true,
                        'name' => 'BON_MERCHANT_NAME',
                        'col' => 2,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Google merchant identifier:'),
                        'required' => true,
                        'name' => 'BON_GOOGLE_ID',
                        'col' => 2,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Ask the customer to enter billing address:'),
                        'name' => 'BONSHIPPING_BILLING_ENABLE',
                        'form_group_class' => 'bonship-address',
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
                        'label' => $this->l('Ask the customer to enter shipping address on product page:'),
                        'name' => 'BONSHIPPING_ADDRESS_ENABLE',
                        'form_group_class' => 'bonship-address',
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
                        'label' => $this->l('Show delivery methods on product page:'),
                        'name' => 'BONSHIPPING_DELIVERY_ENABLE',
                        'form_group_class' => 'display-block',
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
                        'type' => 'text',
                        'label' => $this->l('Delivery method on product page:'),
                        'name' => 'BON_GOOGLE_DELIVERY_FIRST',
                        'form_group_class' => 'display-block',
                        'col' => 2,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Delivery method on product page:'),
                        'name' => 'BON_GOOGLE_DELIVERY_SECOND',
                        'form_group_class' => 'display-block',
                        'col' => 2,
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
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getPaymentProviders()
    {
        $paymentProviders = array(
            array('payment_provider' => 'adyen', 'name' => 'Adyen'),
            array('payment_provider' => 'checkoutltd', 'name' => 'Checkout.com'),
        );

        return $paymentProviders;
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

        if (Tools::isEmpty(Tools::getValue('BON_PROVIDER_ID'))) {
            $errors[] = $this->l('Payment Provider Public Key is required.');
        } elseif (Tools::isEmpty(Tools::getValue('BON_PROVIDER_SECRET'))) {
            $errors[] = $this->l('Payment Provider Secret Key is required.');
        } elseif (Tools::isEmpty(Tools::getValue('BON_MERCHANT_NAME'))) {
            $errors[] = $this->l('User-visible merchant name is required.');
        } elseif (Tools::isEmpty(Tools::getValue('BON_GOOGLE_ID'))) {
            $errors[] = $this->l('Google merchant identifier is required.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') != $this->name) {
            return;
        }
        $this->context->controller->addJS($this->_path . 'views/js/bongooglepay-back.js');
    }


    public function googlePayContent()
    {
        $id_lang = $this->context->language->id;

        $cart = $this->context->cart;
        $id_cart = $cart->id;
        $total = $cart->getOrderTotal(true, 3);
        $products_all = $cart->getProducts(false, false, null, true);
        $products_name = array_column($products_all, 'name');

        $address = new AddressCore($cart->id_address_invoice);
        $customer = new CustomerCore($address->id_customer);

        $currency = new Currency((int)($cart->id_currency));
        $current_currency = $currency->iso_code;
        
        $carriers = new Carrier();
        $carrier_countries = $carriers->getDeliveredCountries($id_lang);
        $carrier_countrie_iso = [];
        $carrier_countrie_iso = array_column($carrier_countries, 'iso_code');
 
        $data_fields = [
            'id_cart' => $id_cart,
            'total' => $total,
            'currency' => $current_currency,
            'countrie_iso' => $carrier_countrie_iso,
            'number_products' => $cart->nbProducts(),
            'firstname' => $address->firstname,
            'lastname'=>$address->lastname,
            'phone' => $address->phone,
            'payer_email' => $customer->email,
            'sender_city'=>$address->city,
            'sender_address' => $address->address1 . ' ' . $address->address2,
            'sender_postcode' => $address->postcode,
            'name'=> $products_name,
        ];

        return $data_fields;
    }

    public function infoOnProductPage()
    {
        $id_product = Tools::getValue('id_product');
        $product = new Product($id_product);
        $product_link = $product -> getLink();
        $product_name = $product->getProductName($id_product);
       
        return [$product_link, $product_name];
    }
 
    public function hookDisplayHeader()
    {
        $pageName = $this->context->controller->php_self;

        $payment_data = $this->googlePayContent();
        $total_price = $payment_data['total'];
        $currency = $payment_data['currency'];
        $countrie_iso = $payment_data['countrie_iso'];

        if (Configuration::get('BONGOOGLEPAY_ENABLE') && $pageName == 'order' || $pageName == 'product') {
            $this->context->controller->addJS($this->_path . 'views/js/bongooglepay-front.js');
            $this->context->controller->addCSS($this->_path . 'views/css/bongooglepay.css');
            Media::addJsDefL('bon_button_color', Configuration::get('BON_BUTTON_COLOR'));
            Media::addJsDefL('bon_payment_provider', Configuration::get('BON_PAYMENT_PROVIDER'));
            Media::addJsDefL('bon_provider_id', Configuration::get('BON_PROVIDER_ID'));
            Media::addJsDefL('bon_merchant_name', Configuration::get('BON_MERCHANT_NAME'));
            Media::addJsDefL('bon_google_id', Configuration::get('BON_GOOGLE_ID'));
            Media::addJsDefL('bon_shipping_address_enable', Configuration::get('BONSHIPPING_ADDRESS_ENABLE'));
            Media::addJsDefL('bonshipping_delivery_enable', Configuration::get('BONSHIPPING_DELIVERY_ENABLE'));
            Media::addJsDefL('bonshipping_billing_enable', Configuration::get('BONSHIPPING_BILLING_ENABLE'));
            Media::addJsDefL('total_checkout', $total_price);
            Media::addJsDefL('currency_checkout', $currency);
            Media::addJsDefL('countrie_iso', json_encode($countrie_iso));
            Media::addJsDefL('bon_google_delivery_second', Configuration::get('BON_GOOGLE_DELIVERY_SECOND'));
            Media::addJsDefL('mod_dir', _MODULE_DIR_);

            if (Configuration::get('BON_GOOGLE_DELIVERY_FIRST')) {
                Media::addJsDefL('bon_google_delivery_first', Configuration::get('BON_GOOGLE_DELIVERY_FIRST'));
            } else {
                Media::addJsDefL('bon_google_delivery_first', 'undefined');
            }

            if (Configuration::get('BON_GOOGLE_DELIVERY_SECOND')) {
                Media::addJsDefL('bon_google_delivery_second', Configuration::get('BON_GOOGLE_DELIVERY_SECOND'));
            } else {
                Media::addJsDefL('bon_google_delivery_second', 'undefined');
            }

            return $this->display($this->_path, '/views/templates/hook/bongooglepay-header.tpl');
        }
    }

    public function hookProductActions()
    {
        if (Configuration::get('BONGOOGLEPAY_ENABLE')) {
            $cart = $this->context->cart;
            $this->context->smarty->assign(array(
                'cart' => $cart
            ));

            return $this->display($this->_path, 'views/templates/hook/bongooglepay-product.tpl');
        }
    }
    public function hookDisplayBeforeBodyClosingTag()
    {
        if (Configuration::get('BONGOOGLEPAY_ENABLE')) {
            return $this->display($this->_path, 'views/templates/hook/bongooglepay-confirmation.tpl');
        }
    }

    public function hookPaymentOptions($params)
    {
        /*
         * Verify if this module is active
         */

        if (!$this->active) {
            return [];
        }

        if (!$this->checkCurrency($params['cart'])) {
            return [];
        }

        $newOption = new PaymentOption();
        $newOption->setModuleName($this->name)
            ->setCallToActionText($this->displayName)
            ->setLogo(_MODULE_DIR_ . 'bongooglepay/views/img/logo.png')
            ->setAdditionalInformation($this->fetch('module:bongooglepay/views/templates/hook/bongooglepay-checkout.tpl'));
        $payment_options = [
            $newOption,
        ];

        return $payment_options;
    }

    public function hookPaymentReturn($params)
    {
        if (!$this->active) {
            return;
        }

        return $this->display($this->_path, 'views/templates/hook/bongooglepay-return.tpl');
    }

    public function checkCurrency($cart)
    {
        $currency_order = new Currency($cart->id_currency);
        $currencies_module = $this->getCurrency($cart->id_currency);

        if (is_array($currencies_module)) {
            foreach ($currencies_module as $currency_module) {
                if ($currency_order->id == $currency_module['id_currency']) {
                    return true;
                }
            }
        }
        return false;
    }
}
