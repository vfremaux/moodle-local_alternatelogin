// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

// jshint undef:false, unused:false, scripturl:true

/**
 * Javascript controller for controlling the sections.
 *
 * @module     local_advancedperfs/perfs_panel
 * @package    local_advancedperfs
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['jquery', 'core/config', 'core/log'], function($, cfg, log) {

    var alternatelogin = {

        init: function() {
            $('.alternate-profile-choice').bind('click', this.togglechoice);
            $('#back-step-1').bind('click', this.switchtopanel1);
            $('#next-step-2').bind('click', this.switchtopanel2);
            $('#next-step-3').bind('click', this.send);
            $('.field-cpy-check input').bind('keyup', this.checkfieldcopy);
            $('input.field-non-empty-input').bind('keyup', this.checknonempty);
            $('select.field-non-empty-input').bind('change', this.checknonempty);
            $('#id-field-authcode-input').bind('change', this.checkauthcode);

            $('.field-cpy-check input').trigger('keyup');
            $('input.field-non-empty-input').trigger('keyup');
            $('select.field-non-empty-input').trigger('change');
            $('#readmore').trigger('open');

            // Profile field choices cannot be checked by trigger.
            alternatelogin.updatebutton3state();

            log.debug('AMD alternate login initialized');
        },

        togglechoice: function() {
            var that = $(this);

            var matches = that.attr('id').match(/pv-choice-btn-(\d+)-(\d+)/);
            var thatid = matches[1];
            $('.alternate-profile-choice').removeClass('selected');
            $('.alternate-profile-field').val('');
            that.addClass('selected');
            $('#pv-' + thatid).val(that.attr('data-value'));
            $('#pv-' + thatid).removeClass('unchecked');

            alternatelogin.updatebutton3state();
        },

        checknonempty: function() {
            var that = $(this);
            if (that.val() !== '') {
                that.removeClass('unchecked');
            } else {
                that.addClass('unchecked');
            }
            alternatelogin.updatebutton2state();
            alternatelogin.updatebutton3state();
        },

        checkauthcode: function() {

            var that = $(this);

            var url = cfg.wwwroot + '/local/alternatelogin/ajax/service.php';
            url += '?what=checkcode';
            url += '&code=' + that.val();

            $.get(url, function(data) {
                if (data.result === 1) {
                    $('#id-field-authcode-field').removeClass('error');
                } else {
                    $('#id-field-authcode-field').addClass('error');
                }
            }, 'json');
        },

        switchtopanel2: function() {
            $('#sign-up-panel-1').addClass('hidden');
            $('#sign-up-panel-2').removeClass('hidden');
        },

        switchtopanel1: function() {
            $('#sign-up-panel-1').removeClass('hidden');
            $('#sign-up-panel-2').addClass('hidden');
        },

        send: function() {
            $('form[name=signup-form]').submit();
        },

        checkfieldcopy: function() {
            var that = $(this);

            var baseelmname = that.attr('name').replace('confirm', '');
            var confirmelmname = baseelmname + 'confirm';
            var val1 = $('input[name=' + baseelmname + ']').val();
            var val2 = $('input[name=' + confirmelmname + ']').val();

            var src = $('#' + baseelmname + '-field-cpy-check img').attr('src');
            if ((val1 === val2) && (val1 !== '')) {
                $('.' + baseelmname + '-field-cpy-check img').attr('src', src.replace(/\bnook$/, 'ok'));
                $('.' + baseelmname + '-field-cpy-check img').attr('src', src.replace(/\bnook$/, 'ok'));
                $('.' + baseelmname + '-field-cpy-check').removeClass('unchecked');
            } else {
                $('.' + baseelmname + '-field-cpy-check img').attr('src', src.replace(/\bok$/, '/nook'));
                $('.' + baseelmname + '-field-cpy-check img').attr('src', src.replace(/\bok$/, '=nook'));
                $('.' + baseelmname + '-field-cpy-check').addClass('unchecked');
            }
            alternatelogin.updatebutton2state();
        },

        updatebutton2state: function() {
            if ($('#sign-up-panel-1 .unchecked').length === 0) {
                $('#next-step-2').prop('disabled', false);
            } else {
                $('#next-step-2').prop('disabled', true);
            }
        },

        updatebutton3state: function() {
            if ($('#sign-up-panel-2 .unchecked').length === 0) {
                $('#next-step-3').prop('disabled', false);
            } else {
                $('#next-step-3').prop('disabled', true);
            }
        }
    };

    return alternatelogin;
});