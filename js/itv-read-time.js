jQuery(window).load(function() {
	tinyMCE.activeEditor.onSubmit.add(function(ed, e) {
		var read_time = Math.round(ed.getContent().split(' ').length / 300);
		jQuery('.est_read_time').text(read_time);
		jQuery('#itv_read_time_value').val(read_time);
	});
});