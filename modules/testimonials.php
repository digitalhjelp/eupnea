<?php
/**
 * Modul: Tilbakemeldinger – henter fra «Tilbakemeldinger» CPT
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$title = get_sub_field('testi_title');
$style = get_sub_field('testi_style') ?: 'grid';
$limit = (int)(get_sub_field('testi_limit') ?: -1);

$tilbakemeldinger = get_posts([
    'post_type'      => 'tilbakemelding',
    'posts_per_page' => $limit,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);

if (empty($tilbakemeldinger)) return;

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
        <!-- Slider -->
        <div class="testimonials__slider" role="list">
            <?php foreach ($tilbakemeldinger as $i => $tb) :
                $sitat   = get_field('sitat',           $tb->ID);
                $tittel  = get_field('forfatter_tittel', $tb->ID);
                $bilde   = get_field('bilde',           $tb->ID);
                $stars   = (int) get_field('stjerner',  $tb->ID) ?: 5;
                $name    = get_the_title($tb->ID);
            ?>
            <div class="testimonial-card testimonial-card--slide<?php echo $i === 0 ? ' is-active' : ''; ?>" role="listitem">
                <?php eupnea_render_testimonial_card($sitat, $name, $tittel, $bilde, $stars); ?>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($tilbakemeldinger) > 1) : ?>
        <div class="testimonials__controls">
            <button class="testimonials__prev" aria-label="Forrige">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div class="testimonials__dots">
                <?php foreach ($tilbakemeldinger as $i => $d) : ?>
                <button class="testimonials__dot<?php echo $i === 0 ? ' is-active' : ''; ?>"
                        aria-label="Sitat <?php echo $i + 1; ?>"
                        data-index="<?php echo $i; ?>"></button>
                <?php endforeach; ?>
            </div>
            <button class="testimonials__next" aria-label="Neste">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
        <?php endif; ?>

        <?php elseif ($style === 'single' && !empty($tilbakemeldinger[0])) : ?>
        <!-- Stort enkelt-sitat -->
        <?php
            $tb     = $tilbakemeldinger[0];
            $sitat  = get_field('sitat',           $tb->ID);
            $tittel = get_field('forfatter_tittel', $tb->ID);
            $bilde  = get_field('bilde',           $tb->ID);
            $name   = get_the_title($tb->ID);
        ?>
        <div class="testimonials__single">
            <blockquote class="testimonial-quote testimonial-quote--large">
                <p>"<?php echo esc_html($sitat); ?>"</p>
                <footer>
                    <?php if ($bilde) : ?>
                        <img src="<?php echo esc_url($bilde['sizes']['thumbnail'] ?? $bilde['url']); ?>"
                             alt="<?php echo esc_attr($name); ?>"
                             class="testimonial-quote__photo" loading="lazy">
                    <?php endif; ?>
                    <cite>
                        <strong><?php echo esc_html($name); ?></strong>
                        <?php if ($tittel) : ?><span><?php echo esc_html($tittel); ?></span><?php endif; ?>
                    </cite>
                </footer>
            </blockquote>
        </div>

        <?php else : ?>
        <!-- Grid -->
        <div class="testimonials__grid">
            <?php foreach ($tilbakemeldinger as $tb) :
                $sitat   = get_field('sitat',            $tb->ID);
                $tittel  = get_field('forfatter_tittel', $tb->ID);
                $bilde   = get_field('bilde',            $tb->ID);
                $stars   = (int) get_field('stjerner',   $tb->ID) ?: 5;
                $name    = get_the_title($tb->ID);
            ?>
            <div class="testimonial-card">
                <?php eupnea_render_testimonial_card($sitat, $name, $tittel, $bilde, $stars); ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>

<?php
// Hjelpefunksjon for ett testimonial-kort
function eupnea_render_testimonial_card(
    string $sitat,
    string $name,
    string $tittel,
    array|null $bilde,
    int $stars
): void {
    ?>
    <?php if ($stars > 0) : ?>
    <div class="testimonial-card__stars" aria-label="<?php echo $stars; ?> av 5 stjerner">
        <?php for ($s = 1; $s <= 5; $s++) : ?>
        <span class="star<?php echo $s <= $stars ? ' star--filled' : ''; ?>" aria-hidden="true">★</span>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

    <blockquote class="testimonial-card__quote">
        <p>"<?php echo esc_html($sitat); ?>"</p>
    </blockquote>

    <footer class="testimonial-card__author">
        <?php if ($bilde) : ?>
        <img src="<?php echo esc_url($bilde['sizes']['thumbnail'] ?? $bilde['url']); ?>"
             alt="<?php echo esc_attr($name); ?>"
             class="testimonial-card__photo" loading="lazy">
        <?php endif; ?>
        <div class="testimonial-card__author-info">
            <cite class="testimonial-card__name"><?php echo esc_html($name); ?></cite>
            <?php if ($tittel) : ?>
            <span class="testimonial-card__title"><?php echo esc_html($tittel); ?></span>
            <?php endif; ?>
        </div>
    </footer>
    <?php
}
