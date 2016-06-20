/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * @copyright     Copyright (c) SCHENCK Simon
 *
 */

$(document).ready(function(){
	
	
	$('.hideaway').on('click','.hideaway-btn',function(event){
		event.stopPropagation();
		var me = $(event.delegateTarget);
		var display = me.children('section').css('display');
		var list = me.parent('.hideaway-list');
		if(list.attr('class')){
			list.children('.hideaway').children('section').css('display','none');
		}
		if(display=='none'){
			me.children('section').css('display','inline-block');
		}else{
			me.children('section').css('display','none');
		}
	});

	$.fn.formToObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

	$('.flash-message').on('click',function(event){
		$(this).remove();
	});

    $.fn.initForm = function() {
		$('.flash-message').on('click',function(event){
			$(this).remove();
		});
    	
    	$('.field-input,.field-textarea').each(function(){
			if($(this).val() != ''){
				$(this).parent().addClass('field-completed');
			}
		});

		$('.field').on('focus','.field-input,.field-textarea',function(event){
			var me = $(event.delegateTarget);
			me.addClass('field-focus field-completed');
		});

		$('.field').on('blur','.field-input,.field-textarea',function(event){
			var me = $(event.delegateTarget);

			var valid = this.checkValidity()
			if( ($(this).val() == '') && valid){
				me.removeClass('field-completed');
			}
			if(!valid){
				me.addClass('not-valid');
				me.append('<span class="valid-message">'+this.validationMessage+'</span>');
			}else{
				me.removeClass('not-valid');
				me.find('.valid-message').remove();
			}
			me.removeClass('field-focus');
		});
	}
	$(document).initForm();
});
