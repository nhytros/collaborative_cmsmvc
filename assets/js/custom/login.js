$( document ).ready(function() {
	$("#loginForm").unbind('submit').bind('submit', function() {
		var form = $(this);
		var url = form.attr('action');
		var type = form.attr('method');

		$.ajax({
			url: url,
			type: type,
			data: form.serialize(),
			dataType: 'json',
			success: function(response) {
				console.log(response);
			}
		});
		return false;
	});
});
