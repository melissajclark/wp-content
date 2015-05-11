/**
 * Collapse Sub Pages
 */
 
jQuery().ready(function($){


	var links ='<li class="expand_all_link"> | <a href="javascript:void(0);">'+acs_l10n_vars.lexpandall+'</a></li><li class="collapse_all_link"> | <a href="javascript:void(0);">'+acs_l10n_vars.lcollapseall+'</a></li>';
	/*
	 * Add Expand/Collapse ALL Links to DOM (has to be first for listeners)
	 */
	jQuery(' .acs-hier .subsubsub').append(links);	

	/*
	 * Initial loading
	 */
	initial_collapse_work();
	reset_listeners();
	
	/*
	 * Does all initial stuff (adding plus/minus buttons, adding top links, perform initial collapse)
	 */	
	function initial_collapse_work(){

		/*
		 * Loop through to add parent and post-id data
		 */	

		jQuery('.pages #the-list tr').each(function(){
			
			var parent = jQuery(this).find('.post_parent').html();
			var id = jQuery(this).find('[name="post[]"]').attr('value');
	
			jQuery(this).attr('data-parent', parent);
			jQuery(this).attr('data-post-id', id);
			jQuery(this).attr('data-collapsed', 0);
			
		});
		
		/*
		 * Loop through again to add +/- as needed
		 */
		jQuery('.pages #the-list tr').each(function(){
			
			var id = jQuery(this).find('[name="post[]"]').attr('value');
	
			if(jQuery('#the-list').find('[data-parent="' + id + '"]').size() > 0)
				jQuery(this).find('.page-title strong').append('<span class="expand_link"><a href="javascript:void(0);" class="minus">[children]</a></span>');			
		});
		
		/*
		 * Collapse from cookie to start with
		 */
		collapse_from_cookie();
		
		
	}
	
	function reset_listeners()
	{
		/*
		 * Called on click, expands and contracts pages by calling functions below
		 */	
		jQuery('.expand_link').click(function(){
			
			var row = jQuery(this).closest('tr');		
			var post_id = row.attr('data-post-id');
				
			jQuery(this).children('a').toggleClass('minus');	
				
			if(row.attr('data-collapsed') == 0)
			{	
				//make cookie here
				add_to_cookie(post_id);		
			
				collapse_subpages(post_id);
				row.attr('data-collapsed', 1);
			}
			else
			{	
				//remove from cookie if exists
				remove_from_cookie(post_id);
			
				expand_subpages(post_id);
				row.attr('data-collapsed', 0);
			}		
		});
	
		/*
		 * Called on click when "Quick Update" is used
		 */		
		jQuery('.inline-edit-save .save').click(function(){
			
			/*
			 * delay before reset, allows WordPress to finish reseting rows 
			 * (not ideal, but the "Quick Edit" is a little wonky to begin with)
			 */
			setTimeout(function(){
			
				//console.log(jQuery('#the-list tr'));
		
				jQuery('#the-list tr').show();
				jQuery('.expand_link').remove();
						
				//redo collapses
				initial_collapse_work();	
				reset_listeners();

			}, 1000); 
					
		});	
		
		/*
		 * Expand and collapse all links
		 */		
		jQuery('.expand_all_link a').click(function(){
			expand_all();
		});			
		jQuery('.collapse_all_link a').click(function(){
			collapse_all();
		});		
	}
	
	function collapse_all()
	{	
		jQuery('.pages #the-list tr').each(function(){
		
			var post_id = jQuery(this).attr('data-post-id');		
		
			if(jQuery(this).attr('data-collapsed') == 0)
			{				
				//make cookie here
				add_to_cookie(post_id);		
			
				collapse_subpages(post_id);
				jQuery(this).attr('data-collapsed', 1).find('.expand_link a').toggleClass('minus');
				
			}					
		});
	}	
	function expand_all()
	{
		jQuery('.pages #the-list tr').each(function(){
		
			var post_id = jQuery(this).attr('data-post-id');		
						
			if(jQuery(this).attr('data-collapsed') == 1)
			{	
				//remove from cookie if exists
				remove_from_cookie(post_id);
			
				expand_subpages(post_id);
				jQuery(this).attr('data-collapsed', 0).find('.expand_link a').toggleClass('minus');
			}	
		});	
	}
	
	/*
	 * Two recursive functions that show/hide the table rows
	 */	 
	function collapse_subpages(parent_id)
	{		
		jQuery('#the-list').find('[data-parent="' + parent_id + '"]').each(function(){
			
			jQuery(this).hide();
			
			collapse_subpages(jQuery(this).attr('data-post-id'));		
		});
	}	
	function expand_subpages(parent_id)
	{		
		jQuery('#the-list').find('[data-parent="' + parent_id + '"]').each(function(){
			
			jQuery(this).show();
			
			//does not unhide rows if group was previously hidden
			if(jQuery(this).attr('data-collapsed') == 0)
				expand_subpages(jQuery(this).attr('data-post-id'));
		});
	}	

	/*
	 * Add value to cookie
	 */	
	 function add_to_cookie(row_id)
	 {
	 	var cookie = $.cookie('collapsed');
	 	var values;
	 	
		if(cookie){		
			values = cookie.split(',');
			if(jQuery.inArray(row_id, values) == -1)
				values.push(row_id);	
		}else{			
			values = new Array(row_id);		
		}	 	
		
		$.cookie('collapsed',values);
		
	 }

	/*
	 * Remove value from cookie
	 */		 
	 function remove_from_cookie(row_id)
	 {
	 	var cookie = $.cookie('collapsed');
	 	var values;
	 	
		if(cookie){		
			values = cookie.split(',');

	 		values = jQuery.grep(values, function(value) {
        		return value != row_id;
      		});	
      		
 			$.cookie('collapsed',values);
		     		
		}	  
	 }
	 
	/*
	 * Read cookie and expand pages as needed
	 */		 	
	function collapse_from_cookie()
	{
	 	var cookie = $.cookie('collapsed');
	 	var values;
	 	
		if(cookie){		
			values = cookie.split(',');

	 		jQuery.each(values,function(index, value){
				jQuery('#the-list').find('[data-post-id="' + value + '"]').attr('data-collapsed', 1).find('.expand_link a').toggleClass('minus');
	 		}); 

	 		jQuery.each(values,function(index, value){
	 			collapse_subpages(value);
	 		});    		
		}	
	}

});
