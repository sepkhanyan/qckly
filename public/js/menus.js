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


});