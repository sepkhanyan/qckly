jQuery(document).ready(function() {

    var token = $('[name=csrf-token]').attr('content');







    $("#addStatus").click(function() {
        $("#addStatus").attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: '/status/store',
            data: {
                '_token': token,
                'name_en': $('input[name=name_en]').val(),
                'name_ar': $('input[name=name_ar]').val()
            },
            success: function(data) {
                window.location.reload();
            },
            error: function(data){
                $("#addStatus").removeAttr('disabled');
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

    $('.edit-status-modal').on('click',  function() {
        $('#status_en').val($(this).data('name-en'));
        $('#status_ar').val($(this).data('name-ar'));
        $('input[name=status_id]').val($(this).data('id'));
        $('#modalEditStatus').modal('show');
    });

    $("#editStatus").click(function() {
        $("#editStatus").attr('disabled', 'disabled');
        var en = $('#status_en').val();
        var ar = $('#status_ar').val();
        $.ajax({
            type: 'POST',
            url: '/status/update',
            data: {
                '_token': token,
                'id': $('input[name=status_id]').val(),
                'name_en': en,
                'name_ar': ar
            },
            success: function(data) {
                window.location.reload();
            },
            error: function(data){
                $("#editStatus").removeAttr('disabled');
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


});