<!-- Category Description -->

<?php if ( category_description() ) :
    echo '<div class="description">';
        echo category_description();
    echo '</div>';
endif; ?>