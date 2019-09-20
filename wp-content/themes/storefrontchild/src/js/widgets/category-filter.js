jQuery(document).ready(function($){

    //chose categories

    $('.product-categories').find('.cat-item').find('a').on('click', function(event){
       event.stopPropagation();
       event.preventDefault();
        // window.history.pushState('', '', this.href);
        window.location.href = this.href;
        // console.log(this.href);

        return;

       var cat_id=$(this).attr("id");
       console.log(cat_id);
       $.ajax({
          url: myajax.url,
          type: 'POST',
          data: {
             action : 'choose_filter',
             status : 'publish',
             cat_id : cat_id,
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

    // reset categories filter
    $('#woocommerce_product_categories-3').find( '.fas.fa-times' ).on( 'click' , function(event){
    //     $.ajax({
    //         url: myajax.url,
    //         type: 'POST',
    //         data: {
    //             action : 'reset_cat_filter',
    //             status : 'publish',
    //         },
    //         beforeSend: function (xhr) {
    //             $('.sk-circle-bounce').css({
    //                 display:'block'
    //             });
    //         },
    //         success: function (result) {
    //             $('.sk-circle-bounce').css({
    //                 display:'none'
    //             });
    //             if (result === '') {
    //                 $('.products.columns-3.grid').html("<div class='no-result col-xs-12'><p>No result</p></div>");
    //             } else {
    //                 $('.products.columns-3.grid').html(result);
    //             }
    //         }
    //     });
    //     return false;
    });
});