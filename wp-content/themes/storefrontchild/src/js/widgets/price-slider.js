jQuery(document).ready(function($){

    $( document.body ).bind( 'price_slider_create price_slider_slide', function( event, min, max ) {

        $( '#amount-floor' ).html( accounting.formatMoney( min, {
            symbol:    woocommerce_price_slider_params.currency_format_symbol,
            decimal:   woocommerce_price_slider_params.currency_format_decimal_sep,
            thousand:  woocommerce_price_slider_params.currency_format_thousand_sep,
            precision: woocommerce_price_slider_params.currency_format_num_decimals,
            format:    woocommerce_price_slider_params.currency_format
        } ) );

        $( '#amount-ceil' ).html( accounting.formatMoney( max, {
            symbol:    woocommerce_price_slider_params.currency_format_symbol,
            decimal:   woocommerce_price_slider_params.currency_format_decimal_sep,
            thousand:  woocommerce_price_slider_params.currency_format_thousand_sep,
            precision: woocommerce_price_slider_params.currency_format_num_decimals,
            format:    woocommerce_price_slider_params.currency_format
        } ) );

        $( document.body ).trigger( 'price_slider_updated', [ min, max ] );
    });

    // slider for price range
    $( function() {
        var min_price         = $( '#amount-floor' ).data( 'min' ),
            max_price         = $( '#amount-ceil' ).data( 'max' ),
            step              = $( '.price_slider_amount' ).data( 'step' ) || 1,
            current_min_price = $( '#amount-floor' ).val(),
            current_max_price = $( '#amount-ceil' ).val();
        $( "#slider-range" ).slider({
            // step:step,
            range: true,
            min: min_price,
            max: max_price,
            values: [ current_min_price, current_max_price ],

            slide: function( event, ui ) {

                $( "#amount-floor" ).val(ui.values[ 0 ] );
                $( "#amount-ceil" ).val( ui.values[ 1 ]);
            }
        });
        $( "#amount-floor" ).val($( "#slider-range" ).slider( "values", 0 ) );
        $( "#amount-ceil" ).val( $( "#slider-range" ).slider( "values", 1 ) );
    } );

    // filter price range
    $( "#slider-range" ).on( "slidechange", function( event, ui ) {
        var range_min = ui.values[ 0 ];
        var range_max = ui.values[ 1 ];

        var url = prepareFilteredLink({
            min_price: ui.values[0],
            max_price: ui.values[1]
        });
        // window.history.pushState('', '', url);
        window.location.href = url;
        console.log(url);
        return;
        $.ajax({
            url: myajax.url,
            type: 'POST',
            data: {
                action : 'choose_price_range',
                status : 'publish',
                range_min : range_min,
                range_max : range_max,
            },
            beforeSend: function (xhr) {
                $('.sk-circle-bounce').css({
                    display:'block'
                });
            },
            success: function (result) {
                $('.sk-circle-bounce').css({
                    display:'none'
                });
                if (result === '') {
                    $('.products.columns-3.grid').html("<div class='no-result col-xs-12'><p>No result</p></div>");
                } else {
                    $('.products.columns-3.grid').html(result);
                }
            }
        });
        return false;
    });

    // reset price range filter



    $('.widget.widget_price_range_widget').find( '.fas.fa-times' ).on( 'click' , function(event){
        // var url = prepareFilteredLink({
        //     min_price: 0,
        //     max_price: 0,
        // });
        // window.history.pushState('', '', url);
        // console.log(url);
        // return;

        // $.ajax({
        //     url: myajax.url,
        //     type: 'POST',
        //     data: {
        //         action : 'reset_price_range_filter',
        //         status : 'publish',
        //     },
        //     beforeSend: function (xhr) {
        //         $('.sk-circle-bounce').css({
        //             display:'block'
        //         });
        //     },
        //     success: function (result) {
        //         $('.sk-circle-bounce').css({
        //             display:'none'
        //         });
        //         $( "#slider-range" ).slider("values", [ 0, 500 ]);
        //         $( "#amount-floor" ).val( "$" + 0 );
        //         $( "#amount-ceil" ).val( "$" + 500 );
        //         if (result === '') {
        //             $('.products.columns-3.grid').html("<div class='no-result col-xs-12'><p>No result</p></div>");
        //         } else {
        //             $('.products.columns-3.grid').html(result);
        //         }
        //     }
        // });
        // return false;
    });
});
