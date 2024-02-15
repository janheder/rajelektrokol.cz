/**
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

document.addEventListener("DOMContentLoaded", aboutAccordion);

function aboutAccordion() {
  let $video = $(".about-us-img-video");
  let $poster = $('.about-us-img-poster')
  $video.on("mouseover", show);
  $video.on("mouseleave", hide);
  delitePoster();

  function show() {
    $(this).attr("controls", "");
  }

  function hide() {
    let isPlaying = false;
    if (!$(".about-us-img-video").get(0).paused) {
      isPlaying = true;
    }
    if (!isPlaying) {
      $(this).removeAttr("controls");
    }
  }

  function delitePoster() {
    $video.click(function () {
      if ($video.pause) {
        $poster.show()
      } else {
        $poster.hide()
      }
    });
  }
  $(function () {
    let Accordion = function (el, multiple) {
      this.el = el || {};
      this.multiple = multiple || false;
      let links = this.el.find('.link');
      links.on('click', {
        el: this.el,
        multiple: this.multiple
      }, this.dropdown)
    }
    Accordion.prototype.dropdown = function (e) {
      let $el = e.data.el,
        $this = $(this),
        $next = $this.next();
      $next.slideToggle();
      $this.parent().toggleClass('open');
      if (!e.data.multiple) {
        $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
      };
    }
    let accordion = new Accordion($('#accordion'), false);
  });
  $('.about-us-social').append('<ul><li class="facebook"><a href="#" target="_blank"><i class="fl-outicons-facebook7"></i></a></li><li class="twitter"><a href="" target="_blank"><i class="fl-outicons-twitter4"></i></a></li><li class="youtube"><a href="#" target="_blank"><i class="fl-outicons-user189"></i></a></li></ul>')
}