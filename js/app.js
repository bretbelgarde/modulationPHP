jQuery(document).ready(function($) {
	
	var modinfoTemplateScript = $("#modinfo-template").html();

	$('.mod-link').click(function(e){
		e.preventDefault();

		$.get($(this).attr('href'), function(res){
			var jsonObj = jQuery.parseJSON(res);
			var data = jsonObj.data;

			if (jsonObj.success) {
				var modinfoTemplate = Handlebars.compile(modinfoTemplateScript);
				$('#mod-details').html(modinfoTemplate(data));
				$('#notifications').html('');
			} else {
				$('#notifications').html(data.error);
				$('#mod-details').html('');
			}


		});

	});

});
