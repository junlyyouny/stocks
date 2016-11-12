+function ($) {
	//公用错误提示
	if ($('.error_info').hasClass('alert')) {
		$('.error_info').fadeOut(3000);
	}
	// 入库表单验证
	$('.storage_from').submit(function(event){
		var goodsNum = $('#goodsNum').val(),
			barcode = $('#barcode').val();
		if (goodsNum == '') {
	    	$('.error_info').text('请输入商品编码！').addClass('alert').show().fadeOut(3000);
	    	event.preventDefault();
	    	return false;
		}
		if (barcode == '') {
	    	$('.error_info').text('请输入条形码！').addClass('alert').show().fadeOut(3000);
	    	return false;
		}
	});
	// 出库表单验证
	$('.sale_from').submit(function(event){
		var stocksId = $('#stocksId').val(),
			barcode = $('#barcode').val();
		if (stocksId == '' && barcode == '') {
	    	$('.error_info').text('请输入库存编码或条形码！').addClass('alert').show().fadeOut(3000);
	    	event.preventDefault();
	    	return false;
		}
	});
}(jQuery);
