	<div class="socialmedia">

	<!-- ============= Displays Content From Theme's Option Page: Social Media Links ================-->

		<!-- Important: Update links to assets before using! -->
	
			<!-- Twitter -->
			
			<?php if ( get_field( 'twitter', 'options' ) ) : ?>
			<a href="<?php the_field( 'twitter', 'options' ); ?>" target="_blank" class="social-link" alt="twitter-link" >
			    <i class="fa fa-twitter fa-2x" alt="twitter" class="social"></i>
			    </a>
			<?php endif; ?>

			<!-- Instagram -->

			<?php if ( get_field( 'instagram', 'options' ) ) : ?>
			<a href="<?php the_field( 'instagram', 'options' ); ?>" target="_blank" class="social-link" alt="instagram-profile">
			    <i class="fa fa-instagram fa-2x" alt="instagram" class="social"></i>
			    </a>
			<?php endif; ?>

			<!-- Tumblr -->

			<?php if ( get_field( 'tumblr', 'options' ) ) : ?>
			<a href="<?php the_field( 'tumblr', 'options' ); ?>" target="_blank" class="social-link" alt="tumblr-profile">
			    <i class="fa fa-tumblr fa-2x" alt="tumblr" class="social"></i>
			    </a>
			<?php endif; ?>

			<!-- Linkedin -->

			<?php if ( get_field( 'linkedin', 'options' ) ) : ?>
			<a href="<?php the_field( 'linkedin', 'options' ); ?>" target="_blank" class="social-link" alt="linkedin-profile">
			    <i class="fa fa-linkedin fa-2x" alt="linkedin" class="social"></i>
			    </a>
			<?php endif; ?>

			<!-- Good Reads -->

			<?php if ( get_field( 'goodreads', 'options' ) ) : ?>
			<a href="<?php the_field( 'goodreads', 'options' ); ?>" target="_blank" class="social-link" alt="good-reads-profile">
			    <i class="fa fa-book fa-2x" alt="goodreads" class="social"></i>
			    </a>
			<?php endif; ?>

			<!-- Google Plus -->

			<?php if ( get_field( 'google_plus', 'options' ) ) : ?>
			<a href="<?php the_field( 'google_plus', 'options' ); ?>" target="_blank" class="social-link" alt="google-plus-profile">
			    <i class="fa fa-google-plus fa-2x" alt="googleplus" class="social"></i>
			    </a>
			<?php endif; ?>

			<!-- Email -->

			<?php if ( get_field( 'email', 'options' ) ) : ?>
			 <a href="mailto:<?php the_field( 'email', 'options' ); ?>" target="_blank" class="social-link" alt="email-link">
			    <i class="fa fa fa-envelope-o fa-2x" alt="email" class="social"></i>
			    </a>
			<?php endif; ?>

	</div>