<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package alsalam
 */
defined('ABSPATH') || exit;

get_header();
?>
<main id="main-content" class="site-main py-20 lg:py-32 flex items-center justify-center min-h-[60vh]">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-2xl mx-auto space-y-8">
            <h1 class="text-7xl lg:text-9xl font-bold text-primary opacity-20">404</h1>
            <h2 class="text-3xl lg:text-4xl font-bold">
                <?php esc_html_e('Oops! That page can&rsquo;t be found.', 'alsalam'); ?>
            </h2>
            <p class="text-white/70 text-lg">
                <?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'alsalam'); ?>
            </p>
            <div class="max-w-md mx-auto mt-8">
                <?php get_search_form(); ?>
            </div>
            <div class="pt-8">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-8 py-4 rounded-full font-semibold transition-all shadow-lg shadow-primary/20">
                    <?php esc_html_e('Back to Home', 'alsalam'); ?>
                </a>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
