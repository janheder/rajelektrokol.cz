/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Call
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
 * @author    Bonpresta
 * @copyright 2015-2021 Bonpresta
 * @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */
document.addEventListener("DOMContentLoaded", function () {
  openBonCallMenu();
  clickBonCall();
});
function openBonCallMenu() {
    $('#btn-boncall .boncall-open').on('click', function () {
        $('.boncall-wrapper').toggleClass('active');
        $('.boncall-open').toggleClass('active');
    });
}

$(function () {
  $(".boncall_form").on("submit", function () {
    $.ajax({
      type: "POST",
      url:
        bon_call_url + "?ajax=1&static_token_bon_call=" + static_token_bon_call,
      async: true,
      dataType: "json",
      data: $(this).serialize(),
      success: function (data) {
        let bonSuccess = $(".bon-call-success");

        if (data["success"] === 1) {
          bonSuccess.html(data.alert);
          bonSuccess.removeClass("alert alert-danger");
          bonSuccess.addClass("alert alert-success");
          $("#btn-boncall .submit").hide();
          $(".bon-call-success.success").prev(
            $(".or , .bon_call_box").hide(300)
          );
        } else {
          bonSuccess.html(data.error);
          bonSuccess.addClass("alert alert-danger");
        }
      },
    });
    return false;
  });
});

function clickBonCall() {
  jQuery(function ($) {
    $(document).mouseup(function (e) {
      var div = $("#btn-boncall");
      if (!div.is(e.target) &&
          div.has(e.target).length === 0) {
        $('.boncall-open').removeClass('active');
        $('.boncall-wrapper').removeClass('active');
      }
    });
  });
}