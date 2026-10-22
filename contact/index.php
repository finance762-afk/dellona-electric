<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /contact/ — Phase 5. Full lead form (form id 'contact') posting to the Page One
 * leads endpoint (build-plan form_action, via $formAction), three unbundled consent
 * boxes (legal-compliance.md), GBP map embed + directions (design-system F4).
 * Field names follow the endpoint contract: the dropdown posts as "service" (the
 * endpoint stores it as service_requested; any other name is dropped). _honey is the
 * honeypot the endpoint checks; _honeypot is a second hidden trap kept per the build
 * prompt. Business hours are not in intake — the page says to call, never invents hours.
 * ------------------------------------------------------------------------- */
$pageTitle       = 'Contact Dellona Electric | Electrician in Reedsburg, WI';
$pageDescription = 'Contact Dellona Electric in Reedsburg, WI: call (608) 477-8453, email dellonaelectric@outlook.com or send the form to request an electrical estimate.';
$canonicalUrl    = $siteUrl . '/contact/';
$currentPage     = 'contact';
$pageType        = 'contact';
$ogImage         = '/assets/images/truck-trailer-job-site-v1.jpg';

$contactAddressLine = $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
$phoneHref = 'tel:' . $phoneRaw;

$schemaGraph = [generateWebPageSchema($pageTitle, $pageDescription, $canonicalUrl, $ogImage)];
$schemaGraph[0]['@type'] = 'ContactPage';
$schemaGraph[0]['mainEntity'] = ['@id' => rtrim($siteUrl, '/') . '/#organization'];
$schemaGraph[0]['speakable'] = ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']];
$contactCrumbs = generateBreadcrumbSchema([['name' => 'Contact', 'url' => '/contact/']]);
unset($contactCrumbs['@context']);
$schemaGraph[] = $contactCrumbs;
$schemaMarkup = ['@graph' => $schemaGraph];
?>
<?php ob_start(); ?>
<style>
/* ==== /contact/ — page composition: type-led hero with contact tiles, form + info split,
   floating-label form, styled map with overlay card, closing CTA ==== */
.pg-contact h1, .pg-contact h2, .pg-contact h3 { text-wrap: balance; }

/* -- C1.4 page hero: layered dark band, three contact tiles instead of a photo -- */
.pg-contact .ct-hero { position: relative; isolation: isolate; overflow: clip; background: linear-gradient(125deg, var(--color-dark) 0%, var(--color-dark-alt) 50%, var(--color-primary-deep) 115%); }
.pg-contact .ct-hero::before {
  content: ""; position: absolute; z-index: -1; pointer-events: none; inset: -40% -10% -30% 45%;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 24%, transparent), transparent 70%);
}
.pg-contact .ct-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.55'/%3E%3C/svg%3E");
}
.pg-contact .ct-hero__grid { display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(0, .95fr); gap: clamp(2rem, 5vw, 4rem); align-items: end; }
.pg-contact .ct-hero .hero-copy { display: grid; gap: var(--space-4); }
.pg-contact .ct-hero h1 .text-accent { color: var(--color-accent-bright); }
.pg-contact .ct-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 86%, transparent); max-width: 34rem; }
.pg-contact .ct-crumbs { color: color-mix(in srgb, var(--color-white) 70%, transparent); }
.pg-contact .ct-crumbs ol { display: flex; flex-wrap: wrap; gap: var(--space-2); align-items: center; }
.pg-contact .ct-crumbs [aria-current] { color: var(--color-white); }
.pg-contact .ct-crumbs a:hover { color: var(--color-white); text-decoration: underline; }
.pg-contact .ct-tiles { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-3); }
.pg-contact .ct-tile a {
  display: grid; grid-template-columns: 48px 1fr auto; gap: var(--space-1) var(--space-4); align-items: center;
  padding: var(--space-4) var(--space-5); border-radius: var(--radius-lg); color: var(--color-white);
  background: color-mix(in srgb, var(--color-white) 7%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent);
  backdrop-filter: blur(8px); transition: background var(--transition), border-color var(--transition), transform var(--transition);
}
.pg-contact .ct-tile a:hover { background: color-mix(in srgb, var(--color-white) 12%, transparent); border-color: var(--color-accent); transform: translateX(4px); }
.pg-contact .ct-tile a, .pg-contact .ct-tile a * { text-decoration: none; }
.pg-contact .ct-tile small { grid-column: 2; grid-row: 1; }
.pg-contact .ct-tile b { grid-column: 2; grid-row: 2; }
.pg-contact .ct-tile__icon { grid-column: 1; grid-row: 1 / span 2; width: 48px; height: 48px; border-radius: var(--radius); display: grid; place-items: center; background: var(--color-accent); color: var(--color-ink); }
.pg-contact .ct-tile small { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-accent-bright); }
.pg-contact .ct-tile b { font-family: var(--font-heading); font-size: var(--font-size-lg); overflow-wrap: anywhere; }
.pg-contact .ct-tile__go { grid-column: 3; grid-row: 1 / span 2; color: color-mix(in srgb, var(--color-white) 60%, transparent); }
@media (max-width: 900px) { .pg-contact .ct-hero__grid { grid-template-columns: 1fr; } }
@media (max-width: 560px) {
  .pg-contact .ct-tile a { grid-template-columns: 40px 1fr; padding: var(--space-3) var(--space-4); }
  .pg-contact .ct-tile__icon { width: 40px; height: 40px; }
  .pg-contact .ct-tile b { font-size: var(--font-size-base); }
  .pg-contact .ct-tile__go { display: none; }
}

/* -- Form + info split -- */
.pg-contact .ct-main { background: var(--color-paper); }
.pg-contact .ct-split { display: grid; grid-template-columns: minmax(0, 1.55fr) minmax(0, 1fr); gap: clamp(1.5rem, 4vw, 3.5rem); align-items: start; }
.pg-contact .ct-form-card { background: var(--color-surface); border-radius: var(--radius-xl); padding: clamp(1.5rem, 3vw, 2.5rem); box-shadow: var(--shadow-lg); border-top: 4px solid var(--color-accent); }
.pg-contact .ct-form-card > .eyebrow { margin-bottom: var(--space-2); }
.pg-contact .ct-form-card h2 { margin-bottom: var(--space-2); }
.pg-contact .ct-form-card > p { color: var(--color-ink-2); margin: 0 0 var(--space-6); max-width: 56ch; }
.pg-contact .ct-form .form-grid { gap: var(--space-4); margin-bottom: var(--space-5); }

/* Floating labels with animated focus (no placeholder text shown — placeholder=" " drives :placeholder-shown) */
.pg-contact .ct-float { position: relative; }
.pg-contact .ct-float input, .pg-contact .ct-float select, .pg-contact .ct-float textarea {
  width: 100%; min-height: 56px; padding: var(--space-6) var(--space-4) var(--space-2); font: inherit; font-size: var(--font-size-base); color: var(--color-ink);
  background: var(--color-paper); border: 1px solid var(--color-line); border-radius: var(--radius); transition: border-color var(--transition), box-shadow var(--transition), background var(--transition);
}
.pg-contact .ct-float textarea { min-height: 132px; resize: vertical; }
.pg-contact .ct-float label {
  position: absolute; left: var(--space-4); top: var(--space-4); pointer-events: none; font-size: var(--font-size-base); color: var(--color-muted);
  transform-origin: left top; transition: transform var(--transition), color var(--transition);
}
.pg-contact .ct-float input:focus, .pg-contact .ct-float select:focus, .pg-contact .ct-float textarea:focus { outline: none; background: var(--color-surface); border-color: var(--color-primary); box-shadow: 0 0 0 3px color-mix(in srgb, var(--color-accent) 30%, transparent); }
.pg-contact .ct-float input:focus + label, .pg-contact .ct-float input:not(:placeholder-shown) + label,
.pg-contact .ct-float textarea:focus + label, .pg-contact .ct-float textarea:not(:placeholder-shown) + label,
.pg-contact .ct-float select + label { transform: translateY(calc(-1 * var(--space-3))) scale(.78); color: var(--color-accent-dark); font-weight: 600; }
.pg-contact .ct-float select { cursor: pointer; padding-right: var(--space-8); }

/* Consent fieldset: three separate boxes on tinted rows */
.pg-contact .form-consent-fieldset { display: grid; gap: var(--space-2); margin-bottom: var(--space-5); }
.pg-contact .form-consent-legend { font-family: var(--font-heading); font-size: var(--font-size-base); color: var(--color-ink); margin-bottom: var(--space-2); }
.pg-contact .form-consent-item { margin: 0; padding: var(--space-3) var(--space-4); border-radius: var(--radius); background: var(--color-paper); border: 1px solid var(--color-line); cursor: pointer; transition: border-color var(--transition); }
.pg-contact .form-consent-item:hover { border-color: var(--color-secondary); }
.pg-contact .form-consent-required { background: var(--color-card-tint-3); border-color: color-mix(in srgb, var(--color-accent) 40%, var(--color-line)); }
.pg-contact .required-star { color: var(--color-danger); font-weight: 700; }
.pg-contact .ct-form .btn { min-height: 52px; }
.pg-contact .ct-form__note { margin: var(--space-3) 0 0; font-size: var(--font-size-xs); color: var(--color-muted); text-align: center; }

/* Info column */
.pg-contact .ct-info { display: grid; gap: var(--space-4); position: sticky; top: calc(var(--nav-height) + var(--space-6)); }
.pg-contact .ct-info__card { background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); padding: var(--space-6); box-shadow: var(--shadow-sm); }
.pg-contact .ct-info__card h2, .pg-contact .ct-info__card h3 { font-size: var(--fs-h3); margin-bottom: var(--space-4); }
.pg-contact .ct-nap { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-4); }
.pg-contact .ct-nap li { display: grid; grid-template-columns: 24px 1fr; gap: var(--space-1) var(--space-3); }
.pg-contact .ct-nap svg { grid-row: span 2; color: var(--color-accent-dark); margin-top: var(--space-1); }
.pg-contact .ct-nap small { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-muted); }
.pg-contact .ct-nap a, .pg-contact .ct-nap span { color: var(--color-ink); font-weight: 600; word-break: break-word; }
.pg-contact .ct-nap a:hover { color: var(--color-accent-dark); }
.pg-contact .ct-steps { list-style: none; margin: 0; padding: 0; counter-reset: ctstep; display: grid; gap: var(--space-4); }
.pg-contact .ct-steps li { counter-increment: ctstep; display: grid; grid-template-columns: 36px 1fr; gap: var(--space-3); font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-contact .ct-steps li::before { content: counter(ctstep); width: 36px; height: 36px; border-radius: var(--radius-full); display: grid; place-items: center; background: var(--color-dark); color: var(--color-accent-bright); font-family: var(--font-accent); font-size: var(--font-size-lg); }
.pg-contact .ct-steps strong { display: block; color: var(--color-ink); font-family: var(--font-heading); }
.pg-contact .ct-info__dark { background: var(--color-dark); color: var(--color-white); border: 0; }
.pg-contact .ct-info__dark h3 { color: var(--color-white); }
.pg-contact .ct-info__dark p { margin: 0 0 var(--space-4); color: color-mix(in srgb, var(--color-white) 80%, transparent); font-size: var(--font-size-sm); }
@media (max-width: 1000px) { .pg-contact .ct-split { grid-template-columns: 1fr; } .pg-contact .ct-info { position: static; } }

/* -- Map: framed, desaturated until hovered, overlay address card -- */
.pg-contact .ct-map { background: var(--color-paper-2); }
.pg-contact .ct-map__head { display: grid; grid-template-columns: minmax(0, 1fr) auto; gap: var(--space-6); align-items: end; margin-bottom: var(--space-8); }
.pg-contact .ct-map__head > div { display: grid; gap: var(--space-3); max-width: 44rem; }
.pg-contact p.answer-block { font-size: var(--fs-lead); line-height: 1.55; color: var(--color-ink); margin: 0; }
.pg-contact .ct-map__frame { position: relative; border-radius: var(--radius-xl); box-shadow: var(--shadow-lg); outline: 1px solid var(--color-line); }
.pg-contact .ct-map__frame::before { content: ""; position: absolute; inset: calc(-1 * var(--space-3)) var(--space-8) var(--space-8) calc(-1 * var(--space-3)); border: 2px solid var(--color-accent); border-radius: var(--radius-xl); opacity: .55; z-index: 0; pointer-events: none; }
.pg-contact .map-embed { z-index: 1; aspect-ratio: 21 / 9; border-radius: var(--radius-xl); background: var(--color-card-tint-2); }
.pg-contact .map-embed iframe { filter: grayscale(.85) contrast(1.05); transition: filter var(--transition-slow); }
.pg-contact .ct-map__frame:hover .map-embed iframe, .pg-contact .ct-map__frame:focus-within .map-embed iframe { filter: none; }
.pg-contact .ct-map__card {
  position: absolute; z-index: 2; left: var(--space-6); bottom: var(--space-6); max-width: 20rem;
  background: var(--color-surface); border-radius: var(--radius-lg); padding: var(--space-5); box-shadow: var(--shadow-lg); display: grid; gap: var(--space-2);
}
.pg-contact .ct-map__card b { font-family: var(--font-heading); font-size: var(--font-size-lg); }
.pg-contact .ct-map__card span { font-size: var(--font-size-sm); color: var(--color-ink-2); }
@media (max-width: 760px) {
  .pg-contact .ct-map__head { grid-template-columns: 1fr; }
  .pg-contact .map-embed { aspect-ratio: 4 / 3; }
  .pg-contact .ct-map__card { position: static; max-width: none; margin-top: var(--space-4); }
}

/* -- C9.2 closing CTA -- */
.pg-contact .ct-cta .container-wide { display: grid; grid-template-columns: minmax(0, 1.3fr) auto; gap: var(--space-8); align-items: center; }
.pg-contact .ct-cta h2 { max-width: 24ch; margin-bottom: var(--space-3); }
.pg-contact .ct-cta p { max-width: 58ch; margin: 0; }
.pg-contact .ct-cta .actions { display: flex; flex-wrap: wrap; gap: var(--space-3); }
@media (max-width: 800px) { .pg-contact .ct-cta .container-wide { grid-template-columns: 1fr; } }

@media (prefers-reduced-motion: reduce) { .pg-contact .ct-tile a, .pg-contact .ct-tile a:hover, .pg-contact .ct-float label { transition: none; transform: none; } }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-contact">

  <!-- HERO — C1.4 page hero with direct contact tiles -->
  <section class="hero hero--interior ct-hero" aria-labelledby="contact-title">
    <div class="container">
      <nav class="breadcrumb ct-crumbs" aria-label="Breadcrumb"><ol><li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li><li><span aria-current="page">Contact</span></li></ol></nav>
      <div class="ct-hero__grid">
        <div class="hero-copy">
          <span class="eyebrow">Contact · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="contact-title">Contact <span class="text-accent"><?php echo e($siteName); ?></span> in <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></h1>
          <p class="hero-answer">The fastest way to reach Dellona Electric is to call <?php echo e($phone); ?>. You can also email <?php echo e($email); ?> or send the form below with your name, number and a short description of the electrical job, and the company will call you back to talk it through.</p>
        </div>
        <ul class="ct-tiles">
          <li class="ct-tile"><a href="<?php echo e($phoneHref); ?>"><span class="ct-tile__icon"><?php echo icon('phone', 22); ?></span><small>Call</small><b><?php echo e($phone); ?></b><span class="ct-tile__go"><?php echo icon('arrow-right', 18); ?></span></a></li>
          <li class="ct-tile"><a href="mailto:<?php echo e($email); ?>"><span class="ct-tile__icon"><?php echo icon('mail', 22); ?></span><small>Email</small><b><?php echo e($email); ?></b><span class="ct-tile__go"><?php echo icon('arrow-right', 18); ?></span></a></li>
          <li class="ct-tile"><a href="<?php echo e($directionsUrl); ?>" target="_blank" rel="noopener"><span class="ct-tile__icon"><?php echo icon('map-pin', 22); ?></span><small>Address</small><b><?php echo e($contactAddressLine); ?></b><span class="ct-tile__go"><?php echo icon('arrow-right', 18); ?></span></a></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- FORM + INFO — split contact layout -->
  <section class="section ct-main" aria-labelledby="form-title">
    <div class="container-wide">
      <div class="ct-split">
        <div class="ct-form-card reveal-left" id="estimate">
          <span class="eyebrow"><?php echo e($estimateCtaLabel); ?></span>
          <h2 id="form-title">What electrical work do you need done?</h2>
          <p>Tell Dellona Electric what is going on, or what you want added, in a sentence or two. Name, phone and email are required so the company can reach you; everything else helps the call-back go faster.</p>
          <form action="<?php echo e($formAction); ?>" method="POST" class="estimate-form ct-form" id="contact-form">
            <?php echo p1_lead_hidden_fields('contact'); ?>
            <input type="hidden" name="_consent_version" value="v2.1">
            <input type="hidden" name="_consent_page" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/contact/', ENT_QUOTES, 'UTF-8'); ?>">
            <input type="text" name="_honeypot" style="display:none" tabindex="-1" autocomplete="off" aria-hidden="true">
            <div class="form-grid">
              <div class="ct-float"><input id="contact-name" type="text" name="name" autocomplete="name" placeholder=" " required><label for="contact-name">Your name *</label></div>
              <div class="ct-float"><input id="contact-phone" type="tel" name="phone" autocomplete="tel" placeholder=" " required><label for="contact-phone">Phone *</label></div>
              <div class="ct-float full"><input id="contact-email" type="email" name="email" autocomplete="email" placeholder=" " required><label for="contact-email">Email *</label></div>
              <div class="ct-float full"><select id="contact-service" name="service"><?php echo p1_service_options(); ?></select><label for="contact-service">Service requested</label></div>
              <div class="ct-float full"><textarea id="contact-message" name="message" rows="4" placeholder=" "></textarea><label for="contact-message">What's going on? (breaker tripping, new circuit, new build…)</label></div>
            </div>
            <fieldset class="form-consent-fieldset">
              <legend class="form-consent-legend">Communication consent</legend>
              <label class="form-consent-item" for="contact-email-opt">
                <input id="contact-email-opt" type="checkbox" name="email_opt_in" value="yes" class="consent-checkbox">
                <span class="consent-label"><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo e($siteName); ?> about my inquiry, services, promotions and news. I can unsubscribe anytime via the link in any email or by emailing <?php echo e($email); ?>. Message frequency varies.</span>
              </label>
              <label class="form-consent-item" for="contact-sms-opt">
                <input id="contact-sms-opt" type="checkbox" name="sms_opt_in" value="yes" class="consent-checkbox">
                <span class="consent-label"><strong>SMS/Text messages (optional):</strong> I agree to receive text messages from <?php echo e($siteName); ?> at the phone number I provided. Message types may include appointment reminders, service updates and promotional offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. <strong>Consent is not a condition of purchase.</strong></span>
              </label>
              <label class="form-consent-item form-consent-required" for="contact-terms">
                <input id="contact-terms" type="checkbox" name="terms_accepted" value="yes" class="consent-checkbox" required>
                <span class="consent-label">I have read and agree to the <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and <a href="/terms/" target="_blank" rel="noopener">Terms of Service</a>. <span class="required-star">*</span></span>
              </label>
            </fieldset>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Send my request</button>
            <p class="ct-form__note">Requesting an estimate carries no obligation.</p>
          </form>
        </div>

        <aside class="ct-info reveal-right" aria-label="Contact details">
          <div class="ct-info__card">
            <h2>How do you reach Dellona Electric?</h2>
            <ul class="ct-nap">
              <li><?php echo icon('phone', 20); ?><small>Phone</small><a href="<?php echo e($phoneHref); ?>"><?php echo e($phone); ?></a></li>
              <li><?php echo icon('mail', 20); ?><small>Email</small><a href="mailto:<?php echo e($email); ?>"><?php echo e($email); ?></a></li>
              <li><?php echo icon('map-pin', 20); ?><small>Address</small><a href="<?php echo e($directionsUrl); ?>" target="_blank" rel="noopener"><?php echo e($contactAddressLine); ?></a></li>
              <li><?php echo icon('clock', 20); ?><small>Hours</small><?php if ($businessHours !== ''): ?><span><?php echo e($businessHours); ?></span><?php else: ?><span>Call <?php echo e($phone); ?> to check availability. The form is open any time.</span><?php endif; ?></li>
              <li><?php echo icon('route', 20); ?><small>Service area</small><span><?php echo e($address['city']); ?> and the surrounding <?php echo e($serviceAreas[0]['county']); ?> County area</span></li>
            </ul>
          </div>
          <div class="ct-info__card">
            <h3>What happens after you send the form?</h3>
            <ol class="ct-steps">
              <li><span><strong>Your request reaches <?php echo e($siteName); ?></strong>With the service and details you entered.</span></li>
              <li><span><strong>You get a call back</strong>To answer a few questions about the job and set a time to look at it.</span></li>
              <li><span><strong>You decide</strong>Go ahead when you are ready.</span></li>
            </ol>
          </div>
          <div class="ct-info__card ct-info__dark">
            <h3>Something sparking, smoking or hot?</h3>
            <p>Shut the power off at the breaker if you can do it safely. For fire or smoke, get out and call 911 first.</p>
            <a class="btn btn-accent btn-block" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
          </div>
        </aside>
      </div>
    </div>
  </section>

  <!-- MAP — GBP listing embed + Get Directions (design-system F4) -->
  <section class="section ct-map edge-curve-top" aria-labelledby="map-title">
    <div class="container-wide">
      <div class="ct-map__head reveal-up">
        <div>
          <span class="eyebrow">Find us</span>
          <h2 id="map-title">Where is <span class="text-accent">Dellona Electric</span> located?</h2>
          <p class="answer-block">Dellona Electric is based at <?php echo e($contactAddressLine); ?>, and works in Reedsburg and the surrounding Sauk County area. Most work happens at your home or business, so call <?php echo e($phone); ?> before stopping by.</p>
        </div>
        <a class="btn btn-secondary" href="<?php echo e($directionsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('navigation', 18); ?> Get Directions</a>
      </div>
      <div class="ct-map__frame reveal-scale">
        <div class="map-embed">
          <iframe src="<?php echo e($gbpMapEmbed); ?>" title="<?php echo e($siteName); ?> on Google Maps" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="ct-map__card">
          <b><?php echo e($siteName); ?></b>
          <span><?php echo e($contactAddressLine); ?></span>
          <a class="btn btn-primary btn-sm" href="<?php echo e($directionsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('navigation', 16); ?> Get Directions</a>
        </div>
      </div>
    </div>
  </section>

  <!-- CLOSING CTA — C9.2 -->
  <section class="closing-cta ct-cta texture-grain slant-top" aria-labelledby="ct-cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Rather talk it through?</span>
        <h2 id="ct-cta-title">Not sure which electrical service your job falls under?</h2>
        <p>You don't need to know. Call <?php echo e($phone); ?> and describe what you see, or browse the <?php echo p1_page_exists('/faq/') ? '<a href="/faq/">common questions</a>' : 'common questions'; ?> first. Dellona Electric will tell you what kind of job it is and what happens next.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <?php if (p1_page_exists('/services/')): ?><a class="btn btn-outline-white btn-lg" href="/services/">See all services</a><?php endif; ?>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
