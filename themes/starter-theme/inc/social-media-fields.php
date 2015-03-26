	 <!-- ==== Displays Content From Theme's Option Page: Social Media Links ===-->

		 <!-- [TO DO] Important: Update links to assets before using! -->

<?php // method for accessible icon fonts: http://www.filamentgroup.com/lab/bulletproof_icon_fonts.html ?>

<?php if ( get_field( 'behance', 'options' ) ) : // <!-- behance --> ?>
    <a href="<?php the_field( 'behance', 'options' ); ?>" target="_blank" class="social-link" alt="behance-profile">
        <span class="icon-fallback-text">
            <span class="fa fa-behance fa-1x" alt="behance" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php e_('Behance'); ?></span>
        </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'bitbucket', 'options' ) ) : // <!-- bitbucket --> ?>
    <a href="<?php the_field( 'bitbucket', 'options' ); ?>" target="_blank" class="social-link" alt="bitbucket-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-bitbucket fa-1x" alt="bitbucket" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('Bitbucket'); ?></span>
        </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'codepen', 'options' ) ) : // <!-- codepen --> ?>
    <a href="<?php the_field( 'codepen', 'options' ); ?>" target="_blank" class="social-link" alt="codepen-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-codepen fa-1x" alt="codepen" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('Codepen'); ?></span>
        </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'dribble', 'options' ) ) : // <!-- dribble --> ?>
    <a href="<?php the_field( 'dribble', 'options' ); ?>" target="_blank" class="social-link" alt="dribble-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-dribble fa-1x" alt="dribble" class="social" aria-hidden="true"></span>
        <span class="icon-text"><?php _e('Dribble'); ?></span>
        </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'email', 'options' ) ) : // <!-- Email --> ?>
     <a href="mailto:<?php the_field( 'email', 'options' ); ?>" target="_blank" class="social-link" alt="email-link">
        <span class="icon-fallback-text"> 
            <span class="fa fa fa-envelope-o fa-1x" alt="email" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('Email'); ?></span>
        </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'flickr', 'options' ) ) : // <!-- flickr --> ?>
    <a href="<?php the_field( 'flickr', 'options' ); ?>" target="_blank" class="social-link" alt="flickr-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-flickr fa-1x" alt="flickr" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('Flickr'); ?></span>
        </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'github', 'options' ) ) : // <!-- github --> ?>
    <a href="<?php the_field( 'github', 'options' ); ?>" target="_blank" class="social-link" alt="github-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-github fa-1x" alt="github" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('Github'); ?></span>
        </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'goodreads', 'options' ) ) : // <!-- Good Reads --> ?>
    <a href="<?php the_field( 'goodreads', 'options' ); ?>" target="_blank" class="social-link" alt="good-reads-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-book fa-1x" alt="goodreads" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('Goodreads'); ?></span>
        </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'google_plus', 'options' ) ) : // <!-- Google Plus --> ?>
    <a href="<?php the_field( 'google_plus', 'options' ); ?>" target="_blank" class="social-link" alt="google-plus-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-google-plus fa-1x" alt="googleplus" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('Google Plus'); ?></span>
        </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'instagram', 'options' ) ) : // <!-- Instagram --> ?>
    <a href="<?php the_field( 'instagram', 'options' ); ?>" target="_blank" class="social-link" alt="instagram-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-instagram fa-1x" alt="instagram" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('Instagram'); ?></span>
    </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'linkedin', 'options' ) ) : // <!-- Linkedin --> ?>
    <a href="<?php the_field( 'linkedin', 'options' ); ?>" target="_blank" class="social-link" alt="linkedin-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-linkedin fa-1x" alt="linkedin" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('LinkedIn'); ?></span>
        </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'pinterest', 'options' ) ) : // <!-- Pinterest --> ?>
    <a href="<?php the_field( 'pinterest', 'options' ); ?>" target="_blank" class="social-link" alt="pinterest-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-pinterest fa-1x" alt="pinterest" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('Pinterest'); ?></span>
        </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'slideshare', 'options' ) ) : // <!-- slideshare --> ?>
    <a href="<?php the_field( 'slideshare', 'options' ); ?>" target="_blank" class="social-link" alt="slideshare-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-slideshare fa-1x" alt="slideshare" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('Slideshare'); ?></span>
        </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'tumblr', 'options' ) ) : // <!-- Tumblr --> ?>
    <a href="<?php the_field( 'tumblr', 'options' ); ?>" target="_blank" class="social-link" alt="tumblr-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-tumblr fa-1x" alt="tumblr" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('Tumblr'); ?></span>
        </span>
    </a>
<?php endif; ?>
	
<?php if ( get_field( 'twitter', 'options' ) ) : // <!-- Twitter -->   ?>
    <a href="<?php the_field( 'twitter', 'options' ); ?>" target="_blank" class="social-link" alt="twitter-link" >
        <span class="icon-fallback-text"> 
            <span class="fa fa-twitter fa-1x" alt="twitter" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e(''); ?></span>
        </span>
    </a>
<?php endif; ?>


<?php if ( get_field( 'vine', 'options' ) ) : // <!-- vine --> ?>
    <a href="<?php the_field( 'vine', 'options' ); ?>" target="_blank" class="social-link" alt="vine-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-vine fa-1x" alt="vine" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('Vine'); ?></span>
        </span>
    </a>
<?php endif; ?>

<?php if ( get_field( 'youtube', 'options' ) ) : // <!-- Youtube --> ?>
    <a href="<?php the_field( 'youtube', 'options' ); ?>" target="_blank" class="social-link" alt="youtube-profile">
        <span class="icon-fallback-text"> 
            <span class="fa fa-youtube fa-1x" alt="youtube" class="social" aria-hidden="true"></span>
            <span class="icon-text"><?php _e('Youtube'); ?></span>
        </span>
    </a>
<?php endif; ?>
