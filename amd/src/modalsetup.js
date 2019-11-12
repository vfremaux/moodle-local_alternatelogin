

define(['jquery', 'core/log'], function($, log) {

    var modalsetup = {
        init: function() {
            $('#alternate-modal-open').bind('click', this.showmodal);
            $('#alternate-modal-close').bind('click', this.closemodal);
            $('#alternate-modal-close').bind('keydown', modalsetup.loopmodal);
            log.debug('AMD Alternate login Modal info initialized');
        },

        showmodal: function() {
            $('footer, .navbar, .login-forms').attr('aria-hidden', true);
            $('input').attr('disabled', true);
            $('#alternate-modal-container').css('display', 'flex');
            $('body').css('overflow', 'hidden');
            $('#welcome-dialog-title').focus();
            $('#alternate-modal-container').bind('keydown', modalsetup.checkout);
        },

        closemodal: function() {
            $('footer, .navbar, .login-forms').attr('aria-hidden', false);
            $('input').attr('disabled', null);
            $('#alternate-modal-container').css('display', 'none');
            $('body').css('overflow', 'visible');
            $('#alternate-modal-open').focus();
            $('#alternate-modal-container').off('keydown');
        },

        checkout: function(e) {
            if (e.keyCode == 27) {
                modalsetup.closemodal();
            }
        },

        loopmodal: function(e) {
            if (e.keyCode == 9) {
                // Tab
                $('#welcome-dialog-title').focus();
            }
        }
    };

    return modalsetup;
});