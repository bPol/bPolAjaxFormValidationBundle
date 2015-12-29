

var ajaxValidator = (function() {

    var that = {};

    var validatorQuery = function(element) {

        var $this = $(element);
        var type = $this.data('validator');
        var $passwords = null;

        var data = {
            'value': $this.val()
        };

        if ('confirm' == type) {
            $passwords = $this.parents('form').find('input[type="password"]');
            data['password']  = $passwords.eq(0).val();
            data['confirm'] = $passwords.eq(1).val();
        }


        $.ajax({
            url: '/ajax/form/validator/' + type,
            data: data,
            method: 'post',
            dataType: 'json',
            statusCode: {
                200: function(rsp) {

                    $this.removeClass('input-success');
                    $this.addClass('input-error');

                    $this.popover({
                        'placement':'right',
                        'trigger': 'hover',
                        'content': rsp.errors[0]
                    });
                },
                204: function() {
                    $this.removeClass('input-error');
                    $this.addClass('input-success');
                    $this.popover('destroy');
                }
            }
        })
    };


    that.init = (function() {

        var timeout;

        $('input[data-validator]').on('keyup blur focus', function() {

            clearTimeout(timeout);
            timeout = setTimeout(validatorQuery($(this)), 400);
        });

        $('select[data-validator]').on('change blur focus', function() {

            clearTimeout(timeout);
            timeout = setTimeout(validatorQuery($(this)), 400);
        });
    });

    return that;
})();

$(function() {

    ajaxValidator.init();
});