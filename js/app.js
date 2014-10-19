jQuery(document).ready(function($) {

	var modinfoTemplateScript = $("#modinfo-template").html();
	var modListTemplateScript = $("#mod-list-template").html();

	var modListTemplate = Handlebars.compile(modListTemplateScript);

	var updateModList = function() {
		
		$.ajax({
			url: 'mod-list.php',
		}).done(function(res){
			var jsonObj = jQuery.parseJSON(res);
			var data = jsonObj.data;
			if (jsonObj.success) {
					$('#mod-list').html(modListTemplate(data))
			} else {
				$('#mod-list').html(data.error);
			}

		});
	}

	updateModList();

	$('#mod-list').delegate(".mod-link", "click", function(e){
		e.preventDefault();

		$.get($(this).attr('href'), function(res){
			var jsonObj = jQuery.parseJSON(res);
			var data = jsonObj.data;
			var modinfoTemplate = Handlebars.compile(modinfoTemplateScript);

			if (jsonObj.success) {
				$('#mod-details').html(modinfoTemplate(data));
				$('#notifications').html('');
			} else {
				$('#notifications').html('<p class="warning">' + data.error + '</p>');
				$('#mod-details').html(modinfoTemplate(data));
			}


		});

	});


	


	$("#mod-details").on("click", "#save", function(e){
		e.preventDefault();

		$.post("save-mod-info.php", $("#mod-data").serialize()).done(function(res) {
			console.log(res);
			var jsonObj = jQuery.parseJSON(res);
			var data = jsonObj.data;
			if (jsonObj.success) {
				$('#notifications').html('<p class="success">' + data + '</p>');
			} else {
				$('#notifications').html('<p class="warning">' + data + '</p>');
			}
		});

		updateModList();

	});
});
