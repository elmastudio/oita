jQuery(document).ready(function($) {
    $('#colorpicker1').hide();
    $('#colorpicker1').farbtastic('#link-color');

    $('#link-color').click(function() {
        $('#colorpicker1').show();
    });

    $(document).mousedown(function() {
        $('#colorpicker1').each(function() {
            var display = $(this).css('display');
            if ( display == 'block' )
                $(this).hide();
        });
    });
});

jQuery(document).ready(function($) {
    $('#colorpicker3').hide();
    $('#colorpicker3').farbtastic('#extrafont-color');

    $('#extrafont-color').click(function() {
        $('#colorpicker3').show();
    });

    $(document).mousedown(function() {
        $('#colorpicker3').each(function() {
            var display = $(this).css('display');
            if ( display == 'block' )
                $(this).hide();
        });
    });
});


jQuery(document).ready(function($) {
    $('#colorpicker2').hide();
    $('#colorpicker2').farbtastic('#sidebarbg-color');

    $('#sidebarbg-color').click(function() {
        $('#colorpicker2').show();
    });

    $(document).mousedown(function() {
        $('#colorpicker2').each(function() {
            var display = $(this).css('display');
            if ( display == 'block' )
                $(this).hide();
        });
    });
});

jQuery(document).ready(function($) {
    $('#colorpicker4').hide();
    $('#colorpicker4').farbtastic('#bg-color');

    $('#bg-color').click(function() {
        $('#colorpicker4').show();
    });

    $(document).mousedown(function() {
        $('#colorpicker4').each(function() {
            var display = $(this).css('display');
            if ( display == 'block' )
                $(this).hide();
        });
    });
});