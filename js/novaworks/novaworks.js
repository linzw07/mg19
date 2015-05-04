jQuery(function() {
	// Top dropdown
	jQuery(".top-dropdown").mouseenter(function() {
			jQuery(this).click();
	});
	jQuery(".top-dropdown").click(function() {
		jQuery(this).addClass('hover');
		jQuery(this).find("ul").stop(true, true).delay(300).fadeIn(300, "easeOutCubic");
	}).mouseleave(function() {
		jQuery(this).find("ul").stop(true, true).delay(300).fadeOut(300, "easeInCubic");
	});
	// Shopping cart dropdown		
	jQuery("#cart").on('click','.cart-contents',function(e) {
			jQuery(".shopping-bag").toggleClass("show");
			e.preventDefault();
		});
	//Top Search Trigger
    jQuery("#top-search-trigger").click(function(e){
	    jQuery('body').toggleClass('top-search-open');
        jQuery('#cart .shopping-bag').toggleClass('show', false);
        e.preventDefault();
    });
    //Top Search dropdown		
	jQuery("#top-search1").hover(function() {
		jQuery(".form-search3", this).transition({opacity:1});
	}, function() {
		jQuery(".form-search3", this).transition({opacity:0});
	});		
	//Flex slider hover
	jQuery(".hidden-buttons").hover(function() {
		jQuery(".owl-buttons", this).transition({opacity:1});
	}, function() {
		jQuery(".owl-buttons", this).transition({opacity:0});
	});	
	// Close notification		
	jQuery("#nova-notification").on('click','.btn-remove',function(e) {
		jQuery('#nova-notification').transition({ display: 'none' },500,'linear');
	});
	// Sort by dropdown
	jQuery(".sorter .sort-by").mouseenter(function() {
			jQuery(this).click();
	});
	jQuery(".sorter .sort-by").click(function() {
		jQuery(this).addClass('hover');
		jQuery(this).find("ul").stop(true, true).delay(300).fadeIn(500, "easeOutCubic");
	}).mouseleave(function() {
		jQuery(this).find("ul").stop(true, true).delay(300).fadeOut(500, "easeInCubic");
	});	
	
	// Limiter dropdown
	jQuery(".sorter .limiter").mouseenter(function() {
			jQuery(this).click();
			
	});
	jQuery(".sorter .limiter").click(function() {
		jQuery(this).addClass('hover');
		jQuery(this).find("ul").stop(true, true).delay(300).fadeIn(500, "easeOutCubic");
	}).mouseleave(function() {
		jQuery(this).find("ul").stop(true, true).delay(300).fadeOut(500, "easeInCubic");
	});
	
	//Color box content html popup
	jQuery(".inline-size-guide").colorbox({inline:true, width:"50%",opacity:0.7, close: "<i class=\"fa fa-times-circle\"></i>"});	
	jQuery.each(jQuery('#accordion a.accordion-toggle'), function(i, link){
	    
	        jQuery('#collapse' + 1).collapse({
	            toggle : true,
	            parent : '#accordion'
	        });
	jQuery(link).on('click', 
	    function(){
	        jQuery('#collapse' + 1).collapse('toggle');
	    }
	)
	});
	//brands slider
    jQuery(".brands-list").owlCarousel({     
	    items : 6,
	    itemsDesktop : [1199,6],
	    itemsDesktopSmall : [979,3],
		itemsTablet: [600,2], //2 items between 600 and 0;
		itemsMobile : [320,1],
		navigation : true,
		slideSpeed : 300,
		paginationSpeed : 300,
		navigationText : ["<i class=\"icon-left-open-big\"></i>","<i class=\"icon-right-open-big\"></i>"],
		pagination : false    
    });	
	jQuery(document).on('mouseenter','.ajaxcart_colorbox', function(){
		jQuery(this).colorbox({
			iframe:true,
			opacity:0.8,
			width:"420",
			height:"200",
			opacity:0.7, 
			close: "<i class=\"fa fa-times-circle\"></i>"
		});
	});	

   jQuery(document).on('mouseenter','.act-quickview-button', function(){
   	jQuery(this).colorbox({iframe:true, width:"780px", height:"480px",opacity:0.7, close: "<i class=\"fa fa-times-circle\"></i>"});
   	});	
   	//Video
   	jQuery(".novaworks-video").colorbox({iframe:true, innerWidth:"99%", innerHeight:"100%",opacity:0.7,close: "<i class=\"fa fa-times-circle\"></i>"});
	// Add (+/-) Button Number Incrementers 
	jQuery(".button-qty").on("click", function() {
	  var $button = jQuery(this);
	  var oldValue = $button.parent().find("input").val();
	
	  if ($button.text() == "+") {
		  var newVal = parseFloat(oldValue) + 1;
		} else {
	   // Don't allow decrementing below zero
	    if (oldValue > 1) {
	      var newVal = parseFloat(oldValue) - 1;
	    } else {
	      newVal = 1;
	    }
	  }
	
	  $button.parent().find("input").val(newVal);
	
	});
	// Novaworks Animation
	jQuery('.novaworks-animation').waypoint(function() {
	     var animation = jQuery(this).attr("data-animation");
	     jQuery(this).addClass(animation);
	     jQuery(this).addClass('start-anim');
	}, { offset: '80%' });	
	// Novaworks Parallax
	jQuery.stellar({
		horizontalScrolling: false,
		verticalOffset: 206
	});				
});
function setAjaxData(data,iframe){
		if(data.status == 'ERROR'){
			alert(data.message);
		}else{
			if(jQuery('.shopping-bag-item')){
	            jQuery('.shopping-bag-item').replaceWith(data.sidebar);
	        }
			jQuery.colorbox.close();			 					      	        
		}
}
function ajaxcart(url,id) {
 url += 'isAjax/1';
 url = url.replace("checkout/cart","ajax/index");
 jQuery('.button-ajax-cart-id-'+id).html('<i class="fa fa-circle-o-notch fa-spin"></i>'); 

 try {
        jQuery.ajax( {
            url : url,
            dataType : 'json',
            success : function(data) {
                if(data.status == 'SUCCESS'){   
                	 jQuery('#nova-notification .notification-content').html(data.message);
                	 jQuery('#nova-notification').fadeIn('slow').delay(4000).fadeOut('slow', function() {
					 	jQuery('#nova-notification').fadeOut('slow');
					 }); 
					 jQuery('.button-ajax-cart-id-'+id).html('<i class="fa fa-shopping-cart"></i>'); 
					 
                }else{
                    bootbox.alert('<p class="error-msg">' + data.message + '</p>');
                }   
                setAjaxData(data,false);
                    
            }
        });
    } catch (e) {
 }
}
function deletecart(url){
		url = url.replace("checkout/cart","ajax/index");
 		try {
                jQuery.ajax( {
                    url : url,
                    dataType : 'json',
                    success : function(data) {  
                        setAjaxData(data,false);   
                    }
                });
            } catch (e) {
 		}
}
function setAjaxCompareData(data,iframe){
		if(data.status == 'ERROR'){
			alert(data.message);
		}else{
			if(jQuery('.block-compare')){
	            jQuery('.block-compare').replaceWith(data.sidebar);
	        }
			if(jQuery('.ajax-compare')){
	            jQuery('.ajax-compare').replaceWith(data.dropdown);
	        }
						 					      	        
		}
}
function ajaxcompare(url,id) {
 url = url.replace("catalog/product_compare/add","ajax/index/compare");
 jQuery('.button-ajax-compare-id-'+id).html('<i class="fa fa-circle-o-notch fa-spin"></i>'); 
 try {
                jQuery.ajax( {
                    url : url,
                    dataType : 'json',
                    success : function(data) {
                        if(data.status == 'SUCCESS'){    
		                	 jQuery('#nova-notification .notification-content').html(data.message);
		                	 jQuery('#nova-notification').fadeIn('slow').delay(4000).fadeOut('slow', function() {
							 	jQuery('#nova-notification').fadeOut('slow');
							 }); 
							 jQuery('.button-ajax-compare-id-'+id).html('<i class="fa fa-retweet"></i>');                              
                        }else{
                            bootbox.alert('<p class="error-msg">' + data.message + '</p>');
                        }   
                        setAjaxCompareData(data,false);
                            
                    }
                });
            } catch (e) {
 }
}
function removeCompare(url){
	url = url.replace("catalog/product_compare/remove","ajax/index/removecompare"); 
 		try {
                jQuery.ajax( {
                    url : url,
                    dataType : 'json',
                    success : function(data) {  
                        setAjaxCompareData(data,false);   
                    }
                });
            } catch (e) {
 		}
}
function clearCompare(url){
	url = url.replace("catalog/product_compare/clear","ajax/index/clearcompare"); 
 		try {
                jQuery.ajax( {
                    url : url,
                    dataType : 'json',
                    success : function(data) {  
                        setAjaxCompareData(data,false); 
                    }
                });
            } catch (e) {
 		}
}
function ajaxwishlist(url,id) {
 url = url.replace("wishlist/index/add","ajax/index/addwishlist");
 jQuery('.button-ajax-wishlist-id-'+id).html('<i class="fa fa-circle-o-notch fa-spin"></i>'); 
 try {
                jQuery.ajax( {
                    url : url,
                    dataType : 'json',
                    success : function(data) {
                        if(data.status == 'SUCCESS'){  
		                	 jQuery('#nova-notification .notification-content').html(data.message);
		                	 jQuery('#nova-notification').fadeIn('slow').delay(4000).fadeOut('slow', function() {
							 	jQuery('#nova-notification').fadeOut('slow');
							 }); 
							 jQuery('button-ajax-wishlist-id-'+id).html('<i class="fa fa-heart-o"></i>'); 
							if(jQuery('.count-wishlist-box')){
	            				jQuery('#count-wishlist-'+id).replaceWith(data.sidebar);
	            				jQuery('.wishlist-link').replaceWith(data.wishlist_header);
	       					 }                        	  
                        }else{
                            bootbox.alert('<p class="error-msg">' + data.message + '</p>');
                        }   
                            
                    }
                });
            } catch (e) {
 }
}


















