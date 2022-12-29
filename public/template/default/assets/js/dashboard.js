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

// Rotation Arrow Sidebar
rotated = false;
$('.main-list').click(function (e) {
    e.preventDefault();
    elem = document.querySelector('.fa-chevron-down');

    $({ rotation: 180 * rotated }).animate({ rotation: 180 * !rotated }, {
        duration: 50,
        step: function (now) {
            $(elem).css({ 'transform': 'rotate(' + now + 'deg)' });
        }
    });
    rotated = !rotated;
});
