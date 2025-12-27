(function() {
    "use strict";

    document.addEventListener('DOMContentLoaded', function() {

        document.addEventListener('click', function(event) {
            // Handle .ww-whatsapp-button clicks
            const whatsappButton = event.target.closest('.ww-whatsapp-button');
            if (whatsappButton) {
                const FBAction = whatsappButton.getAttribute('fb-pixel');
                if (typeof fbq !== 'undefined' && FBAction) {
                    if (FBAction !== 'noevent') {
                        fbq('track', FBAction, {});
                    }
                }
            }

            // Handle #contact-trigger clicks
            if (event.target.closest('#contact-trigger')) {
                const containers = document.querySelectorAll('.ww-container');
                containers.forEach(container => {
                    container.classList.toggle('open');
                });
            }

            // Handle .close-chat clicks
            if (event.target.closest('.close-chat')) {
                const containers = document.querySelectorAll('.ww-container');
                containers.forEach(container => {
                    container.classList.remove('open');
                });
            }
        });

        function twResponsive() {
            const buttons = document.querySelectorAll('.ww-container.ww-std .ww-whatsapp-button');
            buttons.forEach(function(button) {
                const width = button.offsetWidth;
                if (width <= 200) {
                    button.classList.add('smallScreen');
                } else {
                    button.classList.remove('smallScreen');
                }
            });
        }

        window.addEventListener('load', twResponsive);
        window.addEventListener('resize', twResponsive);

        function ForNumbers(evt) {
            const charCode = (evt.which) ? evt.which : evt.keyCode;

            if (
                // 0~9
                (charCode >= 48 && charCode <= 57) ||
                // number pad 0~9
                (charCode >= 96 && charCode <= 105) ||
                // backspace
                charCode === 8 ||
                // tab
                charCode === 9 ||
                // enter
                charCode === 13 ||
                // left, right, delete..
                (charCode >= 35 && charCode <= 46)
            ) {
                // make sure the new value below 100
                const newValue = parseInt(this.value + String.fromCharCode(charCode), 10);
                if (newValue <= 100) {
                    return true;
                }
            }

            evt.preventDefault();
            evt.stopPropagation();

            return false;
        }

        const viewInputs = document.querySelectorAll('input.input-views');
        viewInputs.forEach(function(input) {
            input.addEventListener('keypress', ForNumbers);
        });
    });
})();

import.meta.glob(['../images/**', '../midia/**']);
