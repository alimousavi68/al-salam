<?php
/**
 * The template for displaying all single pages
 *
 * @package alsalam
 */
defined('ABSPATH') || exit;

get_header();
?>
<main id="main-content" class="site-main py-20 lg:py-32">
    <div class="container mx-auto px-4 max-w-4xl">
        <?php
        while (have_posts()) : the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header mb-12 text-center space-y-6">
                    <?php the_title('<h1 class="text-4xl lg:text-5xl font-bold">', '</h1>'); ?>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="mt-8 rounded-3xl overflow-hidden shadow-2xl">
                            <?php the_post_thumbnail('full', array('class' => 'w-full h-auto')); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="entry-content prose prose-invert prose-primary max-w-none prose-lg">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links mt-8">' . esc_html__('Pages:', 'alsalam'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>
            </article>
            <?php
        endwhile;
        ?>
    </div>
</main>
<?php
get_footer();
