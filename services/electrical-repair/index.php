<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/electrical-repair/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php, the client photos used on this
 * page (described only by what they show), general electrical-code knowledge,
 * or the public sources below. Prices, hours, response times and the owner's
 * exact repair process are unconfirmed and stay out of the copy
 * (/content-confirmations.json).
 * Sources:
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 *   Wisconsin adopts the 2023 NEC (DSPS, signed Sept 1 2026) —
 *     https://www.ecmweb.com/national-electrical-code/article/55403844/wisconsin-adopts-2023-national-electrical-code
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'electrical-repair';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'Electrical Repair & Troubleshooting Reedsburg WI | Dellona Electric';
$pageDescription = 'Electrical repair in Reedsburg, WI for dead circuits, short circuits, tripping breakers and flickering lights. Call Dellona Electric at (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'sunroom-device-install-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Need a circuit tracked down?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'Electrical repair services',
    'description' => 'Electrical troubleshooting and repair of dead circuits, short circuits, tripping breakers, flickering lights and partial power loss for homes and businesses in Reedsburg, WI and the surrounding Sauk County area.',
]);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/electrical-repair/ — page composition: symptom → cause ladder, warning-first bento ==== */
.pg-repair .bento-grid > .svc-sign--warn { grid-column: span 4; grid-row: span 2; }
.pg-repair .bento-grid > .bento-large { grid-column: span 8; }
.pg-repair .svc-sign--warn { background: color-mix(in srgb, var(--color-danger) 6%, var(--color-surface)); border-color: color-mix(in srgb, var(--color-danger) 35%, var(--color-line)); }
.pg-repair .svc-sign--warn .svc-sign__icon { background: color-mix(in srgb, var(--color-danger) 12%, var(--color-surface)); color: var(--color-danger); }
.pg-repair .svc-sign--warn h3 { color: var(--color-danger); }
@media (max-width: 800px) { .pg-repair .bento-grid > .svc-sign--warn, .pg-repair .bento-grid > .bento-large { grid-column: span 12; grid-row: auto; } }

/* Signature: symptom → likely cause ladder */
.pg-repair .diag-section { background: var(--color-surface); }
.pg-repair .diag { display: grid; gap: var(--space-3); margin: 0; }
.pg-repair .diag__row {
  display: grid; grid-template-columns: minmax(0, .85fr) var(--space-10) minmax(0, 1.5fr); align-items: center; gap: var(--space-4);
  background: var(--color-paper); border: 1px solid var(--color-line); border-radius: var(--radius-lg); padding: var(--space-4) var(--space-5);
  transition: border-color var(--transition), transform var(--transition);
}
.pg-repair .diag__row:hover { border-color: var(--color-accent); transform: translateX(var(--space-1)); }
.pg-repair .diag dt { font-family: var(--font-heading); font-weight: 700; color: var(--color-ink); display: flex; gap: var(--space-3); align-items: center; }
.pg-repair .diag dt span { font-family: var(--font-accent); font-size: var(--font-size-sm); color: var(--color-accent-dark); letter-spacing: .08em; }
.pg-repair .diag__arrow { color: var(--color-accent-dark); justify-self: center; }
.pg-repair .diag dd { margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-repair .diag dd strong { color: var(--color-ink); }
.pg-repair .diag__row--alert { border-color: color-mix(in srgb, var(--color-danger) 40%, var(--color-line)); background: color-mix(in srgb, var(--color-danger) 5%, var(--color-paper)); }
@media (max-width: 760px) {
  .pg-repair .diag__row { grid-template-columns: 1fr; gap: var(--space-2); }
  .pg-repair .diag__arrow { display: none; }
}

/* Section grounds for this page's order */
.pg-repair .svc-expert { background: var(--color-paper-2); }
.pg-repair .svc-breakdown { background: var(--color-paper); }
.pg-repair .svc-proof__photo { aspect-ratio: 4 / 5; max-height: 600px; }
.pg-repair .svc-expert__figure .img-framed { aspect-ratio: 3 / 4; }
@media (prefers-reduced-motion: reduce) { .pg-repair .diag__row, .pg-repair .diag__row:hover { transition: none; transform: none; } }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-repair">

  <!-- 1. HERO — layered dark band, client repair photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Dellona Electric electrician kneeling on a patterned tile floor, working on a wall box in a sunroom', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Repair &amp; troubleshooting · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="svc-title">Electrical repair and troubleshooting in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric tracks down and fixes electrical faults in Reedsburg homes and businesses: dead outlets and circuits, breakers that trip, lights that flicker or dim, and short circuits that trip a breaker instantly. The work starts with finding the cause, so the same problem does not come back next week.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('wrench', 16); ?> Dead circuits</li>
            <li><?php echo icon('zap', 16); ?> Short circuits</li>
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- 2. PROBLEM STATEMENT — pull quote + warning-first bento -->
    <section class="section svc-signs" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-left">
            <span class="eyebrow">Don't keep resetting it</span>
            <h2 id="signs-title">Which electrical problems need a repair instead of another reset?</h2>
            <p class="answer-block">Anything that keeps coming back after a reset needs a repair. That means a breaker that trips again, a GFCI outlet that won't hold, lights that flicker on one circuit, or outlets that go dead for no clear reason. A reset clears the symptom; it does not fix the loose connection, worn device or overloaded circuit behind it.</p>
            <p class="pull-quote">Electrical problems rarely fix themselves. They go quiet for a while, then they get warmer.</p>
          </div>
          <div class="bento-grid">
            <div class="bento-medium svc-sign svc-sign--warn reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('flame', 20); ?></span>
              <h3>Burning smell or a scorched cover</h3>
              <p>Turn the breaker for that area off and leave it off. Heat damage at an outlet, a switch or the panel is a fire risk, not a nuisance. The <a class="svc-inline-link" href="/services/emergency-electrician/">urgent electrical problems page</a> covers what to do in the first few minutes.</p>
            </div>
            <div class="bento-large svc-sign reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('lightbulb', 20); ?></span>
              <h3>Lights that flicker or dim</h3>
              <p>Flicker in one fixture is often the bulb or a loose lamp holder. Flicker across a whole room, or lights that sag every time the furnace or a microwave starts, points to a loose connection or a crowded circuit. That is worth tracing before the loose spot starts to heat up.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('plug', 20); ?></span>
              <h3>Half a room went dead</h3>
              <p>Check for a tripped GFCI outlet in a bathroom, kitchen, garage or outside first. One GFCI can protect outlets in several rooms.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('zap', 20); ?></span>
              <h3>One appliance trips the breaker</h3>
              <p>If the breaker goes when a vacuum, space heater or microwave starts, try that appliance on another circuit. If it trips there too, the appliance is the suspect.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SIGNATURE — symptom → likely cause ladder -->
    <section class="section diag-section edge-wave-top" aria-labelledby="diag-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Symptom to cause</span>
          <h2 id="diag-title">What usually causes the electrical problem you're seeing?</h2>
          <p class="answer-block">Most electrical faults trace back to a short list of causes. A loose or burned connection, a worn-out outlet, switch or breaker, a circuit carrying more than it was built for, or damaged wire covers nearly all of them. The symptom narrows the list, and testing the circuit tells you which one it is.</p>
        </div>
        <dl class="diag">
          <div class="diag__row reveal-up">
            <dt><span>01</span>Breaker trips the instant you reset it</dt>
            <span class="diag__arrow" aria-hidden="true"><?php echo icon('arrow-right', 22); ?></span>
            <dd><strong>A short circuit or ground fault</strong> on that circuit, or a breaker that has failed. Unplug everything on the circuit and try again; if it still trips with nothing plugged in, the fault is in the wiring or a device.</dd>
          </div>
          <div class="diag__row reveal-up">
            <dt><span>02</span>Breaker trips after a few minutes of heavy use</dt>
            <span class="diag__arrow" aria-hidden="true"><?php echo icon('arrow-right', 22); ?></span>
            <dd><strong>An overload:</strong> more running on the circuit than its 15 or 20 amps allow. Space heaters, hair dryers and window air conditioners are the usual suspects, often sharing a circuit with something else.</dd>
          </div>
          <div class="diag__row reveal-up">
            <dt><span>03</span>Outlets dead, but no breaker tripped</dt>
            <span class="diag__arrow" aria-hidden="true"><?php echo icon('arrow-right', 22); ?></span>
            <dd><strong>A tripped GFCI upstream,</strong> or a loose connection at one outlet that feeds the others after it. Outlets wired with push-in "backstab" connections are frequent offenders.</dd>
          </div>
          <div class="diag__row reveal-up">
            <dt><span>04</span>Outlet or switch warm to the touch</dt>
            <span class="diag__arrow" aria-hidden="true"><?php echo icon('arrow-right', 22); ?></span>
            <dd><strong>A loose terminal or a worn device,</strong> or a load bigger than the device is rated for. Stop using it until it is checked. A dimmer running slightly warm is normal; a buzzing, hot one is not.</dd>
          </div>
          <div class="diag__row diag__row--alert reveal-up">
            <dt><span>05</span>Some lights brighten while others dim</dt>
            <span class="diag__arrow" aria-hidden="true"><?php echo icon('arrow-right', 22); ?></span>
            <dd><strong>Possibly a lost or loose neutral,</strong> at the panel or on the utility's side. Turn off computers and TVs, and call. This pattern can push the wrong voltage into appliances.</dd>
          </div>
          <div class="diag__row reveal-up">
            <dt><span>06</span>Half the house has power, half doesn't</dt>
            <span class="diag__arrow" aria-hidden="true"><?php echo icon('arrow-right', 22); ?></span>
            <dd><strong>One leg of the incoming service is down,</strong> or a main connection has failed. If the neighbors are fine, the problem is at your meter, service drop or panel; the utility checks its side first.</dd>
          </div>
        </dl>
      </div>
    </section>

    <!-- 3. EXPERT POSITIONING — stat + evidence -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-left">
            <div class="img-framed">
              <?php echo p1_picture('crew-company-truck-v1', 'Two members of the Dellona Electric crew standing beside the lettered company truck', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>12.5 A</b><span>What a 1,500-watt space heater draws on its own: most of a 15-amp circuit before anything else is plugged in.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-right">
            <span class="eyebrow">Who comes out</span>
            <h2 id="expert-title">Who troubleshoots electrical problems at Dellona Electric?</h2>
            <p class="answer-block">Troubleshooting calls go to the same Dellona Electric crew that wires panels, chargers and new houses, working out of Reedsburg since 2018 under owner Edward Giannoni. Because the crew also does the bigger work, a fault that turns out to be a worn panel or tired wiring stays with one company instead of starting over.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('wrench', 22); ?><b>Work at the device level</b><span>The photo at the top of this page shows a Dellona Electric electrician at an open wall box with a screwdriver in hand. Plenty of repairs end exactly there: one connection, one device, done properly.</span></li>
              <li><?php echo icon('zap', 22); ?><b>When the fault is bigger than one outlet</b><span>Some faults lead back to the panel or to wiring at the end of its life. Dellona Electric also handles <a href="/services/panel-upgrades/">breaker and panel repair</a> and <a href="/services/wiring-rewiring/">wiring repair and rewiring</a>, so the fix can go as deep as the problem does.</span></li>
              <li><?php echo icon('map-pin', 22); ?><b>A Reedsburg number</b><span>Call <?php echo e($phone); ?>. Repairs are one of <?php echo count($services); ?> kinds of work on the <a href="/services/">full list of Dellona Electric services</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. SERVICE BREAKDOWN — what a repair covers + sticky process -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="included-title">
      <div class="container-wide">
        <div class="svc-breakdown__grid">
          <div class="svc-breakdown__sticky svc-body reveal-left">
            <span class="eyebrow">How a repair works</span>
            <h2 id="included-title">How does an electrical repair visit work?</h2>
            <p class="answer-block">An electrical repair visit starts with your description of the problem, then isolates the circuit involved, tests it and fixes the cause rather than the symptom. You come away knowing what failed, why it failed, and whether anything else on that circuit needs attention.</p>
            <ul class="svc-checklist">
              <li><?php echo icon('check', 18); ?><span><strong>Circuit mapping.</strong> Which breaker feeds which outlets and lights, so the fault can be isolated instead of guessed at.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Testing</strong> at the devices, the junction boxes and the breaker for voltage, loose connections and signs of heat.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Replacing what failed:</strong> worn outlets, switches or breakers, and damaged sections of wire.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Remaking connections,</strong> including moving backstabbed wires onto screw terminals while the device is out.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Current protection on replacements.</strong> Wisconsin adopted the 2023 National Electrical Code in September 2026, and replacing an outlet can bring GFCI or AFCI protection with it where the code now asks for it.</span></li>
            </ul>
          </div>
          <div class="reveal-right">
            <h3 class="sr-only">An electrical repair, step by step</h3>
            <ol class="svc-steps">
              <li><h3>Tell us what's happening</h3><p>When it started, which rooms are affected, what was running at the time, and whether anything smelled hot or felt warm. Those details cut the search down before anyone opens a box.</p></li>
              <li><h3>Isolate the circuit</h3><p>Breaker by breaker, find which outlets and lights share the circuit with the problem, and where along that run the fault sits.</p></li>
              <li><h3>Test and find the cause</h3><p>Connections at outlets, switches, splices and the breaker are checked for looseness, heat damage and wear until the cause shows itself.</p></li>
              <li><h3>Fix it and run it under load</h3><p>What failed is replaced or remade, then the circuit is switched back on and run with its normal load to confirm the repair holds.</p></li>
            </ol>
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
            <?php echo p1_picture('panel-work-basement-v1', 'Two electricians working with the cover off a breaker panel in an unfinished basement, tools on a blue ladder', ['sizes' => '(max-width: 900px) 92vw, 520px']); ?>
            <figcaption>Two of the Dellona Electric crew at an open breaker panel, tools set out on the ladder.</figcaption>
          </figure>
          <div class="svc-proof__copy reveal-right">
            <span class="eyebrow">On the job</span>
            <h2 id="proof-title">What do Dellona Electric repairs look like on the job?</h2>
            <p class="answer-block">Much electrical troubleshooting finishes at the breaker panel. This photo shows two Dellona Electric electricians there with the cover off and their tools on a ladder, in an unfinished basement where the cable runs fan out along the joists overhead, which is where a fault on any of those circuits can be traced.</p>
            <p>Reviews from Dellona Electric customers are on the company's Google Business Profile. You can read them there, or leave one after your repair.</p>
            <div class="actions">
              <a class="btn btn-accent" href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?> Read reviews on Google</a>
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

    <!-- 6. COMPARISON — repair vs rewire vs panel, as a real table -->
    <section class="section svc-compare" aria-labelledby="compare-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">How far the fix goes</span>
          <h2 id="compare-title">Should you repair the circuit, rewire it or upgrade the panel?</h2>
          <p class="answer-block">Repair the circuit when one connection, device or breaker has failed and the wiring around it is sound. Rewire when the wire itself is brittle, ungrounded or damaged along its run, and upgrade the panel when the fault traces back to a panel that is full, worn out or too small for the house.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>General guidance. Testing the circuit decides which column your problem actually belongs in.</caption>
            <thead>
              <tr><th scope="col">What testing finds</th><th scope="col" class="is-pick">Repair the circuit</th><th scope="col">Rewire the run</th><th scope="col">Upgrade the panel</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">One loose or burned connection</th><td class="is-pick"><strong>Yes.</strong> Remake it and replace the damaged device.</td><td>No.</td><td>No.</td></tr>
              <tr><th scope="row">A worn outlet, switch or breaker</th><td class="is-pick"><strong>Yes.</strong> Replace the device.</td><td>Only if the wire behind it is brittle.</td><td>Only if several breakers are failing.</td></tr>
              <tr><th scope="row">Fabric-covered or ungrounded two-wire cable</th><td class="is-pick">A short-term fix at best.</td><td><strong>Yes</strong>, for the runs that are affected.</td><td>Sometimes, at the same time.</td></tr>
              <tr><th scope="row">A circuit that trips under normal use</th><td class="is-pick">Split the load onto a new circuit if there is room.</td><td>Rarely.</td><td><strong>Yes</strong> if the panel has no space for that new circuit.</td></tr>
              <tr><th scope="row">Heat damage inside the panel</th><td class="is-pick">No.</td><td>No.</td><td><strong>Yes.</strong></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- 7. FAQ — research-brief questions, answered without unconfirmed numbers -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do Reedsburg customers ask about electrical repairs?</h2>
          <p class="answer-block">Before a repair, people mostly want to know three things: what it will cost, whether Dellona Electric covers their area, and how quickly someone can come. The honest answer to each depends on the fault and the address, so these explain what decides it and what to tell the office when you call.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does an electrical repair cost?</summary>
          <p>An electrical repair is priced by what the fault turns out to be: a single worn outlet is a small job, while a short hidden in a wall or a failing breaker takes longer to find and fix. Describing the symptoms, the age of the house and what was running when it happened helps Dellona Electric give you a realistic idea on the phone at <?php echo e($phone); ?>.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Do you do electrical repairs outside Reedsburg?</summary>
          <p>Dellona Electric does electrical repairs in Reedsburg and across the surrounding Sauk County area from its base on Briar Bluff Rd. If your home or business is farther out, give the address when you call or put it in the estimate form, and you will hear straight away whether the repair is in range.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Can someone come out right away for an electrical problem?</summary>
          <p>Call <?php echo e($phone); ?>, describe the electrical problem, and Dellona Electric will tell you when someone can get there. If anything is smoking, sparking or hot, turn that breaker off first, and call 911 if there is fire. The <a class="svc-inline-link" href="/services/emergency-electrician/">urgent electrical problems page</a> walks through those first steps.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What other electrical work grows out of a <span class="text-accent">repair call</span>?</h2>
        <p class="hero-answer">A repair call sometimes turns up more than one bad outlet. Urgent faults like scorching or partial power loss need fast attention, aging cable may need replacing rather than patching, and worn devices around the house are often swapped while the crew is there. Each of those has its own page below.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <?php echo p1_service_cards(['emergency-electrician', 'wiring-rewiring', 'outlet-switch-repair']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Repair request</span>
        <h2 id="cta-title">Ready to get that circuit sorted out?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with what you're seeing, which rooms it affects and when it started. Dellona Electric will call you back to work out the next step.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
