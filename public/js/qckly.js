$(document).ready(function () {

    var token = $('[name=csrf-token]').attr('content');


    $("a#select-image").on("click", function () {


        $.post("/image/manager", function (data) {

            $("#media-manager").html(data).fadeIn();

        });//Put the code from above here.

    });



    $('#input_restaurant_telephone').on('keypress', function(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
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


    $('#delete_language').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);
        if(checkValues.length > 0){
            var choice = confirm("Are you sure you want to delete?");

            if (choice) {
                $.ajax({

                    method: "POST",
                    url: "/language/delete",
                    data: {id: checkValues, _token: token},
                    success: function (data) {

                        window.location.reload();
                    }

                });
            }

        }else{
            alert("Select language!");
        }

    });

    $('#delete_review').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);
        if(checkValues.length > 0){
            var choice = confirm("Are you sure you want to delete?");

            if (choice) {
                $.ajax({

                    method: "POST",
                    url: "/review/delete",
                    data: {id: checkValues, _token: token},
                    success: function (data) {

                        window.location.reload();
                    }

                });
            }

        }else{
            alert("Select review!");
        }


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
        if(checkValues.length > 0){
            var choice = confirm("Are you sure you want to delete?");

            if (choice) {
                $.ajax({

                    method: "POST",
                    url: "/customer/delete",
                    data: {id: checkValues, _token: token},
                    success: function (data) {

                        window.location.reload();
                    }

                });
            }

        }else{
            alert("Select customer!");
        }



    });
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

    $('#delete_status').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);
        if(checkValues.length > 0){
            var choice = confirm("Are you sure you want to delete?");

            if (choice) {
                $.ajax({

                    method: "POST",
                    url: "/status/delete",
                    data: {id: checkValues, _token: token},
                    success: function (data) {

                        window.location.reload();
                    }

                });
            }

        }else{
            alert("Select status!");
        }


    });

    $('#delete_order').click(function () {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);
        if(checkValues.length > 0){
            var choice = confirm("Are you sure you want to delete?");

            if (choice) {
                $.ajax({

                    method: "POST",
                    url: "/order/delete",
                    data: {id: checkValues, _token: token},
                    success: function (data) {

                        window.location.reload();
                    }

                });
            }

        }else{
            alert("Select order!");
        }


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