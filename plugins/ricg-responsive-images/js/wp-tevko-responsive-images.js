"use strict";

(function() {

  /**
   * Recalculate srcset attribute after an image-update event
   */
  if ( wp.media ) {
    wp.media.events.on( 'editor:image-update', function( args ) {
      // arguments[0] = { Editor, image, metadata }
  	  var image = args.image,
  			metadata = args.metadata,
  			srcsetGroup = [],
  			srcset = '',
        sizes = '';

      // if the image url has changed, recalculate srcset attributes
      if ( metadata && metadata.url !== metadata.originalUrl ) {
        // we need to get the postdata for the image because
        // the sizes array isn't passed into the editor
        var imagePostData = new wp.media.model.PostImage( metadata ),
          crops = imagePostData.attachment.attributes.sizes;

        // grab all the sizes that match our target ratio and add them to our srcset array
        _.each(crops, function(size){
          var softHeight = Math.round( size.width * metadata.height / metadata.width );

          // If the height is within 1 integer of the expected height, let it pass.
          if ( size.height >= softHeight - 1 && size.height <= softHeight + 1  ) {
            srcsetGroup.push(size.url + ' ' + size.width + 'w');
          }
        });

        // convert the srcsetGroup array to our srcset value
        srcset = srcsetGroup.join(', ');
        sizes = '(max-width: ' + metadata.width + 'px) 100vw, ' + metadata.width + 'px';

        // update the srcset attribute of our image
        image.setAttribute( 'srcset', srcset );

        // update the sizes attribute of our image
        image.setAttribute( 'data-sizes', sizes );
      }

    });    
  }


})();
