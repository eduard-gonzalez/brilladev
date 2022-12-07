jQuery(function($){
 /* bunny cdn on video ended */
    var video =  $('#video-lesson > .responsive-iframe > iframe > html > body > div#videocontainer > div#video > div > div > video');
    /* jquery on event video ended */
    video.on('ended', function() {
        alert('video ended');
    });
    /* on click jquery oprevent */
    $('.thim-login-popup > .login').on('click', function(e) {
        $('div#thim-popup-login').hide();
        window.location.href = "/iniciar-sesion/";
    });
    $('.thim-login-popup > .register').on('click', function(e) {
        $('div#thim-popup-login').hide();
        window.location.href = "/registro/";
    });
    $('#reg_billing_dni').mask('00000000');
    $('#billing_dni').mask('00000000');
    
    $(document.body).on('change', 'select.country_to_state, input.country_to_state', function(){
        var country = $(this).val();
        var $statebox = $('#reg_billing_state');
        var input_name = $statebox.attr('name');
        var input_id = $statebox.attr('id');
        var value = $statebox.val();
        var placeholder = $statebox.attr('placeholder') || $statebox.attr('data-placeholder') || '';
        if (typeof wc_country_select_params === "undefined")
            return false;
        $.ajax({
            type: 'POST',
            url: wc_country_select_params.ajax_url,
            data: {
                action: 'woocommerce_get_country_state_field',
                security: wc_country_select_params.countries_nonce,
                country: country,
                input_name: input_name,
                input_id: input_id,
                value: value,
                placeholder: placeholder
            },
            success: function (code) {
                if (code) {
                    $statebox.parent().replaceWith(code);
                } else {
                    $statebox.parent().find('.select2-container').remove();
                    $statebox.replaceWith('<input type="text" class="input-text" name="' + input_name + '" id="' + input_id + '" placeholder="' + placeholder + '" />');
                }
            }
        });
        return false;
    });
});