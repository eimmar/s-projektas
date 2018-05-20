function updateVisitArrangement(visitContainer) {

    var form = visitContainer.find('#visit-arrangement');
    var data = form.serializeObject();
    visitContainer.addClass('form-loading');

    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        dataType: 'json',
        data: data,
        success: function(response) {
            if (response.success) {
                var newForm = $('.form-content-container', $(response.html));
                visitContainer.html(newForm);
            }
            visitContainer.removeClass('form-loading');
        }
    });
}

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

$(document).ready(function () {
    $('.address-type').collection();

    var visitContainer = $('.visit-arrangement-outer');
    visitContainer.on('change', 'select', function() {
        updateVisitArrangement(visitContainer);
    });

    visitContainer.on('click', '.remove-visit-item', function () {
        var visitItem = $(this).closest('.visit-item');
        if (confirm(visitItem.attr('data-confirm-msg'))) {
            visitItem.remove();
            updateVisitArrangement(visitContainer);
        }
    });

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
