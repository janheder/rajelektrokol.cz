/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

document.addEventListener('DOMContentLoaded', function () {
  subMenuWidth();
  menuHidden();
  mobileMenu();
});

window.addEventListener('resize', function () {
  setTimeout(() => {
    subMenuWidth();
  }, 300);
  mobileMenu();
});

function subMenuWidth() {
  let submenuColl = document.querySelectorAll('.popover');

  submenuColl.forEach((popover) => {
    let attribute = popover.getAttribute('bonmm-data-popup-width'),
    screenSize = popover.getAttribute('data-bonmm-mobile');
    
    if (window.innerWidth >= screenSize) {
        if (attribute == 'popup_container_width') {
          let popoverWidth = popover.closest('.container') != null ? popover.closest('.container').offsetWidth : '';
          if (
            popover.closest('.container') != null &&
            popover.closest('.bonmm-top-menu') != null
          ) {
            popover.style.width = popoverWidth + 'px';
            popover.style.left =
              popover.closest('.container').getBoundingClientRect().left -
              popover.closest('.bonmm-top-menu').getBoundingClientRect().left +
              'px';
          }
        }
    
        if (attribute == 'vertical') {
          let menuWidth = popover.closest('.bonmm-top-menu') != null ? popover.closest('.bonmm-top-menu').offsetWidth : '';
          let verticalHiiden = popover.closest('.vertical-hidden');
          if (popover.closest('.bonmm-top-menu') != null) {
            popover.style.width = window.innerWidth -  menuWidth - popover.closest('.bonmmenu').getBoundingClientRect().left - 30 + 'px';
            let bonmmTitle = document.querySelector('.bonmm-title');
            if (bonmmTitle != null && verticalHiiden == null) {
              popover.style.top = bonmmTitle.offsetHeight + 'px';
            }
          }
        }
    }
  });
}

function menuHidden() {
  let hiddenButton = document.getElementById('hidden-button');
  if (hiddenButton != null) {
    hiddenButton.onclick = function() {
      this.nextElementSibling.classList.toggle('active');
    };
  }
}

function mobileMenu() {
  let mobileMenuIcons = document.querySelectorAll('.bonmm-mobile');
  mobileMenuIcons.forEach((mobileMenuIcon) => {
    let id = mobileMenuIcon.getAttribute('data-id'),
    screenSize = mobileMenuIcon.getAttribute('data-bonmm-mobile'),
    menuContent = document.getElementById('top-menu-'+ id),
    desktopMenu = document.getElementById('desktop_bonmm_'+ id);
    // if (window.innerWidth >= screenSize) {
    if (document.body.offsetWidth >= screenSize) {
      desktopMenu.appendChild(menuContent);
    } else {
      mobileMenuIcon.appendChild(menuContent);
    }
    
    let mobileMenuButton = mobileMenuIcon.querySelector('.bonmm-mobile-button');
    openMobileMenu(mobileMenuButton);
  })
}

function openMobileMenu(mobileMenuIcon) {
  if (mobileMenuIcon != null) {
    mobileMenuIcon.onclick = function() {
      this.nextElementSibling.classList.toggle('active');
    };
  }
}

let bonmmMobileMenu = document.querySelector(".bonmm-mobile")

if (window.innerWidth <= bonmmMobileMenu.dataset.bonmmMobile) {
  $('.bonmm-top-menu .dropdown-item.nav-arrows span.float-xs-right').on('click', function (event) {
    event.preventDefault();
  });
}