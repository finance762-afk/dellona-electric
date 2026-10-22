<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/surge-protection/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php, the client photos (basement panel
 * job; Kohler standby + York AC condenser at a log home; living room TV wall),
 * NEC 230.67 (surge protective device required on dwelling services, including
 * replaced service equipment — added in the 2020 edition, absent from the 2017
 * edition Wisconsin used until 2026), SPD Type 1/2/3 placement, and the sources
 * below. Prices, device brands and warranties are unconfirmed (content-confirmations.json).
 * Sources:
 *   Wisconsin adopts the 2023 NEC, replacing the 2017 edition (DSPS, signed Sept 1 2026) —
 *     https://www.ecmweb.com/national-electrical-code/article/55403844/wisconsin-adopts-2023-national-electrical-code
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'surge-protection';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'Whole-House Surge Protection Reedsburg WI | Dellona Electric';
$pageDescription = 'Whole-house surge protection installed at the panel in Reedsburg, WI by Dellona Electric, guarding furnaces, AC units and electronics. Call (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'panel-work-basement-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Want your whole house protected?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'Whole-house surge protection',
    'description' => 'A surge protective device installed at the main panel to limit voltage spikes on every circuit, protecting furnaces, air conditioners, well pumps, appliances and electronics, in Reedsburg, WI and the surrounding Sauk County area.',
]);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/surge-protection/ — page composition: layers-of-protection diagram, 230.67 stat, strip-vs-panel table ==== */
.pg-surge .svc-signs .bento-grid { grid-template-columns: repeat(6, 1fr); }
.pg-surge .svc-signs .bento-large { grid-column: span 6; grid-row: auto; }
.pg-surge .svc-signs .bento-medium, .pg-surge .svc-signs .bento-small { grid-column: span 2; grid-row: auto; }
@media (max-width: 800px) { .pg-surge .svc-signs .bento-medium, .pg-surge .svc-signs .bento-small { grid-column: span 6; } }

/* Signature: three nested layers, from the service drop in to the outlet */
.pg-surge .surge-layers { list-style: none; margin: var(--space-6) 0 0; padding: 0; display: grid; gap: 0; }
.pg-surge .surge-layers li {
  position: relative; display: grid; grid-template-columns: auto minmax(0, 1fr); gap: var(--space-1) var(--space-4); align-items: start;
  padding: var(--space-4) var(--space-5); border: 1px solid var(--color-line); border-top-width: 0;
}
.pg-surge .surge-layers li:first-child { border-top-width: 1px; border-radius: var(--radius-lg) var(--radius-lg) 0 0; background: var(--color-card-tint-2); }
.pg-surge .surge-layers li:nth-child(2) { margin-inline: var(--space-4); background: var(--color-card-tint-3); border-color: color-mix(in srgb, var(--color-accent) 50%, var(--color-line)); box-shadow: var(--shadow); z-index: 1; }
.pg-surge .surge-layers li:last-child { margin-inline: var(--space-8); border-radius: 0 0 var(--radius-lg) var(--radius-lg); background: var(--color-surface); }
.pg-surge .surge-layers em { grid-row: span 2; font-style: normal; font-family: var(--font-accent); font-size: var(--font-size-sm); letter-spacing: .1em; text-transform: uppercase; color: var(--color-white); background: var(--color-primary); border-radius: var(--radius-sm); padding: var(--space-1) var(--space-2); }
.pg-surge .surge-layers li:nth-child(2) em { background: var(--color-accent-dark); }
.pg-surge .surge-layers b { font-family: var(--font-heading); color: var(--color-ink); }
.pg-surge .surge-layers span { font-size: var(--font-size-sm); color: var(--color-ink-2); }
@media (max-width: 560px) { .pg-surge .surge-layers li:nth-child(2) { margin-inline: var(--space-2); } .pg-surge .surge-layers li:last-child { margin-inline: var(--space-4); } }

/* Expert: landscape living-room photo, code-section stat */
.pg-surge .svc-expert__figure .img-framed { aspect-ratio: 4 / 3; }
.pg-surge .svc-expert__stat b { font-size: clamp(2.2rem, 1.5rem + 2.2vw, 3.2rem); }
.pg-surge .svc-compare { background: var(--color-paper-2); }
.pg-surge .svc-proof__photo { aspect-ratio: 3 / 4; max-height: 600px; }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-surge">

  <!-- 1. HERO — layered dark band, client panel photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Two Dellona Electric electricians working inside an open breaker panel in a basement', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Surge protection · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="svc-title">Whole-house surge protection in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric installs whole-house surge protection in Reedsburg and the surrounding Sauk County area: a surge protective device mounted at your main panel that limits voltage spikes before they reach the furnace, air conditioner, well pump, appliances and electronics on every circuit in the house.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
            <li><?php echo icon('shield-check', 16); ?> Mounted at the panel</li>
            <li><?php echo icon('layers', 16); ?> Every circuit</li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- 2. PROBLEM STATEMENT — pull quote + where spikes come from -->
    <section class="section svc-signs" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-left">
            <span class="eyebrow">Where surges come from</span>
            <h2 id="signs-title">When does a home need whole-house surge protection?</h2>
            <p class="answer-block">A home needs whole-house surge protection once its costly equipment runs on circuit boards, which now covers the furnace, air conditioner, washer, range and most refrigerators. Summer thunderstorms, power returning after an outage and big motors cycling inside the house all send spikes down the same wiring.</p>
            <p class="pull-quote">A power strip guards one outlet. A device at the panel guards the furnace that was never plugged into one.</p>
          </div>
          <div class="bento-grid">
            <div class="bento-large svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('home', 20); ?></span>
              <h3>Circuit boards in everything</h3>
              <p>Furnace controls, AC condensers, washers, ranges, garage door openers and EV chargers all run on electronics now. They are hardwired or plugged in behind the appliance, so a strip by the TV never sees them.</p>
            </div>
            <div class="bento-medium svc-sign reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('zap', 20); ?></span>
              <h3>Summer storms</h3>
              <p>Lightning nearby can push a spike down the service drop and into every circuit at once.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('power', 20); ?></span>
              <h3>Power coming back</h3>
              <p>The moment power is restored after an outage is a common spike.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('repeat', 20); ?></span>
              <h3>Motors inside the house</h3>
              <p>A well pump or AC compressor switching on and off makes small spikes of its own, many times a day.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. SERVICE BREAKDOWN — what's included + layers diagram + sticky process -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="included-title">
      <div class="container-wide">
        <div class="svc-breakdown__grid">
          <div class="svc-breakdown__sticky svc-body reveal-left">
            <span class="eyebrow">What's included</span>
            <h2 id="included-title">What's included in a whole-house surge protection installation?</h2>
            <p class="answer-block">A whole-house surge protection installation mounts a surge protective device at your main panel, wired with leads kept as short as possible. The job includes a look at the home's grounding, because the device can only send a spike to ground if that path is sound, and it ends with the status lights checked.</p>
            <ul class="svc-checklist">
              <li><?php echo icon('check', 18); ?><span><strong>Space in the panel</strong> for the device's breaker, or the connection its maker lists for your panel.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Short, straight leads.</strong> Every extra inch of wire between the device and the bus lets more of a spike through.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>A grounding and bonding check,</strong> since a surge device without a good path to ground can't do its job.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Status lights you can see</strong> when the panel door is open, so you know the protection is still active.</span></li>
            </ul>
            <ol class="surge-layers" aria-label="Three layers of surge protection, outside in">
              <li><em>Type 1</em><b>At the service</b><span>Installed ahead of the main breaker, at or near the meter. Catches spikes from outside.</span></li>
              <li><em>Type 2</em><b>At the main panel</b><span>The usual whole-house device. Covers every branch circuit, hardwired or plugged in.</span></li>
              <li><em>Type 3</em><b>At the outlet</b><span>Plug-in strips for the TV, computer and router. A last layer, not the first.</span></li>
            </ol>
          </div>
          <div class="reveal-right">
            <h3 class="sr-only">How a whole-house surge protection installation goes, step by step</h3>
            <ol class="svc-steps">
              <li><h3>Open the panel and look at the grounding</h3><p>Panel brand, free space, and the grounding electrode conductor and bonding. If the ground is poor, that gets fixed as part of the job, not skipped.</p></li>
              <li><h3>Choose the device</h3><p>A Type 1 or Type 2 device suited to your panel and service, with a status indicator you can read at a glance.</p></li>
              <li><h3>Install with the power off</h3><p>The main is shut off, the device is mounted as close to the bus as the panel allows, and its leads are trimmed short and run straight.</p></li>
              <li><h3>Power up and show you the lights</h3><p>The main goes back on, the indicators are checked, and you learn what a healthy light looks like. A device that has absorbed a large surge can wear out, and the light is how you know it's time to replace it.</p></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. EXPERT POSITIONING — 60/40 split, code-section stat, evidence from the client's own jobs -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-left">
            <div class="img-framed">
              <?php echo p1_picture('living-room-ceiling-fan-v1', 'Living room TV wall with a recessed media box, backlit niches, an electric fireplace insert and recessed ceiling lights', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>230.67</b><span>The National Electrical Code section that requires surge protection on home services.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-right">
            <span class="eyebrow">Panel first, strips second</span>
            <h2 id="expert-title">Why put surge protection at the panel instead of relying on power strips?</h2>
            <p class="answer-block">A device at the panel catches spikes on every circuit at once, including hardwired equipment like the furnace, AC condenser and well pump that never plug into a strip. Point-of-use strips still earn their place at the TV and computer, where they trim what little gets past the panel device.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('zap', 22); ?><b>It is panel work</b><span>A whole-house device lives inside or beside the breaker panel, the same box the crew is working in at the top of this page.</span></li>
              <li><?php echo icon('clipboard-check', 22); ?><b>Code now asks for it on new and replaced services</b><span>Section 230.67 first appeared in the 2020 code. Wisconsin skipped from the 2017 edition straight to the 2023 edition on September 1, 2026, so homes here getting a new or replaced service now get a surge device with it. The <a href="/services/panel-upgrades/">panel upgrade page</a> covers that work.</span></li>
              <li><?php echo icon('battery-charging', 22); ?><b>Chargers, generators and TV walls</b><span>A wall like the one in this photo, an <a href="/services/ev-charger-installation/">EV charger in the garage</a> or a standby generator's controller are all electronics worth guarding. Surge protection is one of <?php echo count($services); ?> services on the <a href="/services/">Dellona Electric services list</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. COMPARISON — strips vs whole-house vs both, as a real table -->
    <section class="section svc-compare" aria-labelledby="compare-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Strip, panel or both</span>
          <h2 id="compare-title">Do you need power strips, a whole-house surge device, or both?</h2>
          <p class="answer-block">Most homes are best served by both: a whole-house device at the panel takes the big hit, and surge strips at sensitive electronics catch what is left. A strip alone leaves hardwired equipment unprotected, and a panel device alone does nothing for spikes that come in on cable TV, internet or phone lines.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>General guidance. Neither layer makes equipment immune to a direct lightning strike.</caption>
            <thead>
              <tr><th scope="col">Compare</th><th scope="col">Surge strip at the outlet</th><th scope="col">Whole-house device at the panel</th><th scope="col" class="is-pick">Both together</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">Furnace, AC, well pump</th><td>Not protected</td><td>Protected</td><td class="is-pick"><strong>Protected</strong></td></tr>
              <tr><th scope="row">TV, computer, router</th><td>Protected at that outlet</td><td>Protected from spikes on the power wiring</td><td class="is-pick"><strong>Two layers</strong> on the most sensitive gear</td></tr>
              <tr><th scope="row">Spikes on cable or phone lines</th><td>Only if the strip has coax or phone ports</td><td>No</td><td class="is-pick">Covered by the strip's ports</td></tr>
              <tr><th scope="row">Spikes made inside the house</th><td>Only at that outlet</td><td>Reduced across all circuits</td><td class="is-pick">Reduced everywhere, trimmed again at the outlet</td></tr>
              <tr><th scope="row">Who installs it</th><td>You</td><td>An electrician, at the panel</td><td class="is-pick">One panel visit, then plug in strips</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- 6. PROOF — dark grain band, captioned client photo, Google profile -->
    <section class="section svc-proof texture-grain slant-top" aria-labelledby="proof-title">
      <span class="grain-layer" aria-hidden="true"></span>
      <div class="container">
        <div class="svc-proof__grid">
          <figure class="svc-proof__photo reveal-left">
            <?php echo p1_picture('standby-generator-log-home-v1', 'York air conditioner condenser and a Kohler standby generator side by side at a log home, with electricians working beside them', ['sizes' => '(max-width: 900px) 92vw, 520px']); ?>
            <figcaption>An AC condenser and a standby generator, both hardwired and both run by circuit boards.</figcaption>
          </figure>
          <div class="svc-proof__copy reveal-right">
            <span class="eyebrow">From the job site</span>
            <h2 id="proof-title">What equipment does whole-house surge protection actually guard?</h2>
            <p class="answer-block">This Dellona Electric job photo shows what whole-house surge protection is for: a York air conditioner and a Kohler standby generator, side by side at a log home. Both are hardwired, both are run by circuit boards, and neither will ever be plugged into a power strip.</p>
            <p>The photo comes from a generator installation, not a surge device install. It is here because it shows the kind of equipment a panel device protects. Dellona Electric's reviews are on its Google Business Profile.</p>
            <div class="actions">
              <a class="btn btn-accent" href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?> See Dellona Electric on Google</a>
              <a class="btn btn-outline-white" href="<?php echo e($reviewRequestUrl); ?>" target="_blank" rel="noopener">Leave a review</a>
            </div>
          </div>
        </div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
        echo p1_google_reviews($slug, ['heading' => '', 'limit' => 3]);
        ?>
      </div>
    </section>

    <!-- 7. FAQ — questions from the research brief, made specific to surge protection -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do homeowners ask about whole-house surge protection?</h2>
          <p class="answer-block">Homeowners asking about whole-house surge protection usually want to know two things: what it costs and whether Wisconsin now requires it. The cost depends on your panel and grounding, and the requirement depends on whether your service is new or being replaced, so both answers are explained below.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does whole-house surge protection cost?</summary>
          <p>The cost of whole-house surge protection depends on the device type, whether your panel has room for it, and whether the grounding needs work before it can do its job. Adding it while a panel is already open for other work saves a separate visit. Call <?php echo e($phone); ?> and Dellona Electric will look at the panel before pricing it.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Is whole-house surge protection required in Wisconsin now?</summary>
          <p>For new and replaced home services, yes. Section 230.67 of the National Electrical Code requires a surge protective device on dwelling services, and Wisconsin's adoption of the 2023 edition in September 2026 brought that rule in; the 2017 edition used before it had no such requirement. Existing homes aren't required to add one, but any home can.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What other electrical work fits with <span class="text-accent">surge protection</span>?</h2>
        <p class="hero-answer">Surge protection sits at the panel, so it pairs naturally with panel replacements, where current code now expects it. It also protects the most electronics-heavy things a home adds: an EV charger in the garage and a standby generator with its own control board. Each of those jobs has its own page below.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <?php echo p1_service_cards(['panel-upgrades', 'ev-charger-installation', 'generator-installation']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Surge protection estimate</span>
        <h2 id="cta-title">Ready to protect the furnace and AC before the next storm?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with your panel's brand and any equipment you're worried about. Dellona Electric will call you back to talk through the device and the install.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
