jQuery(document).ready(function($){

// choose size filter
$('.woocommerce-widget-layered-nav-list').find('li').find('a').on('click', function(event){
   event.stopPropagation();
   event.preventDefault();

    // window.history.pushState('', '', this.href);
    window.location.href = this.href;
    // console.log(this.href);
    return;


   // console.log(url);
   // $.ajax({
   //    url: myajax.url,
   //    type: 'POST',
   //    data: {
   //       action : 'choose_color_size_filter',
   //       status : 'publish',
   //       // color : color,
   //       url : url,
   //    },
   //    beforeSend: function (xhr) {
   //
   //       $('.sk-circle-bounce').css({
   //          display:'block'
   //       });
   //    },
   //    success: function (result) {
   //       $('.sk-circle-bounce').css({
   //          display:'none'
   //       });
   //       if (result === '') {
   //          $('.products.columns-3').html("<div class='no-result col-xs-12'><p>No result</p></div>");
   //       } else {
   //          $('.products.columns-3').html(result);
   //       }
   //    }
   // });
   return false;
});
// reset size filter
$('#woocommerce_layered_nav-5').find( '.fas.fa-times' ).on( 'click' , function(event){
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