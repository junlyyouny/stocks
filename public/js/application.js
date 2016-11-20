+function ($) {
	//公用错误提示
	if ($('.error_info').hasClass('alert')) {
		$('.error_info').fadeOut(6000);
	}
	// 删除操作提醒
	$('.do_del').click(function(){
		if (confirm('确认要删除吗？')) {
			return true;
		}
		return false;
	});
	// 入库表单验证
	$('.storage_from').submit(function(event){
		var goodsNum = $('#goodsNum').val(),
			barcode = $('#barcode').val();
		if (goodsNum == '') {
	    	$('.error_info').text('请输入商品编码！').addClass('alert').show().fadeOut(6000);
	    	event.preventDefault();
	    	return false;
		}
		if (barcode == '') {
	    	$('.error_info').text('请输入条形码！').addClass('alert').show().fadeOut(6000);
	    	return false;
		}
	});
	// 出库表单验证
	$('.sale_from').submit(function(event){
		var stocksId = $('#stocksId').val(),
			barcode = $('#barcode').val();
		if (stocksId == '' && barcode == '') {
	    	$('.error_info').text('请输入库存编码或条形码！').addClass('alert').show().fadeOut(6000);
	    	event.preventDefault();
	    	return false;
		}
	});
	// 时间插件
	if ($('.form_date').length) {
		$('.form_date').datetimepicker({
	        language:  'zh-CN',
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0
	    });
	}
}(jQuery);
