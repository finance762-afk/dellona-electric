<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/ev-charger-installation/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php, the client photo of the JuiceBox
 * install, general NEC practice (EV charging is a continuous load sized at 125%;
 * NEMA 14-50 receptacles top out at a 50 A circuit; 2023 NEC 210.8(A) GFCI on
 * 250 V garage receptacles) and the public sources below. Prices, permit handling,
 * charger brands and timelines are unconfirmed (content-confirmations.json).
 * Sources:
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 *   Wisconsin adopts the 2023 NEC (DSPS, signed Sept 1 2026) —
 *     https://www.ecmweb.com/national-electrical-code/article/55403844/wisconsin-adopts-2023-national-electrical-code
 *   Level 1 / Level 2 charging rates — U.S. DOE Alternative Fuels Data Center,
 *     https://afdc.energy.gov/fuels/electricity-infrastructure-development
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'ev-charger-installation';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'EV Charger Installation Reedsburg WI | Dellona Electric';
$pageDescription = 'Level 2 home EV charger installation in Reedsburg, WI by Dellona Electric, with a panel capacity check first. Call (608) 477-8453 to plan your charger.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'ev-charger-garage-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Want a charger in your garage?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'EV charger installation',
    'description' => 'Level 2 home EV charger installation on a dedicated 240-volt circuit, plug-in or hardwired, after a check of panel capacity, in Reedsburg, WI and the surrounding Sauk County area.',
]);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/ev-charger-installation/ — page composition: charger → breaker map, cord-length signs, three-way charging table ==== */
.pg-ev .svc-signs .bento-grid { grid-template-columns: repeat(6, 1fr); }
.pg-ev .svc-signs .bento-medium { grid-column: span 3; grid-row: auto; }
.pg-ev .svc-signs .bento-small { grid-column: span 3; }
.pg-ev .svc-sign--cold { background: color-mix(in srgb, var(--color-secondary) 12%, var(--color-surface)); }
.pg-ev .svc-sign--cold .svc-sign__icon { background: var(--color-surface); color: var(--color-secondary); }
@media (max-width: 800px) { .pg-ev .svc-signs .bento-medium, .pg-ev .svc-signs .bento-small { grid-column: span 6; } }

/* Signature: charger draw → breaker size, read left to right like a circuit */
.pg-ev .amp-map { list-style: none; margin: var(--space-6) 0 0; padding: 0; display: grid; gap: var(--space-3); }
.pg-ev .amp-map li {
  display: grid; grid-template-columns: auto auto auto minmax(0, 1fr); align-items: center; gap: var(--space-2) var(--space-4);
  background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); padding: var(--space-4) var(--space-5);
  box-shadow: var(--shadow-sm);
}
.pg-ev .amp-map b { font-family: var(--font-accent); font-size: var(--font-size-xl); line-height: 1; color: var(--color-ink); min-width: 4ch; }
.pg-ev .amp-map b + svg { color: var(--color-accent-dark); }
.pg-ev .amp-map b:nth-of-type(2) { color: var(--color-accent-dark); }
.pg-ev .amp-map span { font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-ev .amp-map li:last-child { border-color: color-mix(in srgb, var(--color-accent) 45%, var(--color-line)); background: var(--color-card-tint-3); }
.pg-ev .amp-map__legend { margin: var(--space-3) 0 0; font-size: var(--font-size-xs); color: var(--color-muted); }
@media (max-width: 560px) { .pg-ev .amp-map li { grid-template-columns: auto auto auto; } .pg-ev .amp-map span { grid-column: 1 / -1; } }

/* Expert sits on white with the photo left and a tall stat */
.pg-ev .svc-expert__stat b { font-size: clamp(2.6rem, 1.8rem + 2.8vw, 3.8rem); }
.pg-ev .svc-proof__photo { aspect-ratio: 3 / 4; max-height: 600px; }
.pg-ev .svc-table tbody th { width: 22%; }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-ev">

  <!-- 1. HERO — layered dark band, client EV charger photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'JuiceBox Level 2 EV charger mounted on a garage wall, plugged into a 240-volt outlet below it', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Home EV charging · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="svc-title">EV charger installation in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric installs Level 2 home EV chargers in Reedsburg and the surrounding Sauk County area, on a dedicated 240-volt circuit run from your panel to the garage or driveway. Before the charger goes up, the panel gets checked for room, because a charger circuit is one of the largest loads a house carries.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
            <li><?php echo icon('zap', 16); ?> Level 2, 240 V</li>
            <li><?php echo icon('plug', 16); ?> Plug-in or hardwired</li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- 2. PROBLEM STATEMENT — pull quote + signs a home has outgrown the cord in the trunk -->
    <section class="section svc-signs" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-left">
            <span class="eyebrow">Outgrowing Level 1</span>
            <h2 id="signs-title">When does a home need a Level 2 EV charger instead of a wall outlet?</h2>
            <p class="answer-block">A home needs a Level 2 charger when the 120-volt cord that came with the car can't refill the battery overnight. Long commutes, a second EV, Wisconsin winters that cut range, and charging off a shared or extension-corded outlet all push owners toward a dedicated 240-volt circuit.</p>
            <p class="pull-quote">The cord in the trunk will charge the car. It just may not have it full by morning.</p>
          </div>
          <div class="bento-grid">
            <div class="bento-medium svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('clock', 20); ?></span>
              <h3>Overnight isn't enough</h3>
              <p>A standard 120-volt outlet adds only a few miles of range per hour of charging. That works for a short drive into town. It falls behind quickly with a long daily commute or a weekend of errands across the county.</p>
            </div>
            <div class="bento-medium svc-sign svc-sign--cold reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('snowflake', 20); ?></span>
              <h3>January range loss</h3>
              <p>Cold batteries hold and accept less charge, and cabin heat draws on the same pack. A faster charger lets you warm the car while it's still plugged in and leave with a fuller battery.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('alert-triangle', 20); ?></span>
              <h3>Extension cords and shared outlets</h3>
              <p>Charging through an extension cord, or on a garage outlet shared with a freezer or tools, can trip breakers and heat up plugs. A car pulls current for hours at a time.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('car', 20); ?></span>
              <h3>A second EV in the driveway</h3>
              <p>Two cars on one 120-volt outlet means one of them starts the day short. A Level 2 circuit can refill both on alternating nights.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. SERVICE BREAKDOWN — what's included + charger → breaker map + sticky process -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="included-title">
      <div class="container-wide">
        <div class="svc-breakdown__grid">
          <div class="svc-breakdown__sticky svc-body reveal-left">
            <span class="eyebrow">What's included</span>
            <h2 id="included-title">What's included in an EV charger installation from Dellona Electric?</h2>
            <p class="answer-block">An EV charger installation is a new dedicated 240-volt circuit from your panel to where the car parks. It ends in a 240-volt receptacle for a plug-in charger or a direct hardwired connection, with the breaker sized to the charger, the unit mounted where the cable reaches the port, and a test charge with your car.</p>
            <ul class="svc-checklist">
              <li><?php echo icon('check', 18); ?><span><strong>A capacity check on the panel.</strong> The charger is added to everything the house already runs. If there isn't room, that conversation happens first, and the <a href="/services/panel-upgrades/">panel repair and upgrades page</a> explains the options.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>A circuit of its own.</strong> No sharing with the garage door opener, the freezer or the shop outlets.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>GFCI protection on garage receptacles.</strong> Under the 2023 National Electrical Code, which Wisconsin adopted in September 2026, 240-volt receptacles in a garage need ground-fault protection.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Mounting at the right spot,</strong> close enough that the charging cable reaches the port without stretching across the floor.</span></li>
            </ul>
            <ul class="amp-map" aria-label="Charger current and the breaker it needs">
              <li><b>32 A</b><?php echo icon('arrow-right', 18); ?><b>40 A</b><span>Charger draw → breaker. Plug-in on a 14-50 outlet, or hardwired.</span></li>
              <li><b>40 A</b><?php echo icon('arrow-right', 18); ?><b>50 A</b><span>The most a plug-in charger can draw on a 14-50 outlet.</span></li>
              <li><b>48 A</b><?php echo icon('arrow-right', 18); ?><b>60 A</b><span>Hardwired only. No standard household receptacle is rated for it.</span></li>
            </ul>
            <p class="amp-map__legend">Charging counts as a continuous load, so the breaker is sized at 125% of what the charger draws.</p>
          </div>
          <div class="reveal-right">
            <h3 class="sr-only">How an EV charger installation goes, step by step</h3>
            <ol class="svc-steps">
              <li><h3>Where the car parks and where the port is</h3><p>Garage or driveway, nose-in or back-in, which side the charge port sits on. That sets where the charger mounts and how far the circuit has to run from the panel.</p></li>
              <li><h3>Check the panel and choose the amperage</h3><p>If you already bought a charger, its installation manual lists the breaker it needs. If you haven't, the panel's spare capacity often decides between a 32, 40 or 48 amp unit.</p></li>
              <li><h3>Run the circuit</h3><p>Through the basement ceiling and up into an attached garage, along the garage wall, or in conduit to a detached garage or an outdoor mount, depending on the house.</p></li>
              <li><h3>Mount, connect and test with your car</h3><p>The charger goes up, the breaker comes on, and a test charge confirms the car and the charger agree on the current before anyone leaves.</p></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. EXPERT POSITIONING — 60/40 split, 125% stat, evidence from the client's own jobs -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-left">
            <div class="img-framed">
              <?php echo p1_picture('panel-work-basement-v1', 'Two Dellona Electric electricians working inside an open breaker panel in a basement', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>125%</b><span>EV charging is a continuous load, so the circuit is sized a quarter above the charger's draw.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-right">
            <span class="eyebrow">Charger, circuit and panel</span>
            <h2 id="expert-title">Why does the panel matter as much as the EV charger itself?</h2>
            <p class="answer-block">The panel matters because a Level 2 charger can pull 32 to 48 amps for hours, often overnight while the furnace, water heater and dryer also run. Dellona Electric works on both ends of that circuit, the panel in the basement and the charger on the garage wall, so the two are planned together.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('battery-charging', 22); ?><b>A charger install from the crew's own photos</b><span>The JuiceBox at the top of this page is a plug-in unit on a 240-volt receptacle, its cable coiled on the holster, with a separate GFCI outlet on the same wall for everything else in the garage.</span></li>
              <li><?php echo icon('zap', 22); ?><b>Panel work is part of the same trade</b><span>The photo here shows two of the crew in an open breaker panel. When a house has no spare capacity for a charger, the fix is in that box, not on the garage wall.</span></li>
              <li><?php echo icon('shield-check', 22); ?><b>Protecting the electronics in the charger</b><span>A charger is a computer on a 240-volt circuit. Many owners pair it with <a href="/services/surge-protection/">whole-house surge protection at the panel</a>. It is one of <?php echo count($services); ?> jobs on the <a href="/services/">full list of Dellona Electric services</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. PROOF — dark grain band, captioned client photo, Google profile -->
    <section class="section svc-proof texture-grain slant-top" aria-labelledby="proof-title">
      <span class="grain-layer" aria-hidden="true"></span>
      <div class="container">
        <div class="svc-proof__grid">
          <figure class="svc-proof__photo reveal-left">
            <?php echo p1_picture('ev-charger-garage-v1', 'JuiceBox EV charger with a green status light, its cable looped on the holster and plugged into a 240-volt outlet, beside a GFCI outlet', ['sizes' => '(max-width: 900px) 92vw, 520px']); ?>
            <figcaption>A plug-in Level 2 charger on its own 240-volt receptacle, with a GFCI outlet beside it on the same wall.</figcaption>
          </figure>
          <div class="svc-proof__copy reveal-right">
            <span class="eyebrow">From the job site</span>
            <h2 id="proof-title">What does a finished EV charger installation look like?</h2>
            <p class="answer-block">A finished EV charger installation looks like this photo: a wall-mounted charger, a dedicated 240-volt receptacle below it, and the cable kept off the floor. Here the JuiceBox's green status bar is lit, its plug is seated in the receptacle, and the cable loops over a holster instead of lying where the car can roll over it.</p>
            <p>Reviews from Dellona Electric customers are on the company's Google Business Profile. Read them there, or add yours once your charger is working.</p>
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

    <!-- 6. COMPARISON — Level 1 vs plug-in Level 2 vs hardwired Level 2, as a real table -->
    <section class="section svc-compare" aria-labelledby="compare-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Choosing a setup</span>
          <h2 id="compare-title">Should your EV charger plug in or be hardwired?</h2>
          <p class="answer-block">A plug-in Level 2 charger is easy to swap or take with you, while a hardwired one allows more current. Hardwiring also avoids a garage GFCI receptacle tripping against the charger's own ground-fault protection. Both run on 240 volts and both are far faster than the 120-volt cord that ships with most cars.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>General guidance. Your car's onboard charger also caps how fast it can take power, whatever the wall unit offers.</caption>
            <thead>
              <tr><th scope="col">Compare</th><th scope="col">Level 1 (120 V cord)</th><th scope="col">Level 2, plug-in</th><th scope="col" class="is-pick">Level 2, hardwired</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">Range added per hour</th><td>A few miles</td><td>Roughly 25 miles or more, depending on the car</td><td class="is-pick">The same or a little more at 48 A</td></tr>
              <tr><th scope="row">Circuit</th><td>Ordinary 15 or 20 A outlet</td><td>40 or 50 A circuit with a 14-50 receptacle</td><td class="is-pick">Up to a 60 A circuit, connected directly</td></tr>
              <tr><th scope="row">GFCI in a garage</th><td>Standard GFCI outlet</td><td>The receptacle needs GFCI protection, which can conflict with some chargers</td><td class="is-pick">The charger's own protection does the job</td></tr>
              <tr><th scope="row">Swapping the charger later</th><td>Nothing to change</td><td><strong>Easy:</strong> unplug one, plug in the next</td><td class="is-pick">Needs an electrician to disconnect</td></tr>
              <tr><th scope="row">Outdoor mounting</th><td>Not a long-term plan</td><td>Needs a weatherproof in-use cover</td><td class="is-pick"><strong>Well suited</strong> with an outdoor-rated unit</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- 7. FAQ — questions from the research brief, made specific to chargers -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do Reedsburg drivers ask before installing a home EV charger?</h2>
          <p class="answer-block">Drivers planning a home EV charger mostly ask what the installation will cost and whether the new circuit needs a permit. Both answers depend on the distance from the panel to the parking spot and on the panel itself, so the questions below explain what decides each one for your house.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does EV charger installation cost in Reedsburg?</summary>
          <p>The cost of an EV charger installation depends on how far the circuit runs from the panel to where you park, whether the panel has room for a 40 to 60 amp breaker, plug-in versus hardwired, and indoor versus outdoor mounting. Dellona Electric looks at the panel and the garage before pricing it. Call <?php echo e($phone); ?> to set that up.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Does adding an EV charger circuit need a permit?</summary>
          <p>A new 240-volt charger circuit is an electrical alteration. Inside the city, the City of Reedsburg Building Inspection Department issues permits and lists electrical alterations among the work that may need one, while homes in the surrounding towns answer to their own inspector. Ask when you call and you will know before the charger goes in.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What other electrical work pairs with an <span class="text-accent">EV charger</span>?</h2>
        <p class="hero-answer">Three jobs fit naturally with an EV charger: making room in the panel, surge protection for the charger's electronics, and garage wiring on new builds. If you are building a garage or a house, roughing the charger circuit in before the drywall goes up is far simpler than adding it later.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <?php echo p1_service_cards(['panel-upgrades', 'surge-protection', 'new-construction-wiring']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Charger estimate</span>
        <h2 id="cta-title">Ready to charge at home overnight?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with your car, the charger you have in mind, and where you park. Dellona Electric will call you back to plan the circuit.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
