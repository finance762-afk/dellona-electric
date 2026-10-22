<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/electrical-inspections/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php, the client photos on this page
 * (described only by what is visible), general wiring-history and code points,
 * and the public sources below. Prices, how findings are delivered, visit length
 * and the owner's process are unconfirmed and stay out of the copy
 * (content-confirmations.json). A Dellona inspection is NOT a municipal code
 * inspection — the page says so.
 * Sources:
 *   Wis. Stat. § 101.647 (carbon monoxide detectors) — https://law.justia.com/codes/wisconsin/chapter-101/section-101-647
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 *   Wisconsin adopts the 2023 NEC (DSPS, signed Sept 1 2026) —
 *     https://www.ecmweb.com/national-electrical-code/article/55403844/wisconsin-adopts-2023-national-electrical-code
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'electrical-inspections';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'Home Electrical Inspections Reedsburg WI | Dellona Electric';
$pageDescription = 'Home electrical inspections in Reedsburg, WI: the panel, wiring, outlets and alarms checked before you buy, remodel or add a load. Call (608) 477-8453 today.';
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
    'serviceType' => 'Home electrical inspection',
    'description' => 'Whole-home electrical inspections and maintenance visits in Reedsburg, WI and the surrounding Sauk County area: panel, wiring, outlets, GFCI/AFCI protection and smoke and carbon monoxide alarms checked.',
]);

$phoneHref = 'tel:' . $phoneRaw;

/* Signature: the inspection sheet, grouped the way the walk-through goes. */
$inspSheet = [
    ['icon' => 'zap', 'title' => 'Panel and service', 'items' => ['Panel brand, age and condition', 'Breakers sized to their wire', 'Signs of heat, rust or water', 'Main shutoff easy to reach', 'Grounding and bonding']],
    ['icon' => 'waypoints', 'title' => 'Wiring', 'items' => ['Knob-and-tube or cloth-covered cable', 'Aluminum branch circuits', 'Splices outside of boxes', 'Do-it-yourself additions', 'Cable damage in basement and attic']],
    ['icon' => 'plug', 'title' => 'Outlets and switches', 'items' => ['Loose, warm or cracked devices', 'Two-prong and ungrounded outlets', 'Reversed polarity', 'Switches that buzz or spark']],
    ['icon' => 'shield-check', 'title' => 'Protection devices', 'items' => ['GFCI in kitchens, baths, garage, basement, outdoors', 'AFCI where the code expects it', 'Test buttons that actually trip']],
    ['icon' => 'flame', 'title' => 'Alarms', 'items' => ['Smoke alarms on every level', 'Carbon monoxide alarms where required', 'Alarm age and interconnection']],
];
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/electrical-inspections/ — page composition: clipboard inspection sheet, numbered "when" cards, three-way table ==== */

/* Signature: inspection sheet on a clipboard — a clip bar, ruled paper, check boxes */
.pg-inspect .insp-board { position: relative; margin-top: var(--space-10); background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); padding: var(--space-12) clamp(var(--space-5), 3vw, var(--space-10)) var(--space-8); }
.pg-inspect .insp-board::before {
  content: ""; position: absolute; top: calc(-1 * var(--space-3)); left: 50%; transform: translateX(-50%);
  width: clamp(8rem, 18vw, 12rem); height: var(--space-8); border-radius: var(--radius) var(--radius) var(--radius-sm) var(--radius-sm);
  background: linear-gradient(180deg, var(--color-secondary), var(--color-primary)); box-shadow: var(--shadow);
}
.pg-inspect .insp-sheet { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: var(--space-6); }
.pg-inspect .insp-group h3 { display: flex; align-items: center; gap: var(--space-2); font-size: var(--font-size-base); padding-bottom: var(--space-3); border-bottom: 2px solid var(--color-accent); margin-bottom: var(--space-3); }
.pg-inspect .insp-group h3 svg { color: var(--color-accent-dark); flex: 0 0 auto; }
.pg-inspect .insp-group ul { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-2); }
.pg-inspect .insp-group li {
  position: relative; padding: 0 0 var(--space-2) calc(var(--space-5) + var(--space-2)); font-size: var(--font-size-sm); color: var(--color-ink-2);
  border-bottom: 1px dashed var(--color-line);
}
.pg-inspect .insp-group li::before {
  content: ""; position: absolute; left: 0; top: var(--space-1); width: var(--space-4); height: var(--space-4);
  border: 2px solid var(--color-secondary); border-radius: var(--radius-sm);
}
.pg-inspect .insp-note { margin: var(--space-6) 0 0; padding-top: var(--space-4); border-top: 1px solid var(--color-line); font-size: var(--font-size-sm); color: var(--color-muted); max-width: none; }
@media (max-width: 1100px) { .pg-inspect .insp-sheet { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
@media (max-width: 700px) { .pg-inspect .insp-sheet { grid-template-columns: 1fr; } }

/* "When to get one" cards: even 2x2 grid with oversized index numbers */
.pg-inspect .svc-signs .bento-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); counter-reset: when; }
.pg-inspect .svc-signs .bento-grid > * { grid-column: auto; grid-row: auto; counter-increment: when; }
.pg-inspect .svc-sign::after {
  content: counter(when, decimal-leading-zero); position: absolute; right: var(--space-4); top: var(--space-2);
  font-family: var(--font-accent); font-size: clamp(2.2rem, 1.6rem + 2vw, 3.2rem); line-height: 1; color: var(--color-accent); opacity: .35;
}
@media (max-width: 700px) { .pg-inspect .svc-signs .bento-grid { grid-template-columns: 1fr; } }

/* Expert photo is the small crew portrait — keep it modest */
.pg-inspect .svc-expert__grid { grid-template-columns: minmax(0, .7fr) minmax(0, 1.3fr); }
.pg-inspect .svc-expert__figure { max-width: 380px; }
.pg-inspect .svc-expert__figure .img-framed { aspect-ratio: 3 / 4; }
.pg-inspect .svc-proof__photo { aspect-ratio: 3 / 4; max-height: 600px; }
@media (max-width: 900px) { .pg-inspect .svc-expert__grid { grid-template-columns: 1fr; } }

/* Three-way table: the column for this service carries the accent */
.pg-inspect .svc-table thead th:first-child { width: 20%; }
.pg-inspect .insp-actions { margin-top: var(--space-8); }
.pg-inspect .svc-proof .svc-steps li { background: color-mix(in srgb, var(--color-white) 6%, transparent); border-color: color-mix(in srgb, var(--color-white) 14%, transparent); box-shadow: none; }
.pg-inspect .svc-proof .svc-steps h3 { color: var(--color-white); }
.pg-inspect .svc-proof .svc-steps p { color: color-mix(in srgb, var(--color-white) 78%, transparent); }
.pg-inspect .svc-proof .svc-steps li::before { color: var(--color-accent-bright); }
.pg-inspect .svc-sign.card-tint-1 { background: var(--color-card-tint-1); }
.pg-inspect .svc-sign.card-tint-2 { background: var(--color-card-tint-2); }
.pg-inspect .svc-sign.card-tint-3 { background: var(--color-card-tint-3); }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-inspect">

  <!-- 1. HERO — layered dark band, basement panel photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Two Dellona Electric electricians examining an open breaker panel in a basement with cable runs along the log joists', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Inspections · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="svc-title">Home electrical inspections in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric inspects home electrical systems in Reedsburg and the surrounding Sauk County area. That means the panel, the wiring you can reach, every outlet and switch, GFCI and AFCI protection, and smoke and carbon monoxide alarms. Book one before buying an older house or adding a big load.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
            <li><?php echo icon('clipboard-check', 16); ?> Room by room</li>
            <li><?php echo icon('home', 16); ?> Older homes</li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- 2. PROBLEM STATEMENT — when an inspection is worth booking -->
    <section class="section svc-signs" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-left">
            <span class="eyebrow">When to get one</span>
            <h2 id="signs-title">When is a home electrical inspection worth booking?</h2>
            <p class="answer-block">Book a home electrical inspection before you buy or remodel an older house, before adding a big load, and after water damage. A big load means an EV charger, a heat pump or a hot tub. In each case you need to know what the wiring can handle before you spend money on the house.</p>
            <p class="pull-quote">An inspection changes nothing in the house. It tells you what you already have before you build on it.</p>
          </div>
          <div class="bento-grid">
            <div class="svc-sign card-tint-1 bento-item reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('home', 20); ?></span>
              <h3>Buying an older house</h3>
              <p>A general home inspector looks at everything in the house. An electrician's inspection opens the panel and goes deeper on wiring age, past add-ons and what will need replacing.</p>
            </div>
            <div class="svc-sign card-tint-2 bento-item reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('hammer', 20); ?></span>
              <h3>Before a remodel or addition</h3>
              <p>Opening walls is the moment to replace old cable. Knowing what is behind them first keeps the remodel budget honest.</p>
            </div>
            <div class="svc-sign card-tint-3 bento-item reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('battery-charging', 20); ?></span>
              <h3>Before adding a big load</h3>
              <p>An EV charger, heat pump, hot tub or shop can push an older panel past what it was built for. An inspection answers whether it has room.</p>
            </div>
            <div class="svc-sign card-tint-1 bento-item reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('droplets', 20); ?></span>
              <h3>After water or storm damage</h3>
              <p>Breakers, outlets and cable that have been wet are not trusted just because the power came back on. They get checked.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. SERVICE BREAKDOWN — the inspection sheet (signature) -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="included-title">
      <div class="container-wide">
        <div class="svc-head reveal-up">
          <span class="eyebrow">What gets checked</span>
          <h2 id="included-title">What does a Dellona Electric home electrical inspection cover?</h2>
          <p class="answer-block svc-body">A Dellona Electric home electrical inspection covers five areas of the house, listed on the sheet below. They are the panel and service, the wiring you can reach, outlets and switches, GFCI and AFCI protection, and smoke and carbon monoxide alarms. Anything that turns up can then be priced as <a href="/services/electrical-repair/">electrical repair</a> or a larger job.</p>
        </div>
        <div class="insp-board reveal-up">
          <div class="insp-sheet">
            <?php foreach ($inspSheet as $inspGroup): ?>
            <div class="insp-group">
              <h3><?php echo icon($inspGroup['icon'], 18); ?><?php echo e($inspGroup['title']); ?></h3>
              <ul>
                <?php foreach ($inspGroup['items'] as $inspItem): ?>
                <li><?php echo e($inspItem); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php endforeach; ?>
          </div>
          <p class="insp-note">Wisconsin law (Wis. Stat. § 101.647) calls for a carbon monoxide alarm in the basement and on each floor level of a home that has a fuel-burning appliance, a fireplace or an attached garage. The <a class="svc-inline-link" href="/services/smoke-detector-installation/">smoke and CO alarm page</a> covers placement.</p>
        </div>
      </div>
    </section>

    <!-- 3. EXPERT POSITIONING — 60/40 split, wiring-history stat, what an electrician sees -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-left">
            <div class="img-framed">
              <?php echo p1_picture('crew-company-truck-v1', 'Two members of the Dellona Electric crew standing beside the lettered company truck', ['sizes' => '(max-width: 900px) 80vw, 380px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>1965–73</b><span>Roughly when aluminum branch-circuit wiring went into some U.S. homes. It is one of the things an inspection looks for.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-right">
            <span class="eyebrow">Who does the work</span>
            <h2 id="expert-title">Who inspects the wiring when you call Dellona Electric?</h2>
            <p class="answer-block">Home electrical inspections are done by Dellona Electric's crew, the Reedsburg electricians who repair, rewire and upgrade the same systems they inspect. The company is owned by Edward Giannoni and has been in business since 2018, so what an inspection finds can be explained in terms of what fixing it actually involves.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('waypoints', 22); ?><b>Old wiring, named for what it is</b><span>Knob-and-tube from before the 1940s, cloth-covered cable, aluminum branch circuits and two-prong outlets all turn up in older houses. The <a href="/services/wiring-rewiring/">wiring repair and rewiring page</a> explains what each one means for the house.</span></li>
              <li><?php echo icon('zap', 22); ?><b>Panels opened, not just looked at</b><span>The cover comes off so breakers, wire sizes and connections can be seen. The basement panel at the top of this page is the kind of box that gets that look.</span></li>
              <li><?php echo icon('clipboard-list', 22); ?><b>Maintenance as well as inspection</b><span>The same visit can tighten connections, test every GFCI and AFCI, and replace worn devices. It is one of <?php echo count($services); ?> services on the <a href="/services/">Dellona Electric services page</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. PROOF — dark grain band, captioned client photo, process, Google profile -->
    <section class="section svc-proof texture-grain slant-top" aria-labelledby="proof-title">
      <span class="grain-layer" aria-hidden="true"></span>
      <div class="container">
        <div class="svc-proof__grid">
          <div class="svc-proof__copy reveal-left">
            <span class="eyebrow">How the visit goes</span>
            <h2 id="proof-title">What happens during a home electrical inspection visit?</h2>
            <p class="answer-block">During a home electrical inspection visit, the electrician starts at the panel, then walks the house room by room, testing outlets and protection devices along the way. You then go over what was found together, starting with anything that is a safety problem, before any repair is discussed or priced.</p>
            <ol class="svc-steps">
              <li><h3>Panel first</h3><p>Cover off, breakers and connections checked, service and grounding looked at.</p></li>
              <li><h3>Room by room</h3><p>Outlets tested for power, grounding and polarity; GFCI and AFCI devices tripped and reset.</p></li>
              <li><h3>Basement, attic, outside</h3><p>Visible cable runs, splices, exterior outlets and the service mast.</p></li>
              <li><h3>Go over the findings</h3><p>Safety items first, then what can wait, then what any upgrade you are planning will need.</p></li>
            </ol>
          </div>
          <figure class="svc-proof__photo reveal-right">
            <?php echo p1_picture('ev-charger-garage-v1', 'GFCI receptacle on a garage wall beside a wall-mounted JuiceBox EV charger plugged into a 240-volt outlet', ['sizes' => '(max-width: 900px) 92vw, 500px']); ?>
            <figcaption>A garage wall from a Dellona Electric job: a GFCI receptacle beside a plug-in EV charger and its 240-volt outlet.</figcaption>
          </figure>
        </div>
        <div class="actions insp-actions">
          <a class="btn btn-accent" href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?> See Dellona Electric on Google</a>
          <a class="btn btn-outline-white" href="<?php echo e($reviewRequestUrl); ?>" target="_blank" rel="noopener">Leave a review</a>
        </div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
        echo p1_google_reviews($slug, ['heading' => '', 'limit' => 3]);
        ?>
      </div>
    </section>

    <!-- 6. COMPARISON — three kinds of "inspection", as a real table -->
    <section class="section svc-compare" aria-labelledby="compare-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Which inspection</span>
          <h2 id="compare-title">How is an electrician's inspection different from a code inspection or a home inspection?</h2>
          <p class="answer-block">An electrician's inspection is a private check of the whole electrical system that you ask for. It is not the municipal code inspection that new permitted work must pass, and it goes deeper on wiring than a general home inspector's report. A home inspector's report is often what prompts a buyer to book one.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>A Dellona Electric inspection does not replace a permit inspection and is not a pass/fail certificate.</caption>
            <thead>
              <tr><th scope="col">&nbsp;</th><th scope="col" class="is-pick">Electrician's home inspection</th><th scope="col">Municipal code inspection</th><th scope="col">General home inspection</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">Who does it</th><td class="is-pick">An electrical contractor such as Dellona Electric.</td><td>The building inspector for the city or town.</td><td>A home inspector hired for a sale.</td></tr>
              <tr><th scope="row">When</th><td class="is-pick">Whenever you ask: buying, remodeling, adding a load, after damage.</td><td>When permitted work is done, at rough-in and final.</td><td>During a home purchase.</td></tr>
              <tr><th scope="row">What it covers</th><td class="is-pick">The whole electrical system, panel opened.</td><td>The new work covered by the permit.</td><td>Every system in the house, electrical at a visual level.</td></tr>
              <tr><th scope="row">What you get</th><td class="is-pick">Findings explained, plus what fixing them involves.</td><td>Approval of the permitted work, or corrections.</td><td>A report that may recommend an electrician.</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- 7. FAQ — research-brief questions made specific to inspections -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do Reedsburg homeowners ask before booking an electrical inspection?</h2>
          <p class="answer-block">Before booking an electrical inspection, Reedsburg homeowners mostly ask what it costs and whether Dellona Electric will come out to their address. The cost depends on the house, and the service area runs from Reedsburg into the surrounding Sauk County area, so both answers below start from the property itself.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does a home electrical inspection cost?</summary>
          <p>The cost of a home electrical inspection depends on the size and age of the house, how many panels there are, and whether a garage, shop or other outbuilding is included. Call <?php echo e($phone); ?> with the address, the age of the house and why you want the inspection, and Dellona Electric will tell you how it is priced.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Do you do electrical inspections outside Reedsburg?</summary>
          <p>Dellona Electric is based at <?php echo e($address['street']); ?> in Reedsburg and works in Reedsburg and the surrounding Sauk County area. If the house you want inspected is farther out, call <?php echo e($phone); ?> with the address and you will get a straight answer on whether it is in range.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What work usually follows an <span class="text-accent">electrical inspection</span>?</h2>
        <p class="hero-answer">Inspection findings in older homes tend to point toward three kinds of work. Those are a panel that needs repair or more capacity, old or damaged wiring that should be replaced, and smoke or carbon monoxide alarms that are missing, expired or not interconnected. Each has its own page below with what the work involves.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <?php echo p1_service_cards(['panel-upgrades', 'wiring-rewiring', 'smoke-detector-installation']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Inspection estimate</span>
        <h2 id="cta-title">Ready to find out what's behind your walls?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with the age of the house and why you want it inspected, whether that is a purchase, a remodel or a new load. Dellona Electric will call you back to set a time.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
