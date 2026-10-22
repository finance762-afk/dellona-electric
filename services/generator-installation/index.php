<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/generator-installation/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php, the client photo of the Kohler
 * standby install at a log home (unit on a timber-framed pad beside a York AC
 * condenser, outdoor equipment on the log wall, crew pulling cable and conduit),
 * general trade practice (transfer switch / interlock required to prevent
 * backfeed; standby units run on natural gas or LP) and the sources below.
 * Prices, fuel-line handling, permit handling, brands sold and timelines are
 * unconfirmed (content-confirmations.json).
 * Sources:
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 *   USDA, keeping food safe during an outage (full freezer ~48 h) —
 *     https://www.fsis.usda.gov/food-safety/safe-food-handling-and-preparation/food-safety-basics/keeping-food-safe-during-emergency
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'generator-installation';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'Generator Installation Reedsburg WI | Dellona Electric';
$pageDescription = 'Standby generator installation and portable generator hookups with transfer switches in Reedsburg, WI by Dellona Electric. Call (608) 477-8453 to plan yours.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'standby-generator-log-home-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Need power through the next outage?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'Generator installation',
    'description' => 'Standby generator installation and portable generator hookups with transfer switches or interlocks for homes in Reedsburg, WI and the surrounding Sauk County area.',
]);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/generator-installation/ — page composition: backfeed warning tile, essential-loads chips, three-way setup table ==== */
.pg-gen .svc-sign--danger {
  background: linear-gradient(135deg, var(--color-dark) 0%, var(--color-dark-alt) 100%);
  border-color: color-mix(in srgb, var(--color-danger) 55%, var(--color-dark));
}
.pg-gen .svc-sign--danger h3 { color: var(--color-white); font-size: var(--fs-h3); }
.pg-gen .svc-sign--danger p { color: color-mix(in srgb, var(--color-white) 82%, transparent); font-size: var(--fs-body); }
.pg-gen .svc-sign--danger .svc-sign__icon { background: color-mix(in srgb, var(--color-danger) 30%, var(--color-dark)); color: var(--color-white); }
.pg-gen .svc-sign--danger strong { color: var(--color-accent-bright); }

/* Signature: the loads people put on a generator, as a chip cloud */
.pg-gen .load-chips { list-style: none; margin: var(--space-4) 0 0; padding: var(--space-5); display: flex; flex-wrap: wrap; gap: var(--space-2); background: var(--color-surface); border: 1px dashed color-mix(in srgb, var(--color-accent) 55%, var(--color-line)); border-radius: var(--radius-lg); }
.pg-gen .load-chips li { display: inline-flex; align-items: center; gap: var(--space-2); font-size: var(--font-size-sm); font-weight: 500; color: var(--color-ink); background: var(--color-card-tint-3); border-radius: var(--radius-full); padding: var(--space-1) var(--space-3); }
.pg-gen .load-chips li svg { color: var(--color-accent-dark); }
.pg-gen .load-chips__label { margin: var(--space-6) 0 0; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }

/* Expert: square truck photo, stat reads as fuel label */
.pg-gen .svc-expert__figure .img-framed { aspect-ratio: 1 / 1; }
.pg-gen .svc-expert__stat b { letter-spacing: .04em; }

/* Comparison sits on paper-2 so it doesn't run into the white expert band */
.pg-gen .svc-compare { background: var(--color-paper-2); }
.pg-gen .svc-table thead th:first-child { width: 20%; }
.pg-gen .svc-proof__photo { aspect-ratio: 3 / 4; max-height: 620px; }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-gen">

  <!-- 1. HERO — layered dark band, client generator photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Dellona Electric electricians pulling cable beside a Kohler standby generator and an air conditioner at a log home', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Backup power · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="svc-title">Generator installation in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric wires standby generators and portable generator hookups for homes in Reedsburg and the surrounding Sauk County area. Each one goes in with a transfer switch or a listed interlock, so generator power runs your circuits without ever feeding back onto the utility line during an outage.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
            <li><?php echo icon('power', 16); ?> Standby &amp; portable</li>
            <li><?php echo icon('repeat', 16); ?> Transfer switches</li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- 2. PROBLEM STATEMENT — what an outage stops, plus the backfeed warning -->
    <section class="section svc-signs" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-left">
            <span class="eyebrow">Why people add one</span>
            <h2 id="signs-title">When is a backup generator worth installing at a Reedsburg-area home?</h2>
            <p class="answer-block">A backup generator is worth it when an outage shuts down something you can't go without. That usually means water from a private well, a sump pump in a wet basement, the furnace blower in January or a full chest freezer. A home on a well loses its water the moment it loses power.</p>
            <p class="pull-quote">On a private well, a power outage is a water outage too.</p>
          </div>
          <div class="bento-grid">
            <div class="bento-large svc-sign svc-sign--danger reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('alert-triangle', 20); ?></span>
              <h3>Never backfeed through a dryer outlet</h3>
              <p>A cord with plugs on both ends, run from a portable generator into a dryer or range outlet, pushes power backward through the panel and out onto the utility line. At the transformer that power is stepped up to a dangerous voltage for the line crews working the outage. <strong>A transfer switch or an interlock makes that physically impossible.</strong></p>
            </div>
            <div class="bento-medium svc-sign reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('droplets', 20); ?></span>
              <h3>Well and sump pumps</h3>
              <p>Well pumps usually run on 240 volts and pull a hard surge when they start, so the generator has to be sized for that start, not just the running load.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('snowflake', 20); ?></span>
              <h3>Heat in a winter outage</h3>
              <p>A gas or propane furnace still needs electricity for its blower and controls.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('clock', 20); ?></span>
              <h3>A full freezer</h3>
              <p>USDA guidance gives a full, unopened freezer about 48 hours. Longer outages need a plan.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. EXPERT POSITIONING — 60/40 split, fuel stat, evidence from the Kohler job -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-left">
            <div class="img-framed">
              <?php echo p1_picture('truck-trailer-job-site-v1', 'Dellona Electric pickup and enclosed company trailer parked on a job site', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>LP / NG</b><span>Standby generators run on propane or natural gas, so there is no gas can to refill mid-outage.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-right">
            <span class="eyebrow">Generator to panel</span>
            <h2 id="expert-title">Why should the generator and the transfer switch be wired by the same electrician?</h2>
            <p class="answer-block">The transfer equipment is where the generator meets your panel, so it decides what runs, what doesn't, and whether the setup is safe. Dellona Electric wires the generator, the transfer equipment and the panel side together, which keeps sizing, circuit choice and testing in one set of hands.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('power', 22); ?><b>A Kohler standby install from the crew's own photos</b><span>The photo at the top of this page shows two Dellona Electric electricians beside a Kohler standby unit on a timber-framed pad, one hauling cable while the other works at the outdoor equipment on the log wall.</span></li>
              <li><?php echo icon('wind', 22); ?><b>Big motors counted before the unit is sized</b><span>The same photo has a York air conditioner right next to the generator. Compressors and well pumps need far more current to start than to run, and that start is what overloads an undersized generator.</span></li>
              <li><?php echo icon('zap', 22); ?><b>When the panel needs work first</b><span>A full or failing panel can't take a transfer switch cleanly. That is covered on the <a href="/services/panel-upgrades/">electrical panel repair and upgrades page</a>, and generator work is one of <?php echo count($services); ?> jobs on the <a href="/services/">Dellona Electric services list</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. SERVICE BREAKDOWN — what's included, essential loads, sticky process -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="included-title">
      <div class="container-wide">
        <div class="svc-breakdown__grid">
          <div class="svc-breakdown__sticky svc-body reveal-left">
            <span class="eyebrow">What's included</span>
            <h2 id="included-title">What's included in a generator installation from Dellona Electric?</h2>
            <p class="answer-block">A generator installation covers the electrical side, from the generator to your panel. That means the transfer switch or interlock, the wiring and conduit between them, and the choice of circuits the generator will carry. A standby install also includes setting the unit in place and testing a full transfer with the house running on it.</p>
            <ul class="svc-checklist">
              <li><?php echo icon('check', 18); ?><span><strong>Essentials or whole house.</strong> A smaller unit can carry the circuits you list below; a larger one with a whole-house transfer switch can carry nearly everything.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>The right transfer equipment:</strong> an automatic transfer switch for a standby unit, or a manual transfer switch or listed panel interlock with an outdoor power inlet for a portable.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Placement by the manufacturer's clearances</strong> from windows, doors and vents, because the exhaust carries carbon monoxide.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Conduit and cable between the unit and the house,</strong> like the run being pulled in the photo.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>The fuel hookup.</strong> The gas or propane line to a standby unit is fuel work, separate from the wiring. Ask when you call how it will be handled on your job.</span></li>
            </ul>
            <p class="load-chips__label">Circuits people most often want on a generator</p>
            <ul class="load-chips">
              <li><?php echo icon('droplets', 14); ?> Well pump</li>
              <li><?php echo icon('waves', 14); ?> Sump pump</li>
              <li><?php echo icon('flame', 14); ?> Furnace blower</li>
              <li><?php echo icon('snowflake', 14); ?> Fridge &amp; freezer</li>
              <li><?php echo icon('lightbulb', 14); ?> Some lights</li>
              <li><?php echo icon('globe', 14); ?> Internet router</li>
              <li><?php echo icon('home', 14); ?> Garage door opener</li>
            </ul>
          </div>
          <div class="reveal-right">
            <h3 class="sr-only">How a generator installation goes, step by step</h3>
            <ol class="svc-steps">
              <li><h3>List what has to keep running</h3><p>Walk through the house and decide which circuits matter in an outage: water, heat, food, a home office, medical equipment. That list drives everything after it.</p></li>
              <li><h3>Size the generator and choose the transfer</h3><p>Add up the running loads, then the start-up surge of the biggest motor. Standby or portable, automatic or manual, comes out of that math and your budget.</p></li>
              <li><h3>Set the unit and run the wiring</h3><p>The standby unit goes on its pad, or the power inlet box goes on the outside wall for a portable. Conduit and cable connect it to the transfer equipment at the panel.</p></li>
              <li><h3>Test a real transfer</h3><p>Utility power is shut off at the main, the generator takes the load, and the house is checked on generator power before it is switched back. You see exactly what to do, or what happens automatically, next time the lights go out.</p></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. COMPARISON — standby vs portable setups, as a real table -->
    <section class="section svc-compare" aria-labelledby="compare-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Standby or portable</span>
          <h2 id="compare-title">Should you choose a standby generator or a portable generator hookup?</h2>
          <p class="answer-block">A standby generator starts on its own within moments of an outage and runs on natural gas or propane, so nobody has to be home. A portable generator with a transfer switch or interlock costs less up front, but someone has to wheel it out, start it, refuel it and switch the circuits over by hand.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>General comparison. Generator size, fuel and the circuits you choose change every row.</caption>
            <thead>
              <tr><th scope="col">Compare</th><th scope="col" class="is-pick">Standby + automatic transfer switch</th><th scope="col">Portable + manual transfer switch</th><th scope="col">Portable + interlock and inlet</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">How it starts</th><td class="is-pick"><strong>On its own</strong> when utility power drops</td><td>You start it and flip the selected circuits</td><td>You start it, switch off the main and turn on what you need</td></tr>
              <tr><th scope="row">Fuel</th><td class="is-pick">Natural gas or propane line</td><td>Gasoline, or dual-fuel models</td><td>Gasoline, or dual-fuel models</td></tr>
              <tr><th scope="row">What it can run</th><td class="is-pick">Essentials up to the whole house, by size</td><td>The circuits wired to the switch</td><td>Any circuit in the panel, within the generator's output</td></tr>
              <tr><th scope="row">If you're away</th><td class="is-pick">Runs without you</td><td>Nothing runs until someone gets home</td><td>Nothing runs until someone gets home</td></tr>
              <tr><th scope="row">Up-front cost</th><td class="is-pick">Highest of the three</td><td>Middle</td><td>Usually the lowest</td></tr>
              <tr><th scope="row">Upkeep</th><td class="is-pick">Scheduled self-test runs and routine service</td><td>Store it, run it now and then, keep fuel fresh</td><td>Store it, run it now and then, keep fuel fresh</td></tr>
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
          <div class="svc-proof__copy reveal-left">
            <span class="eyebrow">From the job site</span>
            <h2 id="proof-title">What does a standby generator installation by Dellona Electric look like?</h2>
            <p class="answer-block">This standby generator installation shows two Dellona Electric electricians at a log home, pulling cable to a Kohler unit set on a timber-framed pad. A York air conditioner sits beside it, conduit runs across the sandy ground, and the outdoor electrical equipment the generator ties into is mounted on the log wall.</p>
            <p>Dellona Electric's customer reviews are on its Google Business Profile. Read them there, or leave one after your generator is running.</p>
            <div class="actions">
              <a class="btn btn-accent" href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?> See Dellona Electric on Google</a>
              <a class="btn btn-outline-white" href="<?php echo e($reviewRequestUrl); ?>" target="_blank" rel="noopener">Leave a review</a>
            </div>
          </div>
          <figure class="svc-proof__photo reveal-right">
            <?php echo p1_picture('standby-generator-log-home-v1', 'Kohler standby generator on a timber-framed pad beside a York air conditioner, with an electrician pulling cable and another at the outdoor equipment on the log wall', ['sizes' => '(max-width: 900px) 92vw, 520px']); ?>
            <figcaption>Kohler standby unit going in beside the AC condenser, with the cable run pulled across from the house.</figcaption>
          </figure>
        </div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
        echo p1_google_reviews($slug, ['heading' => '', 'limit' => 3]);
        ?>
      </div>
    </section>

    <!-- 7. FAQ — questions from the research brief, made specific to generators -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do homeowners ask before adding a backup generator?</h2>
          <p class="answer-block">Homeowners planning a backup generator usually ask about three things: what it will cost, whether the work needs a permit, and whether Dellona Electric comes out to their address. Each answer depends on your property and the generator you choose, so the answers below explain how to get a straight one for your home.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does a generator installation cost?</summary>
          <p>The cost of a generator installation depends on standby versus portable, the size of the unit, the type of transfer equipment, how far the generator sits from the panel, and whether the panel needs work to accept it. Dellona Electric looks at the panel and the spot you have in mind before pricing it. Call <?php echo e($phone); ?> to set that up.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Does a standby generator need a permit in Reedsburg?</summary>
          <p>A generator tie-in is an electrical alteration, and a standby unit adds a fuel connection. Inside the city, the City of Reedsburg Building Inspection Department issues permits and lists electrical alterations among the work that may need one. Homes in the surrounding towns fall under their own inspector, so ask when you call.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Do you install generators at rural homes outside Reedsburg?</summary>
          <p>Dellona Electric works in Reedsburg and the surrounding Sauk County area, and rural homes on wells are exactly where backup power matters most. If your property is farther out, call <?php echo e($phone); ?> with the address and you will get a straight answer on whether the generator job is in range.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What other electrical work goes with a <span class="text-accent">backup generator</span>?</h2>
        <p class="hero-answer">A backup generator ties into three other parts of the system. The panel has to have room for the transfer equipment, surge protection guards the electronics whether they run on utility or generator power, and when an outage comes with storm damage, an urgent repair may be needed before anything gets switched back on. Each has its own page below.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <?php echo p1_service_cards(['panel-upgrades', 'surge-protection', 'emergency-electrician']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Generator estimate</span>
        <h2 id="cta-title">Ready to stop losing water and heat in an outage?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with what you need running when the power goes out. Dellona Electric will call you back to plan the generator and the transfer switch.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
