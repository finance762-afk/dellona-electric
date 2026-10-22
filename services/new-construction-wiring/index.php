<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/new-construction-wiring/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php, the client's new-build photos on
 * this page (described only by what is visible), general NEC requirements, and
 * the public sources below. Prices, schedules, builders worked with, permit
 * handling and the owner's process are unconfirmed and stay out of the copy
 * (content-confirmations.json).
 * Sources:
 *   City of Reedsburg Building Inspection (permits; Reedsburg Utility Commission
 *     applications for new developments, 608-768-1000) — https://www.reedsburgwi.gov/buildingsafety
 *   Wisconsin adopts the 2023 NEC (DSPS, signed Sept 1 2026) —
 *     https://www.ecmweb.com/national-electrical-code/article/55403844/wisconsin-adopts-2023-national-electrical-code
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'new-construction-wiring';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'New Construction Wiring Reedsburg WI | Dellona Electric';
$pageDescription = 'New construction wiring for homes, additions, garages and outbuildings in Reedsburg, WI, from rough-in to final. Call Dellona Electric at (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'garage-exterior-lighting-night-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Need a new build wired?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'New construction electrical wiring',
    'description' => 'Electrical wiring for new homes, additions, garages and outbuildings in Reedsburg, WI and the surrounding Sauk County area, from temporary power and rough-in through trim-out and final.',
]);

$phoneHref = 'tel:' . $phoneRaw;

/* Recent-work strip: three new-build photos (first is the tall tile). Captions describe only what is visible. */
$nbGallery = [
    ['img' => 'new-home-exterior-lighting-v1', 'alt' => 'New home at dusk with recessed soffit lights, a porch light and stone veneer beside a fresh concrete driveway',
     'cap' => 'Soffit and porch lighting switched on at a new home, before the yard was seeded'],
    ['img' => 'hero-kitchen-lighting-v1', 'alt' => 'New kitchen with recessed lights in a vaulted ceiling and three glass pendants over a white island',
     'cap' => 'Recessed lights in a vaulted ceiling and three pendants over the island'],
    ['img' => 'truck-trailer-job-site-v1', 'alt' => 'Black pickup and an enclosed trailer lettered Dellona Electric parked on a sandy new-build lot',
     'cap' => 'The Dellona Electric truck and trailer on a new-build lot'],
];
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/new-construction-wiring/ — page composition: six-phase build rail, room-by-room code table, gallery band ==== */

/* Signature: horizontal phase rail from temporary power to final, with a wire running through it */
.pg-newbuild .phase-rail { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: var(--space-4); position: relative; counter-reset: phase; }
.pg-newbuild .phase-rail::before {
  content: ""; position: absolute; left: var(--space-4); right: var(--space-4); top: calc(var(--space-5) - 1px); height: 2px;
  background: linear-gradient(90deg, var(--color-accent), var(--color-accent-dark));
}
.pg-newbuild .phase-rail li { counter-increment: phase; position: relative; display: grid; gap: var(--space-2); align-content: start; padding-top: var(--space-12); }
.pg-newbuild .phase-rail li::before {
  content: counter(phase); position: absolute; top: 0; left: 0; width: var(--space-10); height: var(--space-10); border-radius: var(--radius-full);
  display: grid; place-items: center; font-family: var(--font-accent); font-size: var(--font-size-lg);
  background: var(--color-surface); color: var(--color-accent-dark); border: 2px solid var(--color-accent); box-shadow: var(--shadow-sm);
}
.pg-newbuild .phase-rail li.is-inspect::before { background: var(--color-dark); color: var(--color-accent-bright); border-color: var(--color-dark); }
.pg-newbuild .phase-rail h3 { font-size: var(--font-size-base); }
.pg-newbuild .phase-rail p { margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-newbuild .phase-rail .phase-tag { font-family: var(--font-accent); font-size: var(--font-size-xs); letter-spacing: .12em; text-transform: uppercase; color: var(--color-muted); }
.pg-newbuild .svc-process { background: var(--color-surface); }
.pg-newbuild .svc-process .svc-head { max-width: 52rem; }
@media (max-width: 1000px) {
  .pg-newbuild .phase-rail { grid-template-columns: 1fr; gap: var(--space-6); padding-left: var(--space-12); }
  .pg-newbuild .phase-rail::before { left: calc(var(--space-5) - 1px); right: auto; top: var(--space-2); bottom: var(--space-2); width: 2px; height: auto; background: linear-gradient(180deg, var(--color-accent), var(--color-accent-dark)); }
  .pg-newbuild .phase-rail li { padding-top: 0; }
  .pg-newbuild .phase-rail li::before { left: calc(-1 * var(--space-12)); }
}

/* Bento: "hard to add later" — large card spans the top, three below */
.pg-newbuild .svc-signs .bento-grid { grid-template-columns: repeat(6, 1fr); }
.pg-newbuild .svc-signs .bento-large { grid-column: span 6; grid-row: auto; }
.pg-newbuild .svc-signs .bento-small { grid-column: span 2; }
.pg-newbuild .svc-sign.bento-large { background: linear-gradient(135deg, var(--color-card-tint-3), var(--color-surface)); }
@media (max-width: 800px) { .pg-newbuild .svc-signs .bento-small { grid-column: span 6; } }

/* Code table: room names in the accent face */
.pg-newbuild .svc-table tbody th { font-family: var(--font-accent); font-size: var(--font-size-lg); letter-spacing: .03em; text-transform: uppercase; }

/* Gallery band header sits over the three-photo grid */
.pg-newbuild .nb-gallery-head { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: var(--space-8); align-items: end; margin-bottom: var(--space-8); }
.pg-newbuild .nb-gallery-head .answer-block { margin: 0; }
@media (min-width: 701px) {
  .pg-newbuild .sp-gallery-grid { min-height: 0; grid-template-rows: repeat(2, clamp(220px, 22vw, 300px)); }
  .pg-newbuild .sp-gallery-item { aspect-ratio: auto; }
}
.pg-newbuild .sp-gallery-item img { object-position: 50% 40%; }
.pg-newbuild .nb-gallery-foot { margin-top: var(--space-6); display: flex; flex-wrap: wrap; gap: var(--space-3); align-items: center; }
.pg-newbuild .nb-gallery-foot p { margin: 0; flex: 1 1 22rem; font-size: var(--font-size-sm); }
@media (max-width: 900px) { .pg-newbuild .nb-gallery-head { grid-template-columns: 1fr; } }

/* Expert photo is landscape on this page */
.pg-newbuild .svc-expert__figure .img-framed { aspect-ratio: 4 / 3; }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-newbuild">

  <!-- 1. HERO — layered dark band, new garage lit at night, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Newly built garage at night with exterior wall lights and soffit lights on and both garage doors open', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">New builds · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="svc-title">New construction electrical wiring in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric wires new homes, additions, garages and outbuildings in Reedsburg and the surrounding Sauk County area, from temporary power and rough-in through trim-out and final. The best time to call is before framing is finished, while every outlet, switch and light can still go exactly where you want it.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
            <li><?php echo icon('hard-hat', 16); ?> Rough-in to final</li>
            <li><?php echo icon('home', 16); ?> Homes &amp; garages</li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- 2. PROBLEM STATEMENT — what is hard to add once walls are closed -->
    <section class="section svc-signs" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-left">
            <span class="eyebrow">Plan it now</span>
            <h2 id="signs-title">What wiring is hardest to add after the drywall goes up?</h2>
            <p class="answer-block">Long circuit runs and ceiling lighting are the hardest wiring to add after drywall. That means an EV charger circuit in the garage, a generator inlet, outlets on an island or exterior wall, and recessed lights. Each is a short run of cable at rough-in and a patch-and-paint job once the walls are finished.</p>
            <p class="pull-quote">At rough-in, an extra outlet is a box and a few feet of cable. After drywall, it is a hole in a finished wall.</p>
          </div>
          <div class="bento-grid">
            <div class="bento-large svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('battery-charging', 20); ?></span>
              <h3>A circuit or conduit for an EV charger</h3>
              <p>Even if there is no electric vehicle in the plan yet, a 240-volt circuit or an empty conduit from the panel to the garage wall costs little while the framing is open. Later it can mean a long run through finished space. The <a class="svc-inline-link" href="/services/ev-charger-installation/">EV charger installation page</a> covers how chargers are sized and wired.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('power', 20); ?></span>
              <h3>Generator hookup</h3>
              <p>A transfer switch location and an outdoor inlet are simple to plan beside the panel at rough-in.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('lightbulb', 20); ?></span>
              <h3>Recessed and soffit lights</h3>
              <p>Can lights and soffit lights are laid out on open joists, not fished through a finished ceiling.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('plug', 20); ?></span>
              <h3>Garage and outdoor outlets</h3>
              <p>Workbench circuits, a freezer outlet and outlets on every exterior wall belong on the first plan.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. EXPERT POSITIONING — 60/40 split, code stat, evidence from the client's own new builds -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-left">
            <div class="img-framed">
              <?php echo p1_picture('garage-exterior-lighting-night-v1', 'Finished new garage interior with recessed ceiling lights, seen through two open garage doors at night', ['sizes' => '(max-width: 900px) 90vw, 440px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>6 ft</b><span>The farthest any point along a living-area wall may be from a receptacle under the National Electrical Code.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-right">
            <span class="eyebrow">Who does the work</span>
            <h2 id="expert-title">Who wires new homes and additions for Dellona Electric?</h2>
            <p class="answer-block">New construction wiring is one of the services of Dellona Electric, the Reedsburg company Edward Giannoni owns, in business since 2018. The photos on this page come from the company's own new builds: a finished garage, a new kitchen, a new home's exterior lighting and the company trailer on a sandy lot.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('hard-hat', 22); ?><b>On site from rough-in to final</b><span>The truck and enclosed trailer in the photos below are parked on a new-build lot with the yard still bare sand. That is where the wiring for a new house starts, long before the driveway goes in.</span></li>
              <li><?php echo icon('lightbulb', 22); ?><b>Lighting planned with the wiring</b><span>The garage at the top of the page has up-and-down wall lights beside each door, soffit lights along the gable and recessed lights inside. Fixture choices like these are covered in more depth on the <a href="/services/lighting-installation/">lighting installation page</a>.</span></li>
              <li><?php echo icon('zap', 22); ?><b>Service, panel and what comes later</b><span>Dellona Electric also installs panels, EV chargers and standby generators, so a new house can be wired with room for them. New construction is one of <?php echo count($services); ?> services on the <a href="/services/">Dellona Electric services page</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. SERVICE BREAKDOWN — what's included + six-phase build rail (signature) -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="included-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">What's included</span>
          <h2 id="included-title">What's included in new construction wiring from Dellona Electric?</h2>
          <p class="answer-block">New construction wiring covers everything from temporary power on the empty lot to the last cover plate. That includes the service and panel, every branch circuit, boxes for outlets, switches and fixtures, smoke and carbon monoxide alarm wiring, and the trim-out that makes it all work once the walls are painted.</p>
        </div>
        <ul class="svc-checklist reveal-up">
          <li><?php echo icon('check', 18); ?><span><strong>Service entrance and main panel</strong> sized for the house you are building, including any planned shop, charger or heat pump.</span></li>
          <li><?php echo icon('check', 18); ?><span><strong>A layout walk-through</strong> of outlets, switches and fixtures, room by room, before cable is pulled.</span></li>
          <li><?php echo icon('check', 18); ?><span><strong>Branch circuits</strong> with the AFCI and GFCI protection, tamper-resistant receptacles and dedicated appliance circuits the code calls for.</span></li>
          <li><?php echo icon('check', 18); ?><span><strong>Hardwired, interconnected alarms.</strong> New homes get smoke alarms wired together with battery backup; the <a class="svc-inline-link" href="/services/smoke-detector-installation/">smoke and CO alarm page</a> explains placement.</span></li>
          <li><?php echo icon('check', 18); ?><span><strong>Trim-out:</strong> devices, cover plates, fixtures and fans set once paint and flooring are done.</span></li>
        </ul>
      </div>
    </section>

    <section class="section svc-process" aria-labelledby="phases-title">
      <div class="container-wide">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Build phases</span>
          <h2 id="phases-title">How does electrical work fit into a new build, phase by phase?</h2>
          <p class="answer-block">Electrical work on a new build happens in six phases spread across the whole project, from temporary power for the framers to a final inspection before move-in. Two of those phases are inspections, and the walls cannot be insulated or covered until the rough wiring has been looked at.</p>
        </div>
        <ol class="phase-rail reveal-up">
          <li><span class="phase-tag">Lot</span><h3>Temporary power</h3><p>A temporary service on a pole or pedestal runs saws and tools. Inside the city, new developments may need a Reedsburg Utility Commission application (608-768-1000).</p></li>
          <li><span class="phase-tag">Framing</span><h3>Rough-in</h3><p>Boxes are set, cable is pulled and stapled, and the panel and service go in.</p></li>
          <li class="is-inspect"><span class="phase-tag">Inspector</span><h3>Rough inspection</h3><p>The building inspector checks the open wiring before anything is covered.</p></li>
          <li><span class="phase-tag">Walls</span><h3>Insulation and drywall</h3><p>Other trades close the walls. Box locations are marked so nothing gets buried.</p></li>
          <li><span class="phase-tag">Finish</span><h3>Trim-out</h3><p>Outlets, switches, fixtures, fans and plates go in and every circuit is landed in the panel.</p></li>
          <li class="is-inspect"><span class="phase-tag">Inspector</span><h3>Final</h3><p>Final inspection, then permanent power from the utility and a labeled panel directory.</p></li>
        </ol>
      </div>
    </section>

    <!-- 5 + 7b. PROOF / RECENT WORK — dark grain band with the 3-photo strip -->
    <section class="section svc-proof sp-gallery texture-grain slant-top" aria-labelledby="proof-title">
      <span class="grain-layer" aria-hidden="true"></span>
      <div class="container-wide">
        <div class="nb-gallery-head">
          <div>
            <span class="eyebrow">Recent Work</span>
            <h2 id="proof-title">What new builds has Dellona Electric wired recently?</h2>
          </div>
          <p class="answer-block">Recent Dellona Electric new builds include soffit and porch lighting on a new home and recessed lights with island pendants in a new kitchen. The third photo is the company truck and trailer on a new-build lot, with the yard still bare sand.</p>
        </div>
        <div class="sp-gallery-grid" data-p1-dynamic>
          <?php foreach ($nbGallery as $nbI => $nbItem): ?>
          <figure class="sp-gallery-item reveal-scale reveal-delay-<?php echo $nbI + 1; ?>">
            <?php echo p1_picture($nbItem['img'], $nbItem['alt'], ['sizes' => $nbI === 0 ? '(max-width: 700px) 92vw, 680px' : '(max-width: 700px) 92vw, 520px']); ?>
            <figcaption><?php echo e($nbItem['cap']); ?></figcaption>
          </figure>
          <?php endforeach; ?>
        </div>
        <div class="nb-gallery-foot">
          <p>Reviews from Dellona Electric customers are on the company's Google Business Profile.</p>
          <a class="btn btn-accent" href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?> See Dellona Electric on Google</a>
          <a class="btn btn-outline-white" href="<?php echo e($reviewRequestUrl); ?>" target="_blank" rel="noopener">Leave a review</a>
        </div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
        echo p1_google_reviews($slug, ['heading' => '', 'limit' => 3]);
        ?>
      </div>
    </section>

    <!-- 6. COMPARISON — room-by-room code points, as a real table -->
    <section class="section svc-compare" aria-labelledby="compare-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Room by room</span>
          <h2 id="compare-title">Which code rules shape the wiring plan in each part of a new house?</h2>
          <p class="answer-block">Kitchens, garages, basements and exterior walls each carry their own wiring rules, mostly about GFCI protection and where outlets have to be. Knowing them before layout saves change orders. Wisconsin adopted the 2023 National Electrical Code in September 2026, so these are the rules new builds are planned around.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>Summary of common National Electrical Code points. The inspector for your property has the final word on how they apply.</caption>
            <thead>
              <tr><th scope="col">Space</th><th scope="col">What the plan should cover</th><th scope="col">Code points to know</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">Kitchen</th><td>Counter outlets, island power, range, dishwasher, disposal, microwave and fridge circuits.</td><td>At least two 20-amp small-appliance circuits for the counters; GFCI protection on counter outlets.</td></tr>
              <tr><th scope="row">Garage</th><td>Door openers, workbench, freezer, ceiling lights and a future charger.</td><td>Garage receptacles are GFCI-protected and need at least one 20-amp circuit of their own.</td></tr>
              <tr><th scope="row">Exterior</th><td>Porch, soffit and wall lights, outdoor outlets, holiday lighting.</td><td>Outlets at the front and back of the house, weather-resistant with in-use covers, GFCI-protected.</td></tr>
              <tr><th scope="row">Basement</th><td>Lighting, sump pump, future finished rooms.</td><td>GFCI protection on basement receptacles, finished or not.</td></tr>
              <tr><th scope="row">Bedrooms and living areas</th><td>Outlet spacing, switched lights, fan boxes, TV walls.</td><td>AFCI protection, tamper-resistant receptacles and the 6-foot outlet spacing rule.</td></tr>
              <tr><th scope="row">Detached garage or outbuilding</th><td>A feeder from the house, lights and outlets inside.</td><td>Its own disconnecting means at the building and a grounding electrode.</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- 7. FAQ — research-brief questions made specific to new builds -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do people building in the Reedsburg area ask about new construction wiring?</h2>
          <p class="answer-block">People planning a new build around Reedsburg mostly ask what the wiring will cost and who handles permits and inspections. Both depend on the plans and on where the lot sits, inside the city or in a surrounding town, so the answers below explain what decides each one.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does it cost to wire a new house?</summary>
          <p>The cost of new construction wiring depends on the size of the house, the service size, how many circuits and fixtures the plan calls for, and extras such as a detached garage, an EV circuit or a generator inlet. Dellona Electric prices the work from your plans and a layout conversation. Call <?php echo e($phone); ?> with your plans in hand to start that.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Does a new home in Reedsburg need an electrical permit and inspection?</summary>
          <p>Yes. Inside the city, the City of Reedsburg Building Inspection Department issues building permits for new construction, and new developments may also need a Reedsburg Utility Commission application for power. Lots in the surrounding towns go through the town's inspector under Wisconsin's Uniform Dwelling Code. Ask when you call which applies to your lot.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What else gets wired while a <span class="text-accent">new house</span> is still open?</h2>
        <p class="hero-answer">A new house is the cheapest time to add the extras that are awkward to retrofit. Lighting layouts, a charger circuit in the garage and the smoke and carbon monoxide alarms a new home has to have are all easier with the framing exposed, and each has its own page below with the details.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <?php echo p1_service_cards(['lighting-installation', 'ev-charger-installation', 'smoke-detector-installation']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">New build estimate</span>
        <h2 id="cta-title">Ready to plan the wiring for your new build?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with where the lot is and where the build stands. Plans or a floor sketch help. Dellona Electric will call you back to go over the layout.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
