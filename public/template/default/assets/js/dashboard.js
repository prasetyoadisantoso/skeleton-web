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
    var div = document.getElementsByClassName('main-list');
    var open = false;
    for (var i = 0; i < div.length; i++) {
        (function (index) {
            div[index].addEventListener("click", function (e) {
                let child_id = this.id;
                var child = document.getElementById(child_id);
                var icon = child.children['icon'];
                if (open) {
                    icon.className = 'fa fa-chevron-down';
                } else {
                    icon.className = 'fa fa-chevron-down open';
                }
                open = !open;
            })
        })(i);
    }
});
