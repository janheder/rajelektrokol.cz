/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Portfolio with Masonry Effect
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
 *  @copyright 2015-2021 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

// window.onload = function () {
//
// };
function myFunc() {
  let msnry = new Masonry('.bonportfolio-items', {
    itemSelector: '.bonportfolio-item',
    gutter: 20
  });
  revealOnScroll();
  $('.bonportfolio-main .row').css('opacity', '1');
};
$(document).ready(function () {
  animatePortfolio();
  // video items

  let video_portfolio = $('#bonportfolio-video-element');

  function playVideo() {
    video_portfolio.get(0).play();
  }

  setTimeout(() => {myFunc();}, 3000);

  function pauseVideo() {
    video_portfolio.get(0).pause();
  }


  $('#bonportfolio-video').on('shown.bs.modal', function () {
    playVideo();
  });
  $('#bonportfolio-video').on('hide.bs.modal', function () {
    pauseVideo();
  });


  // tabs

  $(function () {
    let tab = $('.bonportfolio-item-title');

    tab.on('click', function () {
      let self = $(this);

      let link = $(this).attr('data-category');

      let items = $(this)
        .parent()
        .parent()
        .children('.row')
        .children('.bonportfolio-items');

      items.each(function () {
        if ($(this).attr('data-category') == link) {
          $(this).css('display', 'block');
          tab.removeClass('active');
          self.addClass('active');

          var $grid = $('.bonportfolio-items');
          $grid.masonry({ itemSelector: '.bonportfolio-item', gutter: 20 });
          $grid.masonry('destroy');
          $grid.masonry({ itemSelector: '.bonportfolio-item', gutter: 20 });

          let count = 1;
          $('.bonportfolio-item').each(function () {
            $(this).attr('data-timeout', count * 10);
            count++;
          });

          revealOnScroll();
        } else {
          $(this).css('display', 'none');
          tab.remove('active');
        }
      });
    });
  });
});

// animation

function animatePortfolio() {
  let $window = $(window);
  $('.revealOnScroll').addClass('animated');
  $window.on('scroll', revealOnScroll);
  let count = 1;
  $('.bonportfolio-item').each(function () {
    $(this).attr('data-timeout', count * 10);
    count++;
  });
}

function revealOnScroll() {
  let $window = $(window);
  let scrolled = $window.scrollTop(),
    win_height_padded = $window.height() * 1.1;
  $('.revealOnScroll:not(.animated)').each(function () {
    let $this = $(this),
      offsetTop = $this.offset().top;
    if (scrolled + win_height_padded > offsetTop) {
      if ($this.data('timeout')) {
        window.setTimeout(function () {
          $this.addClass('animated ' + $this.data('animation'));
        }, parseInt($this.data('timeout'), 10));
      } else {
        $this.addClass('animated ' + $this.data('animation'));
      }
    }
  });
  $('.revealOnScroll.animated').each(function () {
    let $this = $(this),
      offsetTop = $this.offset().top;
    if (scrolled + win_height_padded < offsetTop) {
      $(this).removeClass('fadeInUp');
    }
  });
}
