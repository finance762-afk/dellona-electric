<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/smoke-detector-installation/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php, the client photos (finished living
 * room with a ceiling smoke alarm; new home exterior; crew with the company truck),
 * Wis. Stat. § 101.647 (CO alarms) and NFPA 72 placement guidance (smoke alarm in
 * each bedroom, outside each sleeping area, every level; replace at 10 years; keep
 * away from cooking appliances). Prices, alarm brands and permit handling are
 * unconfirmed (content-confirmations.json).
 * Sources:
 *   Wis. Stat. § 101.647 carbon monoxide detectors — https://law.justia.com/codes/wisconsin/chapter-101/section-101-647
 *     (basement + each floor level except attic, garage, storage; not required with no attached garage,
 *      fireplace or fuel-burning appliance; hardwired units need battery backup; may be combined with a smoke detector)
 *   NFPA 72 smoke alarm guidance — https://www.nfpa.org/education-and-research/home-fire-safety/smoke-alarms
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'smoke-detector-installation';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'Smoke Detector Installation Reedsburg WI | Dellona Electric';
$pageDescription = 'Hardwired, interconnected smoke and carbon monoxide alarms installed and replaced in Reedsburg, WI by Dellona Electric. Call (608) 477-8453 to plan yours.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'new-home-exterior-lighting-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Need alarms on every floor?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'Smoke detector installation',
    'description' => 'Installation and replacement of hardwired, interconnected smoke alarms and carbon monoxide alarms with battery backup, in Reedsburg, WI and the surrounding Sauk County area.',
]);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/smoke-detector-installation/ — page composition: floor-by-floor placement plan, alarm-type table ==== */
.pg-smoke .svc-sign.bento-large { background: var(--color-card-tint-3); }
.pg-smoke .svc-sign.bento-large .svc-sign__icon { background: var(--color-surface); }

/* Signature: a house in section, top floor down, with the alarms each level needs */
.pg-smoke .floor-plan { list-style: none; margin: var(--space-6) 0 0; padding: 0; display: grid; gap: var(--space-2); }
.pg-smoke .floor-plan li {
  display: grid; grid-template-columns: minmax(7rem, auto) minmax(0, 1fr); gap: var(--space-1) var(--space-4); align-items: start;
  background: var(--color-surface); border: 1px solid var(--color-line); padding: var(--space-4) var(--space-5);
}
.pg-smoke .floor-plan li:first-child { clip-path: polygon(8% 0, 92% 0, 100% 100%, 0 100%); padding-inline: var(--space-12); border-radius: var(--radius-sm); background: var(--color-card-tint-1); }
.pg-smoke .floor-plan li:last-child { border-style: dashed; background: var(--color-paper); }
.pg-smoke .floor-plan b { grid-row: span 2; font-family: var(--font-accent); font-size: var(--font-size-sm); letter-spacing: .12em; text-transform: uppercase; color: var(--color-muted); padding-top: var(--space-1); }
.pg-smoke .floor-plan span { font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-smoke .floor-plan .tag { display: inline-flex; gap: var(--space-1); flex-wrap: wrap; }
.pg-smoke .floor-plan .tag i { font-style: normal; font-size: var(--font-size-xs); font-weight: 600; border-radius: var(--radius-full); padding: 0 var(--space-2); background: var(--color-card-tint-3); color: var(--color-ink); }
.pg-smoke .floor-plan .tag i.co { background: color-mix(in srgb, var(--color-secondary) 16%, var(--color-surface)); }
@media (max-width: 560px) { .pg-smoke .floor-plan li, .pg-smoke .floor-plan li:first-child { grid-template-columns: 1fr; padding-inline: var(--space-4); clip-path: none; } .pg-smoke .floor-plan b { grid-row: auto; } }

.pg-smoke .svc-included { margin-bottom: var(--space-6); display: grid; gap: var(--space-3); }
.pg-smoke .svc-included h3 { font-size: var(--fs-h3); }
.pg-smoke .svc-expert { background: var(--color-paper); }
.pg-smoke .svc-expert__figure .img-framed { aspect-ratio: 3 / 4; }
.pg-smoke .svc-proof__photo { aspect-ratio: 4 / 3; }
.pg-smoke .svc-proof .svc-proof__grid { grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr); }
@media (max-width: 900px) { .pg-smoke .svc-proof .svc-proof__grid { grid-template-columns: 1fr; } }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-smoke">

  <!-- 1. HERO — layered dark band, client new-home photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'New home at dusk with soffit lights and porch lights switched on', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Smoke &amp; CO alarms · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="svc-title">Smoke detector installation in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric installs and replaces hardwired, interconnected smoke and carbon monoxide alarms in Reedsburg and the surrounding Sauk County area. When one alarm senses smoke or CO, every alarm in the house sounds, and each hardwired unit keeps a battery backup for when the power is out.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
            <li><?php echo icon('flame', 16); ?> Smoke + CO</li>
            <li><?php echo icon('link', 16); ?> Interconnected</li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- 2. PROBLEM STATEMENT — pull quote + signs alarms are due -->
    <section class="section svc-signs" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-left">
            <span class="eyebrow">Time to replace</span>
            <h2 id="signs-title">When should smoke and carbon monoxide alarms be replaced or upgraded?</h2>
            <p class="answer-block">Replace smoke alarms 10 years after the manufacture date printed on the back, and CO alarms when they reach the end of life their maker lists. Upgrade sooner if an alarm chirps after a fresh battery, if only the alarm nearest the problem sounds, or if a bedroom or a floor has none.</p>
            <p class="pull-quote">An alarm in the basement does little good if nobody upstairs can hear it.</p>
          </div>
          <div class="bento-grid">
            <div class="bento-large svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('clock', 20); ?></span>
              <h3>Chirping after a new battery</h3>
              <p>Many alarms chirp at the end of their service life whatever battery is in them. Turn the unit over: if the date on the back is ten years old or more, or you can't find a date at all, the alarm is due. Replacing one hardwired alarm in an interconnected set usually means matching the rest of the set so they keep talking to each other.</p>
            </div>
            <div class="bento-medium svc-sign reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('link', 20); ?></span>
              <h3>Only one alarm sounds</h3>
              <p>If you test the basement alarm and the bedroom alarms stay quiet, the set isn't interconnected. A fire on one floor may not wake anyone on another.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('flame', 20); ?></span>
              <h3>New fireplace or furnace</h3>
              <p>Adding a fuel-burning appliance, a fireplace or an attached garage brings Wisconsin's CO alarm rule into play.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('hammer', 20); ?></span>
              <h3>A finished basement or new bedroom</h3>
              <p>New sleeping rooms need alarms of their own, tied in with the rest.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. PLACEMENT + BREAKDOWN — floor-by-floor plan (sticky) + what's included + process -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="placement-title">
      <div class="container-wide">
        <div class="svc-breakdown__grid">
          <div class="svc-breakdown__sticky svc-body reveal-left">
            <span class="eyebrow">Placement</span>
            <h2 id="placement-title">Where do smoke and CO alarms go in a Wisconsin home?</h2>
            <p class="answer-block">Smoke alarms go in every bedroom, outside each sleeping area and on every level, basement included, under the NFPA 72 standard. Wisconsin law adds carbon monoxide alarms in the basement and on each floor level, except attics, garages and storage areas, in homes with a fuel-burning appliance, fireplace or attached garage.</p>
            <ol class="floor-plan" aria-label="Alarm placement by floor, top down">
              <li><b>Upper floor</b><span class="tag"><i>Smoke</i><i class="co">CO</i></span><span>A smoke alarm in each bedroom, and smoke plus CO in the hallway outside them.</span></li>
              <li><b>Main floor</b><span class="tag"><i>Smoke</i><i class="co">CO</i></span><span>Smoke and CO on the level, with the smoke alarm kept back from the range so cooking doesn't set it off.</span></li>
              <li><b>Basement</b><span class="tag"><i>Smoke</i><i class="co">CO</i></span><span>Both, typically near the stairs and the furnace and water heater area.</span></li>
              <li><b>Attached garage</b><span class="tag"><i class="co">Trigger</i></span><span>No CO alarm is required in the garage itself, but having one attached is what puts CO alarms in the house.</span></li>
            </ol>
          </div>
          <div class="reveal-right">
            <div class="svc-included svc-body">
              <h3>What the installation includes</h3>
              <ul class="svc-checklist">
                <li><?php echo icon('check', 18); ?><span><strong>A count of what you have</strong> and what each floor and bedroom still needs, with the dates on existing alarms.</span></li>
                <li><?php echo icon('check', 18); ?><span><strong>Hardwired alarms with battery backup,</strong> fed from a household circuit, so they work through an outage.</span></li>
                <li><?php echo icon('check', 18); ?><span><strong>Interconnection,</strong> by a third wire between boxes or by hardwired units that link wirelessly where the walls are closed.</span></li>
                <li><?php echo icon('check', 18); ?><span><strong>Combination smoke and CO units</strong> where they fit, which Wisconsin's CO law allows.</span></li>
              </ul>
            </div>
            <h3 class="sr-only">How a smoke and CO alarm installation goes, step by step</h3>
            <ol class="svc-steps">
              <li><h3>Walk the house</h3><p>Bedrooms, levels, the furnace, water heater, fireplace and garage. That walk sets how many smoke alarms and CO alarms the house needs and where.</p></li>
              <li><h3>Check the wiring that's already there</h3><p>Existing alarm boxes may have power and an interconnect wire, power only, or nothing at all. That decides between swapping heads, running new cable, or using wireless-interconnect hardwired units.</p></li>
              <li><h3>Install a matched set</h3><p>Interconnected alarms have to be compatible with each other, so the set is installed as one family, each on its mounting plate with its backup battery in.</p></li>
              <li><h3>Test them together</h3><p>Press test on one alarm and every alarm in the house should sound. You see how to silence a nuisance alarm and where the replacement date is written.</p></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. COMPARISON — alarm power and interconnect options, as a real table -->
    <section class="section svc-compare" aria-labelledby="compare-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Alarm types</span>
          <h2 id="compare-title">Should you choose battery-only, sealed 10-year or hardwired smoke alarms?</h2>
          <p class="answer-block">Hardwired, interconnected alarms with battery backup are the strongest choice, because every alarm sounds at once and they keep working when the power is out. Battery-only and sealed 10-year units are reasonable where running new wire isn't practical, especially models that interconnect wirelessly and still sound together.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>General guidance. Follow the maker's instructions for any alarm, and test monthly whatever the type.</caption>
            <thead>
              <tr><th scope="col">Compare</th><th scope="col">Battery-only</th><th scope="col">Sealed 10-year battery</th><th scope="col" class="is-pick">Hardwired, interconnected</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">Power</th><td>Replaceable battery</td><td>Built-in battery for the alarm's life</td><td class="is-pick">House circuit, with a backup battery</td></tr>
              <tr><th scope="row">All alarms sound together</th><td>Only wireless-interconnect models</td><td>Only wireless-interconnect models</td><td class="is-pick"><strong>Yes</strong>, by wire or a listed wireless link</td></tr>
              <tr><th scope="row">During a power outage</th><td>Works while the battery lasts</td><td>Works</td><td class="is-pick">Works on its backup battery</td></tr>
              <tr><th scope="row">Upkeep</th><td>New batteries, replace at 10 years</td><td>Replace the whole unit at end of life</td><td class="is-pick">Backup batteries as the maker says, replace at 10 years</td></tr>
              <tr><th scope="row">Who installs it</th><td>You</td><td>You</td><td class="is-pick">An electrician</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- 5. EXPERT POSITIONING — 60/40 split, 10-year stat, why the wiring matters -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-left">
            <div class="img-framed">
              <?php echo p1_picture('crew-company-truck-v1', 'Two members of the Dellona Electric crew standing beside the lettered company truck', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>10 yrs</b><span>Smoke alarms are due for replacement 10 years after the date printed on the back.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-right">
            <span class="eyebrow">Why an electrician</span>
            <h2 id="expert-title">Why have an electrician install hardwired smoke and CO alarms?</h2>
            <p class="answer-block">An electrician is needed because hardwired alarms connect to a household circuit and, to sound together, to each other through a third interconnect wire run between every box. Dellona Electric handles that wiring in finished homes, remodels and new construction, and the alarms go in as part of the same visit.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('link', 22); ?><b>Older homes without the third wire</b><span>Alarm boxes wired with power only can't interconnect by wire. The choice is fishing new cable through finished ceilings or using hardwired alarms that link wirelessly, and the walk-through tells you which makes sense.</span></li>
              <li><?php echo icon('hard-hat', 22); ?><b>New homes and additions</b><span>On a new build, alarm boxes and interconnect cable go in at rough-in with everything else. The <a href="/services/new-construction-wiring/">new construction wiring page</a> covers that work, from rough-in to final.</span></li>
              <li><?php echo icon('clipboard-check', 22); ?><b>Part of a full check of the house</b><span>Alarm ages and placement are among the things an <a href="/services/electrical-inspections/">electrical inspection</a> looks at. It is one of <?php echo count($services); ?> services on the <a href="/services/">Dellona Electric services list</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 6. PROOF — dark grain band, captioned client photo, Google profile -->
    <section class="section svc-proof texture-grain slant-top" aria-labelledby="proof-title">
      <span class="grain-layer" aria-hidden="true"></span>
      <div class="container">
        <div class="svc-proof__grid">
          <figure class="svc-proof__photo reveal-left">
            <?php echo p1_picture('living-room-ceiling-fan-v1', 'Finished living room with a round smoke alarm on the ceiling near the hallway, recessed lights and a nine-blade ceiling fan', ['sizes' => '(max-width: 900px) 92vw, 620px']); ?>
            <figcaption>The smoke alarm sits on the ceiling at the hallway opening, top left, alongside the recessed lights.</figcaption>
          </figure>
          <div class="svc-proof__copy reveal-right">
            <span class="eyebrow">From the job site</span>
            <h2 id="proof-title">What does a hardwired smoke alarm look like in a finished room?</h2>
            <p class="answer-block">In a finished room a hardwired smoke alarm sits flat on the ceiling, like the round unit near the hallway opening in this living room. Its power and interconnect wires stay hidden in the box above it, and the same ceiling also feeds the recessed lights and the large nine-blade fan.</p>
            <p>Reviews from Dellona Electric customers are on the company's Google Business Profile, where you can read them or add your own.</p>
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

    <!-- 7. FAQ — questions from the research brief, made specific to alarms -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do homeowners ask about smoke and carbon monoxide alarms?</h2>
          <p class="answer-block">Homeowners asking about smoke and carbon monoxide alarms mostly want to know what an installation costs and what Wisconsin requires. The cost turns on how many alarms the house needs and what wiring is already in place, and the requirement turns on what burns fuel in your home.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does it cost to install hardwired smoke detectors?</summary>
          <p>The cost of hardwired smoke detectors depends on how many alarms the house needs, whether the existing boxes already have power and an interconnect wire, smoke-only versus combination smoke and CO units, and how hard it is to reach the ceilings. Dellona Electric walks the house before pricing it. Call <?php echo e($phone); ?> to set that up.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Do Wisconsin homes need carbon monoxide alarms?</summary>
          <p>Most do. Wisconsin's carbon monoxide law, Wis. Stat. § 101.647, calls for a CO alarm in the basement and on each floor level, except attics, garages and storage areas. It does not apply to a home with no attached garage, no fireplace and no fuel-burning appliance, and a hardwired CO alarm must have a battery backup.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What other electrical work goes with new <span class="text-accent">smoke and CO alarms</span>?</h2>
        <p class="hero-answer">Smoke and CO alarms usually come up alongside a whole-house electrical inspection, new construction or an addition, or a ceiling being opened for smart switches and new wiring. Any of those is a good time to bring the alarms up to date, since the ceilings and boxes are already being worked on. Each job has its own page below.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <?php echo p1_service_cards(['electrical-inspections', 'new-construction-wiring', 'smart-home-wiring']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Alarm estimate</span>
        <h2 id="cta-title">Ready to have every alarm in the house sound together?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with how many floors and bedrooms you have and how old your alarms are. Dellona Electric will call you back to plan the install.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
