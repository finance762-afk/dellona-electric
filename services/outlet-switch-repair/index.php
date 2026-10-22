<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /services/outlet-switch-repair/ — Phase 4 (premium editorial service page).
 * Facts trace to build-plan.json / config.php, the client photos used on this
 * page (described only by what they show), general electrical-code knowledge
 * (receptacle types; tamper-resistant receptacles first required in dwellings by
 * the 2008 NEC), or the public sources below. Prices, device brands and the
 * owner's process are unconfirmed and stay out of the copy (/content-confirmations.json).
 * Sources:
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 *   Wisconsin adopts the 2023 NEC (DSPS, signed Sept 1 2026) —
 *     https://www.ecmweb.com/national-electrical-code/article/55403844/wisconsin-adopts-2023-national-electrical-code
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';

$serviceSlug     = 'outlet-switch-repair';
$svc             = p1_service_by_slug($serviceSlug);
$pageTitle       = 'Outlet & Switch Repair Reedsburg WI | Dellona Electric';
$pageDescription = 'Outlet and light switch repair in Reedsburg, WI: dead, loose or warm outlets, GFCI and USB outlets, and dimmers. Call Dellona Electric at (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/services/' . $serviceSlug . '/';
$currentPage     = 'services';
$pageType        = 'service';

$heroImage   = 'living-room-ceiling-fan-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormService = $svc['name'];
$heroFormTitle   = 'Need an outlet or switch fixed?';

$schemaMarkup = p1_service_schema($serviceSlug, $pageTitle, $pageDescription, $canonicalUrl, $heroImage, [
    'serviceType' => 'Outlet repair',
    'description' => 'Repair and replacement of dead, loose, warm or worn outlets and light switches, including GFCI, tamper-resistant, USB and dimmer devices, for homes and businesses in Reedsburg, WI and the surrounding Sauk County area.',
]);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<style>
/* ==== /services/outlet-switch-repair/ — page composition: drawn receptacle faces, stat card on top, switch table ==== */
.pg-outlet .svc-sign.bento-large { background: var(--color-card-tint-2); }
.pg-outlet .svc-sign--warn { border-color: color-mix(in srgb, var(--color-danger) 35%, var(--color-line)); }
.pg-outlet .svc-sign--warn .svc-sign__icon { background: color-mix(in srgb, var(--color-danger) 12%, var(--color-surface)); color: var(--color-danger); }

/* Signature: receptacle-type grid with a CSS-drawn faceplate per type */
.pg-outlet .rcpt-section { background: var(--color-surface); }
.pg-outlet .rcpt-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-4); list-style: none; margin: 0; padding: 0; }
.pg-outlet .rcpt {
  display: grid; grid-template-columns: auto 1fr; gap: var(--space-2) var(--space-4); align-items: start;
  background: var(--color-paper); border: 1px solid var(--color-line); border-radius: var(--radius-lg); padding: var(--space-5);
  transition: transform var(--transition), box-shadow var(--transition);
}
.pg-outlet .rcpt:hover { transform: translateY(-2px); box-shadow: var(--shadow); }
.pg-outlet .rcpt h3 { font-size: var(--font-size-lg); align-self: center; }
.pg-outlet .rcpt p { grid-column: 1 / -1; margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-outlet .rcpt p b { color: var(--color-ink); }
.pg-outlet .rcpt-face {
  position: relative; width: var(--space-12); height: var(--space-16); border-radius: var(--radius);
  background: var(--color-surface); border: 2px solid var(--color-line); box-shadow: var(--shadow-sm);
}
.pg-outlet .rcpt-face::before, .pg-outlet .rcpt-face::after {
  content: ""; position: absolute; top: var(--space-4); width: var(--space-1); height: var(--space-4); border-radius: var(--radius-sm); background: var(--color-ink);
}
.pg-outlet .rcpt-face::before { left: var(--space-3); height: var(--space-5); }
.pg-outlet .rcpt-face::after { right: var(--space-3); }
.pg-outlet .rcpt-face i {
  position: absolute; left: 50%; bottom: var(--space-3); transform: translateX(-50%);
  width: var(--space-3); height: var(--space-3); border-radius: var(--radius-full) var(--radius-full) var(--radius-sm) var(--radius-sm); background: var(--color-ink);
}
.pg-outlet .rcpt-face--gfci { background: color-mix(in srgb, var(--color-success) 8%, var(--color-surface)); }
.pg-outlet .rcpt-face--gfci i { width: var(--space-6); height: var(--space-2); border-radius: var(--radius-sm); bottom: auto; top: 46%; background: var(--color-danger); }
.pg-outlet .rcpt-face--afci { background: color-mix(in srgb, var(--color-accent) 12%, var(--color-surface)); }
.pg-outlet .rcpt-face--afci i { width: var(--space-6); height: var(--space-2); border-radius: var(--radius-sm); bottom: auto; top: 46%; background: var(--color-accent-dark); }
.pg-outlet .rcpt-face--tr::before, .pg-outlet .rcpt-face--tr::after { box-shadow: 0 0 0 2px var(--color-accent); }
.pg-outlet .rcpt-face--usb i { width: var(--space-5); height: var(--space-2); border-radius: var(--radius-sm); bottom: var(--space-2); background: var(--color-secondary); }
.pg-outlet .rcpt-face--20a::before { height: var(--space-5); box-shadow: var(--space-1) var(--space-3) 0 0 var(--color-ink); }
.pg-outlet .rcpt-face--wr { border-color: var(--color-secondary); background: var(--color-card-tint-2); }
@media (max-width: 1000px) { .pg-outlet .rcpt-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 600px) { .pg-outlet .rcpt-grid { grid-template-columns: 1fr; } }

/* Expert: stat card sits at the top of the photo on this page */
.pg-outlet .svc-expert { background: var(--color-paper-2); }
.pg-outlet .svc-expert__stat { bottom: auto; top: var(--space-8); }
.pg-outlet .svc-breakdown { background: var(--color-paper); }
.pg-outlet .svc-proof__photo { aspect-ratio: 4 / 5; max-height: 600px; }
@media (prefers-reduced-motion: reduce) { .pg-outlet .rcpt, .pg-outlet .rcpt:hover { transition: none; transform: none; } }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-outlet">

  <!-- 1. HERO — layered dark band, finished living-room wall photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="svc-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Living room wall with a wall switch by the doorway, backlit niches and a power box under the TV mount', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_service_breadcrumb($svc['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Outlets &amp; switches · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="svc-title">Outlet and light switch repair in <span class="text-accent"><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span></h1>
          <p class="hero-answer">Dellona Electric repairs and replaces outlets and light switches in Reedsburg homes and businesses: dead or loose outlets, outlets that feel warm or spark, switches that flicker or buzz, and old two-prong outlets. Replacements can be GFCI, tamper-resistant, USB or smart devices, matched to what the room and the code call for.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('plug', 16); ?> GFCI outlets</li>
            <li><?php echo icon('lightbulb', 16); ?> Dimmers</li>
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
            <span class="eyebrow">Signs it's time</span>
            <h2 id="signs-title">When should an outlet or light switch be repaired instead of ignored?</h2>
            <p class="answer-block">Repair an outlet or switch as soon as it feels warm, smells hot, sparks more than a tiny flash, buzzes, or won't hold a plug. Those are signs of a loose connection or a worn device, and both get worse with use. A dead outlet is less urgent, but it often hides one of those causes.</p>
            <p class="pull-quote">Most outlet problems start as a loose screw or a worn spring. So do a lot of outlet fires.</p>
          </div>
          <div class="bento-grid">
            <div class="bento-large svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('plug', 20); ?></span>
              <h3>Plugs fall out or feel loose</h3>
              <p>The spring contacts inside an outlet wear out after years of plugging and unplugging. A loose grip means a poor connection, and a poor connection makes heat right at the plug. Replacing the outlet is quick, and it is the moment to check the wire and box behind it.</p>
            </div>
            <div class="bento-medium svc-sign svc-sign--warn reveal-up reveal-delay-2">
              <span class="svc-sign__icon"><?php echo icon('flame', 20); ?></span>
              <h3>Warm, discolored or crackling</h3>
              <p>A faceplate that is warm, brown around the slots, or crackles when something is plugged in has a connection that is heating up. Stop using it and turn off its breaker.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-3">
              <span class="svc-sign__icon"><?php echo icon('lightbulb', 20); ?></span>
              <h3>Switch flickers or buzzes</h3>
              <p>Lights that blink when you touch the switch, or a dimmer that hums, point to a worn switch or a dimmer that doesn't suit LED bulbs.</p>
            </div>
            <div class="bento-small svc-sign reveal-up reveal-delay-1">
              <span class="svc-sign__icon"><?php echo icon('alert-triangle', 20); ?></span>
              <h3>Dead outlet</h3>
              <p>Press reset on nearby GFCI outlets first. If it is still dead, a loose connection upstream is the likely cause; the <a class="svc-inline-link" href="/services/electrical-repair/">electrical repair and troubleshooting</a> page covers how that gets traced.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SIGNATURE — receptacle types with drawn faceplates -->
    <section class="section rcpt-section edge-wave-top" aria-labelledby="rcpt-title">
      <div class="container-wide">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Know your outlets</span>
          <h2 id="rcpt-title">Which type of outlet should replace the one you have?</h2>
          <p class="answer-block">The right replacement outlet depends on where it is and what the circuit is. Kitchens, bathrooms, garages, basements and outdoor outlets need GFCI protection, every new outlet in a home must be tamper-resistant, and a 20-amp circuit takes a 20-amp device. Beyond that, USB and weather-resistant outlets are about convenience and location.</p>
        </div>
        <ul class="rcpt-grid">
          <li class="rcpt reveal-up reveal-delay-1">
            <span class="rcpt-face" aria-hidden="true"><i></i></span><h3>Standard 15-amp</h3>
            <p>The everyday outlet on most bedroom and living-room circuits. <b>Replace it when</b> plugs fall out, the face is cracked, or it has been wired with push-in backstab connections that loosen.</p>
          </li>
          <li class="rcpt reveal-up reveal-delay-2">
            <span class="rcpt-face rcpt-face--gfci" aria-hidden="true"><i></i></span><h3>GFCI</h3>
            <p>Cuts power in a fraction of a second when current leaks to ground, as it can through water or a person. <b>Required</b> in kitchens, bathrooms, laundry areas, garages, unfinished basements and outdoors. One GFCI can protect the outlets wired after it.</p>
          </li>
          <li class="rcpt reveal-up reveal-delay-3">
            <span class="rcpt-face rcpt-face--afci" aria-hidden="true"><i></i></span><h3>AFCI or dual-function</h3>
            <p>Detects the arcing a damaged cord or loose connection makes before it starts a fire. A dual-function device adds GFCI protection too. <b>Used</b> where the code wants arc-fault protection and the panel breaker doesn't provide it.</p>
          </li>
          <li class="rcpt reveal-up reveal-delay-1">
            <span class="rcpt-face rcpt-face--tr" aria-hidden="true"><i></i></span><h3>Tamper-resistant</h3>
            <p>Built-in shutters stop a child pushing a key or hairpin into one slot. Look for "TR" on the face. <b>Required</b> for new and replacement outlets in homes.</p>
          </li>
          <li class="rcpt reveal-up reveal-delay-2">
            <span class="rcpt-face rcpt-face--usb" aria-hidden="true"><i></i></span><h3>USB-A or USB-C</h3>
            <p>Two standard plugs plus built-in USB charging ports. <b>Good for</b> nightstands, kitchen counters and desks, and it fits the same box as the outlet it replaces.</p>
          </li>
          <li class="rcpt reveal-up reveal-delay-3">
            <span class="rcpt-face rcpt-face--20a" aria-hidden="true"><i></i></span><h3>20-amp</h3>
            <p>Recognizable by the T-shaped slot. <b>Goes on</b> 20-amp circuits such as kitchen counters, and never on a 15-amp circuit, where it would invite a load the wire can't carry.</p>
          </li>
        </ul>
      </div>
    </section>

    <!-- 3. EXPERT POSITIONING — 2008 stat, GFCI evidence photo -->
    <section class="section svc-expert" aria-labelledby="expert-title">
      <div class="container">
        <div class="svc-expert__grid">
          <figure class="svc-expert__figure reveal-left">
            <div class="img-framed">
              <?php echo p1_picture('ev-charger-garage-v1', 'GFCI outlet with its green indicator lit on a garage wall beside a wall-mounted JuiceBox EV charger', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <figcaption class="svc-expert__stat"><b>2008</b><span>The National Electrical Code edition that first required tamper-resistant outlets in homes.</span></figcaption>
          </figure>
          <div class="svc-expert__copy svc-body reveal-right">
            <span class="eyebrow">Who does the work</span>
            <h2 id="expert-title">Who repairs outlets and switches at Dellona Electric?</h2>
            <p class="answer-block">Outlet and switch repairs are handled by Dellona Electric's crew, based on Briar Bluff Rd in Reedsburg since 2018. The same electricians wire garages, kitchens and new homes, so a simple device swap that turns up scorched insulation or aluminum wire inside the box doesn't need a second company.</p>
            <ul class="svc-proofs">
              <li><?php echo icon('shield-check', 22); ?><b>GFCI where there's water and concrete</b><span>The garage in this photo has a GFCI outlet beside the charger, green light on. Garages, basements and outdoor outlets are where that protection matters most, and where older homes most often lack it.</span></li>
              <li><?php echo icon('home', 22); ?><b>Switches that suit what they control</b><span>Dimmers that match LED bulbs, three-way switches that agree with each other, and smart switches where the box has the neutral wire they need. More on that on the <a href="/services/smart-home-wiring/">smart home wiring page</a>.</span></li>
              <li><?php echo icon('waypoints', 22); ?><b>When the box tells a bigger story</b><span>Brittle cloth-covered cable or a missing ground behind the device means the fix is <a href="/services/wiring-rewiring/">wiring repair or rewiring</a>. Everything else Dellona Electric does is on the <a href="/services/">services page</a>.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. SERVICE BREAKDOWN — what's included + process -->
    <section class="section svc-breakdown edge-curve-top" aria-labelledby="included-title">
      <div class="container-wide">
        <div class="svc-breakdown__grid">
          <div class="svc-breakdown__sticky svc-body reveal-left">
            <span class="eyebrow">What's included</span>
            <h2 id="included-title">What's included when Dellona Electric replaces an outlet or switch?</h2>
            <p class="answer-block">An outlet or switch replacement covers more than the device: the box and the wire behind it get looked at too. The new device is matched to the circuit and the location, connected on its screw terminals, and tested before the cover plate goes back on.</p>
            <ul class="svc-checklist">
              <li><?php echo icon('check', 18); ?><span><strong>Power off and proven dead</strong> at the device before anything is unscrewed.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>The box and wire inspected:</strong> scorched insulation, nicked conductors, aluminum wire, a loose box or a missing ground.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>The right device</strong> for the circuit's amperage and the room, including GFCI and tamper-resistant types where required. With Wisconsin on the 2023 National Electrical Code since September 2026, a replaced outlet has to meet today's protection rules.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Solid connections</strong> on screw terminals instead of push-in backstabs.</span></li>
              <li><?php echo icon('check', 18); ?><span><strong>Tested:</strong> polarity, ground, and a GFCI test-and-reset where one is fitted.</span></li>
            </ul>
          </div>
          <div class="reveal-right">
            <h3 class="sr-only">An outlet or switch repair, step by step</h3>
            <ol class="svc-steps">
              <li><h3>Find the circuit</h3><p>The breaker for the device is identified and switched off, and the outlet is tested to make sure it is really dead.</p></li>
              <li><h3>Open it up and look</h3><p>The old device comes out so the box, the wire and the connections can be checked for heat damage and wear.</p></li>
              <li><h3>Fit the right replacement</h3><p>A new outlet or switch suited to the location goes in, wired onto its terminals with any damaged wire ends trimmed back to clean copper.</p></li>
              <li><h3>Test and close</h3><p>Power goes back on, the device is tested under a plug-in load or with its lights, and the cover plate is fitted.</p></li>
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
            <?php echo p1_picture('sunroom-device-install-v1', 'Electrician kneeling on a patterned tile floor, screwing a device into a wall box on beadboard paneling', ['sizes' => '(max-width: 900px) 92vw, 520px']); ?>
            <figcaption>Fitting a device to a wall box on beadboard paneling, screwdriver in hand.</figcaption>
          </figure>
          <div class="svc-proof__copy reveal-right">
            <span class="eyebrow">Up close</span>
            <h2 id="proof-title">What does outlet and switch work by Dellona Electric look like up close?</h2>
            <p class="answer-block">Outlet and switch work happens at the wall box, one device at a time. This photo shows a Dellona Electric electrician kneeling on a patterned tile floor, screwing a device into its box on beadboard paneling, with spare screwdrivers and strippers laid out on the floor and the window sill.</p>
            <p>Customer reviews for Dellona Electric are posted on its Google Business Profile. Read them there, or leave your own after the work is done.</p>
            <div class="actions">
              <a class="btn btn-accent" href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?> Google reviews</a>
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

    <!-- 6. COMPARISON — switch types as a real table -->
    <section class="section svc-compare" aria-labelledby="compare-title">
      <div class="container">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Switch options</span>
          <h2 id="compare-title">Should you replace a light switch with a standard switch, a dimmer or a smart switch?</h2>
          <p class="answer-block">A standard switch is the right choice when you only need on and off. Choose a dimmer when you want to set the light level and the bulbs are dimmable, and a smart switch when you want schedules or phone control, provided the box has a neutral wire or the switch is a no-neutral model.</p>
        </div>
        <div class="svc-table-wrap reveal-up">
          <table class="svc-table">
            <caption>General guidance. What's in the box, and which bulbs you use, decide what fits.</caption>
            <thead>
              <tr><th scope="col">Consideration</th><th scope="col">Standard switch</th><th scope="col">Dimmer</th><th scope="col" class="is-pick">Smart switch</th></tr>
            </thead>
            <tbody>
              <tr><th scope="row">Needs a neutral wire in the box</th><td>No.</td><td>Usually not.</td><td class="is-pick"><strong>Most models do.</strong> Older switch loops often lack one.</td></tr>
              <tr><th scope="row">Works with LED bulbs</th><td>Yes.</td><td>Only with dimmable LEDs and an LED-rated dimmer.</td><td class="is-pick">Yes, within the switch's rated load.</td></tr>
              <tr><th scope="row">Three-way (two switches, one light)</th><td>Yes, with a matching three-way pair.</td><td>Yes, with a three-way dimmer kit.</td><td class="is-pick">Yes, with a companion switch.</td></tr>
              <tr><th scope="row">Runs warm</th><td>No.</td><td>Slightly, which is normal.</td><td class="is-pick">Slightly.</td></tr>
              <tr><th scope="row">Best for</th><td>Closets, hallways, basements.</td><td>Dining, living and bedroom lighting.</td><td class="is-pick">Porch lights on a schedule, lights you control from your phone.</td></tr>
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
          <h2 id="faq-title">What do Reedsburg customers ask about outlet and switch repairs?</h2>
          <p class="answer-block">The two questions that come up most about outlet and switch work are how it is priced and whether swapping a device needs a permit. Both depend on how many devices are involved and whether anything new is being added, so these answers explain the difference and what to mention when you call.</p>
        </div>
        <details class="faq reveal-up" open>
          <summary>How much does it cost to repair or replace an outlet or switch?</summary>
          <p>The cost of outlet or switch work depends on how many devices you want replaced, what type they are (a GFCI or smart switch costs more than a standard device), and whether opening the box turns up damaged wire or a missing ground that needs fixing too. Doing several at one visit is usually better value than one at a time. Call Dellona Electric at <?php echo e($phone); ?> with the list.</p>
        </details>
        <details class="faq reveal-up">
          <summary>Do I need a permit to replace outlets or switches in Reedsburg?</summary>
          <p>Swapping an existing outlet or switch for a similar one is treated differently from adding new outlets or circuits. Inside the city, the City of Reedsburg Building Inspection Department lists electrical alterations among the work that may need an application, and homes in the surrounding towns fall under their own inspector. Mention what you're planning when you call and the permit question gets answered up front.</p>
        </details>
      </div>
    </section>

  </article>

  <!-- RELATED SERVICES — required services-grid, 3 cards -->
  <section class="section svc-related" aria-labelledby="related-title">
    <div class="container-wide">
      <div class="section-title reveal-up">
        <span class="eyebrow-label">What We Do</span>
        <h2 id="related-title">What other electrical work goes with <span class="text-accent">outlet and switch</span> repairs?</h2>
        <p class="hero-answer">A dead outlet sometimes turns out to be a circuit problem that needs tracing, two-prong outlets often lead to new grounded wiring, and switch upgrades are the first step toward smart controls around the house. Each of those has its own page below, with what the work involves and what to expect.</p>
        <span class="section-subtitle">Other services you may need</span>
      </div>
      <?php echo p1_service_cards(['electrical-repair', 'wiring-rewiring', 'smart-home-wiring']); ?>
    </div>
  </section>

  <!-- 8. FINAL CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Outlets &amp; switches</span>
        <h2 id="cta-title">Ready to fix those outlets and switches?</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with how many outlets or switches need attention and which rooms they're in. Dellona Electric will call you back to set up the work.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
