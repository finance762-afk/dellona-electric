<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/panel-upgrades/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php, the client photo on this page,
 * or the public sources below. Prices, permit handling, outage length and the
 * owner's process are unconfirmed and stay out of the copy (content-confirmations.json).
 * Sources:
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 *   Wisconsin adopts the 2023 NEC (DSPS, signed Sept 1 2026) —
 *     https://www.ecmweb.com/national-electrical-code/article/55403844/wisconsin-adopts-2023-national-electrical-code
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'panel-upgrades';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'Panel Repair & Upgrades Reedsburg WI | Dellona Electric';
$pageDescription = 'Electrical panel repair, circuit breaker repair and panel upgrades in Reedsburg, WI from Dellona Electric. Call (608) 477-8453 to have your panel checked.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'panel-work-basement-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Want your panel looked at?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'Electrical panel upgrade',
    'description' => 'Electrical panel repair, circuit breaker repair and panel or service upgrades for homes and businesses in Reedsburg, WI and the surrounding Sauk County area.',
]);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/panel-upgrades/ — page composition: breaker-slot texture, amp ladder, repair-vs-replace table ==== */
.pg-panel .svc-sign.bento-large {
  background:
    repeating-linear-gradient(180deg, transparent 0 var(--space-6), color-mix(in srgb, var(--color-primary) 6%, transparent) var(--space-6) calc(var(--space-6) + 2px)),
    var(--color-card-tint-1);
}
.pg-panel .svc-sign.bento-large h3 { font-size: var(--fs-h3); }
.pg-panel .svc-sign--warn { border-color: color-mix(in srgb, var(--color-danger) 35%, var(--color-line)); }
.pg-panel .svc-sign--warn .svc-sign__icon { background: color-mix(in srgb, var(--color-danger) 12%, var(--color-surface)); color: var(--color-danger); }

/* Amp ladder: the three service sizes most homes sit at, drawn as rising bars */
.pg-panel .amp-ladder { list-style: none; margin: var(--space-4) 0 0; padding: 0; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-3); align-items: end; }
.pg-panel .amp-ladder li { display: grid; gap: var(--space-2); align-content: end; }
.pg-panel .amp-ladder i { display: block; border-radius: var(--radius-sm) var(--radius-sm) 0 0; background: linear-gradient(180deg, var(--color-accent), var(--color-accent-dark)); }
.pg-panel .amp-ladder li:nth-child(1) i { height: var(--space-10); opacity: .45; }
.pg-panel .amp-ladder li:nth-child(2) i { height: var(--space-16); opacity: .7; }
.pg-panel .amp-ladder li:nth-child(3) i { height: calc(var(--space-16) * 1.6); }
.pg-panel .amp-ladder b { font-family: var(--font-accent); font-size: var(--font-size-xl); color: var(--color-ink); line-height: 1; }
.pg-panel .amp-ladder span { font-size: var(--font-size-xs); color: var(--color-muted); }

/* Expert split runs photo-right on this page */
.pg-panel .svc-expert__grid { grid-template-columns: minmax(0, 1.2fr) minmax(0, .8fr); }
.pg-panel .svc-expert__figure { order: 2; }
.pg-panel .svc-expert__stat { right: auto; left: calc(-1 * var(--space-6)); }
@media (max-width: 900px) {
  .pg-panel .svc-expert__grid { grid-template-columns: 1fr; }
  .pg-panel .svc-expert__figure { order: 0; }
  .pg-panel .svc-expert__stat { left: var(--space-4); }
}

/* Proof photo is portrait: cap its height beside the copy */
.pg-panel .svc-proof__photo { aspect-ratio: 4 / 5; max-height: 620px; }
.pg-panel .svc-table td.is-pick strong { color: var(--color-ink); }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-panel">

  <!-- 1. HERO — layered dark band, client panel photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Two Dellona Electric electricians working inside an open breaker panel in an unfinished basement', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Panels &amp; breakers · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="svc-title">Electrical panel repair and upgrades in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric repairs failing breakers and replaces or upgrades electrical panels for homes and businesses in Reedsburg and the surrounding Sauk County area. If breakers trip, buzz or run warm, or your panel has no room for an EV charger, a generator or an addition, the panel is the place to start.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
            <li><?php echo icon('map-pin', 16); ?> Reedsburg-based</li>
            <li><?php echo icon('zap', 16); ?> Panels &amp; breakers</li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- 2. PROBLEM STATEMENT — pull quote + telltale signs in bento cards -->
    <section class="section svc-signs" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-left">
            <span class="eyebrow">Telltale signs</span>
            <h2 id="signs-title">What are the signs your electrical panel needs repair or an upgrade?</h2>
            <p class="answer-block">Breakers that trip again after a reset, a panel that buzzes or feels warm, and a box with no empty slots are the three most common signs. Each one points to a worn breaker, a loose connection or a panel that has run out of room for what the house now asks of it.</p>
            <p class="pull-quote">A breaker that trips once is doing its job. A breaker that trips every week is telling you about the circuit behind it.</p>
          </div>
          <div class="bento-grid">
            <div class="bento-large svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('zap', 20); ?></span>
              <h3>Breakers that won't stay on</h3>
              <p>A breaker that trips again within minutes of a reset is either protecting a circuit that is overloaded or faulted, or it has worn out itself. Either way the cause needs finding. Resetting it over and over only wears it further. If it is one circuit and the panel is otherwise sound, that is usually an <a class="svc-inline-link" href="/services/electrical-repair/">electrical repair and troubleshooting</a> job rather than a new panel.</p>
            </div>
            <div class="bento-medium svc-sign svc-sign--warn reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('flame', 20); ?></span>
              <h3>Warm, buzzing or scorched</h3>
              <p>Heat you can feel on the cover, a steady buzz, or brown marks around a breaker mean a connection is loose or failing. Turn that breaker off, leave the cover on and call.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('layers', 20); ?></span>
              <h3>No open slots</h3>
              <p>Tandem breakers doubled up in every space, or a small sub-panel added to make room, usually mean the panel is full.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('alert-triangle', 20); ?></span>
              <h3>Federal Pacific or Zinsco</h3>
              <p>Federal Pacific Stab-Lok and Zinsco panels have a long record of breakers that may not trip under overload. They are worth replacing, not repairing.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. EXPERT POSITIONING — 60/40 split, technical stat, evidence from the client's own jobs -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-right">
            <div class="img-framed">
              <?php echo p1_picture('standby-generator-log-home-v1', 'Dellona Electric electricians wiring an outdoor disconnect beside a Kohler standby generator and an air conditioner at a log home', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>200 A</b><span>A common size for a whole-home panel upgrade. Many older homes still run on 100 amps or less.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-left">
            <span class="eyebrow">Who does the work</span>
            <h2 id="expert-title">Who handles panel and breaker work at Dellona Electric?</h2>
            <p class="answer-block">Panel work at Dellona Electric is handled by the Reedsburg company Edward Giannoni has run since 2018. The crew works in everything from older basements with log joists overhead to new builds and commercial spaces, and the panel job photographed at the top of this page is one of them.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('home', 22); ?><b>Older basements are routine</b><span>The photo at the top of this page shows two of the crew in an open panel under log joists, with cable runs fanned out along the beams. Block walls, exposed joists and wiring added over decades are normal territory.</span></li>
              <li><?php echo icon('battery-charging', 22); ?><b>The panel and what it feeds, from one call</b><span>Dellona Electric also installs <a href="/services/ev-charger-installation/">home EV chargers</a> and <a href="/services/generator-installation/">standby generators with transfer switches</a>, the two most common reasons a panel runs out of room. The photo here is the outdoor side of a Kohler standby install.</span></li>
              <li><?php echo icon('map-pin', 22); ?><b>Local to Reedsburg</b><span>The company is based at <?php echo e($address['street']); ?> in Reedsburg, and the number to call is <?php echo e($phone); ?>. Panel work is one of <?php echo count($services); ?> services listed on the <a href="/services/">Dellona Electric services page</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. SERVICE BREAKDOWN — what's included + sticky-scroll process -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="included-title">
      <div class="container-wide">
        <div class="svc-breakdown__grid">
          <div class="svc-breakdown__sticky svc-body reveal-left">
            <span class="eyebrow">What's included</span>
            <h2 id="included-title">What's included in a panel upgrade from Dellona Electric?</h2>
            <p class="answer-block">A panel upgrade swaps your breaker panel for a larger one sized to the home's actual load and moves every existing circuit into it. Depending on the house, it can also mean a new meter base, service entrance cable and grounding, and it ends with every breaker labeled and the power back on.</p>
            <ul class="svc-checklist">
              <li><?php echo icon('check', 18); ?><span><strong>A load count first.</strong> Furnace, range, dryer, water heater, well pump and anything you plan to add, such as a charger or heat pump, decide whether 100, 150 or 200 amps makes sense.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>New panel and breakers,</strong> including the AFCI and GFCI breakers the code calls for on the circuits that need them.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Service entrance and meter base</strong> when the amperage of the service itself goes up.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Grounding and bonding</strong> brought up to current requirements.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Surge protection.</strong> Wisconsin adopted the 2023 National Electrical Code in September 2026, and it calls for a surge protective device when a home's service equipment is replaced. More on that on the <a href="/services/surge-protection/">whole-house surge protection page</a>.</span></li>
            </ul>
            <ol class="amp-ladder" aria-label="Typical residential service sizes">
              <li><i></i><b>60–100 A</b><span>Older homes, fuses or a small breaker panel</span></li>
              <li><i></i><b>150 A</b><span>Mid-size homes with gas heat</span></li>
              <li><i></i><b>200 A</b><span>Electric heat, EV charging, shops</span></li>
            </ol>
          </div>
          <div class="reveal-right">
            <h3 class="sr-only">How a panel upgrade goes, step by step</h3>
            <ol class="svc-steps">
              <li><h3>Look at the panel and what it feeds</h3><p>Brand, age, open slots, signs of heat or water, and what you want to add in the next few years. A panel that only needs one breaker replaced gets that, not a sales pitch.</p></li>
              <li><h3>Size the new panel</h3><p>The load count sets the panel and service size, and you hear what the job covers before any work is scheduled.</p></li>
              <li><h3>Power down and swap</h3><p>When the service size changes, the utility has to disconnect and reconnect power at the meter. The old panel comes out, the new one goes in, and each circuit is moved over and landed on its own breaker.</p></li>
              <li><h3>Test, label and restore</h3><p>Every circuit is switched on and checked, the panel directory is written out so each breaker says what it controls, and you are shown where the main shutoff is.</p></li>
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
          <div class="svc-proof__copy reveal-left">
            <span class="eyebrow">From the job site</span>
            <h2 id="proof-title">What does panel work by Dellona Electric look like?</h2>
            <p class="answer-block">This photo shows two Dellona Electric electricians working in an open breaker panel in an unfinished basement, with cable runs fanned out along the log joists above it. It is the kind of space panel work happens in across older homes in this part of Wisconsin: block walls, exposed beams and wiring added over decades.</p>
            <p>Customer reviews for Dellona Electric live on the company's Google Business Profile, where you can read them or add your own after a job.</p>
            <div class="actions">
              <a class="btn btn-accent" href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?> See Dellona Electric on Google</a>
              <a class="btn btn-outline-white" href="<?php echo e($reviewRequestUrl); ?>" target="_blank" rel="noopener">Leave a review</a>
            </div>
          </div>
          <figure class="svc-proof__photo reveal-right">
            <?php echo p1_picture('panel-work-basement-v1', 'Two electricians working in an open breaker panel with cable runs fanned out along the log joists above', ['sizes' => '(max-width: 900px) 92vw, 540px']); ?>
            <figcaption>Panel work in an unfinished basement: new cable runs dressed along the joists above the box.</figcaption>
          </figure>
        </div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
        echo p1_google_reviews($slug, ['heading' => '', 'limit' => 3]);
        ?>
      </div>
    </section>

    <!-- 6. COMPARISON — repair vs replace, as a real table -->
    <section class="section svc-compare" aria-labelledby="compare-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Repair or replace</span>
          <h2 id="compare-title">Should you repair your breaker panel or replace it?</h2>
          <p class="answer-block">Repair makes sense when one breaker or one connection has failed in a panel that is otherwise sound and big enough. Replacement makes sense when the panel is full, too small for what you are adding, damaged by heat or water, or a brand with a record of breakers that may not trip.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>General guidance. The right call depends on what is found once the panel cover comes off.</caption>
            <thead>
              <tr><th scope="col">What you're seeing</th><th scope="col">Repair the panel</th><th scope="col" class="is-pick">Replace or upgrade it</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">One breaker trips or won't reset</th><td><strong>Usually.</strong> Replace the breaker or fix the circuit it protects.</td><td class="is-pick">Only if the panel itself turns out to be damaged.</td></tr>
              <tr><th scope="row">Warmth, buzzing or scorch marks</th><td>If the damage is limited to one breaker and its connection.</td><td class="is-pick"><strong>Yes</strong> if the bus bar or several breakers are heat-damaged.</td></tr>
              <tr><th scope="row">No empty slots</th><td>A short-term fix with tandem breakers, where the panel is listed for them.</td><td class="is-pick"><strong>Yes</strong> if you are adding circuits.</td></tr>
              <tr><th scope="row">Adding an EV charger, heat pump or addition</th><td>Possible if the load count shows room.</td><td class="is-pick"><strong>Usually</strong> when it doesn't.</td></tr>
              <tr><th scope="row">Federal Pacific Stab-Lok or Zinsco panel</th><td>Not recommended.</td><td class="is-pick"><strong>Yes.</strong></td></tr>
              <tr><th scope="row">Water got into the panel</th><td>No. Wet breakers are not dried out and reused.</td><td class="is-pick"><strong>Yes</strong>, the affected breakers or the whole panel.</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- 7. FAQ — questions from the research brief, answered without unconfirmed numbers -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do Reedsburg homeowners ask about panel upgrades?</h2>
          <p class="answer-block">Most questions about a panel upgrade come down to two things: what it will cost and whether it needs a permit. Both depend on the house and the jurisdiction, so the answers below explain what drives each one and how you find out for your own panel before any work starts.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does an electrical panel upgrade cost?</summary>
          <p>The price of a panel upgrade depends on the new panel size, whether the meter base and service entrance cable change too, how many circuits move over, and whether code updates such as grounding or surge protection are part of the job. Dellona Electric looks at the panel and what you plan to add before pricing it. Call <?php echo e($phone); ?> to set that up.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Does a panel upgrade need a permit in Reedsburg?</summary>
          <p>Usually, yes. Inside the city, the City of Reedsburg Building Inspection Department issues permits and lists electrical alterations among the work that may need one. Properties in the surrounding towns fall under their own inspector. Ask when you call and you will know before work starts whether your panel upgrade needs a permit.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What other electrical work often goes with a <span class="text-accent">panel upgrade</span>?</h2>
        <p class="hero-answer">A panel upgrade usually happens because something new needs power. Common reasons are an EV charger in the garage or a standby generator with its transfer switch, and surge protection now comes along whenever the service equipment is replaced. Each of those has its own page below, and the work can be planned together.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <?php echo p1_service_cards(['ev-charger-installation', 'generator-installation', 'surge-protection']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Panel estimate</span>
        <h2 id="cta-title">Ready to have your panel looked at?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with your panel's brand and what you plan to add. Dellona Electric will call you back to talk it through.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
