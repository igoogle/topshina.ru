$(document).ready(function(){
	new DG.OnOffSwitchAuto({
		cls:'.bx_filter input[type=checkbox]',
		textOn:"",
		height:18,
		heightTrack:14,
		textOff:"",
		trackColorOff:"f5f5f5",
		listener:function(name, checked){
			ID = $(this)[0].inputEl.attr('id');
			$('#' + ID).closest('.bx_filter_parameters_box_container').find('label').click();
		}
	});
	
	$(document).on('click', '.top_filter_block.type_item .filter_close', function(){
		if(window.matchMedia('(min-width: 800px)').matches){
			var _this = $(this),
				parentBlock = _this.closest('.top_filter_block');

			if(!parentBlock.hasClass('closed')){
				parentBlock.addClass('closed');
				parentBlock.animate({width: 50}, 300).find('form').hide();
				
				$.cookie('HIDE_FILTER_SHOPS', 'Y', {path: arTires2Options['SITE_DIR'], expires: 365});
				
				/*parentBlock.find('.bx_filter_parameters_box_container input[type=checkbox]').each(function(){
					if(!$(this).prop('checked')){
						$(this).prop('checked', true);
						$(this).closest('.bx_filter_parameters_box_container').find('.on-off-switch-track>div').css('left', '-1px');
						$(this).closest('.bx_filter_parameters_box_container').find('.on-off-switch-thumb').css('left', '18px');
					}
				}).promise().done(function(){
					BX.ajax({
						url: location.href,
						method: 'POST',
						data: parentBlock.find('form').serialize(),
						dataType: 'html',
						processData: false,
						start: true,
						headers: [{'name': 'X-Requested-With', 'value': 'XMLHttpRequest'}],
						onfailure: function(data) {
							console.log(data);
							alert('Error connecting server');
						},
						onsuccess: function(html){
							var ob = BX.processHTML(html);

							// inject
							$('.js_wrapper')[0].innerHTML = ob.HTML;
							BX.ajax.processScripts(ob.SCRIPT);
						}
					});
				});*/
			}
			else{
				$.cookie('HIDE_FILTER_SHOPS', null, {path: arTires2Options['SITE_DIR']});
				parentBlock.find('form').show();
				parentBlock.removeClass('closed');
				
				var filterWidth = 0;
							
				filterWidth += parseInt(parentBlock.css('padding-left'));
				filterWidth += parseInt(parentBlock.css('padding-right'));
				
				parentBlock.find('.bx_filter_parameters_box_container').each(function(){
					filterWidth += $(this).outerWidth();
				}).promise().done(function(){
					parentBlock.animate({width: filterWidth}, 300);
				});
			}
		}
	});
});