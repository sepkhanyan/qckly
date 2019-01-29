jQuery(document).ready(function() {

	$('body').on('click', '#view_edited', function() {
		var editedCollectionID = $(this).attr('data-id')
		console.log(editedCollectionID)

		$.ajax({
			url: 'get-edited-fields',
			method: 'GET',
			data: { id: editedCollectionID },
			success: function (result) {
				$('#show_fields').html(result.html)
			}
		})
	})
})