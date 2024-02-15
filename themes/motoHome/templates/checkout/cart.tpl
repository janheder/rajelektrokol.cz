{**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
 {extends file=$layout}

 {block name='content'}
 
   <section id="main" class="row">
    
 
       <!-- Left Block: cart product informations & shpping -->
       
 <div class="cart-grid-body {if empty($cart.products)} col-12 {else}col-12 col-lg-8 {/if}">
 
   
         <!-- cart products detailed -->
         <div class="card cart-container">
           <div class="card-body">
             <h1 class="h1">{l s='Shopping Cart' d='Shop.Theme.Checkout'}</h1>
           </div>
           <hr class="separator">
           {block name='cart_overview'}
             {include file='checkout/_partials/cart-detailed.tpl' cart=$cart}
           {/block}
         </div>
         {* <img src=" {$urls.pages.index}img/cms/empty-cart.png" alt=""> *}
         <div class="cart-grid-body-content">
           <img src="{$urls.img_url}/empty-cart.png" alt="empty-cart">
           <h2>{l s='Continue shopping' d='Shop.Theme.Actions'}</h2>
           <p>{l s='Once you added items to your shopping cart, you can check out from here' d='Shop.Theme.Actions'}</p>
         </div>
         <a class="label btn-primary" href="{$urls.pages.index}">
             {l s='SHOP NOW!' d='Shop.Theme.Actions'}
           </a>
         {block name='continue_shopping'}
           <a class="label" href="{$urls.pages.index}">
             <i class="material-icons">chevron_left</i>{l s='Continue shopping' d='Shop.Theme.Actions'}
           </a>
         {/block}
 
         <!-- shipping informations -->
         {block name='hook_shopping_cart_footer'}
           {hook h='displayShoppingCartFooter'}
         {/block}
       </div>
 
       <!-- Right Block: cart subtotal & cart total -->
       <div class="cart-grid-right col-12 col-lg-4">
 
         {block name='cart_summary'}
           <div class="card cart-summary">
 
             {block name='hook_shopping_cart'}
               {hook h='displayShoppingCart'}
             {/block}
 
             {block name='cart_totals'}
               {include file='checkout/_partials/cart-detailed-totals.tpl' cart=$cart}
             {/block}
 
             {block name='cart_actions'}
               {include file='checkout/_partials/cart-detailed-actions.tpl' cart=$cart}
             {/block}
 
           </div>
         {/block}
 
         {block name='hook_reassurance'}
           {hook h='displayReassurance'}
         {/block}
 
       </div>
 
    
   </section>
 {/block}
 