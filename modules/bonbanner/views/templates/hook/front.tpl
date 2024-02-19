{*
* 2015-2020 Bonpresta
*
* Bonpresta Responsive banners
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
* @author Bonpresta
* @copyright 2015-2020 Bonpresta
* @license http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

{if isset($items) && $items}
<section id="bonbanners" class="revealOnScroll animated fadeIn" data-animation="fadeIn">
    <ul class="bonbanners-list mb-0">
        {foreach from=$items item=item name=item}
            <li class="bonbanners-item {if isset($item.specific_class) && $item.specific_class}{$item.specific_class|escape:'htmlall':'UTF-8'}{/if} revealOnScroll animated fadeIn"
                data-animation="fadeInUp"
                style="background-image: url('{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}')">
                    <a class="bonbanners-main-link" href="{$item.url|escape:'htmlall':'UTF-8'}" {if $item.blank}target="_blank"{/if} ></a>
                    <div class="banner-inner">
                        <a href="{$item.url|escape:'htmlall':'UTF-8'}" {if $item.blank}target="_blank"{/if} >
                            {if isset($item.title) && $item.title}
                                <p class="h1">{$item.title|escape:'htmlall':'UTF-8'}</p>
                            {/if}
                            {if isset($item.subtitle) && $item.subtitle}
                                <p class="h2">{$item.subtitle|escape:'htmlall':'UTF-8'}</p>
                            {/if}
                            {if isset($item.description) && $item.description}
                                {$item.description nofilter}
                            {/if}
                        </a>
                        <div class="banner-inner_footer">
                            <a href="{$item.url|escape:'htmlall':'UTF-8'}" {if $item.blank}target="_blank"{/if} class="padding-primary btn btn-primary">{l s='View more' mod='bonbanner'}</a>
                            <div class="banner-inner_footer-soc">
                                {if $settings['BON_BANNER_SOCIAL'].value != 0}
                                    {if isset($item.facebook_url) && $item.facebook_url}
                                        <a href="{$item.facebook_url|escape:'htmlall':'UTF-8'}" {if $item.blank}target="_blank"{/if}>
                                            <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.46395 7.83197C2.41595 7.83197 1.35995 7.83197 0.879945 7.83197C0.623945 7.83197 0.543945 7.73597 0.543945 7.49597C0.543945 6.85597 0.543945 6.19997 0.543945 5.55997C0.543945 5.30397 0.639945 5.22397 0.879945 5.22397H2.46395C2.46395 5.17597 2.46395 4.24797 2.46395 3.81597C2.46395 3.17597 2.57595 2.56797 2.89595 2.00797C3.23195 1.43197 3.71195 1.04797 4.31995 0.823967C4.71995 0.679967 5.11995 0.615967 5.55195 0.615967H7.11995C7.34395 0.615967 7.43995 0.711967 7.43995 0.935967V2.75997C7.43995 2.98397 7.34395 3.07997 7.11995 3.07997C6.68795 3.07997 6.25595 3.07997 5.82395 3.09597C5.39195 3.09597 5.16795 3.30397 5.16795 3.75197C5.15195 4.23197 5.16795 4.69597 5.16795 5.19197H7.02395C7.27995 5.19197 7.37595 5.28797 7.37595 5.54397V7.47997C7.37595 7.73597 7.29595 7.81597 7.02395 7.81597C6.44795 7.81597 5.21595 7.81597 5.16795 7.81597V13.032C5.16795 13.304 5.08795 13.4 4.79995 13.4C4.12795 13.4 3.47195 13.4 2.79995 13.4C2.55995 13.4 2.46395 13.304 2.46395 13.064C2.46395 11.384 2.46395 7.87997 2.46395 7.83197Z" fill="#464646"/>
                                            </svg>
                                        </a>
                                    {/if}
                                    {if isset($item.youtube_url) && $item.youtube_url}
                                        <a href="{$item.youtube_url|escape:'htmlall':'UTF-8'}" {if $item.blank}target="_blank"{/if}>
                                            <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.677 0.339111H3.323C1.48775 0.339111 0 1.82686 0 3.66211V8.33812C0 10.1734 1.48775 11.6611 3.323 11.6611H12.677C14.5122 11.6611 16 10.1734 16 8.33812V3.66211C16 1.82686 14.5122 0.339111 12.677 0.339111ZM10.4297 6.22762L6.05451 8.31431C5.93793 8.36991 5.80327 8.28491 5.80327 8.15577V3.85195C5.80327 3.72097 5.94147 3.63608 6.05829 3.69529L10.4335 5.91241C10.5636 5.97832 10.5613 6.16487 10.4297 6.22762Z" fill="#464646"/>
                                            </svg>
                                        </a>
                                    {/if}
                                    {if isset($item.twitter_url) && $item.twitter_url}
                                        <a href="{$item.twitter_url|escape:'htmlall':'UTF-8'}" {if $item.blank}target="_blank"{/if}>
                                            <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16 2.039C15.405 2.3 14.771 2.473 14.11 2.557C14.79 2.151 15.309 1.513 15.553 0.744C14.919 1.122 14.219 1.389 13.473 1.538C12.871 0.897 12.013 0.5 11.077 0.5C9.261 0.5 7.799 1.974 7.799 3.781C7.799 4.041 7.821 4.291 7.875 4.529C5.148 4.396 2.735 3.089 1.114 1.098C0.831 1.589 0.665 2.151 0.665 2.756C0.665 3.892 1.25 4.899 2.122 5.482C1.595 5.472 1.078 5.319 0.64 5.078C0.64 5.088 0.64 5.101 0.64 5.114C0.64 6.708 1.777 8.032 3.268 8.337C3.001 8.41 2.71 8.445 2.408 8.445C2.198 8.445 1.986 8.433 1.787 8.389C2.212 9.688 3.418 10.643 4.852 10.674C3.736 11.547 2.319 12.073 0.785 12.073C0.516 12.073 0.258 12.061 0 12.028C1.453 12.965 3.175 13.5 5.032 13.5C11.068 13.5 14.368 8.5 14.368 4.166C14.368 4.021 14.363 3.881 14.356 3.742C15.007 3.28 15.554 2.703 16 2.039Z" fill="#464646"/>
                                            </svg>
                                        </a>
                                    {/if}
                                    {if isset($item.instagram_url) && $item.instagram_url}
                                        <a href="{$item.instagram_url|escape:'htmlall':'UTF-8'}" {if $item.blank}target="_blank"{/if}>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_91_366)">
                                                    <path d="M11.0694 2.59058C10.882 2.59058 10.7295 2.74307 10.7295 2.93046C10.7295 3.11785 10.882 3.27034 11.0694 3.27034C11.2568 3.27034 11.4093 3.11787 11.4093 2.93046C11.4093 2.74304 11.2568 2.59058 11.0694 2.59058Z" fill="#464646"/>
                                                    <path d="M6.99999 3.98682C5.33853 3.98682 3.98682 5.33853 3.98682 6.99999C3.98682 8.66145 5.33853 10.0132 6.99999 10.0132C8.66148 10.0132 10.0132 8.66148 10.0132 7.00002C10.0132 5.33855 8.66148 3.98682 6.99999 3.98682Z" fill="#464646"/>
                                                    <path d="M10.1621 0H3.83789C1.72167 0 0 1.72167 0 3.83791V10.1621C0 12.2784 1.72167 14 3.83789 14H10.1621C12.2784 14 14 12.2783 14 10.1621V3.83791C14 1.72167 12.2784 0 10.1621 0ZM7 10.8399C4.88264 10.8399 3.16009 9.11736 3.16009 7C3.16009 4.88264 4.88266 3.16012 7 3.16012C9.11734 3.16012 10.8399 4.88266 10.8399 7C10.8399 9.11734 9.11734 10.8399 7 10.8399ZM11.0696 4.09708C10.4263 4.09708 9.90295 3.57372 9.90295 2.93043C9.90295 2.28714 10.4263 1.76375 11.0696 1.76375C11.7129 1.76375 12.2362 2.28711 12.2362 2.9304C12.2362 3.57369 11.7129 4.09708 11.0696 4.09708Z" fill="#464646"/>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_91_366">
                                                        <rect width="14" height="14" fill="white"/>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </a>
                                    {/if}
                                {/if}
                            </div>
                        </div>
                    </div>
            </li>

        {/foreach}
    </ul>
</section>
{/if}