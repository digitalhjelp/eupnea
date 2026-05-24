<?php
/**
 * Enkelt innlegg
 *
 * @package Eupnea
 */

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
    <div class="container single-post__inner">

        <!-- Topp-meta -->
        <header class="single-post__header">
            <div class="single-post__meta">
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo esc_html(get_the_date()); ?>
                </time>
                <?php if (get_the_category()) : ?>
                <span> · </span>
                <?php the_category(', '); ?>
                <?php endif; ?>
            </div>
            <h1 class="single-post__title"><?php the_title(); ?></h1>
            <?php if (has_post_thumbnail()) : ?>
            <div class="single-post__thumbnail">
                <?php the_post_thumbnail('large'); ?>
            </div>
            <?php endif; ?>
        </header>

        <!-- Innhold -->
        <div class="single-post__content">
            <?php the_content(); ?>
        </div>

        <!-- Navigasjon -->
        <nav class="single-post__nav" aria-label="<?php esc_attr_e('Innleggsnavigasjon', 'eupnea'); ?>">
            <?php the_post_navigation([
                'prev_text' => '← ' . __('Forrige', 'eupnea'),
                'next_text' => __('Neste', 'eupnea') . ' →',
            ]); ?>
        </nav>

    </div>
</article>

<?php
    endwhile;
endif;

get_footer();
