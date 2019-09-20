//Tools

jQuery('.woocommerce-widget-layered-nav-list').wrap('<div style="display: none"></div>');
jQuery('.woocommerce-widget-layered-nav-list').addClass('ready');
jQuery(document).ready(function($){

   $('.carousel-inner').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      arrows: false,

   });

   if ($(window).width() <= '414'){

      $('#Category--List').slick({
         slidesToShow: 1,
         slidesToScroll: 1,
         autoplay: false,
         arrows: true,
         prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
         nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
      });
   }else if ($(window).width() <= '500'){

      $('#Category--List').slick({
         slidesToShow: 2,
         slidesToScroll: 2,
         autoplay: false,
         arrows: true,
         prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
         nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
      });
   }else if ($(window).width() <= '768'){

      $('#Category--List').slick({
         slidesToShow: 3,
         slidesToScroll: 3,
         autoplay: false,
         arrows: true,
         prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
         nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
      });
   }else if ($(window).width() <= '1600'){

      $('#Category--List').slick({
         slidesToShow: 6,
         slidesToScroll: 6,
         autoplay: false,
         arrows: true,
         prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
         nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
      });
   }




   $('.category_item').on( 'click' , function(event){

      var categorySlug = $(this).attr('data-categorySlug'),
          response = '';

      $(this).parent().find('li').removeClass('active');
      $(this).addClass('active');


      $.ajax({
         url: myajax.url,
         type: 'POST',
         data: {
            action : 'choose_category',
            categorySlug : categorySlug
         },
         beforeSend: function (xhr) {
            $('#category_list').empty();
            $('.sk-circle-bounce').css({
               display:'block'
            });
         },
         success: function (result) {
            // response = $.parseJSON(result);
            $('.sk-circle-bounce').css({
               display:'none'
            });

            if (result === '') {
               $('#category_list').html("<div class='no-result col-xs-12'><p>No result</p></div>");
            } else {
               $('#category_list').html(result);
            }

         }
      });
      return false;

   });

   $('.open-close-menu').on( 'click' , function(event){
        $('body').toggleClass('show-menu');
   });

// show input search
//    $('.search_container').find('.search').on( 'click' , function(event){
//       // $('.search-form-control').toggleClass('show-search');
//       $('.search_container').toggleClass('show-input');
//    });

   // stop following the menu header link
   $('#menu-header_catalog_menu').find('.menu-item').find('a').on('click' , function (event){
      if ($('#menu-header_catalog_menu').find('.menu-item').find('.sub-menu')){
         event.stopPropagation();
         event.preventDefault();
      }
   });


   $('.view-all').on( 'click' , function(event){

      $(this).toggleClass('active');
      $.ajax({
         url: myajax.url,
         type: 'POST',
         data: {
            action : 'show_all',
            status : 'publish',
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


//Show per page
//    $('.choose-per-page').find('option').on ('click', function(event){
//       var show_per_page =
//       $.ajax({
//          url: myajax.url,
//          type: 'POST',
//          data: {
//             action : 'choose_filter',
//             status : 'publish',
//             cat_id : cat_id,
//          },
//          beforeSend: function (xhr) {
//
//             $('.sk-circle-bounce').css({
//                display:'block'
//             });
//          },
//          success: function (result) {
//             $('.sk-circle-bounce').css({
//                display:'none'
//             });
//             if (result === '') {
//                $('.products.columns-3').html("<div class='no-result col-xs-12'><p>No result</p></div>");
//             } else {
//                $('.products.columns-3').html(result);
//             }
//          }
//       });
//       return false;
//    });

// slideup/slidedown for filter
   $(document).on( 'click', '.gamma.widget-title', function(event) {
      $(this).parent().next().slideToggle('slow');
      $(this).toggleClass('reset');
   });

// reset filters (color, size, category)
   $('#secondary').delegate( '.fas.fa-times', 'click' ,  function(event) {
      var $widgetContainer = $(this).parent().parent();
      if($widgetContainer.hasClass('widget_product_categories')){
         // reset category
         var url = prepareFilteredLink({
            product_cat: 0,
         });


      } else if($widgetContainer.hasClass('widget_price_range_widget')) {
         // reset price range
         // console.log($widgetContainer.hasClass('widget_price_range_widget'));
         url = prepareFilteredLink({
            min_price: 0,
            max_price: 0,
         });

      } else if($widgetContainer.find('.woocommerce-widget-layered-nav-list .wc-layered-nav-term').length > 0) {
         // reset size
         // console.log($widgetContainer.find('.woocommerce-widget-layered-nav-list .wc-layered-nav-term').length);
         url = prepareFilteredLink({
            filter_size: 0,
         });

      } else if($widgetContainer.find('.yith-wcan-color').length > 0){
         // reset color
         console.log($widgetContainer.find('.yith-wcan-color').length);
         url = prepareFilteredLink({
            filter_color: 0,
         });
      }
      console.log(url);
      window.history.pushState('', '', url);

      return;
   });

// slick-slider for footer
   $('.footer-carousel-inner').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      arrows: false,
   });

// slick-slider for brands footer

   if ($(window).width() <= '640'){
      $('.brands-carousel-inner').slick({
         slidesToShow: 2,
         slidesToScroll: 1,
         autoplay: false,
         arrows: true,
         prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
         nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
      });
   }
   if ($(window).width() <= '768'){
      $('.brands-carousel-inner').slick({
         slidesToShow: 3,
         slidesToScroll: 1,
         autoplay: false,
         arrows: true,
         prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
         nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
      });
   }
   if ($(window).width() <= '1600'){
      $('.brands-carousel-inner').slick({
         slidesToShow: 4,
         slidesToScroll: 1,
         autoplay: false,
         arrows: true,
         prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
         nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
      });
   }
   if ($(window).width() > '1600'){
      $('.brands-carousel-inner').slick({
         slidesToShow: 5,
         slidesToScroll: 1,
         autoplay: false,
         arrows: true,
         prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
         nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
      });
   }






});

/*! (c) Andrea Giammarchi - ISC */
var self=this||{};try{!function(t,n){if(new t("q=%2B").get("q")!==n||new t({q:n}).get("q")!==n||new t([["q",n]]).get("q")!==n||"q=%0A"!==new t("q=\n").toString()||"q=+%26"!==new t({q:" &"}).toString())throw t;self.URLSearchParams=t}(URLSearchParams,"+")}catch(t){!function(t,a,o){"use strict";var u=t.create,h=t.defineProperty,n=/[!'\(\)~]|%20|%00/g,e=/\+/g,r={"!":"%21","'":"%27","(":"%28",")":"%29","~":"%7E","%20":"+","%00":"\0"},i={append:function(t,n){l(this._ungap,t,n)},delete:function(t){delete this._ungap[t]},get:function(t){return this.has(t)?this._ungap[t][0]:null},getAll:function(t){return this.has(t)?this._ungap[t].slice(0):[]},has:function(t){return t in this._ungap},set:function(t,n){this._ungap[t]=[a(n)]},forEach:function(n,e){var r=this;for(var i in r._ungap)r._ungap[i].forEach(t,i);function t(t){n.call(e,t,a(i),r)}},toJSON:function(){return{}},toString:function(){var t=[];for(var n in this._ungap)for(var e=g(n),r=0,i=this._ungap[n];r<i.length;r++)t.push(e+"="+g(i[r]));return t.join("&")}};for(var s in i)h(c.prototype,s,{configurable:!0,writable:!0,value:i[s]});function c(t){var n=u(null);switch(h(this,"_ungap",{value:n}),!0){case!t:break;case"string"==typeof t:"?"===t.charAt(0)&&(t=t.slice(1));for(var e=t.split("&"),r=0,i=e.length;r<i;r++){var a=(s=e[r]).indexOf("=");-1<a?l(n,p(s.slice(0,a)),p(s.slice(a+1))):s.length&&l(n,p(s),"")}break;case o(t):for(r=0,i=t.length;r<i;r++){var s;l(n,(s=t[r])[0],s[1])}break;case"forEach"in t:t.forEach(f,n);break;default:for(var c in t)l(n,c,t[c])}}function f(t,n){l(this,n,t)}function l(t,n,e){var r=o(e)?e.join(","):e;n in t?t[n].push(r):t[n]=[r]}function p(t){return decodeURIComponent(t.replace(e," "))}function g(t){return encodeURIComponent(t).replace(n,v)}function v(t){return r[t]}self.URLSearchParams=c}(Object,String,Array.isArray)}!function(l){var r=!1;try{r=!!Symbol.iterator}catch(t){}function t(t,n){var e=[];return t.forEach(n,e),r?e[Symbol.iterator]():{next:function(){var t=e.shift();return{done:void 0===t,value:t}}}}"forEach"in l||(l.forEach=function(e,r){var i=this,t=Object.create(null);this.toString().replace(/=[\s\S]*?(?:&|$)/g,"=").split("=").forEach(function(n){!n.length||n in t||(t[n]=i.getAll(n)).forEach(function(t){e.call(r,t,n,i)})})}),"keys"in l||(l.keys=function(){return t(this,function(t,n){this.push(n)})}),"values"in l||(l.values=function(){return t(this,function(t,n){this.push(t)})}),"entries"in l||(l.entries=function(){return t(this,function(t,n){this.push([n,t])})}),!r||Symbol.iterator in l||(l[Symbol.iterator]=l.entries),"sort"in l||(l.sort=function(){for(var t,n,e,r=this.entries(),i=r.next(),a=i.done,s=[],c=Object.create(null);!a;)n=(e=i.value)[0],s.push(n),n in c||(c[n]=[]),c[n].push(e[1]),a=(i=r.next()).done;for(s.sort(),t=0;t<s.length;t++)this.delete(s[t]);for(t=0;t<s.length;t++)n=s[t],this.append(n,c[n].shift())}),function(c){var o=c.defineProperty,u=c.getOwnPropertyDescriptor,h=function(t){var n=t.append;t.append=l.append,URLSearchParams.call(t,t._usp.search.slice(1)),t.append=n},f=function(t,n){if(!(t instanceof n))throw new TypeError("'searchParams' accessed on an object that does not implement interface "+n.name)},t=function(n){var e,r,t=n.prototype,i=u(t,"searchParams"),a=u(t,"href"),s=u(t,"search");!i&&s&&s.set&&(r=function(e){function r(t,n){l.append.call(this,t,n),t=this.toString(),e.set.call(this._usp,t?"?"+t:"")}function i(t){l.delete.call(this,t),t=this.toString(),e.set.call(this._usp,t?"?"+t:"")}function a(t,n){l.set.call(this,t,n),t=this.toString(),e.set.call(this._usp,t?"?"+t:"")}return function(t,n){return t.append=r,t.delete=i,t.set=a,o(t,"_usp",{configurable:!0,writable:!0,value:n})}}(s),e=function(t,n){return o(t,"_searchParams",{configurable:!0,writable:!0,value:r(n,t)}),n},c.defineProperties(t,{href:{get:function(){return a.get.call(this)},set:function(t){var n=this._searchParams;a.set.call(this,t),n&&h(n)}},search:{get:function(){return s.get.call(this)},set:function(t){var n=this._searchParams;s.set.call(this,t),n&&h(n)}},searchParams:{get:function(){return f(this,n),this._searchParams||e(this,new URLSearchParams(this.search.slice(1)))},set:function(t){f(this,n),e(this,t)}}}))};try{t(HTMLAnchorElement),/^function|object$/.test(typeof URL)&&URL.prototype&&t(URL)}catch(t){}}(Object)}(self.URLSearchParams.prototype,Object);

function prepareFilteredLink(params) {
    var urlParams = new URLSearchParams(window.location.search);

    for (var prop in params) {

        if(params.hasOwnProperty(prop)) {
            if(params[prop]) {
                urlParams.set(prop, params[prop])
            } else {
                urlParams.delete(prop)
            }
        }
    }
    var uri = decodeURIComponent(urlParams.toString());

    return window.location.protocol + '//' +
        window.location.host + window.location.pathname  +
        ((uri.length > 0) ? '?' +  uri : '');
}
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