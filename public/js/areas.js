jQuery(document).ready(function() {

    var token = $('[name=csrf-token]').attr('content');


    $("#addArea").click(function() {
        $("#addArea").attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: '/area/store',
            data: {
                '_token': token,
                'name_en': $('input[name=name_en]').val(),
                'name_ar': $('input[name=name_ar]').val()
            },
            success: function(data) {
                window.location.reload();
            },
            error: function(data){
                $("#addArea").removeAttr('disabled');
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

    $('.edit-area-modal').on('click',  function() {
        $('#area_en').val($(this).data('name-en'));
        $('#area_ar').val($(this).data('name-ar'));
        $('input[name=area_id]').val($(this).data('id'));
        $('#modalEditArea').modal('show');
    });

    $("#editArea").click(function() {
        $("#editArea").attr('disabled', 'disabled');
        var en = $('#area_en').val();
        var ar = $('#area_ar').val();
        $.ajax({
            type: 'POST',
            url: '/area/update',
            data: {
                '_token': token,
                'id': $('input[name=area_id]').val(),
                'name_en': en,
                'name_ar': ar
            },
            success: function(data) {
                window.location.reload();
            },
            error: function(data){
                $("#editArea").removeAttr('disabled');
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


    $('#delete_area').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues.length);
        if(checkValues.length > 0){
            var choice = confirm("Are you sure you want to delete?");

            if (choice) {
                $.ajax({

                    method: "POST",
                    url: "/area/delete",
                    data: {id: checkValues, _token: token},
                    success: function (data) {

                        window.location.reload();
                    }

                });
            }
        }else{
            alert("Select area!");
        }



    });


});