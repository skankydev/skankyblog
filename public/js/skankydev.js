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

	$.fn.colorSelect = function(op){
		var o = {
			outPut:function(val){
				console.log("output");
			},
			name: "color-select"
		}
		if(op){$.extend(true,o,op)};
		if (typeof o.colorPalettes == 'undefined') {
			o.colorPalettes = ['black','gray','green','red','blue'];
		}

		var toHtml   = '<div class="color-select-master"><span> </span>';
		toHtml      += '<div class="color-select"><span> </span><div class="color-input">';
		var classCss = 'color-select-input'
		for(var i=0;i<o.colorPalettes.length;i++){
			toHtml +='<input type="radio" name="'+o.name+'"  value="'+o.colorPalettes[i]+'" class="'+classCss+' '+classCss+'-'+o.colorPalettes[i]+'" id="'+classCss+'-'+o.colorPalettes[i]+'" data="'+o.colorPalettes[i]+'"><label class="color-label" for="'+classCss+'-'+o.colorPalettes[i]+'"> </label>';
		}
		toHtml +='</div></div></div>';
		$(this).html(toHtml);
		$(this).find('input').each(function(k){
			var color = $(this).attr('data');
			$(this).next().css("background",color);
			$(this).hide();
		});
		$(this).find('.color-input').hide();
		var laspan = $(this).find('span');

		$(this).click(function(e){
			if($(this).find('.color-input').css('display') == 'none'){
				$(this).find('.color-input').fadeIn(200);
			}else{
				$(this).find('.color-input').fadeOut(200);
			}
		});
		$(this).mouseleave(function(e){
			$(this).find('.color-input').fadeOut(200);
		});
		$(this).on('change','input',function(e){
			laspan.css("background",$(this).val());
			o.outPut($(this).val())
		});
	}


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
