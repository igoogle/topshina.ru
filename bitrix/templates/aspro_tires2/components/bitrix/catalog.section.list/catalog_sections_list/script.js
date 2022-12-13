$(document).ready(function(){
	$('.item_types_block .block_wrapper .item').click(function(){
		var _this = $(this);
		if(_this.data('group') != 'all')
		{
			_this.closest('.sections_inner_wrapper').find('.list.items .list_item_wrapp').addClass('hidden');
			_this.closest('.sections_inner_wrapper').find('.list.items .list_item_wrapp.'+_this.data('group')).removeClass('hidden');
		}
		else
		{
			_this.closest('.sections_inner_wrapper').find('.list.items .list_item_wrapp').removeClass('hidden');
		}
	})
})