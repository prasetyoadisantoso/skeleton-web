/* -------------------------------------------------------------------------- */
/*                            Sidebar Toggle Button                           */
/* -------------------------------------------------------------------------- */
$(document).ready(function () {
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
});

/* -------------------------------------------------------------------------- */
/*                             Dropdown Animation                             */
/* -------------------------------------------------------------------------- */
// Add slideDown animation to Bootstrap dropdown when expanding.
$('.dropdown').on('show.bs.dropdown', function () {
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
});

// Add slideUp animation to Bootstrap dropdown when collapsing.
$('.dropdown').on('hide.bs.dropdown', function () {
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
});
