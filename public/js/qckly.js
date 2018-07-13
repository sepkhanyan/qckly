$(document).ready(function() {

    var token = $('[name=csrf-token]').attr('content');
    // $('body').on('click', '#button_add_area', function() {
    //     $('#addNote').modal('show');
    //     var type = $(this).attr('data-type');
    //     $.ajax({
    //         url: '/areas/store/' + type,
    //         method: 'GET',
    //         success: function(result) {
    //
    //         }
    //     })
    // });




    $("a#select-image").on("click", function(){


        $.post("/image/manager", function(data){

            $("#media-manager").html(data).fadeIn();

        });//Put the code from above here.

    });
    $('#lat-lng-no').click(function() {
        $('#lat-lng'). slideDown('fast');
    });
    $('#lat-lng-yes').click(function() {
        $('#lat-lng'). slideUp('fast');
    });
    $('#opening-daily-show').click(function() {
        $('#opening-daily'). slideDown('fast');
        $('#opening-flexible'). slideUp('fast');
    });
    $('#opening-flexible-show').click(function() {
        $('#opening-flexible'). slideDown('fast');
        $('#opening-daily'). slideUp('fast');
    });
    $('#daily-flexible-hide').click(function() {
        $('#opening-daily'). slideUp('fast');
        $('#opening-flexible'). slideUp('fast');
    });
    $('#delivery-hours-daily-show').click(function() {
        $('#delivery-hours-daily'). slideDown('fast');
    });
    $('#delivery-hours-daily-hide').click(function() {
        $('#delivery-hours-daily'). slideUp('fast');
    });
    $('#collection-hours-daily-show').click(function() {
        $('#collection-hours-daily'). slideDown('fast');
    });
    $('#collection-hours-daily-hide').click(function() {
        $('#collection-hours-daily'). slideUp('fast');
    });
    $('#future-orders-days-show').click(function() {
        $('#future-orders-days'). slideDown('fast');
    });
    $('#future-orders-days-hide').click(function() {
        $('#future-orders-days'). slideUp('fast');
    });
    $('#special_toggle_hide').click(function() {
        $('#special-toggle'). slideUp('fast');
    });
    $('#special_toggle_show').click(function() {
        $('#special-toggle'). slideDown('fast');
    });


    $('#subcategory').change(function(){
        if ($(this).val() == 3)
        {
            $('#menu_item').attr('multiple','multiple');
        }
        else
        {
            $('#menu_item').removeAttr('multiple');
        }
    });

    $('#subcategory').click(function() {
        $('#items'). slideDown('fast');
        if($('select[name=subcategory]').val() == 1){
            $('#by_person'). slideDown('fast');
            $('#max_qty'). slideDown('fast');
            $('#min_qty'). slideDown('fast');
            $('#add_item'). slideUp('fast');
        }else if($('select[name=subcategory]').val() == 2){
            $('#max_qty'). slideDown('fast');
            $('#min_qty'). slideDown('fast');
            $('#by_person'). slideUp('fast');
            $('#add_item'). slideUp('fast');
        }else if($('select[name=subcategory]').val() == 3){
            $('#max_qty'). slideDown('fast');
            $('#min_qty'). slideDown('fast');
            $('#by_person'). slideUp('fast');
            $('#add_item'). slideUp('fast');
        }else if($('select[name=subcategory]').val() == 4){
            $('#max_qty'). slideDown('fast');
            $('#min_qty'). slideDown('fast');
            $('#by_person'). slideUp('fast');
            $('#add_item'). slideDown('fast');
        }

    });

    $("#add_item").click(function(){
        var original = $(".js-select");
        var clone = original.clone();
        clone.select2();
        $("#menu_item").clone().appendTo("#item");
    });






    $('#delete_collection').click(function() {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url:"/delete/collection",
            data:{id:checkValues,_token:token },
            success:function(data){

                window.location.reload();
            }

        });

    });

    $('#delete_menu_subcategory').click(function() {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url:"/delete/menu_subcategory",
            data:{id:checkValues,_token:token },
            success:function(data){

                window.location.reload();
            }

        });

    });

    $('#delete_restaurant_category').click(function() {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url:"/delete/restaurant_category",
            data:{id:checkValues,_token:token },
            success:function(data){

                window.location.reload();
            }

        });

    });

    $('#delete_restaurant').click(function() {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


            $.ajax({

                method: "POST",
                url:"/delete/restaurants",
                data:{id:checkValues,_token:token },
                success:function(data){

                    window.location.reload();
                }

            });

    });
    $('#delete_area').click(function() {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url:"/delete/areas",
            data:{id:checkValues,_token:token },
            success:function(data){

                window.location.reload();
            }

        });

    });
    $('#delete_category').click(function() {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url:"/delete/categories",
            data:{id:checkValues,_token:token },
            success:function(data){

                window.location.reload();
            }

        });

    });
    $('#delete_customer').click(function() {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url:"/delete/customers",
            data:{id:checkValues,_token:token },
            success:function(data){

                window.location.reload();
            }

        });

    });
    $('#delete_menu').click(function() {
        window.checkValues = $('input[name=delete]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log(checkValues);


        $.ajax({

            method: "POST",
            url:"/delete/menus",
            data:{id:checkValues,_token:token },
            success:function(data){

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

            // $('.timepicker').timepicker({
            //     defaultTime: '11:45 AM'
            // });

            $('input[name="auto_lat_lng"]').on('change', function() {
                $('#lat-lng').slideDown('fast');

                if (this.value == '1') {
                    $('#lat-lng').slideUp('fast');
                }
            });

            $('input[name="opening_type"]').on('change', function() {
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

            $('input[name="delivery_type"]').on('change', function() {
                if (this.value == '0') {
                    $('#delivery-hours-daily').slideUp('fast');
                }

                if (this.value == '1') {
                    $('#delivery-hours-daily').slideDown('fast');
                }
            });

            $('input[name="collection_type"]').on('change', function() {
                if (this.value == '0') {
                    $('#collection-hours-daily').slideUp('fast');
                }

                if (this.value == '1') {
                    $('#collection-hours-daily').slideDown('fast');
                }
            });

            $('input[name="future_orders"]').on('change', function() {
                $('#future-orders-days').slideUp('fast');

                if (this.value == '1') {
                    $('#future-orders-days').slideDown('fast');
                }
            });

            $(document).on('click', '.btn-add-condition', function() {
                var panelRow = $(this).attr('data-panel-row');
                var tableRow = $(this).attr('data-table-row');

                tableRow++;
                addDeliveryCondition(panelRow, tableRow);

                $(this).attr('data-table-row', tableRow);
            });

            $(document).on('change', '#delivery-areas select.form-control', function() {
                $(this).parent().parent().find('input.total').attr('disabled', false);

                if (this.value == 'all') {
                    $(this).parent().parent().find('input.total').val('0');
                    $(this).parent().parent().find('input.total').attr('disabled', true);
                }
            });

            $('#delivery-areas select.form-control').trigger('change');
        
});