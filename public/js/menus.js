jQuery(document).ready(function() {

    var token = $('[name=csrf-token]').attr('content');

    $('#delete_menu').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);

        if(checkValues.length > 0){
            var choice = confirm("Are you sure you want to delete?");

            if (choice) {
                $.ajax({

                    method: "POST",
                    url: "/menu/delete",
                    data: {id: checkValues, _token: token},
                    success: function (data) {

                        window.location.reload();
                    }

                });
            }

        }else{
            alert("Select menu item!");
        }


    });

    $('#delete_menu_category').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);
        if(checkValues.length > 0){
            var choice = confirm("Are you sure you want to delete?");

            if (choice) {
                $.ajax({

                    method: "POST",
                    url: "/menu_category/delete",
                    data: {id: checkValues, _token: token},
                    success: function (data) {

                        window.location.reload();
                    }

                });
            }

        }else{
            alert("Select menu category!");
        }


    });


    // view edited fields in modal
    $('body').on('click', '#view_edited', function() {
        var editedCategoryID = $(this).attr('data-id');

        $.ajax({
            url: '/menu_category/get-category-edited-fields/' + editedCategoryID,
            method: 'GET',
            success: function (result) {
                $('#show_fields').html(result.html)
            }
        })
    });
    // view edited fields in modal

    // approve edited category
    $('body').on('submit', '#editForm', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var categoryId = $(this).attr('data-id');

        $.ajax({
            url: '/menu_category/edit_approve/' + categoryId,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(result) {
                $('#edited_category').modal('hide');
                $('#statusAndBtn' + categoryId).remove();
                $('#mainTr' + categoryId).removeClass('info');

                $.each(result, function(index, value) {
                    $('#' + index + categoryId).html(value)
                })
            }
        })
    });
    // end approve edited category

    // reject edited category
    $('body').on('click', '#reject', function() {
        var categoryId = $(this).attr('data-id');

        $.ajax({
            url: '/menu_category/edit_reject/' + categoryId,
            method: 'GET',
            success: function(result) {
                $('#edited_category').modal('hide');
                $('#statusAndBtn' + categoryId).remove();
                $('#mainTr' + categoryId).removeClass('info')
            }
        })
    });
    // end reject edited category


});