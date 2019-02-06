jQuery(document).ready(function() {

	// view edited fields in modal
		$('body').on('click', '#view_edited', function() {
			var editedCollectionID = $(this).attr('data-id');

			$.ajax({
				url: '/collection/get-collection-edited-fields/' + editedCollectionID,
				method: 'GET',
				success: function (result) {
					$('#show_fields').html(result.html)
				}
			})
		});
	// view edited fields in modal

	// approve edited collection
        $('body').on('submit', '#editForm', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var collectionId = $(this).attr('data-id');

            $.ajax({
                url: '/collection/edit_approve/' + collectionId,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(result) {
                    $('#edited_collection').modal('hide');
                    $('#statusAndBtn' + collectionId).remove();
                    $('#mainTr' + collectionId).removeClass('info');

                    $.each(result, function(index, value) {
                        $('#' + index + collectionId).html(value)
                    })
                }
            })
        });
    // end approve edited collection

    // reject edited restaurant
        $('body').on('click', '#reject', function() {
            var collectionId = $(this).attr('data-id');

            $.ajax({
                url: '/collection/edit_reject/' + collectionId,
                method: 'GET',
                success: function(result) {
                	$('#edited_collection').modal('hide');
                	$('#statusAndBtn' + collectionId).remove();
                	$('#mainTr' + collectionId).removeClass('info')
                }
            })
        });
    // end reject edited restaurant



    // view edited fields in modal
    $('body').on('click', '#add_images', function() {
        var collectionID = $(this).attr('data-id');

        $.ajax({
            url: '/collection/getExtraImages/' + collectionID,
            method: 'GET',
            success: function (result) {
                $('#show_images').html(result.html)
            }
        })

    });

    $('body').on('submit', '#uploadImages', function(e) {
        $('#uploadButton').attr('disabled', 'disabled');
        e.preventDefault();
        var formData = new FormData(this);
        var collectionId = $(this).attr('data-id');

        $.ajax({
            url: '/collection/images_upload/' + collectionId,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(result) {
                $('#show_images').html(result.html);
                $('#uploadButton').removeAttr('disabled');
            },
            error: function(data){
                $('#uploadButton').removeAttr('disabled');
                if(data.responseJSON.errors.image){
                    $('#imageForm').addClass('has-error');
                    $('#imageForm .help-block').removeClass('hidden');
                    $('#imageForm .help-block strong').text(data.responseJSON.errors.image);
                }
            }
        })
    });

    $('body').on('click', '#removeImage', function() {
        var collectionImageID = $(this).attr('data-id');

        $.ajax({
            url: '/collection/image_delete/' + collectionImageID,
            method: 'GET',
            success: function (result) {
                $('#show_images').html(result.html)
            }
        })

    });


});

