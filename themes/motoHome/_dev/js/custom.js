$(document).ready(function() {
    openMenuMobile();
    openSearchMobile();
    closeSearchMobile()
})

function openMenuMobile () {
    $('.burger-icon').on('click', ()=>{
        $('.burger-icon').toggleClass('active');
        $('.position-static.d-block #_desktop_top_menu').toggleClass('active')
    })
}


function openSearchMobile() {
    $('#search-mobile').on('click', ()=>{
        $('.d-block>.search-widget').addClass('active');
    })
}

function closeSearchMobile() {
    $('.seatch-widget-close').on('click', ()=>{
        $('.d-block>.search-widget').removeClass('active');
    })
}