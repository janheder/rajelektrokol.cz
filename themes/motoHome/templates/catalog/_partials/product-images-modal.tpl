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
<div class="modal modal-gallery js-product-images-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button class="gallery-close"></button>
                {assign var=imagesCount value=$product.images|count}
                <aside id="thumbnails" class="thumbnails js-thumbnails text-sm-center">
                    {block name='product_images'}
                        <div class="js-modal-mask mask {if $imagesCount <= 5} nomargin {/if}">
                            <ul class="product-images js-modal-product-images">
                                {foreach from=$product.images item=image}
                                    <li class="thumb-container" data-image-large-src="{$image.large.url}">
                                        <img data-image-large-src="{$image.large.url}" class="thumb js-modal-thumb" src="{$image.large.url}" alt="{$image.legend}" title="{$image.legend}" itemprop="image">
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    {/block}
                    {if $imagesCount > 5}
                    {/if}
                </aside>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->