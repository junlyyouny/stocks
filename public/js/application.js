+function ($) {
	$('.input_from').submit(function(event){
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
}(jQuery);
