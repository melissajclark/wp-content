
// empty object for code to live on
var filterApp = {};

// array to store data-attributes on filterable items
filterApp.dataAttr = ['data-status', 
					'data-language'];

// array to store selectors used throughout JS
filterApp.selector  = ['select#audioChoice', 
						'select#languageChoice', 
						'article.filterableItem', 
						'.filterableContent',
						'form.filterNav'];

// array to store classes added when hiding / showing items
filterApp.transition = ['hideItemTransition', 
						'showItemTransition'];

filterApp.values = ['English: ',
					'All',
					'French: ',
					'Tous'];
						
// ------------------------------------

filterApp.init = function() { // this function holds everything to start the app

$(filterApp.selector[2]).addClass("animated");

	// ============ Function that listens on click & evaluates type data

	$(filterApp.selector[4]).on("change",function(event){ 

		event.preventDefault(); // prevents page from refreshing

		// finds the value of the user's selection (aka the desired content to view)
		filterApp.userAudioSelection = $(filterApp.selector[0]).val();
		filterApp.userLanguageSelection = $(filterApp.selector[1]).val();

		/**
		*
		* If Statement: Evaluates English values on submit
		*
		**/
		
		// checks if Audio = all and language = all
		if (filterApp.userAudioSelection === filterApp.values[1] && filterApp.userLanguageSelection === filterApp.values[1] || filterApp.userAudioSelection === filterApp.values[3] && filterApp.userLanguageSelection === filterApp.values[3]) {
			console.log(filterApp.values[0] + 'or' + filterApp.values[2] + ' all audio & languages selected');

			$(filterApp.selector[2]).show();

		// checks if audio = all but languages do not = all
		} else if (filterApp.userAudioSelection === filterApp.values[1] && filterApp.userLanguageSelection != filterApp.values[1] || filterApp.userAudioSelection === filterApp.values[3] && filterApp.userLanguageSelection != filterApp.values[3]) {
			console.log(filterApp.values[0] + 'or' + filterApp.values[2] + ' All audio selected But language != All');

			// finds items NOT matching user's selection and hides them
			// selection: Audio: all | Language != all
			$(filterApp.selector[2] + '[' + filterApp.dataAttr[1] + ']').not('[' + filterApp.dataAttr[1] + '="' + filterApp.userLanguageSelection + '"]').addClass(filterApp.transition[0]).hide();
			
			//finds items matching user's selection and shows them
			// selection: Audio: all | Language != all
			$(filterApp.selector[2] + '[' + filterApp.dataAttr[1] + ']').filter('[' + filterApp.dataAttr[1] + '="' + filterApp.userLanguageSelection + '"]').addClass(filterApp.transition[1]).show();

		// checks is languages = all, but audio does not equal all
		} else if (filterApp.userAudioSelection != filterApp.values[1] && filterApp.userLanguageSelection === filterApp.values[1] || filterApp.userAudioSelection != filterApp.values[3] && filterApp.userLanguageSelection === filterApp.values[3]) {
			console.log(filterApp.values[0] + 'or' + filterApp.values[2] + ' All languages selected But audio != All'); 

			// finds items NOT matching user's selection and hides them
			// selection: Audio = !all | Language = all
			$(filterApp.selector[2] + '[' + filterApp.dataAttr[0] + ']').not('[' + filterApp.dataAttr[0] + '="' + filterApp.userAudioSelection + '"]').addClass(filterApp.transition[0]).hide();
			
			//finds items matching user's selection and shows them
			// selection: Audio = !all | Language = all
			$(filterApp.selector[2] + '[' + filterApp.dataAttr[0] + ']').filter('[' + filterApp.dataAttr[0] + '="' + filterApp.userAudioSelection + '"]').addClass(filterApp.transition[1]).show();

		// checks is both audio & language do not equal all
		}  else if (filterApp.userAudioSelection != filterApp.values[1] && filterApp.userLanguageSelection != filterApp.values[1] || filterApp.userAudioSelection != filterApp.values[3] && filterApp.userLanguageSelection != filterApp.values[3]) {
			console.log(filterApp.values[0] + 'or' + filterApp.values[2] + ' audio & video both do not equal all'); 

			// finds items NOT matching user's selection and hides them
			// selection: Audio = !all | Language = !all
			$(filterApp.selector[2] + '[' + filterApp.dataAttr[0] + ']' + '[' + filterApp.dataAttr[1] + ']').not('[' + filterApp.dataAttr[0] + '="' + filterApp.userAudioSelection + '"]' + '[' + filterApp.dataAttr[1] + '="' + filterApp.userLanguageSelection + '"]').addClass(filterApp.transition[0]).hide();
			
			//finds items matching user's selection and shows them
			// selection: Audio = !all | Language = !all
			$(filterApp.selector[2] + '[' + filterApp.dataAttr[0] + ']' + '[' + filterApp.dataAttr[1] + ']').filter('[' + filterApp.dataAttr[0] + '="' + filterApp.userAudioSelection + '"]' + '[' + filterApp.dataAttr[1] + '="' + filterApp.userLanguageSelection + '"]').addClass(filterApp.transition[1]).show();

		} 

	});  // ============ End function that listens on click & evaluates filterApp.dataAttr[1] 

}; // end filterApp.init


/**
*
* Doc Ready = calls all code above
*
**/
function filterMe() {
  jQuery(document).ready(function($){ // wordpress doc ready

    filterApp.init();
    
  }); // end of WordPress doc ready function
} // end of filterMe


/** Pseudo code notes (end of file to preserve spacing to view Diffs of commits)

On "Submit", I want:

- To check which .filterableItems have the data-attributes the user selected
- To hide the items that don't match the selection
- To include a CSS transition when this occurs

**/