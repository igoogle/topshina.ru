$(document).ready(function(){	
	$(".bx_filter_title.title").click( function(e){
		$(this).siblings().removeClass('active');
		$(this).toggleClass('active');
		initSelects(document);
	});

	setTimeout(function(){
		$('.front_filter_wrap').addClass('load');
	}, 100);
	
	$(document).on('click', '.front_filter_wrap .title_block .dropdown .item', function(){
		var _this = $(this),
			iblockID = _this.data('iblock_id'),
			templateParams = _this.closest('.front_filter_wrap').data('params'),
			templateName = _this.closest('.front_filter_wrap').data('template'),
			type = _this.data('type'),
			filterURL = _this.data('filter_url');
									
		if(!_this.hasClass('active')){
			$('.front_filter_wrap.tires').removeClass('load');
			
			setTimeout(function(){
				$.ajax({
					url: arTires2Options['SITE_DIR']+'ajax/main_tires.php',
					type: 'POST',
					data: {IBLOCK_ID: iblockID, TEMPLATE_PARAMS: templateParams, TEMPLATE_NAME: templateName, FILTER_URL: filterURL, TYPE: type},
					success: function(html){
						_this.closest('.item_tires').html(html);
						setTimeout(function(){
							$('.front_filter_wrap.tires').addClass('load');
						}, 0);
					},
				});
			}, 300);
		}
	});
	
	$(document).on('click', '.front_filter_wrap .title_block .link_item', function(){
		var _this = $(this);
		
		if(!_this.hasClass('active')){
			var dataFilter = _this.data('filter');
			
			_this.closest('.title_block').find('.link_item').removeClass('active');
			_this.closest('.title_block').find('.link_item[data-filter='+dataFilter+']').addClass('active');
	
			if(dataFilter == 'params'){
				_this.closest('.front_filter_wrap').find('.bx_filter_parameters_box.tyresind').removeClass('active');
				_this.closest('.front_filter_wrap').find('.tyres_params').addClass('active');
				_this.closest('.front_filter_wrap').find('input[type=submit]').show();
				_this.closest('.front_filter_wrap').find('.all_hint').show();
			}
			else if(dataFilter == 'avto'){
				_this.closest('.front_filter_wrap').find('.bx_filter_parameters_box.tyresind').addClass('active');
				_this.closest('.front_filter_wrap').find('.tyres_params').removeClass('active');
				_this.closest('.front_filter_wrap').find('input[type=submit]').hide();
				_this.closest('.front_filter_wrap').find('.all_hint').hide();
			}
			
			initSelects(document);
		}
	});
	
	$(document).on('click', '.bx_filter_search_reset_main', function(){
		var selectBlock = $(this).closest('.bx_filter').find('.bx_filter_select_block');
		selectBlock.each(function(){
			var input = $(this).find('input').first(),
				propertyID = $(this).closest('.bx_filter_parameters_box').data('property_id');

			$('#smartFilterDropDown'+propertyID+' ul li').first().find('label').click();
			$('#smartFilterDropDown'+propertyID).hide();
		});

		$(this).closest('.bx_filter').find('input[type=checkbox]').each(function(){
			var _this = $(this);
			
			if(_this.prop('checked') === true){
				_this.find('+label').click();
			}
		});
		
		$(this).closest('.bx_filter').find('.ik_select').each(function(){
			var value = $(this).find('option').first().val();
			$(this).find('select').ikSelect('select', [value]);
		});
		
		if($(this).closest('.front_filter_wrap.tires').length){
			$('.block_all_results .tyres_result').html('');
		}
		if($(this).closest('.front_filter_wrap.wheels').length){
			$('.block_all_results .wheels_result').html('');
		}
		
		if($('.block_all_results .tyres_result').html() == '' && $('.block_all_results .wheels_result').html() == ''){
			$('#filter_result').removeClass('showen');
		}
	});

	$(".hint .icon").click(function(e){
		e.stopPropagation();
		var tooltipWrapp = $(this).parents(".hint");
		var bActive = tooltipWrapp.is('.active');
		$('.bx_filter .hint.active').removeClass("active").find(".tooltip").slideUp(200);
		if(!bActive){
			tooltipWrapp.addClass("active").find(".tooltip").slideDown(200);
			tooltipWrapp.find(".tooltip_close").click(function(e) { e.stopPropagation(); tooltipWrapp.removeClass("active").find(".tooltip").slideUp(200);});
		}
	});
	$(document).click(function(e) {
		if(!$(e.target).hasClass('tooltip')){
			$('.bx_filter .hint.active').removeClass("active").find(".tooltip").slideUp(200);
		}
	});
})

function JCSmartFilter(ajaxURL, viewMode, params)
{
	this.ajaxURL = ajaxURL;
	this.form = null;
	this.timer = null;
	this.cacheKey = '';
	this.cache = [];
	this.dblclick = false;
	this.set_filter = '';
	this.viewMode = viewMode;
	this.showModef = false;
	this.ajaxMode = false;
	this.reset = false;

	if (params && params.SEF_SET_FILTER_URL)
	{
		this.bindUrlToButton('set_filter', params.SEF_SET_FILTER_URL);
		this.sef = true;
	}
	if (params && params.SEF_DEL_FILTER_URL)
	{
		this.bindUrlToButton('del_filter', params.SEF_DEL_FILTER_URL);
	}

	if (params && params.AJAX_FILTER)
	{
		this.ajaxMode = true;
	}
}

JCSmartFilter.prototype.keyup = function(input)
{
	if(!!this.timer)
	{
		clearTimeout(this.timer);
	}
	if(!$(input).hasClass('disabled')){
		this.timer = setTimeout(BX.delegate(function(){
			this.reload(input);
		}, this), 500);
	}
};

JCSmartFilter.prototype.click = function(checkbox, dblclick, set_filter)
{
	if(!!this.timer)
	{
		clearTimeout(this.timer);
	}


	this.dblclick = (typeof dblclick != "undefined" && dblclick);
	this.set_filter = set_filter;

	if(this.dblclick)
	{
		this.set_filter.disabled = true;
	}

	this.timer = setTimeout(BX.delegate(function(){
		this.reload(checkbox, dblclick);
	}, this), 500);
};

JCSmartFilter.prototype.reload = function(input, dblclick)
{
	if (this.cacheKey !== '')
	{
		//Postprone backend query
		if(!!this.timer)
		{
			clearTimeout(this.timer);
		}
		this.timer = setTimeout(BX.delegate(function(){
			this.reload(input, dblclick);
		}, this), 1000);
		return;
	}
	this.cacheKey = '|';

	var isSelecBox  = false;
	isSelecBox = $(input).closest('.bx_filter_select_container').length;

	this.position_input = 0;

	this.label_input = $('label[data-role=label_'+$(input).attr('name').replace("all_", "")+']');
	if(isSelecBox)
	{
		this.label_input = $(input).closest('.bx_filter_select_container');
	}
	if(this.label_input.length)
	{
		this.position_input = this.label_input.offset().top - this.label_input.height() / 2;
		if(this.label_input.hasClass('nab')){
			this.position_input += 7;
		}
		if(isSelecBox)
		{
			this.position_input += 10;
		}
	}

	this.position = BX.pos(input, true);
	this.form = BX.findParent(input, {'tag':'form'});
	if (this.form)
	{
		var values = [];
		values[0] = {name: 'ajax', value: 'y'};
		this.gatherInputsValues(values, BX.findChildren(this.form, {'tag': new RegExp('^(input|select)$', 'i')}, true));

		for (var i = 0; i < values.length; i++)
			this.cacheKey += values[i].name + ':' + values[i].value + '|';

		if (this.cache[this.cacheKey])
		{
			this.curFilterinput = input;
			this.postHandler(this.cache[this.cacheKey], true);
		}
		else
		{
			if (this.sef)
			{
				var set_filter = $('[name=set_filter]');
				set_filter.disabled = true;
			}

			this.curFilterinput = input;
			BX.ajax.loadJSON(
				this.ajaxURL,
				this.values2post(values),
				BX.delegate(this.postHandler, this)
			);
		}
	}
};

JCSmartFilter.prototype.reloadAllForm = function()
{
	this.form = $('form.smartfilter')[0];

	if (this.form)
	{
		var values = [];
		values[0] = {name: 'ajax', value: 'y'};
		this.gatherInputsValues(values, BX.findChildren(this.form, {'tag': new RegExp('^(input|select)$', 'i')}, true));
		this.showModef = false;
		BX.ajax.loadJSON(
			this.ajaxURL,
			this.values2post(values),
			BX.delegate(this.postHandler, this)
		);
	}
}

JCSmartFilter.prototype.updateItem = function (PID, arItem, reset)
{
	if (arItem.PROPERTY_TYPE === 'N' || arItem.PRICE)
	{
		var trackBar = window['trackBar' + PID];
		if (!trackBar && arItem.ENCODED_ID)
			trackBar = window['trackBar' + arItem.ENCODED_ID];

		if (trackBar && arItem.VALUES)
		{
			if (arItem.VALUES.MIN)
			{
				if (arItem.VALUES.MIN.FILTERED_VALUE)
					trackBar.setMinFilteredValue(arItem.VALUES.MIN.FILTERED_VALUE);
				else
					trackBar.setMinFilteredValue(arItem.VALUES.MIN.VALUE);
			}

			if (arItem.VALUES.MAX)
			{
				if (arItem.VALUES.MAX.FILTERED_VALUE)
					trackBar.setMaxFilteredValue(arItem.VALUES.MAX.FILTERED_VALUE);
				else
					trackBar.setMaxFilteredValue(arItem.VALUES.MAX.VALUE);
			}
			if(reset=="Y"){
				trackBar.leftPercent=trackBar.rightPercent=0;
				$("#"+arItem.VALUES.MIN.CONTROL_ID).val('');
				$("#"+arItem.VALUES.MAX.CONTROL_ID).val('');
				$("#left_slider_"+arItem.ID).css({'left':"0%"});
				$("#colorUnavailableActive_"+arItem.ID).css({'left':"0%", 'right' : "0%"});
				$("#colorAvailableInactive_"+arItem.ID).css({'left':"0%", 'right' : "0%"});
				$("#colorAvailableActive_"+arItem.ID).css({'left':"0%", 'right' : "0%"});
				$("#right_slider_"+arItem.ID).css({'right':"0%"});
			}
		}
	}
	else if (arItem.VALUES)
	{
		for (var i in arItem.VALUES)
		{
			if (arItem.VALUES.hasOwnProperty(i))
			{
				var value = arItem.VALUES[i];
				var control = BX(value.CONTROL_ID);
				if (!!control)
				{
					var label = document.querySelector('[data-role="label_'+value.CONTROL_ID+'"]');
						input = document.querySelector('[id="'+value.CONTROL_ID+'"]');
					if (value.DISABLED)
					{
						var labelFor = $(label).attr('for');

						if (label && labelFor.indexOf('all_') === -1){
							BX.addClass(label, 'disabled');
							if(input){
								input.setAttribute('disabled','disabled');
								BX.addClass(input, 'disabled');
							}
							if($(label).closest('.bx_filter_select_popup').length){
								$(label).parent().hide();
							}
						}else if(labelFor.indexOf('all_') === -1){
							BX.addClass(control.parentNode, 'disabled');							
						}
					}
					else
					{
						if (label){
							BX.removeClass(label, 'disabled');
							if($(label).closest('.bx_filter_select_popup').length){
								$(label).parent().show();
							}
							if(input){
								input.removeAttribute('disabled');
								BX.removeClass(input, 'disabled');
							}
						}else
							BX.removeClass(control.parentNode, 'disabled');
					}

					if(reset=="Y"){
						if($(control).attr("type")=="checkbox" || $(control).attr("type")=="radio"){
							if($(control).attr("checked")){
								$(control).prop('checked',false);
								// input.removeAttribute('checked');
							}
						}
					}

					if (value.hasOwnProperty('ELEMENT_COUNT'))
					{
						label = document.querySelector('[data-role="count_'+value.CONTROL_ID+'"]');
						if (label)
							label.innerHTML = value.ELEMENT_COUNT;
					}
				}
			}
		}
	}
};

JCSmartFilter.prototype.postHandlerAjax = function (result, fromCache)
{
	$('#content').html(result);
}

JCSmartFilter.prototype.filterCatalog = function (url, set_disabled)
{
	if( window.History.enabled || window.history.pushState != null ){
		window.History.pushState( null, document.title, url );
	}else{
		location.href = url;
	}

	// this.setUrlSortDisplay(url);

	jsAjaxUtil.ShowLocalWaitWindow( 'id', 'wait_loader_container', true );
	$.ajax({
		url:url,
		type: "GET",
		data: {'ajax_get':'Y', 'ajax_get_filter':'Y'},
		success: function(html){
			if($('.middle > .container .js_wrapper_block .js_top_block').length && $('.middle > .container .js_wrapper_block .js_bottom_block').length)
			{
				$('.middle > .container .js_wrapper_block .js_top_block').html($(html).find('.js_top_block').html());
				$('.middle > .container .js_wrapper_block .js_bottom_block').html($(html).find('.js_bottom_block').html());
			}
			else if($('.middle > .container .middle').length)
			{
				$('.middle > .container .middle').html(html);
			}
			else
			{
				$('.middle > .container').html(html);
			}

			$('.catalog_block').ready(function()
			{
				touchItemBlock('.catalog_item a');
				$('.catalog_block').equalize({children: '.catalog_item .cost', reset: true});
				$('.catalog_block').equalize({children: '.catalog_item .item-title', reset: true});
				$('.catalog_block').equalize({children: '.catalog_item .counter_block', reset: true});
				$('.catalog_block').equalize({children: '.catalog_item .item_info', reset: true});
				$('.catalog_block').equalize({children: '.catalog_item_wrapp', reset: true});
			});

			$('.sections_wrapper .items .item').sliceHeight({'fixWidth':1});
			$('.fast_view_frame').remove();

			var ob = BX.processHTML(html);
			// inject
			BX.ajax.processScripts(ob.SCRIPT);

			setStatusButton();
			BX.onCustomEvent('onAjaxSuccessFilter');

			if(set_disabled=="Y"){
				var set_filter = BX('set_filter'),
					reset_filter = BX('del_filter');
				set_filter.disabled = false;
				reset_filter.disabled = false;
			}
			// $('.countdown').countdown('destroy');
			initCountdown();

			if($('.loadings.bg').length)
				$('.loadings.bg').removeClass('loadings bg');

			jsAjaxUtil.CloseLocalWaitWindow( 'id', 'wait_loader_container' );
		}
	})
}

JCSmartFilter.prototype.postHandler = function (result, fromCache)
{
	var hrefFILTER, url, curProp;
	var modef = $('[data-id=modef]');
	var modef_mobile = BX('modef_mobile');
	var modef_num = BX('modef_num');
	var modef_num_mobile = BX('modef_num_mobile');
	var reset="N";

	if ('RESET_FORM' in result){
		document.getElementById("smartfilter").reset();
		reset="Y";
	}

	if (!!result && !!result.ITEMS)
	{
		reset = this.reset;
		for(var PID in result.ITEMS)
		{
			if (result.ITEMS.hasOwnProperty(PID))
			{
				this.updateItem(PID, result.ITEMS[PID], reset);
			}
		}

		if(reset=="Y" || this.reset == "Y"){
			if($(".bx_filter_select_block").length){
				$(".bx_filter_select_block").each(function(){
					var id=$(this).closest('.bx_filter_parameters_box').attr('property_id'),
						all_text=$(this).find('.bx_filter_select_popup li:first-child label').text();
					$(this).find('.bx_filter_select_text').text(all_text);
					$(this).find('.bx_filter_select_popup li label').removeClass('selected');
				})
			}
			if($(".wrapp_slider.iblock").length)
			{
				$(".bx_filter_select_block").each(function()
				{
					var id=$(this).closest('.bx_filter_parameters_box').attr('property_id'),
						all_text=$(this).find('.input_wr_all input:first-child').data('title');
					$(this).find('.bx_filter_select_text').text(all_text);
					$(this).find('.bx_filter_select_popup li label').removeClass('selected');
				})
			}
		}

		if (!!modef && !!modef_num)
		{
			if(this.position_input)
				$('#modef').css({'top':this.position_input - $(".smartfilter").offset().top})
			else
				$('#modef').css({'top':'auto'})

			//modef_num.innerHTML = result.ELEMENT_COUNT;
			//modef_num_mobile.innerHTML = result.ELEMENT_COUNT;
			hrefFILTER = BX.findChildren(modef, {tag: 'A'}, true);
			hrefFILTER_mobile = BX.findChildren(modef_mobile, {tag: 'A'}, true);

			if (result.FILTER_URL && hrefFILTER)
			{
				hrefFILTER[0].href = BX.util.htmlspecialcharsback(result.FILTER_URL.replace('/filter/clear/apply/', '/'));
				hrefFILTER[0].href = BX.util.htmlspecialcharsback(result.FILTER_URL.replace('/filter/clear/', '/'));
				hrefFILTER[0].href = BX.util.htmlspecialcharsback(result.FILTER_URL.replace('/search/clear/', '/'));
				hrefFILTER[0].href = BX.util.htmlspecialcharsback(result.FILTER_URL.replace('/search/clear/apply', '/'));
				hrefFILTER_mobile[0].href = BX.util.htmlspecialcharsback(result.FILTER_URL.replace('/filter/clear/apply/', '/'));
			}

			if (result.FILTER_AJAX_URL && result.COMPONENT_CONTAINER_ID)
			{
				BX.unbindAll(hrefFILTER[0]);
				BX.unbindAll(hrefFILTER_mobile[0]);
				BX.bind(hrefFILTER[0], 'click', function(e)
				{
					url = BX.util.htmlspecialcharsback(result.FILTER_AJAX_URL);
					BX.ajax.insertToNode(url, result.COMPONENT_CONTAINER_ID);
					return BX.PreventDefault(e);
				});
			}

			if (result.INSTANT_RELOAD && result.COMPONENT_CONTAINER_ID)
			{
				url = BX.util.htmlspecialcharsback(result.FILTER_AJAX_URL);
				BX.ajax.insertToNode(url, result.COMPONENT_CONTAINER_ID);
			}
			else
			{
				if(this.ajaxMode)
				{
					/*ajax update filter catalog items start*/
					url = BX.util.htmlspecialcharsback(result.FILTER_AJAX_URL);
					if(reset == "Y")
					{
						var data = [];
						if(url.indexOf('?') !== -1)
						{
							var arTmpUrl = url.split('?'),
								pair = arTmpUrl[1].split('&');
								
							for(var i = 0; i < pair.length; i ++)
							{
								var param = pair[i].split('=');
								data[param[0]] = param[1];
							}
							if(pair)
							{
								if('car' in data)
									delete data['car'];
								if('model' in data)
									delete data['model'];
								if('year' in data)
									delete data['year'];
								if('modification' in data)
									delete data['modification'];
								if('tyre_type' in data)
									delete data['tyre_type'];
								if('type_filter' in data)
									delete data['type_filter'];
							}
							if(data)
							{
								var str = '';
								for (var p in data)
									str += '&'+p+'='+data[p]

								url = arTmpUrl[0]+'?'+str.substr(1)
							}
						}

					}

					this.filterCatalog(url, "N");

					/*ajax update filter catalog items end*/

					if (result.SEF_SET_FILTER_URL)
					{
						this.bindUrlToButton('set_filter', result.SEF_SET_FILTER_URL);
					}else{
						this.bindUrlToButton('set_filter', url);
					}
				}
				else
				{
					/*if (modef.style.display === 'none')
					{
						if(this.showModef)
							modef.style.display = 'inline-block';
						modef_mobile.style.display = 'inline-block';
					}*/
					if (this.viewMode == "vertical" && this.showModef)
					{
						curProp = BX.findChild(BX.findParent(this.curFilterinput, {'class':'bx_filter_parameters_box'}), {'class':'bx_filter_container_modef'}, true, false);
						//curProp.appendChild(modef);
					}

					if (result.SEF_SET_FILTER_URL)
					{
						this.bindUrlToButton('name=[set_filter]', result.SEF_SET_FILTER_URL);
						if(this.dblclick)
						{
							var filter_urls = "";
							filter_urls = BX.util.htmlspecialcharsback(result.SEF_SET_FILTER_URL.replace('/filter/clear/apply/', '/'));
							filter_urls = BX.util.htmlspecialcharsback(result.SEF_SET_FILTER_URL.replace('/filter/clear/', '/'));
							filter_urls = BX.util.htmlspecialcharsback(result.SEF_SET_FILTER_URL.replace('search/clear/apply', 'search'));
							filter_urls = BX.util.htmlspecialcharsback(result.SEF_SET_FILTER_URL.replace('search/clear', 'search'));

							this.set_filter.disabled = false;
							window.location.href = filter_urls
						}
					}
					else if(result.FILTER_URL)
					{
						this.bindUrlToButton('name=[set_filter]', result.FILTER_URL);
						if(this.dblclick)
						{
							this.set_filter.disabled = false;
							window.location.href = result.FILTER_URL.replace(/&amp;/g, '&')
						}
					}
				}
			}
		}
	}

	if (this.sef)
	{
		var set_filter = BX('set_filter');
		if(set_filter)
			set_filter.disabled = false;
	}

	if (!fromCache && this.cacheKey !== '')
	{
		this.cache[this.cacheKey] = result;
	}
	this.cacheKey = '';
};

JCSmartFilter.prototype.bindUrlToButton = function (buttonId, url)
{
	var button = BX(buttonId);
	
	if (button)
	{
		var proxy = function(j, func)
		{
			return function()
			{
				return func(j);
			}
		};

		if (button.type == 'submit')
			button.type = 'button';

		$(button).data("href", url);

		BX.unbindAll(button);

		// BX.bind(button, 'click', proxy(this, function(this){
		BX.bind(button, 'click', BX.proxy(function(){
			var url_filter=$(button).data('href'),
				id=$(button).attr('id');
			if(this.ajaxMode)
			{

				if(id=="del_filter"){
					var values = [],
						url_form =this.normal_url ? $('form.smartfilter').attr('action') : this.ajaxURL;
					values[0] = {name: 'ajax', value: 'y'};
					// document.getElementById("smartfilter").reset();
					if(!this.normal_url){
						// this.gatherInputsValues(values, BX.findChildren(document.getElementById("smartfilter"), {'tag': new RegExp('^([type=hidden])$', 'i')}, true));
						this.gatherInputsValues(values, BX.findChildren(document.getElementById("smartfilter"), {'attribute': 'hidden'}, true));
					}
					values[1] = {name: 'reset_form', value: 'y'};
					if (this.sef)
					{
						var set_filter = BX('set_filter'),
							reset_filter = BX('del_filter');
						// set_filter.disabled = true;
						reset_filter.disabled = true;
					}

					if($(button).closest('.smartfilter').find('.cars-list.car').length)
					{
						$(button).closest('.smartfilter').find('.cars-list.car').val('').change();
					}

					/*var selectBlock = $(button).closest('.bx_filter').find('.bx_filter_select_block');
					selectBlock.each(function(){
						var input = $(button).find('input').first(),
							propertyID = $(button).closest('.bx_filter_parameters_box').data('property_id');

					console.log(propertyID)
						$('#smartFilterDropDown'+propertyID+' ul li').first().find('label').click();
						$('#smartFilterDropDown'+propertyID).hide();
					});*/

					$(button).closest('.bx_filter').find('.ik_select').each(function(){
						var value = $(button).find('option').first().val();
						$(button).find('select').ikSelect('select', [value]);
					});

					this.reset = "Y";

					BX.ajax.loadJSON(
						url_form,
						this.values2post(values),
						BX.delegate(this.postHandler, this)
					);
				}
			}
			else
			{
				window.location.href = url;
			}
			return false;
		}, this));
	}
};

JCSmartFilter.prototype.gatherInputsValues = function (values, elements)
{
	if(elements)
	{
		for(var i = 0; i < elements.length; i++)
		{
			var el = elements[i];
			if (el.disabled || !el.type)
				continue;

			switch(el.type.toLowerCase())
			{
				case 'text':
				case 'textarea':
				case 'password':
				case 'hidden':
				case 'select-one':
					if(el.value.length)
						values[values.length] = {name : el.name, value : el.value};
					break;
				case 'radio':
				case 'checkbox':
					if(el.checked || $(el).prop("checked"))
					{
						values[values.length] = {name : el.name, value : el.value};
					}
					break;
				case 'select-multiple':
					for (var j = 0; j < el.options.length; j++)
					{
						if (el.options[j].selected)
							values[values.length] = {name : el.name, value : el.options[j].value};
					}
					break;
				default:
					break;
			}
		}
	}
};

JCSmartFilter.prototype.values2post = function (values)
{
	var post = [];
	var current = post;
	var i = 0;

	while(i < values.length)
	{
		var p = values[i].name.indexOf('[');
		if(p == -1)
		{
			current[values[i].name] = values[i].value;
			current = post;
			i++;
		}
		else
		{
			var name = values[i].name.substring(0, p);
			var rest = values[i].name.substring(p+1);
			if(!current[name])
				current[name] = [];

			var pp = rest.indexOf(']');
			if(pp == -1)
			{
				//Error - not balanced brackets
				current = post;
				i++;
			}
			else if(pp == 0)
			{
				//No index specified - so take the tires2 integer
				current = current[name];
				values[i].name = '' + current.length;
			}
			else
			{
				//Now index name becomes and name and we go deeper into the array
				current = current[name];
				values[i].name = rest.substring(0, pp) + rest.substring(pp+1);
			}
		}
	}
	return post;
};

JCSmartFilter.prototype.hideFilterProps = function(element)
{
	var obj = element.parentNode,
		filterBlock = obj.querySelector("[data-role='bx_filter_block']"),
		propAngle = obj.querySelector("[data-role='prop_angle']");

	if(BX.hasClass(obj, "bx-active"))
	{
		new BX.easing({
			duration : 300,
			start : { opacity: 1,  height: filterBlock.offsetHeight },
			finish : { opacity: 0, height:0 },
			transition : BX.easing.transitions.quart,
			step : function(state){
				filterBlock.style.opacity = state.opacity;
				filterBlock.style.height = state.height + "px";
			},
			complete : function() {
				filterBlock.setAttribute("style", "");
				BX.removeClass(obj, "bx-active");
			}
		}).animate();

		BX.addClass(propAngle, "fa-angle-down");
		BX.removeClass(propAngle, "fa-angle-up");
	}
	else
	{
		filterBlock.style.display = "block";
		filterBlock.style.opacity = 0;
		filterBlock.style.height = "auto";

		var obj_children_height = filterBlock.offsetHeight;
		filterBlock.style.height = 0;

		new BX.easing({
			duration : 300,
			start : { opacity: 0,  height: 0 },
			finish : { opacity: 1, height: obj_children_height },
			transition : BX.easing.transitions.quart,
			step : function(state){
				filterBlock.style.opacity = state.opacity;
				filterBlock.style.height = state.height + "px";
			},
			complete : function() {
			}
		}).animate();

		BX.addClass(obj, "bx-active");
		BX.removeClass(propAngle, "fa-angle-down");
		BX.addClass(propAngle, "fa-angle-up");
	}
};

JCSmartFilter.prototype.showDropDownPopup = function(element, popupId)
{
	var contentNode = element.querySelector('[data-role="dropdownContent"]'),
		offset=$(element).offset();
	BX.PopupWindowManager.create("smartFilterDropDown"+popupId, element, {
		autoHide: true,
		offsetLeft: 0,
		offsetTop: 0,
		overlay : false,
		draggable: {restrict:true},
		closeByEsc: true,
		content: contentNode
	}).show();
	$("#smartFilterDropDown"+popupId).css({'top':offset.top+30, 'left':offset.left});
};

JCSmartFilter.prototype.selectDropDownItem = function(element, controlId)
{
	if(!BX.hasClass(element,'disabled')){
		this.keyup(BX(controlId));

		var wrapContainer = BX.findParent(BX(controlId), {className:"bx_filter_select_container"}, false);

		var currentOption = wrapContainer.querySelector('[data-role="currentOption"]');

		currentOption.innerHTML = element.innerHTML;
		$(element).closest('.bx_filter_select_popup').find('label').removeClass('selected');
		BX.addClass(element, "selected");
		if($('.popup-window').is(':visible')){
			BX.PopupWindowManager.getCurrentPopup().close();
		}
	}
};

BX.namespace("BX.Iblock.SmartFilter");
BX.Iblock.SmartFilter = (function()
{
	var SmartFilter = function(arParams)
	{
		if (typeof arParams === 'object')
		{
			this.leftSlider = BX(arParams.leftSlider);
			this.rightSlider = BX(arParams.rightSlider);
			this.tracker = BX(arParams.tracker);
			this.trackerWrap = BX(arParams.trackerWrap);

			this.minInput = BX(arParams.minInputId);
			this.maxInput = BX(arParams.maxInputId);

			this.minPrice = parseFloat(arParams.minPrice);
			this.maxPrice = parseFloat(arParams.maxPrice);

			this.curMinPrice = parseFloat(arParams.curMinPrice);
			this.curMaxPrice = parseFloat(arParams.curMaxPrice);

			this.fltMinPrice = arParams.fltMinPrice ? parseFloat(arParams.fltMinPrice) : parseFloat(arParams.curMinPrice);
			this.fltMaxPrice = arParams.fltMaxPrice ? parseFloat(arParams.fltMaxPrice) : parseFloat(arParams.curMaxPrice);

			this.precision = arParams.precision || 0;

			this.priceDiff = this.maxPrice - this.minPrice;

			this.leftPercent = arParams.leftPercent ? parseFloat(arParams.leftPercent) : 0;
			this.rightPercent = arParams.rightPercent ? parseFloat(arParams.rightPercent) : 0;

			this.fltMinPercent = 0;
			this.fltMaxPercent = 0;

			this.colorUnavailableActive = BX(arParams.colorUnavailableActive);//gray
			this.colorAvailableActive = BX(arParams.colorAvailableActive);//blue
			this.colorAvailableInactive = BX(arParams.colorAvailableInactive);//light blue

			this.isTouch = false;

			this.init();

			if ('ontouchstart' in document.documentElement || 'ontouchstart' in window)
			{
				this.isTouch = true;

				BX.bind(this.leftSlider, "touchstart", BX.proxy(function(event){
					this.onMoveLeftSlider(event)
				}, this));

				BX.bind(this.rightSlider, "touchstart", BX.proxy(function(event){
					this.onMoveRightSlider(event)
				}, this));

				BX.bind(this.colorAvailableActive, "touchstart", BX.proxy(function(event){
					this.onChangeLeftSlider(event);
				}, this));

				BX.bind(this.colorUnavailableActive, "touchstart", BX.proxy(function(event){
					this.onChangeLeftSlider(event);
				}, this));

				BX.bind(this.colorAvailableInactive, "touchstart", BX.proxy(function(event){
					this.onChangeLeftSlider(event);
				}, this));
			}
			else
			{
				BX.bind(this.leftSlider, "mousedown", BX.proxy(function(event){
					this.onMoveLeftSlider(event)
				}, this));

				BX.bind(this.rightSlider, "mousedown", BX.proxy(function(event){
					this.onMoveRightSlider(event)
				}, this));

				BX.bind(this.colorAvailableActive, "mousedown", BX.proxy(function(event){
					this.onChangeLeftSlider(event);
				}, this));

				BX.bind(this.colorUnavailableActive, "mousedown", BX.proxy(function(event){
					this.onChangeLeftSlider(event);
				}, this));

				BX.bind(this.colorAvailableInactive, "mousedown", BX.proxy(function(event){
					this.onChangeLeftSlider(event);
				}, this));
			}

			BX.bind(this.minInput, "keyup", BX.proxy(function(event){
				this.onInputChange();
			}, this));

			BX.bind(this.maxInput, "keyup", BX.proxy(function(event){
				this.onInputChange();
			}, this));
		}
	};

	SmartFilter.prototype.init = function()
	{
		var priceDiff;

		if (this.curMinPrice > this.minPrice)
		{
			priceDiff = this.curMinPrice - this.minPrice;
			this.leftPercent = (priceDiff*100)/this.priceDiff;

			this.leftSlider.style.left = this.leftPercent + "%";
			this.colorUnavailableActive.style.left = this.leftPercent + "%";
		}

		this.setMinFilteredValue(this.fltMinPrice);

		if (this.curMaxPrice < this.maxPrice)
		{
			priceDiff = this.maxPrice - this.curMaxPrice;
			this.rightPercent = (priceDiff*100)/this.priceDiff;

			this.rightSlider.style.right = this.rightPercent + "%";
			this.colorUnavailableActive.style.right = this.rightPercent + "%";
		}

		this.setMaxFilteredValue(this.fltMaxPrice);
	};

	SmartFilter.prototype.setMinFilteredValue = function (fltMinPrice)
	{
		this.fltMinPrice = parseFloat(fltMinPrice);
		if (this.fltMinPrice >= this.minPrice)
		{
			var priceDiff = this.fltMinPrice - this.minPrice;
			this.fltMinPercent = (priceDiff*100)/this.priceDiff;

			if (this.leftPercent > this.fltMinPercent)
				this.colorAvailableActive.style.left = this.leftPercent + "%";
			else
				this.colorAvailableActive.style.left = this.fltMinPercent + "%";

			this.colorAvailableInactive.style.left = this.fltMinPercent + "%";
		}
		else
		{
			this.colorAvailableActive.style.left = "0%";
			this.colorAvailableInactive.style.left = "0%";
		}
	};

	SmartFilter.prototype.setMaxFilteredValue = function (fltMaxPrice)
	{
		this.fltMaxPrice = parseFloat(fltMaxPrice);
		if (this.fltMaxPrice <= this.maxPrice)
		{
			var priceDiff = this.maxPrice - this.fltMaxPrice;
			this.fltMaxPercent = (priceDiff*100)/this.priceDiff;

			if (this.rightPercent > this.fltMaxPercent)
				this.colorAvailableActive.style.right = this.rightPercent + "%";
			else
				this.colorAvailableActive.style.right = this.fltMaxPercent + "%";

			this.colorAvailableInactive.style.right = this.fltMaxPercent + "%";
		}
		else
		{
			this.colorAvailableActive.style.right = "0%";
			this.colorAvailableInactive.style.right = "0%";
		}
	};

	SmartFilter.prototype.getXCoord = function(elem)
	{
		var box = elem.getBoundingClientRect();
		var body = document.body;
		var docElem = document.documentElement;

		var scrollLeft = window.pageXOffset || docElem.scrollLeft || body.scrollLeft;
		var clientLeft = docElem.clientLeft || body.clientLeft || 0;
		var left = box.left + scrollLeft - clientLeft;

		return Math.round(left);
	};

	SmartFilter.prototype.getPageX = function(e)
	{
		e = e || window.event;
		var pageX = null;

		if (this.isTouch && e.targetTouches[0] != null)
		{
			pageX = e.targetTouches[0].pageX;
		}
		else if (e.pageX != null)
		{
			pageX = e.pageX;
		}
		else if (e.clientX != null)
		{
			var html = document.documentElement;
			var body = document.body;

			pageX = e.clientX + (html.scrollLeft || body && body.scrollLeft || 0);
			pageX -= html.clientLeft || 0;
		}

		return pageX;
	};

	SmartFilter.prototype.recountMinPrice = function()
	{
		var newMinPrice = (this.priceDiff*this.leftPercent)/100;
		newMinPrice = (this.minPrice + newMinPrice).toFixed(this.precision);

		if (newMinPrice != this.minPrice)
			this.minInput.value = newMinPrice;
		else
			this.minInput.value = "";
		smartFilter.keyup(this.minInput);
	};

	SmartFilter.prototype.recountMaxPrice = function()
	{
		var newMaxPrice = (this.priceDiff*this.rightPercent)/100;
		newMaxPrice = (this.maxPrice - newMaxPrice).toFixed(this.precision);

		if (newMaxPrice != this.maxPrice)
			this.maxInput.value = newMaxPrice;
		else
			this.maxInput.value = "";
		smartFilter.keyup(this.maxInput);
	};

	SmartFilter.prototype.onInputChange = function ()
	{
		var priceDiff;
		if (this.minInput.value)
		{
			var leftInputValue = this.minInput.value;
			if (leftInputValue < this.minPrice)
				leftInputValue = this.minPrice;

			if (leftInputValue > this.maxPrice)
				leftInputValue = this.maxPrice;

			priceDiff = leftInputValue - this.minPrice;
			this.leftPercent = (priceDiff*100)/this.priceDiff;

			this.makeLeftSliderMove(false);
		}

		if (this.maxInput.value)
		{
			var rightInputValue = this.maxInput.value;
			if (rightInputValue < this.minPrice)
				rightInputValue = this.minPrice;

			if (rightInputValue > this.maxPrice)
				rightInputValue = this.maxPrice;

			priceDiff = this.maxPrice - rightInputValue;
			this.rightPercent = (priceDiff*100)/this.priceDiff;

			this.makeRightSliderMove(false);
		}
	};

	SmartFilter.prototype.makeLeftSliderMove = function(recountPrice)
	{
		recountPrice = (recountPrice !== false);

		this.leftSlider.style.left = this.leftPercent + "%";
		this.colorUnavailableActive.style.left = this.leftPercent + "%";

		var areBothSlidersMoving = false;
		if (this.leftPercent + this.rightPercent >= 100)
		{
			areBothSlidersMoving = true;
			this.rightPercent = 100 - this.leftPercent;
			this.rightSlider.style.right = this.rightPercent + "%";
			this.colorUnavailableActive.style.right = this.rightPercent + "%";
		}

		if (this.leftPercent >= this.fltMinPercent && this.leftPercent <= (100-this.fltMaxPercent))
		{
			this.colorAvailableActive.style.left = this.leftPercent + "%";
			if (areBothSlidersMoving)
			{
				this.colorAvailableActive.style.right = 100 - this.leftPercent + "%";
			}
		}
		else if(this.leftPercent <= this.fltMinPercent)
		{
			this.colorAvailableActive.style.left = this.fltMinPercent + "%";
			if (areBothSlidersMoving)
			{
				this.colorAvailableActive.style.right = 100 - this.fltMinPercent + "%";
			}
		}
		else if(this.leftPercent >= this.fltMaxPercent)
		{
			this.colorAvailableActive.style.left = 100-this.fltMaxPercent + "%";
			if (areBothSlidersMoving)
			{
				this.colorAvailableActive.style.right = this.fltMaxPercent + "%";
			}
		}

		if (recountPrice)
		{
			this.recountMinPrice();
			if (areBothSlidersMoving)
				this.recountMaxPrice();
		}
	};

	SmartFilter.prototype.countNewLeft = function(event)
	{
		var pageX = this.getPageX(event);

		var trackerXCoord = this.getXCoord(this.trackerWrap);
		var rightEdge = this.trackerWrap.offsetWidth;

		var newLeft = pageX - trackerXCoord;

		if (newLeft < 0)
			newLeft = 0;
		else if (newLeft > rightEdge)
			newLeft = rightEdge;

		return newLeft;
	};

	SmartFilter.prototype.onMoveLeftSlider = function(e)
	{
		if (!this.isTouch)
		{
			this.leftSlider.ondragstart = function() {
				return false;
			};
		}

		if (!this.isTouch)
		{
			document.onmousemove = BX.proxy(function(event) {
				this.leftPercent = ((this.countNewLeft(event)*100)/this.trackerWrap.offsetWidth);
				this.makeLeftSliderMove();
			}, this);

			document.onmouseup = function() {
				document.onmousemove = document.onmouseup = null;
			};
		}
		else
		{
			var onMoveFunction = BX.proxy(function(event) {
				this.leftPercent = ((this.countNewLeft(event)*100)/this.trackerWrap.offsetWidth);
				this.makeLeftSliderMove();
			}, this);

			var onEndFunction = BX.proxy(function(event) {
				window.removeEventListener('touchmove', onMoveFunction, false);
				window.removeEventListener('touchend', onEndFunction, false);
				onMoveFunction = onEndFunction = null;
			}, this);

			window.addEventListener('touchmove', onMoveFunction, false);
			window.addEventListener('touchend', onEndFunction, false);

			/*document.ontouchmove = BX.proxy(function(event) {
				this.leftPercent = ((this.countNewLeft(event)*100)/this.trackerWrap.offsetWidth);
				this.makeLeftSliderMove();
			}, this);

			document.ontouchend = function() {
				document.ontouchmove = document.touchend = null;
			};*/
		}

		return false;
	};

	SmartFilter.prototype.makeRightSliderMove = function(recountPrice)
	{
		recountPrice = (recountPrice !== false);

		this.rightSlider.style.right = this.rightPercent + "%";
		this.colorUnavailableActive.style.right = this.rightPercent + "%";

		var areBothSlidersMoving = false;
		if (this.leftPercent + this.rightPercent >= 100)
		{
			areBothSlidersMoving = true;
			this.leftPercent = 100 - this.rightPercent;
			this.leftSlider.style.left = this.leftPercent + "%";
			this.colorUnavailableActive.style.left = this.leftPercent + "%";
		}

		if ((100-this.rightPercent) >= this.fltMinPercent && this.rightPercent >= this.fltMaxPercent)
		{
			this.colorAvailableActive.style.right = this.rightPercent + "%";
			if (areBothSlidersMoving)
			{
				this.colorAvailableActive.style.left = 100 - this.rightPercent + "%";
			}
		}
		else if(this.rightPercent <= this.fltMaxPercent)
		{
			this.colorAvailableActive.style.right = this.fltMaxPercent + "%";
			if (areBothSlidersMoving)
			{
				this.colorAvailableActive.style.left = 100 - this.fltMaxPercent + "%";
			}
		}
		else if((100-this.rightPercent) <= this.fltMinPercent)
		{
			this.colorAvailableActive.style.right = 100-this.fltMinPercent + "%";
			if (areBothSlidersMoving)
			{
				this.colorAvailableActive.style.left = this.fltMinPercent + "%";
			}
		}

		if (recountPrice)
		{
			this.recountMaxPrice();
			if (areBothSlidersMoving)
				this.recountMinPrice();
		}
	};

	SmartFilter.prototype.onMoveRightSlider = function(e)
	{
		if (!this.isTouch)
		{
			this.rightSlider.ondragstart = function() {
				return false;
			};
		}

		if (!this.isTouch)
		{
			document.onmousemove = BX.proxy(function(event) {
				this.rightPercent = 100-(((this.countNewLeft(event))*100)/(this.trackerWrap.offsetWidth));
				this.makeRightSliderMove();
			}, this);

			document.onmouseup = function() {
				document.onmousemove = document.onmouseup = null;
			};
		}
		else
		{
			var onMoveFunction = BX.proxy(function(event) {
				this.rightPercent = 100-(((this.countNewLeft(event))*100)/(this.trackerWrap.offsetWidth));
				this.makeRightSliderMove();
			}, this);

			var onEndFunction = BX.proxy(function(event) {
				window.removeEventListener('touchmove', onMoveFunction, false);
				window.removeEventListener('touchend', onEndFunction, false);
				onMoveFunction = onEndFunction = null;
			}, this);

			window.addEventListener('touchmove', onMoveFunction, false);
			window.addEventListener('touchend', onEndFunction, false);

			/*document.ontouchmove = BX.proxy(function(event) {
				this.rightPercent = 100-(((this.countNewLeft(event))*100)/(this.trackerWrap.offsetWidth));
				this.makeRightSliderMove();
			}, this);

			document.ontouchend = function() {
				document.ontouchmove = document.ontouchend = null;
			};*/
		}

		return false;
	};

	SmartFilter.prototype.onChangeLeftSlider = function(e)
	{
		if (!this.isTouch)
		{
			this.leftSlider.ondragstart = function() {
				//return false;
			};
		}
		if (!this.isTouch)
		{
			// document.onmousedown = BX.proxy(function(event) {
				var percent=((this.countNewLeft(event)*100)/this.trackerWrap.offsetWidth);
				if($(event.target).is(".bx_ui_slider_handle") || !$(event.target).is("[class^=bx_ui_slider]"))
					return;
				if(percent<50){
					this.leftPercent = percent+1;
					this.makeLeftSliderMove();
				}else{
					this.rightPercent = 100-percent;
					this.makeRightSliderMove();
				}
			// }, this);

			document.onmouseup = function() {
				document.onmousemove = document.onmouseup = null;
			};
		}
		else
		{
			var percent=((this.countNewLeft(e)*100)/this.trackerWrap.offsetWidth);
			if($(e.target).is(".bx_ui_slider_handle"))
				return;
			if(percent<50){
				this.leftPercent = percent;
				this.makeLeftSliderMove();
			}else{
				this.rightPercent = 100-percent;
				this.makeRightSliderMove();
			}

			/*document.ontouchend = BX.proxy(function(event) {
				var percent=((this.countNewLeft(event)*100)/this.trackerWrap.offsetWidth);
				if($(event.target).is(".bx_ui_slider_handle"))
					return;
				if(percent<50){
					this.leftPercent = percent;
					this.makeLeftSliderMove();
				}else{
					this.rightPercent = 100-percent;
					this.makeRightSliderMove();
				}
			}, this);

			document.ontouchend = function() {
				document.ontouchmove = document.touchend = null;
			};*/
		}

		return false;
	};

	return SmartFilter;
})();