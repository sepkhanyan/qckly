$(document).ready(function () {

    var token = $('[name=csrf-token]').attr('content');

    $("a#select-image").on("click", function () {


        $.post("/image/manager", function (data) {

            $("#media-manager").html(data).fadeIn();

        });//Put the code from above here.

    });


    $('#editCategory').click(function () {
        $('#editing_category').slideDown();
    });
    $('#editCategoryCancel').click(function () {
        $('#editing_category').slideUp();
        $('#category').val(null).trigger("change");
    });
    $('#editArea').click(function () {
        $('#editing_area').slideDown();
    });
    $('#editAreaCancel').click(function () {
        $('#editing_area').slideUp();
        $('#area').val(null).trigger("change");
    });

    $('#editNameEn').click(function () {
        $('#editing_name_en').slideDown();
    });
    $('#editNameEnCancel').click(function () {
        $('#editing_name_en').slideUp();
        $('input[name=restaurant_name_en]').val("");
    });

    $('#editNameAr').click(function () {
        $('#editing_name_ar').slideDown();
    });
    $('#editNameArCancel').click(function () {
        $('#editing_name_ar').slideUp();
        $('input[name=restaurant_name_ar]').val("");
    });

    $('#editTelephone').click(function () {
        $('#editing_telephone').slideDown();
    });
    $('#input_restaurant_telephone').on('keypress', function(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
    });
    $('#editTelephoneCancel').click(function () {
        $('#editing_telephone').slideUp();
        $('input[name=restaurant_telephone]').val("");
    });

    $('#editDescriptionEn').click(function () {
        $('#editing_description_en').slideDown();
    });
    $('#editDescriptionEnCancel').click(function () {
        $('#editing_description_en').slideUp();
        $('#input_description_en').val("");
    });
    $('#editDescriptionAr').click(function () {
        $('#editing_description_ar').slideDown();
    });
    $('#editDescriptionArCancel').click(function () {
        $('#editing_description_ar').slideUp();
        $('#input_description_ar').val("");
    });

    $('#editImage').click(function () {
        $('#editing_image').slideDown();
    });
    $('#editImageCancel').click(function () {
        $('#editing_image').slideUp();
        $('input[name=image]').val("");
        $('#thumb').attr('src', '/admin/no_photo.png');
    });

    $('#editWorkingHour').click(function () {
        $('#editing_working_hour').slideDown();
    });
    $('#editWorkingHourCancel').click(function () {
        $('#editing_working_hour').slideUp();
        $('#opening-daily').slideUp('fast');
        $('#opening-flexible').slideUp('fast');
        $('input[name=opening_type]').prop('checked', false);
        $('#opening-type label').removeClass('active');
    });

    $('#editCategory').click(function () {
        $('#editing_category').slideDown();
    });
    $('#editCategoryCancel').click(function () {
        $('#editing_category').slideUp();
        $('input[name=category]').prop('selected', false);
    });


    $('#editArea').click(function () {
        $('#editing_area').slideDown();
    });
    $('#editAreaCancel').click(function () {
        $('#editing_area').slideUp();
        $('input[name=area]').prop('selected', false);
    });

    $('#lat-lng-no').click(function () {
        $('#lat-lng').slideDown('fast');
    });
    $('#lat-lng-yes').click(function () {
        $('#lat-lng').slideUp('fast');
    });
    $('#opening-daily-show').click(function () {
        $('#opening-daily').slideDown('fast');
        $('#opening-flexible').slideUp('fast');
    });
    $('#opening-flexible-show').click(function () {
        $('#opening-flexible').slideDown('fast');
        $('#opening-daily').slideUp('fast');
    });
    $('#daily-flexible-hide').click(function () {
        $('#opening-daily').slideUp('fast');
        $('#opening-flexible').slideUp('fast');
    });
    $('#delivery-hours-daily-show').click(function () {
        $('#delivery-hours-daily').slideDown('fast');
    });
    $('#delivery-hours-daily-hide').click(function () {
        $('#delivery-hours-daily').slideUp('fast');
    });
    $('#collection-hours-daily-show').click(function () {
        $('#collection-hours-daily').slideDown('fast');
    });
    $('#collection-hours-daily-hide').click(function () {
        $('#collection-hours-daily').slideUp('fast');
    });
    $('#future-orders-days-show').click(function () {
        $('#future-orders-days').slideDown('fast');
    });
    $('#future-orders-days-hide').click(function () {
        $('#future-orders-days').slideUp('fast');
    });
    $('#special_toggle_hide').click(function () {
        $('#special-toggle').slideUp('fast');
    });
    $('#special_toggle_show').click(function () {
        $('#special-toggle').slideDown('fast');
    });



    $('#delete_language').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url: "/language/delete",
            data: {id: checkValues, _token: token},
            success: function (data) {

                window.location.reload();
            }

        });

    });

    $('#delete_review').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url: "/review/delete",
            data: {id: checkValues, _token: token},
            success: function (data) {

                window.location.reload();
            }

        });

    });

    $('#delete_mealtime').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url: "/mealtime/delete",
            data: {id: checkValues, _token: token},
            success: function (data) {

                window.location.reload();
            }

        });

    });

    $('#delete_collection').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url: "/collection/delete",
            data: {id: checkValues, _token: token},
            success: function (data) {

                window.location.reload();
            }

        });

    });


    $('#delete_collection_category').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url: "/collection_category/delete",
            data: {id: checkValues, _token: token},
            success: function (data) {

                window.location.reload();
            }

        });

    });

    $('#delete_restaurant_category').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url: "/restaurant_category/delete",
            data: {id: checkValues, _token: token},
            success: function (data) {

                window.location.reload();
            }

        });

    });

    $('#delete_restaurant').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url: "/restaurant/delete",
            data: {id: checkValues, _token: token},
            success: function (data) {

                window.location.reload();
            }

        });

    });
    $('#delete_area').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url: "/area/delete",
            data: {id: checkValues, _token: token},
            success: function (data) {

                window.location.reload();
            }

        });

    });
    $('#delete_menu_category').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url: "/menu_category/delete",
            data: {id: checkValues, _token: token},
            success: function (data) {

                window.location.reload();
            }

        });

    });

    $('#edit_menu_category_reject').click(function () {
        window.checkValues = $('input[name=edit_menu_category]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);
        $.ajax({

            method: "POST",
            url: "/menu_category/edit_reject",
            data: {id: checkValues, _token: token},
            success: function (data) {

                // window.location.reload();
            }

        });

    });

    $('#delete_customer').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url: "/customer/delete",
            data: {id: checkValues, _token: token},
            success: function (data) {

                window.location.reload();
            }

        });

    });
    $('#delete_menu').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url: "/menu/delete",
            data: {id: checkValues, _token: token},
            success: function (data) {

                window.location.reload();
            }

        });

    });

    $('#delete_status').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url: "/status/delete",
            data: {id: checkValues, _token: token},
            success: function (data) {

                window.location.reload();
            }

        });

    });

    $('#delete_order').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url: "/order/delete",
            data: {id: checkValues, _token: token},
            success: function (data) {

                window.location.reload();
            }

        });

    });




    $('.timepicker').timepicker({
        defaultTime: '11:45 AM'
    });


    $('#delivery-areas select.form-control').select2({
        minimumResultsForSearch: Infinity
    });

    $('input[name="auto_lat_lng"]').on('change', function () {
        $('#lat-lng').slideDown('fast');
        if (this.value == '1') {
            $('#lat-lng').slideUp('fast');
        }
    });

    $('input[name="opening_type"]').on('change', function () {
        if (this.value == '24_7') {
            $('#opening-daily').slideUp('fast');
            $('#opening-flexible').slideUp('fast');
        }
        if (this.value == 'daily') {
            $('#opening-flexible').slideUp('fast');
            $('#opening-daily').slideDown('fast');
        }
        if (this.value == 'flexible') {
            $('#opening-daily').slideUp('fast');
            $('#opening-flexible').slideDown('fast');
        }
    });

    $('input[name="delivery_type"]').on('change', function () {
        if (this.value == '0') {
            $('#delivery-hours-daily').slideUp('fast');
        }
        if (this.value == '1') {
            $('#delivery-hours-daily').slideDown('fast');
        }
    });

    $('input[name="collection_type"]').on('change', function () {
        if (this.value == '0') {
            $('#collection-hours-daily').slideUp('fast');
        }
        if (this.value == '1') {
            $('#collection-hours-daily').slideDown('fast');
        }
    });

    $('input[name="future_orders"]').on('change', function () {
        $('#future-orders-days').slideUp('fast');
        if (this.value == '1') {
            $('#future-orders-days').slideDown('fast');
        }
    });

    $(document).on('click', '.btn-add-condition', function () {
        var panelRow = $(this).attr('data-panel-row');
        var tableRow = $(this).attr('data-table-row');
        tableRow++;
        addDeliveryCondition(panelRow, tableRow);
        $(this).attr('data-table-row', tableRow);
    });

    $(document).on('change', '#delivery-areas select.form-control', function () {
        $(this).parent().parent().find('input.total').attr('disabled', false);
        if (this.value == 'all') {
            $(this).parent().parent().find('input.total').val('0');
            $(this).parent().parent().find('input.total').attr('disabled', true);
        }
    });
    $('#delivery-areas select.form-control').trigger('change');
});