$(document).ready(function () {
    var token = $('[name=csrf-token]').attr('content');


    $("#addRestaurantCategory").click(function() {
        $("#addRestaurantCategory").attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: '/restaurant_category/store',
            data: {
                '_token': token,
                'name_en': $('input[name=name_en]').val(),
                'name_ar': $('input[name=name_ar]').val()
            },
            success: function(data) {
                window.location.reload();
            },
            error: function(data){
                $("#addRestaurantCategory").removeAttr('disabled');
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

    $('.edit-restaurant-category-modal').on('click',  function() {
        $('#category_en').val($(this).data('name-en'));
        $('#category_ar').val($(this).data('name-ar'));
        $('input[name=restaurant_category_id]').val($(this).data('id'));
        $('#modalEditRestaurantCategory').modal('show');
    });

    $("#editRestaurantCategory").click(function() {
        $("#editRestaurantCategory").attr('disabled', 'disabled');
        var en = $('#category_en').val();
        var ar = $('#category_ar').val();
        $.ajax({
            type: 'POST',
            url: '/restaurant_category/update',
            data: {
                '_token': token,
                'id': $('input[name=restaurant_category_id]').val(),
                'name_en': en,
                'name_ar': ar
            },
            success: function(data) {
                window.location.reload();
            },
            error: function(data){
                $("#editRestaurantCategory").removeAttr('disabled');
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

    $('#delete_restaurant_category').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);
        if(checkValues.length > 0){
            var choice = confirm("Are you sure you want to delete?");

            if (choice) {
                $.ajax({

                    method: "POST",
                    url: "/restaurant_category/delete",
                    data: {id: checkValues, _token: token},
                    success: function (data) {

                        window.location.reload();
                    }

                });
            }

        }else{
            alert("Select restaurant category!");
        }
    });

    $('#delete_restaurant').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);
        if(checkValues.length > 0){
            var choice = confirm("Are you sure you want to delete?");

            if (choice) {
                $.ajax({

                    method: "POST",
                    url: "/restaurant/delete",
                    data: {id: checkValues, _token: token},
                    success: function (data) {

                        window.location.reload();
                    }

                });
            }

        }else{
            alert("Select restaurant!");
        }
    });

    // view edited fields in modal
        $('body').on('click', '#view_edited', function() {
            var editedRestaurantID = $(this).attr('data-id')

            $.ajax({
                url: 'restaurant/get-restaurant-edited-fields',
                method: 'GET',
                data: { id: editedRestaurantID },
                success: function (result) {
                    $('#show_fields').html(result.html)
                }
            })
        })
    // end view edited fields in modal

    // approve edited restaurant
        $('body').on('submit', '#editForm', function(e) {
            e.preventDefault()
            var formData = new FormData(this)
            var restaurantId = $(this).attr('data-id')

            $.ajax({
                url: 'restaurant/edit_approve/' + restaurantId,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(result) {
                    $('#edited_restaurant').modal('hide')
                    $('#statusAndBtn' + restaurantId).remove()
                    $('#mainTr' + restaurantId).removeClass('info')

                    $.each(result, function(index, value) {
                        $('#' + index + restaurantId).html(value)
                    })
                }
            })
        })
    // end approve edited restaurant

    // reject edited restaurant
        $('body').on('click', '#reject', function() {
            var restaurantId = $(this).attr('data-id')

            $.ajax({
                url: 'restaurant/edit_reject/' + restaurantId,
                method: 'GET'
            })
        })
    // end reject edited restaurant
});