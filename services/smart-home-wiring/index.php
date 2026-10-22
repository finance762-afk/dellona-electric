<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/smart-home-wiring/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php, the client photos on this page
 * (captions describe only what is visible — no job locations), general electrical-
 * code knowledge, or the sources below. No device brands are named: which brands
 * the client installs, whether they do app/hub setup, prices and permit handling
 * are unconfirmed (content-confirmations.json).
 * Sources:
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 *   Neutral at switch locations: NFPA 70 (NEC) 404.2(C), added in the 2011 edition
 *   Flexible cords not run through walls: NFPA 70 (NEC) 400.12
 *   Wisconsin adopts the 2023 NEC (DSPS, signed Sept 1 2026) —
 *     https://www.ecmweb.com/national-electrical-code/article/55403844/wisconsin-adopts-2023-national-electrical-code
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'smart-home-wiring';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'Smart Home Wiring Reedsburg WI | Dellona Electric';
$pageDescription = 'Smart home wiring in Reedsburg, WI from Dellona Electric: smart switches and dimmers, video doorbells, thermostats and hidden TV power. Call (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'living-room-ceiling-fan-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Need smart switches wired?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'Smart home wiring',
    'description' => 'Wiring for smart switches and dimmers, video doorbells, smart thermostats and in-wall TV power, including neutral wires and transformers, for homes in Reedsburg, WI and the surrounding Sauk County area.',
]);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/smart-home-wiring/ — page composition: TV-wall hero crop, neutral-wire box diagrams, device table ==== */
.pg-smart .svc-hero__media img { object-position: 20% 60%; }

/* Bento: medium first, large second (mirrors the panel and lighting pages) */
.pg-smart .svc-sign.bento-medium { grid-column: span 5; background: var(--color-card-tint-3); }
.pg-smart .svc-sign.bento-large { grid-column: span 7; }
.pg-smart .svc-sign.bento-small { grid-column: span 6; }
@media (max-width: 800px) { .pg-smart .svc-sign.bento-medium, .pg-smart .svc-sign.bento-large, .pg-smart .svc-sign.bento-small { grid-column: span 12; } }

/* Signature: two switch boxes drawn as wire lists */
.pg-smart .svc-neutral { background: var(--color-surface); }
.pg-smart .neutral-grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr); gap: var(--space-12); align-items: start; }
.pg-smart .boxes { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-4); }
.pg-smart .box {
  margin: 0; border: 2px solid var(--color-line); border-radius: var(--radius-lg); padding: var(--space-5);
  background: linear-gradient(180deg, var(--color-paper), var(--color-surface)); box-shadow: var(--shadow-sm); display: grid; gap: var(--space-3); align-content: start;
}
.pg-smart .box--ok { border-color: color-mix(in srgb, var(--color-success) 45%, var(--color-line)); }
.pg-smart .box--loop { border-style: dashed; }
.pg-smart .box figcaption { font-family: var(--font-heading); font-weight: 700; color: var(--color-ink); display: flex; align-items: center; gap: var(--space-2); }
.pg-smart .box--ok figcaption svg { color: var(--color-success); }
.pg-smart .box--loop figcaption svg { color: var(--color-accent-dark); }
.pg-smart .wires { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-2); }
.pg-smart .wires li { display: grid; grid-template-columns: var(--space-10) 1fr; gap: var(--space-3); align-items: center; font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-smart .wire { display: block; height: var(--space-2); border-radius: var(--radius-full); border: 1px solid var(--color-line); }
.pg-smart .wire--black { background: var(--color-ink); }
.pg-smart .wire--white { background: var(--color-surface); }
.pg-smart .wire--marked { background: linear-gradient(90deg, var(--color-surface) 0 55%, var(--color-ink) 55% 80%, var(--color-surface) 80%); }
.pg-smart .wire--ground { background: var(--color-accent-dark); }
.pg-smart .box__note { margin: 0; font-size: var(--font-size-xs); color: var(--color-muted); }
.pg-smart .safety-note { display: flex; gap: var(--space-3); align-items: flex-start; font-size: var(--font-size-sm); color: var(--color-ink-2); border-top: 1px solid var(--color-line); padding-top: var(--space-4); margin-top: var(--space-2); }
.pg-smart .safety-note svg { color: var(--color-danger); flex: 0 0 auto; margin-top: var(--space-1); }
@media (max-width: 900px) { .pg-smart .neutral-grid { grid-template-columns: 1fr; gap: var(--space-8); } }
@media (max-width: 560px) { .pg-smart .boxes { grid-template-columns: 1fr; } }

/* Device table rides on paper; expert split runs photo-right */
.pg-smart .svc-compare { background: var(--color-paper); }
.pg-smart .svc-table td:last-child { color: var(--color-ink); }
.pg-smart .svc-expert__grid { grid-template-columns: minmax(0, 1.2fr) minmax(0, .8fr); }
.pg-smart .svc-expert__figure { order: 2; }
.pg-smart .svc-expert__stat { right: auto; left: calc(-1 * var(--space-6)); }
@media (max-width: 900px) {
  .pg-smart .svc-expert__grid { grid-template-columns: 1fr; }
  .pg-smart .svc-expert__figure { order: 0; }
  .pg-smart .svc-expert__stat { left: var(--space-4); }
}
.pg-smart .svc-proof__photo { aspect-ratio: 4 / 3; }
.pg-smart .svc-proof__photo img { object-position: 30% 60%; }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-smart">

  <!-- 1. HERO — layered dark band, client TV-wall photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Living room TV wall with a recessed media box behind the mount and backlit built-in niches', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Switches · doorbells · TV walls</span>
          <h1 class="hero-title" id="svc-title">Smart home wiring in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric wires homes in Reedsburg and the surrounding Sauk County area for smart switches and dimmers, video doorbells, smart thermostats and wall-mounted TVs. Many smart-device headaches are wiring problems, such as a missing neutral or a weak doorbell transformer, and that is the part an electrician sorts out.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
            <li><?php echo icon('check', 16); ?> Neutrals checked</li>
            <li><?php echo icon('home', 16); ?> Hidden TV power</li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="svc-article" aria-labelledby="svc-title">

    <!-- 2. PROBLEM STATEMENT — pull quote + signs in a 5/7, 6/6 bento -->
    <section class="section svc-signs" aria-labelledby="signs-title">
      <div class="container-wide">
        <div class="svc-signs__layout">
          <div class="svc-signs__lead reveal-left">
            <span class="eyebrow">Telltale signs</span>
            <h2 id="signs-title">What are the signs your wiring isn't ready for smart devices?</h2>
            <p class="answer-block">Smart switches that won't power up, LED lights that glow when switched off, and video doorbells that keep rebooting are the common signs. Each traces back to the wiring behind the device: no neutral in the switch box, a no-neutral switch leaking a little current, or a doorbell transformer too weak for a camera.</p>
            <p class="pull-quote">The app can't fix what's in the wall. A smart switch is only as good as the wires in the box behind it.</p>
          </div>
          <div class="bento-grid">
            <div class="bento-medium svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('lightbulb', 20); ?></span>
              <h3>Lights that glow when off</h3>
              <p>A no-neutral smart switch stays powered by trickling a little current through the bulbs. Low-wattage LEDs can glow or flicker with the switch off.</p>
            </div>
            <div class="bento-large svc-sign reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('plug', 20); ?></span>
              <h3>No neutral in the switch box</h3>
              <p>Many smart switches need a neutral wire to power their own radio. In older homes the switch box often holds only a hot wire and the wire to the light, because the neutral stays up at the fixture. The fix is a no-neutral model, a smart bulb, or new cable to the box, which is the kind of run covered under <a class="svc-inline-link" href="/services/wiring-rewiring/">wiring repair and rewiring</a>.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('zap', 20); ?></span>
              <h3>A doorbell that keeps rebooting</h3>
              <p>Older doorbell transformers often put out too little voltage for a camera doorbell. It drops offline, or never charges, until the transformer is replaced.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('snowflake', 20); ?></span>
              <h3>A thermostat that drains or drops out</h3>
              <p>Smart thermostats want steady 24-volt power, usually from a common (C) wire. Older thermostat cable often has no spare conductor for it.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SIGNATURE — the neutral-wire check, drawn as two switch boxes -->
    <section class="section svc-neutral" aria-labelledby="neutral-title">
      <div class="container">
        <div class="neutral-grid">
          <div class="svc-body reveal-left">
            <span class="eyebrow">The neutral check</span>
            <h2 id="neutral-title">How do you know if a switch box has a neutral wire?</h2>
            <p class="answer-block">A switch box has a neutral if it holds a bundle of white wires joined together and tucked to the back, separate from the switch itself. A box with only one cable, or a white wire marked with black tape and landed on the switch, is usually a switch loop with no neutral available.</p>
            <p>The National Electrical Code started requiring a neutral at most switch locations in its 2011 edition, so a house wired before then is likely to have at least a few switch loops. A switch loop is not a defect. It just limits which smart switch will work in that spot without new wire.</p>
            <p class="safety-note"><?php echo icon('alert-triangle', 18); ?><span>Turn the breaker off before taking a switch plate off to look. If you would rather not, Dellona Electric checks every box on the list as the first step of the job.</span></p>
          </div>
          <div class="boxes reveal-right">
            <figure class="box box--ok">
              <figcaption><?php echo icon('check', 18); ?> Neutral in the box</figcaption>
              <ul class="wires">
                <li><span class="wire wire--black" aria-hidden="true"></span>Black, power coming in</li>
                <li><span class="wire wire--black" aria-hidden="true"></span>Black, out to the light</li>
                <li><span class="wire wire--white" aria-hidden="true"></span>White bundle, spliced at the back</li>
                <li><span class="wire wire--ground" aria-hidden="true"></span>Bare copper ground</li>
              </ul>
              <p class="box__note">Most smart switches and dimmers can go here.</p>
            </figure>
            <figure class="box box--loop">
              <figcaption><?php echo icon('alert-triangle', 18); ?> Switch loop</figcaption>
              <ul class="wires">
                <li><span class="wire wire--black" aria-hidden="true"></span>Black, out to the light</li>
                <li><span class="wire wire--marked" aria-hidden="true"></span>White marked black, power in</li>
                <li><span class="wire wire--ground" aria-hidden="true"></span>Bare copper ground</li>
              </ul>
              <p class="box__note">No neutral. Needs a no-neutral device or new cable.</p>
            </figure>
          </div>
        </div>
      </div>
    </section>

    <!-- 6. COMPARISON — what each smart device needs, as a real table -->
    <section class="section svc-compare edge-wave-top" aria-labelledby="compare-title">
      <div class="container-wide">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Device by device</span>
          <h2 id="compare-title">What does each smart device need from your home's wiring?</h2>
          <p class="answer-block">Each smart device needs something different from the wiring behind it. Switches and dimmers usually need a neutral, video doorbells need a strong enough transformer, smart thermostats need steady 24-volt power, and a wall-mounted TV needs power inside the wall that meets code. The table sets out each one.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>General guidance. Always follow the wiring diagram of the device you bought.</caption>
            <thead>
              <tr><th scope="col">Device</th><th scope="col">What it needs at the wall</th><th scope="col">Common snag</th><th scope="col">Usual fix</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">Smart switch</th><td>A neutral, and room in the box for a deeper device</td><td>A switch loop with no neutral</td><td>A no-neutral model, a smart bulb, or new cable</td></tr>
              <tr><th scope="row">Smart dimmer</th><td>A neutral and a rating for LED loads</td><td>Flicker or dropout at the low end</td><td>Set the dimmer's low trim and use dimmable lamps</td></tr>
              <tr><th scope="row">Three-way smart setup</th><td>A companion switch or remote at the second spot</td><td>Old traveler wiring that doesn't match the maker's diagram</td><td>Rewire the pair to the device's diagram</td></tr>
              <tr><th scope="row">Video doorbell</th><td>A doorbell transformer with enough voltage, and a working chime</td><td>An older low-voltage transformer</td><td>Replace the transformer</td></tr>
              <tr><th scope="row">Smart thermostat</th><td>A 24-volt common (C) wire</td><td>No spare conductor in the old cable</td><td>New thermostat cable or the maker's adapter</td></tr>
              <tr><th scope="row">Wall-mounted TV</th><td>A recessed outlet behind the screen and a low-voltage cable path</td><td>Power cords pushed through the wall, which the code doesn't allow</td><td>A recessed media box or an in-wall power kit</td></tr>
              <tr><th scope="row">Smart smoke and CO alarms</th><td>Hardwired interconnect between alarms</td><td>Battery-only units that don't sound together</td><td>Hardwired, interconnected alarms</td></tr>
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
            <h2 id="included-title">What's included in smart home wiring from Dellona Electric?</h2>
            <p class="answer-block">Smart home wiring covers what sits inside the wall: neutrals, boxes, transformers and in-wall power, installed so each device powers up and stays online. The job ends when every device is wired, powered and working from its own wall control, ready to pair with its app.</p>
            <ul class="svc-checklist">
              <li><?php echo icon('check', 18); ?><span><strong>A box-by-box survey</strong> of which switch locations have a neutral and enough depth. Smart switches are bulkier than standard ones, and a crowded box may need replacing.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>New cable where a neutral is missing,</strong> fished from the light or the nearest box with one.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Doorbell and thermostat power:</strong> a transformer sized for a camera doorbell and a common wire for a smart thermostat.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Power behind the TV</strong> from a recessed outlet or media box, with a separate path for HDMI and other low-voltage cables.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Lighting zones worth controlling.</strong> Smart dimmers do the most when each zone, such as niches, recessed lights and pendants, has its own switch. New zones are covered on the <a href="/services/lighting-installation/">lighting installation page</a>.</span></li>
            </ul>
          </div>
          <div class="reveal-right">
            <h3 class="sr-only">How a smart home wiring job goes, step by step</h3>
            <ol class="svc-steps">
              <li><h3>List the devices</h3><p>What you want to control, from where, and which devices you already own or plan to buy.</p></li>
              <li><h3>Open the boxes</h3><p>Each switch, doorbell and thermostat location is checked for a neutral, box depth, cable count and transformer voltage.</p></li>
              <li><h3>Wire and mount</h3><p>New cable, boxes, transformers or in-wall power go in where the survey found a gap, then the devices are mounted.</p></li>
              <li><h3>Power up and check</h3><p>Every device powers on and works from its own wall control, LED dimmers are trimmed, and three-way pairs are tested from both ends.</p></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. EXPERT POSITIONING — the 2011 neutral rule, evidence from the client's photos -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-right">
            <div class="img-framed">
              <?php echo p1_picture('sunroom-device-install-v1', 'Dellona Electric electrician setting a wiring device into a wall box in a sunroom with beadboard walls', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>2011</b><span>The National Electrical Code edition that began requiring a neutral at most switch locations.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-left">
            <span class="eyebrow">Who does the work</span>
            <h2 id="expert-title">What smart home wiring work has Dellona Electric done?</h2>
            <p class="answer-block">The clearest example of smart home wiring by Dellona Electric is the living room photographed on this page. It has a recessed media box behind the TV mount, built-in wall niches lit from above, recessed ceiling lights around a nine-blade fan and a smoke alarm on the ceiling.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('home', 22); ?><b>Power where the TV hangs</b><span>The recessed box behind the mount gives the TV an outlet and a cable path behind the screen, so nothing dangles and no cord runs inside the wall.</span></li>
              <li><?php echo icon('lightbulb', 22); ?><b>Lighting split into zones</b><span>Niche lights, recessed lights and the fan's own light are separate loads, which is what smart dimmers and scenes work best with.</span></li>
              <li><?php echo icon('flame', 22); ?><b>Safety devices in the mix</b><span>Smart homes still need alarms that sound together. Hardwired, interconnected smoke and CO alarms have their own page under <a href="/services/smoke-detector-installation/">smoke detector installation</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. PROOF — dark grain band, the TV wall photo, Google profile -->
    <section class="section svc-proof texture-grain slant-top" aria-labelledby="proof-title">
      <span class="grain-layer" aria-hidden="true"></span>
      <div class="container">
        <div class="svc-proof__grid">
          <div class="svc-proof__copy reveal-left">
            <span class="eyebrow">From the job site</span>
            <h2 id="proof-title">What does smart-ready wiring by Dellona Electric look like?</h2>
            <p class="answer-block">This living room shows what smart-ready wiring looks like once the walls are finished. A recessed box behind the TV mount supplies power and a cable path, the built-in niches have their own lights, and recessed lights circle a nine-blade fan, so each zone is something a smart dimmer can run.</p>
            <p>Customer reviews of Dellona Electric are posted on the company's Google Business Profile, and you can add your own there after a job.</p>
            <div class="actions">
              <a class="btn btn-accent" href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?> See Dellona Electric on Google</a>
              <a class="btn btn-outline-white" href="<?php echo e($reviewRequestUrl); ?>" target="_blank" rel="noopener">Leave a review</a>
            </div>
          </div>
          <figure class="svc-proof__photo reveal-right">
            <?php echo p1_picture('living-room-ceiling-fan-v1', 'TV wall with a recessed media box behind the mount, backlit built-in niches and an electric fireplace below', ['sizes' => '(max-width: 900px) 92vw, 560px']); ?>
            <figcaption>Recessed media box behind the TV mount, lit niches on both sides and recessed lights overhead.</figcaption>
          </figure>
        </div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
        echo p1_google_reviews($slug, ['heading' => '', 'limit' => 3]);
        ?>
      </div>
    </section>

    <!-- 7. FAQ — questions from the research brief, made specific to smart wiring -->
    <section class="section svc-faq" aria-labelledby="faq-title">
      <div class="container-narrow">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Common questions</span>
          <h2 id="faq-title">What do Reedsburg homeowners ask about smart home wiring?</h2>
          <p class="answer-block">Smart home wiring questions usually come down to cost and to whether a permit is involved. Both depend on whether the job is a device swap in existing boxes or new cable, new boxes and new circuits, so each answer below starts from that difference.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does it cost to wire a house for smart switches?</summary>
          <p>The cost of smart switch wiring depends mostly on how many switch boxes already have a neutral. Boxes with a neutral and enough depth turn the job into a device swap, while switch loops need new cable or a different type of device. A doorbell transformer, thermostat wire or in-wall TV power each add their own piece. Dellona Electric checks the boxes before pricing. Call <?php echo e($phone); ?> to start.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Does smart home wiring need a permit in Reedsburg?</summary>
          <p>Replacing a switch in an existing box is a different job from running new cable or adding circuits for a TV wall. Inside the city, the City of Reedsburg Building Inspection Department lists electrical alterations among the work that may need a permit application, and the surrounding towns have their own inspector. Ask when you call and you will know before work starts whether your smart home project needs one.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What other electrical work pairs with a <span class="text-accent">smart home</span> upgrade?</h2>
        <p class="hero-answer">Smart home projects tend to grow into the rest of the electrical system. New lighting zones give smart dimmers something worth controlling, hardwired interconnected smoke and carbon monoxide alarms sound together on every level, and whole-house surge protection guards the electronics a smart home adds. Each has its own page.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <p class="svc-body reveal-up">See every service on the <a href="/services/">Dellona Electric services page</a>, from repairs to new construction.</p>
      <?php echo p1_service_cards(['lighting-installation', 'smoke-detector-installation', 'surge-protection']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Smart wiring estimate</span>
        <h2 id="cta-title">Ready to get your switches and devices wired right?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with the devices you have or plan to buy. Dellona Electric will call you back to talk through what the wiring needs.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
