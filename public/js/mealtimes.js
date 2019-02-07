jQuery(document).ready(function() {

    var token = $('[name=csrf-token]').attr('content');



    $("#addMealtime").click(function() {
        $("#addMealtime").attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: '/mealtime/store',
            data: {
                '_token': token,
                'name_en': $('input[name=name_en]').val(),
                'name_ar': $('input[name=name_ar]').val(),
                'start_time' : $('input[name=start_time]').val(),
                'end_time' : $('input[name=end_time]').val()
            },
            success: function(data) {
                window.location.reload();
            },
            error: function(data){
                $("#addMealtime").removeAttr('disabled');
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
                if(data.responseJSON.errors.start_time){
                    $('#start').addClass('has-error');
                    $('#start .help-block').removeClass('hidden');
                    $('#start .help-block strong').text(data.responseJSON.errors.start_time);
                }else{
                    $('#start').removeClass('has-error');
                    $('#start .help-block').addClass('hidden');
                }
                if(data.responseJSON.errors.end_time){
                    $('#end').addClass('has-error');
                    $('#end .help-block').removeClass('hidden');
                    $('#end .help-block strong').text(data.responseJSON.errors.end_time);
                }else{
                    $('#end').removeClass('has-error');
                    $('#end .help-block').addClass('hidden');
                }
            }
        });
    });

    $('.edit-mealtime-modal').on('click',  function() {
        $('#mealtime_en').val($(this).data('name-en'));
        $('#mealtime_ar').val($(this).data('name-ar'));
        $('#start_time').val($(this).data('start-time'));
        $('#end_time').val($(this).data('end-time'));
        $('input[name=mealtime_id]').val($(this).data('id'));
        $('#modalEditMealtime').modal('show');
    });

    $("#editMealtime").click(function() {
        $("#editMealtime").attr('disabled', 'disabled');
        var en = $('#mealtime_en').val();
        var ar = $('#mealtime_ar').val();
        var start = $('#start_time').val();
        var end = $('#end_time').val();
        $.ajax({
            type: 'POST',
            url: '/mealtime/update',
            data: {
                '_token': token,
                'id': $('input[name=mealtime_id]').val(),
                'name_en': en,
                'name_ar': ar,
                'start_time': start,
                'end_time' : end
            },
            success: function(data) {
                window.location.reload();
            },
            error: function(data){
                $("#editMealtime").removeAttr('disabled');
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
                if(data.responseJSON.errors.start_time){
                    $('#editStart').addClass('has-error');
                    $('#editStart .help-block').removeClass('hidden');
                    $('#editStart .help-block strong').text(data.responseJSON.errors.start_time);
                }else{
                    $('#editStart').removeClass('has-error');
                    $('#editStart .help-block').addClass('hidden');
                }
                if(data.responseJSON.errors.end_time){
                    $('#editEnd').addClass('has-error');
                    $('#editEnd .help-block').removeClass('hidden');
                    $('#editEnd .help-block strong').text(data.responseJSON.errors.end_time);
                }else{
                    $('#editEnd').removeClass('has-error');
                    $('#editEnd .help-block').addClass('hidden');
                }
            }
        });
    });


    $('#delete_mealtime').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);
        if(checkValues.length > 0){
            var choice = confirm("Are you sure you want to delete?");

            if (choice) {
                $.ajax({

                    method: "POST",
                    url: "/mealtime/delete",
                    data: {id: checkValues, _token: token},
                    success: function (data) {

                        window.location.reload();
                    }

                });
            }

        }else{
            alert("Select mealtime!");
        }


    });


});