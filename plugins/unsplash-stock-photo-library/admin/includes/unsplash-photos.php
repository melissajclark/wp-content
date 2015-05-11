<ul class="order">
   <li><?php _e('Order', USP_NAME); ?>:</li>
   <li><a href="javascript:void(0);" id="usp-newest"><?php _e('Recent', USP_NAME); ?></a></li>
   <li><a href="javascript:void(0);" id="usp-oldest"><?php _e('Oldest', USP_NAME); ?></a></li>
   <li><a href="javascript:void(0);" id="usp-randomize"><?php _e('Random', USP_NAME); ?></a></li>
</ul>
<ul id="usp_photos"></ul>
<div class="more-wrap">
   <span class="loading"></span>
   <input type="button" id="usp-load-more" name="usp-load-more" value="<?php _e('Load More Images', USP_NAME); ?>" class="button">
</div>
<?php
   $options = get_option( 'usp_settings' );
   
   // get width of download file
   $download_w = $options['_usp_dw'];
   if(!isset($download_w))
      $download_w = 1600;
      
   // Get height of downloads
   $download_h = $options['_usp_dh'];
   if(!isset($download_h))
      $download_h = 900;
      
   // Get posts per page
   $download_pp = $options['_usp_pp'];
   if(!isset($download_pp))
      $download_pp = 20;
   
?>
<script>
   jQuery(document).ready(function($) {	   			      
      // Parse JSON from https://unsplash.it/list
	   var url = 'https://unsplash.it/list',
	       usp_photos = '',
	       usp_photos_default_arr = '',
	       usp_photos_length = '',
	       usp_pages = '',
	       usp_load = <?php echo $download_pp; ?>,
	       usp_current = 0,
	       usp_thumb_width = 240,
	       usp_thumb_height = 200,
	       usp_width = <?php echo $download_w; ?>,
	       usp_height = <?php echo $download_h; ?>,
	       container = $('#usp_photos'),
	       btn = $('.more-wrap');  			     
	       
	   $.getJSON( url, function( data ) {	       
	      // Convert JSON to JS Array
	      var arr = [],
	          num = 0;
         for (elem in data) {
            if(num === 0){ // Skip the first node, it's and empty ID
               num++;
            }else{
               arr.push(data[elem]);
            }
         }                           
         	      
	      usp_photos = arr.reverse(); // Reverse array so we have the latest images first
	      
	      usp_photos_length = usp_photos.length; 
	      usp_pages = Math.round(usp_photos_length / usp_load); // Generate the # of pages
         get_photos();  // Get the photos now :)                      
      }).error(function() { 
         alert("<?php _e('Error loading Unsplash JSON feed.', USP_NAME); ?>")
      });
      
      function get_photos(){
         $('.loading', btn).fadeIn();
         // Loop photos
         for(var i = 0; i < usp_load; i++){
           var n = (usp_current * usp_load) + i;
           
           // Wrap usp_photos[n] in undefined function to avoid undefined image var
           if (undefined != usp_photos[n]){
            //console.log(usp_photos[n]);
              var id = usp_photos[n].id,
                  img = 'https://unsplash.it/'+usp_thumb_width+'/'+usp_thumb_height+'?image='+id,                                 
                  full_size = 'https://unsplash.it/'+usp_width+'/'+usp_height+'?image='+id,
                  author = usp_photos[n].author,
                  link = usp_photos[n].post_url,
                  el = '<li>';
                  el += '<a class="upload" href="'+ link +'" data-url="'+full_size+'" data-desc="<?php _e('Photo by: ',USP_NAME); ?> '+author+'" title="<?php _e('Click to upload photo ',USP_NAME); ?>">';
                  el += '<img width="'+ usp_thumb_width +'" height="'+ usp_thumb_height +'" src="'+ img +'"/>'
                  el += '</a>';
                  el += '<div class="controls">';
                  el += '<span class="num zoom-in" data-href="'+link+'" title="<?php _e('View Full Size', USP_NAME); ?>"><i class="fa fa-search-plus"></i></span>';
                  el += '<span class="num">#'+id+'</span>';
                  el += '</div>';
                  el += '</li>';           
               
               
               // Append el to container if id is NOT 0
               if(id !== 0)
                  $(el).appendTo(container);
               
               // Fade in images when loaded
               $('img', container).bind('load', function(){
                  $(this).parent('a').addClass('loaded');
               });
            }                           
         }
         $('.loading', btn).fadeOut();
         
         // Image Click Event
         $('li a.upload', container).on('click', function(e){
            var el = $(this);                           
            // If not saving, then proceed
            if(!el.hasClass('saving')){
               el.addClass('saving');
               e.preventDefault();
               var image = $(this).data('url'),
                   description = $(this).data('desc');
               $.ajax({
						type: 'POST',
						url: usp_admin_localize.ajax_admin_url,
						dataType: 'JSON',
						
						data: {
							action: 'usp_upload_image',
							image: image, 
							description: description, 
							nonce: usp_admin_localize.usp_admin_nonce,
						},
						
						success: function(response) {	   									  		
                     console.log(response); 
                     if(response){
                        var hasError = response.error,
                            msg = response.msg;
                                                    
                        if(hasError){ // Error
                           el.removeClass('saving').removeClass('uploaded');
                           if(!$('span.err', el).length){
                              el.append('<span class="err" title="'+ msg +'"><i class="fa fa-exclamation-circle"></i></span>');
                           }
                        }else{ // Success!
                           el.removeClass('saving').addClass('uploaded');
                           if(!$('span.check', el).length){
                              el.append('<span class="check" title="'+ msg +'"><i class="fa fa-check"></i></span>');
                           }
                        }
                     }else{ // If reponse is empty
                        el.removeClass('saving').removeClass('uploaded');
                        if(!$('span.err', el).length){
                           el.append('<span class="err" title="<?php _e('Unable to save image, check your server permissions.', USP_NAME) ;?>"><i class="fa fa-exclamation-circle"></i></span>');
                        }
                     }
	
						},
						
						error: function(xhr, status, error) {
							console.log(status);
							el.removeClass('saving').removeClass('uploaded');
                     if(!$('span.err', el).length){
                        el.append('<span class="err" title="<?php _e('Unable to save image, check your server permissions.', USP_NAME) ;?>"><i class="fa fa-exclamation-circle"></i></span>');
                     }
						}
               }); 
            }else{                              
               e.preventDefault();
            }         
         });
         
         $('li .zoom-in', container).on('click', function(e){
            var el = $(this),
                href = el.data('href');
            window.open(href);
         });
                                
      }
      
      
      // Generate random arr
      function randomizeArr(){                        
	      usp_photos.sort(function() { 
	         return 0.5 - Math.random() 
	      });
	      usp_sortPhotos();
      }                     
      // Randomize button
      $('#usp-randomize').on('click', function(){
         randomizeArr();
         $('ul.order li a').removeClass('active');
         $(this).addClass('active');
      });       
                                        
      
      // Oldest First button
      function usp_oldestArr(a,b) {
         if (a.id < b.id)
            return -1;
         if (a.id > b.id)
            return 1;
         return 0;
      }
      $('#usp-oldest').on('click', function(){
         if(!$(this).hasClass('active')){
            $('ul.order li a').removeClass('active');
            $(this).addClass('active');
            usp_photos.sort(usp_oldestArr); // Sort arr
            usp_sortPhotos();
         }
      });
      
      // Newest First button
      function usp_newestArr(a,b) {
         if (a.id > b.id)
            return -1;
         if (a.id < b.id)
            return 1;
         return 0;
      }
      $('#usp-newest').on('click', function(){
         if(!$(this).hasClass('active')){
            $('ul.order li a').removeClass('active');
            $(this).addClass('active');
            usp_photos.sort(usp_newestArr); // Sort arr
            usp_sortPhotos();
         }
      });
      $('#usp-newest').addClass('active');
      
      function usp_sortPhotos(){                        
         usp_current = 0;
	      $('#usp_photos').html('');
         get_photos();
      }
                           
      
      // Load more button
      $('#usp-load-more', btn).on('click', function(){
         usp_current++;
         if(usp_current <= usp_pages)
            get_photos();            
         //console.log(usp_current);  //console.log(usp_pages);
      });                     
      
   });	
   			
</script>