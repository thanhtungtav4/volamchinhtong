
function setHeightIframeId(){
    var postMessageData = {
        'action': 'setHeightIframe',
        'target': 'iframe-id',
        'height': document.body.offsetHeight,
    };
    parent.postMessage(JSON.stringify(postMessageData), MAINSITE);
}

function setHeightIframeMenuLeft(){
    var postMessageData = {
        'action': 'setHeightIframe',
        'target': 'iframe-menu-left',
        'height': document.body.offsetHeight,
    };
    parent.postMessage(JSON.stringify(postMessageData), MAINSITE);
}
function setHeightIframeMenuTop(){
    var postMessageData = {
        'action': 'setHeightIframe',
        'target': 'iframe-menu-top',
        'height': document.body.offsetHeight,
    };
    parent.postMessage(JSON.stringify(postMessageData), MAINSITE);
}
function reloadIframeId(){
    var postMessageData = {
        'action': 'reloadIframe',
    };
    parent.postMessage(JSON.stringify(postMessageData), MAINSITE);
}

$(document).ready(function(){

    $('.open-iframe').on({
        "contextmenu": function(e) {
            e.preventDefault();
        }
    });

    $('.open-iframe').click(function(){
        var href = $(this).attr('href');
        var postMessageData = {
            'action': 'openIframeId',
            'href': href,
        };
        parent.postMessage(JSON.stringify(postMessageData), MAINSITE);
        return false;
    });

    $('.selected-item').click(function(){
        var tthis = $(this);
        var status = tthis.data('status');
        if(status == 'disable'){
            return false;
        }
        $('.selected-item').removeClass('active');
        tthis.addClass('active');
        tthis.find('input[name="cardType"]').prop('checked', true);

        var cardType = $("input[name='cardType']:checked").val();
        if(cardType == 'VT' || cardType == 'VINA' || cardType == 'MOBI'){
            $('.amount-card-mobi').show();
            setHeightIframeId();
        }else{
            $('.amount-card-mobi').hide();
        }

        return false;
    });

    $('.form-payment').submit(function(){
        var cardType = $('input[name="cardType"]:checked').val();
        var amount = parseInt($('select[name="amount"]').val());
        if(!cardType){
            Swal.fire({
              title: 'Warning!',
              text: 'Vui lòng chọn loại thẻ cào',
              type: 'error',
              confirmButtonText: 'Đồng ý'
            });
            return false;
        }
        if( (cardType == 'VT' || cardType == 'VINA' || cardType == 'MOBI') && amount <= 0){
            Swal.fire({
              title: 'Warning!',
              text: 'Vui lòng chọn mệnh giá thẻ cào',
              type: 'error',
              confirmButtonText: 'Đồng ý'
            });
            return false;
        }


    });

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    var max = $(".reservation-limit").attr('data-date-limit');
    if(!max){
        max = 15;
    }
    $(".reservation-limit").daterangepicker({
        "autoApply":true, 
        "locale":{"format":"YYYY-MM-DD"},
        "dateLimit": {"days": max},
        "maxDate": formatDate(Date())
    });


});