import jQuery from 'jquery';

(function($) {
    "use strict";
    jQuery(document).ready(function($) {
        $(document).on('click', '.ww-whatsapp-button', function() {
            var FBAction = $(this).attr('fb-pixel');
            if ( typeof fbq !== 'undefined' && FBAction ) {
                if( FBAction != 'noevent' ){
                    fbq('track', FBAction, {});
                }
            }
        });

        $(document).click(function(event) {
            if($(event.target).closest('#contact-trigger').length) {
                $('.ww-container').toggleClass('open');
            }
        });

        function twResponsive() {
            $('.ww-container.ww-std .ww-wa-button').each(function() {
                var $this = $(this),
                    width = $this.outerWidth();

                if (width <= 200) {
                    $this.addClass('smallScreen');
                } else {
                    $this.removeClass('smallScreen');
                }
            })
        }

        $(window).on('load', function() {
            twResponsive();
        });
        $(window).on('resize', function() {
            twResponsive();
        });

        $(document).click(function(x) {
            if($(x.target).closest('.close-chat').length) {
                $('.ww-container').removeClass('open');
            }
        });

        function ForNumbers(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode;

            if (
                //0~9
                charCode >= 48 && charCode <= 57 ||
                //number pad 0~9
                charCode >= 96 && charCode <= 105 ||
                //backspace
                charCode == 8 ||
                //tab
                charCode == 9 ||
                //enter
                charCode == 13 ||
                //left, right, delete..
                charCode >= 35 && charCode <= 46
            )
            {
                //make sure the new value below 20
                if(parseInt(this.value+String.fromCharCode(charCode), 10) <= 100)
                    return true;
            }

            evt.preventDefault();
            evt.stopPropagation();

            return false;
        }

        $('input.input-views').each(function() {
            var $this = $(this);
            $this.on('keypress', ForNumbers, false);

            console.log('anu mas')
        })

        if( jQuery('.ww-whatsapp-content').length > 0 || jQuery('.ww-std').length > 0 ){
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://get.geojs.io/v1/ip/geo.js?callback=ww_whatsapp_callback';
            var h = document.getElementsByTagName('script')[0];
            h.parentNode.insertBefore(script, h);
        }
    });
})(jQuery);

function ww_whatsapp_callback(data){
    "use strict";
    var geo = data;

    var agents = [];
    var numbers = [];
    if( jQuery('.ww-whatsapp-button').length > 0 ){
        jQuery.each( jQuery('.ww-whatsapp-button'), function(key, button){
            agents.push( jQuery(button).attr('data-agent') );
            numbers.push( jQuery(button).attr('data-number') );
        });

        const rot_data = "agent="+agents+"&number="+numbers+"&geo="+JSON.stringify(geo)+"&type=view&ref="+window.location.href;

        jQuery.ajax({
            async: true,
            url: ww_whatsapp_chat,
            type: 'POST',
            data: rot_data,
        });
    }
    else if( jQuery('.ww-wa-button').length > 0 ){
        jQuery.each( jQuery('.ww-wa-button'), function(key, button){
            agents.push( jQuery(button).attr('data-agent') );
            numbers.push( jQuery(button).attr('data-number') );
        });

        const rot_data = "agent="+agents+"&number="+numbers+"&geo="+JSON.stringify(geo)+"&type=view&ref="+window.location.href;

        jQuery.ajax({
            async: true,
            url: ww_whatsapp_chat,
            type: 'POST',
            data: rot_data,
        });
    }
}

window.ww_whatsapp_callback = ww_whatsapp_callback;

import.meta.glob(['../images/**', '../midia/**']);
