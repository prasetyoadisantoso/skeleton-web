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
$(document).ready(function () {
    jQuery(".main-list").click(function () {
        var child = document.getElementById(this.id);
        var icon = child.children['icon'];
        let open = $(icon).hasClass('open');
        if (open) {
            icon.className = 'fa fa-chevron-down';
        } else {
            icon.className = 'fa fa-chevron-down open';
        }
    });
});
