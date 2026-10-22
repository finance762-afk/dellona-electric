<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /about/ — Phase 5 (archetype: minimal-tech).
 * Every fact traces to build-plan.json / config.php or to what the client's own
 * photos show. The founding story, licence number, insurance, certifications,
 * crew names and dated milestones are NOT in intake — left out of the copy and
 * listed in /content-confirmations.json.
 * Sources (credentials section):
 *   Wis. Stat. § 101.862 — electrical wiring requires a DSPS licence or registration
 *   DSPS credential search — https://licensesearch.wi.gov/
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php';

$pageTitle       = 'About Dellona Electric | Electricians in Reedsburg, WI';
$pageDescription = 'Meet Dellona Electric, the Reedsburg, WI electrical company Edward Giannoni has run since 2018, and see the jobs behind the photos. Call (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/about/';
$currentPage     = 'about';
$pageType        = 'about';

$heroImage   = 'garage-exterior-lighting-night-v1';
$heroSizes   = '(max-width: 900px) 100vw, 52vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

/* Milestones: 2018 and today are the only dates intake supplies. The middle of the
 * timeline is the work itself, one client photo per stop — no invented years. */
$aboutTimeline = [
    ['label' => '2018', 'title' => 'Dellona Electric opens in Reedsburg',
     'text' => 'The company starts taking electrical work in Reedsburg, Wisconsin. Today it runs from E8981 Briar Bluff Rd under owner Edward Giannoni.',
     'big' => 'Est. 2018'],
    ['label' => 'Repairs', 'title' => 'Fixing what is already in the walls',
     'text' => 'Dead outlets, worn switches and circuits that quit. Here, a wall box on beadboard paneling in a sunroom with lake-view windows.',
     'img' => 'sunroom-device-install-v1', 'alt' => 'Dellona Electric electrician kneeling to work on a wall box in a lakeside sunroom'],
    ['label' => 'Panels', 'title' => 'Breakers and panels in the basement',
     'text' => 'Panel repairs and upgrades, with cable bundles fanning out along the joists of an unfinished basement.',
     'img' => 'panel-work-basement-v1', 'alt' => 'Two Dellona Electric electricians working inside an open breaker panel in an unfinished basement'],
    ['label' => 'Chargers', 'title' => 'EV charging in the garage',
     'text' => 'A JuiceBox Level 2 charger on a garage wall, plugged into its own 240-volt outlet.',
     'img' => 'ev-charger-garage-v1', 'alt' => 'Wall-mounted JuiceBox EV charger plugged into a 240-volt outlet on a garage wall'],
    ['label' => 'Backup power', 'title' => 'A standby generator at a log home',
     'text' => 'Two of the crew running conduit beside a Kohler standby generator and the air conditioner it sits next to.',
     'img' => 'standby-generator-log-home-v1', 'alt' => 'Two Dellona Electric electricians running conduit beside a Kohler standby generator at a log home'],
    ['label' => 'New builds', 'title' => 'Lighting a new kitchen',
     'text' => 'Recessed ceiling lights and three pendants over a white island, wired while the house was being built.',
     'img' => 'hero-kitchen-lighting-v1', 'alt' => 'Kitchen with recessed ceiling lights and three pendant lights over a white island'],
    ['label' => 'Commercial', 'title' => 'Pendants over a restaurant bar',
     'text' => 'Commercial lighting under a skylight, above the bar and dining tables of a restaurant.',
     'img' => 'commercial-bar-lighting-v1', 'alt' => 'Restaurant bar interior with pendant lights, a skylight and wood-plank flooring'],
    ['label' => date('Y'), 'title' => $yearsInBusiness . ' years and ' . count($services) . ' services',
     'text' => 'Repairs, upgrades, installs, new construction and commercial work across Reedsburg and the surrounding Sauk County area.',
     'big' => $yearsInBusiness . ' yrs'],
];

/* What to expect — each line restates something the homepage and service pages already say. */
$aboutValues = [
    ['icon' => 'hammer', 'title' => 'One company for fixing and building',
     'text' => 'The crew that tracks down a dead circuit in an older house is the same one that wires new homes, garages and additions. One number covers both.'],
    ['icon' => 'clipboard-check', 'title' => 'The panel gets looked at first',
     'text' => 'Before an EV charger, a generator or an addition is priced, the panel and wiring are checked, so the plan fits what the house can carry.'],
    ['icon' => 'landmark', 'title' => 'Permits talked about up front',
     'text' => 'Panel changes, new circuits and new construction often need a Wisconsin electrical permit. Ask when you call and you will hear whether yours does.'],
    ['icon' => 'eye', 'title' => 'You see what was done',
     'text' => 'When the work is finished you are walked through it, including how to use anything new: a charger, a transfer switch or new controls.'],
];

$schemaGraph = [generateWebPageSchema($pageTitle, $pageDescription, $canonicalUrl, '/assets/images/' . $heroImage . '.jpg')];
$schemaGraph[0]['@type'] = 'AboutPage';
$schemaGraph[0]['mainEntity'] = ['@id' => rtrim($siteUrl, '/') . '/#organization'];
$schemaGraph[0]['speakable'] = ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']];
$schemaGraph[] = [
    '@type'    => 'Person',
    '@id'      => $canonicalUrl . '#owner',
    'name'     => $ownerName,
    'jobTitle' => 'Owner',
    'worksFor' => ['@id' => rtrim($siteUrl, '/') . '/#organization'],
    'workLocation' => ['@type' => 'Place', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => $address['city'], 'addressRegion' => $address['state'], 'addressCountry' => 'US']],
];
$aboutCrumbs = generateBreadcrumbSchema([['name' => 'About', 'url' => '/about/']]);
unset($aboutCrumbs['@context']);
$schemaGraph[] = $aboutCrumbs;
$schemaMarkup = ['@graph' => $schemaGraph];

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_cta_band_css(); ?>
<style>
/* ==== /about/ — page composition: layered photo hero, overlapping story split,
   duotone team panel, alternating photo timeline, credential cards ==== */

/* -- C1.4 page hero: dark brushed band, night photo on the right, glow + grain layers -- */
.pg-about .about-hero { position: relative; isolation: isolate; overflow: clip; background: linear-gradient(120deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 120%); }
.pg-about .about-hero::before {
  content: ""; position: absolute; z-index: -1; pointer-events: none; inset: -20% 40% -10% -15%;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 22%, transparent), transparent 72%);
}
.pg-about .about-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .28; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.55'/%3E%3C/svg%3E");
}
.pg-about .about-hero__media { position: absolute; inset: 0 0 0 48%; z-index: -2; }
.pg-about .about-hero__media picture, .pg-about .about-hero__media img { display: block; width: 100%; height: 100%; object-fit: cover; }
.pg-about .about-hero__media::after {
  content: ""; position: absolute; inset: 0; pointer-events: none;
  background: linear-gradient(90deg, var(--color-dark) 0%, color-mix(in srgb, var(--color-dark) 50%, transparent) 35%, color-mix(in srgb, var(--color-dark) 10%, transparent) 100%);
}
.pg-about .about-hero .hero-copy { display: grid; gap: var(--space-4); max-width: 37rem; padding-block: var(--space-4) var(--space-6); }
.pg-about .about-hero h1 { color: var(--color-white); text-wrap: balance; }
.pg-about .about-hero h1 .text-accent { color: var(--color-accent-bright); }
.pg-about .about-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 86%, transparent); max-width: 34rem; }
.pg-about .about-hero .hero-chips li { background: color-mix(in srgb, var(--color-dark) 55%, transparent); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); backdrop-filter: blur(6px); }
.pg-about .about-hero .hero-chips svg, .pg-about .about-hero .link-call svg { color: var(--color-accent-bright); }
.pg-about .about-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.pg-about .about-crumbs { color: color-mix(in srgb, var(--color-white) 70%, transparent); }
.pg-about .about-crumbs ol { display: flex; flex-wrap: wrap; gap: var(--space-2); align-items: center; }
.pg-about .about-crumbs [aria-current] { color: var(--color-white); }
.pg-about .about-crumbs a:hover { color: var(--color-white); text-decoration: underline; }
@media (max-width: 900px) {
  .pg-about .about-hero__media { inset: 0; }
  .pg-about .about-hero__media::after { background: linear-gradient(180deg, color-mix(in srgb, var(--color-dark) 90%, transparent), color-mix(in srgb, var(--color-dark) 78%, transparent)); }
}

/* -- Shared heads -- */
.pg-about h2, .pg-about h3 { text-wrap: balance; }
.pg-about .ab-head { display: grid; gap: var(--space-3); max-width: 46rem; margin-bottom: var(--space-10); }
.pg-about .ab-head--center { margin-inline: auto; text-align: center; justify-items: center; }
.pg-about p.answer-block { font-size: var(--fs-lead); line-height: 1.55; color: var(--color-ink); margin: 0; }
.pg-about .ab-prose p { color: var(--color-ink-2); max-width: var(--measure); }
.pg-about .ab-prose a:not(.btn) { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-decoration-color: var(--color-accent); text-decoration-thickness: 2px; text-underline-offset: 3px; }

/* -- C6.2 story split: two overlapping client photos + floating badge -- */
.pg-about .ab-story { background: var(--color-paper); }
.pg-about .ab-story .about-split { grid-template-columns: minmax(0, 1.1fr) minmax(0, .9fr); align-items: start; }
.pg-about .ab-story__copy { display: grid; gap: var(--space-4); }
.pg-about .ab-story__copy .pull-quote { margin: var(--space-2) 0; padding-left: var(--space-4); border-left: 4px solid var(--color-accent); font-size: clamp(1.25rem, 1rem + 1.1vw, 1.75rem); max-width: 30ch; }
.pg-about .ab-story .about-image { margin-top: var(--space-6); margin-bottom: var(--space-12); }
.pg-about .ab-story .about-image-primary { aspect-ratio: 3 / 4; }
.pg-about .ab-story .about-image-primary img, .pg-about .ab-story .about-image-secondary img { width: 100%; height: 100%; object-fit: cover; }
.pg-about .ab-story .about-image-secondary { aspect-ratio: 1; right: calc(-1 * var(--space-6)); bottom: calc(-1 * var(--space-10)); width: 48%; border-color: var(--color-paper); }
.pg-about .ab-badge {
  position: absolute; z-index: 3; left: calc(-1 * var(--space-6)); top: var(--space-8);
  background: var(--color-accent); color: var(--color-ink); border-radius: var(--radius); padding: var(--space-3) var(--space-4);
  box-shadow: var(--shadow-lg); display: grid; gap: var(--space-1); transform: rotate(-3deg);
}
.pg-about .ab-badge b { font-family: var(--font-accent); font-size: var(--font-size-xl); letter-spacing: .04em; text-transform: uppercase; line-height: 1; }
.pg-about .ab-badge span { font-size: var(--font-size-xs); font-weight: 600; }
@media (max-width: 900px) {
  .pg-about .ab-story .about-split { grid-template-columns: 1fr; }
  .pg-about .ab-badge { left: var(--space-2); }
  .pg-about .ab-story .about-image-secondary { right: calc(-1 * var(--space-2)); }
}

/* -- Team + values: duotone crew photo beside an owner card, tinted value cards -- */
.pg-about .ab-team { background: var(--color-surface); }
.pg-about .ab-team__grid { display: grid; grid-template-columns: minmax(0, .85fr) minmax(0, 1.15fr); gap: var(--space-12); align-items: start; }
.pg-about .ab-team__people { position: sticky; top: calc(var(--nav-height) + var(--space-6)); display: grid; gap: var(--space-4); }
.pg-about .ab-crew { position: relative; margin: 0; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); aspect-ratio: 4 / 5; }
.pg-about .ab-crew img { width: 100%; height: 100%; object-fit: cover; }
.pg-about .ab-crew::after { content: ""; position: absolute; inset: 0; pointer-events: none; background: linear-gradient(160deg, color-mix(in srgb, var(--color-accent) 30%, transparent), color-mix(in srgb, var(--color-dark) 55%, transparent)); mix-blend-mode: multiply; transition: opacity var(--transition-slow); }
.pg-about .ab-crew:hover::after { opacity: .35; }
.pg-about .ab-crew figcaption { position: absolute; z-index: 1; inset: auto 0 0 0; padding: var(--space-10) var(--space-4) var(--space-3); background: linear-gradient(to top, color-mix(in srgb, var(--color-black) 80%, transparent), transparent); color: var(--color-white); font-size: var(--font-size-sm); }
.pg-about .ab-owner { display: grid; grid-template-columns: auto 1fr; gap: var(--space-1) var(--space-4); align-items: center; background: var(--color-dark); color: var(--color-white); border-radius: var(--radius-lg); padding: var(--space-5); box-shadow: var(--shadow); }
.pg-about .ab-owner__icon { grid-row: span 2; width: 52px; height: 52px; border-radius: var(--radius-full); display: grid; place-items: center; background: color-mix(in srgb, var(--color-accent) 18%, transparent); color: var(--color-accent-bright); }
.pg-about .ab-owner b { font-family: var(--font-heading); font-size: var(--font-size-lg); }
.pg-about .ab-owner span { font-size: var(--font-size-sm); color: color-mix(in srgb, var(--color-white) 75%, transparent); }
.pg-about .ab-values { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-4); margin-top: var(--space-8); }
.pg-about .ab-value { border-radius: var(--radius-lg); padding: var(--space-6); border: 1px solid var(--color-line); display: grid; gap: var(--space-2); align-content: start; box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.pg-about .ab-value:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.pg-about .ab-value:hover .ab-value__icon { transform: rotate(-8deg) scale(1.08); }
.pg-about .ab-value__icon { width: 44px; height: 44px; border-radius: var(--radius); display: grid; place-items: center; background: var(--color-surface); color: var(--color-accent-dark); box-shadow: var(--shadow-sm); transition: transform var(--transition); }
.pg-about .ab-value h3 { font-size: var(--font-size-lg); }
.pg-about .ab-value p { margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
@media (max-width: 900px) { .pg-about .ab-team__grid { grid-template-columns: 1fr; } .pg-about .ab-team__people { position: static; } }
@media (max-width: 560px) { .pg-about .ab-values { grid-template-columns: 1fr; } }

/* -- C7.1 signature: alternating timeline, card one side, client photo the other -- */
.pg-about .ab-timeline { background: var(--color-paper-2); }
.pg-about .tl { list-style: none; margin: 0 auto; padding: 0; max-width: 1000px; position: relative; display: grid; gap: var(--space-10); }
.pg-about .tl::before { content: ""; position: absolute; left: 50%; top: 0; bottom: 0; width: 2px; transform: translateX(-50%); background: linear-gradient(to bottom, var(--color-accent), var(--color-primary)); }
.pg-about .tl-item { display: grid; grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr); gap: var(--space-8); align-items: center; }
.pg-about .tl-node {
  grid-column: 2; grid-row: 1; position: relative; z-index: 1; min-width: 56px; height: 56px; padding-inline: var(--space-3); border-radius: var(--radius-full);
  display: grid; place-items: center; background: var(--color-dark); color: var(--color-accent-bright);
  font-family: var(--font-accent); font-size: var(--font-size-sm); letter-spacing: .08em; text-transform: uppercase; box-shadow: 0 0 0 6px var(--color-paper-2), var(--shadow);
}
.pg-about .tl-card { grid-row: 1; background: var(--color-surface); border-radius: var(--radius-lg); padding: var(--space-6); box-shadow: var(--shadow); display: grid; gap: var(--space-2); }
.pg-about .tl-card h3 { font-size: var(--fs-h3); }
.pg-about .tl-card p { margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-about .tl-side { grid-row: 1; margin: 0; }
.pg-about .tl-side picture, .pg-about .tl-side img { display: block; width: 100%; aspect-ratio: 4 / 3; object-fit: cover; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); }
.pg-about .tl-big { font-family: var(--font-accent); font-size: clamp(2.6rem, 1.8rem + 3vw, 4.4rem); line-height: .9; color: var(--color-accent-dark); letter-spacing: .02em; }
.pg-about .tl-item:nth-child(odd) .tl-card { grid-column: 1; border-right: 4px solid var(--color-accent); text-align: right; }
.pg-about .tl-item:nth-child(odd) .tl-side { grid-column: 3; }
.pg-about .tl-item:nth-child(even) .tl-card { grid-column: 3; border-left: 4px solid var(--color-accent); }
.pg-about .tl-item:nth-child(even) .tl-side { grid-column: 1; text-align: right; }
@media (max-width: 767px) {
  .pg-about .tl::before { left: 27px; }
  .pg-about .tl-item { grid-template-columns: auto minmax(0, 1fr); gap: var(--space-3) var(--space-4); }
  .pg-about .tl-node { grid-column: 1; grid-row: 1 / span 2; align-self: start; min-width: 56px; padding-inline: var(--space-1); font-size: var(--font-size-xs); }
  .pg-about .tl-item:nth-child(n) .tl-card { grid-column: 2; grid-row: 1; text-align: left; border-right: 0; border-left: 4px solid var(--color-accent); }
  .pg-about .tl-item:nth-child(n) .tl-side { grid-column: 2; grid-row: 2; text-align: left; }
}

/* -- Credentials: four check cards with an accent rule -- */
.pg-about .ab-creds { background: var(--color-surface); }
.pg-about .ab-creds__grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-4); }
.pg-about .ab-cred { position: relative; border-radius: var(--radius-lg); padding: var(--space-6) var(--space-5) var(--space-5); border: 1px solid var(--color-line); display: grid; gap: var(--space-2); align-content: start; overflow: hidden; }
.pg-about .ab-cred::before { content: ""; position: absolute; inset: 0 0 auto 0; height: 4px; background: linear-gradient(90deg, var(--color-accent), var(--color-primary)); transform: scaleX(.3); transform-origin: left; transition: transform var(--transition-slow); }
.pg-about .ab-cred:hover::before { transform: scaleX(1); }
.pg-about .ab-cred svg { color: var(--color-accent-dark); }
.pg-about .ab-cred h3 { font-size: var(--font-size-lg); }
.pg-about .ab-cred p { margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-about .ab-cred a { color: var(--color-primary); font-weight: 600; font-size: var(--font-size-sm); text-decoration: underline; text-decoration-color: var(--color-accent); text-underline-offset: 3px; display: inline-flex; gap: var(--space-1); align-items: center; }
@media (max-width: 1000px) { .pg-about .ab-creds__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 560px) { .pg-about .ab-creds__grid { grid-template-columns: 1fr; } }

/* -- C9.2 closing CTA -- */
.pg-about .ab-cta .container-wide { display: grid; grid-template-columns: minmax(0, 1.3fr) auto; gap: var(--space-8); align-items: center; }
.pg-about .ab-cta h2 { max-width: 24ch; margin-bottom: var(--space-3); }
.pg-about .ab-cta p { max-width: 58ch; margin: 0; }
.pg-about .ab-cta .actions { display: flex; flex-wrap: wrap; gap: var(--space-3); }
@media (max-width: 800px) { .pg-about .ab-cta .container-wide { grid-template-columns: 1fr; } }

@media (prefers-reduced-motion: reduce) { .pg-about .ab-value, .pg-about .ab-value:hover, .pg-about .ab-value__icon, .pg-about .ab-cred::before { transition: none; transform: none; } }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-about">

  <!-- HERO — C1.4 page hero, night photo of a new garage the crew lit -->
  <section class="hero hero--interior about-hero" aria-labelledby="about-title">
    <div class="about-hero__media">
      <?php echo p1_picture($heroImage, 'Newly built garage lit up at night by exterior wall lights, with both doors open', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <nav class="breadcrumb about-crumbs" aria-label="Breadcrumb"><ol><li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li><li><span aria-current="page">About</span></li></ol></nav>
      <div class="hero-copy">
        <span class="eyebrow">About us · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
        <h1 class="hero-title" id="about-title">The <?php echo e($address['city']); ?> electricians behind <span class="text-accent"><?php echo e($siteName); ?></span></h1>
        <p class="hero-answer"><?php echo e($siteName); ?> is a Reedsburg, Wisconsin electrical company owned by <?php echo e($ownerName); ?> and working since <?php echo (int) $yearEstablished; ?>. The crew handles repairs and upgrades in existing homes, wiring for new houses, garages and additions, and electrical work in commercial spaces such as restaurants, all from a base on Briar Bluff Rd.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-accent btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
          <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
          <li><?php echo icon('users', 16); ?> Owner <?php echo e($ownerName); ?></li>
          <li><?php echo icon('zap', 16); ?> <?php echo count($services); ?> services</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- STORY — C6.2 overlapping composition -->
  <section class="section ab-story" aria-labelledby="story-title">
    <div class="container">
      <div class="about-split">
        <div class="ab-story__copy ab-prose reveal-left">
          <span class="eyebrow">Our story</span>
          <h2 id="story-title">What kind of electrical company is <span class="text-accent">Dellona Electric</span>?</h2>
          <p class="answer-block">Dellona Electric is a local electrical contractor in Reedsburg, Wisconsin, owned by <?php echo e($ownerName); ?> and in business since <?php echo (int) $yearEstablished; ?>. It takes on everything from one dead outlet to the full wiring of a new house, for homeowners, builders and businesses.</p>
          <p>The company works out of <?php echo e($address['street']); ?> in Reedsburg, and its truck and enclosed trailer carry the company name and phone number on the side. Most jobs fall into three kinds of work: repairs and safety work in houses that are already lived in, installs that add something new, and wiring for buildings that are still going up.</p>
          <blockquote class="pull-quote">Fixing something or building something, it is one number to call.</blockquote>
          <p>The photos on this site are the crew's own jobs, not stock images. They show a JuiceBox charger on a garage wall, conduit run to a Kohler standby generator at a log home, a basement panel with cable fanned along the joists, a new kitchen lit with recessed lights and pendants, and pendant lighting over a restaurant bar.</p>
          <p>If you want to see the full list before you call, the <a href="/services/">services page</a> covers all <?php echo count($services); ?> kinds of work, each with its own page.</p>
        </div>
        <div class="reveal-right">
          <div class="about-image">
            <div class="about-image-primary">
              <?php echo p1_picture('standby-generator-log-home-v1', 'Two Dellona Electric electricians running conduit beside a Kohler standby generator at a log home', ['sizes' => '(max-width: 900px) 90vw, 440px']); ?>
            </div>
            <div class="about-image-secondary">
              <?php echo p1_picture('truck-trailer-job-site-v1', 'Dellona Electric pickup truck and enclosed trailer, lettered with the company phone number, parked on a new-build lot', ['sizes' => '(max-width: 900px) 45vw, 220px']); ?>
            </div>
            <div class="ab-badge"><b>Est. <?php echo (int) $yearEstablished; ?></b><span><?php echo e($address['city']); ?>, Wisconsin</span></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php echo p1_cta_band('Have a job in mind already?', 'Send the basics here and ' . $siteName . ' will call you back to talk it through.'); ?>

  <!-- TEAM + VALUES -->
  <section class="section ab-team edge-curve-top" aria-labelledby="team-title">
    <div class="container-wide">
      <div class="ab-team__grid">
        <div class="ab-team__people reveal-left">
          <figure class="ab-crew img-duotone">
            <?php echo p1_picture('crew-company-truck-v1', 'Two members of the Dellona Electric crew standing beside the lettered company truck', ['sizes' => '(max-width: 900px) 90vw, 440px']); ?>
            <figcaption>Two of the <?php echo e($siteName); ?> crew with the company truck</figcaption>
          </figure>
          <div class="ab-owner">
            <span class="ab-owner__icon"><?php echo icon('users', 24); ?></span>
            <b><?php echo e($ownerName); ?></b>
            <span>Owner, <?php echo e($siteName); ?></span>
          </div>
        </div>
        <div>
          <div class="ab-head reveal-up">
            <span class="eyebrow">The team</span>
            <h2 id="team-title">Who will you deal with at <span class="text-accent">Dellona Electric</span>?</h2>
            <p class="answer-block">Dellona Electric is owned by <?php echo e($ownerName); ?>, and the crew in these photos, in the lettered company truck, is who you will see on site. Calls to <?php echo e($phone); ?> and estimate requests from this website go to the company directly.</p>
          </div>
          <h3 class="reveal-up">What can you expect from a Dellona Electric job?</h3>
          <div class="ab-values">
            <?php foreach ($aboutValues as $abI => $abVal): ?>
            <div class="ab-value card-tint-<?php echo ($abI % 3) + 1; ?> reveal-up reveal-delay-<?php echo ($abI % 4) + 1; ?>">
              <span class="ab-value__icon"><?php echo icon($abVal['icon'], 22); ?></span>
              <h3><?php echo e($abVal['title']); ?></h3>
              <p><?php echo e($abVal['text']); ?></p>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TIMELINE — signature section (C7.1) -->
  <section class="section ab-timeline edge-wave-top" aria-labelledby="timeline-title">
    <div class="container">
      <div class="ab-head ab-head--center reveal-up">
        <span class="eyebrow">Since <?php echo (int) $yearEstablished; ?></span>
        <h2 id="timeline-title">What has <span class="text-accent">Dellona Electric</span> worked on since <?php echo (int) $yearEstablished; ?>?</h2>
        <p class="answer-block">Dellona Electric opened in Reedsburg in <?php echo (int) $yearEstablished; ?>. Between then and now, the story is told through the kinds of work in the crew's own photos, from basement panels and garage chargers to a log-home generator and a restaurant bar.</p>
      </div>
      <ol class="tl">
        <?php foreach ($aboutTimeline as $tlI => $tlItem): ?>
        <li class="tl-item">
          <span class="tl-node"><?php echo e($tlItem['label']); ?></span>
          <div class="tl-card <?php echo $tlI % 2 === 0 ? 'reveal-left' : 'reveal-right'; ?>">
            <h3><?php echo e($tlItem['title']); ?></h3>
            <p><?php echo e($tlItem['text']); ?></p>
          </div>
          <?php if (!empty($tlItem['img'])): ?>
          <figure class="tl-side reveal-scale"><?php echo p1_picture($tlItem['img'], $tlItem['alt'], ['sizes' => '(max-width: 767px) 80vw, 440px']); ?></figure>
          <?php else: ?>
          <div class="tl-side" aria-hidden="true"><span class="tl-big"><?php echo e($tlItem['big']); ?></span></div>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </section>

  <!-- CREDENTIALS — only what can be checked; licence details pending client confirmation -->
  <section class="section ab-creds edge-torn-top" aria-labelledby="creds-title">
    <div class="container-wide">
      <div class="ab-head reveal-up">
        <span class="eyebrow">Credentials</span>
        <h2 id="creds-title">How can you check an electrician's credentials in Wisconsin?</h2>
        <p class="answer-block">Wisconsin law requires anyone installing or repairing electrical wiring to hold a state electrician license or registration from the Department of Safety and Professional Services (DSPS). You can look any electrician up by name on the state's free credential search before work starts.</p>
      </div>
      <div class="ab-creds__grid">
        <div class="ab-cred reveal-up reveal-delay-1">
          <?php echo icon('badge-check', 28); ?>
          <h3>State license lookup</h3>
          <p>DSPS lists every Wisconsin electrician credential and its status. Ask <?php echo e($siteName); ?> for its license number when you call, then check it yourself.</p>
          <a href="https://licensesearch.wi.gov/" target="_blank" rel="noopener">Wisconsin credential search <?php echo icon('external-link', 14); ?></a>
        </div>
        <div class="ab-cred reveal-up reveal-delay-2">
          <?php echo icon('map-pin', 28); ?>
          <h3>Google Business Profile</h3>
          <p><?php echo e($siteName); ?> is listed on Google Maps at <?php echo e($address['street']); ?>, <?php echo e($address['city']); ?>. Customer reviews appear on that listing.</p>
          <a href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener">See the listing <?php echo icon('external-link', 14); ?></a>
        </div>
        <div class="ab-cred reveal-up reveal-delay-3">
          <?php echo icon('landmark', 28); ?>
          <h3>Permits and inspections</h3>
          <p>Inside city limits, electrical permits and inspections go through the City of Reedsburg's Building Inspection department.</p>
          <a href="https://www.reedsburgwi.gov/buildingsafety" target="_blank" rel="noopener">City of Reedsburg permits <?php echo icon('external-link', 14); ?></a>
        </div>
        <div class="ab-cred reveal-up reveal-delay-4">
          <?php echo icon('calendar-check', 28); ?>
          <h3>In business since <?php echo (int) $yearEstablished; ?></h3>
          <p><?php echo $yearsInBusiness; ?> years working in Reedsburg and the surrounding <?php echo e($serviceAreas[0]['county']); ?> County area, under the same name and phone number.</p>
          <a href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 14); ?> <?php echo e($phone); ?></a>
        </div>
      </div>
    </div>
  </section>

  <!-- CLOSING CTA — C9.2 radial glow -->
  <section class="closing-cta ab-cta texture-grain slant-top" aria-labelledby="ab-cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Work with us</span>
        <h2 id="ab-cta-title">Need an electrician in Reedsburg you can call directly?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with a short description of the job. <?php echo e($siteName); ?> will call you back to ask a few questions and set a time to look at it.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
