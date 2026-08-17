<?php
/**
 * The template for displaying search results pages
 *
 * @package alsalam
 */
defined('ABSPATH') || exit;

get_header();
?>
<main id="main-content" class="site-main py-20 lg:py-32">
    <div class="container mx-auto px-4">
        <header class="page-header text-center mb-16 space-y-6">
            <h1 class="text-4xl lg:text-5xl font-bold">
                <?php
                /* translators: %s: search query. */
                printf(esc_html(pll__('Search Results for: %s')), '<span>' . get_search_query() . '</span>');
                ?>
            </h1>
            <div class="max-w-2xl mx-auto">
                <?php get_search_form(); ?>
            </div>
        </header>

        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                while (have_posts()) : the_post();
                    // Just a basic card for search results
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden hover:bg-white/10 transition-colors'); ?>>
                        <div class="p-6 space-y-4">
                            <header class="entry-header">
                                <?php the_title(sprintf('<h2 class="text-xl font-bold mb-2"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
                            </header>
                            <div class="entry-summary text-white/70 text-sm">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="inline-flex text-primary hover:text-primary-light font-medium text-sm mt-4">
                                <?php esc_html_e('Read More &rarr;', 'alsalam'); ?>
                            </a>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>
            
            <div class="mt-16 flex justify-center">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => esc_html(pll__('Previous')),
                    'next_text' => esc_html(pll__('Next')),
                    'class'     => 'alsalam-pagination flex gap-2'
                ));
                ?>
            </div>

        <?php else : ?>
            <div class="text-center max-w-2xl mx-auto py-12 space-y-6">
                <p class="text-xl text-white/70"><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'alsalam'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
