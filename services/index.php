<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/ — Phase 4 services hub. Lists all 15 config.php services in three
 * groups (8 repair/safety · 5 installs with a featured tile · 2 build/business),
 * plus a symptom → service table. Every fact traces to config.php or the client
 * photos. No estimate tool (integrations.estimate_tool.authorized = false).
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$pageTitle       = 'Electrical Services in Reedsburg, WI | Dellona Electric';
$pageDescription = 'All 15 electrical services from Dellona Electric in Reedsburg, WI: repairs, panels, wiring, lighting, EV chargers, generators and new builds. Call (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/services/';
$currentPage     = 'services';
$pageType        = 'other';

$heroImage   = 'truck-trailer-job-site-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$hubGroups = [
    'repair'  => ['electrical-repair', 'panel-upgrades', 'wiring-rewiring', 'outlet-switch-repair',
                  'emergency-electrician', 'electrical-inspections', 'smoke-detector-installation', 'surge-protection'],
    'install' => ['ev-charger-installation', 'generator-installation', 'lighting-installation', 'ceiling-fan-installation', 'smart-home-wiring'],
    'build'   => ['new-construction-wiring', 'commercial-electrical'],
];

/* Symptom → service guide. Links render only for pages that exist on disk. */
$hubSymptoms = [
    ['A breaker trips again right after you reset it', 'electrical-repair', 'panel-upgrades'],
    ['An outlet is dead, loose, warm or discolored', 'outlet-switch-repair', 'electrical-repair'],
    ['The panel is full, or you are adding a charger, heat pump or addition', 'panel-upgrades', 'ev-charger-installation'],
    ['Two-prong outlets, cloth-covered wire or an older home being remodeled', 'wiring-rewiring', 'electrical-inspections'],
    ['The power goes out and you want the house to keep running', 'generator-installation', 'surge-protection'],
    ['A burning smell, sparking, or part of the house went dark', 'emergency-electrician', 'electrical-repair'],
    ['You are building a house, garage, addition or outbuilding', 'new-construction-wiring', 'lighting-installation'],
    ['A restaurant, shop or office needs lighting, circuits or a repair', 'commercial-electrical', 'lighting-installation'],
];

$schemaGraph = [
    generateWebPageSchema($pageTitle, $pageDescription, $canonicalUrl, '/assets/images/' . $heroImage . '.jpg'),
];
$schemaGraph[0]['@type'] = 'CollectionPage';
$schemaGraph[0]['speakable'] = ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']];
$hubItems = [];
foreach ($services as $hubI => $hubSvc) {
    $hubItems[] = ['@type' => 'ListItem', 'position' => $hubI + 1, 'name' => $hubSvc['name'],
                   'url' => rtrim($siteUrl, '/') . '/services/' . $hubSvc['slug'] . '/'];
}
$schemaGraph[] = ['@type' => 'ItemList', '@id' => $canonicalUrl . '#services', 'name' => $siteName . ' electrical services', 'numberOfItems' => count($services), 'itemListElement' => $hubItems];
$hubCrumbs = generateBreadcrumbSchema([['name' => 'Services', 'url' => '/services/']]);
unset($hubCrumbs['@context']);
$schemaGraph[] = $hubCrumbs;
$schemaMarkup = ['@graph' => $schemaGraph];

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/ hub — grouped grids, numbered group rail, symptom table ==== */
.pg-hub .svc-hero .hero-copy { max-width: 38rem; }
.pg-hub .svc-hero .hero-actions .btn-accent svg { color: var(--color-ink); }
.pg-hub .hub-hero__tag {
  position: absolute; right: var(--space-6); bottom: var(--space-6); z-index: 1;
  background: var(--color-surface); color: var(--color-ink); border-radius: var(--radius); padding: var(--space-3) var(--space-4);
  box-shadow: var(--shadow-lg); display: grid; gap: var(--space-1); max-width: 16rem;
}
.pg-hub .hub-hero__tag b { font-family: var(--font-accent); font-size: var(--font-size-xl); letter-spacing: .02em; line-height: 1; color: var(--color-accent-dark); }
.pg-hub .hub-hero__tag span { font-size: var(--font-size-xs); color: var(--color-muted); }
@media (max-width: 900px) { .pg-hub .hub-hero__tag { display: none; } }

.pg-hub .hub-services { background: var(--color-paper); }
.pg-hub .hub-services .section-title { max-width: none; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); column-gap: var(--space-12); align-items: end; }
.pg-hub .hub-services .section-title .eyebrow-label,
.pg-hub .hub-services .section-title h2,
.pg-hub .hub-services .section-title .section-subtitle { grid-column: 1; }
.pg-hub .hub-services .section-title .hero-answer { grid-column: 2; grid-row: 1 / span 3; font-size: var(--fs-body); max-width: 36rem; }
.pg-hub .hub-services .section-title .prose { grid-column: 1 / -1; margin: 0; }
@media (max-width: 900px) {
  .pg-hub .hub-services .section-title { grid-template-columns: 1fr; }
  .pg-hub .hub-services .section-title .hero-answer { grid-column: 1; grid-row: auto; }
}

/* Group rail: big accent numeral + heading, then the grid */
.pg-hub .hub-group { display: grid; grid-template-columns: minmax(180px, 230px) minmax(0, 1fr); gap: var(--space-8); padding-block: var(--space-10); border-top: 1px solid var(--color-line); }
.pg-hub .hub-group:first-of-type { border-top: 0; }
.pg-hub .hub-group__rail { position: sticky; top: calc(var(--nav-height) + var(--space-6)); align-self: start; display: grid; gap: var(--space-2); }
.pg-hub .hub-group__num { font-family: var(--font-accent); font-size: clamp(2.6rem, 1.8rem + 2.4vw, 4rem); line-height: .9; color: var(--color-accent); }
.pg-hub .hub-group__rail h3 { font-size: var(--fs-h3); }
.pg-hub .hub-group__rail p { margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-hub .hub-group .services-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
.pg-hub .hub-group--install .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.pg-hub .hub-group--install .services-grid--featured > :first-child { grid-column: span 1; grid-row: span 2; }
.pg-hub .hub-group--build .services-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
.pg-hub .hub-group--build .service-card__image { aspect-ratio: 16 / 9; }
@media (max-width: 1200px) { .pg-hub .hub-group .services-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } .pg-hub .hub-group--install .services-grid--featured > :first-child { grid-column: span 2; grid-row: auto; } }
@media (max-width: 900px) { .pg-hub .hub-group { grid-template-columns: 1fr; gap: var(--space-4); } .pg-hub .hub-group__rail { position: static; } }
@media (max-width: 480px) { .pg-hub .hub-group .services-grid, .pg-hub .hub-group--build .services-grid { grid-template-columns: 1fr; } .pg-hub .hub-group--install .services-grid--featured > :first-child { grid-column: auto; } }

/* Symptom guide table */
.pg-hub .hub-guide { background: var(--color-surface); }
.pg-hub .hub-guide .svc-table tbody th { width: 46%; font-family: var(--font-body); font-weight: 600; }
.pg-hub .hub-guide .svc-table a { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-decoration-color: var(--color-accent); text-underline-offset: 3px; }
.pg-hub .hub-guide .svc-table td.is-pick a { color: var(--color-ink); }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-hub">

  <!-- HERO — layered dark band, the crew's truck and trailer on a new-build lot -->
  <section class="hero hero--interior svc-hero" aria-labelledby="hub-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Dellona Electric pickup truck and enclosed trailer, lettered with the company phone number, parked on a new-build lot', ['sizes' => $heroSizes, 'priority' => true]); ?>
      <div class="hub-hero__tag"><b>On site</b><span>The Dellona Electric truck and trailer at a new build</span></div>
    </div>
    <div class="container">
      <nav class="breadcrumb svc-crumbs" aria-label="Breadcrumb"><ol><li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li><li><span aria-current="page">Services</span></li></ol></nav>
      <div class="hero-copy">
        <span class="eyebrow">All services · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
        <h1 class="hero-title" id="hub-title">Electrical services in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
        <p class="hero-answer">Dellona Electric offers <?php echo count($services); ?> electrical services from its base in Reedsburg: repairs and safety work in existing homes, installs such as EV chargers, standby generators, lighting and ceiling fans, and the wiring for new houses, garages, additions and commercial spaces. Each service below has its own page with signs, options and common questions.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-accent btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
          <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
          <li><?php echo icon('home', 16); ?> Homes &amp; new builds</li>
          <li><?php echo icon('building-2', 16); ?> Businesses</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ALL SERVICES — required services-grid pattern, grouped -->
  <section class="section hub-services" aria-labelledby="hub-services-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="hub-services-title">Which electrical services does <span class="text-accent">Dellona Electric</span> offer in <span class="text-accent">Reedsburg</span>?</h2>
        <p class="hero-answer">Dellona Electric's <?php echo count($services); ?> services fall into three groups: repairs and safety work on existing wiring, installs that add something new to a house, and wiring for new construction and commercial buildings. Pick the group that matches your job, then the card closest to it, and each card opens a page written about that one service.</p>
        <span class="section-subtitle">Repairs · Installs · New builds</span>
        <p class="prose">Owner <?php echo e($ownerName); ?>'s company has worked out of <?php echo e($address['street']); ?> in Reedsburg since <?php echo (int) $yearEstablished; ?>, and the photos on these cards are the crew's own jobs.</p>
      </div>

      <div class="hub-group hub-group--repair">
        <div class="hub-group__rail reveal-left">
          <span class="hub-group__num" aria-hidden="true">01</span>
          <h3>Repairs and safety</h3>
          <p>Something isn't working, or you want to know it won't fail. Eight services for existing homes and buildings.</p>
        </div>
        <?php echo p1_service_cards($hubGroups['repair']); ?>
      </div>

      <div class="hub-group hub-group--install">
        <div class="hub-group__rail reveal-left">
          <span class="hub-group__num" aria-hidden="true">02</span>
          <h3>Installs and upgrades</h3>
          <p>Adding something to the house: a charger, backup power, new lighting, fans or smart controls.</p>
        </div>
        <?php echo p1_service_cards($hubGroups['install'], ['class' => 'services-grid--featured', 'featured_label' => 'EV charging']); ?>
      </div>

      <div class="hub-group hub-group--build">
        <div class="hub-group__rail reveal-left">
          <span class="hub-group__num" aria-hidden="true">03</span>
          <h3>New builds and businesses</h3>
          <p>Wiring from the ground up, and electrical work for restaurants, shops and offices.</p>
        </div>
        <?php echo p1_service_cards($hubGroups['build'], ['sizes' => '(max-width: 480px) 100vw, (max-width: 1200px) 50vw, 560px']); ?>
      </div>
    </div>
  </section>

  <!-- SYMPTOM GUIDE — real table -->
  <section class="section hub-guide svc-compare edge-curve-top" aria-labelledby="guide-title">
    <div class="container">
      <div class="svc-head reveal-up">
        <span class="eyebrow">Where to start</span>
        <h2 id="guide-title">Not sure which electrical service fits your problem?</h2>
        <p class="answer-block">Start from what you are seeing, not the name of the service. The table matches eight everyday electrical problems in homes and businesses to the service page that covers them, plus a second page worth reading, so you can describe the job accurately when you call or send the estimate form.</p>
      </div>
      <div class="svc-table-wrap reveal-up">
        <table class="svc-table">
          <caption>Not on the list? Call <?php echo e($phone); ?> and describe it; you'll hear which kind of job it is.</caption>
          <thead><tr><th scope="col">What's going on</th><th scope="col" class="is-pick">Start here</th><th scope="col">Also read</th></tr></thead>
          <tbody>
            <?php foreach ($hubSymptoms as $hubRow):
                $hubMain = p1_service_by_slug($hubRow[1]);
                $hubAlso = p1_service_by_slug($hubRow[2]); ?>
            <tr>
              <th scope="row"><?php echo e($hubRow[0]); ?></th>
              <?php foreach ([[$hubMain, $hubRow[1], true], [$hubAlso, $hubRow[2], false]] as $hubCell):
                  $hubHref = '/services/' . $hubCell[1] . '/'; ?>
              <td<?php echo $hubCell[2] ? ' class="is-pick"' : ''; ?>><?php if (p1_page_exists($hubHref)): ?><a href="<?php echo e($hubHref); ?>"><?php echo e($hubCell[0]['name']); ?></a><?php else: echo e($hubCell[0]['name']); endif; ?></td>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain slant-top" aria-labelledby="hub-cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Talk it through</span>
        <h2 id="hub-cta-title">Have a job that covers more than one service?</h2>
        <p>Plenty do: a panel upgrade before an EV charger, a generator with a transfer switch, new lighting during a remodel. Call <?php echo e($phone); ?> or send the estimate form with everything on your list, and Dellona Electric will call you back to plan it as one job.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
