$(document).ready(function () {
    $('.address-type').collection();

    $.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    var visitForm = $('#visit-arrangement');
    visitForm.on('change', 'select', function() {

        var data = visitForm.serializeObject();
        visitForm.addClass('form-loading');

        $.ajax({
            url: visitForm.attr('action'),
            type: visitForm.attr('method'),
            dataType: 'json',
            data: data,
            success: function(response) {
                if (response.success) {
                    var newForm = $('.form-content-container', $(response.html));
                    visitForm.html(newForm);
                }
                visitForm.removeClass('form-loading');
            }
        });
    });


    $('.visit-service-type').collection();

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
