<?php
/**
* 2015-2020 Bonpresta
*
* Bonpresta Home Tab Content
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

include_once(_PS_MODULE_DIR_.'bontab/classes/ClassTab.php');

class Bontab extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bontab';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Bonpresta';
        $this->module_key = '13905732aea18a59346f76a671d624e8';
        $this->need_instance = 1;
        $this->bootstrap = true;
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('Product Size Guide and Shipping');
        $this->description = $this->l('Display modal popup on product page.');
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
                $tab->name[$language['id_lang']] = 'bontab';
            }
        }
        $tab->class_name = 'AdminAjaxTab';
        $tab->module = $this->name;
        $tab->id_parent = - 1;
        return (bool)$tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int)Tab::getIdFromClassName('AdminAjaxTab')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {

        include(dirname(__FILE__).'/sql/install.php');
        $this->installSamples();
        return parent::install() &&
            $this->createAjaxController() &&
            $this->registerHook('header') &&
            $this->registerHook('displayProductPopup') &&
            $this->registerHook('displayBackOfficeHeader');
    }

    protected function installSamples()
    {
        $languages = Language::getLanguages(false);
        for ($i = 1; $i <= 2; ++$i) {
            $item = new ClassTab();
            $item->id_shop = (int)$this->context->shop->id;
            $item->status = 1;
            $item->sort_order = $i;
            if ($i == 1) {
                foreach ($languages as $language) {
                $item->title[$language['id_lang']] = 'Size Guide';
                $item->description[$language['id_lang']] = '<div class="size-tab-description"><h2 class="modal-title">Size Guide</h2><p>This is an approximate conversion table to help you find your size.</p>
                    <p>If you already have purchased an item from our brand, we recommend that you select the same size as indicated on the table</p>
                    <table class="bon-table-first"><thead><tr><th>Italian Size</th><th>French Size</th><th>Spanish Size</th><th>German Size</th><th>UK Size</th><th>USA Size</th><th>Japanese Size</th></tr></thead>
                    <tbody>
                    <tr><td>34</td>
                    <td>30</td>
                    <td>30</td>
                    <td>30</td>
                    <td>4</td>
                    <td>00</td>
                    <td>34</td>
                    </tr>
                    <tr>
                    <td>36</td>
                    <td>32</td>
                    <td>32</td>
                    <td>32</td>
                    <td>6</td>
                    <td>0</td>
                    <td>36</td>
                    </tr>
                    <tr>
                    <td>38</td>
                    <td>34</td>
                    <td>34</td>
                    <td>34</td>
                    <td>8</td>
                    <td>2</td>
                    <td>38</td>
                    </tr>
                    <tr>
                    <td>40</td>
                    <td>36</td>
                    <td>36</td>
                    <td>36</td>
                    <td>10</td>
                    <td>4</td>
                    <td>40</td>
                    </tr>
                    <tr>
                    <td>42</td>
                    <td>38</td>
                    <td>38</td>
                    <td>38</td>
                    <td>12</td>
                    <td>6</td>
                    <td>42</td>
                    </tr>
                    <tr>
                    <td>44</td>
                    <td>40</td>
                    <td>40</td>
                    <td>40</td>
                    <td>14</td>
                    <td>8</td>
                    <td>44</td>
                    </tr>
                    <tr>
                    <td>46</td>
                    <td>42</td>
                    <td>42</td>
                    <td>42</td>
                    <td>16</td>
                    <td>10</td>
                    <td>46</td>
                    </tr>
                    <tr>
                    <td>48</td>
                    <td>44</td>
                    <td>44</td>
                    <td>44</td>
                    <td>18</td>
                    <td>12</td>
                    <td>48</td>
                    </tr>
                    <tr>
                    <td>50</td>
                    <td>46</td>
                    <td>46</td>
                    <td>46</td>
                    <td>20</td>
                    <td>14</td>
                    <td>50</td>
                    </tr>
                    <tr>
                    <td>52</td>
                    <td>48</td>
                    <td>48</td>
                    <td>48</td>
                    <td>22</td>
                    <td>16</td>
                    <td>52</td>
                    </tr>
                    </tbody>
                    </table>
                    </div>';
            }
            }
            if ($i == 2) {
                foreach ($languages as $language) {
                    $item->title[$language['id_lang']] = 'Shipping';
                    $item->description[$language['id_lang']] = '<div class="delivery-information-popup">
                    <h2 class="delivery-title">Shipping</h2>
                    <ul>
                    <li>Complimentary ground shipping within 1 to 7 business days</li>
                    <li>In-store collection available within 1 to 7 business days</li>
                    <li>Next-day and Express delivery options also available</li>
                    <li>Purchases are delivered in an orange box tied with a Bolduc ribbon, with the exception of certain items</li>
                    <li>See the delivery FAQs for details on shipping methods, costs and delivery times</li>
                    </ul>
                    <h2 class="delivery-title">Returns and Exchange</h2>
                    <ul>
                    <li>Easy and complimentary, within 14 days</li>
                    <li>See conditions and procedure in our return FAQs</li>
                    </ul>
                    </div>';
                }
            }
            $item->add();
        }
    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');

        return parent::uninstall()
        && $this->removeAjaxContoller();
    }

    public function getContent()
    {

        $output = '';
        $result ='';

        if ((bool)Tools::isSubmit('submitUpdateTab')) {
            if (!$result = $this->preValidateForm()) {
                $output .= $this->addTab();
            } else {
                $output = $result;
                $output .= $this->renderTabForm();
            }
        }

        if ((bool)Tools::isSubmit('statusbontab')) {
            $output .= $this->updateStatusTab();
        }

        if ((bool)Tools::isSubmit('deletebontab')) {
            $output .= $this->deleteTab();
        }

        if (Tools::getIsset('updatebontab') || Tools::getValue('updatebontab')) {
            $output .= $this->renderTabForm();
        } elseif ((bool)Tools::isSubmit('addbontab')) {
            $output .= $this->renderTabForm();
        } elseif (!$result) {
            $output .= $this->renderTabList();
        }

        return $output;
    }
    protected function renderTabForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => ((int)Tools::getValue('id_tab') ? $this->l('Update Tab') : $this->l('Add Tab')),
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
                        'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back'
                    )
                )
            ),
        );

        if ((bool)Tools::getIsset('updatebontab') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassTab((int)Tools::getValue('id_tab'));
            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tab', 'value' => (int)$tab->id);
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitUpdateTab';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigTabFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form));
    }

    protected function getConfigTabFormValues()
    {
        if ((bool)Tools::getIsset('updatebontab') && (int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassTab((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassTab();
        }

        $fields_values = array(
            'id_tab' => Tools::getValue('id_tab'),
            'title' => Tools::getValue('title', $tab->title),
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
        if (!$tabs = ClassTab::getTabList()) {
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
        $helper->table = 'bontab';
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

    protected function addTab()
    {
        $errors = array();

        if ((int)Tools::getValue('id_tab') > 0) {
            $tab = new ClassTab((int)Tools::getValue('id_tab'));
        } else {
            $tab = new ClassTab();
        }

        $tab->id_shop = (int)$this->context->shop->id;
        $tab->status = (int)Tools::getValue('status');

        if ((int)Tools::getValue('id_tab') > 0) {
            $tab->sort_order = Tools::getValue('sort_order');
        } else {
            $tab->sort_order = $tab->getMaxSortOrder((int)$this->id_shop);
        }

        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $tab->title[$language['id_lang']] = Tools::getValue('title_'.$language['id_lang']);
            $tab->description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang']);
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

        if (Tools::isEmpty(Tools::getValue('title_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('The title is required.');
        } elseif (!Validate::isGenericName(Tools::getValue('title_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad title format.');
        }

        if (!Validate::isCleanHtml(Tools::getValue('description_'.$this->default_language['id_lang']))) {
            $errors[] = $this->l('Bad description format.');
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function deleteTab()
    {
        $tab = new ClassTab(Tools::getValue('id_tab'));
        $res = $tab->delete();

        if (!$res) {
            return $this->displayError($this->l('Error occurred when deleting the tab'));
        }

        return $this->displayConfirmation($this->l('The tab is successfully deleted'));
    }

    protected function updateStatusTab()
    {
        $tab = new ClassTab(Tools::getValue('id_tab'));

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

        Media::addJsDefL('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxTab'));
        $this->context->smarty->assign('ajax_theme_url', $this->context->link->getAdminLink('AdminAjaxTab'));
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.sortable');
        $this->context->controller->addJS($this->_path.'views/js/tab-back.js');
        $this->context->controller->addCSS($this->_path.'views/css/tab-back.css');
    }

    public function hookHeader()
    {
        $this->context->controller->addCSS($this->_path.'/views/css/tab-front.css');
    }

    public function hookDisplayProductPopup()
    {
        $tab = new ClassTab();
        $tabs = $tab->getFrontItems($this->id_shop, true);
        $result = array();

        foreach ($tabs as $key => $tab) {
            $result[$key]['title'] = $tab['title'];
            $result[$key]['description'] = $tab['description'];
        }

        $this->context->smarty->assign('items_popups', $result);

        return $this->display(__FILE__, 'views/templates/hook/tab-home.tpl');
    }
}
