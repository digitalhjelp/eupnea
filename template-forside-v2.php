<?php
/**
 * Template Name: Forside v2 – Ny design
 *
 * En modernisert forside-mal for Eupnea.no som bygger på
 * det eksisterende designsystemet fra sense.eupnea.no.
 *
 * @package Eupnea
 */

get_header();
?>

<!-- ─────────────────────────────────────────────────────────────────
     HERO
───────────────────────────────────────────────────────────────────── -->
<?php
$hero_badge      = get_field('hero_badge')       ?: 'Norsk coaching &amp; lederutvikling';
$hero_heading    = get_field('hero_heading')      ?: 'Pust dypere. Led bedre. Veks roligere.';
$hero_subheading = get_field('hero_subheading')   ?: 'Eupnea hjelper ledere og organisasjoner med å skape bærekraftig vekst gjennom bevisst lederskap, indre ro og høy ytelse.';
$hero_cta_1_label = get_field('hero_cta_1_label') ?: 'Se våre programmer';
$hero_cta_1_url   = get_field('hero_cta_1_url')   ?: '#programmer';
$hero_cta_2_label = get_field('hero_cta_2_label') ?: 'Lær om oss';
$hero_cta_2_url   = get_field('hero_cta_2_url')   ?: '#om-oss';
$hero_stats       = get_field('hero_stats')       ?: [];
?>

<section class="fv2-hero" aria-label="Hero-seksjon">
    <div class="fv2-hero__bg" aria-hidden="true"></div>
    <div class="fv2-hero__decor" aria-hidden="true">
        <div class="fv2-hero__decor-circle fv2-hero__decor-circle--1"></div>
        <div class="fv2-hero__decor-circle fv2-hero__decor-circle--2"></div>
        <div class="fv2-hero__decor-circle fv2-hero__decor-circle--3"></div>
    </div>
    <div class="fv2-hero__dots" aria-hidden="true"></div>

    <div class="container fv2-hero__content">

        <?php if ($hero_badge) : ?>
        <div class="fv2-hero__badge">
            <span class="fv2-hero__badge-dot" aria-hidden="true"></span>
            <?php echo wp_kses_post($hero_badge); ?>
        </div>
        <?php endif; ?>

        <?php if ($hero_heading) : ?>
        <h1 class="fv2-hero__heading">
            <?php echo wp_kses_post($hero_heading); ?>
        </h1>
        <?php endif; ?>

        <?php if ($hero_subheading) : ?>
        <p class="fv2-hero__subheading"><?php echo esc_html($hero_subheading); ?></p>
        <?php endif; ?>

        <div class="fv2-hero__buttons">
            <?php if ($hero_cta_1_label && $hero_cta_1_url) : ?>
                <?php echo eupnea_button($hero_cta_1_label, $hero_cta_1_url, 'primary'); ?>
            <?php endif; ?>
            <?php if ($hero_cta_2_label && $hero_cta_2_url) : ?>
                <?php echo eupnea_button($hero_cta_2_label, $hero_cta_2_url, 'outline'); ?>
            <?php endif; ?>
        </div>

        <?php if ($hero_stats) : ?>
        <div class="fv2-hero__stats">
            <?php foreach ($hero_stats as $stat) :
                $number = $stat['number'] ?? '';
                $label  = $stat['label']  ?? '';
                if (!$number) continue;
            ?>
            <div class="fv2-hero__stat">
                <span class="fv2-hero__stat-number"><?php echo esc_html($number); ?></span>
                <?php if ($label) : ?>
                    <span class="fv2-hero__stat-label"><?php echo esc_html($label); ?></span>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>

    <!-- Pusteanimasjon høyre side -->
    <div class="fv2-hero__visual" aria-hidden="true">
        <div class="fv2-breathing-ring">
            <div class="fv2-breathing-ring__circle"></div>
            <div class="fv2-breathing-ring__circle"></div>
            <div class="fv2-breathing-ring__circle"></div>
            <div class="fv2-breathing-ring__circle"></div>
            <div class="fv2-breathing-ring__circle fv2-breathing-ring__circle--fill"></div>
            <div class="fv2-breathing-ring__text">
                <span class="fv2-breathing-ring__word">eupnea</span>
                <span class="fv2-breathing-ring__sub"><?php esc_html_e('normal, rolig pust', 'eupnea'); ?></span>
            </div>
        </div>
    </div>

    <div class="fv2-hero__scroll" aria-hidden="true">
        <span class="fv2-hero__scroll-label"><?php esc_html_e('Scroll', 'eupnea'); ?></span>
        <span class="fv2-hero__scroll-line"></span>
    </div>
</section>

<!-- ─────────────────────────────────────────────────────────────────
     PARTNERE (strip)
───────────────────────────────────────────────────────────────────── -->
<?php
$partners_label = get_field('partners_strip_label') ?: __('Brukt av ledere i', 'eupnea');
$partners       = get_field('partners_strip_items') ?: [];
if ($partners_label || $partners) :
?>
<div class="fv2-partners-strip">
    <?php if ($partners_label) : ?>
        <p class="fv2-partners-strip__label"><?php echo esc_html($partners_label); ?></p>
    <?php endif; ?>
    <?php if ($partners) : ?>
    <div class="fv2-partners-strip__row">
        <?php foreach ($partners as $index => $partner) :
            $name = $partner['name'] ?? '';
            if (!$name) continue;
        ?>
            <?php if ($index > 0) : ?>
                <span class="fv2-partners-strip__dot" aria-hidden="true"></span>
            <?php endif; ?>
            <?php if (!empty($partner['url'])) : ?>
                <a href="<?php echo esc_url($partner['url']); ?>" class="fv2-partner-item" target="_blank" rel="noopener noreferrer">
                    <?php echo esc_html($name); ?>
                </a>
            <?php else : ?>
                <span class="fv2-partner-item"><?php echo esc_html($name); ?></span>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- ─────────────────────────────────────────────────────────────────
     FLEKSIBELT INNHOLD (resterende seksjoner via ACF)
───────────────────────────────────────────────────────────────────── -->
<?php if (have_posts()) :
    while (have_posts()) :
        the_post();
        get_template_part('template-parts/flexible-content');
    endwhile;
endif; ?>

<?php get_footer(); ?>
