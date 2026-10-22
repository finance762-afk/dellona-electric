<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/ceiling-fan-installation/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php, the client photos on this page
 * (captions describe only what is visible — no job locations), general trade
 * guidance labelled as such, or the sources below. Prices, permit handling and
 * fan brands are unconfirmed (content-confirmations.json).
 * Sources:
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 *   Fan support boxes, 70 lb limit: NFPA 70 (NEC) 314.27(C)
 *   Wisconsin adopts the 2023 NEC (DSPS, signed Sept 1 2026) —
 *     https://www.ecmweb.com/national-electrical-code/article/55403844/wisconsin-adopts-2023-national-electrical-code
 *   Blade-span, mounting-height and downrod figures: general industry sizing guidance, labelled on the page.
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'ceiling-fan-installation';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'Ceiling Fan Installation Reedsburg WI | Dellona Electric';
$pageDescription = 'Ceiling fan installation in Reedsburg, WI by Dellona Electric: fan-rated boxes, downrods for tall ceilings, separate fan and light control. Call (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'living-room-ceiling-fan-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Want a fan put up?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'Ceiling fan installation',
    'description' => 'Ceiling fan installation on fan-rated boxes, with braces, downrods and wall, remote or smart controls, for homes in Reedsburg, WI and the surrounding Sauk County area.',
]);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/ceiling-fan-installation/ — page composition: rotor bento, blade-span table, downrod scale, controls table ==== */
.pg-fan .svc-hero__media img { object-position: 50% 15%; }

/* Bento: an even 2x2 of signs beside the pull quote */
.pg-fan .svc-signs .bento-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
.pg-fan .svc-sign.bento-large, .pg-fan .svc-sign.bento-medium, .pg-fan .svc-sign.bento-small { grid-column: auto; grid-row: auto; }
.pg-fan .svc-sign.bento-large {
  background:
    repeating-conic-gradient(from 0deg at 100% 0%, color-mix(in srgb, var(--color-primary) 5%, transparent) 0 10deg, transparent 10deg 40deg),
    var(--color-card-tint-1);
}
@media (max-width: 800px) { .pg-fan .svc-signs .bento-grid { grid-template-columns: 1fr; } }

/* Blade-span sizing table sits under the sticky checklist */
.pg-fan .span-table { margin-top: var(--space-4); }
.pg-fan .span-table .svc-table { min-width: 0; }
.pg-fan .span-table td:last-child { font-family: var(--font-accent); font-size: var(--font-size-lg); color: var(--color-ink); letter-spacing: .02em; }

/* Downrod scale: ceiling height → downrod, drawn as hanging rods */
.pg-fan .downrod { list-style: none; margin: var(--space-2) 0 0; padding: 0; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-3); align-items: start; }
.pg-fan .downrod li { display: grid; gap: var(--space-1); justify-items: center; text-align: center; padding-top: var(--space-2); border-top: 3px solid var(--color-ink); }
.pg-fan .downrod i { display: block; width: 3px; background: var(--color-accent-dark); border-radius: var(--radius-sm); }
.pg-fan .downrod li:nth-child(1) i { height: var(--space-1); }
.pg-fan .downrod li:nth-child(2) i { height: var(--space-4); }
.pg-fan .downrod li:nth-child(3) i { height: var(--space-8); }
.pg-fan .downrod li:nth-child(4) i { height: var(--space-12); }
.pg-fan .downrod b { font-family: var(--font-accent); font-size: var(--font-size-lg); line-height: 1; color: var(--color-ink); }
.pg-fan .downrod span { font-size: var(--font-size-xs); color: var(--color-muted); }

/* Controls comparison gets the paper ground so it never sits white-on-white after the expert band */
.pg-fan .svc-compare { background: var(--color-paper); }
.pg-fan .svc-expert__figure .img-framed { aspect-ratio: 3 / 4; }

/* Proof photo is landscape on this page */
.pg-fan .svc-proof__photo { aspect-ratio: 4 / 3; }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-fan">

  <!-- 1. HERO — layered dark band, client living-room fan photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Large nine-blade ceiling fan with a center light in a living room with recessed lights', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Ceiling fans · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="svc-title">Ceiling fan installation in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric installs ceiling fans in homes across Reedsburg and the surrounding Sauk County area, from swapping an old light for a fan to putting one where no ceiling box exists yet. Each fan hangs from a box rated to carry it, at the right height, with wall, remote or smart control.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
            <li><?php echo icon('shield-check', 16); ?> Fan-rated boxes</li>
            <li><?php echo icon('wind', 16); ?> Fan &amp; light controls</li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- 2. PROBLEM STATEMENT — pull quote + 2x2 sign grid -->
    <section class="section svc-signs" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-left">
            <span class="eyebrow">Telltale signs</span>
            <h2 id="signs-title">What are the signs a ceiling fan was hung wrong or needs replacing?</h2>
            <p class="answer-block">A fan that wobbles, hums, or hangs from a box meant only for a light fixture needs attention before it needs replacing. Those signs point to a loose or unrated mount, a wall control meant for lights, or wiring that never gave the fan and its light separate switches.</p>
            <p class="pull-quote">A light fixture weighs a few pounds and sits still. A fan weighs several times that and spins for hours. The box above it has to know the difference.</p>
          </div>
          <div class="bento-grid">
            <div class="bento-large svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('alert-triangle', 20); ?></span>
              <h3>Hung from a light-only box</h3>
              <p>Many older ceiling boxes are listed for light fixtures only. A fan's weight and constant vibration slowly loosen the screws, so the fix is a box listed for fan support or a brace bar fastened between the joists.</p>
            </div>
            <div class="bento-medium svc-sign reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('repeat', 20); ?></span>
              <h3>Wobble that balancing won't cure</h3>
              <p>A balancing kit corrects uneven blades. A wobble that survives it usually comes from the bracket, the box or a downrod that isn't seated.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('zap', 20); ?></span>
              <h3>A hum from the wall control</h3>
              <p>A light dimmer used as a fan speed control makes the motor hum and can overheat it. Fan motors need a control rated for fans.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('plug', 20); ?></span>
              <h3>Fan and light on one switch</h3>
              <p>Living with a pull chain for one and the wall switch for the other usually means only two wires run from the switch to the ceiling. Separate control needs an extra conductor, or a remote receiver hidden in the canopy.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 4 (moved up). SERVICE BREAKDOWN — checklist, sizing table and downrod scale beside the process -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="included-title">
      <div class="container-wide">
        <div class="svc-breakdown__grid">
          <div class="svc-breakdown__sticky svc-body reveal-left">
            <span class="eyebrow">What's included</span>
            <h2 id="included-title">What's included in a ceiling fan installation from Dellona Electric?</h2>
            <p class="answer-block">A ceiling fan installation covers the support, the wiring and the controls as well as the fan itself. That means checking or replacing the ceiling box, adding a brace where there is no joist to fasten to, choosing a downrod for the ceiling height, and wiring the fan and its light to the controls you want.</p>
            <ul class="svc-checklist">
              <li><?php echo icon('check', 18); ?><span><strong>A box listed for fan support.</strong> The National Electrical Code limits a box carrying a fan on its own to fans of 70 pounds or less, and the box has to be marked for the purpose.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>The right height.</strong> Blades sit at least 7 feet off the floor and ideally 8 to 9, with a sloped-ceiling adapter on vaulted ceilings.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Room to turn.</strong> Blade tips about 18 inches from walls and sloped ceilings.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Controls rated for motors:</strong> a fan speed control, separate fan and light switches, or a remote. Phone and voice control are covered under <a href="/services/smart-home-wiring/">smart home wiring</a>.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Both directions tested.</strong> Counterclockwise pushes air down in summer; clockwise on low pulls it up and moves the warm air off the ceiling in a Wisconsin winter.</span></li>
            </ul>
            <div class="svc-table-wrap span-table">
              <table class="svc-table">
                <caption>General industry sizing guidance for blade span.</caption>
                <thead><tr><th scope="col">Room size</th><th scope="col">Typical room</th><th scope="col">Blade span</th></tr></thead>
                <tbody>
                  <tr><th scope="row">Up to 75 sq ft</th><td>Small bedroom, office</td><td>29–36 in</td></tr>
                  <tr><th scope="row">76–144 sq ft</th><td>Bedroom, kitchen</td><td>36–42 in</td></tr>
                  <tr><th scope="row">144–225 sq ft</th><td>Primary bedroom, family room</td><td>44–50 in</td></tr>
                  <tr><th scope="row">225–400 sq ft</th><td>Great room, open plan</td><td>50–54 in+</td></tr>
                  <tr><th scope="row">Over 400 sq ft</th><td>Large open spaces</td><td>56 in+ or two fans</td></tr>
                </tbody>
              </table>
            </div>
            <ol class="downrod" aria-label="Typical downrod length by ceiling height">
              <li><i></i><b>8 ft</b><span>Flush or close mount</span></li>
              <li><i></i><b>9 ft</b><span>About 6 in rod</span></li>
              <li><i></i><b>10 ft</b><span>About 12 in rod</span></li>
              <li><i></i><b>12 ft</b><span>About 24 in rod</span></li>
            </ol>
          </div>
          <div class="reveal-right">
            <h3 class="sr-only">How a ceiling fan installation goes, step by step</h3>
            <ol class="svc-steps">
              <li><h3>Check what's above the ceiling</h3><p>The box type, where the joists run, whether there is attic access, and how many conductors already come down from the switch.</p></li>
              <li><h3>Pick the mount and controls</h3><p>A new fan-rated box or a brace bar, the downrod length for your ceiling, and how you want to run the fan and its light.</p></li>
              <li><h3>Mount, wire and hang</h3><p>The brace and box are secured to the framing, the fan is assembled and hung, and the connections are made inside the canopy.</p></li>
              <li><h3>Balance and run it</h3><p>Every speed, both directions and the light kit are tested, any remote is paired, and the blades are balanced if they need it.</p></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. EXPERT POSITIONING — 60/40 split, the 70 lb rule, evidence from the client's photos -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-left">
            <div class="img-framed">
              <?php echo p1_picture('sunroom-device-install-v1', 'Dellona Electric electrician setting a device into a wall box on beadboard paneling in a sunroom', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>70 lb</b><span>The most a fan-rated ceiling box may carry on its own under the National Electrical Code.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-right">
            <span class="eyebrow">Who does the work</span>
            <h2 id="expert-title">Why does Dellona Electric treat a ceiling fan as more than a light swap?</h2>
            <p class="answer-block">Dellona Electric treats a ceiling fan as a mechanical load as well as an electrical one, because it hangs, spins and vibrates for years. The living-room photo at the top of this page shows the result: a large nine-blade fan with a center light, centered between recessed lights in a finished room.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('wind', 22); ?><b>Big fans for open rooms</b><span>The fan at the top of the page is a nine-blade model with an LED light, in an open living room where a small fan would barely move the air.</span></li>
              <li><?php echo icon('lightbulb', 22); ?><b>Planned with the room's lighting</b><span>In that room the recessed lights carry the general lighting, so the fan's light kit is a bonus rather than the only source. Layouts like that are covered on the <a href="/services/lighting-installation/">lighting installation page</a>.</span></li>
              <li><?php echo icon('wrench', 22); ?><b>The wall side matters too</b><span>The photo here shows the other half of a fan job: setting a device in a wall box. Worn or loose switches found along the way can be replaced too, as covered under <a href="/services/outlet-switch-repair/">outlet and switch repair</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 6. COMPARISON — fan control options as a real table -->
    <section class="section svc-compare" aria-labelledby="compare-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Controls</span>
          <h2 id="compare-title">Which ceiling fan control is right for your room?</h2>
          <p class="answer-block">A wall switch is simplest, separate fan and light switches are most convenient, and a remote or smart control works when the wiring can't easily change. Which control fits depends on how many conductors already run between the switch box and the ceiling box.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>Rough guide. What is already in the wall decides which options are simple and which need new wire.</caption>
            <thead>
              <tr><th scope="col">Control</th><th scope="col">Wiring it needs</th><th scope="col">Fan and light separate?</th><th scope="col">Good fit</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">Pull chains only</th><td>Power at the fan, switch left on</td><td>Yes, by chain</td><td>Rooms where nobody minds reaching up</td></tr>
              <tr><th scope="row">Single wall switch</th><td>Standard two-wire switch leg</td><td>No, chains set the speed</td><td>Replacing a light on an existing switch</td></tr>
              <tr><th scope="row">Two wall switches</th><td>An extra conductor from switch to fan</td><td>Yes</td><td>Bedrooms and living rooms used every day</td></tr>
              <tr><th scope="row">Wall fan-speed control</th><td>A control rated for fan motors, never a light dimmer</td><td>With a dual control</td><td>Rooms where speed changes through the day</td></tr>
              <tr><th scope="row">Remote and canopy receiver</th><td>No new wire, receiver fits in the canopy</td><td>Yes</td><td>Finished ceilings where new wire is hard</td></tr>
              <tr><th scope="row">Smart fan control</th><td>Often a neutral at the switch box</td><td>Yes</td><td>Schedules, voice or phone control</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- 5. PROOF — dark grain band, the finished fan job, Google profile -->
    <section class="section svc-proof texture-grain slant-top" aria-labelledby="proof-title">
      <span class="grain-layer" aria-hidden="true"></span>
      <div class="container">
        <div class="svc-proof__grid">
          <div class="svc-proof__copy reveal-left">
            <span class="eyebrow">From the job site</span>
            <h2 id="proof-title">What does a ceiling fan installed by Dellona Electric look like?</h2>
            <p class="answer-block">This living room is a Dellona Electric ceiling fan job. A large nine-blade fan with a center light hangs mid-ceiling with recessed lights spaced around it, and below it the built-in wall niches are lit from above, with a recessed box set behind the TV mount.</p>
            <p>Read what Dellona Electric customers say on the company's Google Business Profile, or leave a review of your own after a job.</p>
            <div class="actions">
              <a class="btn btn-accent" href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?> See Dellona Electric on Google</a>
              <a class="btn btn-outline-white" href="<?php echo e($reviewRequestUrl); ?>" target="_blank" rel="noopener">Leave a review</a>
            </div>
          </div>
          <figure class="svc-proof__photo reveal-right">
            <?php echo p1_picture('living-room-ceiling-fan-v1', 'Living room with a nine-blade ceiling fan, recessed ceiling lights and backlit built-in wall niches around a TV wall', ['sizes' => '(max-width: 900px) 92vw, 560px']); ?>
            <figcaption>Nine-blade fan with a center light, recessed lights around it and lit niches on the wall below.</figcaption>
          </figure>
        </div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
        echo p1_google_reviews($slug, ['heading' => '', 'limit' => 3]);
        ?>
      </div>
    </section>

    <!-- 7. FAQ — questions from the research brief, made specific to fans -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do Reedsburg homeowners ask about ceiling fan installation?</h2>
          <p class="answer-block">Ceiling fan installation questions usually come down to price and to whether Dellona Electric works where you live. The price turns mostly on what is already above the ceiling, and the service area reaches past the city limits, so both answers below start with a detail about your house.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does it cost to install a ceiling fan?</summary>
          <p>The cost of a ceiling fan install depends mostly on what is already in the ceiling. Hanging a fan where a fan-rated box and switch wiring exist is a shorter job than adding a brace, a new box, a long downrod for a vaulted ceiling or a new switch leg. Tell Dellona Electric the ceiling height and what is up there now, or call <?php echo e($phone); ?>, and you will hear what the job involves before it is priced.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Do you install ceiling fans outside the city of Reedsburg?</summary>
          <p>Yes. Dellona Electric is based on Briar Bluff Rd in Reedsburg and installs ceiling fans in Reedsburg and the surrounding Sauk County area. For a home farther out, call <?php echo e($phone); ?> with the address and ask whether it falls inside the area the crew covers.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What other electrical work goes with a new <span class="text-accent">ceiling fan</span>?</h2>
        <p class="hero-answer">A new ceiling fan often sets off other electrical work in the same room. Recessed lighting can take over from the fan's light kit, a smart control can run the fan from a phone or a schedule, and a worn or loose wall switch is worth replacing while the wiring is open. Each has a page below.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <p class="svc-body reveal-up">Every kind of work Dellona Electric does is listed on the <a href="/services/">electrical services overview</a>.</p>
      <?php echo p1_service_cards(['lighting-installation', 'smart-home-wiring', 'outlet-switch-repair']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Fan estimate</span>
        <h2 id="cta-title">Ready to put a fan where the old light is?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with the room, the ceiling height and what is up there now. Dellona Electric will call you back to talk through the mount and the controls.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
