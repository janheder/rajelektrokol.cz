{*
* 2015-2020 Bonpresta
*
* Bonpresta Product Discounts with Countdown
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

<script type="text/javascript">
       var countdown_days = "{l s='days' mod='productcountdown' js=1}",
           countdown_hr = "{l s='hr' mod='productcountdown' js=1}",
           countdown_min = "{l s='min' mod='productcountdown' js=1}",
           countdown_sec = "{l s='sec' mod='productcountdown' js=1}";

       productCountdownScript();

       $('.bon-scroll-button-wrapper').on('click', function () {
           setTimeout(function () {
               productCountdownScript();
           }, 1200);
       });

       function productCountdownScript() {
           if ($("[data-countdown]")) {
               $("[data-countdown]").each(function() {
                   var $this = $(this),
                       finalDate = $(this).data("countdown");
                   $this.countdown(finalDate, function(event) {
                       $this.html(event.strftime('<span><span>%D</span>' + countdown_days + '</span><span><span>%H</span>' + countdown_hr + '</span><span><span>%M</span>' + countdown_min + '</span><span><span>%S</span>' + countdown_sec + '</span>'));
                   });
               });
           }
       }
</script>