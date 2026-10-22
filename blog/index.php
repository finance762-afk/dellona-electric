<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /blog/ — Premium "coming soon" placeholder (blog-standard, 2026-10-20).
 * The build writes NO posts: real posts are added later from the design-portal
 * Blogs tab. Until then this page is noindex, follow and stays OUT of sitemap.php,
 * and the homepage carries no "From the Blog" section. Not linked from nav/footer.
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php';

$pageTitle       = 'Electrical Tips Blog, Coming Soon | Dellona Electric';
$pageDescription = 'Dellona Electric in Reedsburg, WI is preparing articles on home wiring, panels, generators and EV chargers. Call (608) 477-8453 with your questions now.';
$canonicalUrl    = $siteUrl . '/blog/';
$currentPage     = 'blog';
$pageType        = 'blog';
$ogType          = 'website';
$robotsMeta      = 'noindex, follow';
$phoneHref       = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_cta_band_css(); ?>
<style>
/* ==== /blog/ placeholder — compact dark hero, topic list, CTA band ==== */
.pg-blog .bl-hero { background: linear-gradient(120deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 120%); position: relative; isolation: isolate; overflow: clip; }
.pg-blog .bl-hero::before { content: ""; position: absolute; z-index: -1; inset: -30% -10% auto 50%; height: 150%; background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 18%, transparent), transparent 70%); pointer-events: none; }
.pg-blog .bl-hero .hero-copy { display: grid; gap: var(--space-4); max-width: 44rem; }
.pg-blog .bl-hero h1 { text-wrap: balance; }
.pg-blog .bl-soon { background: var(--color-paper); }
.pg-blog .bl-soon__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr); gap: var(--space-12); align-items: start; }
.pg-blog .bl-soon h2 { text-wrap: balance; }
.pg-blog .bl-topics { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-4); }
.pg-blog .bl-topics li { display: grid; gap: var(--space-2); padding: var(--space-5); border-radius: var(--radius-lg); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); }
.pg-blog .bl-topics li:nth-child(3n+1) { background: var(--color-card-tint-1); }
.pg-blog .bl-topics li:nth-child(3n+2) { background: var(--color-card-tint-2); }
.pg-blog .bl-topics li:nth-child(3n) { background: var(--color-card-tint-3); }
.pg-blog .bl-topics svg { color: var(--color-accent-dark); }
.pg-blog .bl-topics b { font-family: var(--font-heading); }
.pg-blog .bl-topics a { font-size: var(--font-size-sm); color: var(--color-primary); text-decoration: underline; text-decoration-color: var(--color-accent); text-underline-offset: 3px; }
@media (max-width: 900px) { .pg-blog .bl-soon__grid { grid-template-columns: 1fr; gap: var(--space-8); } }
@media (max-width: 520px) { .pg-blog .bl-topics { grid-template-columns: 1fr; } }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-blog">

  <section class="hero hero--interior bl-hero" aria-labelledby="blog-title">
    <div class="container">
      <div class="hero-copy">
        <span class="eyebrow">Dellona Electric blog</span>
        <h1 class="hero-title" id="blog-title">Electrical tips for Reedsburg homes, coming soon</h1>
        <p class="hero-answer">Dellona Electric is writing its first articles now. Until they're published, the service pages below answer the most common questions, and the crew is a phone call away at <?php echo e($phone); ?>.</p>
      </div>
    </div>
  </section>

  <section class="section bl-soon" aria-labelledby="soon-title">
    <div class="container-wide">
      <div class="bl-soon__grid">
        <div class="section-head">
          <span class="eyebrow">In the meantime</span>
          <h2 id="soon-title">Where can you find answers before the first articles go up?</h2>
          <p>Each Dellona Electric service page covers what the work involves, the warning signs to watch for and the questions people ask before they call.</p>
        </div>
        <ul class="bl-topics">
          <?php foreach ([
              ['wiring-rewiring', 'waypoints', 'Older-home wiring', 'Knob-and-tube, cloth-sheathed cable and two-prong outlets', 'wiring and rewiring'],
              ['panel-upgrades', 'zap', 'Panels and breakers', 'When a panel needs repair, and when it needs more capacity', 'panel upgrades'],
              ['generator-installation', 'power', 'Backup power', 'Standby generators, transfer switches and portable inlets', 'generator installation'],
              ['ev-charger-installation', 'battery-charging', 'EV chargers', 'Level 2 charging on a dedicated 240-volt circuit', 'EV charger installation'],
          ] as $blTopic):
              $blHref = '/services/' . $blTopic[0] . '/';
              if (!p1_page_exists($blHref)) continue; ?>
          <li><?php echo icon($blTopic[1], 22); ?><b><?php echo e($blTopic[2]); ?></b><span><?php echo e($blTopic[3]); ?></span><a href="<?php echo e($blHref); ?>">Read about <?php echo e($blTopic[4]); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </section>

  <?php echo p1_cta_band('Have a question that can\'t wait for an article?', 'Send the basics and ' . $siteName . ' will call you back to talk it through.'); ?>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
