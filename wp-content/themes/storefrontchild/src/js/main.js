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
