jQuery(document).ready(function($){
    // choose color filter
    $('.yith-wcan-color.yith-wcan.yith-wcan-group').find('li').find('a').on('click', function(event){
        event.stopPropagation();
        event.preventDefault();

        window.history.pushState('', '', this.href);
        console.log(this.href);

        window.location.href = this.href;
        return;

        $.ajax({
            url: myajax.url,
            type: 'POST',
            data: {
                action : 'choose_color_size_filter',
                status : 'publish',
                // color : color,
                url : url,
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
                    $('.products.columns-3').html("<div class='no-result col-xs-12'><p>No result</p></div>");
                } else {
                    $('.products.columns-3').html(result);
                }
            }
        });
        return false;
    });

    // reset color filter
    $('widget.yith-woocommerce-ajax-product-filter.yith-woo-ajax-navigation.woocommerce.widget_layered_nav').find( '.fas.fa-times' ).on( 'click' , function(event){

        //
        // $.ajax({
        //     url: myajax.url,
        //     type: 'POST',
        //     data: {
        //         action : 'reset_color_size_filter',
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