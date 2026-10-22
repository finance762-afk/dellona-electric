<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /service-areas/ — Phase 6 service-area hub.
 * config.php lists one confirmed area (Reedsburg); the research brief's "nearby
 * communities in Sauk County" are unconfirmed, so no other town is named as an area
 * or given a page. The second card is a call-to-confirm card, not an area page.
 * build-plan seo.target_radius (25) is an SEO targeting value, not a confirmed
 * service radius — it is not published. Shop location: Census geocoder places
 * E8981 Briar Bluff Rd in Dellona town, Sauk County, ~6.6 mi ENE of downtown
 * Reedsburg (https://geocoding.geo.census.gov/geocoder/). See the Reedsburg page
 * header for the full source list.
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/area-helpers.php';

$pageTitle       = 'Electrician Service Area: Reedsburg & Sauk County | Dellona Electric';
$pageDescription = 'Where Dellona Electric works: electrical repair in Reedsburg, WI and the surrounding Sauk County area, from a shop on Briar Bluff Rd. Call (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/service-areas/';
$currentPage     = 'service-areas';
$pageType        = 'other';

$heroImage   = 'truck-trailer-job-site-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$schemaMarkup = p1_area_schema(null, $pageTitle, $pageDescription, $canonicalUrl, $heroImage);

/* Area cards: every config.php area, linked only once its page exists. */
$hubAreaCopy = [
    'reedsburg' => [
        'img'  => 'garage-exterior-lighting-night-v1',
        'alt'  => 'Newly built garage lit at night by exterior wall lights',
        'desc' => 'The city on the Baraboo River: 1870s storefronts downtown, pre-1970 homes with cloth-sheathed wiring, newer subdivisions ready for chargers, and a city-owned electric utility.',
        'bullets' => ['Older-home wiring and panels', 'Flood-damaged circuits replaced', 'Upgrades with Reedsburg Utility'],
    ],
];
$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<?php echo p1_area_page_css(); ?>
<style>
/* ==== /service-areas/ — composition: coverage hero card, area cards, framed map with shop card, how-we-confirm steps ==== */
.pg-areas .sa-hero .hero-grid { grid-template-columns: minmax(0, 2fr) minmax(16rem, .7fr); align-items: end; }
.pg-areas .sa-hero .hero-copy { max-width: 52rem; }
.pg-areas .sa-hero .hero-title { max-width: none; }
.pg-areas .sa-hero .hero-answer { max-width: 40rem; }
.pg-areas .sa-coverage { display: grid; gap: var(--space-3); padding: var(--space-6); border-radius: var(--radius-lg); background: color-mix(in srgb, var(--color-dark) 72%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 18%, transparent); backdrop-filter: blur(8px); color: var(--color-white); box-shadow: var(--shadow-lg); }
.pg-areas .sa-coverage h2 { font-size: var(--font-size-lg); color: var(--color-white); }
.pg-areas .sa-coverage ul { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-3); }
.pg-areas .sa-coverage li { display: grid; grid-template-columns: 24px 1fr; gap: var(--space-3); font-size: var(--font-size-sm); color: color-mix(in srgb, var(--color-white) 86%, transparent); }
.pg-areas .sa-coverage li svg { color: var(--color-accent-bright); margin-top: var(--space-1); }
@media (max-width: 900px) { .pg-areas .sa-hero .hero-grid { grid-template-columns: 1fr; } }

.pg-areas .sa-areas { background: var(--color-paper); }
.pg-areas .sa-areas .services-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); max-width: 60rem; }
.pg-areas .sa-elsewhere { display: grid; align-content: center; gap: var(--space-4); padding: var(--space-8); border-radius: var(--radius-lg); border: 2px dashed var(--color-line); background: var(--color-card-tint-neutral); }
.pg-areas .sa-elsewhere__icon { width: 52px; height: 52px; border-radius: var(--radius-full); display: grid; place-items: center; background: var(--color-dark); color: var(--color-accent-bright); }
.pg-areas .sa-elsewhere h3 { font-size: var(--font-size-xl); }
.pg-areas .sa-elsewhere p { margin: 0; color: var(--color-ink-2); }
@media (max-width: 700px) { .pg-areas .sa-areas .services-grid { grid-template-columns: 1fr; } }

.pg-areas .sa-map { background: var(--color-paper-2); }
.pg-areas .sa-map__frame { position: relative; border-radius: var(--radius-xl); box-shadow: var(--shadow-lg); outline: 1px solid var(--color-line); }
.pg-areas .sa-map__frame::after { content: ""; position: absolute; inset: var(--space-8) calc(-1 * var(--space-3)) calc(-1 * var(--space-3)) var(--space-8); border: 2px solid var(--color-accent); border-radius: var(--radius-xl); opacity: .5; z-index: -1; pointer-events: none; }
.pg-areas .sa-map .map-embed { aspect-ratio: 21 / 9; border-radius: var(--radius-xl); background: var(--color-card-tint-2); }
.pg-areas .sa-map .map-embed iframe { filter: grayscale(.85) contrast(1.05); transition: filter var(--transition-slow); }
.pg-areas .sa-map__frame:hover iframe, .pg-areas .sa-map__frame:focus-within iframe { filter: none; }
.pg-areas .sa-map__card { position: absolute; left: var(--space-6); bottom: var(--space-6); z-index: 2; max-width: 20rem; display: grid; gap: var(--space-2); padding: var(--space-5); border-radius: var(--radius-lg); background: var(--color-surface); box-shadow: var(--shadow-lg); }
.pg-areas .sa-map__card b { font-family: var(--font-heading); font-size: var(--font-size-lg); }
.pg-areas .sa-map__card span { font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-areas .sa-map__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.2fr); gap: var(--space-10); align-items: start; margin-bottom: var(--space-10); }
.pg-areas .sa-map__grid .svc-head { margin-bottom: 0; }
@media (max-width: 900px) {
  .pg-areas .sa-map__grid { grid-template-columns: 1fr; gap: var(--space-6); }
  .pg-areas .sa-map .map-embed { aspect-ratio: 4 / 3; }
  .pg-areas .sa-map__card { position: static; max-width: none; margin-top: var(--space-4); }
}
.pg-areas .sa-services { background: var(--color-surface); }
.pg-areas .sa-services .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
@media (max-width: 900px) { .pg-areas .sa-services .services-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 560px) { .pg-areas .sa-services .services-grid { grid-template-columns: 1fr; } }
.pg-areas .sa-all { margin: var(--space-8) 0 0; }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-areas">

  <!-- 1. HERO — truck on a job site, coverage card -->
  <section class="hero hero--interior svc-hero sa-hero" aria-labelledby="sa-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Dellona Electric pickup and enclosed trailer parked on a job site', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_area_breadcrumb(); ?>
      <div class="hero-grid">
        <div class="hero-copy">
          <span class="eyebrow">Service area · Sauk County, Wisconsin</span>
          <h1 class="hero-title" id="sa-title">Electrical Repair Services in <span class="text-accent">Reedsburg</span> &amp; Surrounding Communities</h1>
          <p class="hero-answer">Dellona Electric works in Reedsburg and the surrounding Sauk County area from its shop on Briar Bluff Rd, about six and a half miles east of downtown Reedsburg. If your property is farther out, call with the address for a straight answer.</p>
          <div class="hero-actions">
            <a class="btn btn-primary btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
            <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
          </div>
        </div>
        <aside class="sa-coverage" aria-labelledby="sa-coverage-title">
          <h2 id="sa-coverage-title">Where the crew works</h2>
          <ul>
            <li><?php echo icon('map-pin', 18); ?><span>Shop: E8981 Briar Bluff Rd, Town of Dellona, with a Reedsburg mailing address</span></li>
            <li><?php echo icon('home', 18); ?><span>City of Reedsburg: homes, downtown buildings and businesses</span></li>
            <li><?php echo icon('route', 18); ?><span>The surrounding Sauk County area: call with your address to confirm</span></li>
          </ul>
        </aside>
      </div>
    </div>
  </section>

  <!-- 2. AREA CARDS -->
  <section class="section sa-areas" aria-labelledby="sa-areas-title">
    <div class="container-wide">
      <div class="svc-head reveal-up">
        <span class="eyebrow">Areas served</span>
        <h2 id="sa-areas-title">Which communities does Dellona Electric serve?</h2>
        <p class="answer-block">Dellona Electric's main service area is the City of Reedsburg, which has its own page covering the city's housing, its municipal utility and the Baraboo River. Work elsewhere in the surrounding Sauk County area is confirmed by phone, address by address.</p>
      </div>
      <div class="services-grid">
        <?php foreach ($serviceAreas as $hubI => $hubArea):
            $hubCard = $hubAreaCopy[$hubArea['slug']] ?? null;
            if (!$hubCard) continue;
            $hubTint = ($hubI % 3) + 1;
            $hubHref = areaHref($hubArea); ?>
        <article class="service-card-with-image card-tint-<?php echo $hubTint; ?> reveal-up reveal-delay-<?php echo $hubTint; ?>" id="<?php echo e($hubArea['slug']); ?>">
          <div class="service-card__image"><?php echo p1_picture($hubCard['img'], $hubCard['alt'], ['sizes' => '(max-width: 700px) 100vw, 480px']); ?></div>
          <div class="service-card__body">
            <div class="service-card__icon"><?php echo icon('map-pin', 22); ?></div>
            <h3><?php echo e($hubArea['name']); ?>, <?php echo e($address['state']); ?></h3>
            <p class="service-card__desc"><?php echo e($hubCard['desc']); ?></p>
            <ul><?php foreach ($hubCard['bullets'] as $hubBullet): ?><li><?php echo e($hubBullet); ?></li><?php endforeach; ?></ul>
            <?php if ($hubHref !== '' && strpos($hubHref, '#') === false): ?>
            <a href="<?php echo e($hubHref); ?>" class="service-card__cta">Electrician in <?php echo e($hubArea['name']); ?></a>
            <?php endif; ?>
          </div>
        </article>
        <?php endforeach; ?>
        <div class="sa-elsewhere reveal-up reveal-delay-2">
          <span class="sa-elsewhere__icon"><?php echo icon('route', 24); ?></span>
          <h3>Elsewhere in Sauk County?</h3>
          <p>If your home, farm or business is outside Reedsburg, call <?php echo e($phone); ?> or send the estimate form with your address. You'll hear back whether the job is in range before anything is scheduled.</p>
          <div><button type="button" class="btn btn-primary" data-open-estimate><?php echo e($estimateCtaLabel); ?></button></div>
        </div>
      </div>
    </div>
  </section>

  <!-- 3. MAP — GBP listing embed + shop card -->
  <section class="section sa-map edge-curve-top" aria-labelledby="sa-map-title">
    <div class="container-wide">
      <div class="sa-map__grid">
        <div class="svc-head reveal-left">
          <span class="eyebrow">On the map</span>
          <h2 id="sa-map-title">Where is Dellona Electric located?</h2>
          <p class="answer-block">Dellona Electric's shop is at E8981 Briar Bluff Rd in the Town of Dellona, east of the City of Reedsburg. Most work happens at your home or business, so the map is for orientation, not walk-ins.</p>
        </div>
        <div class="reveal-right">
          <h3 class="sr-only">How a job outside Reedsburg gets confirmed</h3>
          <ol class="area-steps">
            <li><b>Call or send the form</b><span>Include the street address and a line about the job.</span></li>
            <li><b>Distance and timing checked</b><span>Dellona Electric looks at where the property is and when the crew can get there.</span></li>
            <li><b>A straight answer</b><span>You hear whether it's in range before any visit is booked.</span></li>
          </ol>
        </div>
      </div>
      <div class="sa-map__frame reveal-scale">
        <div class="map-embed">
          <iframe src="<?php echo e($gbpMapEmbed); ?>" title="<?php echo e($siteName); ?> on Google Maps" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="sa-map__card">
          <b><?php echo e($siteName); ?></b>
          <span>E8981 Briar Bluff Rd, Reedsburg, WI 53959 · about 6½ miles east of downtown Reedsburg</span>
          <a class="btn btn-primary btn-sm" href="<?php echo e($directionsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('map', 16); ?> Get directions</a>
        </div>
      </div>
    </div>
  </section>

  <!-- 4. SERVICES — required services-grid -->
  <section class="section sa-services edge-wave-top" aria-labelledby="sa-services-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="sa-services-title">What <span class="text-accent">electrical work</span> does Dellona Electric do across Reedsburg and Sauk County?</h2>
        <p class="hero-answer">The same 15 services are available everywhere Dellona Electric works, from troubleshooting a dead circuit to wiring a new home. The three below are where most Reedsburg-area calls start, and the services page lists the full range.</p>
        <span class="section-subtitle">Where most calls start</span>
      </div>
      <?php echo p1_service_cards(['electrical-repair', 'panel-upgrades', 'generator-installation']); ?>
      <?php if (p1_page_exists('/services/')): ?>
      <p class="sa-all reveal-up"><a class="btn btn-secondary" href="/services/">View all <?php echo count($services); ?> services</a></p>
      <?php endif; ?>
    </div>
  </section>

  <!-- 5. CTA -->
  <section class="closing-cta svc-cta texture-grain slant-top" aria-labelledby="sa-cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Estimates</span>
        <h2 id="sa-cta-title">Need an electrician in Reedsburg or nearby?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with your address and what's going on. Dellona Electric will call you back.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
