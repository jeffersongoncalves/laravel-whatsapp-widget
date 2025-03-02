var time = Math.floor(Math.random() * (3000 - 2000)) + 2000; // random time from 2-3 second
var geo = {};

function whatsapp_callback(data) {
    geo = data;

    const datas = ww_whatsapp_chat_data+"&geo=" + JSON.stringify(geo);

    fetch(ww_whatsapp_chat, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
        },
        body: datas,
    });
}

var script = document.createElement('script');
script.type = 'text/javascript';
script.src = 'https://get.geojs.io/v1/ip/geo.js?callback=whatsapp_callback';
var h = document.getElementsByTagName('script')[0];
h.parentNode.insertBefore(script, h);

setTimeout(function () {
    window.location.replace(ww_whatsapp_chat_redirect);
}, time);

window.whatsapp_callback = whatsapp_callback;

import.meta.glob(['../images/**', '../midia/**']);
