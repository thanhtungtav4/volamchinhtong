var widthWidgetLogin  = 583;
var heightWidgetLogin = 577;
var leftWidgetLogin   = widthWidgetLogin/2;
var topWidgetLogin    = heightWidgetLogin/2 + heightWidgetLogin/5;

var iframe_destroy = function(){
    $('.iframe_open_container').remove();
}
var iframe_open = function (url, styles) {
    iframe_destroy();
    var cont = $('<div class="iframe_open_container" style="z-index:9999;background: transparent;top: 0;left: 0;width: 100%;height: 100%;position: fixed;background: rgba(0, 0, 0, 0.75);" onclick="iframe_destroy()"></div>');

    var ifr = $('<iframe border=0 style="border:0;overflow: hidden;position: fixed;left: calc(50% - '+leftWidgetLogin+'px);top: calc(50% - '+topWidgetLogin+'px);width:'+widthWidgetLogin+'px;height: '+heightWidgetLogin+'px"/>');
    ifr.attr('src', url);
    $(ifr).addClass('iframe_open');
    if (typeof styles == 'object') {
        Object.keys(styles).forEach(function(key) {
            $(ifr).css(key, styles[key]);
        });
    }
    $(ifr).appendTo(cont);
    $(cont).appendTo('body');
}
function widget_login() {
    var task = this.getAttribute('data-task');
    
    var _url="https://volamchinhtong.com/id/widget?redirect-top=1";
    if (task) {
        _url = _url + "&task="+task;
    }
    var href = this.getAttribute('data-href');
    if (href == null) {
        href = this.href;
    }
    _url = _url + "&redirect="+encodeURIComponent(href);
    iframe_open(_url);
    return !1;
}