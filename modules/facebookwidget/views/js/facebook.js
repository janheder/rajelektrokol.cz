/**
 * 2015-2017 Bonpresta
 *
 * Bonpresta Facebook Like Box
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
 *  @copyright 2015-2017 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

document.addEventListener('DOMContentLoaded', function () {
        openFacebookMenu();
        function injectFbLikeBox(d, s, id) {
                var js,
                    fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.defer = !0;
                js.async = !0;
                js.src =
                    '//connect.facebook.net/' +
                    l_code +
                    '/sdk.js#xfbml=1&version=v2.10&appId=332803467148699';
                fjs.parentNode.insertBefore(js, fjs);
        }
        $('.fb_iframe_widget iframe').attr('loading', 'lazy');
        $(function () {
                const $facebookLikeButton = $('#facebook-menu-open');
                $facebookLikeButton.on('click', function () {
                        injectFbLikeBox(document, 'script', 'facebook-jssdk');
                });
        });
});
function openFacebookMenu() {
        clickFacebookBox();
        let customMenu = document.querySelector('.facebook-custom-menu');
        let customMenuButton = document.getElementById('facebook-menu-open');
        customMenuButton.addEventListener('click', function () {
                customMenu.classList.toggle('active');
                customMenuButton.classList.toggle('active');
        });
}

function clickFacebookBox() {
        jQuery(function ($) {
                $(document).mouseup(function (e) {
                        var div = $('#facebook-menu-open');
                        if (!div.is(e.target) && div.has(e.target).length === 0) {
                                $('#facebook-menu-open').removeClass('active');
                                $('.facebook-custom-menu').removeClass('active');
                        }
                });
        });
}
