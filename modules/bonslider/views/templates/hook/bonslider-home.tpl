{*
* 2015-2021 Bonpresta
*
* Bonpresta Slider Manager with Photos and Videos
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
* @copyright 2015-2021 Bonpresta
* @license http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

{if isset($items) && $items && $display_carousel}

    <div class="clearfix"></div>
    <section id="bonslider" class="swiper">
        <ul class="bonslider-slider swiper-wrapper">
            {foreach from=$items item=item name=item}
                {if $item.type == 'image'}
                    {if $smarty.foreach.item.iteration <= $limit}
                        <li class="bonslider-item swiper-slide">
                            <a class="link-bonslider" href="{$item.url|escape:'htmlall':'UTF-8'}">
                                {if isset($item.image) && $item.image}
                                    <img class="img-responsive"
                                        src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                        alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                {/if}
                                {if isset($item.subitems) && $item.subitems}
                                    <div class="bonslider-subitem">
                                        {foreach from=$item.subitems item=item name=item}
                                            {if $item.image|escape:'htmlall':'UTF-8'}
                                                <img class="{$item.title|escape:'htmlall':'UTF-8'} {$item.animation|escape:'htmlall':'UTF-8'}"
                                                     style="top:{$item.top|escape:'htmlall':'UTF-8'}%; right:{$item.right|escape:'htmlall':'UTF-8'}%; z-index:{$item.zindex|escape:'htmlall':'UTF-8'};animation-delay: {$item.animation_delay|escape:'htmlall':'UTF-8'}ms"
                                                     src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                                     alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                            {/if}
                                            {if $item.description}
                                                <div style="top:{$item.top|escape:'htmlall':'UTF-8'}%; right:{$item.right|escape:'htmlall':'UTF-8'}%; z-index:{$item.zindex|escape:'htmlall':'UTF-8'};animation-delay: {$item.animation_delay|escape:'htmlall':'UTF-8'}ms"
                                                     class="bonslider-subitem-text {$item.animation|escape:'htmlall':'UTF-8'}">
                                                    {$item.description nofilter}
                                                </div>
                                            {/if}
                                        {/foreach}
                                    </div>
                                {/if}
                                {if isset($item.description) && $item.description}
                                    <div class="bonslider-item-description" data-swiper-parallax-scale="0.3" data-swiper-parallax-y="-60%" data-swiper-parallax-opacity="0" data-swiper-parallax-duration="800">
                                        {$item.description nofilter}
                                    </div>
                                {/if}
                            </a>
                            {if $twitter_link || $facebook_link || $instagram_link}
                                <div class="bonslider-social">
                                    {if $soc_title}
                                        <p class="bonslider-social-title">{$soc_title|escape:'htmlall':'UTF-8'}</p>
                                    {/if}
                                    {if $twitter_link}
                                        <a class="bonslider-social-link" href="{$twitter_link|escape:'htmlall':'UTF-8'}">
                                            <svg width="16" height="13" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M17.125 1.9668C16.5273 2.22461 15.877 2.41016 15.207 2.48242C15.9026 2.06921 16.4234 1.41641 16.6719 0.646485C16.0192 1.03474 15.3042 1.307 14.5586 1.45117C14.247 1.11802 13.8701 0.852617 13.4514 0.671499C13.0327 0.490381 12.5812 0.39743 12.125 0.398438C10.2793 0.398438 8.79492 1.89453 8.79492 3.73047C8.79492 3.98828 8.82617 4.24609 8.87695 4.49414C6.11328 4.34961 3.64844 3.0293 2.00977 1.00781C1.71118 1.5178 1.55471 2.09849 1.55664 2.68945C1.55664 3.8457 2.14453 4.86523 3.04102 5.46484C2.5127 5.44404 1.99676 5.29882 1.53516 5.04102V5.08203C1.53516 6.70117 2.67969 8.04297 4.20508 8.35156C3.91867 8.42596 3.62404 8.46402 3.32812 8.46484C3.11133 8.46484 2.90625 8.44336 2.69922 8.41406C3.12109 9.73438 4.34961 10.6934 5.8125 10.7246C4.66797 11.6211 3.23437 12.1484 1.67773 12.1484C1.39844 12.1484 1.14062 12.1387 0.873047 12.1074C2.34961 13.0547 4.10156 13.6016 5.98828 13.6016C12.1133 13.6016 15.4648 8.52734 15.4648 4.12305C15.4648 3.97852 15.4648 3.83398 15.4551 3.68945C16.1035 3.21484 16.6719 2.62695 17.125 1.9668Z" fill="#666666"/>
                                            </svg>
                                        </a>
                                    {/if}
                                    {if $facebook_link}
                                        <a class="bonslider-social-link" href="{$facebook_link|escape:'htmlall':'UTF-8'}">
                                            <svg width="9" height="15" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.16667 0.916665C9.16667 0.806159 9.12277 0.700178 9.04463 0.622038C8.96649 0.543898 8.86051 0.499999 8.75 0.499999H6.66667C5.6176 0.447741 4.5905 0.812825 3.80977 1.51548C3.02904 2.21814 2.55815 3.20125 2.5 4.25V6.5H0.416667C0.30616 6.5 0.200179 6.5439 0.122039 6.62204C0.0438988 6.70018 0 6.80616 0 6.91667V9.08333C0 9.19384 0.0438988 9.29982 0.122039 9.37796C0.200179 9.4561 0.30616 9.5 0.416667 9.5H2.5V15.0833C2.5 15.1938 2.5439 15.2998 2.62204 15.378C2.70018 15.4561 2.80616 15.5 2.91667 15.5H5.41667C5.52717 15.5 5.63315 15.4561 5.71129 15.378C5.78943 15.2998 5.83333 15.1938 5.83333 15.0833V9.5H8.01667C8.10932 9.50133 8.19978 9.47173 8.27374 9.41589C8.34769 9.36005 8.40092 9.28115 8.425 9.19167L9.025 7.025C9.04158 6.96343 9.04381 6.89889 9.03151 6.83632C9.01922 6.77376 8.99273 6.71486 8.95409 6.66414C8.91545 6.61343 8.86569 6.57226 8.80864 6.5438C8.75158 6.51534 8.68876 6.50036 8.625 6.5H5.83333V4.25C5.85406 4.04373 5.95093 3.85259 6.10502 3.71391C6.25911 3.57523 6.45936 3.49896 6.66667 3.5H8.75C8.86051 3.5 8.96649 3.4561 9.04463 3.37796C9.12277 3.29982 9.16667 3.19384 9.16667 3.08333V0.916665Z" fill="#666666"/>
                                            </svg>
                                        </a>
                                    {/if}
                                    {if $instagram_link}
                                        <a class="bonslider-social-link" href="{$instagram_link|escape:'htmlall':'UTF-8'}">
                                            <svg width="15" height="15" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.99997 3.99414C5.78317 3.99414 3.99411 5.7832 3.99411 8C3.99411 10.2168 5.78317 12.0059 7.99997 12.0059C10.2168 12.0059 12.0058 10.2168 12.0058 8C12.0058 5.7832 10.2168 3.99414 7.99997 3.99414ZM7.99997 10.6035C6.56638 10.6035 5.39645 9.43359 5.39645 8C5.39645 6.56641 6.56638 5.39648 7.99997 5.39648C9.43356 5.39648 10.6035 6.56641 10.6035 8C10.6035 9.43359 9.43356 10.6035 7.99997 10.6035ZM12.1699 2.89649C11.6523 2.89649 11.2343 3.31445 11.2343 3.83203C11.2343 4.34961 11.6523 4.76758 12.1699 4.76758C12.6875 4.76758 13.1054 4.35156 13.1054 3.83203C13.1056 3.70913 13.0815 3.58741 13.0345 3.47383C12.9876 3.36026 12.9187 3.25706 12.8318 3.17016C12.7449 3.08325 12.6417 3.01435 12.5281 2.96739C12.4145 2.92042 12.2928 2.89633 12.1699 2.89649ZM15.8086 8C15.8086 6.92188 15.8183 5.85352 15.7578 4.77734C15.6972 3.52734 15.4121 2.41797 14.498 1.50391C13.582 0.587892 12.4746 0.304689 11.2246 0.244142C10.1465 0.183595 9.07809 0.19336 8.00192 0.19336C6.9238 0.19336 5.85544 0.183595 4.77927 0.244142C3.52927 0.304689 2.41989 0.589845 1.50583 1.50391C0.589814 2.41992 0.306611 3.52734 0.246064 4.77734C0.185517 5.85547 0.195283 6.92383 0.195283 8C0.195283 9.07617 0.185517 10.1465 0.246064 11.2227C0.306611 12.4727 0.591767 13.582 1.50583 14.4961C2.42185 15.4121 3.52927 15.6953 4.77927 15.7559C5.85739 15.8164 6.92575 15.8066 8.00192 15.8066C9.08005 15.8066 10.1484 15.8164 11.2246 15.7559C12.4746 15.6953 13.584 15.4102 14.498 14.4961C15.414 13.5801 15.6972 12.4727 15.7578 11.2227C15.8203 10.1465 15.8086 9.07812 15.8086 8ZM14.0898 12.6055C13.9472 12.9609 13.7754 13.2266 13.5 13.5C13.2246 13.7754 12.9609 13.9473 12.6054 14.0898C11.5781 14.498 9.13864 14.4062 7.99997 14.4062C6.8613 14.4062 4.41989 14.498 3.39255 14.0918C3.03708 13.9492 2.77146 13.7773 2.49802 13.502C2.22263 13.2266 2.05075 12.9629 1.90817 12.6074C1.50192 11.5781 1.59372 9.13867 1.59372 8C1.59372 6.86133 1.50192 4.41992 1.90817 3.39258C2.05075 3.03711 2.22263 2.77149 2.49802 2.49805C2.77341 2.22461 3.03708 2.05078 3.39255 1.9082C4.41989 1.50195 6.8613 1.59375 7.99997 1.59375C9.13864 1.59375 11.58 1.50195 12.6074 1.9082C12.9629 2.05078 13.2285 2.22266 13.5019 2.49805C13.7773 2.77344 13.9492 3.03711 14.0918 3.39258C14.498 4.41992 14.4062 6.86133 14.4062 8C14.4062 9.13867 14.498 11.5781 14.0898 12.6055Z" fill="#666666"/>
                                            </svg>
                                        </a>
                                    {/if}
                                </div>
                            {/if}
                        </li>
                    {/if}
                {else}
                    {if !$swiper_device}
                        <li class="swiper-slide">
                            <div id="video-container" class="video-container">
                                <a class="link-bonslick" href="{$item.url|escape:'htmlall':'UTF-8'}">
                                    <video id="video-element" class="bonslick-video" loop="loop">
                                        <source src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}" type="video/mp4">
                                    </video>
                                    {if isset($item.subitems) && $item.subitems}
                                        <div class="bonslider-subitem">
                                            {foreach from=$item.subitems item=item name=item}
                                                <img class="{$item.title|escape:'htmlall':'UTF-8'} {$item.animation|escape:'htmlall':'UTF-8'}"
                                                     style="top:{$item.top|escape:'htmlall':'UTF-8'}%; right:{$item.right|escape:'htmlall':'UTF-8'}%; z-index:{$item.zindex|escape:'htmlall':'UTF-8'};animation-delay: {$item.animation_delay|escape:'htmlall':'UTF-8'}ms"
                                                     src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}"
                                                     alt="{$item.title|escape:'htmlall':'UTF-8'}" />
                                            {/foreach}
                                        </div>
                                    {/if}
                                    <section class="box-bonslick">
                                        {if isset($item.description) && $item.description}
                                            <div class="bonslider-item-description" data-swiper-parallax-scale="0.3" data-swiper-parallax-y="-60%" data-swiper-parallax-opacity="0" data-swiper-parallax-duration="800">
                                                {$item.description nofilter}
                                            </div>
                                        {/if}
                                    </section>
                                </a>
                                <div id="controls">
                                    <button id='btnPlayPause' class='play' accesskey="P" onclick='playPauseVideo();'></button>
                                    <button id='btnMute' class='mute' onclick='muteVolume();'></button>
                                </div>
                            </div>
                            {if $soc_title || $twitter_link || $facebook_link || $instagram_link}
                                <div class="bonslider-social">
                                    {if $soc_title}
                                        <p class="bonslider-social-title">{$soc_title|escape:'htmlall':'UTF-8'}</p>
                                    {/if}
                                    {if $twitter_link}
                                        <a class="bonslider-social-link" href="{$twitter_link|escape:'htmlall':'UTF-8'}">
                                            <svg width="16" height="13" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M17.125 1.9668C16.5273 2.22461 15.877 2.41016 15.207 2.48242C15.9026 2.06921 16.4234 1.41641 16.6719 0.646485C16.0192 1.03474 15.3042 1.307 14.5586 1.45117C14.247 1.11802 13.8701 0.852617 13.4514 0.671499C13.0327 0.490381 12.5812 0.39743 12.125 0.398438C10.2793 0.398438 8.79492 1.89453 8.79492 3.73047C8.79492 3.98828 8.82617 4.24609 8.87695 4.49414C6.11328 4.34961 3.64844 3.0293 2.00977 1.00781C1.71118 1.5178 1.55471 2.09849 1.55664 2.68945C1.55664 3.8457 2.14453 4.86523 3.04102 5.46484C2.5127 5.44404 1.99676 5.29882 1.53516 5.04102V5.08203C1.53516 6.70117 2.67969 8.04297 4.20508 8.35156C3.91867 8.42596 3.62404 8.46402 3.32812 8.46484C3.11133 8.46484 2.90625 8.44336 2.69922 8.41406C3.12109 9.73438 4.34961 10.6934 5.8125 10.7246C4.66797 11.6211 3.23437 12.1484 1.67773 12.1484C1.39844 12.1484 1.14062 12.1387 0.873047 12.1074C2.34961 13.0547 4.10156 13.6016 5.98828 13.6016C12.1133 13.6016 15.4648 8.52734 15.4648 4.12305C15.4648 3.97852 15.4648 3.83398 15.4551 3.68945C16.1035 3.21484 16.6719 2.62695 17.125 1.9668Z" fill="#666666"/>
                                            </svg>
                                        </a>
                                    {/if}
                                    {if $facebook_link}
                                        <a class="bonslider-social-link" href="{$facebook_link|escape:'htmlall':'UTF-8'}">
                                            <svg width="9" height="15" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.16667 0.916665C9.16667 0.806159 9.12277 0.700178 9.04463 0.622038C8.96649 0.543898 8.86051 0.499999 8.75 0.499999H6.66667C5.6176 0.447741 4.5905 0.812825 3.80977 1.51548C3.02904 2.21814 2.55815 3.20125 2.5 4.25V6.5H0.416667C0.30616 6.5 0.200179 6.5439 0.122039 6.62204C0.0438988 6.70018 0 6.80616 0 6.91667V9.08333C0 9.19384 0.0438988 9.29982 0.122039 9.37796C0.200179 9.4561 0.30616 9.5 0.416667 9.5H2.5V15.0833C2.5 15.1938 2.5439 15.2998 2.62204 15.378C2.70018 15.4561 2.80616 15.5 2.91667 15.5H5.41667C5.52717 15.5 5.63315 15.4561 5.71129 15.378C5.78943 15.2998 5.83333 15.1938 5.83333 15.0833V9.5H8.01667C8.10932 9.50133 8.19978 9.47173 8.27374 9.41589C8.34769 9.36005 8.40092 9.28115 8.425 9.19167L9.025 7.025C9.04158 6.96343 9.04381 6.89889 9.03151 6.83632C9.01922 6.77376 8.99273 6.71486 8.95409 6.66414C8.91545 6.61343 8.86569 6.57226 8.80864 6.5438C8.75158 6.51534 8.68876 6.50036 8.625 6.5H5.83333V4.25C5.85406 4.04373 5.95093 3.85259 6.10502 3.71391C6.25911 3.57523 6.45936 3.49896 6.66667 3.5H8.75C8.86051 3.5 8.96649 3.4561 9.04463 3.37796C9.12277 3.29982 9.16667 3.19384 9.16667 3.08333V0.916665Z" fill="#666666"/>
                                            </svg>
                                        </a>
                                    {/if}
                                    {if $instagram_link}
                                        <a class="bonslider-social-link" href="{$instagram_link|escape:'htmlall':'UTF-8'}">
                                            <svg width="15" height="15" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.99997 3.99414C5.78317 3.99414 3.99411 5.7832 3.99411 8C3.99411 10.2168 5.78317 12.0059 7.99997 12.0059C10.2168 12.0059 12.0058 10.2168 12.0058 8C12.0058 5.7832 10.2168 3.99414 7.99997 3.99414ZM7.99997 10.6035C6.56638 10.6035 5.39645 9.43359 5.39645 8C5.39645 6.56641 6.56638 5.39648 7.99997 5.39648C9.43356 5.39648 10.6035 6.56641 10.6035 8C10.6035 9.43359 9.43356 10.6035 7.99997 10.6035ZM12.1699 2.89649C11.6523 2.89649 11.2343 3.31445 11.2343 3.83203C11.2343 4.34961 11.6523 4.76758 12.1699 4.76758C12.6875 4.76758 13.1054 4.35156 13.1054 3.83203C13.1056 3.70913 13.0815 3.58741 13.0345 3.47383C12.9876 3.36026 12.9187 3.25706 12.8318 3.17016C12.7449 3.08325 12.6417 3.01435 12.5281 2.96739C12.4145 2.92042 12.2928 2.89633 12.1699 2.89649ZM15.8086 8C15.8086 6.92188 15.8183 5.85352 15.7578 4.77734C15.6972 3.52734 15.4121 2.41797 14.498 1.50391C13.582 0.587892 12.4746 0.304689 11.2246 0.244142C10.1465 0.183595 9.07809 0.19336 8.00192 0.19336C6.9238 0.19336 5.85544 0.183595 4.77927 0.244142C3.52927 0.304689 2.41989 0.589845 1.50583 1.50391C0.589814 2.41992 0.306611 3.52734 0.246064 4.77734C0.185517 5.85547 0.195283 6.92383 0.195283 8C0.195283 9.07617 0.185517 10.1465 0.246064 11.2227C0.306611 12.4727 0.591767 13.582 1.50583 14.4961C2.42185 15.4121 3.52927 15.6953 4.77927 15.7559C5.85739 15.8164 6.92575 15.8066 8.00192 15.8066C9.08005 15.8066 10.1484 15.8164 11.2246 15.7559C12.4746 15.6953 13.584 15.4102 14.498 14.4961C15.414 13.5801 15.6972 12.4727 15.7578 11.2227C15.8203 10.1465 15.8086 9.07812 15.8086 8ZM14.0898 12.6055C13.9472 12.9609 13.7754 13.2266 13.5 13.5C13.2246 13.7754 12.9609 13.9473 12.6054 14.0898C11.5781 14.498 9.13864 14.4062 7.99997 14.4062C6.8613 14.4062 4.41989 14.498 3.39255 14.0918C3.03708 13.9492 2.77146 13.7773 2.49802 13.502C2.22263 13.2266 2.05075 12.9629 1.90817 12.6074C1.50192 11.5781 1.59372 9.13867 1.59372 8C1.59372 6.86133 1.50192 4.41992 1.90817 3.39258C2.05075 3.03711 2.22263 2.77149 2.49802 2.49805C2.77341 2.22461 3.03708 2.05078 3.39255 1.9082C4.41989 1.50195 6.8613 1.59375 7.99997 1.59375C9.13864 1.59375 11.58 1.50195 12.6074 1.9082C12.9629 2.05078 13.2285 2.22266 13.5019 2.49805C13.7773 2.77344 13.9492 3.03711 14.0918 3.39258C14.498 4.41992 14.4062 6.86133 14.4062 8C14.4062 9.13867 14.498 11.5781 14.0898 12.6055Z" fill="#666666"/>
                                            </svg>
                                        </a>
                                    {/if}
                                </div>
                            {/if}
                        </li>
                    {/if}
                {/if}
            {/foreach}
        </ul>
        {if $nav}
            <div class="bonslider-button-next swiper-button-next"></div>
            <div class="bonslider-button-prev swiper-button-prev"></div>
        {/if}
        {if $dots}
            <div class="bonslider-pagination swiper-pagination">
            </div>
        {/if}
    </section>
{/if}