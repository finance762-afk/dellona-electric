<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/wiring-rewiring/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php, the client photos used on this
 * page (described only by what they show), general electrical-code knowledge
 * (wiring eras, NEC replacement rules), or the public sources below. Prices,
 * job length, wall patching and the owner's rewiring process are unconfirmed and
 * stay out of the copy (/content-confirmations.json).
 * Sources:
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 *   Wisconsin adopts the 2023 NEC (DSPS, signed Sept 1 2026) —
 *     https://www.ecmweb.com/national-electrical-code/article/55403844/wisconsin-adopts-2023-national-electrical-code
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'wiring-rewiring';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'Wiring Repair & Rewiring Reedsburg WI | Dellona Electric';
$pageDescription = 'Faulty wiring repair and home rewiring in Reedsburg, WI for knob-and-tube, cloth-sheathed and ungrounded circuits. Call Dellona Electric at (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'panel-work-basement-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Want your wiring checked?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'Electrical wiring repair',
    'description' => 'Faulty and damaged wiring repair, plus partial and whole-home rewiring of knob-and-tube, cloth-sheathed, aluminum and ungrounded circuits, for homes in Reedsburg, WI and the surrounding Sauk County area.',
]);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/wiring-rewiring/ — page composition: wiring-era timeline, photo-right expert, proof after the table ==== */
.pg-wiring .svc-signs .bento-grid > .bento-large { order: 2; }
.pg-wiring .svc-sign.bento-large {
  background:
    repeating-linear-gradient(135deg, transparent 0 var(--space-4), color-mix(in srgb, var(--color-accent) 7%, transparent) var(--space-4) calc(var(--space-4) + 2px)),
    var(--color-card-tint-3);
}

/* Signature: era line — five generations of house wiring */
.pg-wiring .era-section { background: var(--color-surface); }
.pg-wiring .era-line { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: var(--space-4); position: relative; }
.pg-wiring .era-line::before {
  content: ""; position: absolute; left: var(--space-2); right: var(--space-2); top: calc(var(--space-3) + 1px); height: 3px; border-radius: var(--radius-full);
  background: linear-gradient(90deg, var(--color-danger), var(--color-accent) 55%, var(--color-success));
}
.pg-wiring .era { position: relative; display: grid; gap: var(--space-2); align-content: start; padding-top: var(--space-10); }
.pg-wiring .era::before {
  content: ""; position: absolute; top: 0; left: 0; width: var(--space-6); height: var(--space-6); border-radius: 50%;
  background: var(--color-surface); border: 4px solid var(--color-accent); box-shadow: var(--shadow-sm);
}
.pg-wiring .era:first-child::before { border-color: var(--color-danger); }
.pg-wiring .era:last-child::before { border-color: var(--color-success); }
.pg-wiring .era__years { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.pg-wiring .era h3 { font-size: var(--font-size-lg); }
.pg-wiring .era p { margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-wiring .era__verdict { display: inline-block; justify-self: start; margin-top: var(--space-1); font-size: var(--font-size-xs); font-weight: 600; padding: var(--space-1) var(--space-2); border-radius: var(--radius-sm); background: var(--color-paper-2); color: var(--color-ink); }
@media (max-width: 1000px) {
  .pg-wiring .era-line { grid-template-columns: 1fr; gap: var(--space-6); padding-left: var(--space-10); }
  .pg-wiring .era-line::before { left: var(--space-3); right: auto; top: var(--space-2); bottom: var(--space-2); width: 3px; height: auto; background: linear-gradient(180deg, var(--color-danger), var(--color-accent) 55%, var(--color-success)); }
  .pg-wiring .era { padding-top: 0; }
  .pg-wiring .era::before { left: calc(-1 * var(--space-10)); }
}

/* Expert split runs photo-right, stat on the left edge */
.pg-wiring .svc-expert { background: var(--color-paper-2); }
.pg-wiring .svc-expert__grid { grid-template-columns: minmax(0, 1.2fr) minmax(0, .8fr); }
.pg-wiring .svc-expert__figure { order: 2; }
.pg-wiring .svc-expert__figure .img-framed { aspect-ratio: 4 / 3.4; }
.pg-wiring .svc-expert__stat { right: auto; left: calc(-1 * var(--space-6)); bottom: calc(-1 * var(--space-6)); }
@media (max-width: 900px) {
  .pg-wiring .svc-expert__grid { grid-template-columns: 1fr; }
  .pg-wiring .svc-expert__figure { order: 0; }
  .pg-wiring .svc-expert__stat { left: var(--space-4); }
}
.pg-wiring .svc-breakdown { background: var(--color-paper); }
.pg-wiring .svc-table thead th:first-child { width: 24%; }
.pg-wiring .svc-proof__photo { aspect-ratio: 4 / 5; max-height: 600px; }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-wiring">

  <!-- 1. HERO — layered dark band, basement wiring photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Cable runs fanned out along the log joists of an old basement while two electricians work at the breaker panel below', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Wiring &amp; rewiring · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="svc-title">Wiring repair and rewiring in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric repairs damaged and faulty wiring and rewires older homes in Reedsburg and the surrounding Sauk County area, a few rooms at a time or the whole house. That covers replacing knob-and-tube and cloth-sheathed cable, adding grounded circuits where outlets are still two-prong, and rewiring walls opened up during a remodel.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('home', 16); ?> Older homes</li>
            <li><?php echo icon('hammer', 16); ?> Remodel rewiring</li>
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- 2. PROBLEM STATEMENT — pull quote + signs in bento cards -->
    <section class="section svc-signs" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-left">
            <span class="eyebrow">What to look for</span>
            <h2 id="signs-title">How can you tell your home's wiring needs repair or replacing?</h2>
            <p class="answer-block">Old or failing wiring usually shows itself in plain sight. Look for two-prong outlets, fabric-covered cable in the basement or attic, outlets that feel warm or loose, and breakers that trip on ordinary use. Any one of them deserves a closer look; two or more usually mean the wiring itself is the problem, not a single device.</p>
            <p class="pull-quote">Wire doesn't wear out from being used. It wears out from heat, age, mice and every owner who added a circuit their own way.</p>
          </div>
          <div class="bento-grid">
            <div class="bento-medium svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('layers', 20); ?></span>
              <h3>Fabric-covered or brittle cable</h3>
              <p>Cloth-jacketed cable from the 1940s through the 1960s has rubber insulation that hardens and cracks, worst of all inside light fixtures where it has been cooked for decades.</p>
            </div>
            <div class="bento-large svc-sign reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('plug', 20); ?></span>
              <h3>Two-prong outlets in most rooms</h3>
              <p>Two-slot outlets usually mean ungrounded two-wire circuits. A three-prong adapter, or a three-prong outlet swapped onto the same two wires, only looks grounded. The code does allow a GFCI outlet labeled "No Equipment Ground" as a protected stopgap, but new grounded cable is the lasting fix.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('alert-triangle', 20); ?></span>
              <h3>Splices with no box</h3>
              <p>Taped splices hanging in a basement or buried in an attic are a common leftover from past additions, and a common place for heat to build.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('droplets', 20); ?></span>
              <h3>Chewed or wet wiring</h3>
              <p>Rodent-chewed insulation in attics and outbuildings, or cable that has sat in a damp basement, needs replacing rather than taping.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SIGNATURE — wiring-era line -->
    <section class="section era-section edge-torn-top" aria-labelledby="era-title">
      <div class="container-wide">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Wiring by era</span>
          <h2 id="era-title">What kind of wiring is likely inside an older Wisconsin home?</h2>
          <p class="answer-block">The age of a house is the best first guess at the wiring inside it. Homes built before about 1940 may still have knob-and-tube, mid-century houses often run on cloth-sheathed cable with no ground, and some homes wired in the late 1960s and early 1970s have aluminum branch circuits. Later additions often mix all three.</p>
        </div>
        <ol class="era-line">
          <li class="era reveal-up reveal-delay-1">
            <span class="era__years">Before about 1940</span>
            <h3>Knob-and-tube</h3>
            <p>Single wires strung on ceramic knobs and through ceramic tubes, with no ground. The insulation is brittle by now, and attic insulation packed around it traps heat it was never designed for. Some home insurers ask about it before covering a house.</p>
            <span class="era__verdict">Replace</span>
          </li>
          <li class="era reveal-up reveal-delay-2">
            <span class="era__years">1940s – 1960s</span>
            <h3>Cloth-sheathed cable</h3>
            <p>Two insulated wires in a fabric jacket, often without a ground wire. It looks tidier than knob-and-tube, but the rubber insulation underneath cracks when it is moved.</p>
            <span class="era__verdict">Replace when you can</span>
          </li>
          <li class="era reveal-up reveal-delay-3">
            <span class="era__years">About 1965 – 1973</span>
            <h3>Aluminum branch circuits</h3>
            <p>Solid aluminum wire on 15 and 20 amp circuits. It expands and loosens at outlets and switches not rated for aluminum, and those loose joints run hot.</p>
            <span class="era__verdict">Repair the connections or rewire</span>
          </li>
          <li class="era reveal-up reveal-delay-4">
            <span class="era__years">1970s onward</span>
            <h3>Grounded plastic-sheathed cable</h3>
            <p>Modern cable with a bare ground wire. The wire itself is usually fine; the trouble is damage, overloaded circuits and do-it-yourself additions.</p>
            <span class="era__verdict">Repair what's damaged</span>
          </li>
          <li class="era reveal-up reveal-delay-1">
            <span class="era__years">Today</span>
            <h3>Protected circuits</h3>
            <p>Since Wisconsin adopted the 2023 National Electrical Code in September 2026, new circuits in living areas get arc-fault protection and wet locations get GFCI protection.</p>
            <span class="era__verdict">What new work looks like</span>
          </li>
        </ol>
      </div>
    </section>

    <!-- 3. EXPERT POSITIONING — photo right, stat on the left edge -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-right">
            <div class="img-framed">
              <?php echo p1_picture('hero-kitchen-lighting-v1', 'Kitchen with recessed ceiling lights and three pendant lights over a white island', ['sizes' => '(max-width: 900px) 90vw, 440px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>1965–73</b><span>Roughly when aluminum branch-circuit wire went into some homes. Its connections need devices and connectors rated for aluminum.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-left">
            <span class="eyebrow">Who does the work</span>
            <h2 id="expert-title">Who handles wiring repair and rewiring for Dellona Electric?</h2>
            <p class="answer-block">Wiring repairs and rewiring at Dellona Electric are handled by the Reedsburg company's crew under owner Edward Giannoni, in business since 2018. The work runs from replacing one damaged run in a basement to wiring a whole room for new lighting, like the kitchen pictured here with its recessed lights and island pendants.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('home', 22); ?><b>At home in old basements</b><span>The photo at the top of this page shows two of the crew at a panel under log joists, with cable runs dressed along the beams above them. Old framing, block walls and wiring added over decades are part of the job.</span></li>
              <li><?php echo icon('zap', 22); ?><b>The panel gets planned with the wire</b><span>A rewire often runs into a panel with no room left. Dellona Electric also does <a href="/services/panel-upgrades/">panel repair and upgrades</a>, so new circuits and the panel that feeds them can be planned as one job.</span></li>
              <li><?php echo icon('plug', 22); ?><b>Sometimes the device is the whole problem</b><span>If testing shows sound wire behind a tired outlet, the fix is <a href="/services/outlet-switch-repair/">outlet and switch repair</a>, not a rewire. The full range of work is on the <a href="/services/">Dellona Electric services page</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. SERVICE BREAKDOWN — what a rewire involves + sticky process -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="included-title">
      <div class="container-wide">
        <div class="svc-breakdown__grid">
          <div class="svc-breakdown__sticky svc-body reveal-left">
            <span class="eyebrow">What a rewire involves</span>
            <h2 id="included-title">What does rewiring an older house involve?</h2>
            <p class="answer-block">Rewiring replaces old cable with new grounded circuits, one area at a time, usually by fishing new cable through existing walls and ceilings rather than tearing them open. Access from the basement and attic does most of the work, and the old wiring is disconnected so it can never carry power again.</p>
            <ul class="svc-checklist">
              <li><?php echo icon('check', 18); ?><span><strong>A survey of what's there:</strong> which circuits are live, what type of wire each one is, and where splices and boxes hide.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>A circuit plan</strong> that gives kitchens, bathrooms and laundry the dedicated circuits current code expects, instead of copying the old layout.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>New grounded cable</strong> fished through walls and ceilings to new boxes.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>New outlets and switches</strong> with arc-fault and GFCI protection where the 2023 code calls for them.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Old wiring retired:</strong> disconnected at both ends and removed where it can be reached.</span></li>
            </ul>
          </div>
          <div class="reveal-right">
            <h3 class="sr-only">How a rewire goes, step by step</h3>
            <ol class="svc-steps">
              <li><h3>Walk the house</h3><p>Basement, attic, every room. Outlets are tested, the panel is opened, and the old wire types are identified so the scope is based on what is really in the walls.</p></li>
              <li><h3>Plan circuits and order</h3><p>The new circuits are laid out room by room, and the order of work is agreed with you so you know which areas will be without power, and when.</p></li>
              <li><h3>Run cable, set boxes</h3><p>New cable goes in through the basement, the attic and small openings, then into new boxes at outlets, switches and fixtures.</p></li>
              <li><h3>Connect, test, retire the old</h3><p>Each new circuit is landed in the panel and tested; then the old wiring it replaces is disconnected and labeled dead.</p></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- 6. COMPARISON — spot repair vs partial vs whole-house rewire -->
    <section class="section svc-compare" aria-labelledby="compare-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">How much to rewire</span>
          <h2 id="compare-title">Should you repair the bad wiring, rewire part of the house, or rewire all of it?</h2>
          <p class="answer-block">Repair one run when the damage is local and the rest of the wiring is modern and sound. Rewire part of the house when old cable is confined to certain rooms or a remodel opens the walls anyway, and rewire everything when knob-and-tube or ungrounded cable still feeds most of the home.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>General guidance. What the walk-through finds decides the scope.</caption>
            <thead>
              <tr><th scope="col">What you have</th><th scope="col">Spot repair</th><th scope="col" class="is-pick">Partial rewire</th><th scope="col">Whole-house rewire</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">One damaged run (a nail, a mouse, water)</th><td><strong>Yes.</strong> Replace that run.</td><td class="is-pick">No.</td><td>No.</td></tr>
              <tr><th scope="row">A kitchen or bathroom remodel</th><td>No.</td><td class="is-pick"><strong>Yes</strong>, while the walls are open.</td><td>If the rest of the house is knob-and-tube.</td></tr>
              <tr><th scope="row">Two-prong outlets in a few rooms</th><td>GFCI outlets as a code-allowed stopgap.</td><td class="is-pick"><strong>Yes</strong>, new grounded circuits to those rooms.</td><td>If it's every room.</td></tr>
              <tr><th scope="row">Knob-and-tube still in use</th><td>Not recommended; don't extend it.</td><td class="is-pick">For the rooms that can be reached first.</td><td><strong>Yes.</strong></td></tr>
              <tr><th scope="row">Aluminum branch circuits</th><td><strong>Yes:</strong> remake every connection with aluminum-rated connectors.</td><td class="is-pick">Where connections have already overheated.</td><td>An option if problems keep turning up.</td></tr>
            </tbody>
          </table>
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
            <h2 id="proof-title">What does Dellona Electric wiring work look like on site?</h2>
            <p class="answer-block">This photo shows a Dellona Electric electrician fitting a device into a wall box in a sunroom with new beadboard walls and a patterned tile floor. It is the last step of a wiring job: the cable is already in the wall, and the boxes get their outlets and switches once the finishes are on.</p>
            <p>Customers' reviews of Dellona Electric are on its Google Business Profile, where you can read them or add your own once your wiring work is done.</p>
            <div class="actions">
              <a class="btn btn-accent" href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?> Dellona Electric on Google</a>
              <a class="btn btn-outline-white" href="<?php echo e($reviewRequestUrl); ?>" target="_blank" rel="noopener">Leave a review</a>
            </div>
          </div>
          <figure class="svc-proof__photo reveal-right">
            <?php echo p1_picture('sunroom-device-install-v1', 'Electrician fitting a device into a wall box on new beadboard paneling in a sunroom with a patterned tile floor', ['sizes' => '(max-width: 900px) 92vw, 520px']); ?>
            <figcaption>Trim-out in a sunroom: devices going into the boxes after the beadboard is up.</figcaption>
          </figure>
        </div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
        echo p1_google_reviews($slug, ['heading' => '', 'limit' => 3]);
        ?>
      </div>
    </section>

    <!-- 7. FAQ — research-brief questions, answered without unconfirmed numbers -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do Reedsburg homeowners ask about rewiring?</h2>
          <p class="answer-block">Homeowners weighing a rewire usually ask what it costs and whether it needs a permit and inspection. Both answers depend on the size of the house, how easy the walls are to reach and where the property sits, so here is what drives each one and how to get the answer for your own home.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does it cost to rewire a house?</summary>
          <p>Rewiring cost depends on the square footage and number of stories, how much access the basement and attic give, how many circuits the new plan needs, and whether the panel has to grow along with the wiring. A partial rewire of the worst rooms costs far less than a whole house. Dellona Electric walks the house before pricing it; call <?php echo e($phone); ?> to arrange that.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Does rewiring need a permit and inspection in Reedsburg?</summary>
          <p>Expect it to. For homes inside the city, the City of Reedsburg Building Inspection Department handles permits and names electrical alterations among the work that may need an application, and rewiring is a substantial alteration. Homes in the surrounding towns are covered by their own inspector. Raise it when you call, and the permit question gets settled before any cable is pulled.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What other work pairs well with <span class="text-accent">rewiring</span> an older home?</h2>
        <p class="hero-answer">New circuits need somewhere to land, so a rewire often goes hand in hand with a panel upgrade. Fresh outlets and switches finish each room, and a whole-home electrical inspection is a sensible first step when you're not sure how much of the old wiring is still in service. All three have their own pages below.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <?php echo p1_service_cards(['panel-upgrades', 'outlet-switch-repair', 'electrical-inspections']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Wiring estimate</span>
        <h2 id="cta-title">Ready to find out what's behind your walls?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with the age of the house and what you've noticed: two-prong outlets, fabric-covered cable or breakers that trip. Dellona Electric will call you back to plan a walk-through.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
