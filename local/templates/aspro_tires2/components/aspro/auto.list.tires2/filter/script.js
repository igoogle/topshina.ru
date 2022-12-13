$(document).ready(function(){

	//send query for reload auto form
	$(document).on('change', 'select.cars-list', function(){
		var _this = $(this),
			container = _this.closest('.car_list_wrap');
		$.ajax({
			url: arTires2Options['SITE_DIR']+'ajax/car_list.php',
			type: 'POST',
			data: {
				template: 'filter',
				type_filter: container.find('input[name="type_filter"]').val(),
				car: container.find('select.car').val(), 
				model: container.find('select.model').val(),
				year: container.find('select.year').val(),
				modification: container.find('select.modification').val(),
				VYLET_DISKA_TYPE: obConfigTyreIndex.et_type,
				VYLET_DISKA_RANGE_MIN: obConfigTyreIndex.et_range0,
				VYLET_DISKA_RANGE_MAX: obConfigTyreIndex.et_range1,
				DIAMETR_STUPITSY_TYPE: obConfigTyreIndex.dia_type,
				DIAMETR_STUPITSY_RANGE_MIN: obConfigTyreIndex.dia_range0,
				DIAMETR_STUPITSY_RANGE_MAX: obConfigTyreIndex.dia_range1,
			}
		}).done(function(text){
			BX(container[0]).innerHTML = text;
			initSelects(document);
		});
	})
	
	//prepare filter propsID
	var filter_name = $('input#filter_name').val(),
		width_profil_id = $('.bx_filter_parameters_box[data-tyreindex=twidth]').data('property_id'),
		height_profil_id = $('.bx_filter_parameters_box[data-tyreindex=theight]').data('property_id'),
		dia_profil_id = $('.bx_filter_parameters_box[data-tyreindex=tdia]').data('property_id'),
		ddia_profil_id = $('.bx_filter_parameters_box[data-tyreindex=ddia]').data('property_id'),
		dmbr_profil_id = $('.bx_filter_parameters_box[data-tyreindex=dmbr]').data('property_id'),
		dco_profil_id = $('.bx_filter_parameters_box[data-tyreindex=dco]').data('property_id'),
		dvd_profil_id = $('.bx_filter_parameters_box[data-tyreindex=dvd]').data('property_id'),
		dds_profil_id = $('.bx_filter_parameters_box[data-tyreindex=dds]').data('property_id'),
		alen_profil_id = $('.bx_filter_parameters_box[data-tyreindex=alen]').data('property_id'),
		awidth_profil_id = $('.bx_filter_parameters_box[data-tyreindex=awidth]').data('property_id'),
		aheight_profil_id = $('.bx_filter_parameters_box[data-tyreindex=aheight]').data('property_id'),
		atype_profil_id = $('.bx_filter_parameters_box[data-tyreindex=atype]').data('property_id'),
		apolarity_profil_id = $('.bx_filter_parameters_box[data-tyreindex=apolarity]').data('property_id'),
		acapacity_profil_id = $('.bx_filter_parameters_box[data-tyreindex=acapacity]').data('property_id'),
		avolume_profil_id = $('.bx_filter_parameters_box[data-tyreindex=avolume]').data('property_id'),
		dwidth_profil_id = $('.bx_filter_parameters_box[data-tyreindex=dwidth]').data('property_id');

	//filter element form by auto result
	$(document).on('change', 'input[type="radio"].cars-list', function(){
		var filter_width = filter_name+'_'+width_profil_id+'_'+$(this).attr('data-w'),
			filter_height = filter_name+'_'+height_profil_id+'_'+$(this).attr('data-h'),
			filter_dia = filter_name+'_'+dia_profil_id+'_'+$(this).attr('data-d'),
			filter_dwidth = filter_name+'_'+dwidth_profil_id+'_'+$(this).attr('data-w'),
			filter_dco = filter_name+'_'+dco_profil_id+'_'+$(this).attr('data-lz'),
			filter_dmbr = filter_name+'_'+dmbr_profil_id+'_'+$(this).attr('data-pcd'),
			filter_apolarity = filter_name+'_'+apolarity_profil_id+'_'+$(this).attr('data-apolarity'),
			filter_atype = filter_name+'_'+atype_profil_id+'_'+$(this).attr('data-atype'),
			filter_dds = filter_name+'_'+dds_profil_id+'_'+$(this).attr('data-dia')*1,
			filter_ddia = filter_name+'_'+ddia_profil_id+'_'+$(this).attr('data-d'),
			arProps = [],
			arPropsSlider = [];

		//twidth
		if(width_profil_id)
		{
			arProps.push({
				'key': width_profil_id,
				'tyreindex': 'twidth',
				'id': filter_width
			})
		}

		//height
		if(height_profil_id)
		{
			arProps.push({
				'key': height_profil_id,
				'tyreindex': 'theight',
				'id': filter_height
			})
		}

		//tdia
		if(dia_profil_id)
		{
			arProps.push({
				'key': dia_profil_id,
				'tyreindex': 'tdia',
				'id': filter_dia
			})
		}

		//ddia
		if(ddia_profil_id)
		{
			arProps.push({
				'key': ddia_profil_id,
				'tyreindex': 'ddia',
				'id': filter_ddia
			})
		}

		//ddia
		if(dwidth_profil_id)
		{
			arProps.push({
				'key': dwidth_profil_id,
				'tyreindex': 'dwidth',
				'id': filter_dwidth
			})
		}

		//dco
		if(dco_profil_id)
		{
			arProps.push({
				'key': dco_profil_id,
				'tyreindex': 'dco',
				'id': filter_dco
			})
		}

		//dmbr
		if(dmbr_profil_id)
		{
			arProps.push({
				'key': dmbr_profil_id,
				'tyreindex': 'dmbr',
				'id': filter_dmbr
			})
		}

		//apolatity
		if(apolarity_profil_id)
		{
			arProps.push({
				'key': apolarity_profil_id,
				'tyreindex': 'apolarity',
				'id': filter_apolarity
			})
		}

		//atype
		if(atype_profil_id)
		{
			arProps.push({
				'key': atype_profil_id,
				'tyreindex': 'atype',
				'id': filter_atype
			})
		}

		// checked|unchecked props
		if(arProps)
		{
			for(var i in arProps)
			{
				$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] input').removeAttr('checked');
				$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] input[id='+arProps[i].id+']').prop('checked', 'checked').removeClass('disabled').removeAttr('disabled');
				$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] input[data-ti_id='+arProps[i].id+']').prop('checked', 'checked').removeClass('disabled').removeAttr('disabled');

				if($('.bx_filter_select_popup').length)
				{
					if($('.bx_filter_select_popup label[for='+arProps[i].id+']').length)
					{
						if($('#smartFilterDropDown'+arProps[i].key).length)
							$('#smartFilterDropDown'+arProps[i].key+' label').removeClass('selected');
						$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] .bx_filter_select_popup label').removeClass('selected');

						$('.bx_filter_select_popup label[for='+arProps[i].id+']').addClass('selected');
						$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] .bx_filter_select_text').text($('.bx_filter_select_popup label[for='+arProps[i].id+']').text())
					}
					else
					{
						if($('#smartFilterDropDown'+arProps[i].key).length)
						{
							$('#smartFilterDropDown'+arProps[i].key+' label').removeClass('selected');
							$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] .bx_filter_select_text').text($('#smartFilterDropDown'+arProps[i].key+' ul li:first label').text())
						}
						else
						{
							$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] .bx_filter_select_popup label').removeClass('selected');
							$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] .bx_filter_select_text').text($('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] .bx_filter_select_popup ul li:first label').text())
						}
					}
				}
			}
		}

		//dds
		if(dds_profil_id)
		{
			arPropsSlider.push({
				'key': dds_profil_id,
				'value': 'data-dia',
				'range0': obConfigTyreIndex.dia_range0,
				'range1': obConfigTyreIndex.dia_range1,
			})
		}

		//dvd
		if(dvd_profil_id)
		{
			arPropsSlider.push({
				'key': dvd_profil_id,
				'value': 'data-et',
				'range0': obConfigTyreIndex.et_range0,
				'range1': obConfigTyreIndex.et_range1,
			})
		}

		//alen
		if(alen_profil_id)
		{
			arPropsSlider.push({
				'key': alen_profil_id,
				'value1': 'data-alen_from',
				'value2': 'data-alen_to',
			})
		}

		//awidth
		if(awidth_profil_id)
		{
			arPropsSlider.push({
				'key': awidth_profil_id,
				'value1': 'data-awidth_from',
				'value2': 'data-awidth_to',
			})
		}

		//aheight
		if(aheight_profil_id)
		{
			arPropsSlider.push({
				'key': aheight_profil_id,
				'value1': 'data-aheight_from',
				'value2': 'data-aheight_to',
			})
		}

		//acapacity
		if(acapacity_profil_id)
		{
			arPropsSlider.push({
				'key': acapacity_profil_id,
				'value1': 'data-acapacity_from',
				'value2': 'data-acapacity_to',
			})
		}

		//avolume
		if(avolume_profil_id)
		{
			arPropsSlider.push({
				'key': avolume_profil_id,
				'value1': 'data-avolume_from',
				'value2': 'data-avolume_to',
			})
		}

		if(arPropsSlider)
		{
			for(var i in arPropsSlider)
			{
				if('value1' in arPropsSlider[i] && 'value2' in arPropsSlider[i])
				{
					var value1 = parseFloat($(this).attr(arPropsSlider[i].value1)),
						value2 = parseFloat($(this).attr(arPropsSlider[i].value2)),
						container = $('.bx_filter_parameters_box[data-property_id='+arPropsSlider[i].key+']'),
						min = parseFloat(container.find('.min-price').attr('placeholder')),
						max = parseFloat(container.find('.max-price').attr('placeholder')),
						min_val = (value1 >= min ? value1 : ''),
						max_val = (value2 <= max ? value2 : '');
				}
				else
				{
					var value = parseFloat($(this).attr(arPropsSlider[i].value)),
						range0 = parseFloat(arPropsSlider[i].range0),
						range1 = parseFloat(arPropsSlider[i].range1),
						container = $('.bx_filter_parameters_box[data-property_id='+arPropsSlider[i].key+']'),
						min = parseFloat(container.find('.min-price').attr('placeholder')),
						max = parseFloat(container.find('.max-price').attr('placeholder')),
						min_val = (value - range0 >= min ? value - range0 : ''),
						max_val = (value + range1 <= max ? value + range1 : '');
				}
				if(container.find('.min-price').length)
					container.find('.min-price').val((min_val.toString().length ? parseFloat(min_val.toFixed(1)) : ''));
				if(container.find('.max-price').length)
					container.find('.max-price').val((max_val.toString().length ? parseFloat(max_val.toFixed(1)) : ''));

				if(typeof window['trackBar'+arPropsSlider[i].key])
				{
					window['trackBar'+arPropsSlider[i].key].onInputChange();
				}
			}
		}

		//submit filter form
		if(typeof smartFilter == 'object')
			smartFilter.reloadAllForm();
	})
})