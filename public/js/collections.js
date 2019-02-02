jQuery(document).ready(function() {

	// view edited fields in modal
		$('body').on('click', '#view_edited', function() {
			var editedCollectionID = $(this).attr('data-id')

			$.ajax({
				url: '/collection/get-collection-edited-fields/' + editedCollectionID,
				method: 'GET',
				success: function (result) {
					$('#show_fields').html(result.html)
				}
			})
		})
	// view edited fields in modal

	// approve edited collection
        $('body').on('submit', '#editForm', function(e) {
            e.preventDefault()
            var formData = new FormData(this)
            var collectionId = $(this).attr('data-id')

            $.ajax({
                url: '/collection/edit_approve/' + collectionId,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(result) {
                    $('#edited_collection').modal('hide')
                    $('#statusAndBtn' + collectionId).remove()
                    $('#mainTr' + collectionId).removeClass('info')

                    $.each(result, function(index, value) {
                        $('#' + index + collectionId).html(value)
                    })
                }
            })
        })
    // end approve edited collection

    // reject edited restaurant
        $('body').on('click', '#reject', function() {
            var collectionId = $(this).attr('data-id')

            $.ajax({
                url: '/collection/edit_reject/' + collectionId,
                method: 'GET',
                success: function(result) {
                	$('#edited_collection').modal('hide')
                	$('#statusAndBtn' + collectionId).remove()
                	$('#mainTr' + collectionId).removeClass('info')
                }
            })
        })
    // end reject edited restaurant
})