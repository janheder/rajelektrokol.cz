/**
 * 2015-2022 Bonpresta
 *
 * Bonpresta Instagram Gallery Feed Photos & Videos User
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
 *  @copyright 2015-2022 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */
$(document).ready(function () {
	if (typeof(variable) != "undefined" && !+BONINSTAGRAM_DISPLAY_CAROUSEL) {
		heightSlide();
		window.addEventListener('resize', function(event) {
			heightSlide();
		});
	}
	function heightSlide() {
		let slideHeight = $('#boninstagram .instagram-item').width();

		$('#boninstagram .instagram-item').css('height', slideHeight + 'px');
	}
});
