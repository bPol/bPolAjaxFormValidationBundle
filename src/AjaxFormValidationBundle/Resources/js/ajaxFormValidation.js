

var ajaxValidator = (function() {

    var that = {};

    var validatorQuery = function(element) {

        var $this = $(element);
        var type = $this.data('validator');

        $.ajax({
            url: '/ajax/form/validator/' + type,
            data: {'value':$this.val()},
            method: 'post',
            dataType: 'json',
            success: function() {
                $this.removeClass('input-error');
                $this.addClass('input-success');
                $this.data('content', '');
                $this.popover('destroy');
            },
            error: function(xhr) {
                var rsp = $.parseJSON(xhr.responseText);

                $this.removeClass('input-success');
                $this.addClass('input-error');

                $this.data('content', rsp.errors[0]);
                $this.popover({
                    'placement':'right',
                    'trigger': 'hover'
                });
            }
        })
    };


    that.init = (function() {

        var timeout;

        $('input[data-validator]').on('keyup blur focus', function() {

            clearTimeout(timeout);
            timeout = setTimeout(validatorQuery($(this)), 300);
        });

        $('select[data-validator]').on('change blur focus', function() {

            clearTimeout(timeout);
            timeout = setTimeout(validatorQuery($(this)), 300);
        });
    });

    return that;
})();

$(function() {

    ajaxValidator.init();
});