{*
 * 2015-2017 Bonpresta
 *
 * Bonpresta Online Chat Zendesk
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
*}

<!--Start of Zendesk Chat Script-->

<!--End of Zendesk Chat Script-->


<script>
    function injectZendesk(d, s) {
        var js,
            fjs = d.getElementsByTagName(s)[0];
        js = d.createElement(s);
        js.async = true;
        js.defer = true;
        js.id = "ze-snippet";
        js.src = 'https://static.zdassets.com/ekr/snippet.js?key={$zendesk_id|escape:'htmlall':'UTF-8'}';
        fjs.parentNode.insertBefore(js, fjs);
    }
    setTimeout(() => {
        injectZendesk(document, 'script');
    }, 7000);
</script>