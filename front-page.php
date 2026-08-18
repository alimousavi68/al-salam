<?php
/**
 * Template Name: Front Page
 * The template for displaying the front page
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="flex-grow">
    <h1 class="sr-only"><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></h1>

    <?php
    get_template_part('template-parts/front-page/hero');
    get_template_part('template-parts/front-page/about');
    get_template_part('template-parts/front-page/infrastructure');
    get_template_part('template-parts/front-page/products');
    get_template_part('template-parts/front-page/gallery');
    get_template_part('template-parts/front-page/why-choose-us');
    get_template_part('template-parts/front-page/news');
    get_template_part('template-parts/front-page/testimonials');
    get_template_part('template-parts/front-page/features-marquee');
    ?>
</main>

<?php
get_footer();
