// Empty object for all code to live on

var filterApp = {};
filterApp.sortTypes = ["all", "German", "French", "Cantonese", "Portugese", "Spanish"]; // object to hold options for filtering
filterApp.sortShapes = ["all", "circle", "hexagon", "square"]; // object to hold options for filtering
filterApp.eachItem = "";

// ------------------------------------



filterApp.init = function() { // this function holds everything to start the app

	// ======== functions that need to occur on page load ============

	/**
	*
	* Hide legend of results on page load + add active class to all items
	*
	**/

	$("section.filterResultsCurrent").hide();
	
	/**
	*
	* Append sort options to selection menu: types
	*
	**/

	// $("#filterOptionsTypes").append(
	// 	"<li value='"+ filterApp.sortTypes[0] + "'><a class='filterControl' href='#'>" +  filterApp.sortTypes[0] + "</a></li>" + 
	// 	"<li value='"+ filterApp.sortTypes[1] + "'><a class='filterControl' href='#'>" +  filterApp.sortTypes[1] + "</a></li>" +
	// 	"<li value='"+ filterApp.sortTypes[2] + "'><a class='filterControl' href='#'>" +  filterApp.sortTypes[2] + "</a></li>" +
	// 	"<li value='"+ filterApp.sortTypes[3] + "'><a class='filterControl' href='#'>" +  filterApp.sortTypes[3] + "</a></li>" +
	// 	"<li value='"+ filterApp.sortTypes[4] + "'><a class='filterControl' href='#'>" +  filterApp.sortTypes[4] + "</a></li>" +
	// 	"<li value='"+ filterApp.sortTypes[5] + "'><a class='filterControl' href='#'>" +  filterApp.sortTypes[5] + "</a></li>"
	// );

	/**
	*
	* Append sort options to selection menu: shapes
	*
	**/

	$("#filterOptionsShapes").append(
		"<li value='"+ filterApp.sortShapes[0] + "'><a class='filterControl' href='#'>" +  filterApp.sortShapes[0] + "</a></li>" + 
		"<li value='"+ filterApp.sortShapes[1] + "'><a class='filterControl' href='#'>" +  filterApp.sortShapes[1] + "</a></li>" +
		"<li value='"+ filterApp.sortShapes[2] + "'><a class='filterControl' href='#'>" +  filterApp.sortShapes[2] + "</a></li>" +
		"<li value='"+ filterApp.sortShapes[3] + "'><a class='filterControl' href='#'>" +  filterApp.sortShapes[3] + "</a></li>"
	);	


	// ======== End functions that need to occur on page load ===========


	// ============ Function that listens on click & evaluates type data

	$("#filterOptionsTypes a.filterControl").on("click",function(){ 

		// finds the value of the user's selection (aka the desired shape to view)
		filterApp.sortChoiceType = $(this).text().toLowerCase().replace(/\s+/g, '').toString();

		console.log(filterApp.sortChoiceType);
		
		// displays legend after user clicks on a filter link filterApp.sortChoiceType
		$("article.filterResultsCurrent").show(); 

		// finds items NOT matching user's selection and hides them
		$("article.filterableItem").not('[data-status="' + filterApp.sortChoiceType  + '"]').css("background", "red");

		//finds items matching user's selection and shows them
		$("article.filterableItem").filter('[data-status="' + filterApp.sortChoiceType  + '"]').css("background", "green");

		// hides legend if "all" is selected + shows all items when all is selected
		if (filterApp.sortChoiceType === "all") {
			$("section.filterResultsCurrent").hide();
			$("article.filterableItem").css("display", "inline-block");
		} else {
			$("section.filterResultsCurrent").show();
			$("li span.currentChoice").html("Status: " + filterApp.sortChoiceType);
		}

	}); // end function on types select
	
	// ============ End function that listens on click & evaluates type data
	
	// ============ Function that listens on click & evaluates shape data

// 	$("#filterOptionsShapes a.filterControl").on("click",function(){ 

// 		// finds the value of the user's selection (aka the desired shape to view)
// 		filterApp.sortChoiceShape = $(this).text();

// 		$("section.filterResultsCurrent").show(); // displays legend after user clicks on a filter link

// 		// finds items NOT matching user's selection and hides them
// 		$("section.filterableItem").not('[data-shape="' + filterApp.sortChoiceShape + '"]').css("display", "none");

// 		//finds items matching user's selection and shows them
// 		$("section.filterableItem").filter('[data-shape="' + filterApp.sortChoiceShape + '"]').css("display", "inline-block");


// 		// hides legend if "all" is selected + shows all items when all is selected
// 		if (filterApp.sortChoiceShape === "all") {
// 			$("section.filterResultsCurrent").hide();
// 			$("section.filterableItem").css("display", "inline-block");
// 		} else {
// 			$("section.filterResultsCurrent").show();
// 			$("li span.currentChoice").html("Shape: " + filterApp.sortChoiceShape);
// 		}

// 	}); // end function on shapes select
	
// 	// ============ End function that listens on click & evaluates shape data


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