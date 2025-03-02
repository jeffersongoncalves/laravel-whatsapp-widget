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
        })
    });
})(jQuery);

import.meta.glob(['../images/**', '../midia/**']);
