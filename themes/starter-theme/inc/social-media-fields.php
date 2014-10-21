	<div class="socialmedia">

	<!-- ============= Displays Content From Theme's Option Page: Social Media Links ================-->

		<!-- Important: Update links to assets before using! -->
	
			<!-- Twitter -->
			
			<?php if ( get_field( 'twitter', 'options' ) ) : ?>
			<a href="<?php the_field( 'twitter', 'options' ); ?>" target="_blank" class="social-link" alt="twitter-link" >
			    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/twitter-64.png" alt="twitter" class="social">
			    </a>
			<?php endif; ?>

			<!-- Instagram -->

			<?php if ( get_field( 'instagram', 'options' ) ) : ?>
			<a href="<?php the_field( 'instagram', 'options' ); ?>" target="_blank" class="social-link" alt="instagram-profile">
			    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/instagram-64.png" alt="instagram" class="social">
			    </a>
			<?php endif; ?>

			<!-- Tumblr -->

			<?php if ( get_field( 'tumblr', 'options' ) ) : ?>
			<a href="<?php the_field( 'tumblr', 'options' ); ?>" target="_blank" class="social-link" alt="tumblr-profile">
			    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/tumblr-64.png" alt="tumblr" class="social">
			    </a>
			<?php endif; ?>

			<!-- Linkedin -->

			<?php if ( get_field( 'linkedin', 'options' ) ) : ?>
			<a href="<?php the_field( 'linkedin', 'options' ); ?>" target="_blank" class="social-link" alt="linkedin-profile">
			    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/linkedin-64.png" alt="linkedin" class="social">
			    </a>
			<?php endif; ?>

			<!-- Good Reads -->

			<?php if ( get_field( 'goodreads', 'options' ) ) : ?>
			<a href="<?php the_field( 'goodreads', 'options' ); ?>" target="_blank" class="social-link" alt="good-reads-profile">
			    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/goodreads-64.png" alt="goodreads" class="social">
			    </a>
			<?php endif; ?>

			<!-- Google Plus -->

			<?php if ( get_field( 'google_plus', 'options' ) ) : ?>
			<a href="<?php the_field( 'google_plus', 'options' ); ?>" target="_blank" class="social-link" alt="google-plus-profile">
			    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/google-plus-64.png" alt="googleplus" class="social">
			    </a>
			<?php endif; ?>

			<!-- Email -->


			<?php if ( get_field( 'email', 'options' ) ) : ?>
			 <a href="mailto:<?php the_field( 'email', 'options' ); ?>" target="_blank" class="social-link" alt="email-link">
			    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/email-64.png" alt="email" class="social">
			    </a>
			<?php endif; ?>

	</div>