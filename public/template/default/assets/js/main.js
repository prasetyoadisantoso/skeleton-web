// Prev & Next Button
let count = 1;
$("#next").click(function (e) {
    e.preventDefault();
    count++;
    if (count < 6) {
        document.getElementById("page_" + count).scrollIntoView({ behavior: 'smooth', block: 'center' });
        scrollLine.style.width = '0px';
    } else {
        count = 5;
    }
});

$("#prev").click(function (e) {
    e.preventDefault();
    count--;
    if (count > 0) {
        document.getElementById("page_" + count).scrollIntoView({ behavior: 'smooth', block: 'center' });
        scrollLine.style.width = '0px';
    } else {
        count = 1;
    }
});

// Vertical Scroll
const container = document.querySelector('.containerize');
let scrollLine = document.querySelector('.scroll');

if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    container.addEventListener("touchstart", touchStart, false,);
    container.addEventListener("touchmove", touchMove, false);

    var start = { x: 0, y: 0 };

    function touchStart(event) {
        start.x = event.touches[0].pageX;
        start.y = event.touches[0].pageY;
    }

    function touchMove(event) {
        offset = {};

        offset.x = start.x - event.touches[0].pageX;
        offset.y = start.y - event.touches[0].pageY;

        container.scrollLeft += offset.x / 4;

        scrollLine.style.width = container.scrollLeft / 4 + 'px';

    }
} else {
    container.addEventListener('wheel', (e) => {
        e.preventDefault();
        container.scrollLeft += e.deltaY;
        scrollLine.style.width = container.scrollLeft / 4 + 'px';
    })
}

// FAB
$('#zoomBtn').click(function () {
    $('.zoom-btn-sm').toggleClass('scale-out');
    if (!$('.zoom-card').hasClass('scale-out')) {
        $('.zoom-card').toggleClass('scale-out');
    }
});

$('.zoom-btn-sm').click(function () {
    var btn = $(this);
    var card = $('.zoom-card');

    if ($('.zoom-card').hasClass('scale-out')) {
        $('.zoom-card').toggleClass('scale-out');
    }
    if (btn.hasClass('zoom-btn')) {
        card.css('background-color', '#ffffff');
    } else {
        card.css('background-color', '#7b1fa2');
    }
});

// Tween Animation
function init() {
    var stage = new createjs.Stage("demoCanvas");
    var circle = new createjs.Shape();
    var circle_magenta = new createjs.Shape();
    var circle_dark = new createjs.Shape();
    var circle_green = new createjs.Shape();
    var circle_blue = new createjs.Shape();
    circle.graphics.beginFill(createjs.Graphics.getRGB(249, 50, 44)).drawCircle(0, 0, 100);
    circle_magenta.graphics.beginFill(createjs.Graphics.getRGB(214, 51, 132)).drawCircle(0, 0, 50);
    circle_dark.graphics.beginFill(createjs.Graphics.getRGB(52, 58, 64)).drawCircle(0, 0, 60);
    circle_green.graphics.beginFill(createjs.Graphics.getRGB(25, 135, 84)).drawCircle(0, 0, 40);
    circle_blue.graphics.beginFill(createjs.Graphics.getRGB(13, 110, 253)).drawCircle(0, 0, 30);
    circle.x = 100;
    circle.y = 150;
    circle_magenta.x = 100;
    circle_magenta.y = 100;
    circle_dark.x = 300;
    circle_dark.y = 350;
    circle_green.x = 300;
    circle_green.y = 400;
    circle_blue.x = 300;
    circle_blue.y = 400;
    stage.addChild(circle);
    stage.addChild(circle_magenta);
    stage.addChild(circle_dark);
    stage.addChild(circle_green);
    stage.addChild(circle_blue);
    createjs.Tween.get(circle, { loop: true })
        .to({ y: 350 }, 1000, createjs.Ease.getPowInOut(2))
        .to({ y: 150 }, 800, createjs.Ease.getPowInOut(2));
    createjs.Tween.get(circle_magenta, { loop: true })
        .to({ x: 450 }, 1000, createjs.Ease.getPowInOut(4))
        .to({ alpha: 0, y: 100 }, 500, createjs.Ease.getPowInOut(2))
        .to({ alpha: 0, y: 100 }, 100)
        .to({ alpha: 1, y: 100 }, 500, createjs.Ease.getPowInOut(2))
        .to({ x: 100 }, 800, createjs.Ease.getPowInOut(2));
    createjs.Tween.get(circle_dark, { loop: true })
        .to({ y: 200 }, 1000, createjs.Ease.getPowInOut(4))
        .to({ alpha: 0, y: 100 }, 500, createjs.Ease.getPowInOut(2))
        .to({ alpha: 0, y: 100 }, 100)
        .to({ alpha: 1, y: 100 }, 500, createjs.Ease.getPowInOut(2))
        .to({ y: 300 }, 800, createjs.Ease.getPowInOut(2));
    createjs.Tween.get(circle_green, { loop: true })
        .to({ y: 100 }, 1000, createjs.Ease.getPowInOut(2))
        .to({ y: 400 }, 800, createjs.Ease.getPowInOut(2))
        ;
    createjs.Tween.get(circle_blue, { loop: true })
        .to({ x: 150 }, 1000, createjs.Ease.getPowInOut(2))
        .to({ x: 300 }, 800, createjs.Ease.getPowInOut(2))
        ;
    createjs.Ticker.setFPS(60);
    createjs.Ticker.addEventListener("tick", stage);
}

// Auto Hover Collapse
$(".feature-1-icon").hover(
    function (e) {
        e.preventDefault();
        $('.feature-1-collapse').collapse('show');
    }, function (e) {
        e.preventDefault();
        $('.feature-1-collapse').collapse('hide');
    }
);

$(".feature-2-icon").hover(
    function (e) {
        e.preventDefault();
        $('.feature-2-collapse').collapse('show');
    }, function (e) {
        e.preventDefault();
        $('.feature-2-collapse').collapse('hide');
    }
);

$(".feature-3-icon").hover(
    function (e) {
        e.preventDefault();
        $('.feature-3-collapse').collapse('show');
    }, function (e) {
        e.preventDefault();
        $('.feature-3-collapse').collapse('hide');
    }
);

// Rotation Arrow Sidebar
rotated = false;
$('#zoomBtn').click(function (e) {
    e.preventDefault();
    elem = document.querySelector('.fa-angles-left');

    $({ rotation: 180 * rotated }).animate({ rotation: 180 * !rotated }, {
        duration: 250,
        step: function (now) {
            $(elem).css({ 'transform': 'rotate(' + now + 'deg)' });
        }
    });
    rotated = !rotated;
});

// Preloader
window.addEventListener("load", function () {
    if (!sessionStorage.viewed){
        const loader = document.querySelector(".preloader");
        loader.className += " loader-hidden";
        sessionStorage.viewed = 1;
    }else{
      const loader = document.querySelector(".preloader");
      const imaging = document.querySelector(".rotate");
      loader.className += " loader-hidden-fast";
      imaging.className += " rotate-hidden";
    }
});
