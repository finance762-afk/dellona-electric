<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/emergency-electrician/ — Phase 4 (premium editorial service page).
 * Intake does NOT confirm hours, after-hours availability or response times, so
 * this page promises none: it tells people what to do first, who to call for
 * what, and to call (608) 477-8453 about the electrical fault. Facts trace to
 * build-plan.json / config.php, the client photos used here (described only by
 * what they show), general electrical-safety guidance, or the sources below.
 * Sources:
 *   City of Reedsburg Building Inspection (lists Reedsburg Utility Commission,
 *     608-768-1000) — https://www.reedsburgwi.gov/buildingsafety
 *   Wisconsin adopts the 2023 NEC (DSPS, signed Sept 1 2026) —
 *     https://www.ecmweb.com/national-electrical-code/article/55403844/wisconsin-adopts-2023-national-electrical-code
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'emergency-electrician';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'Emergency Electrical Repair Reedsburg WI | Dellona Electric';
$pageDescription = 'Sparks, a burning smell or half the house dark in Reedsburg, WI? See what to do first, then call Dellona Electric at (608) 477-8453 for emergency repair.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'truck-trailer-job-site-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Need an electrician to call you back?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'Emergency electrical repair',
    'description' => 'Urgent electrical repair for burning smells, sparking or hot outlets, partial power loss and storm-damaged service masts at homes and businesses in Reedsburg, WI and the surrounding Sauk County area.',
]);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/emergency-electrician/ — page composition: call-first hero, first-five-minutes steps, who-to-call table ==== */
.pg-emergency .svc-hero .hero-call { background: var(--color-accent); color: var(--color-ink); }
.pg-emergency .svc-hero .hero-call:hover { background: var(--color-accent-bright); }
.pg-emergency .svc-hero .hero-form-open { background: transparent; color: var(--color-white); border-color: color-mix(in srgb, var(--color-white) 55%, transparent); }
.pg-emergency .svc-hero .hero-form-open:hover { background: color-mix(in srgb, var(--color-white) 10%, transparent); border-color: var(--color-white); }
.pg-emergency .svc-hero .hero-chips li:first-child svg { color: var(--color-danger); }

/* Signature: the first five minutes */
.pg-emergency .first-five { background: var(--color-surface); }
.pg-emergency .ff-steps { list-style: none; margin: 0; padding: 0; counter-reset: ff; display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: var(--space-4); }
.pg-emergency .ff-step {
  counter-increment: ff; position: relative; display: grid; gap: var(--space-2); align-content: start;
  background: var(--color-paper); border: 1px solid var(--color-line); border-top: 4px solid var(--color-accent);
  border-radius: var(--radius-lg); padding: var(--space-12) var(--space-5) var(--space-5);
}
.pg-emergency .ff-step::before {
  content: counter(ff); position: absolute; top: var(--space-4); left: var(--space-5);
  font-family: var(--font-accent); font-size: var(--font-size-xl); line-height: 1; color: var(--color-accent-dark);
}
.pg-emergency .ff-step--danger { border-top-color: var(--color-danger); background: color-mix(in srgb, var(--color-danger) 5%, var(--color-paper)); }
.pg-emergency .ff-step--danger::before { color: var(--color-danger); }
.pg-emergency .ff-step h3 { font-size: var(--font-size-lg); }
.pg-emergency .ff-step p { margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
@media (max-width: 1100px) { .pg-emergency .ff-steps { grid-template-columns: repeat(2, minmax(0, 1fr)); } .pg-emergency .ff-step:last-child { grid-column: 1 / -1; } }
@media (max-width: 600px) { .pg-emergency .ff-steps { grid-template-columns: 1fr; } }

/* Bento: two warning cards on this page */
.pg-emergency .svc-signs { background: var(--color-paper-2); }
.pg-emergency .svc-sign--warn { background: color-mix(in srgb, var(--color-danger) 6%, var(--color-surface)); border-color: color-mix(in srgb, var(--color-danger) 35%, var(--color-line)); }
.pg-emergency .svc-sign--warn .svc-sign__icon { background: color-mix(in srgb, var(--color-danger) 12%, var(--color-surface)); color: var(--color-danger); }

/* Who-to-call table: the "call first" column carries the accent */
.pg-emergency .svc-table td.call-first { font-weight: 600; color: var(--color-ink); }
.pg-emergency .svc-table a { color: var(--color-primary); font-weight: 600; }
.pg-emergency .svc-expert { background: var(--color-paper); }
.pg-emergency .svc-breakdown { background: var(--color-paper-2); }
.pg-emergency .svc-proof__photo { aspect-ratio: 3 / 4; max-height: 560px; }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-emergency">

  <!-- 1. HERO — call-first: safety answer, phone button, compact callback card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Dellona Electric pickup truck and enclosed trailer, lettered with the company phone number, parked on a job site', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Urgent electrical problems · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="svc-title">Emergency electrical repair in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">If something electrical is smoking, sparking or too hot to touch, turn off its breaker, and call 911 if there is fire or heavy smoke. For a downed line or an outage across the neighborhood, call your utility. For the electrical fault itself in Reedsburg or nearby Sauk County, call Dellona Electric at <?php echo e($phone); ?>.</p>
          <div class="hero-actions">
            <a class="btn btn-lg hero-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
            <button type="button" class="btn btn-lg hero-form-open" data-open-estimate>Request a call back</button>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('flame', 16); ?> Fire? Call 911</li>
            <li><?php echo icon('power', 16); ?> Breaker off first</li>
            <li><?php echo icon('zap', 16); ?> Lines down? Utility</li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- SIGNATURE — the first five minutes -->
    <section class="section first-five" aria-labelledby="ff-title">
      <div class="container-wide">
        <div class="svc-head reveal-up">
          <span class="eyebrow">The first five minutes</span>
          <h2 id="ff-title">What should you do first when something electrical goes wrong?</h2>
          <p class="answer-block">Get people clear, cut the power at the breaker if you can do it safely, and call the right number for what you're facing. Fire goes to 911, lines down or a dark street go to the utility, and a fault inside your home or business goes to an electrician once it is safe.</p>
        </div>
        <ol class="ff-steps">
          <li class="ff-step ff-step--danger reveal-up reveal-delay-1"><h3>Get people away from it</h3><p>Smoke or flames: everyone out, then call 911. Never put water on an electrical fire, and don't go back in for belongings.</p></li>
          <li class="ff-step reveal-up reveal-delay-2"><h3>Turn off the breaker</h3><p>Switch off the breaker for that area, or the main, if the panel is dry and cool to stand at. If the panel itself is hot, smoking or you'd be standing in water, leave it alone.</p></li>
          <li class="ff-step reveal-up reveal-delay-3"><h3>Unplug what's involved</h3><p>Only if the plug and cord aren't hot, melted or sparking. Otherwise leave it in place with the breaker off.</p></li>
          <li class="ff-step ff-step--danger reveal-up reveal-delay-4"><h3>Stay clear of downed lines</h3><p>Treat every fallen line as live. Utilities commonly advise staying at least 30 feet back, and keeping others away while you call.</p></li>
          <li class="ff-step reveal-up reveal-delay-1"><h3>Call the right people</h3><p>911 for fire, the utility for lines and outages, and Dellona Electric at <?php echo e($phone); ?> for the fault on your side of the meter.</p></li>
        </ol>
      </div>
    </section>

    <!-- 2. PROBLEM STATEMENT — what can't wait -->
    <section class="section svc-signs edge-wave-top" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-left">
            <span class="eyebrow">Don't wait on these</span>
            <h2 id="signs-title">Which electrical problems need attention right away?</h2>
            <p class="answer-block">Heat, smoke, sparks and water near anything electrical need attention right away. So do lights that brighten in one room as they dim in another, and power to only half the house. Those point to a failing connection or a problem with the incoming service, and they tend to get worse, not better.</p>
            <p class="pull-quote">A smell of hot plastic near an outlet is not something to sleep on. Turn the breaker off tonight and make the call.</p>
          </div>
          <div class="bento-grid">
            <div class="bento-large svc-sign svc-sign--warn reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('flame', 20); ?></span>
              <h3>Burning smell, smoke or scorch marks</h3>
              <p>Hot plastic or a fishy smell near an outlet, switch, fixture or the panel means insulation is overheating. Turn off that breaker, keep it off, and don't use the outlet again until it has been opened up and repaired. If you see smoke or flame, leave and call 911.</p>
            </div>
            <div class="bento-medium svc-sign svc-sign--warn reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('droplets', 20); ?></span>
              <h3>Water in the basement or panel</h3>
              <p>If water has reached outlets, cords or the panel, don't wade in to reach anything. Call the utility to cut power at the meter if needed.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('lightbulb', 20); ?></span>
              <h3>Lights brighten and dim</h3>
              <p>Some rooms bright, others dim, can mean a lost neutral. Turn off electronics and call.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('cloud-snow', 20); ?></span>
              <h3>Storm damage at the mast</h3>
              <p>A service mast pulled off the house by ice, wind or a falling limb needs the utility first, then an electrician.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 6. COMPARISON — who to call for what -->
    <section class="section svc-compare" aria-labelledby="compare-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Who to call</span>
          <h2 id="compare-title">Should you call 911, the utility or an electrician?</h2>
          <p class="answer-block">Call 911 for fire, smoke or anyone hurt, and call your electric utility for anything on its side: downed lines, a dark street, or a damaged meter or service drop. Call an electrician for faults inside your building and for repairs to the mast and meter base, which are usually the owner's responsibility.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>Inside the City of Reedsburg, the electric utility is the Reedsburg Utility Commission, <a href="tel:+16087681000">608-768-1000</a>. Rural addresses: use the outage number on your electric bill.</caption>
            <thead>
              <tr><th scope="col">What's happening</th><th scope="col" class="is-pick">Call first</th><th scope="col">Then</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">Fire, flames or heavy smoke</th><td class="is-pick call-first">911</td><td>Dellona Electric, once the fire department has cleared the building.</td></tr>
              <tr><th scope="row">A downed or sagging power line</th><td class="is-pick call-first">911 or your electric utility</td><td>Stay back; the utility makes the line safe.</td></tr>
              <tr><th scope="row">The whole street is dark</th><td class="is-pick call-first">Your utility's outage line</td><td>Switch off sensitive electronics until power returns.</td></tr>
              <tr><th scope="row">Your building is dark, the neighbors aren't</th><td class="is-pick call-first">Check the main breaker, then the utility</td><td>Dellona Electric, if the utility's side checks out.</td></tr>
              <tr><th scope="row">Half the house dead, or lights brightening and dimming</th><td class="is-pick call-first">Your utility</td><td>Dellona Electric for the panel and wiring side.</td></tr>
              <tr><th scope="row">Burning smell, a hot outlet, a buzzing panel</th><td class="is-pick call-first">Breaker off, then Dellona Electric</td><td>Keep that circuit off until it's repaired.</td></tr>
              <tr><th scope="row">Mast or meter base torn off by a storm</th><td class="is-pick call-first">Your utility, to disconnect</td><td>Dellona Electric to repair the mast and meter base so service can be restored.</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- 3. EXPERT POSITIONING — stat + evidence -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-left">
            <div class="img-framed">
              <?php echo p1_picture('standby-generator-log-home-v1', 'Two electricians running conduit beside a Kohler standby generator and an air conditioner at a log home', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>30 ft</b><span>The distance utilities commonly tell people to keep from a downed power line.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-right">
            <span class="eyebrow">Who handles it</span>
            <h2 id="expert-title">Who handles urgent electrical repairs for Dellona Electric?</h2>
            <p class="answer-block">Urgent repairs go to Dellona Electric, the Reedsburg electrical company owned by Edward Giannoni since 2018, at <?php echo e($phone); ?>. The crew that comes out is the same one that wires panels, generators and new homes, and the truck and trailer in the photo at the top of this page carry that number on the side.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('wrench', 22); ?><b>Made safe, then fixed properly</b><span>A burned connection might be one outlet or a failing breaker. Dellona Electric does both <a href="/services/electrical-repair/">electrical repair and troubleshooting</a> and <a href="/services/panel-upgrades/">panel repair and upgrades</a>, so the urgent fix and the lasting one come from the same people.</span></li>
              <li><?php echo icon('power', 22); ?><b>Ready for the next outage</b><span>The photo here shows the crew running conduit to a Kohler standby generator. If outages keep catching you out, <a href="/services/generator-installation/">generator installation</a> is how to keep the lights and the well pump on next time.</span></li>
              <li><?php echo icon('map-pin', 22); ?><b>Based in Reedsburg</b><span>Dellona Electric works out of <?php echo e($address['street']); ?>. Its other work is listed on the <a href="/services/">services page</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. SERVICE BREAKDOWN — what happens after the call -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="included-title">
      <div class="container-wide">
        <div class="svc-breakdown__grid">
          <div class="svc-breakdown__sticky svc-body reveal-left">
            <span class="eyebrow">After you call</span>
            <h2 id="included-title">What happens after you call Dellona Electric about an urgent problem?</h2>
            <p class="answer-block">You describe what you see, smell and hear, and Dellona Electric tells you whether it is safe to leave the circuit off and when someone can get there. On site, the order is: make it safe, find the cause, then repair it or leave it secure until the full repair can be done.</p>
            <ul class="svc-checklist">
              <li><?php echo icon('check', 18); ?><span><strong>What to tell us on the phone:</strong> the address, what happened, which rooms or circuits are affected, and whether the breaker is already off.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Making it safe:</strong> the damaged circuit is isolated so the rest of the house can have power back where that's possible.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Finding the cause:</strong> a burned connection, a failed device or breaker, water, or a problem with the incoming service.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Repairs that meet today's code.</strong> Wisconsin adopted the 2023 National Electrical Code in September 2026, and repaired or replaced parts are brought up to it.</span></li>
            </ul>
          </div>
          <div class="reveal-right">
            <h3 class="sr-only">An urgent repair call, step by step</h3>
            <ol class="svc-steps">
              <li><h3>Call and describe it</h3><p>Ring <?php echo e($phone); ?>. If you can't talk safely where you are, step outside first.</p></li>
              <li><h3>Hear what to do meanwhile</h3><p>Whether to keep a breaker off, stay out of a room, or call the utility first, and when someone can come.</p></li>
              <li><h3>Isolate and find the fault</h3><p>On site, the affected circuit is cut off from the rest, then traced to the connection, device or equipment that failed.</p></li>
              <li><h3>Repair or secure</h3><p>When the parts are on hand, the repair is made there and then. If a part or a bigger repair is needed, the circuit is left safe and the rest of the work is scheduled with you.</p></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. PROOF — dark grain band, crew photo, Google profile -->
    <section class="section svc-proof texture-grain slant-top" aria-labelledby="proof-title">
      <span class="grain-layer" aria-hidden="true"></span>
      <div class="container">
        <div class="svc-proof__grid">
          <div class="svc-proof__copy reveal-left">
            <span class="eyebrow">Who you'll see</span>
            <h2 id="proof-title">Who shows up when you call Dellona Electric?</h2>
            <p class="answer-block">Dellona Electric's crew drives a truck lettered with the company name, and this photo shows two of them standing beside it. The number painted on the trailer at the top of this page is the same <?php echo e($phone); ?> you call, which makes it easy to tell who is pulling into the driveway.</p>
            <p>Reviews of Dellona Electric are posted on the company's Google Business Profile. Read them there, or add yours once the problem is fixed.</p>
            <div class="actions">
              <a class="btn btn-accent" href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?> Dellona Electric on Google</a>
              <a class="btn btn-outline-white" href="<?php echo e($reviewRequestUrl); ?>" target="_blank" rel="noopener">Leave a review</a>
            </div>
          </div>
          <figure class="svc-proof__photo reveal-right">
            <?php echo p1_picture('crew-company-truck-v1', 'Two members of the Dellona Electric crew standing beside the lettered company truck', ['sizes' => '(max-width: 900px) 92vw, 443px']); ?>
            <figcaption>Two of the Dellona Electric crew with the company truck.</figcaption>
          </figure>
        </div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
        echo p1_google_reviews($slug, ['heading' => '', 'limit' => 3]);
        ?>
      </div>
    </section>

    <!-- 7. FAQ — research-brief questions, answered honestly (hours unconfirmed) -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do people ask Dellona Electric about urgent electrical calls?</h2>
          <p class="answer-block">People calling about an urgent electrical problem want to know whether Dellona Electric takes after-hours calls, what an urgent repair costs, and whether their address is covered. The answers below are straight about what this page can and can't promise, and point you to the phone call that settles each one.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>Do you offer emergency or after-hours electrical service?</summary>
          <p>Call <?php echo e($phone); ?> and describe the electrical problem, and Dellona Electric will tell you when someone can be there. Hours and after-hours availability aren't listed on this site yet, so ask on the call rather than assume. If there is fire, smoke or a downed line, call 911 or your utility first.</p>
        </details>
        <details class="faq reveal-up">
          <summary>How much does an emergency electrical repair cost?</summary>
          <p>An urgent electrical repair is priced by what failed and what it takes to fix it: replacing one burned outlet is very different from rebuilding a storm-damaged service mast. Ask on the phone how the visit will be charged before anyone sets out, so there are no surprises when the work is done.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Do you cover urgent calls outside Reedsburg?</summary>
          <p>Dellona Electric is based in Reedsburg and works across the surrounding Sauk County area. For an urgent problem farther out, give your full address when you call and you'll find out straight away whether someone can reach you, and roughly when.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What other work follows an <span class="text-accent">urgent electrical</span> call?</h2>
        <p class="hero-answer">An urgent call often leads to a longer fix. The burned connection gets a proper repair, a failing breaker can point to a panel that needs replacing, and a bad outage is the usual reason people look at a standby generator. Each of those has its own page below with what the work involves.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <?php echo p1_service_cards(['electrical-repair', 'panel-upgrades', 'generator-installation']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Call first</span>
        <h2 id="cta-title">Need an electrician for something unsafe right now?</h2>
        <p>Turn the breaker off if it's safe to, then call <?php echo e($phone); ?>. If it can wait for a call back, send the form and Dellona Electric will ring you.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate>Request a call back</button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
