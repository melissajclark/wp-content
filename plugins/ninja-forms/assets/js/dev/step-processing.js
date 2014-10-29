jQuery(document).ready(function($) {
	
	var progressbar = $( "#progressbar" ),
	progressLabel = $( ".progress-label" );

	progressbar.progressbar({
		value: false,
		change: function() {
			var value = parseInt( progressbar.progressbar( "value" ) );
			if ( value == 90 ) {
				nfProgressBar.currentLabel = 1;
			} else if ( value % 10 == 0 ) {
				nfProgressBar.changeTextLabel();
			}
			var text = nfProgressBar.getTextLabel();
			progressLabel.text( text + " " + progressbar.progressbar( "value" ) + "%" );
		},
		complete: function() {
			progressLabel.text( "Complete!" );
		}
	});

 	if ( nfProcessingAction != 'none' ) {
		var nfProgressBar = {
			labels: {
				0: 'Lacing Our Tabis',
				1: 'Cleaning The Dojo',
				2: 'Doing Splits',
				3: 'Buffing Bo Staff',
				4: 'Intimidating Gaze',
				5: 'Sparring',
				6: 'Packing Smoke Bombs',
				7: 'Polishing Shuriken',
				8: 'Throwing Sais',
				9: 'Calling Our Mom',
				10: 'Practicing Katas',
				11: 'Swinging Nunchucks',
				12: 'Sharpening Swords',
				13: 'Ironing Ninja Gi',
				14: 'Eating Breakfast',
				15: 'Cutting Stuff',
				16: 'Doing Dishes',
				17: 'Climbing Walls'
			},
			getTextLabel: function() {
				var label = this.labels[ this.currentLabel ];
				return label;
			},
			changeTextLabel: function() {
				var max = Object.keys( this.labels ).length - 1;
				var labelNum = Math.floor( Math.random() * ( max - 2 + 1 ) ) + 2;
				this.currentLabel = labelNum;		
			},
			currentLabel: 0
      	};

      	var nfProcessing = {
      		setup: function() {
      			// Figure out when we're going to change the size of the bar.
      			this.interval = Math.floor( 100 / parseInt( this.totalSteps ) );
      		},
      		process: function() {
      			
				$.post( ajaxurl, { step: this.step, total_steps: nfProcessing.totalSteps, args: this.args, action: nfProcessingAction }, function( response ) {
		      		response = $.parseJSON( response );
		      		nfProcessing.step = response.step;
		      		nfProcessing.totalSteps = response.total_steps;
		      		nfProcessing.args = response.args;
		      		
		      		if ( nfProcessing.runSetup == 1 ) {
		      			nfProcessing.setup();
		      			nfProcessing.runSetup = 0;
		      		}

		      		if ( ! response.complete ) {
		      			nfProcessing.progress();
		      			nfProcessing.process();
		      		} else {
		      			progressbar.progressbar( "value", 100 );
		      			if ( typeof response.redirect != 'undefined' && response.redirect != '' ) {
		      				document.location.href = response.redirect;
		      			}
		      		}
		      	});
      		},
      		progress: function() {
				var val = progressbar.progressbar( "value" ) || 0;

				progressbar.progressbar( "value", val + this.interval );

      		},
      		step: 'loading',
      		totalSteps: 0,
      		runSetup: 1,
      		interval: 0,
      		args: nfProcessingArgs,
      	}
     	
     	nfProcessing.process();
	}
  });