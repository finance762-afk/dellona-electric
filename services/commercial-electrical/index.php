<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/commercial-electrical/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php ("commercial and light industrial
 * buildings"), the client's restaurant-bar photo (described only by what is
 * visible — the business and town are not named), general NEC / NFPA 101 points,
 * and the public sources below. Clients, prices, after-hours scheduling, permit
 * handling and any industrial or three-phase capability beyond the config wording
 * are unconfirmed and stay out of the copy (content-confirmations.json).
 * Sources:
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 *   Wisconsin adopts the 2023 NEC (DSPS, signed Sept 1 2026) —
 *     https://www.ecmweb.com/national-electrical-code/article/55403844/wisconsin-adopts-2023-national-electrical-code
 *   DSPS commercial electrical permitting / delegated municipalities —
 *     https://dsps.wi.gov/Documents/Programs/DelegatedAgent/Letters/ElectricalCedarburgCity.pdf (example letter; Reedsburg's status not claimed)
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'commercial-electrical';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'Commercial Electrical Reedsburg WI | Dellona Electric';
$pageDescription = 'Commercial electrical repair, lighting and upgrades for restaurants, shops, offices and light industrial space in Reedsburg, WI. Call Dellona Electric at (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'commercial-bar-lighting-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Need work done at your business?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'Commercial electrical repair',
    'description' => 'Electrical repair, lighting, new circuits and upgrades for restaurants, shops, offices and light industrial buildings in Reedsburg, WI and the surrounding Sauk County area.',
]);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/commercial-electrical/ — page composition: space-type strip, exit-light test card, home-vs-commercial table ==== */

/* Signature: the four kinds of space, as a ruled strip with tinted icon tiles */
.pg-commercial .space-strip { list-style: none; margin: var(--space-10) 0 0; padding: 0; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); border-top: 2px solid var(--color-ink); }
.pg-commercial .space-strip li { display: grid; gap: var(--space-2); align-content: start; padding: var(--space-6) var(--space-5) var(--space-4) 0; }
.pg-commercial .space-strip li + li { padding-left: var(--space-5); border-left: 1px solid var(--color-line); }
.pg-commercial .space-strip .space-icon { width: var(--space-10); height: var(--space-10); border-radius: var(--radius); display: grid; place-items: center; }
.pg-commercial .space-strip li:nth-child(1) .space-icon { background: var(--color-card-tint-3); color: var(--color-accent-dark); }
.pg-commercial .space-strip li:nth-child(2) .space-icon { background: var(--color-card-tint-1); color: var(--color-primary); }
.pg-commercial .space-strip li:nth-child(3) .space-icon { background: var(--color-card-tint-2); color: var(--color-secondary); }
.pg-commercial .space-strip li:nth-child(4) .space-icon { background: var(--color-paper-2); color: var(--color-ink); }
.pg-commercial .space-strip h3 { font-size: var(--font-size-lg); }
.pg-commercial .space-strip p { margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
@media (max-width: 900px) {
  .pg-commercial .space-strip { grid-template-columns: 1fr 1fr; }
  .pg-commercial .space-strip li:nth-child(3) { padding-left: 0; border-left: 0; }
  .pg-commercial .space-strip li:nth-child(n+3) { border-top: 1px solid var(--color-line); }
}
@media (max-width: 560px) {
  .pg-commercial .space-strip { grid-template-columns: 1fr; }
  .pg-commercial .space-strip li + li { padding-left: 0; border-left: 0; border-top: 1px solid var(--color-line); }
}

/* Bento: two equal tall cards then a full-width test card styled like an exit sign panel */
.pg-commercial .svc-signs .bento-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
.pg-commercial .svc-signs .bento-grid > * { grid-column: auto; grid-row: auto; }
.pg-commercial .svc-signs .svc-sign--test { grid-column: 1 / -1; background: var(--color-dark); border-color: var(--color-dark); }
.pg-commercial .svc-sign--test h3 { color: var(--color-white); }
.pg-commercial .svc-sign--test p { color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.pg-commercial .svc-sign--test .svc-sign__icon { background: color-mix(in srgb, var(--color-success) 30%, transparent); color: var(--color-white); }
.pg-commercial .svc-sign--test .test-pair { display: flex; flex-wrap: wrap; gap: var(--space-3); margin-top: var(--space-2); }
.pg-commercial .svc-sign--test .test-pair span { font-family: var(--font-accent); font-size: var(--font-size-sm); letter-spacing: .1em; text-transform: uppercase; border: 1px solid color-mix(in srgb, var(--color-white) 30%, transparent); border-radius: var(--radius-full); padding: var(--space-1) var(--space-3); color: var(--color-accent-bright); }
@media (max-width: 700px) { .pg-commercial .svc-signs .bento-grid { grid-template-columns: 1fr; } }

/* Process runs in the right column on this page; the included list sits left */
.pg-commercial .svc-breakdown__grid { grid-template-columns: minmax(0, .95fr) minmax(0, 1.05fr); }

/* Proof: portrait restaurant photo, capped */
.pg-commercial .svc-proof__photo { aspect-ratio: 3 / 4; max-height: 640px; }
.pg-commercial .svc-expert__figure .img-framed { aspect-ratio: 1 / 1; }
.pg-commercial .svc-table thead th:first-child { width: 24%; }
.pg-commercial .svc-sign.card-tint-1 { background: var(--color-card-tint-1); }
.pg-commercial .svc-sign.card-tint-2 { background: var(--color-card-tint-2); }
.pg-commercial .svc-sign.card-tint-3 { background: var(--color-card-tint-3); }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-commercial">

  <!-- 1. HERO — layered dark band, restaurant bar photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Restaurant bar and dining tables under filament pendant lights, ceiling fixtures and a skylight', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Commercial · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="svc-title">Commercial electrical work in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric handles electrical repair, lighting and upgrades for restaurants, shops, offices and light industrial buildings in Reedsburg and the surrounding Sauk County area. That covers dining and retail lighting, circuits for new equipment, exit and emergency lights, and tracking down faults that shut part of a business down.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
            <li><?php echo icon('building-2', 16); ?> Shops &amp; restaurants</li>
            <li><?php echo icon('lightbulb', 16); ?> Lighting &amp; circuits</li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- 2. PROBLEM STATEMENT — the electrical problems that slow a business down -->
    <section class="section svc-signs" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-left">
            <span class="eyebrow">When to call</span>
            <h2 id="signs-title">Which electrical problems cost a business the most?</h2>
            <p class="answer-block">The costliest electrical problems are the ones that stop part of a business from operating. Think of a dark dining room or sales floor, a breaker that trips whenever a new cooler or oven runs, or exit lights that fail their test. Each is usually one circuit, connection or fixture.</p>
            <p class="pull-quote">In a home, a dead circuit is an inconvenience. In a restaurant on a Friday night, it is lost tables.</p>
          </div>
          <div class="bento-grid">
            <div class="svc-sign card-tint-1 bento-item reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('lightbulb', 20); ?></span>
              <h3>Lights out over customers</h3>
              <p>A row of pendants or ceiling fixtures that goes dark is usually one circuit, one switch or one failed fixture driver. Finding which, quickly, keeps the room open.</p>
            </div>
            <div class="svc-sign card-tint-2 bento-item reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('zap', 20); ?></span>
              <h3>Trips when equipment starts</h3>
              <p>New coolers, ovens, compressors and point-of-sale stations get added over the years, often onto circuits that were never sized for them. A dedicated circuit is the usual fix.</p>
            </div>
            <div class="svc-sign svc-sign--test bento-item reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('alert-triangle', 20); ?></span>
              <h3>Exit and emergency lights that fail their test</h3>
              <p>The Life Safety Code (NFPA 101) calls for battery-powered emergency lighting to be tested monthly and run for a full 90 minutes once a year. Units with dead batteries or burned-out lamps get repaired or replaced.</p>
              <div class="test-pair"><span>Monthly · 30 seconds</span><span>Yearly · 90 minutes</span></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. EXPERT POSITIONING — 60/40 split, life-safety stat, evidence from the client's own work -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-left">
            <div class="img-framed">
              <?php echo p1_picture('truck-trailer-job-site-v1', 'Black pickup and an enclosed trailer lettered Dellona Electric with its phone number, parked on a job site', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>90 min</b><span>How long battery emergency lights have to stay lit in their annual test under NFPA 101.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-right">
            <span class="eyebrow">Who does the work</span>
            <h2 id="expert-title">Who does commercial electrical work at Dellona Electric?</h2>
            <p class="answer-block">Commercial work at Dellona Electric is done by the same Reedsburg company that wires homes and new builds, owned by Edward Giannoni and in business since 2018. The restaurant bar shown at the top of this page and again below comes from the company's own job photos.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('lightbulb', 22); ?><b>Lighting that sets the room</b><span>The restaurant photo shows pendants over the bar, ceiling fixtures along the beams and an exit sign by the entrance: decorative, general and life-safety lighting in one space. The <a href="/services/lighting-installation/">lighting installation page</a> covers fixture choices in more detail.</span></li>
              <li><?php echo icon('zap', 22); ?><b>Capacity for new equipment</b><span>When a new line of equipment needs more than the existing service can give, the answer may be a new sub-panel or a larger service. See <a href="/services/panel-upgrades/">panel repair and upgrades</a> for how that is sized.</span></li>
              <li><?php echo icon('map-pin', 22); ?><b>One local number</b><span>Dellona Electric is based at <?php echo e($address['street']); ?> in Reedsburg. Commercial work is one of <?php echo count($services); ?> services on the <a href="/services/">Dellona Electric services page</a>, and the number to call is <?php echo e($phone); ?>.</span></li>
            </ul>
          </div>
        </div>
        <ul class="space-strip reveal-up" aria-label="Kinds of commercial space">
          <li><span class="space-icon"><?php echo icon('flame', 20); ?></span><h3>Restaurants and bars</h3><p>Dining and bar lighting, kitchen equipment circuits, exit and emergency lights.</p></li>
          <li><span class="space-icon"><?php echo icon('building-2', 20); ?></span><h3>Shops and retail</h3><p>Sales-floor and display lighting, sign circuits, outlets for registers and coolers.</p></li>
          <li><span class="space-icon"><?php echo icon('clipboard-list', 20); ?></span><h3>Offices</h3><p>Lighting upgrades, added outlets for workstations, dedicated circuits for equipment.</p></li>
          <li><span class="space-icon"><?php echo icon('hammer', 20); ?></span><h3>Light industrial</h3><p>Repairs, lighting for work areas and circuits for new machines in shop buildings.</p></li>
        </ul>
      </div>
    </section>

    <!-- 4. SERVICE BREAKDOWN — what's included + sticky-scroll process -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="included-title">
      <div class="container-wide">
        <div class="svc-breakdown__grid">
          <div class="svc-breakdown__sticky svc-body reveal-left">
            <span class="eyebrow">What's included</span>
            <h2 id="included-title">What does commercial electrical service from Dellona Electric include?</h2>
            <p class="answer-block">Commercial electrical service from Dellona Electric covers repairs, lighting, new circuits and service upgrades in buildings that are open to customers or used for work. Every job starts from what the space has to keep doing while the work happens, and ends with tested circuits and an updated panel directory.</p>
            <ul class="svc-checklist">
              <li><?php echo icon('check', 18); ?><span><strong>Troubleshooting and repair</strong> of dead circuits, tripping breakers and failed fixtures. Single-circuit faults are covered on the <a class="svc-inline-link" href="/services/electrical-repair/">electrical repair and troubleshooting page</a>.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Lighting</strong> for dining rooms, bars, sales floors, offices and work areas, including pendants and LED retrofits.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Dedicated circuits</strong> for coolers, ovens, compressors, signs and other equipment.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Exit and emergency lighting</strong> repaired, replaced or added.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Panels, sub-panels and service upgrades</strong> when the building needs more capacity.</span></li>
            </ul>
          </div>
          <div class="reveal-right">
            <h3 class="sr-only">How a commercial job goes, step by step</h3>
            <ol class="svc-steps">
              <li><h3>Walk the space</h3><p>See the panel, the problem and the equipment involved, and hear when the business is open and busiest.</p></li>
              <li><h3>Settle scope and paperwork</h3><p>Commercial electrical plans and inspections in Wisconsin run through the Department of Safety and Professional Services or a municipality it has delegated to. Whether a job needs plans or a permit is sorted out at this stage.</p></li>
              <li><h3>Plan the shutoffs</h3><p>Any work that needs a circuit or the whole building powered down is scheduled with you, so you know in advance which areas will be dark and when.</p></li>
              <li><h3>Test and hand back</h3><p>Circuits are tested under load, emergency and exit lights are checked on battery, and the panel directory is updated to match what is now in the building.</p></li>
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
            <?php echo p1_picture('commercial-bar-lighting-v1', 'Curved restaurant bar with filament pendants, ceiling fixtures between dark beams, a skylight and an exit sign by the entrance', ['sizes' => '(max-width: 900px) 92vw, 520px']); ?>
            <figcaption>Restaurant bar lighting: filament pendants over the bar, ceiling fixtures along the beams and a lit exit sign.</figcaption>
          </figure>
          <div class="svc-proof__copy reveal-right">
            <span class="eyebrow">From the job site</span>
            <h2 id="proof-title">What does a finished commercial job by Dellona Electric look like?</h2>
            <p class="answer-block">This restaurant bar comes from Dellona Electric's own job photos, and it shows how many kinds of lighting one commercial room carries. Filament pendants hang over the curved bar, ceiling fixtures run between dark beams under tin-style ceiling tiles, a skylight adds daylight, and an exit sign is lit by the entrance.</p>
            <p>Reviews from Dellona Electric customers, commercial and residential, are on the company's Google Business Profile.</p>
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

    <!-- 6. COMPARISON — home vs commercial electrical work, as a real table -->
    <section class="section svc-compare" aria-labelledby="compare-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Home vs commercial</span>
          <h2 id="compare-title">How is commercial electrical work different from wiring a house?</h2>
          <p class="answer-block">Commercial electrical work differs from house wiring in who reviews it, how cable is run, and what has to keep working during the job. Businesses also carry life-safety lighting that homes do not, and their equipment loads change far more often than a household's, which is why circuits and panels get outgrown.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>General differences. What applies to a given building depends on its use, its size and the code official reviewing the work.</caption>
            <thead>
              <tr><th scope="col">Topic</th><th scope="col">A house</th><th scope="col" class="is-pick">A commercial space</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">Who reviews the work</th><td>The local building inspector under Wisconsin's Uniform Dwelling Code.</td><td class="is-pick">The state Department of Safety and Professional Services or a municipality it has delegated to.</td></tr>
              <tr><th scope="row">How cable is run</th><td>Mostly plastic-sheathed cable inside wood framing.</td><td class="is-pick">Often conduit or metal-clad cable, depending on the building's construction.</td></tr>
              <tr><th scope="row">Life-safety lighting</th><td>Not required.</td><td class="is-pick">Exit signs and battery emergency lights where exits must be marked, with regular testing.</td></tr>
              <tr><th scope="row">Equipment</th><td>Household appliances on standard circuits.</td><td class="is-pick">Coolers, ovens, compressors and signs, often on dedicated circuits.</td></tr>
              <tr><th scope="row">When the work happens</th><td>Whenever the homeowner is available.</td><td class="is-pick">Usually planned around open hours, so customers are not left in the dark.</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- 7. FAQ — research-brief questions made specific to commercial work -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do Reedsburg business owners ask about commercial electrical work?</h2>
          <p class="answer-block">Business owners in the Reedsburg area usually want to know two things before calling: how commercial electrical work is priced and whether it needs a permit or plan review. Both depend on the building and the scope of the job, and the answers below explain what each one turns on.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does commercial electrical work cost?</summary>
          <p>The cost of commercial electrical work depends on the scope, how much of it has to happen outside open hours, the wiring method the building needs, and whether plans or a permit are involved. Dellona Electric walks the space and talks through the job before pricing it. Call <?php echo e($phone); ?> with a description of the problem or project to start.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Does commercial electrical work in Reedsburg need a permit?</summary>
          <p>Often, yes. In Wisconsin, commercial electrical plans and inspections run through the Department of Safety and Professional Services or a municipality it has delegated to, and inside the city the City of Reedsburg Building Inspection Department issues building permits. Ask when you call and you will know what your commercial job needs before work starts.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What other services do <span class="text-accent">businesses</span> call Dellona Electric for?</h2>
        <p class="hero-answer">Commercial jobs often lead into one of three related services. Those are lighting for a dining room, sales floor or office, a panel or service upgrade when equipment outgrows the building, and troubleshooting a circuit that keeps failing. Each has its own page below with more on how that work is done.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <?php echo p1_service_cards(['lighting-installation', 'panel-upgrades', 'electrical-repair']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Commercial estimate</span>
        <h2 id="cta-title">Need electrical work at your business?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with the kind of business, what is going on and when you are open. Dellona Electric will call you back to set up a walk-through.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
