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
    {extends file='page.tpl'}

    {block name='page_title'}
    {l s='Our stores' d='Shop.Theme.Global'}
    {/block}

    {block name='page_content_container'}
    <section id="content" class="page-content page-stores row">

        {foreach $stores as $store}
        <article id="store-{$store.id}" class="store-item col-12">
            <p class="h3 card-title">{$store.name}</p>
            <div class="store-item-container row">
                <div class="store-picture col-12 col-lg-5">
                    <img src="{$store.image.bySize.stores_default.url}" alt="{$store.image.legend}" title="{$store.image.legend}">

                </div>
                <div class="store-description col-12 col-lg-3 col-xl-2">
                    <div class="store-contact-wrapper">

                        <div class="store-block-addres">
                            <h4>{l s='Store Address' d='Shop.Theme.Global'}</h4>
                            <address>{$store.address.formatted nofilter}</address>
                        </div>
                        <div class="store-block-contact">
                            {if $store.note || $store.phone || $store.fax || $store.email}
                            <h4>{l s='Store Contacts' d='Shop.Theme.Global'}</h4>
                            {/if}
                            <footer id="about-{$store.id}" class="">
                                <div class="store-item-footer divide-top">
                                    {if $store.note}
                                    <div class="card-body">
                                        <p class="text-justify">{$store.note}
                                        <p>
                                    </div>
                                    {/if}
                                    <ul class="card-body">
                                        {if $store.phone}
                                        <li><i class="material-icons">&#xE0B0;</i>{$store.phone}</li>
                                        {/if}
                                        {if $store.fax}
                                        <li><i class="material-icons">&#xE8AD;</i>{$store.fax}</li>
                                        {/if}
                                        {if $store.email}
                                        <li><i class="material-icons">&#xE0BE;</i>{$store.email}</li>
                                        {/if}
                                    </ul>
                                </div>
                            </footer>
                        </div>
                    </div>
                </div>
                <div class="divide-left col-12 col-lg-4 col-xl-5">
                    <table class="bon-table-second">
                        {foreach $store.business_hours as $day}
                        <tr>
                            <td>{$day.day}</td>
                            <td>
                                <ul>
                                    {foreach $day.hours as $h}
                                    <li>{$h}</li>
                                    {/foreach}
                                </ul>
                            </td>
                        </tr>
                        {/foreach}
                    </table>
                </div>
            </div>
        </article>
        {/foreach}

    </section>
    {/block}