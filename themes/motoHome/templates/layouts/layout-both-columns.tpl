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
* @author PrestaShop SA <contact@prestashop.com>
    * @copyright 2007-2020 PrestaShop SA
    * @license https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
    * International Registered Trademark & Property of PrestaShop SA
    *}
    <!doctype html>
    <html lang="{$language.iso_code}">

    <head>
        {block name='head'}
        {include file='_partials/head.tpl'}
        {/block}
    </head>

    <body id="{$page.page_name}" class="{$page.body_classes|classnames}">

        {block name='hook_after_body_opening_tag'}
            {hook h='displayAfterBodyOpeningTag'}
        {/block}

        <main>
            {block name='product_activation'}
            {include file='catalog/_partials/product-activation.tpl'}
            {/block}
            {block name='header_nav'}
                <nav class="navigation d-none d-lg-block active" id="navigation">
                    <div class="bon-link-overlay-wrapper">
                        <div class="bon-link-overlay"></div>
                    </div>
                    <div class="d-none d-lg-flex">
                        <div class="navigation-nav1">
                            {hook h='displayNav1'}
                        </div>
                        <div class="navigation-nav2">
                            {hook h='displayNav2'}
                        </div>
                    </div>
                </nav>
            {/block}
            <header id="header">
                {hook h='displayCustomBanner'}
                {block name='header'}
                {include file='_partials/header.tpl'}
                {/block}
            </header>

            {block name='notifications'}
            {include file='_partials/notifications.tpl'}
            {/block}

            <section id="wrapper">
                {if $page.page_name == 'index'}
                {hook h='displayCustomSlick'}
                {/if}
                {hook h="displayWrapperTop"}
                {block name='breadcrumb'}
                {include file='_partials/breadcrumb.tpl'}
                {/block}
                {if $page.page_name != 'index'}
                <div class="container">
                    {if $page.page_name != 'product'} <div class="row"> {/if}
                        {/if}
                        {block name="left_column"}
                        <div id="left-column" class="col-12 col-md-3">
                            {if $page.page_name == 'product'}
                            {hook h='displayLeftColumnProduct'}
                            {else}
                            {hook h="displayLeftColumn"}
                            {/if}
                        </div>
                        {/block}

                        {block name="content_wrapper"}
                        <div id="content-wrapper" class="left-column right-column col-sm-4 col-md-6">
                            {hook h="displayContentWrapperTop"}
                            {block name="content"}
                            <p>Hello world! This is HTML5 Boilerplate.</p>
                            {/block}
                            {hook h="displayContentWrapperBottom"}
                        </div>
                        {/block}

                        {block name="right_column"}
                        <div id="right-column" class="col-12 col-sm-4 col-md-3">
                            {if $page.page_name == 'product'}
                            {hook h='displayRightColumnProduct'}
                            {else}
                            {hook h="displayRightColumn"}
                            {/if}
                        </div>
                        {/block}
                        {if $page.page_name != 'index'}
                    </div>
                </div>
                {/if}
                {hook h="displayWrapperBottom"}

                {if $page.page_name != 'index'}
                </div>
                {/if}
            </section>
        </main>
        {block name='hook_footer_before'}
            <div class="footer_before">
                {hook h='displayFooterBefore'}
            </div>
        {/block}
        <footer id="footer">
            {block name="footer"}
            {include file="_partials/footer.tpl"}
            {/block}
        </footer>

        {block name='javascript_bottom'}
        {include file="_partials/javascript.tpl" javascript=$javascript.bottom}
        {/block}

        {block name='hook_before_body_closing_tag'}
        {hook h='displayBeforeBodyClosingTag'}
        {/block}
        <span id="back-to-top"></span>
    </body>

    </html>