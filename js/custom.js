jQuery(document).ready(function () {
  
  if(jQuery('.single .ez-toc-title-toggle').length){
    jQuery('.single .ez-toc-title-toggle').html('<img src="../wp-content/uploads/2023/05/Stroke-3.png">');  
  }
    jQuery('.counter').each(function () {
     var size = jQuery(this).text().split(".")[1] ? jQuery(this).text().split(".")[1].length : 0;
     jQuery(this).prop('Counter', 0).animate({
        Counter: jQuery(this).text()
     }, {
        duration: 5000,
        step: function (func) {
           jQuery(this).text(parseFloat(func).toFixed(size));
        }
     });
  
    
  });
  
  jQuery('.first-box .nav-tabs a').on('click', function(){
    var filter = jQuery(this).data('filter');
    if(filter){
      jQuery('.first-box .nav-tabs li').removeClass('active');
      jQuery(this).closest('li').addClass('active');
      jQuery('.first-box .all-grid').removeClass('show');
      var check = jQuery(document).find(filter);
      check.addClass('show');
    }
   });
   jQuery(document).on('click', '#nav_bar_sec .tablinks a', function(){
    var filter = jQuery(this).data('filter');
    if(filter){
      jQuery('#posts_search_form').find('#filter_post_cat').val(filter);
      jQuery('#nav_bar_sec .tablinks').removeClass('active');
      jQuery(this).closest('li').addClass('active');
      jQuery('.body_sec .main-box').removeClass('show');
      var check = jQuery(document).find(filter);
      jQuery('#posts_search_form').find('#paged').val('0'); 
      posts_search_filter('search');
      //check.addClass('show');
    }
   });
  
   jQuery('body').on("click", ".load_more_posts", function(e){
    posts_search_filter('load');
   });
  
   jQuery('body').on("submit", "#posts_search_form", function(e){
    e.preventDefault();
    jQuery('#posts_search_form').find('#paged').val('0');  
    posts_search_filter('search');
   });
   if(jQuery('#filter_post_cat').length){
      jQuery('#filter_post_cat').val('.all_article');
      //jQuery('#paged').val('2');
   } 
  function posts_search_filter(filter){
    var paged = jQuery('#posts_search_form').find('#paged').val();  
    var cat = jQuery('#posts_search_form').find('#filter_post_cat').val();
    var search = jQuery('#posts_search_form').find('#search_keyword').val();
    if(filter != 'load'){
      jQuery('.main-box').html('');
    }
  
    jQuery.ajax({
        type : "POST",
        url : tx_ajax_object.ajax_url,
        data : {
            action: "tx_load_more_posts",
            paged: paged,
            cat: cat,
            search: search
        },
        beforeSend: function() {
          jQuery(".slider_loader").removeClass('d_none');        
        },
        success: function(response) {
            //console.log(response);
            var data = JSON.parse(response);
            if(filter == 'load'){
              //jQuery(document).find('#load_more_content').append(data.html);
              jQuery('.main-box'+data.category).append(data.html);
            }else{
              jQuery('.main-box'+data.category).html(data.html);
              if(data.category == ''){
                jQuery('.main-box.all_article').addClass('show');
              }else{
                jQuery('.main-box'+data.category).addClass('show');
              }            
            }
            if(data.remaining_posts == 'hide'){
               jQuery('.load_more_btn_wrap').addClass('d_none');
            }else{
               jQuery('.load_more_btn_wrap').removeClass('d_none');
            }
            jQuery('#posts_search_form').find('#paged').val(data.paged); 
            jQuery('#posts_search_form').find('#filter_post_cat').val(data.category);
            jQuery(".slider_loader").addClass('d_none'); 
        }
    });
  }
    
    
  /* testimonial slider start*/
    
  var brandSlider = jQuery('.testimonial_slider');
  brandSlider.owlCarousel({
      loop: false,
      nav: true,
      dots: false,
      smartSpeed: 500,
      margin: 30,
      item:3,
  // 	autoWidth:true,
      responsive: {
        0: {
            items: 1,
        margin: 10,
        stagePadding: 20,
        },
        480: {
            items: 1,
        margin: 10,
        stagePadding: 20,
        },
        768: {
            items: 2
        },
        992: {
            items: 4,
        touchDrag  : false,
               mouseDrag  : false,
        },
        1200: {
            items: 4
        }
      }
  });
  
  if(jQuery(window).width() > 991){
  function brandSliderClasses() {
      brandSlider.each(function() {
          var total = jQuery(this).find('.owl-item.active').length;
          jQuery(this).find('.owl-item').removeClass('firstactiveitem');
          jQuery(this).find('.owl-item').removeClass('fullDetial_author');
          jQuery(this).find('.owl-item.active').each(function(index) {
              if (index === 0) {
                  jQuery(this).addClass('firstactiveitem')
              }
              if (index === total - 2 && total > 2) {
                  jQuery(this).addClass('fullDetial_author');
              }
          })
      
      })
  }
  brandSliderClasses();
  brandSlider.on('translated.owl.carousel', function(event) {
      brandSliderClasses()
  }); 
  }
    jQuery(document).ready(function() {
    if(jQuery(window).width() > 991){	
  var owltotalWidth=jQuery('.testimonial_slider .owl-item').width();
      var owltotalWidthfull=jQuery('.testimonial_slider .owl-stage').width();
      jQuery('.testimonial_slider .owl-stage').width(owltotalWidth+owltotalWidthfull);
       jQuery('.testimonial_slider .owl-stage .owl-item.fullDetial_author').width(owltotalWidth*2);	
  
  jQuery('.testimonial_slider .owl-nav button.owl-next').click(function(){
      jQuery('.testimonial_slider .owl-item').width(owltotalWidth);
       jQuery('.testimonial_slider .owl-stage .owl-item.fullDetial_author + .owl-item').width(owltotalWidth*2);	
    console.log('click');
    (function (el) {
      setTimeout(function () {
          el.children().remove('.slider_loader');
      }, 800);
  }(jQuery(".testimonial_slider .owl-stage-outer").append("<div class='slider_loader'><div class='loader'></div></div>")));
  });
    jQuery('.testimonial_slider .owl-nav button.owl-prev').click(function(){
      jQuery('.testimonial_slider .owl-item').width(owltotalWidth);
       jQuery('.testimonial_slider .owl-stage .owl-item.fullDetial_author').prev().width(owltotalWidth*2);	
    console.log('click');
      (function (el) {
      setTimeout(function () {
          el.children().remove('.slider_loader');
      }, 800);
  }(jQuery(".testimonial_slider .owl-stage-outer").append("<div class='slider_loader'><div class='loader'></div></div>")));
  });
    }
  if(jQuery(window).width() < 991){
    jQuery('.testimonial_slider .owl-item').addClass('fullDetial_author');
  }
  });

/*blog single page table of content  toggle js */
    jQuery(".rotate_image, .ez-toc-title-toggle").click(function(){    
    jQuery(".toggle_class_active").toggle();
    jQuery(".ez-toc-list").toggle();
    jQuery(this).toggleClass("rotate");
  });
/*faq section toggle js*/
//jQuery(".gutentor-single-item-title").after().click(function(){
  jQuery(".gutentor-accordion-heading ").click(function(){
    jQuery('.gutentor-accordion-heading').removeClass('active');
    
    
   if(jQuery( ".gutentor-accordion-body" ).hasClass( "service_faq_sect")){
      jQuery('.gutentor-accordion-body').removeClass('service_faq_sect');
   }
else{
  jQuery(this).next('.gutentor-accordion-body').addClass('service_faq_sect');
  jQuery(this).addClass('active');
  //jQuery(this).next('.gutentor-single-item-title h3').css('right','100px');
}
    
  //jQuery('.gutentor-accordion-body').removeClass('service_faq_sect');
  
    
  //  jQuery(this).toggleClass("rotate");
    

  });  
  });
 
  
  
  /* testimonial slider start*/
               
  jQuery(function() {
    // Owl Carousel
    var owl = jQuery(".tading_strateg_first");
    owl.owlCarousel({
      items: 3,
      margin: 30,
      loop: false,
      nav: true,
       touchDrag  : false,
          mouseDrag  : false,
      
       responsive: {
      0: {
        stagePadding: 50,
       loop: true,
        items: 1,
       touchDrag  : true,
          mouseDrag  : true,
      margin: 10,
      },
     767: {
        items:4,
       touchDrag  : false,
          mouseDrag  : false,
        loop: false,
        margin: 30,
      },
  
      1024: {
        items: 4
      },
  
      1366: {
        items:4
      }
    }
    });
  });
  
  /**====== tabsection select trigger js======*/
   jQuery('.tabSelect select').on('change',function(){
     var datafilter = jQuery(this).children('option:selected').attr('data-filter');
   jQuery('.nav-tabs ul').find("[data-filter='" + datafilter + "']").click();
   });
  
  /**====== header toggle js======*/
  jQuery('#mobile-menu-control-wrapper').click(function(){
    jQuery('header.site-header').toggleClass('showMenu');
  });
  /**====== single blog page accordian js======*/
  jQuery('.tableContentBox .wp-block-heading img').click(function(){
    jQuery(this).parents('.tableContentBox').toggleClass('showcollapsse');
    jQuery('.collapsePost').slideToggle();
  });
  
    jQuery(document).on('click', '.comment_pagination', function(e) {
        e.preventDefault();
        var page = jQuery(this).attr('data-page');
        var post_id = jQuery(this).attr('data-post_id');
        jQuery.ajax({
            url: tx_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'load_comments',
                post_id: post_id,
                page: page
            },
            beforeSend: function() {
              jQuery("#slider_loader").removeClass('d_none');        
            },
            success: function(response) {
                var obj = response.data;
                jQuery('#single_commentlist').html(obj.comment_html);
                jQuery("#slider_loader").addClass('d_none'); 
            }
        });
    });
  
  function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }



//   var acc = document.getElementsByClassName("service_faq");
// var i;

// for (i = 0; i < acc.length; i++) {
//   acc[i].addEventListener("click", function() {
    
//     this.classList.toggle("active");
//     var panel = this.nextElementSibling;
//     if (panel.style.display === "block") {
//       panel.style.display = "none";
//     } else {
//       panel.style.display = "block";
//     }
//   });
// }
