
function isJson(item) {
    item = typeof item !== "string"
        ? JSON.stringify(item)
        : item;

    try {
        item = JSON.parse(item);
    } catch (e) {
        return false;
    }

    if (typeof item === "object" && item !== null) {
        return true;
    }

    return false;
}

var eventMethod = window.addEventListener
    ? "addEventListener"
    : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = eventMethod === "attachEvent"
    ? "onmessage"
    : "message";
eventer(messageEvent, function (e) {
    if(e.origin != "https://id.volamnhatpham.com" && e.origin != "http://id.volamnhatpham.com" && e.origin != "https://volamnhatpham.com" && e.origin != "http://volamnhatpham.com"){
        return;
    }
    if(!isJson(e.data)){
        return;
    }
    if(typeof e.data != 'string'){
        return;
    }
    var data = JSON.parse(e.data);
    if(data.action != undefined && data.action == 'openIframeId'){
        $('#iframe-id').attr('src', data.href);
        $('.nav').removeClass('showMenu');
        $('.swapmenu').removeClass('show');
    }else if(data.action != undefined && data.action == 'reloadIframe'){
        $('#iframe-menu-top').attr( 'src', function ( i, val ) { return val; });
        $('#iframe-menu-left').attr( 'src', function ( i, val ) { return val; });
    }else if(data.action != undefined && data.action == 'setHeightIframe' && data.target == 'iframe-menu-top'){
        $('#iframe-menu-top').height(data.height);
    }else if(data.action != undefined && data.action == 'setHeightIframe' && data.target == 'iframe-menu-left'){
        $('#iframe-menu-left').height(data.height);
    }else if(data.action != undefined && data.action == 'setHeightIframe' && data.target == 'iframe-id'){
        $('#iframe-id').height(data.height);
    }
    
});

$(document).ready(function(){
    // $('.download').click(function(){
    //     Swal.fire({
    //           title: 'Võ Lâm Chính Tông!',
    //           text: 'Bản cài đặt sẽ được công bố vào ngày 22/06)',
    //           confirmButtonText: 'OK'
    //     });
    //     return false;
    // });
});

function changeAlias(alias) {
    var str = alias;
    str = str.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a"); 
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e"); 
    str = str.replace(/ì|í|ị|ỉ|ĩ/g,"i"); 
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o"); 
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u"); 
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y"); 
    str = str.replace(/đ/g,"d");
    str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|\$|_|`|-|{|}|\||\\/g," ");
    str = str.replace(/ + /g," ");
    str = str.replace(/ /g,"-");
    str = str.trim(); 
    return str;
}

function setHeightDownload(){
    if($('body').width() < 768){
        return;
    }
    $('.download-main .package.package-mini .step').each(function(index){
        var height = $(this).height();
        $('.download-main .package.package-full .step:nth-child('+(parseInt(index)+1)+')').height(height);
    });
}
$(document).ready(function(){
    setHeightDownload();
    $( '.download-main img' ).on("load", function(){
        setHeightDownload();
    });
});

$.fn.dailyTask = function () {
    $(this).find('>a').click(function (e) {
        e.preventDefault()
        $(this).closest('ul').children().removeClass('active')
        $(this).closest('li').addClass('active')

        $('.daily .daily-content').find('>div').attr('style', '')
        $('.daily .daily-content').find(`.${$(this).data('day')}`).css('display', 'block')
    })
}

$.fn.mouseover = function () {
    $(this).on('mouseenter', function () {
        $(this).parent().find(`span.${this.classList.value}`).addClass('hover')
    })
    $(this).on('mouseleave', function () {
        $(this).parent().find(`span.${this.classList.value}`).removeClass('hover')
    })
}

$.fn.backtotop = function () {
    $(this).click(function (e) {
        e.preventDefault()
        $('html, body').animate({
            scrollTop: 0
        }, 1000)
    })
}

$.fn.swapMenu = function () {
    $(this).click(function (e) {
        e.preventDefault()
        if ($(this).hasClass('show')) {
            $(this).removeClass('show')
            $(this).parent().removeClass('showMenu')
        }
        else {
            $(this).addClass('show')
            $(this).parent().addClass('showMenu')
        }

    })
}

$(document).ready(function () {
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        margin: 10,
        loop: true,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
        }
    })

    if ($('.block-user-account .user-account').length) {
        $('.block-user-account .user-account').mouseover()
    }

    if ($('.content-right a.download').length) {
        $('.content-right a.download').mouseover()
    }

    if ($('.daily .tabs li').length) {
        $('.daily .tabs li').each(function () {
            $(this).dailyTask()
        })
    }
    if ($('#totop')) {
        $('#totop').backtotop()
    }
    if ($('.swapmenu').length) {
        $('.swapmenu').each(function () {
            $(this).swapMenu()
        })
    }
    $(".list-news .list").mCustomScrollbar();

    checkingTodayName();
});

function checkingTodayName() {
    var allDayOfTheWeek = 7;
    var sunday = 0;
    var datetimes = new Date();
    var weekdays = new Array(allDayOfTheWeek);
    var arrWeekday = [];
    $.each(weekdays, function(index) {
        if(index != sunday) {
            arrWeekday[index] = index++;
        } else {
            arrWeekday[index] = allDayOfTheWeek;
        }
    });
    var toDayName = arrWeekday[datetimes.getDay()];
    if($('.tabs-item').hasClass('day-name-' + toDayName)) {
        $('.day-name-' + toDayName).addClass('active');
    }
}