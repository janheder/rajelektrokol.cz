<?php
/**
 * 2007-2021 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2021 PrestaShop SA
 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

include_once(dirname(__FILE__).'/../../boncomments.php');
include_once(dirname(__FILE__).'/../../BonComment.php');
include_once(dirname(__FILE__).'/../../BonCommentCriterion.php');

class boncommentsfeedbackModuleFrontController extends ModuleFrontController
{
	public function __construct()
	{
		parent::__construct();
		$this->context = Context::getContext();
	}

	public function setMedia(){
        parent::setMedia();
    }

	public function initContent()
	{
	    $module = Module::getInstanceByName('boncomments');
	    $nb = (Configuration::get('PC_NB_FEEDBACK') != false ? Configuration::get('PC_NB_FEEDBACK'):10);
	    $total = BonComment::getAllActiveCount();
	    $total = $total[0]['count'];
        $p = (Tools::getValue('p', 0) != 0 ? Tools::getValue('p'):1);
        $comments = BonComment::getAllActive($p, $nb);
        $pagination = array();
        $pagination['items_shown_from'] = ($p == 1 ? 1:$p*$nb-$nb);
        $pagination['items_shown_to'] = ($p == 1 ? $nb:$p*$nb);
        $pagination['total_items'] = $total;
        $pagination['should_be_displayed'] = (ceil($pagination['total_items']/$nb) > 1 ? 1:0);

        for ($i=0; $i<ceil($pagination['total_items']/$nb); $i++){
            $pagination['pages'][$i]['page']=$i+1;
            $pagination['pages'][$i]['clickable']=1;
            $pagination['pages'][$i]['js-search-link']=1;
            if ((int)Tools::getValue('p') == $i+1){
                $pagination['pages'][$i]['current']=1;
            }
            $pagination['pages'][$i]['url']=$this->context->link->getModuleLink('boncomments', 'feedback', array('p'=> $i+1));
        }

	    $this->context->smarty->assign(array(
	        'comments' => $comments,
            'secure_key' => $module->secure_key,
            'pagination' => $pagination,
            'boncomments_controller_url' => $this->context->link->getModuleLink('boncomments'),
            'boncomments_url_rewriting_activated' => (int)Configuration::get('PS_REWRITING_SETTINGS'),
        ));
		parent::initContent();
        $this->setTemplate('module:boncomments/views/templates/front/feedback.tpl');

    }

}
