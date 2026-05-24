<?php
/**
 * Fallback-mal
 *
 * @package Eupnea
 */

get_header();
?>

<div class="container" style="padding: 4rem 1.5rem;">
    <?php if (have_posts()) : ?>
        <header class="archive-header">
            <h1 class="archive-title">
                <?php
                if (is_home()) {
                    esc_html_e('Nyheter', 'eupnea');
                } elseif (is_archive()) {
                    the_archive_title();
                } elseif (is_search()) {
                    printf(esc_html__('Søkeresultater for: %s', 'eupnea'), '<span>' . get_search_query() . '</span>');
                }
                ?>
            </h1>
        </header>

        <div class="posts-grid">
            <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                <?php if (has_post_thumbnail()) : ?>
                <div class="post-card__thumbnail">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium_large'); ?>
                    </a>
                </div>
                <?php endif; ?>
                <div class="post-card__body">
                    <h2 class="post-card__title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="post-card__excerpt"><?php the_excerpt(); ?></div>
                    <a href="<?php the_permalink(); ?>" class="btn btn--outline btn--small">
                        <?php esc_html_e('Les mer', 'eupnea'); ?>
                    </a>
                </div>
            </article>
            <?php endwhile; ?>
        </div>

        <?php the_posts_navigation(); ?>

    <?php else : ?>
        <p><?php esc_html_e('Ingen innhold funnet.', 'eupnea'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
