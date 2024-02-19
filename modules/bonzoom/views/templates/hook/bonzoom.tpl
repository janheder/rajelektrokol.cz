{*
* 2015-2020 Bonpresta
*
* Bonpresta Product Images Zoom
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

{if isset($zoom_display) && $zoom_display}
    <script>
        var zoom_type = "{$zoom_type|escape:'htmlall':'UTF-8'}",
        zoom_lens_size  = "{$zoom_lens_size|escape:'htmlall':'UTF-8'}",
        zoom_cursor_type = "{$zoom_cursor_type|escape:'htmlall':'UTF-8'}",
        zoom_lens_opacity = "{$zoom_lens_opacity|escape:'htmlall':'UTF-8'}",
        zoom_scroll = "{$zoom_scroll|escape:'htmlall':'UTF-8'}",
        zoom_easing = "{$zoom_easing|escape:'htmlall':'UTF-8'}",
        zoom_fade_in = "{$zoom_fade_in|escape:'htmlall':'UTF-8'}",
        zoom_fade_out = "{$zoom_fade_out|escape:'htmlall':'UTF-8'}",
        zoom_lens_shape = "{$zoom_lens_shape|escape:'htmlall':'UTF-8'}",
        zoom_win_width = "{$zoom_win_width|escape:'htmlall':'UTF-8'}",
        zoom_win_height = "{$zoom_win_height|escape:'htmlall':'UTF-8'}",
        zoom_win_border = "{$zoom_win_border|escape:'htmlall':'UTF-8'}";
        zoom_win_border_color = "{$zoom_win_border_color|escape:'htmlall':'UTF-8'}";
    
        function applyElevateZoom() {
            var src = $('.thickbox.shown').attr('href'),
                bigimage = $('.fancybox.shown').attr('href');
            $('#bigpic').elevateZoom({
                zoomType: zoom_type,
                cursor: zoom_cursor_type,
                zoomWindowFadeIn: zoom_fade_in,
                zoomWindowFadeOut: zoom_fade_out,
                scrollZoom: zoom_scroll,
                easing: zoom_easing,
                lensOpacity: zoom_lens_opacity,
                lensShape: zoom_lens_shape,
                lensSize: zoom_lens_size,
                zoomImage: bigimage,
                zoomWindowWidth: zoom_win_width,
                zoomWindowHeight: zoom_win_height,
                borderSize: zoom_win_border,
                borderColour: zoom_win_border_color,
            });
        }
    
        $(document).ready(function() {
            applyElevateZoom();
            $('#color_to_pick_list').click(
                function() {
                    restartElevateZoom();
                }
            );
    
            $('#color_to_pick_list').hover(
                function() {
                    restartElevateZoom();
                }
            );
    
    
            $('#views_block li a').hover(
                function() {
                    restartElevateZoom();
                }
            );
    
            $(document).on('click', '.attribute_radio', function() {
                restartElevateZoom();
            });
    
            $(document).on('change', '.attribute_select', function() {
                restartElevateZoom();
            });
        });
    
        function restartElevateZoom() {
            $(".zoomContainer").remove();
            applyElevateZoom();
        }
    </script>
{/if}