$(document).ready(function () {
    $('.profile-ajax>#form_popup').on("click", function (e) {
        e.preventDefault();
        $('#popup').fadeIn(1000);
    })
    $('#closePopup').on("click", function (e) {
        e.preventDefault();
        $('#popup').fadeOut(1000);
    })
})
