(function($) {
	$(function(){

		// Ajax Search Function
		function ajaxSearch(form, url) {
			$.ajax({
				url: url,
				type: 'POST',
				data: $(form).serialize(),
				beforeSend: function() {
					$('#filter-form').append('<span id="waiting" class="loading"></span>');
				},
				complete: function() {
					$('#waiting').remove();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$('#waiting').remove();
					$('#filter-form').append('<span id="result-error">'+errorThrown+'</span>');
				},
				success: function(data) {
					$('#data_table_wrapper').html(data);
				}
			});
		};

		var timeoutReference;
		$('#filter-box').on('keyup', function(e){
			var form = $('#filter-form');
			var url = form.attr('action');
			if (timeoutReference) clearTimeout(timeoutReference);
			timeoutReference = setTimeout(function() {
				ajaxSearch(form, url);
			}, 500);
		});

		$('#fiter-form').submit(function(e){
			e.preventDefault();
		});

		/* ========== End of Search Function List ============== */

		$("#categoryName").keyup(function(){
		    var Text = $(this).val();
		    Text = Text.toLowerCase();
		    Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
		    $("#categorySlug").val(Text);        
		});

	});
})(jQuery);