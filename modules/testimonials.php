<?php
/**
 * Modul: Tilbakemeldinger (Testimonials)
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$title = get_sub_field('testi_title');
$style = get_sub_field('testi_style') ?: 'grid';
$items = get_sub_field('testi_items');

if (empty($items)) return;

$instance_id = 'testimonials-' . uniqid();
?>

<section class="module module--testimonials testimonials testimonials--<?php echo esc_attr($style); ?>"
         id="<?php echo esc_attr($instance_id); ?>">
    <div class="container">

        <?php if ($title) : ?>
        <header class="section-header">
            <h2 class="section-header__title"><?php echo esc_html($title); ?></h2>
        </header>
        <?php endif; ?>

        <?php if ($style === 'slider') : ?>
        <!-- Slider / Karusell -->
        <div class="testimonials__slider" role="list" aria-roledescription="karusell" aria-label="Tilbakemeldinger">
            <?php foreach ($items as $index => $item) :
                $quote        = $item['quote']        ?? '';
                $author_name  = $item['author_name']  ?? '';
                $author_title = $item['author_title'] ?? '';
                $author_photo = $item['author_photo'] ?? null;
                $rating       = (int) ($item['rating'] ?? 5);
            ?>
            <div class="testimonial-card testimonial-card--slide<?php echo $index === 0 ? ' is-active' : ''; ?>"
                 role="listitem" aria-roledescription="element" aria-label="<?php echo esc_attr($index + 1); ?>">
                <?php include __DIR__ . '/../template-parts/testimonial-inner.php'; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($items) > 1) : ?>
        <div class="testimonials__controls" aria-label="Karusell-kontroller">
            <button class="testimonials__prev" aria-label="Forrige">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </button>
            <div class="testimonials__dots">
                <?php foreach ($items as $i => $dot) : ?>
                <button class="testimonials__dot<?php echo $i === 0 ? ' is-active' : ''; ?>"
                        aria-label="<?php printf(esc_attr__('Sitat %d', 'eupnea'), $i + 1); ?>"
                        data-index="<?php echo esc_attr($i); ?>"></button>
                <?php endforeach; ?>
            </div>
            <button class="testimonials__next" aria-label="Neste">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </button>
        </div>
        <?php endif; ?>

        <?php elseif ($style === 'single') : ?>
        <!-- Stort enkelt-sitat -->
        <?php $item = $items[0];
            $quote        = $item['quote']        ?? '';
            $author_name  = $item['author_name']  ?? '';
            $author_title = $item['author_title'] ?? '';
            $author_photo = $item['author_photo'] ?? null;
            $rating       = (int) ($item['rating'] ?? 5);
        ?>
        <div class="testimonials__single">
            <blockquote class="testimonial-quote testimonial-quote--large">
                <p>"<?php echo esc_html($quote); ?>"</p>
                <footer>
                    <?php if ($author_photo) : ?>
                        <?php echo eupnea_image($author_photo, 'thumbnail', 'testimonial-quote__photo'); ?>
                    <?php endif; ?>
                    <cite>
                        <strong><?php echo esc_html($author_name); ?></strong>
                        <?php if ($author_title) : ?>
                            <span><?php echo esc_html($author_title); ?></span>
                        <?php endif; ?>
                    </cite>
                </footer>
            </blockquote>
        </div>

        <?php else : ?>
        <!-- Grid -->
        <div class="testimonials__grid">
            <?php foreach ($items as $item) :
                $quote        = $item['quote']        ?? '';
                $author_name  = $item['author_name']  ?? '';
                $author_title = $item['author_title'] ?? '';
                $author_photo = $item['author_photo'] ?? null;
                $rating       = (int) ($item['rating'] ?? 5);
            ?>
            <div class="testimonial-card">
                <!-- Stjerner -->
                <?php if ($rating > 0) : ?>
                <div class="testimonial-card__stars" aria-label="<?php printf(esc_attr__('%d av 5 stjerner', 'eupnea'), $rating); ?>">
                    <?php for ($s = 1; $s <= 5; $s++) : ?>
                    <span class="star<?php echo $s <= $rating ? ' star--filled' : ''; ?>" aria-hidden="true">★</span>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>

                <blockquote class="testimonial-card__quote">
                    <p>"<?php echo esc_html($quote); ?>"</p>
                </blockquote>

                <footer class="testimonial-card__author">
                    <?php if ($author_photo) : ?>
                        <?php echo eupnea_image($author_photo, 'thumbnail', 'testimonial-card__photo'); ?>
                    <?php endif; ?>
                    <div class="testimonial-card__author-info">
                        <?php if ($author_name) : ?>
                            <cite class="testimonial-card__name"><?php echo esc_html($author_name); ?></cite>
                        <?php endif; ?>
                        <?php if ($author_title) : ?>
                            <span class="testimonial-card__title"><?php echo esc_html($author_title); ?></span>
                        <?php endif; ?>
                    </div>
                </footer>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>
