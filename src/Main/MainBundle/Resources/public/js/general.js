$(function(){
	
	$('.filter_price').on('click',function(){
		var min_value = $(this).children('span').children('.exact_val_min').text();
		var max_value = $(this).children('span').children('.exact_val_max').text();
		var url = $('#filter_path').val();
		if(max_value!='')
        {
        	var text = parseFloat(min_value).toFixed(2) +'-'+ parseFloat(max_value).toFixed(2);
        }else
        {
        	var text = parseFloat(min_value).toFixed(2) +' and above';
        }
		var my_elem = '<li class="price"><span class="label">Price:</span> <span class="value">'+text+'</span></li>';
		var params={};
		$('.filter_list').children('.price').remove();
		$('.filter_list').append(my_elem);
		$('.actions').show();
		params['min_value'] = parseFloat(min_value).toFixed(2);
		params['max_value'] = parseFloat(max_value).toFixed(2);
		$.post(url,params,function(o){
			$('.list_wrapper').html(o);
		},'html');
	});
	$('.filter_categories').on('click',function(){
		var my_elem = '<li class="category"><span class="label">Category:</span> <span class="value">'+$(this).text()+'</span></li>';
		$('.filter_list').children('.category').remove();
		$('.filter_list').prepend(my_elem);
		$('.actions').show();
		$.post($('#filter_path').val(),{ 'category_id': $(this).attr('rel'), 'category_name': $(this).text() }, function(o){
			$('.list_wrapper').html(o);
		},'html');
	});
	$('.clear_all').on('click',function(){
		$('.actions').hide();
		$('.filter_list').children('.price').remove();
		$('.filter_list').children('.category').remove();
		var url = $('#filter_path').val();
		var params = {};
		params['reset_filters'] = true;
		$.post(url,params,function(o){
			$('.list_wrapper').html(o);
		},'html');
	})
});