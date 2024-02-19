<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Product Comments
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

require_once _PS_MODULE_DIR_ . '/boncomments/BonComment.php';
require_once _PS_MODULE_DIR_ . '/boncomments/BonCommentCriterion.php';

class BonComments extends Module
{
    const INSTALL_SQL_FILE = 'install.sql';

    private $_html = '';
    private $_filters = array();

    private $_bonCommentsCriterionTypes = array();
    private $_baseUrl;

    public function __construct()
    {
        $this->name = 'boncomments';
        $this->tab = 'front_office_features';
        $this->version = '9.9.9';
        $this->author = 'Bonpresta';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->_setFilters();
        parent::__construct();
        $this->secure_key = Tools::encrypt($this->name);
        $this->displayName = $this->l('Product Comments');
        $this->description = $this->l('Allows users to post reviews and rate products on specific criteria.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function install($keep = true)
    {
        if ($keep) {
            if (!file_exists(dirname(__FILE__) . '/' . self::INSTALL_SQL_FILE)) {
                return false;
            } elseif (!$sql = Tools::file_get_contents(dirname(__FILE__) . '/' . self::INSTALL_SQL_FILE)) {
                return false;
            }
            $sql = str_replace(array(
                'PREFIX_',
                'ENGINE_TYPE'
            ), array(
                _DB_PREFIX_,
                _MYSQL_ENGINE_
            ), $sql);
            $sql = preg_split("/;\s*[\r\n]+/", trim($sql));

            foreach ($sql as $query) {
                if (!Db::getInstance()->execute(trim($query))) {
                    return false;
                }
            }
        }

        $this->maybeUpdateDatabase('bon_comment', 'id_shop', 'int(5)', 1);
        $this->maybeUpdateDatabase('bon_comment_criterion', 'id_shop', 'int(5)', 1);

        if (parent::install() == false ||
            !$this->registerHook('displayProductExtraContent') ||
            !$this->registerHook('header') ||
            !$this->registerHook('displayRightColumnProduct') ||
            !$this->registerHook('displayProductListReviews') ||
            !$this->registerHook('displayProductPopup') ||
            !Configuration::updateValue('BON_COMMENTS_MINIMAL_TIME', 30) ||
            !Configuration::updateValue('BON_COMMENTS_ALLOW_GUESTS', 1) ||
            !Configuration::updateValue('BON_COMMENTS_MODERATE', 1)) {
            return false;
        }

        return true;
    }

    public function uninstall($keep = true)
    {
        if (!parent::uninstall() || ($keep && !$this->deleteTables()) || !Configuration::deleteByName('BON_COMMENTS_MODERATE') || !Configuration::deleteByName('BON_COMMENTS_ALLOW_GUESTS') || !Configuration::deleteByName('BON_COMMENTS_MINIMAL_TIME') || !$this->unregisterHook('displayRightColumnProduct') || !$this->unregisterHook('displayProductPopup') || !$this->unregisterHook('header') || !$this->unregisterHook('productFooter') || !$this->unregisterHook('top') || !$this->unregisterHook('displayProductListReviews')) {
            return false;
        }

        return true;
    }

    public function reset()
    {
        if (!$this->uninstall(false)) {
            return false;
        }
        if (!$this->install(false)) {
            return false;
        }

        return true;
    }

    private function maybeUpdateDatabase($table, $column, $type = "int(8)", $default = "1", $null = "NULL")
    {
        $sql = 'DESCRIBE ' . _DB_PREFIX_ . $table;
        $columns = Db::getInstance()->executeS($sql);
        $found = false;
        foreach ($columns as $col) {
            if ($col['Field'] == $column) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            if (!Db::getInstance()->execute('ALTER TABLE `' . _DB_PREFIX_ . $table . '` ADD `' . $column . '` ' . $type . ' DEFAULT ' . $default . ' ' . $null)) {
                return false;
            }
        }
        return true;
    }

    public function deleteTables()
    {
        return true;
        /**
        return Db::getInstance()->execute('
			DROP TABLE IF EXISTS
			`' . _DB_PREFIX_ . 'bon_comment`,
			`' . _DB_PREFIX_ . 'bon_comment_criterion`,
			`' . _DB_PREFIX_ . 'bon_comment_criterion_product`,
			`' . _DB_PREFIX_ . 'bon_comment_criterion_lang`,
			`' . _DB_PREFIX_ . 'bon_comment_criterion_category`,
			`' . _DB_PREFIX_ . 'bon_comment_grade`,
			`' . _DB_PREFIX_ . 'bon_comment_usefulness`,
			`' . _DB_PREFIX_ . 'bon_comment_report`');
         **/
    }

    public function getCacheId($id_product = null)
    {
        return parent::getCacheId() . '|' . (int)$id_product;
    }

    protected function _postProcess()
    {
        $this->_setFilters();

        if (Tools::isSubmit('submitModerate')) {
            Configuration::updateValue('BON_COMMENTS_GDPRCMS', (int)Tools::getValue('BON_COMMENTS_GDPRCMS'));
            Configuration::updateValue('BON_COMMENTS_MODERATE', (int)Tools::getValue('BON_COMMENTS_MODERATE'));
            Configuration::updateValue('BON_COMMENTS_GDPR', (int)Tools::getValue('BON_COMMENTS_GDPR'));
            Configuration::updateValue('BON_COMMENTS_ALLOW_GUESTS', (int)Tools::getValue('BON_COMMENTS_ALLOW_GUESTS'));
            Configuration::updateValue('BON_COMMENTS_MINIMAL_TIME', (int)Tools::getValue('BON_COMMENTS_MINIMAL_TIME'));
            Configuration::updateValue('BON_COMMENTS_LIST', (int)Tools::getValue('BON_COMMENTS_LIST'));
            $this->_html .= '<div class="conf confirm alert alert-success">' . $this->l('Settings updated') . '</div>';
        } elseif (Tools::isSubmit('boncomments')) {
            $id_product_comment = (int)Tools::getValue('id_product_comment');
            $comment = new BonComment($id_product_comment);
            $comment->validate();
            BonComment::deleteReports($id_product_comment);
        } elseif (Tools::isSubmit('deleteboncomments')) {
            $id_product_comment = (int)Tools::getValue('id_product_comment');
            $comment = new BonComment($id_product_comment);
            $comment->delete();
        } elseif (Tools::isSubmit('submitEditCriterion')) {
            $criterion = new BonCommentCriterion((int)Tools::getValue('id_product_comment_criterion'));
            $criterion->id_product_comment_criterion_type = Tools::getValue('id_product_comment_criterion_type');
            $criterion->active = Tools::getValue('active');

            $languages = Language::getLanguages();
            $name = array();

            foreach ($languages as $value) {
                $name[$value['id_lang']] = Tools::getValue('name_' . $value['id_lang']);
            }

            $criterion->name = $name;

            if (!$criterion->validateFields(false) || !$criterion->validateFieldsLang(false)) {
                $this->_html .= '<div class="conf confirm alert alert-danger"> The criterion cannot be saved </div>';
            } else {

                $criterion->save();

                $criterion->deleteCategories();
                $criterion->deleteProducts();
                if ($criterion->id_product_comment_criterion_type == 2) {
                    if ($categories = Tools::getValue('categoryBox')) {
                        if (count($categories)) {
                            foreach ($categories as $id_category) {
                                $criterion->addCategory((int)$id_category);
                            }
                        }
                    }
                }
                elseif ($criterion->id_product_comment_criterion_type == 3) {
                    if ($products = Tools::getValue('ids_product')) {
                        if (count($products)) {
                            foreach ($products as $product) {
                                $criterion->addProduct((int)$product);
                            }
                        }
                    }
                }
                if ($criterion->save()) {
                    Tools::redirectAdmin(Context::getContext()->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&conf=4');
                } else {
                    $this->_html .= '<div class="conf confirm alert alert-danger">' . $this->l('The criterion could not be saved') . '</div>';
                }
            }
        }
        elseif (Tools::isSubmit('deleteboncommentscriterion')) {
            $productCommentCriterion = new BonCommentCriterion((int)Tools::getValue('id_product_comment_criterion'));
            if ($productCommentCriterion->id) {
                if ($productCommentCriterion->delete()) {
                    $this->_html .= '<div class="conf confirm alert alert-success">' . $this->l('Criterion deleted') . '</div>';
                }
            }
        }
        elseif (Tools::isSubmit('statusboncommentscriterion')) {
            $criterion = new BonCommentCriterion((int)Tools::getValue('id_product_comment_criterion'));
            if ($criterion->id) {
                $criterion->active = (int)(!$criterion->active);
                $criterion->save();
            }
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&conf=4&module_name=' . $this->name);
        } elseif ($id_product_comment = (int)Tools::getValue('approveComment')) {
            $comment = new BonComment($id_product_comment);
            $comment->validate();
        } elseif ($id_product_comment = (int)Tools::getValue('noabuseComment')) {
            BonComment::deleteReports($id_product_comment);
        }

        $this->_clearcache('views/templates/hook/boncomments_reviews.tpl');
    }


    public function getContent()
    {
        $this->maybeUpdateDatabase('bon_comment', 'id_shop', 'int(5)', 1);
        $this->maybeUpdateDatabase('bon_comment_criterion', 'id_shop', 'int(5)', 1);

        include_once dirname(__FILE__) . '/BonComment.php';
        include_once dirname(__FILE__) . '/BonCommentCriterion.php';

        $this->_html = '';

        if (Tools::isSubmit('updateboncommentscriterion')) {
            $this->_html .= $this->renderCriterionForm((int)Tools::getValue('id_product_comment_criterion'));
        } else {
            $this->_postProcess();
            $this->_html .= $this->renderConfigForm();
            $this->_html .= $this->renderModerateLists();
            $this->_html .= $this->renderCriterionList();
            $this->_html .= $this->renderCommentsList();
        }

        $this->_setBaseUrl();
        $this->_bonCommentsCriterionTypes = BonCommentCriterion::getTypes();

        $this->context->controller->addJs($this->_path . 'views/js/moderate.js');

        return $this->_html;
    }

    public function psversion($part = 1)
    {
        $version = _PS_VERSION_;
        $exp = explode(".", $version);
        if ($part == 1) {
            return $exp[1];
        }
        if ($part == 2) {
            return $exp[2];
        }
        if ($part == 3) {
            return $exp[3];
        }
    }

    private function _setBaseUrl()
    {
        $this->_baseUrl = 'index.php?';
        foreach (array(Tools::getValue('')) as $k => $value) {
            if (!in_array($k, array('deleteCriterion', 'editCriterion'))) {
                $this->_baseUrl .= $k . '=' . $value . '&';
            }
        }

        $this->_baseUrl = rtrim($this->_baseUrl, '&');
    }

    public function renderConfigForm()
    {
        $fields_form_1 = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuration'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'is_bool' => true,
                        'label' => $this->l('All reviews must be validated by an employee'),
                        'name' => 'BON_COMMENTS_MODERATE',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'is_bool' => true,
                        'label' => $this->l('Allow guest reviews'),
                        'name' => 'BON_COMMENTS_ALLOW_GUESTS',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Minimum time between 2 reviews from the same user'),
                        'name' => 'BON_COMMENTS_MINIMAL_TIME',
                        'class' => 'fixed-width-xs',
                        'suffix' => 'seconds',
                    ),
                    array(
                        'type' => 'switch',
                        'is_bool' => true,
                        'label' => $this->l('Show reviews counter and stars on list of products'),
                        'name' => 'BON_COMMENTS_LIST',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'is_bool' => true,
                        'label' => $this->l('GDPR Compliant'),
                        'name' => 'BON_COMMENTS_GDPR',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Privacy policy page'),
                        'desc' => $this->l('Choose a CMS page with privacy policy details for GDPR purposes'),
                        'name' => 'BON_COMMENTS_GDPRCMS',
                        'class' => 't',
                        'options' => array(
                            'query' => CMS::getCmsPages($this->context->language->id, null, false),
                            'id' => 'id_cms',
                            'name' => 'meta_title'
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right',
                    'name' => 'submitModerate',
                ),
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->name;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->module = $this;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitBonCommentsConfiguration';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );
        return $helper->generateForm(array($fields_form_1));
    }

    public function renderModerateLists()
    {
        $return = null;

        if (Configuration::get('BON_COMMENTS_MODERATE')) {
            $comments = BonComment::getByValidate(0, false);

            $fields_list = $this->getStandardFieldList();

            if (version_compare(_PS_VERSION_, '1.6', '<')) {
                $return .= '<h1>' . $this->l('Reviews waiting for approval') . '</h1>';
                $actions = array(
                    'enable',
                    'delete'
                );
            } else {
                $actions = array(
                    'approve',
                    'delete'
                );
            }

            $helper = new HelperList();
            $helper->shopLinkType = '';
            $helper->simple_header = true;
            $helper->actions = $actions;
            $helper->show_toolbar = false;
            $helper->module = $this;
            $helper->listTotal = count($comments);
            $helper->identifier = 'id_product_comment';
            $helper->title = $this->l('Reviews waiting for approval');
            $helper->table = $this->name;
            $helper->token = Tools::getAdminTokenLite('AdminModules');
            $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
            $return .= $helper->generateList($comments, $fields_list);
        }

        $comments = BonComment::getReportedComments();

        $fields_list = $this->getStandardFieldList();

        if (version_compare(_PS_VERSION_, '1.6', '<')) {
            $return .= '<h1>' . $this->l('Reported Reviews') . '</h1>';
            $actions = array(
                'enable',
                'delete'
            );
        } else {
            $actions = array(
                'delete',
                'noabuse'
            );
        }

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = true;
        $helper->actions = $actions;
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->listTotal = count($comments);
        $helper->identifier = 'id_product_comment';
        $helper->title = $this->l('Reported Reviews');
        $helper->table = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $return .= $helper->generateList($comments, $fields_list);

        return $return;
    }

    public function renderCriterionList()
    {
        include_once dirname(__FILE__) . '/BonCommentCriterion.php';

        $criterions = BonCommentCriterion::getCriterions($this->context->language->id, false, false);

        $fields_list = array(
            'id_product_comment_criterion' => array(
                'title' => $this->l('ID'),
                'type' => 'text',
            ),
            'name' => array(
                'title' => $this->l('Name'),
                'type' => 'text',
            ),
            'type_name' => array(
                'title' => $this->l('Type'),
                'type' => 'text',
            ),
            'active' => array(
                'title' => $this->l('Status'),
                'active' => 'status',
                'type' => 'bool',
            ),
        );

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->actions = array(
            'edit',
            'delete'
        );
        $helper->show_toolbar = true;
        $helper->toolbar_btn['new'] = array(
            'href' => $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&module_name=' . $this->name . '&updateboncommentscriterion',
            'desc' => $this->l('Add New Criterion', null, null, false),
        );
        $helper->module = $this;
        $helper->identifier = 'id_product_comment_criterion';
        $helper->title = $this->l('Review Criteria');
        $helper->table = $this->name . 'criterion';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        return $helper->generateList($criterions, $fields_list);
    }

    public function renderCommentsList()
    {
        $comments = BonComment::getByValidate(1, false);
        $moderate = Configuration::get('BON_COMMENTS_MODERATE');

        if (empty($moderate)) {
            $comments = array_merge($comments, BonComment::getByValidate(0, false));
        }

        $fields_list = $this->getStandardFieldList();

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = true;
        $helper->actions = array('delete');
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->listTotal = count($comments);
        $helper->identifier = 'id_product_comment';
        $helper->title = $this->l('Approved Reviews');
        $helper->table = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        return $helper->generateList($comments, $fields_list);
    }

    public function getConfigFieldsValues()
    {
        return array(
            'BON_COMMENTS_GDPRCMS' => Tools::getValue('BON_COMMENTS_GDPRCMS', Configuration::get('BON_COMMENTS_GDPRCMS')),
            'BON_COMMENTS_GDPR' => Tools::getValue('BON_COMMENTS_GDPR', Configuration::get('BON_COMMENTS_GDPR')),
            'BON_COMMENTS_MODERATE' => Tools::getValue('BON_COMMENTS_MODERATE', Configuration::get('BON_COMMENTS_MODERATE')),
            'BON_COMMENTS_ALLOW_GUESTS' => Tools::getValue('BON_COMMENTS_ALLOW_GUESTS', Configuration::get('BON_COMMENTS_ALLOW_GUESTS')),
            'BON_COMMENTS_MINIMAL_TIME' => Tools::getValue('BON_COMMENTS_MINIMAL_TIME', Configuration::get('BON_COMMENTS_MINIMAL_TIME')),
            'BON_COMMENTS_LIST' => Tools::getValue('BON_COMMENTS_LIST', Configuration::get('BON_COMMENTS_LIST')),
        );
    }

    public function getCriterionFieldsValues($id = 0)
    {
        $criterion = new BonCommentCriterion($id);

        return array(
            'name' => $criterion->name,
            'id_product_comment_criterion_type' => $criterion->id_product_comment_criterion_type,
            'active' => $criterion->active,
            'id_product_comment_criterion' => $criterion->id,
        );
    }

    public function getStandardFieldList()
    {
        return array(
            'id_product_comment' => array(
                'title' => $this->l('ID'),
                'type' => 'text',
            ),
            'title' => array(
                'title' => $this->l('Review title'),
                'type' => 'text',
            ),
            'content' => array(
                'title' => $this->l('Review'),
                'type' => 'text',
            ),
            'grade' => array(
                'title' => $this->l('Rating'),
                'type' => 'text',
                'suffix' => '/5',
            ),
            'customer_name' => array(
                'title' => $this->l('Author'),
                'type' => 'text',
            ),
            'name' => array(
                'title' => $this->l('Product'),
                'type' => 'text',
            ),
            'date_add' => array(
                'title' => $this->l('Time of publication'),
                'type' => 'date',
            ),
        );
    }

    public function renderCriterionForm($id_criterion = 0)
    {
        $types = BonCommentCriterion::getTypes();
        $query = array();
        foreach ($types as $key => $value) {
            $query[] = array(
                'id' => $key,
                'label' => $value,
            );
        }

        $criterion = new BonCommentCriterion((int)$id_criterion);
        $selected_categories = $criterion->getCategories();

        $product_table_values = Product::getSimpleProducts($this->context->language->id);
        $selected_products = $criterion->getProducts();
        foreach ($product_table_values as $key => $product) {
            if (false !== array_search($product['id_product'], $selected_products)) {
                $product_table_values[$key]['selected'] = 1;
            }
        }

        if (version_compare(_PS_VERSION_, '1.6', '<')) {
            $field_category_tree = array(
                'type' => 'categories_select',
                'name' => 'categoryBox',
                'label' => $this->l('Criterion will be restricted to the following categories'),
                'category_tree' => $this->initCategoriesAssociation(null, $id_criterion),
            );
        } else {
            $field_category_tree = array(
                'type' => 'categories',
                'label' => $this->l('Criterion will be restricted to the following categories'),
                'name' => 'categoryBox',
                'desc' => $this->l('Mark the boxes of categories to which this criterion applies.'),
                'tree' => array(
                    'use_search' => false,
                    'id' => 'categoryBox',
                    'use_checkbox' => true,
                    'selected_categories' => $selected_categories,
                ),
                'values' => array(
                    'trads' => array(
                        'Root' => Category::getTopCategory(),
                        'selected' => $this->l('Selected'),
                        'Collapse All' => $this->l('Collapse All'),
                        'Expand All' => $this->l('Expand All'),
                        'Check All' => $this->l('Check All'),
                        'Uncheck All' => $this->l('Uncheck All'),
                    ),
                    'selected_cat' => $selected_categories,
                    'input_name' => 'categoryBox[]',
                    'use_radio' => false,
                    'use_search' => false,
                    'disabled_categories' => array(),
                    'top_category' => Category::getTopCategory(),
                    'use_context' => true,
                ),
            );
        }

        $fields_form_1 = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Add new criterion'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'hidden',
                        'name' => 'id_product_comment_criterion',
                    ),
                    array(
                        'type' => 'text',
                        'lang' => true,
                        'label' => $this->l('Criterion name'),
                        'name' => 'name',
                        'required' => true,
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'id_product_comment_criterion_type',
                        'label' => $this->l('Application scope of the criterion'),
                        'options' => array(
                            'query' => $query,
                            'id' => 'id',
                            'name' => 'label',
                        ),
                    ),
                    $field_category_tree,
                    array(
                        'type' => 'products',
                        'label' => $this->l('The criterion will be restricted to the following products'),
                        'name' => 'ids_product',
                        'values' => $product_table_values,
                    ),
                    array(
                        'type' => 'switch',
                        'is_bool' => true,
                        //retro compat 1.5
                        'label' => $this->l('Active'),
                        'name' => 'active',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right',
                    'name' => 'submitEditCriterion',
                ),
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->name;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->module = $this;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitEditCriterion';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getCriterionFieldsValues($id_criterion),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form_1));
    }

    private function _checkDeleteComment()
    {
        $action = Tools::getValue('delete_action');
        if (empty($action) === false) {
            $product_comments = Tools::getValue('delete_id_product_comment');

            if (count($product_comments)) {
                if ($action == 'delete') {
                    foreach ($product_comments as $id_product_comment) {
                        if (!$id_product_comment) {
                            continue;
                        }
                        $comment = new BonComment((int)$id_product_comment);
                        $comment->delete();
                        BonComment::deleteGrades((int)$id_product_comment);
                        BonComment::deleteReports((int)$id_product_comment);
                    }
                }
            }
        }
    }

    private function _setFilters()
    {
        $this->_filters = array(
            'page' => (string)Tools::getValue('submitFilter' . $this->name),
            'pagination' => (string)Tools::getValue($this->name . '_pagination'),
            'filter_id' => (string)Tools::getValue($this->name . 'Filter_id_product_comment'),
            'filter_content' => (string)Tools::getValue($this->name . 'Filter_content'),
            'filter_customer_name' => (string)Tools::getValue($this->name . 'Filter_customer_name'),
            'filter_grade' => (string)Tools::getValue($this->name . 'Filter_grade'),
            'filter_name' => (string)Tools::getValue($this->name . 'Filter_name'),
            'filter_date_add' => (string)Tools::getValue($this->name . 'Filter_date_add'),
        );
    }

    public function displayApproveLink($token, $id, $name = null)
    {
        $this->smarty->assign(array(
            'href' => $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&module_name=' . $this->name . '&approveComment=' . $id,
            'action' => $this->l('Approve'),
        ));

        return $this->display(__FILE__, 'views/templates/admin/list_action_approve.tpl');
    }

    public function displayNoabuseLink($token, $id, $name = null)
    {
        $this->smarty->assign(array(
            'href' => $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&module_name=' . $this->name . '&noabuseComment=' . $id,
            'action' => $this->l('Not abusive'),
        ));

        return $this->display(__FILE__, 'views/templates/admin/list_action_noabuse.tpl');
    }

    public function hookDisplayProductListReviews($params)
    {
        $id_product = (int)$params['product']['id_product'];
        if (!$this->isCached('module:boncomments/views/templates/hook/boncomments_reviews.tpl', $this->getCacheId($id_product))) {
            $average = BonComment::getAverageGrade($id_product);
            $this->smarty->assign(array(
                'product' => $params['product'],
                'averageTotal' => round($average['grade']),
                'ratings' => BonComment::getRatings($id_product),
                'nbComments' => (int)BonComment::getCommentNumber($id_product),
                'BON_COMMENTS_LIST' => (int)Configuration::get('BON_COMMENTS_LIST'),
            ));
        }

        return $this->fetch('module:boncomments/views/templates/hook/boncomments_reviews.tpl', $this->getCacheId($id_product));
    }

    public function hookdisplayProductExtraContent($params)
    {
        if (Tools::getValue('ajax','false') == 'false') {
            $tabz = array();
            $tabz[] = (new PrestaShop\PrestaShop\Core\Product\ProductExtraContent())->setTitle($this->l('Reviews'))->setContent($this->hookProductFooter($params));
            return $tabz;
        } else {
            return array();
        }
    }

    public function hookProductFooter($params)
    {
        if (Tools::getValue('action') == 'quickview') {
            return false;
        }

        $id_guest = ((int)$this->context->cookie->id_customer) ? (int)$this->context->cookie->id_guest : false;
        $customerComment = BonComment::getByCustomer((int)(Tools::getValue('id_product')), (int)$this->context->cookie->id_customer, true, (int)$id_guest);

        $averages = BonComment::getAveragesByProduct((int)Tools::getValue('id_product'), $this->context->language->id);
        $averageTotal = 0;

        foreach ($averages as $average) {
            $averageTotal += (float)($average);
        }

        $averageTotal = count($averages) ? ($averageTotal / count($averages)) : 0;

        $product = $this->context->controller->getProduct();
        $image = Product::getCover((int)Tools::getValue('id_product'));
        $cover_image = $this->context->link->getImageLink($product->link_rewrite, $image['id_image'], ImageType::getFormattedName('medium'));

        $this->context->smarty->assign(array(
            'logged' => $this->context->customer->isLogged(true),
            'action_url' => '',
            'link' => $this->context->link,
            'productcomments_product' => $product,
            'comments' => BonComment::getByProduct((int)Tools::getValue('id_product'), 1, null, $this->context->cookie->id_customer),
            'criterions' => BonCommentCriterion::getByProduct((int)Tools::getValue('id_product'), $this->context->language->id),
            'averages' => $averages,
            'product_comment_path' => $this->_path,
            'averageTotal' => $averageTotal,
            'allow_guests' => (int)Configuration::get('BON_COMMENTS_ALLOW_GUESTS'),
            'BON_COMMENTS_GDPR' => (int)Configuration::get('BON_COMMENTS_GDPR'),
            'BON_COMMENTS_LIST' => (int)Configuration::get('BON_COMMENTS_LIST'),
            'BON_COMMENTS_GDPRCMS' => (int)Configuration::get('BON_COMMENTS_GDPRCMS'),
            'too_early' => ($customerComment && (strtotime($customerComment['date_add']) + Configuration::get('BON_COMMENTS_MINIMAL_TIME')) > time()),
            'delay' => Configuration::get('BON_COMMENTS_MINIMAL_TIME'),
            'id_product_comment_form' => (int)Tools::getValue('id_product'),
            'secure_key' => $this->secure_key,
            'productcomment_cover' => (int)Tools::getValue('id_product') . '-' . (int)$image['id_image'],
            'productcomment_cover_image' => $cover_image,
            'mediumSize' => Image::getSize(ImageType::getFormattedName('medium')),
            'nbComments' => (int)BonComment::getCommentNumber((int)Tools::getValue('id_product')),
            'productcomments_controller_url' => $this->context->link->getModuleLink('boncomments'),
            'productcomments_url_rewriting_activated' => (int)Configuration::get('PS_REWRITING_SETTINGS'),
            'moderation_active' => (int)Configuration::get('BON_COMMENTS_MODERATE'),
        ));

        return $this->display(__FILE__, '/views/templates/hook/boncomments.tpl');
    }

    public function  hookDisplayProductPopup()
    {

        return $this->display(__FILE__, '/views/templates/hook/boncomments_popup.tpl');
    }
   
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path . 'views/js/jquery.rating.pack.js');
        $this->context->controller->addJS($this->_path . 'views/js/jquery.textareaCounter.plugin.js');
        $this->context->controller->addJS($this->_path . 'views/js/boncomments.js');
        $this->context->controller->addCSS($this->_path . 'views/css/boncomments.css', 'all');
        $this->context->controller->addjqueryPlugin('fancybox');
        $this->page_name = Dispatcher::getInstance()->getController();
    }

    public static function getImagesByID($id_product, $limit = 1)
    {
        $id_image = Db::getInstance()->ExecuteS('SELECT `id_image` FROM `' . _DB_PREFIX_ . 'image` WHERE `id_product` = ' . (int)($id_product) . ' ORDER BY position ASC LIMIT 0, ' . $limit);
        $toReturn = array();
        if (!$id_image) {
            return;
        } else {
            foreach ($id_image as $image) {
                $toReturn[] = $id_product . '-' . $image['id_image'];
            }
        }
        return $toReturn;
    }

    public function hookdisplayLeftColumnProduct($params)
    {
        if (Tools::getValue('controller') != 'product') {
            return;
        } else {
            return $this->hookProductFooter($params);
        }
    }

    public function hookdisplayRightColumnProduct($params)
    {
        return $this->hookdisplayLeftColumnProduct($params);
    }

    public function initCategoriesAssociation($id_root = null, $id_criterion = 0)
    {
        if (is_null($id_root)) {
            $id_root = Configuration::get('PS_ROOT_CATEGORY');
        }

        $id_shop = (int)Tools::getValue('id_shop');
        $shop = new Shop($id_shop);

        if ($id_criterion == 0) {
            $selected_cat = array();
        } else {
            $pdc_object = new BonCommentCriterion($id_criterion);
            $selected_cat = $pdc_object->getCategories();
        }

        if (Shop::getContext() == Shop::CONTEXT_SHOP && Tools::isSubmit('id_shop')) {
            $root_category = new Category($shop->id_category);
        } else {
            $root_category = new Category($id_root);
        }

        $root_category = array(
            'id_category' => $root_category->id,
            'name' => $root_category->name[$this->context->language->id]
        );

        $helper = new Helper();

        return $helper->renderCategoryTree($root_category, $selected_cat, 'categoryBox', false, true);
    }
}
