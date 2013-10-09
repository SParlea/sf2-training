$(function(){
	$('.sort_by').on('change',function(){
		var sort_by = $(this).val();
		var direction = $('.direction').val();
		var url = $('.sort_form').attr('action');
		var fields = $('.sort_form').serializeArray(), params = {},this_= $(this);
		$.each(fields,function(i,field){
			params[field.name] = field.value;
		}); 
		params['sort_by'] = sort_by;
		params['direction'] = direction;
		$.post(url,params,function(o){
			$('.list_wrapper').html(o);
		},'html');
	});
	$('.direction').on('change',function(){
		var sort_by = $('.sort_by').val();
		var direction = $(this).val();
		var url = $('.sort_form').attr('action');
		var fields = $('.sort_form').serializeArray(), params = {},this_= $(this);
		$.each(fields,function(i,field){
			params[field.name] = field.value;
		}); 
		params['sort_by'] = sort_by;
		params['direction'] = direction;
		$.post(url,params,function(o){
			$('.list_wrapper').html(o);
		},'html');
	});
});