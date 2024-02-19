{*
* Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
*}

{if isset($menus) && $menus}
  {foreach from=$menus item=menu name=menu}
    {if $hookName == $menu['settings']['position_desktop']}
      {if isset($menu['settings']['menu_font_family']) && $menu['settings']['menu_font_family'] != 'default'}
        <link
          href="{$http|escape:'html':'UTF-8'}://fonts.googleapis.com/css?family={$menu['settings']['menu_font_family']|escape:'html':'UTF-8'}"
          rel="stylesheet">
      {/if}
      {if isset($menu['settings']['menu_font_family']) && $menu['settings']['sub_menu_font'] != 'default'}
        <link
          href="{$http|escape:'html':'UTF-8'}://fonts.googleapis.com/css?family={$menu['settings']['sub_menu_font']|escape:'html':'UTF-8'}"
          rel="stylesheet">
      {/if}

      <style>
        #desktop_bonmm_{$smarty.foreach.menu.index} {if $menu['settings']['type'] == "vertical" || $menu['settings']['type'] == "full_screen"}#top-menu-{$smarty.foreach.menu.index}{/if} {
        {if $menu['settings']['image']!= '' && $menu['settings']['color_background'] == ''} 
          background: url('{$image_baseurl|escape:'html':'UTF-8'}{$menu['settings']['image']|escape:'html':'UTF-8'}') no-repeat center center / cover;
        {/if}
        {if $menu['settings']['color_background']!= ''} 
          background-color: {$menu['settings']['color_background']|escape:'html':'UTF-8'};
        {/if}
        }

        #top-menu-{$smarty.foreach.menu.index}[data-bonmm-depth="0"] > li > a, .bonmm-title, .bonmm-mobile-button {
        {if $menu['settings']['menu_font_size'] != ''}
          font-size: {$menu['settings']['menu_font_size']|escape:'html':'UTF-8'}px;
        {/if}
        {if $menu['settings']['menu_font_family'] != 'default'}
          font-family: '{$menu['settings']['menu_font_family']|escape:'html':'UTF-8'}', sans-serif;
        {/if}
        {if $menu['settings']['color_link'] != ''}
          color: {$menu['settings']['color_link']|escape:'html':'UTF-8'};
        {/if}
        }

        .bonmmenu #top-menu-{$smarty.foreach.menu.index}[data-bonmm-depth="0"] .collapse-icons i {
          {if $menu['settings']['color_link'] != ''}
            color: {$menu['settings']['color_link']|escape:'html':'UTF-8'};
          {/if}
        }

        .bonmm-mobile #top-menu-{$smarty.foreach.menu.index}[data-bonmm-depth="0"] .collapse-icons i {
          {if $menu['settings']['mobile_links_color'] != ''} 
            color: {$menu['settings']['mobile_links_color']|escape:'html':'UTF-8'};
          {else}
            color: #ffffff;
          {/if}
        }

        #top-menu-{$smarty.foreach.menu.index}[data-bonmm-depth="0"] > li > a:hover .collapse-icons i {
        {if $menu['settings']['color_link_hover'] != ''}
          color: {$menu['settings']['color_link_hover']|escape:'html':'UTF-8'};
        {/if}
        }

        .bonmmenu .dropdown-submenu,
        #top-menu-{$smarty.foreach.menu.index}[data-bonmm-depth="0"] > li > a {
        text-transform: {$menu['settings']['text_transform']|escape:'html':'UTF-8'};
        }

        #desktop_bonmm_{$smarty.foreach.menu.index} .burger-lines span, 
        #mobile_bonmm_{$smarty.foreach.menu.index} .burger-lines span {
        {if $menu['settings']['color_link'] != ''}
          background-color: {$menu['settings']['color_link']|escape:'html':'UTF-8'};
        {else}
          background-color: #3a3a3a;
        {/if}
        }

        #desktop_bonmm_{$smarty.foreach.menu.index} .bonmm-title:hover .burger-lines span {
        {if $menu['settings']['color_link_hover'] != ''}
          background-color: {$menu['settings']['color_link_hover']|escape:'html':'UTF-8'};
        {/if}
        }

        #desktop_bonmm_{$smarty.foreach.menu.index} .bonmm-title:hover span {
        {if $menu['settings']['color_link_hover'] != ''}
          color: {$menu['settings']['color_link_hover']|escape:'html':'UTF-8'};
        {/if}
        }

        #top-menu-{$smarty.foreach.menu.index}[data-bonmm-depth="0"] > li > a:hover {
        {if $menu['settings']['color_link_hover'] != ''}
          color: {$menu['settings']['color_link_hover']|escape:'html':'UTF-8'};
        {/if}
        }

        #top-menu-{$smarty.foreach.menu.index} .bonmm-top-menu a.dropdown-submenu:hover {
        {if $menu['settings']['sub_color_titles_hover'] != ''}
          color: {$menu['settings']['sub_color_titles_hover']|escape:'html':'UTF-8'};
        {/if}
        }

        #top-menu-{$smarty.foreach.menu.index} .popover  {
        {if $menu['settings']['sub_color_background']!= ''} 
          background-color: {$menu['settings']['sub_color_background']|escape:'html':'UTF-8'};
        {/if}
        }

        #top-menu-{$smarty.foreach.menu.index} .bonmm-top-menu a.dropdown-submenu {
        {if $menu['settings']['sub_color_titles'] != ''}
          color: {$menu['settings']['sub_color_titles']|escape:'html':'UTF-8'};
        {/if}
        {if $menu['settings']['sub_menu_font_size'] != ''}
          font-size: {$menu['settings']['sub_menu_font_size']|escape:'html':'UTF-8'}px;
        {/if}
        {if $menu['settings']['menu_font_family'] != 'default'}
          font-family: '{$menu['settings']['menu_font_family']|escape:'html':'UTF-8'}', sans-serif;
        {/if}
        }

        #top-menu-{$smarty.foreach.menu.index} .bonmm-top-menu a:not(.dropdown-submenu) {
        {if $menu['settings']['sub_menu_font'] != 'default'}
          font-family: '{$menu['settings']['sub_menu_font']|escape:'html':'UTF-8'}', sans-serif;
        {/if}
        {if $menu['settings']['sub_color_link'] != ''}
          color: {$menu['settings']['sub_color_link']|escape:'html':'UTF-8'};
        {/if}
        }

        #top-menu-{$smarty.foreach.menu.index} .bonmm-top-menu a:hover {
        {if $menu['settings']['sub_color_link_hover'] != ''}
          color: {$menu['settings']['sub_color_link_hover']|escape:'html':'UTF-8'};
        {/if}
        }

        #top-menu-{$smarty.foreach.menu.index} .bonmm-top-menu[data-bonmm-depth="2"] a {
        {if $menu['settings']['sub_menu_font_size'] != ''}
          font-size: calc({$menu['settings']['sub_menu_font_size']|escape:'html':'UTF-8'}px - 10%);
        {/if}
        }

        @media (max-width: 1200px) {
          {if $menu['settings']['hide_on_mobile'] == 1}
            #desktop_bonmm_{$smarty.foreach.menu.index},
            #mobile_bonmm_{$smarty.foreach.menu.index} {
            display: none;
          }

        {/if}
        }

        #mobile_bonmm_{$smarty.foreach.menu.index}  .bonmm-top-menu {
        {if $menu['settings']['mobile_background'] != ''} 
          background-color: {$menu['settings']['mobile_background']|escape:'html':'UTF-8'};
        {else}
          background-color: white;
        {/if}
        }

        #mobile_bonmm_{$smarty.foreach.menu.index}  .bonmm-top-menu li a, 
        #mobile_bonmm_{$smarty.foreach.menu.index}  .bonmm-top-menu li a.dropdown-submenu,
        #mobile_bonmm_{$smarty.foreach.menu.index}  .bonmm-top-menu li a:not(.dropdown-submenu) {
        {if $menu['settings']['mobile_links_color'] != ''} 
          color: {$menu['settings']['mobile_links_color']|escape:'html':'UTF-8'};
        {else}
          color: #3a3a3a;
        {/if}
        }

        /* hover effects */
        {if $menu['settings']['main_hover_effect'] == 'underline'} 
          .bonmmenu>.bonmm-top-menu>li>a:after {
            {if $menu['settings']['color_hover_effect'] != ''} 
              background: {$menu['settings']['color_hover_effect']|escape:'html':'UTF-8'};
            {else}
              background: #3a3a3a;
            {/if}
            content: "";
            left: 0;
            position: absolute;
            right: 0;
            top: 100%;
            height: 3px;
            -webkit-transform: scaleX(0);
            transform: scaleX(0);
            transition: all .3s linear;
          }

          .bonmmenu>.bonmm-top-menu>li>a:hover:after {
            -webkit-transform: scaleX(1);
            transform: scaleX(1);
            width: 100%;
          }

          .bonmmenu>.bonmm-top-menu>li>a.nav-arrows:after {
            width: calc(100% - 24px);
          }

        {elseif $menu['settings']['main_hover_effect'] == 'text_shadow'}
          .bonmmenu>.bonmm-top-menu>li>a:hover {
            {if $menu['settings']['color_hover_effect'] != ''} 
              text-shadow: 0 0 20px {$menu['settings']['color_hover_effect']|escape:'html':'UTF-8'};
            {else}
              text-shadow: 0 0 20px #3a3a3a;
            {/if}
          }

        {elseif $menu['settings']['main_hover_effect'] == 'background'}
          .bonmmenu>.bonmm-top-menu>li>a:before {
            right: -10%;
            content: "";
            top: 0;
            bottom: 0;
            {if $menu['settings']['color_hover_effect'] != ''} 
              background: {$menu['settings']['color_hover_effect']|escape:'html':'UTF-8'};
            {else}
              background: #3a3a3a;
            {/if}
            transition: all .3s linear;
            position: absolute;
            z-index: -1;
            width: 0;
            border-radius: 98px;
          }

          .bonmmenu>.bonmm-top-menu>li>a:hover:before {
            width: 120%;
          }

        {elseif $menu['settings']['main_hover_effect'] == 'overline'}
          .bonmmenu>.bonmm-top-menu>li>a:after {
            {if $menu['settings']['color_hover_effect'] != ''} 
              background: {$menu['settings']['color_hover_effect']|escape:'html':'UTF-8'};
            {else}
              background: #3a3a3a;
            {/if}
            content: "";
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            height: 3px;
            -webkit-transform: scaleX(0);
            transform: scaleX(0);
            transition: all .3s linear;
          }

          .bonmmenu>.bonmm-top-menu>li>a:hover:after {
            -webkit-transform: scaleX(1);
            transform: scaleX(1);
            width: 100%;
          }

        {elseif $menu['settings']['main_hover_effect'] == 'transformY'}
          .bonmmenu>.bonmm-top-menu>li>a {
            transform: translateY(0);
            transition: all .3s linear;
          }

          .bonmmenu>.bonmm-top-menu>li>a:hover {
            transform: translateY(-5px);
          }

        {elseif $menu['settings']['main_hover_effect'] == 'both_line'}
          .bonmmenu>.bonmm-top-menu>li>a:after,
          .bonmmenu>.bonmm-top-menu>li>a:before {
            {if $menu['settings']['color_hover_effect'] != ''} 
              background: {$menu['settings']['color_hover_effect']|escape:'html':'UTF-8'};
            {else}
              background: #3a3a3a;
            {/if}
            position: absolute;
            transition: all .3s linear;
          }

          .bonmmenu>.bonmm-top-menu>li>a:after {
            width: 0;
            height: 1px;
            left: 0;
            right: 0;
            margin: 0 auto;
            content: "";
            top: 0;
          }

          .bonmmenu>.bonmm-top-menu>li>a:before {
            content: "";
            width: 0;
            height: 1px;
            bottom: 0;
            left: 0;
            right: 0;
            margin: 0 auto;
          }

          .bonmmenu>.bonmm-top-menu>li>a:hover:before,
          .bonmmenu>.bonmm-top-menu>li>a:hover:after {
            width: 100%;
          }

        {/if}
      </style>
    {/if}
  {/foreach}
{/if}


<div class="menu-main-wrapper">
  {if isset($menus) && $menus}
    {foreach from=$menus item=menu name=menu}
      {if $hookName == $menu['settings']['position_desktop']}
        {assign var=_counter value=0}
        {function name="menu" nodes=[] depth=0 parent=null}
          {if $nodes|count}
            {if isset($menu['settings']['max_depth']) && $menu['settings']['max_depth'] >= $depth || $menu['settings']['max_depth'] == ''}
              <ul
                class="bonmm-top-menu{if $depth == 0} {$menu['settings']['menu_alignment']|escape:'html':'UTF-8'} {if $menu['settings']['type'] != "vertical" && $menu['settings']['type'] != "full_screen"}{$menu['settings']['menu_width']|escape:'html':'UTF-8'}{/if}  {if $menu['settings']['hidde_vertical_menu']}vertical-hidden{/if} {/if}"
                {if $depth == 0} id="top-menu-{$smarty.foreach.menu.index}" {/if}
                {if $depth === 1}bonmm-data-submenu-width="{$menu['settings']['sub_menu_width']|escape:'html':'UTF-8'}" {/if}
                data-bonmm-depth="{$depth}">
                {foreach from=$nodes item=node}
                  <li
                    class="{$node.type}{if $node.current} current {/if} {if $depth == 0 }{foreach from=$menu['subitems_view'] item=view}{if isset($view['column_width']) && $view["id_category"] == $node.page_identifier } {$view['column_width']|escape:'html':'UTF-8'}{/if}{if isset($view['view_type']) && $view["id_category"] == $node.page_identifier} popover_{$view['view_type']|escape:'html':'UTF-8'}{/if}{/foreach}{/if} {if $menu['settings']['collapse_sub']}collapse_sub{/if}"
                    id="{$node.page_identifier}">
                    {assign var=_counter value=$_counter+1}
                    {if $node.type == "manufacturer" && $menu['settings']['brands_image']}
                      <a href="{$node.url}">
                        <img
                          src="{$urls.img_manu_url}{$node.page_identifier|replace:'manufacturer-':''}-{$menu['settings']['brands_img_type']|escape:'html':'UTF-8'}.jpg"
                          alt="{$node.label|escape:'html':'UTF-8'}" />
                      </a>
                    {/if}
                    <a
                      class="{if $depth >= 0}dropdown-item{/if}{if $depth === 1} dropdown-submenu {/if} {if $node.children|count}nav-arrows{/if} {if $depth != 0 && $node.type == "manufacturer" && !$menu['settings']['brands_name']}d-none hidden-xs-down{/if}"
                      href="{$node.url}" data-bonmm-depth="{$depth}"
                      {if $node.open_in_new_window} target="_blank" {/if}>

                      {* category thumb *}
                      {if $node.image_urls|count && $menu['settings']['enable_category_images'] && $depth == 1 || $node.image_urls|count && $menu['settings']['enable_category_images_hover'] && $depth != 0}
                        {foreach from=$node.image_urls item=image_url}
                          <div class="bonmm-category-img {if $menu['settings']['enable_category_images_hover']}on_hover{/if}">
                            <img src="{$image_url}" alt="{$node.label|escape:'html':'UTF-8'}">
                          </div>
                        {/foreach}
                      {/if}
                      {foreach from=$menu['subitems_labels'] item=label}
                        {if $label["id_category"] == $node.page_identifier }
                          {if $label["label_switch_icon"]}
                            <span class="bonmm_label bonmm_label_type_{$label["type_label"]|escape:'html':'UTF-8'}"
                              style="color: {$label["label_text_color"]|escape:'html':'UTF-8'}; border-color:{$label["label_bg_color"]|escape:'html':'UTF-8'}; background: {$label["label_bg_color"]|escape:'html':'UTF-8'}; font-size: {$label["label_font_size"]|escape:'html':'UTF-8'}px; ">{$label["label_name"]|escape:'html':'UTF-8'}</span>
                          {/if}

                          {if $label["switch_icon"]}
                            <i style="font-size: {$label["icon_font_size"]|escape:'html':'UTF-8'}px; color: {$label["icon_color"]|escape:'htmlall':'UTF-8'}"
                              class="bonmm-icon {$label["icon"]|escape:'htmlall':'UTF-8'}">{if $label["type_icon"]=='material_icons'}{$label["icon"]|escape:'htmlall':'UTF-8'|replace:'material-icons':''}{/if}</i>
                          {/if}
                        {/if}
                      {/foreach}
                      {$node.label}
                      {if $node.children|count}
                        {assign var=_expand_id value=10|mt_rand:100000}
                        <span
                          class="float-xs-right   d-block {if $menu['settings']['mobile_view'] == "1200"}d-xl-none hidden-xl-up{elseif $menu['settings']['mobile_view'] == "992"}d-lg-none hidden-lg-up{elseif $menu['settings']['mobile_view'] == "768"}d-md-none hidden-md-up{elseif $menu['settings']['mobile_view'] == "576"} d-sm-none hidden-sm-up{/if}">
                          <span data-target="#top_sub_menu_{$_expand_id}" data-toggle="collapse" class="navbar-toggler collapse-icons">
                            <i class="material-icons add">&#xE313;</i>
                          </span>
                        </span>
                        {if $menu['settings']['collapse_sub'] || $depth == 0 }
                          <span data-target="#top_sub_menu_{$_expand_id}" data-toggle="collapse" class="collapse-icons desktop">
                            <i class="material-icons add">&#xE313;</i>
                          </span>
                        {/if}
                      {/if}
                    </a>
                    {if $node.children|count}
                      <div {if $depth === 0 }class="popover sub-menu collapse"
                          bonmm-data-popup-width="{if $menu['settings']['type'] == "vertical"}vertical{else}{$menu['settings']['sub_menu_popup_width']|escape:'html':'UTF-8'}{/if}"
                        {else}
                          class="collapse"
                        {/if}
                        id="top_sub_menu_{$_expand_id}" data-bonmm-mobile="{$menu['settings']['mobile_view']|escape:'html':'UTF-8'}"
                        {foreach from=$menu['subitems_banner'] item=banners}
                          {if $banners["id_category"] == $node.page_identifier }
                            {if $banners['content_type'] == "background_image" && isset($banners['image'])}
                            style="background: url({$image_baseurl}{$banners['image']|escape:'html':'UTF-8'})" {/if}
                          {/if}
                        {/foreach}>

                        {if $menu['settings']['sub_menu_width'] == "submenu_container_width" && $depth === 0}
                          <div class="container">
                          {/if}
                          {menu nodes=$node.children depth=$node.depth parent=$node}
                          {* custom banners *}
                          {if $menu['subitems_banner']|count && $depth === 0 }<div class="bonmm-banners-wrapper row">{foreach from=$menu['subitems_banner'] item=banners}{if $banners["id_category"] == $node.page_identifier } <a href="{$node.url}" class="banner-wrapper col-12  {$banners["banner_width"]|escape:'html':'UTF-8'}"> {if $banners['content_type'] == "banner"}<div class="img-wrapper"><img src="{$image_baseurl}{$banners['image']|escape:'htmlall':'UTF-8'}" alt="{$banners['title']|escape:'htmlall':'UTF-8'}"></div>{if $banners['description_type'] == "custom_description" && isset($banners['banner_description']) }<div class="custom-description"><h3>{$banners['banner_description']|escape:'htmlall':'UTF-8' nofilter}</h3></div>{/if}{elseif $banners['content_type'] == "video"}<div class="box-video"><div class="video-container"><iframe src="https://www.youtube.com/embed/{$banners['youtube_video']|escape:'htmlall':'UTF-8'}?iv_load_policy=3;rel=0;theme=light&amp;loop=1&amp;rel=0&amp;showinfo=1&amp;controls=1" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div></div> {elseif $banners['content_type'] == "category_image"}{if $node.image_urls|count}{foreach from=$node.image_urls item=image_url}<img src="{$image_url|escape:'html':'UTF-8'}" alt="{$node.label|escape:'html':'UTF-8'}">{/foreach}{/if}{if $banners['description_type'] == "category_description" && $node.description}<div class="category-description">{$node.description|strip_tags|truncate:170:"..."|escape:'html':'UTF-8'}</div>{/if}{/if}</a>{/if}{/foreach}</div>{/if}
                          {* products *}
                          {if $menu['subitems_products']|count && $depth === 0}
                            <div class="bonmm-products-wrapper row">{foreach from=$menu['subitems_products'] item=product}{if $product.id_category == $node.page_identifier}<div class="product-wrapper col-xs-3 col-3 {$product.product_width|escape:'html':'UTF-8'}"><div class="bonmm-product-item"><a href="{$product.info.url|escape:'htmlall':'UTF-8'}" class="bonmm-image-wrapper"><img class="img-responsive" src="{$product.info.cover.bySize.home_default.url|escape:'htmlall':'UTF-8'}" alt="{$product.info.cover.legend|escape:'htmlall':'UTF-8'}" data-full-size-image-url="{$product.info.cover.large.url|escape:'htmlall':'UTF-8'}" /> </a> <div class="bonmm-item-description"> <p class="bonmm-prod-brand"> {if isset($product.info.manufacturer_name)}{$product.info.manufacturer_name|escape:'htmlall':'UTF-8'}{/if} </p> <span class="bonmm-prod-review">{hook h="displayProductListReviews" product=$product.info}</span> <a href="{$product.info.url|escape:'htmlall':'UTF-8'}" class="name">{$product.info.name|escape:'htmlall':'UTF-8'|truncate:25:'...':true}</a> <div class="product-price-and-shipping"> <div class="current-price"> <span class="price {if $product.info.has_discount}price-has-discount{/if}">{$product.info.price|escape:'htmlall':'UTF-8'}</span> {if $product.info.has_discount} {hook h='displayProductPriceBlock' product=$product.info type="old_price"} <span class="regular-price">{$product.info.regular_price|escape:'htmlall':'UTF-8'}</span>{/if}</div></div></div></div></div>{/if}{/foreach}</div>{/if}{if $menu['settings']['sub_menu_width'] == "submenu_container_width"  && $depth === 0}</div>{/if}{/if}
                  </li>
                {/foreach}

                

              {foreach from=$menu['subitems_view'] item=view}{if $view["id_category"] == $node.page_identifier}{assign var="enable_category_description" value=$view["enable_category_description"]}{/if}{/foreach}                
              {if $depth == 1 && isset($node.description) && isset($enable_category_description) && $enable_category_description == true}<div class="bonmm-cat-desc d-none d-xl-block">{$node.description|escape:'html':'UTF-8' nofilter}</div>{/if}
                
                {* contact info *}
                {if  $menu['settings']['type'] == "vertical" || $menu['settings']['type'] == "full_screen"}
                  {if {$menu['settings']['enable_contact_info']}}
                    <li class="bonmm-contant-info">
                      {$shop.name|escape:'html':'UTF-8'}
                      <br>
                      {$shop.address.address1|escape:'html':'UTF-8'} {$shop.address.address2|escape:'html':'UTF-8'}
                      {$shop.address.postcode|escape:'html':'UTF-8'} {$shop.address.state|escape:'html':'UTF-8'}
                      {$shop.address.country|escape:'html':'UTF-8'}
                      <br>
                      <a href="mailto:{$shop.email|escape:'html':'UTF-8'}">{$shop.email|escape:'html':'UTF-8'}</a>
                      <br>
                      {$shop.phone|escape:'html':'UTF-8'}
                      <br>
                      {$shop.fax|escape:'html':'UTF-8'}
                      <br>
                    </li>
                  {/if}
                  {if $menu['settings']['custom_text'] != ''}
                    <li class="bonmm-contant-info">
                      {$menu['settings']['custom_text']|escape:'htmlall':'UTF-8'}
                    </li>
                  {/if}
                {/if}
                {if $depth == 0}
                  <div id="mobile_top_menu_wrapper">
                      <div class="js-top-menu-bottom">
                          <div id="_mobile_currency_selector"></div>
                          <div id="_mobile_language_selector"></div>
                          <div id="_mobile_contact_link"></div>
                      </div>
                  </div>
                {/if}
              </ul>
            {/if}
          {/if}
        {/function}

        {* menu wrapper *}
        <div
          class="bonmmenu direction-{$menu['settings']['type']|escape:'html':'UTF-8'} sub-direction-{$menu['settings']['sub_direction_type']|escape:'html':'UTF-8'} {$menu['settings']['sub_menu_popup_width']|escape:'html':'UTF-8'} d-none {if $menu['settings']['mobile_view'] == "1200"}d-xl-block hidden-lg-down{elseif $menu['settings']['mobile_view'] == "992"}d-lg-block hidden-md-down{elseif $menu['settings']['mobile_view'] == "768"}d-md-block hidden-sm-down{elseif $menu['settings']['mobile_view'] == "576"}d-block d-sm-block hidden-xs-down{/if}"
          id="desktop_bonmm_{$smarty.foreach.menu.index}">
          {if $menu['settings']['type'] == "vertical" || $menu['settings']['type'] == "full_screen"}
            <div
              class="bonmm-title d-none {if $menu['settings']['mobile_view'] == "1200"}d-xl-block hidden-lg-down{elseif $menu['settings']['mobile_view'] == "992"}d-lg-block hidden-md-down{elseif $menu['settings']['mobile_view'] == "768"}d-md-block hidden-sm-down{elseif $menu['settings']['mobile_view'] == "576"}d-block d-sm-block hidden-xs-down{/if}"
              {if $menu['settings']['type'] == "full_screen" || $menu['settings']['type'] == "vertical" && $menu['settings']['hidde_vertical_menu'] }id="hidden-button"
              {/if}>
              <div class="burger-lines">
                <span></span><span></span><span></span>
              </div>
              <span>
                {l s='MENU' mod='bonmegamenu'}
              </span>
            </div>
          {/if}
          {menu nodes=$menu['item'].children}
        </div>
      {/if}
    {/foreach}

    {* mobile menu *}
    {foreach from=$menus item=menu name=menu}
      {if $hookName == $menu['settings']['position_mobile']}
        <div id="mobile_bonmm_{$smarty.foreach.menu.index}"
          class="bonmm-mobile {if $menu['settings']['mobile_view'] == "1200"}d-xl-none hidden-xl-up{elseif $menu['settings']['mobile_view'] == "992"}d-lg-none hidden-lg-up{elseif $menu['settings']['mobile_view'] == "768"}d-md-none hidden-md-up{elseif $menu['settings']['mobile_view'] == "576"}d-block d-sm-none hidden-sm-up{/if}"
          data-id="{$smarty.foreach.menu.index}" data-bonmm-mobile="{$menu['settings']['mobile_view']|escape:'html':'UTF-8'}">
          <div class="bonmm-mobile-button">
            <div class="burger-lines">
              <span></span><span></span><span></span>
            </div>
          </div>
        </div>
      {/if}
    {/foreach}
  {/if}
</div>