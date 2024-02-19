<?php
/**
 * Copyright 2022 ModuleFactory
 *
 * @author    ModuleFactory
 * @copyright ModuleFactory all rights reserved.
 * @license   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
class FsCustomHtmlHelperFormFilter extends FsCustomHtmlHelperForm
{
    protected static $smarty_registered_filter = false;

    protected static $pages;

    private $filter_form_init_function;

    public function __construct()
    {
        parent::__construct();

        $context = Context::getContext();
        if (!self::$smarty_registered_filter) {
            smartyRegisterFunction(
                $context->smarty,
                'modifier',
                'fschFilterContentText',
                [$this, 'getContentText'],
                false
            );
            self::$smarty_registered_filter = true;
        }
    }

    public function getAutoCompleteSearchUrl($content_type)
    {
        return $this->fshelper->getAdminControllerUrl(
            'AdminFsCustomHtmlFilter',
            [
                'ajax' => '1',
                'action' => 'search',
                'content_type' => $content_type,
                'filter_form_init_function' => $this->filter_form_init_function,
            ]
        );
    }

    public function setFilterFormInitFunction($filter_form_init_function)
    {
        $this->filter_form_init_function = $filter_form_init_function;

        return $this;
    }

    public function getFilterFormInitFunction()
    {
        return $this->filter_form_init_function;
    }

    public function getContentText($id_content, $content_type)
    {
        switch ($content_type) {
            case 'category':
                return $this->getCategoryText($id_content);

            case 'product':
                return $this->getProductText($id_content);

            case 'manufacturer':
                return $this->getManufacturerText($id_content);

            case 'supplier':
                return $this->getSupplierText($id_content);

            case 'cms_page':
                return $this->getCMSPageText($id_content);

            case 'cms_category':
                return $this->getCMSCategoryText($id_content);

            case 'customer':
                return $this->getCustomerText($id_content);

            case 'tag':
                return $this->getTagText($id_content);
                
            case 'feature':
                return $this->getFeatureValueText($id_content);

            default:
                return $this->module->l('Content type not defined!');
        }
    }

    public function getFilterRules($grouped = true)
    {
        $conditions_yes_no = [
            'equals' => $this->module->l('equals to'),
            'notequals' => $this->module->l('not equals to'),
        ];

        $conditions_extends = [
            'equals' => $this->module->l('equals to'),
            'notequals' => $this->module->l('not equals to'),
            'startswith' => $this->module->l('starts with'),
            'contains' => $this->module->l('contains'),
            'endswith' => $this->module->l('ends with'),
        ];

        $conditions_numeric = [
            'equals' => $this->module->l('equals to'),
            'notequals' => $this->module->l('not equals to'),
            'less' => $this->module->l('less then'),
            'greater' => $this->module->l('greater then'),
        ];

        $value_true_false = [
            ['id' => 1, 'name' => 'true'],
        ];

        $value_conditions = [
            ['id' => 'new', 'name' => 'New'],
            ['id' => 'used', 'name' => 'Used'],
            ['id' => 'refurbished', 'name' => 'Refurbished'],
        ];

        $value_visibility = [
            ['id' => 'both', 'name' => 'Everywhere'],
            ['id' => 'catalog', 'name' => 'Catalog only'],
            ['id' => 'search', 'name' => 'Search only'],
            ['id' => 'none', 'name' => 'Nowhere'],
        ];

        $value_availability = [
            ['id' => 0, 'name' => 'Deny orders'],
            ['id' => 1, 'name' => 'Allow orders'],
        ];

        $genders = [];
        $genders_raw = Gender::getGenders($this->context->language->id)->getResults();
        if ($genders_raw) {
            foreach ($genders_raw as $gender) {
                $genders[] = [
                    'id' => $gender->id,
                    'name' => $gender->name,
                ];
            }
        }

        $grouped_rules = [
            'date_time' => [
                'label' => $this->module->l('Date Time'),
                'rules' => [
                    'datetime' => [
                        'label' => $this->module->l('Date Time'),
                        'conditions' => $conditions_numeric,
                        'input' => [
                            'type' => 'date_time',
                            'placeholder' => $this->module->l('Please select a date time'),
                        ],
                        'help' => $this->getFilterRuleHelp('date_time'),
                    ],
                    'date' => [
                        'label' => $this->module->l('Date'),
                        'conditions' => $conditions_numeric,
                        'input' => [
                            'type' => 'date',
                            'placeholder' => $this->module->l('Please select a date'),
                        ],
                        'help' => $this->getFilterRuleHelp('date'),
                    ],
                    'time' => [
                        'label' => $this->module->l('Time'),
                        'conditions' => $conditions_numeric,
                        'input' => [
                            'type' => 'time',
                            'placeholder' => $this->module->l('Please select a time'),
                        ],
                        'help' => $this->getFilterRuleHelp('time'),
                    ],
                ],
            ],
            'page' => [
                'label' => $this->module->l('Page'),
                'rules' => [
                    'page_type' => [
                        'label' => $this->module->l('Page Type'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'optiongroup' => [
                                    'query' => $this->getAllPage(true),
                                    'label' => 'label',
                                ],
                                'options' => [
                                    'query' => 'pages',
                                    'id' => 'id',
                                    'name' => 'name',
                                ],
                                'default' => [
                                    'value' => 'all',
                                    'label' => $this->module->l('Any Page'),
                                ],
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('page_type'),
                    ],
                ],
            ],
            'category' => [
                'label' => $this->module->l('Category'),
                'rules' => [
                    'category' => [
                        'label' => $this->module->l('Category'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'category',
                            'url' => $this->getAutoCompleteSearchUrl('category'),
                            'placeholder' => $this->module->l('please select a category'),
                        ],
                        'help' => $this->getFilterRuleHelp('category'),
                    ],
                    'category_parent' => [
                        'label' => $this->module->l('Category Parent'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'category',
                            'url' => $this->getAutoCompleteSearchUrl('category'),
                            'placeholder' => $this->module->l('please select a category'),
                        ],
                        'help' => $this->getFilterRuleHelp('category_parent'),
                    ],
                    'category_children' => [
                        'label' => $this->module->l('Category Children'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'category',
                            'url' => $this->getAutoCompleteSearchUrl('category'),
                            'placeholder' => $this->module->l('please select a category'),
                        ],
                        'help' => $this->getFilterRuleHelp('category_children'),
                    ],
                ],
            ],
            'product' => [
                'label' => $this->module->l('Product'),
                'rules' => [
                    /*'product_feature' => [
                        'label' => $this->module->l('Feature'),
                        'conditions' => $conditions_extends,
                        'parameter' => true,
                        'input' => [
                            'type' => 'text',
                            'placeholder' => 'ID',
                        ],
                        'help' => $this->getFilterRuleHelp('query_parameter'),
                    ],*/
                    'product_feature' => [
                        'label' => $this->module->l('Feature'),
                        'conditions' => $conditions_yes_no,
                        //'parameter' => true,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'feature',
                            'url' => $this->getAutoCompleteSearchUrl('feature'),
                            'placeholder' => 'ID',
                        ],
                        'help' => $this->getFilterRuleHelp('query_parameter'),
                    ],
                    'product' => [
                        'label' => $this->module->l('Product'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'product',
                            'url' => $this->getAutoCompleteSearchUrl('product'),
                            'placeholder' => $this->module->l('please select a product'),
                        ],
                        'help' => $this->getFilterRuleHelp('product'),
                    ],
                    'product_category' => [
                        'label' => $this->module->l('Product Category'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'category',
                            'url' => $this->getAutoCompleteSearchUrl('category'),
                            'placeholder' => $this->module->l('please select a category'),
                        ],
                        'help' => $this->getFilterRuleHelp('product_category'),
                    ],
                    'product_default_category' => [
                        'label' => $this->module->l('Product Default Category'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'category',
                            'url' => $this->getAutoCompleteSearchUrl('category'),
                            'placeholder' => $this->module->l('please select a category'),
                        ],
                        'help' => $this->getFilterRuleHelp('product_default_category'),
                    ],
                    'product_manufacturer' => [
                        'label' => $this->module->l('Product Manufacturer'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'manufacturer',
                            'url' => $this->getAutoCompleteSearchUrl('manufacturer'),
                            'placeholder' => $this->module->l('please select a manufacturer'),
                        ],
                        'help' => $this->getFilterRuleHelp('product_manufacturer'),
                    ],
                    'product_supplier' => [
                        'label' => $this->module->l('Product Supplier'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'supplier',
                            'url' => $this->getAutoCompleteSearchUrl('supplier'),
                            'placeholder' => $this->module->l('please select a supplier'),
                        ],
                        'help' => $this->getFilterRuleHelp('product_supplier'),
                    ],
                    'product_availability' => [
                        'label' => $this->module->l('Product Availability (Out of Stock behavior)'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $value_availability,
                                'id' => 'id',
                                'name' => 'name',
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('product_availability'),
                    ],
                    'product_quantity' => [
                        'label' => $this->module->l('Product Quantity'),
                        'conditions' => $conditions_numeric,
                        'input' => [
                            'type' => 'text',
                            'placeholder' => 'quantity',
                        ],
                        'help' => $this->getFilterRuleHelp('product_quantity'),
                    ],
                    'product_price' => [
                        'label' => $this->module->l('Product Price'),
                        'conditions' => $conditions_numeric,
                        'input' => [
                            'type' => 'text',
                            'placeholder' => 'price',
                        ],
                        'help' => $this->getFilterRuleHelp('product_price'),
                    ],
                    'product_price_specific' => [
                        'label' => $this->module->l('Product has Specific Price (Discounted)'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $value_true_false,
                                'id' => 'id',
                                'name' => 'name',
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('product_price_specific'),
                    ],
                    'product_available_for_order' => [
                        'label' => $this->module->l('Product Available for Order'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $value_true_false,
                                'id' => 'id',
                                'name' => 'name',
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('product_available_for_order'),
                    ],
                    'product_show_price' => [
                        'label' => $this->module->l('Product Show Price'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $value_true_false,
                                'id' => 'id',
                                'name' => 'name',
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('product_show_price'),
                    ],
                    'product_online_only' => [
                        'label' => $this->module->l('Product Online Only'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $value_true_false,
                                'id' => 'id',
                                'name' => 'name',
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('product_online_only'),
                    ],
                    'product_on_sale' => [
                        'label' => $this->module->l('Product on Sale'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $value_true_false,
                                'id' => 'id',
                                'name' => 'name',
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('product_on_sale'),
                    ],
                    'product_condition' => [
                        'label' => $this->module->l('Product Condition'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $value_conditions,
                                'id' => 'id',
                                'name' => 'name',
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('product_condition'),
                    ],
                    'product_visibility' => [
                        'label' => $this->module->l('Product Visibility'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $value_visibility,
                                'id' => 'id',
                                'name' => 'name',
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('product_visibility'),
                    ],
                    'product_tag' => [
                        'label' => $this->module->l('Product Tag'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'tag',
                            'url' => $this->getAutoCompleteSearchUrl('tag'),
                            'placeholder' => $this->module->l('please select a tag'),
                        ],
                        'help' => $this->getFilterRuleHelp('product_tag'),
                    ],
                    'product_weight' => [
                        'label' => $this->module->l('Product Weight (kg)'),
                        'conditions' => $conditions_numeric,
                        'input' => [
                            'type' => 'text',
                            'placeholder' => 'kg',
                        ],
                        'help' => $this->getFilterRuleHelp('product_weight'),
                    ],
                ],
            ],
            'manufacturer' => [
                'label' => $this->module->l('Manufacturer'),
                'rules' => [
                    'manufacturer' => [
                        'label' => $this->module->l('Manufacturer'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'manufacturer',
                            'url' => $this->getAutoCompleteSearchUrl('manufacturer'),
                            'placeholder' => $this->module->l('please select a manufacturer'),
                        ],
                        'help' => $this->getFilterRuleHelp('manufacturer'),
                    ],
                ],
            ],
            'supplier' => [
                'label' => $this->module->l('Supplier'),
                'rules' => [
                    'supplier' => [
                        'label' => $this->module->l('Supplier'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'supplier',
                            'url' => $this->getAutoCompleteSearchUrl('supplier'),
                            'placeholder' => $this->module->l('please select a supplier'),
                        ],
                        'help' => $this->getFilterRuleHelp('supplier'),
                    ],
                ],
            ],
            'cms' => [
                'label' => $this->module->l('CMS'),
                'rules' => [
                    'cms_page' => [
                        'label' => $this->module->l('CMS Page'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'cms_page',
                            'url' => $this->getAutoCompleteSearchUrl('cms_page'),
                            'placeholder' => $this->module->l('please select a cms page'),
                        ],
                        'help' => $this->getFilterRuleHelp('cms_page'),
                    ],
                    'cms_page_category' => [
                        'label' => $this->module->l('CMS Page Category'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'cms_category',
                            'url' => $this->getAutoCompleteSearchUrl('cms_category'),
                            'placeholder' => $this->module->l('please select a cms category'),
                        ],
                        'help' => $this->getFilterRuleHelp('cms_page_category'),
                    ],
                    'cms_category' => [
                        'label' => $this->module->l('CMS Category'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'cms_category',
                            'url' => $this->getAutoCompleteSearchUrl('cms_category'),
                            'placeholder' => $this->module->l('please select a cms category'),
                        ],
                        'help' => $this->getFilterRuleHelp('cms_category'),
                    ],
                ],
            ],
            'customer' => [
                'label' => $this->module->l('Customer'),
                'rules' => [
                    'customer' => [
                        'label' => $this->module->l('Customer'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'customer',
                            'url' => $this->getAutoCompleteSearchUrl('customer'),
                            'placeholder' => $this->module->l('please select a customer'),
                        ],
                        'help' => $this->getFilterRuleHelp('customer'),
                    ],
                    'customer_gender' => [
                        'label' => $this->module->l('Customer Gender'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $genders,
                                'id' => 'id',
                                'name' => 'name',
                                'default' => [
                                    'value' => '',
                                    'label' => $this->module->l('please select a customer gender'),
                                ],
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('customer_gender'),
                    ],
                    'customer_group' => [
                        'label' => $this->module->l('Customer Group'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => Group::getGroups($this->context->language->id),
                                'id' => 'id_group',
                                'name' => 'name',
                                'default' => [
                                    'value' => '',
                                    'label' => $this->module->l('please select a customer group'),
                                ],
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('customer_group'),
                    ],
                    'customer_bought_product' => [
                        'label' => $this->module->l('Customer Bought Product'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'product',
                            'url' => $this->getAutoCompleteSearchUrl('product'),
                            'placeholder' => $this->module->l('please select a product'),
                        ],
                        'help' => $this->getFilterRuleHelp('customer_bought_product'),
                    ],
                    'customer_bought_category' => [
                        'label' => $this->module->l('Customer Bought Product From Category'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'category',
                            'url' => $this->getAutoCompleteSearchUrl('category'),
                            'placeholder' => $this->module->l('please select a category'),
                        ],
                        'help' => $this->getFilterRuleHelp('customer_bought_category'),
                    ],
                    'customer_newsletter_subscription' => [
                        'label' => $this->module->l('Customer Newsletter Subscription'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $value_true_false,
                                'id' => 'id',
                                'name' => 'name',
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('customer_newsletter_subscription'),
                    ],
                ],
            ],
            'cart' => [
                'label' => $this->module->l('Cart'),
                'rules' => [
                    'cart_has_current_product' => [
                        'label' => $this->module->l('Cart Has Current Product'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $value_true_false,
                                'id' => 'id',
                                'name' => 'name',
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('cart_has_current_product'),
                    ],
                    'cart_has_product' => [
                        'label' => $this->module->l('Cart Has Product'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'product',
                            'url' => $this->getAutoCompleteSearchUrl('product'),
                            'placeholder' => $this->module->l('please select a product'),
                        ],
                        'help' => $this->getFilterRuleHelp('cart_has_product'),
                    ],
                    'cart_has_category' => [
                        'label' => $this->module->l('Cart Has Product From Category'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'autocomplete',
                            'content_type' => 'category',
                            'url' => $this->getAutoCompleteSearchUrl('category'),
                            'placeholder' => $this->module->l('please select a category'),
                        ],
                        'help' => $this->getFilterRuleHelp('cart_has_category'),
                    ],
                    'cart_total' => [
                        'label' => $this->module->l('Cart Total'),
                        'conditions' => $conditions_numeric,
                        'input' => [
                            'type' => 'text',
                            'placeholder' => 'total',
                        ],
                        'help' => $this->getFilterRuleHelp('cart_total'),
                    ],
                    'cart_weight' => [
                        'label' => $this->module->l('Cart Weight (kg)'),
                        'conditions' => $conditions_numeric,
                        'input' => [
                            'type' => 'text',
                            'placeholder' => 'kg',
                        ],
                        'help' => $this->getFilterRuleHelp('cart_weight'),
                    ],
                ],
            ],
            'location' => [
                'label' => $this->module->l('Location'),
                'rules' => [
                    'location_zone' => [
                        'label' => $this->module->l('Zone'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => Zone::getZones(true),
                                'id' => 'id_zone',
                                'name' => 'name',
                                'default' => [
                                    'value' => '',
                                    'label' => $this->module->l('please select a zone'),
                                ],
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('location_zone'),
                    ],
                    'location_country' => [
                        'label' => $this->module->l('Country'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => Country::getCountries($this->context->language->id, true),
                                'id' => 'id_country',
                                'name' => 'name',
                                'default' => [
                                    'value' => '',
                                    'label' => $this->module->l('please select a country'),
                                ],
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('location_country'),
                    ],
                ],
            ],
            'url' => [
                'label' => $this->module->l('URL'),
                'rules' => [
                    'referral_url' => [
                        'label' => $this->module->l('Referrer URL'),
                        'conditions' => $conditions_extends,
                        'input' => [
                            'type' => 'text',
                            'placeholder' => 'referrer url',
                        ],
                        'help' => $this->getFilterRuleHelp('referral_url'),
                    ],
                    'request_uri' => [
                        'label' => $this->module->l('Request URI (URL)'),
                        'conditions' => $conditions_extends,
                        'input' => [
                            'type' => 'text',
                            'placeholder' => 'request uri',
                        ],
                        'help' => $this->getFilterRuleHelp('request_uri'),
                    ],
                    'query_string' => [
                        'label' => $this->module->l('Query String'),
                        'conditions' => $conditions_extends,
                        'input' => [
                            'type' => 'text',
                            'placeholder' => 'query string',
                        ],
                        'help' => $this->getFilterRuleHelp('query_string'),
                    ],
                    'query_parameter' => [
                        'label' => $this->module->l('Query Parameter'),
                        'conditions' => $conditions_extends,
                        'parameter' => true,
                        'input' => [
                            'type' => 'text',
                            'placeholder' => 'query parameter value',
                        ],
                        'help' => $this->getFilterRuleHelp('query_parameter'),
                    ],
                ],
            ],
            'other' => [
                'label' => $this->module->l('Other'),
                'rules' => [
                    'currency' => [
                        'label' => $this->module->l('Currency'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => Currency::getCurrencies(),
                                'id' => 'id_currency',
                                'name' => 'name',
                                'default' => [
                                    'value' => '',
                                    'label' => $this->module->l('please select a currency'),
                                ],
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('currency'),
                    ],
                    'mobile' => [
                        'label' => $this->module->l('Mobile Phone'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $value_true_false,
                                'id' => 'id',
                                'name' => 'name',
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('mobile'),
                    ],
                    'tablet' => [
                        'label' => $this->module->l('Tablet'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $value_true_false,
                                'id' => 'id',
                                'name' => 'name',
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('tablet'),
                    ],
                    'desktop' => [
                        'label' => $this->module->l('Desktop'),
                        'conditions' => $conditions_yes_no,
                        'input' => [
                            'type' => 'select',
                            'options' => [
                                'query' => $value_true_false,
                                'id' => 'id',
                                'name' => 'name',
                            ],
                        ],
                        'help' => $this->getFilterRuleHelp('desktop'),
                    ],
                ],
            ],
        ];

        if ($grouped) {
            return $grouped_rules;
        }

        $simple_rules = [];
        foreach ($grouped_rules as $group) {
            foreach ($group['rules'] as $id_rule => $rule) {
                $simple_rules[$id_rule] = $rule;
            }
        }

        return $simple_rules;
    }

    public function getFilterRuleHelp($rule)
    {
        $this->fshelper->smartyAssign([
            'fsch_rule' => $rule,
        ]);

        return $this->fshelper->smartyFetch('admin/help_filter_rules.tpl');
    }

    public function getFilterRuleInfo($rule)
    {
        $filter_rules = $this->getFilterRules();
        foreach ($filter_rules as $group) {
            foreach ($group['rules'] as $id_rule => $info) {
                if ($id_rule == $rule) {
                    return $info;
                }
            }
        }

        return false;
    }

    public function getAllPage($grouped = false)
    {
        if (!isset(self::$pages)) {
            self::$pages = [];

            $pages = array_merge(Meta::getPages(), [
                'product' => 'product',
                'cms' => 'cms',
                'cms-category' => 'cms-category',
                'checkout' => 'checkout',
            ]);

            $exclude = ['index.php', 'pdf-invoice', 'pdf-order-return', 'pdf-order-slip', 'attachment', 'getfile'];

            foreach ($pages as $label => $value) {
                if (!in_array($value, $exclude)) {
                    self::$pages[$value] = $label;
                }
            }

            ksort(self::$pages);
        }

        if (!$grouped) {
            return self::$pages;
        }

        $grouped_pages = [
            'default' => [
                'label' => $this->module->l('Default Pages'),
                'pages' => [],
            ],
            'module' => [
                'label' => $this->module->l('Module Pages'),
                'pages' => [],
            ],
        ];

        foreach (self::$pages as $value => $label) {
            if ($this->fshelper->startsWith($value, 'module-')) {
                $grouped_pages['module']['pages'][] = ['id' => $value, 'name' => $label];
            } else {
                $grouped_pages['default']['pages'][] = ['id' => $value, 'name' => $label];
            }
        }

        return $grouped_pages;
    }

    public function generate()
    {
        foreach ($this->fields_form as &$fieldset) {
            if (isset($fieldset['form']['input'])) {
                foreach ($fieldset['form']['input'] as &$params) {
                    switch ($params['type']) {
                        case 'fsch_filter':
                            $this->fshelper->addCSS('select2.min.css');
                            $this->fshelper->addJS('select2.full.min.js');
                            $this->fshelper->addCSS('filter.css');
                            $this->fshelper->addJS('filter.js');

                            $filter_generate_url = $this->fshelper->getAdminControllerUrl(
                                'AdminFsCustomHtmlFilter',
                                [
                                    'ajax' => '1',
                                    'action' => 'generate',
                                    'filter_form_init_function' => $this->filter_form_init_function,
                                ]
                            );

                            $this->fshelper->smartyAssign([
                                'fsch_filter_rules' => $this->getFilterRules(),
                                'fsch_module_base_url' => $this->fshelper->getModuleBaseUrl(),
                                'fsch_filter_generate_url' => $filter_generate_url,
                            ]);

                            break;
                    }
                }
            }
        }

        return parent::generate();
    }

    public function getPostedFilters($name)
    {
        $raw_data = Tools::getValue($name, false);
        if (!$raw_data) {
            return false;
        }

        $filters = [];
        foreach ($raw_data as $id_filter_group => $filter_group) {
            foreach ($filter_group as $filter) {
                $filter_array = json_decode($filter, true);
                $filter_array['id_filter_group'] = $id_filter_group;

                $filters[$id_filter_group][] = $filter_array;
            }
        }

        return $filters;
    }

    // ############### AJAX ################

    public function autocompleteSearch($content_type, $q, $page, $limit)
    {
        $content = ['items' => [], 'total_count' => 0];
        switch ($content_type) {
            case 'category':
                $content['items'] = $this->searchCategory($q, $page, $limit);
                $content['total_count'] = $this->getSearchCategoryTotalCount($q);
                break;

            case 'product':
                $content['items'] = $this->searchProduct($q, $page, $limit);
                $content['total_count'] = $this->getSearchProductTotalCount($q);
                break;

            case 'manufacturer':
                $content['items'] = $this->searchManufacturer($q, $page, $limit);
                $content['total_count'] = $this->getSearchManufacturerTotalCount($q);
                break;

            case 'supplier':
                $content['items'] = $this->searchSupplier($q, $page, $limit);
                $content['total_count'] = $this->getSearchSupplierTotalCount($q);
                break;

            case 'cms_page':
                $content['items'] = $this->searchCMSPage($q, $page, $limit);
                $content['total_count'] = $this->getSearchCMSPageTotalCount($q);
                break;

            case 'cms_category':
                $content['items'] = $this->searchCMSCategory($q, $page, $limit);
                $content['total_count'] = $this->getSearchCMSCategoryTotalCount($q);
                break;

            case 'customer':
                $content['items'] = $this->searchCustomer($q, $page, $limit);
                $content['total_count'] = $this->getSearchCustomerTotalCount($q);
                break;

            case 'tag':
                $content['items'] = $this->searchTag($q, $page, $limit);
                $content['total_count'] = $this->getSearchTagTotalCount($q);
                break;
            
            case 'feature':
                $content['items'] = $this->searchFeatureValue($q, $page, $limit);
                $content['total_count'] = $this->getSearchFeatureTotalCount($q);
                break;
        }

        return $content;
    }

    public function generateFilterHtml($input_name, $filter_type)
    {
        $selected_value = '';
        if (in_array($filter_type, [
            'mobile',
            'tablet',
            'desktop',
            'customer_newsletter_subscription',
            'product_price_specific',
            'product_available_for_order',
            'product_show_price',
            'product_online_only',
            'product_on_sale',
        ])
        ) {
            $selected_value = '1';
        } elseif (in_array($filter_type, ['page_type'])) {
            $selected_value = 'all';
        } elseif (in_array($filter_type, ['product_condition'])) {
            $selected_value = 'new';
        } elseif (in_array($filter_type, ['product_visibility'])) {
            $selected_value = 'both';
        }

        $this->fshelper->smartyAssign([
            'fsch_filter_rules' => $this->getFilterRules(),
            'fsch_module_base_url' => $this->fshelper->getModuleBaseUrl(),
            'selected_type' => $filter_type,
            'input_name' => $input_name,
            'selected_value' => $selected_value,
        ]);

        return $this->fshelper->smartyFetch('admin/_configure/helpers/form/filter_row.tpl');
    }

    // ############### CATEGORY ################

    public function searchCategory($q, $page = 1, $limit = 10)
    {
        $sql = 'SELECT `id_category` as `id`, `name` as `text` FROM `' . _DB_PREFIX_ . 'category_lang`';
        $sql .= ' WHERE `name` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' AND `id_lang` = \'' . pSQL($this->context->language->id) . '\'';
        $sql .= ' GROUP BY `id_category` LIMIT ' . (int) (($page - 1) * $limit) . ', ' . (int) $limit;
        $result = Db::getInstance()->executeS($sql);

        if ($result) {
            foreach ($result as &$row) {
                $row['text'] = $this->getCategoryText($row['id']);
            }
        }

        return $result;
    }

    public function getCategoryText($id_category)
    {
        $category = new Category($id_category);
        if (Validate::isLoadedObject($category)) {
            $cats = [];
            foreach ($category->getParentsCategories($this->context->language->id) as $cat) {
                $cats[] = $cat['name'];
            }
            $cats = array_reverse($cats);

            return implode(' >> ', $cats);
        } else {
            return $this->module->l('Category not found!');
        }
    }

    public function getSearchCategoryTotalCount($q)
    {
        $sql = 'SELECT COUNT(`id_category`) as `count` FROM `' . _DB_PREFIX_ . 'category_lang`';
        $sql .= ' WHERE `name` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' AND `id_lang` = \'' . pSQL($this->context->language->id) . '\'';
        $sql .= ' GROUP BY `id_shop` ORDER BY count DESC';

        return (int) Db::getInstance()->getValue($sql);
    }

    // ############### PRODUCT ################

    public function searchProduct($q, $page = 1, $limit = 10)
    {
        $sql = 'SELECT `id_product` as `id`, `name` as `text` FROM `' . _DB_PREFIX_ . 'product_lang`';
        $sql .= ' WHERE `name` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' AND `id_lang` = \'' . pSQL($this->context->language->id) . '\'';
        $sql .= ' GROUP BY `id_product` LIMIT ' . (int) (($page - 1) * (int) $limit) . ', ' . (int) $limit;
        $result = Db::getInstance()->executeS($sql);

        if ($result) {
            foreach ($result as &$row) {
                $row['text'] = $this->getProductText($row['id']);
            }
        }

        return $result;
    }

    public function getProductText($id_product)
    {
        $product = new Product($id_product);
        if (Validate::isLoadedObject($product)) {
            $default_category = new Category($product->id_category_default);
            $text = Product::getProductName($id_product, null, $this->context->language->id);
            if (Validate::isLoadedObject($default_category)) {
                $text = $default_category->getName($this->context->language->id) . ' >> ' . $text;
            }

            return $text;
        } else {
            return $this->module->l('Product not found!');
        }
    }

    public function getSearchProductTotalCount($q)
    {
        $sql = 'SELECT COUNT(`id_product`) as `count` FROM `' . _DB_PREFIX_ . 'product_lang`';
        $sql .= ' WHERE `name` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' AND `id_lang` = \'' . pSQL($this->context->language->id) . '\'';
        $sql .= ' GROUP BY `id_shop` ORDER BY count DESC';

        return (int) Db::getInstance()->getValue($sql);
    }

    // ############### MANUFACTURER ################

    public function searchManufacturer($q, $page = 1, $limit = 10)
    {
        $sql = 'SELECT `id_manufacturer` as `id`, `name` as `text` FROM `' . _DB_PREFIX_ . 'manufacturer`';
        $sql .= ' WHERE `name` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' GROUP BY `id_manufacturer` LIMIT ' . (int) (($page - 1) * (int) $limit) . ', ' . (int) $limit;
        $result = Db::getInstance()->executeS($sql);

        return $result;
    }

    public function getManufacturerText($id_manufacturer)
    {
        $manufacturer = new Manufacturer($id_manufacturer);
        if (Validate::isLoadedObject($manufacturer)) {
            return $manufacturer->name;
        } else {
            return $this->module->l('Manufacturer not found!');
        }
    }

    public function getSearchManufacturerTotalCount($q)
    {
        $sql = 'SELECT COUNT(`id_manufacturer`) as `count` FROM `' . _DB_PREFIX_ . 'manufacturer`';
        $sql .= ' WHERE `name` LIKE \'%' . pSQL($q) . '%\'';

        return (int) Db::getInstance()->getValue($sql);
    }

    // ############### SUPPLIER ################

    public function searchSupplier($q, $page = 1, $limit = 10)
    {
        $sql = 'SELECT `id_supplier` as `id`, `name` as `text` FROM `' . _DB_PREFIX_ . 'supplier`';
        $sql .= ' WHERE `name` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' GROUP BY `id_supplier` LIMIT ' . (int) (($page - 1) * (int) $limit) . ', ' . (int) $limit;
        $result = Db::getInstance()->executeS($sql);

        return $result;
    }

    public function getSupplierText($id_supplier)
    {
        $supplier = new Supplier($id_supplier);
        if (Validate::isLoadedObject($supplier)) {
            return $supplier->name;
        } else {
            return $this->module->l('Supplier not found!');
        }
    }

    public function getSearchSupplierTotalCount($q)
    {
        $sql = 'SELECT COUNT(`id_supplier`) as `count` FROM `' . _DB_PREFIX_ . 'supplier`';
        $sql .= ' WHERE `name` LIKE \'%' . pSQL($q) . '%\'';

        return (int) Db::getInstance()->getValue($sql);
    }

    // ############### CMS PAGE ################

    public function searchCMSPage($q, $page = 1, $limit = 10)
    {
        $sql = 'SELECT `id_cms` as `id`, `meta_title` as `text` FROM `' . _DB_PREFIX_ . 'cms_lang`';
        $sql .= ' WHERE `meta_title` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' AND `id_lang` = \'' . pSQL($this->context->language->id) . '\'';
        $sql .= ' GROUP BY `id_cms` LIMIT ' . (int) (($page - 1) * (int) $limit) . ', ' . (int) $limit;
        $result = Db::getInstance()->executeS($sql);

        return $result;
    }

    public function getCMSPageText($id_cms)
    {
        $cms = new CMS($id_cms, $this->context->language->id);
        if (Validate::isLoadedObject($cms)) {
            return $cms->meta_title;
        } else {
            return $this->module->l('CMS Page not found!');
        }
    }

    public function getSearchCMSPageTotalCount($q)
    {
        $sql = 'SELECT COUNT(`id_cms`) as `count` FROM `' . _DB_PREFIX_ . 'cms_lang`';
        $sql .= ' WHERE `meta_title` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' AND `id_lang` = \'' . pSQL($this->context->language->id) . '\'';
        $sql .= ' GROUP BY `id_shop` ORDER BY count DESC';

        return (int) Db::getInstance()->getValue($sql);
    }

    // ############### CMS CATEGORY ################

    public function searchCMSCategory($q, $page = 1, $limit = 10)
    {
        $sql = 'SELECT `id_cms_category` as `id`, `name` as `text` FROM `' . _DB_PREFIX_ . 'cms_category_lang`';
        $sql .= ' WHERE `name` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' AND `id_lang` = \'' . pSQL($this->context->language->id) . '\'';
        $sql .= ' GROUP BY `id_cms_category` LIMIT ' . (int) (($page - 1) * (int) $limit) . ', ' . (int) $limit;
        $result = Db::getInstance()->executeS($sql);

        return $result;
    }

    public function getCMSCategoryText($id_cms_category)
    {
        $cms_category = new CMSCategory($id_cms_category, $this->context->language->id);
        if (Validate::isLoadedObject($cms_category)) {
            return $cms_category->name;
        } else {
            return $this->module->l('Product not found!');
        }
    }

    public function getSearchCMSCategoryTotalCount($q)
    {
        $sql = 'SELECT COUNT(`id_cms_category`) as `count` FROM `' . _DB_PREFIX_ . 'cms_category_lang`';
        $sql .= ' WHERE `name` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' AND `id_lang` = \'' . pSQL($this->context->language->id) . '\'';
        $sql .= ' GROUP BY `id_shop` ORDER BY count DESC';

        return (int) Db::getInstance()->getValue($sql);
    }

    // ############### CUSTOMER ################

    public function searchCustomer($q, $page = 1, $limit = 10)
    {
        $sql = 'SELECT `id_customer` as `id` FROM `' . _DB_PREFIX_ . 'customer`';
        $sql .= ' WHERE `lastname` LIKE \'%' . pSQL($q) . '%\' OR `firstname` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' OR `email` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' GROUP BY `id_customer` LIMIT ' . (int) (($page - 1) * (int) $limit) . ', ' . (int) $limit;
        $result = Db::getInstance()->executeS($sql);

        if ($result) {
            foreach ($result as &$row) {
                $row['text'] = $this->getCustomerText($row['id']);
            }
        }

        return $result;
    }

    public function getCustomerText($id_customer)
    {
        $customer = new Customer($id_customer);
        if (Validate::isLoadedObject($customer)) {
            return $customer->lastname . ', ' . $customer->firstname . ' (' . $customer->email . ')';
        } else {
            return $this->module->l('Supplier not found!');
        }
    }

    public function getSearchCustomerTotalCount($q)
    {
        $sql = 'SELECT COUNT(`id_customer`) as `count` FROM `' . _DB_PREFIX_ . 'customer`';
        $sql .= ' WHERE `lastname` LIKE \'%' . pSQL($q) . '%\' OR `firstname` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' OR `email` LIKE \'%' . pSQL($q) . '%\'';

        return (int) Db::getInstance()->getValue($sql);
    }

    // ############### TAG ################

    public function searchTag($q, $page = 1, $limit = 10)
    {
        $sql = 'SELECT `id_tag` as `id`, `name` as `text` FROM `' . _DB_PREFIX_ . 'tag`';
        $sql .= ' WHERE `name` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' LIMIT ' . (int) (($page - 1) * $limit) . ', ' . (int) $limit;
        $result = Db::getInstance()->executeS($sql);

        return $result;
    }
    
    public function searchFeatureValue($q, $page = 1, $limit = 10)
    {
        /*$sql = 'SELECT `id_feature_value` as `id`, `value` as `text` FROM `' . _DB_PREFIX_ . 'feature_value_lang`';
        $sql .= ' WHERE `value` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' LIMIT ' . (int) (($page - 1) * $limit) . ', ' . (int) $limit;*/
        
        $sql = 'SELECT l.id_feature_value as id, CONCAT(fl.name, \' - \', l.value) AS `text` FROM ps_feature_value_lang l';
        $sql .= ' JOIN ps_feature_value fv ON fv.id_feature_value=l.id_feature_value ';
        $sql .= ' JOIN ps_feature_lang fl ON fl.id_feature=fv.id_feature and fl.id_lang=l.id_lang ';        
        $sql .= ' WHERE l.id_lang=3 and CONCAT(fl.name, \' - \', l.value) LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' LIMIT ' . (int) (($page - 1) * $limit) . ', ' . (int) $limit;
        $result = Db::getInstance()->executeS($sql);

        return $result;
    }
    
    public function getFeatureValueText($id_feature)
    {
        $sql = ' SELECT value FROM ps_feature_value_lang WHERE id_feature_value= ' . pSQL($id_feature);        

        return (String) Db::getInstance()->getValue($sql);
    }

    public function getTagText($id_tag)
    {
        $tag = new Tag($id_tag);
        if (Validate::isLoadedObject($tag)) {
            return $tag->name;
        } else {
            return $this->module->l('Tag not found!');
        }
    }

    public function getSearchTagTotalCount($q)
    {
        $sql = 'SELECT COUNT(`id_tag`) as `count` FROM `' . _DB_PREFIX_ . 'tag`';
        $sql .= ' WHERE `name` LIKE \'%' . pSQL($q) . '%\'';
        $sql .= ' ORDER BY count DESC';

        return (int) Db::getInstance()->getValue($sql);
    }
    
    /*TOM*/
    public function getSearchFeatureTotalCount($q)
    {
        //$sql = 'SELECT COUNT(`id_feature_value`) as `count` FROM `' . _DB_PREFIX_ . 'feature_value_lang`';
        //$sql .= ' WHERE `value` LIKE \'%' . pSQL($q) . '%\'';
        //$sql .= ' ORDER BY count DESC';
        $sql = 'SELECT l.id_feature_value as id, CONCAT(fl.name, ' - ', l.value) AS `text` FROM ps_feature_value_lang l';
        $sql .= ' JOIN ps_feature_value fv ON fv.id_feature_value=l.id_feature_value ';
        $sql .= ' JOIN ps_feature_lang fl ON fl.id_feature=fv.id_feature and fl.id_lang=l.id_lang ';        
        $sql .= ' WHERE l.id_lang=3 and CONCAT(fl.name, \' - \', l.value) LIKE \'%' . pSQL($q) . '%\'';        
        $sql .= ' ORDER BY count DESC';

        return (int) Db::getInstance()->getValue($sql);
    }

    // ############### TOOLTIP HELPERS ################

    public function getTypeText($type)
    {
        $rule_info = $this->getFilterRuleInfo($type);
        if ($rule_info) {
            return $rule_info['label'];
        }

        return '';
    }

    public function getConditionText($type, $condition)
    {
        $rule_info = $this->getFilterRuleInfo($type);
        if ($rule_info) {
            if (isset($rule_info['conditions'][$condition])) {
                return $rule_info['conditions'][$condition];
            }
        }

        return '';
    }

    public function getValueText($type, $value)
    {
        $rule_info = $this->getFilterRuleInfo($type);
        if ($rule_info) {
            $input = $rule_info['input'];

            if ($input['type'] == 'select') {
                if (isset($input['options']['optiongroup'])) {
                    $optgroup_query = $input['options']['optiongroup']['query'];
                    foreach ($optgroup_query as $group) {
                        $items = $group[$input['options']['options']['query']];
                        foreach ($items as $item) {
                            if ($value == $item[$input['options']['options']['id']]) {
                                return $item[$input['options']['options']['name']];
                            }
                        }
                    }

                    if (isset($input['options']['default']['label'])) {
                        return $input['options']['default']['label'];
                    }
                } else {
                    $items = $input['options']['query'];
                    foreach ($items as $item) {
                        if ($value == $item[$input['options']['id']]) {
                            return $item[$input['options']['name']];
                        }
                    }

                    if (isset($input['options']['default']['label'])) {
                        return $input['options']['default']['label'];
                    }
                }
            } elseif ($input['type'] == 'autocomplete') {
                return $this->getContentText($value, $input['content_type']);
            } else {
                return $value;
            }
        }

        return '';
    }
}
