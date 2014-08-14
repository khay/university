(function($) {
	$(function(){

		$("#categoryName").keyup(function(){
		    var Text = $(this).val();
		    Text = Text.toLowerCase();
		    Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
		    $("#categorySlug").val(Text);        
		});

	});
})(jQuery);