$(document).ready(function(){
	$('.item_types_block .block_wrapper .item').click(function(){
		var _this = $(this);
		if(_this.data('group') != 'all')
		{
			_this.closest('.sections_inner_wrapper').find('.list.items .item_block').addClass('hidden');
			_this.closest('.sections_inner_wrapper').find('.list.items .item_block.'+_this.data('group')).removeClass('hidden');
		}
		else
		{
			_this.closest('.sections_inner_wrapper').find('.list.items .item_block').removeClass('hidden');
		}
	})
})