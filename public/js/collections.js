jQuery(document).ready(function() {

    var token = $('[name=csrf-token]').attr('content');

    $('#delete_collection').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);

        if(checkValues.length > 0){
            var choice = confirm("Are you sure you want to delete?");

            if (choice) {
                $.ajax({

                    method: "POST",
                    url: "/collection/delete",
                    data: {id: checkValues, _token: token},
                    success: function (data) {

                        window.location.reload();
                    }

                });
            }

        }else{
            alert("Select collection!");
        }


    });


    $('#delete_collection_category').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);

        if(checkValues.length > 0){
            var choice = confirm("Are you sure you want to delete?");

            if (choice) {
                $.ajax({

                    method: "POST",
                    url: "/collection_category/delete",
                    data: {id: checkValues, _token: token},
                    success: function (data) {

                        window.location.reload();
                    }

                });
            }

        }else{
            alert("Select collection category!");
        }


    });

    $("#addCollectionCategory").click(function() {
        $("#addCollectionCategory").attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: '/collection_category/store',
            data: {
                '_token': token,
                'name_en': $('input[name=name_en]').val(),
                'name_ar': $('input[name=name_ar]').val()
            },
            success: function(data) {
                window.location.reload();
            },
            error: function(data){
                $("#addCollectionCategory").removeAttr('disabled');
                if(data.responseJSON.errors.name_en){
                    $('#en').addClass('has-error');
                    $('#en .help-block').removeClass('hidden');
                    $('#en .help-block strong').text(data.responseJSON.errors.name_en);
                }else{
                    $('#en').removeClass('has-error');
                    $('#en .help-block').addClass('hidden');
                }
                if(data.responseJSON.errors.name_ar){
                    $('#ar').addClass('has-error');
                    $('#ar .help-block').removeClass('hidden');
                    $('#ar .help-block strong').text(data.responseJSON.errors.name_ar);
                }else{
                    $('#ar').removeClass('has-error');
                    $('#ar .help-block').addClass('hidden');
                }
            }
        });
    });

    $('.edit-collection-category-modal').on('click',  function() {
        $('#category_en').val($(this).data('name-en'));
        $('#category_ar').val($(this).data('name-ar'));
        $('input[name=collection_category_id]').val($(this).data('id'));
        $('#modalEditCollectionCategory').modal('show');
    });

    $("#editCollectionCategory").click(function() {
        $("#editCollectionCategory").attr('disabled', 'disabled');
        var en = $('#category_en').val();
        var ar = $('#category_ar').val();
        $.ajax({
            type: 'POST',
            url: '/collection_category/update',
            data: {
                '_token': token,
                'id': $('input[name=collection_category_id]').val(),
                'name_en': en,
                'name_ar': ar
            },
            success: function(data) {
                window.location.reload();
            },
            error: function(data){
                console.log(data.responseJSON);
                $("#editCollectionCategory").removeAttr('disabled');
                if(data.responseJSON.errors.name_en){
                    $('#editEn').addClass('has-error');
                    $('#editEn .help-block').removeClass('hidden');
                    $('#editEn .help-block strong').text(data.responseJSON.errors.name_en);
                }else{
                    $('#editEn').removeClass('has-error');
                    $('#editEn .help-block').addClass('hidden');
                }
                if(data.responseJSON.errors.name_ar){
                    $('#editAr').addClass('has-error');
                    $('#editAr .help-block').removeClass('hidden');
                    $('#editAr .help-block strong').text(data.responseJSON.errors.name_ar);
                }else{
                    $('#editAr').removeClass('has-error');
                    $('#editAr .help-block').addClass('hidden');
                }
            }
        });
    });

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

