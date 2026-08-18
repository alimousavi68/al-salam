<?php
/**
 * Main template file.
 *
 * @package alsalam
 */
defined('ABSPATH') || exit;

get_header(); 
?>
<main id="main-content" class="site-main">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            the_content();
        endwhile;
    else :
        echo '<p>' . esc_html__('No content found.', 'alsalam') . '</p>';
    endif;
    ?>
</main>
<?php
get_footer();
