<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/lighting-installation/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php, the four client lighting photos
 * on this page (captions describe only what is visible — no job locations), general
 * electrical-code knowledge, or the public sources below. Prices, permit handling,
 * fixture brands and design services are unconfirmed (content-confirmations.json).
 * Sources:
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 *   Wisconsin adopts the 2023 NEC (DSPS, signed Sept 1 2026) —
 *     https://www.ecmweb.com/national-electrical-code/article/55403844/wisconsin-adopts-2023-national-electrical-code
 *   Luminaire box weight limit (over 50 lb needs a box marked for the weight): NFPA 70 (NEC) 314.27(A)(2)
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'lighting-installation';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'Lighting Installation Reedsburg WI | Dellona Electric';
$pageDescription = 'Indoor, outdoor and security lighting installation in Reedsburg, WI from Dellona Electric: recessed, pendant, soffit and motion lights. Call (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'hero-kitchen-lighting-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Want new lights put in?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'Lighting installation',
    'description' => 'Indoor, outdoor and security lighting installation, including recessed, pendant, soffit, wall and motion-sensor fixtures, for homes and businesses in Reedsburg, WI and the surrounding Sauk County area.',
]);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/lighting-installation/ — page composition: light-pool bento, Kelvin bar, fixture guide table, gallery proof band ==== */
.pg-lighting .svc-signs__layout { grid-template-columns: minmax(0, 1.1fr) minmax(0, .9fr); }
.pg-lighting .svc-signs__lead { order: 2; }
.pg-lighting .svc-sign.bento-large {
  background:
    radial-gradient(60% 70% at 50% -10%, color-mix(in srgb, var(--color-accent) 26%, transparent), transparent 70%),
    var(--color-card-tint-3);
}
.pg-lighting .svc-sign.bento-large h3 { font-size: var(--fs-h3); }
.pg-lighting .svc-sign.bento-medium { background: var(--color-surface); }
@media (max-width: 900px) { .pg-lighting .svc-signs__lead { order: 0; } }

.pg-lighting .svc-hero__media img { object-position: 30% 50%; }

/* Kelvin bar: warm-to-cool color temperature scale under the expert stat */
.pg-lighting .kelvin { display: grid; gap: var(--space-2); margin-top: var(--space-2); }
.pg-lighting .kelvin__bar {
  height: var(--space-3); border-radius: var(--radius-full);
  background: linear-gradient(90deg, var(--color-accent-dark), var(--color-accent), color-mix(in srgb, var(--color-accent) 25%, var(--color-white)), var(--color-white), color-mix(in srgb, var(--color-secondary) 30%, var(--color-white)));
  border: 1px solid var(--color-line);
}
.pg-lighting .kelvin__ticks { display: flex; justify-content: space-between; font-family: var(--font-accent); font-size: var(--font-size-xs); letter-spacing: .08em; color: var(--color-muted); }

/* Fixture guide table: wave edge, first column tagged with a lamp dot */
.pg-lighting .svc-compare { background: var(--color-paper); }
.pg-lighting .svc-table tbody th { position: relative; padding-left: calc(var(--space-5) + var(--space-4)); }
.pg-lighting .svc-table tbody th::before {
  content: ""; position: absolute; left: var(--space-5); top: calc(var(--space-4) + var(--space-2));
  width: var(--space-2); height: var(--space-2); border-radius: var(--radius-full);
  background: var(--color-accent); box-shadow: 0 0 0 var(--space-1) color-mix(in srgb, var(--color-accent) 25%, transparent);
}
.pg-lighting .svc-table tbody tr:nth-child(n+5) th::before { background: var(--color-secondary); box-shadow: 0 0 0 var(--space-1) color-mix(in srgb, var(--color-secondary) 25%, transparent); }

/* Proof band carries the recent-work strip instead of a single photo */
.pg-lighting .svc-proof__grid { grid-template-columns: minmax(0, .85fr) minmax(0, 1.15fr); }
.pg-lighting .sp-gallery-item { box-shadow: var(--shadow-lg); }
@media (min-width: 701px) { .pg-lighting .sp-gallery-grid { height: clamp(460px, 40vw, 580px); } .pg-lighting .sp-gallery-item { aspect-ratio: auto; min-height: 0; } .pg-lighting .sp-gallery-item picture { height: 100%; } }
.pg-lighting .sp-gallery-item img { transition: transform var(--transition-slow); }
.pg-lighting .sp-gallery-item:hover img { transform: scale(1.03); }
@media (max-width: 900px) { .pg-lighting .svc-proof__grid { grid-template-columns: 1fr; } }
@media (prefers-reduced-motion: reduce) { .pg-lighting .sp-gallery-item img { transition: none; } }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-lighting">

  <!-- 1. HERO — layered dark band, client kitchen lighting photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Kitchen with recessed ceiling lights and three glass pendant lights over a white island, wired by Dellona Electric', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Indoor · outdoor · security</span>
          <h1 class="hero-title" id="svc-title">Lighting installation in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric installs indoor, outdoor and security lighting for homes and businesses in Reedsburg and the surrounding Sauk County area: recessed ceiling lights, pendants over islands and bars, soffit and porch lights, and motion or dusk-to-dawn fixtures, wired on the right circuits with switches and dimmers that suit LED lamps.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
            <li><?php echo icon('lightbulb', 16); ?> Recessed &amp; pendants</li>
            <li><?php echo icon('sun', 16); ?> Exterior &amp; security</li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- 2. PROBLEM STATEMENT — bento signs left, pull quote right -->
    <section class="section svc-signs" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-right">
            <span class="eyebrow">When to call</span>
            <h2 id="signs-title">What are the signs your home's lighting needs an electrician?</h2>
            <p class="answer-block">Lights that flicker or buzz after an LED swap, rooms lit by a single ceiling fixture, and dark entries or driveways are the usual reasons to call. Each one has a wiring answer: a dimmer rated for LED loads, new recessed or pendant circuits, or exterior fixtures on a switch, motion sensor or photocell.</p>
            <p class="pull-quote">A lot of LED flicker isn't the bulb at all. It's a dimmer built for incandescent loads trying to run a few watts of LED.</p>
          </div>
          <div class="bento-grid">
            <div class="bento-large svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('lightbulb', 20); ?></span>
              <h3>Flicker and buzz after switching to LED</h3>
              <p>Older dimmers were designed around the load of incandescent bulbs. An LED lamp draws a fraction of that, so the dimmer can flicker, hum or cut out at the low end of the slide. The usual fix is a dimmer rated for LED loads and matched to the fixtures, with dimmable lamps. If a light flickers on a plain switch with no dimmer, that points to a loose connection instead, which is a job for <a class="svc-inline-link" href="/services/electrical-repair/">electrical troubleshooting</a>.</p>
            </div>
            <div class="bento-medium svc-sign reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('home', 20); ?></span>
              <h3>One fixture for the whole room</h3>
              <p>A single center light leaves corners, counters and work surfaces in your own shadow. A recessed layout spreads light evenly, and pendants put it where you work.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('sun', 20); ?></span>
              <h3>Dark entries and driveways</h3>
              <p>Soffit lights, wall lights by the doors and a motion floodlight make the walk from car to door safe.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('flame', 20); ?></span>
              <h3>Fixtures that run hot</h3>
              <p>Browned sockets or brittle fixture wires in older homes are heat damage. Replace the fixture and check the wire in the box.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. EXPERT POSITIONING — 60/40 split, color-temperature stat, evidence from the client's photos -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-left">
            <div class="img-framed">
              <?php echo p1_picture('commercial-bar-lighting-v1', 'Restaurant bar and dining area with filament pendant lights, ceiling-mounted fixtures and a skylight', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>2700–3000 K</b><span>The warm-white color temperature most homes pick for living spaces. 4000 K and up reads cooler, better for garages and shops.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-right">
            <span class="eyebrow">Who does the work</span>
            <h2 id="expert-title">What kind of lighting jobs does Dellona Electric take on?</h2>
            <p class="answer-block">Dellona Electric takes on lighting from a single fixture swap to the full layout of a new house. The company's own photos show a vaulted kitchen with a grid of recessed lights and three glass pendants, soffit lights on a new home, wall lights beside a two-door garage and filament pendants in a restaurant bar.</p>
            <div class="kelvin" aria-hidden="true">
              <div class="kelvin__bar"></div>
              <div class="kelvin__ticks"><span>2200 K</span><span>2700 K</span><span>3000 K</span><span>4000 K</span><span>5000 K</span></div>
            </div>
            <ul class="svc-proofs">
              <li><?php echo icon('hard-hat', 22); ?><b>Planned with the building</b><span>On a new house, every recessed light, pendant and soffit fixture goes in at rough-in, before drywall, which is how the kitchen and exterior in these photos were done. See <a href="/services/new-construction-wiring/">new construction wiring</a> for the full sequence.</span></li>
              <li><?php echo icon('wrench', 22); ?><b>Finished ceilings too</b><span>Existing rooms can take recessed lighting. Slim LED wafer fixtures need only a round cutout and no housing above the ceiling, so wire can often be fished through the cavities already there.</span></li>
              <li><?php echo icon('building-2', 22); ?><b>Dining rooms and bars</b><span>The photo here is a restaurant bar with filament pendants over the counter and ceiling fixtures across the dining area. Business lighting has its own page under <a href="/services/commercial-electrical/">commercial electrical work</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 6 (moved up). COMPARISON — fixture guide as a real table -->
    <section class="section svc-compare edge-wave-top" aria-labelledby="compare-title">
      <div class="container-wide">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Fixture guide</span>
          <h2 id="compare-title">Which type of light fits which part of the house?</h2>
          <p class="answer-block">Recessed lights suit general room lighting, pendants and under-cabinet strips suit task areas, and soffit, wall and motion fixtures suit the outside. The right mix depends on ceiling height, what is above the ceiling, and whether the room is finished or still open framing.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>General guidance. Ceiling height, insulation and framing decide the final choice for each room.</caption>
            <thead>
              <tr><th scope="col">Fixture</th><th scope="col">Best for</th><th scope="col">What the install involves</th><th scope="col">Watch for</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">LED wafer (canless) recessed</th><td>Retrofits in finished ceilings, low ceilings</td><td>A round cutout, a junction box that rides with the light, wire fished to each spot</td><td>Pick one color temperature for the whole room</td></tr>
              <tr><th scope="row">Recessed housing with trim</th><td>New builds, vaulted ceilings with sloped trims</td><td>Housings set in open framing at rough-in</td><td>Housings touching insulation must be rated for it</td></tr>
              <tr><th scope="row">Pendants</th><td>Islands, bars, dining tables</td><td>Ceiling boxes placed over the counter, not where an old fixture happened to be</td><td>Hang height above the counter and spacing between pendants</td></tr>
              <tr><th scope="row">Under-cabinet LED</th><td>Kitchen counters and workbenches</td><td>Low-profile strips or pucks, fed from a switch or a nearby box</td><td>Hiding the driver and the feed wire</td></tr>
              <tr><th scope="row">Soffit (eave) lights</th><td>Entries, gables, walkways</td><td>Recessed lights cut into the soffit, on a switch or a timer</td><td>Damp-location rating</td></tr>
              <tr><th scope="row">Wall lights and sconces</th><td>Garage doors, side doors, decks</td><td>An exterior box sealed to the siding at each light</td><td>Wet or damp rating, and glare toward the neighbors</td></tr>
              <tr><th scope="row">Motion floodlights</th><td>Driveways, yards, outbuildings</td><td>A high mount aimed at the approach, with a sensor that can be set</td><td>Sensor range and how long it stays on</td></tr>
              <tr><th scope="row">Dusk-to-dawn (photocell)</th><td>Yard lights, signs, farm lots</td><td>A photocell on the fixture or the circuit turns it on at dark</td><td>Mounting the cell where other lights won't fool it</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- 4. SERVICE BREAKDOWN — what's included + sticky-scroll process -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="included-title">
      <div class="container-wide">
        <div class="svc-breakdown__grid">
          <div class="svc-breakdown__sticky svc-body reveal-left">
            <span class="eyebrow">What's included</span>
            <h2 id="included-title">What's included when Dellona Electric installs new lighting?</h2>
            <p class="answer-block">A lighting installation covers the layout, the wiring and the controls, not just hanging the fixture. That means placing lights where the room needs them, running new circuits or extending existing ones, installing switches and LED-rated dimmers, and testing every fixture before the job is closed up.</p>
            <ul class="svc-checklist">
              <li><?php echo icon('check', 18); ?><span><strong>A layout that fits the room.</strong> Lights placed around counters, islands, doors and seating, spaced so recessed lights don't leave dark bands between them.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Circuits checked for the load,</strong> with a new circuit run when the existing one is already carrying enough.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Boxes that carry the weight.</strong> Under the National Electrical Code, a light fixture over 50 pounds needs a box marked for that weight.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Controls where you reach for them:</strong> three-way switches at both ends of halls and stairs, LED-rated dimmers, and timers, photocells or motion sensors outside. Phone and schedule control is covered on the <a href="/services/smart-home-wiring/">smart home wiring page</a>.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Outdoor-rated parts</strong> for anything in the weather: damp- or wet-location fixtures and exterior boxes sealed to the siding.</span></li>
            </ul>
          </div>
          <div class="reveal-right">
            <h3 class="sr-only">How a lighting installation goes, step by step</h3>
            <ol class="svc-steps">
              <li><h3>Walk the space</h3><p>Where the light falls short today, what you want to see better, and which switches are in the wrong place or missing entirely.</p></li>
              <li><h3>Choose fixtures and controls</h3><p>Fixture types and count, switch and dimmer locations, and color temperature, so you hear what the job covers before it goes on the schedule.</p></li>
              <li><h3>Run wire and set boxes</h3><p>In open framing that happens at rough-in. In finished rooms, wire is fished through existing cavities and small openings wherever the framing allows it.</p></li>
              <li><h3>Hang, switch and test</h3><p>Fixtures go up, LED dimmers are trimmed so the low end doesn't flicker, outdoor sensors are aimed, and every light is switched on before the crew leaves.</p></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- 5 + 7b. PROOF / RECENT WORK — dark grain band with the 3-photo lighting strip -->
    <section class="section svc-proof sp-gallery texture-grain slant-top" aria-labelledby="proof-title">
      <span class="grain-layer" aria-hidden="true"></span>
      <div class="container-wide">
        <div class="svc-proof__grid">
          <div class="svc-proof__copy reveal-left">
            <span class="eyebrow">Recent Work</span>
            <h2 id="proof-title">What lighting has Dellona Electric installed recently?</h2>
            <p class="answer-block">The photos here show three Dellona Electric lighting installs, two outdoors and one commercial. A new home at dusk has recessed soffit lights over the entry and gables, a new garage has up-and-down wall lights beside both doors, and a restaurant bar has filament pendants under a skylight.</p>
            <p>The kitchen at the top of this page is a fourth: recessed lights across a vaulted ceiling with three glass globe pendants over the island. Reviews from Dellona Electric customers are on the company's Google Business Profile.</p>
            <div class="actions">
              <a class="btn btn-accent" href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?> See Dellona Electric on Google</a>
              <a class="btn btn-outline-white" href="<?php echo e($reviewRequestUrl); ?>" target="_blank" rel="noopener">Leave a review</a>
            </div>
          </div>
          <div class="sp-gallery-grid reveal-right" data-p1-dynamic>
            <figure class="sp-gallery-item">
              <?php echo p1_picture('new-home-exterior-lighting-v1', 'New home at dusk with recessed soffit lights glowing over the entry and gables', ['sizes' => '(max-width: 700px) 92vw, 380px']); ?>
              <figcaption>Recessed soffit lights over the entry and gables of a new home, switched on at dusk.</figcaption>
            </figure>
            <figure class="sp-gallery-item">
              <?php echo p1_picture('garage-exterior-lighting-night-v1', 'New garage at night with up-and-down wall lights on both sides of two open doors', ['sizes' => '(max-width: 700px) 92vw, 320px']); ?>
              <figcaption>Up-and-down wall lights beside both doors of a new garage.</figcaption>
            </figure>
            <figure class="sp-gallery-item">
              <?php echo p1_picture('commercial-bar-lighting-v1', 'Restaurant bar with filament pendant lights hanging over the counter', ['sizes' => '(max-width: 700px) 92vw, 320px']); ?>
              <figcaption>Filament pendants over a restaurant bar.</figcaption>
            </figure>
          </div>
        </div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
        echo p1_google_reviews($slug, ['heading' => '', 'limit' => 3]);
        ?>
      </div>
    </section>

    <!-- 7. FAQ — questions from the research brief, made specific to lighting -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do Reedsburg homeowners ask before adding lighting?</h2>
          <p class="answer-block">Questions about new lighting usually come down to cost and whether the work needs a permit. Both depend on how many fixtures go in, whether new circuits or switch locations are involved, and where the property sits, so the answers below cover what drives each one.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does it cost to add recessed lights or pendants?</summary>
          <p>The cost of new recessed lights or pendants depends on how many fixtures go in, whether the ceiling is finished or open, how far the wire runs from the nearest usable circuit, and whether new switches or dimmers are part of it. Lighting added to a finished ceiling takes more labor per light than lighting wired at rough-in. Dellona Electric sees the space before giving a price. Call <?php echo e($phone); ?> to arrange it.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Do I need a permit to add lights in Reedsburg?</summary>
          <p>It depends on the work. Swapping a fixture on an existing box is a different job from adding new circuits, boxes or exterior lighting. Inside the city, the City of Reedsburg Building Inspection Department lists electrical alterations among the work that may need a permit application, and properties in the surrounding towns go through their own inspector. Ask when you call and you will know whether your lighting job needs one.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What other electrical work pairs well with <span class="text-accent">new lighting</span>?</h2>
        <p class="hero-answer">New lighting often goes in alongside a ceiling fan in the same room, smart switches and dimmers that run it from a phone or a schedule, or the wiring for a new build or addition where every fixture is planned at rough-in. Those three services are below, each with its own page and photos.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <p class="svc-body reveal-up">Looking for something else? All <?php echo count($services); ?> kinds of work are listed on the <a href="/services/">Dellona Electric services page</a>.</p>
      <?php echo p1_service_cards(['ceiling-fan-installation', 'smart-home-wiring', 'new-construction-wiring']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Lighting estimate</span>
        <h2 id="cta-title">Ready to light up a dark room or driveway?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with the rooms or outdoor areas you want lit. Dellona Electric will call back to talk through fixtures, switch locations and dimmers.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
