$(document).ready(function () {
    $('.address-type').collection();

    //TODO: Vehicle form based on manufacturer
    // $(function () {
    //     var manufacturer = $('#vehicle_manufacturer');
    //
    //     manufacturer.change(function() {
    //         var form = $(this).closest('form');
    //         var data = {};
    //         data[manufacturer.attr('name')] = manufacturer.val();
    //
    //         $.ajax({
    //             url : form.attr('action'),
    //             type: form.attr('method'),
    //             data : data,
    //             success: function(html) {
    //                 // Replace current position field ...
    //                 $('#vehicle_model').replaceWith(
    //                     $(html).find('#vehicle_model')
    //                 );
    //             }
    //         });
    //     });
    // });

});
