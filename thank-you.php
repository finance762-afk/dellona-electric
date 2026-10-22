<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * thank-you.php — the leads endpoint 303-redirects here (_next = $siteUrl/thank-you).
 * noindex, nofollow. Confirmation, what happens next (the same three steps the
 * homepage and contact page promise — no response-time claim, which is unconfirmed),
 * phone CTA, links back to services, and the Google review request (design-system F5).
 * ------------------------------------------------------------------------- */
$pageTitle       = 'Thank You | Dellona Electric, Reedsburg, WI';
$pageDescription = 'Thanks for contacting Dellona Electric in Reedsburg, WI. Your request has been sent, and the company will call you back about your electrical job.';
$canonicalUrl    = $siteUrl . '/thank-you';
$currentPage     = 'thank-you';
$pageType        = 'other';
$noindex         = true;

$phoneHref = 'tel:' . $phoneRaw;

$tyServices = array_values(array_filter([
    ['/services/electrical-repair/', 'Electrical repair', 'wrench'],
    ['/services/panel-upgrades/', 'Panel repair & upgrades', 'zap'],
    ['/services/lighting-installation/', 'Lighting installation', 'lightbulb'],
    ['/services/ev-charger-installation/', 'EV charger installation', 'battery-charging'],
    ['/services/generator-installation/', 'Generator installation', 'power'],
    ['/services/new-construction-wiring/', 'New construction wiring', 'hard-hat'],
], function ($s) { return p1_page_exists($s[0]); }));
?>
<?php ob_start(); ?>
<style>
/* ==== thank-you — page composition: confirmation hero with pulse badge, numbered next
   steps on a rail, review card, service chips ==== */
.pg-thanks h1, .pg-thanks h2, .pg-thanks h3 { text-wrap: balance; }
.pg-thanks .ty-hero { position: relative; isolation: isolate; overflow: clip; background: linear-gradient(120deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 120%); }
.pg-thanks .ty-hero::before { content: ""; position: absolute; z-index: -1; pointer-events: none; inset: -40% 30% -20% -20%; background: radial-gradient(closest-side, color-mix(in srgb, var(--color-success) 26%, transparent), transparent 70%); }
.pg-thanks .ty-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.55'/%3E%3C/svg%3E");
}
.pg-thanks .ty-hero .hero-copy { display: grid; gap: var(--space-4); max-width: 44rem; }
.pg-thanks .ty-hero h1 .text-accent { color: var(--color-accent-bright); }
.pg-thanks .ty-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 86%, transparent); max-width: 38rem; }
.pg-thanks .ty-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.pg-thanks .ty-badge { width: 64px; height: 64px; border-radius: var(--radius-full); display: grid; place-items: center; background: var(--color-success); color: var(--color-white); box-shadow: 0 0 0 0 color-mix(in srgb, var(--color-success) 50%, transparent); animation: ty-pulse 2.4s var(--ease) 3; }
@keyframes ty-pulse { 0% { box-shadow: 0 0 0 0 color-mix(in srgb, var(--color-success) 50%, transparent); } 100% { box-shadow: 0 0 0 22px transparent; } }

/* -- Next steps rail + review card -- */
.pg-thanks .ty-next { background: var(--color-paper); }
.pg-thanks .ty-next__grid { display: grid; grid-template-columns: minmax(0, 1.25fr) minmax(0, .75fr); gap: clamp(2rem, 5vw, 4rem); align-items: start; }
.pg-thanks .ty-head { display: grid; gap: var(--space-3); margin-bottom: var(--space-8); max-width: 44rem; }
.pg-thanks p.answer-block { font-size: var(--fs-lead); line-height: 1.55; color: var(--color-ink); margin: 0; }
.pg-thanks .ty-steps { list-style: none; margin: 0; padding: 0; counter-reset: tystep; position: relative; display: grid; gap: var(--space-6); }
.pg-thanks .ty-steps::before { content: ""; position: absolute; left: 23px; top: var(--space-2); bottom: var(--space-2); width: 2px; background: linear-gradient(to bottom, var(--color-success), var(--color-accent)); }
.pg-thanks .ty-steps li { counter-increment: tystep; position: relative; display: grid; grid-template-columns: 48px 1fr; gap: var(--space-4); align-items: start; }
.pg-thanks .ty-steps li::before { content: counter(tystep); position: relative; z-index: 1; width: 48px; height: 48px; border-radius: var(--radius-full); display: grid; place-items: center; background: var(--color-dark); color: var(--color-accent-bright); font-family: var(--font-accent); font-size: var(--font-size-xl); box-shadow: 0 0 0 6px var(--color-paper); }
.pg-thanks .ty-steps li:first-child::before { content: "✓"; background: var(--color-success); color: var(--color-white); }
.pg-thanks .ty-steps h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-1); }
.pg-thanks .ty-steps p { margin: 0; color: var(--color-ink-2); font-size: var(--font-size-sm); max-width: 52ch; }
.pg-thanks .ty-side { display: grid; gap: var(--space-4); }
.pg-thanks .ty-card { border-radius: var(--radius-lg); padding: var(--space-6); box-shadow: var(--shadow); display: grid; gap: var(--space-3); }
.pg-thanks .ty-card--call { background: var(--color-dark); color: var(--color-white); }
.pg-thanks .ty-card--call h3 { color: var(--color-white); }
.pg-thanks .ty-card--call p { margin: 0; color: color-mix(in srgb, var(--color-white) 80%, transparent); font-size: var(--font-size-sm); }
.pg-thanks .ty-card--review { background: var(--color-card-tint-3); border: 1px solid color-mix(in srgb, var(--color-accent) 35%, var(--color-line)); }
.pg-thanks .ty-card--review p { margin: 0; font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-thanks .ty-stars { display: flex; gap: var(--space-1); color: var(--color-star); }
.pg-thanks .ty-stars svg { fill: currentColor; }
@media (max-width: 900px) { .pg-thanks .ty-next__grid { grid-template-columns: 1fr; } }

/* -- Back to services: chip links -- */
.pg-thanks .ty-more { background: var(--color-surface); }
.pg-thanks .ty-chips { list-style: none; margin: 0; padding: 0; display: flex; flex-wrap: wrap; gap: var(--space-3); }
.pg-thanks .ty-chips a { text-decoration: none; display: inline-flex; gap: var(--space-2); align-items: center; padding: var(--space-3) var(--space-5); border-radius: var(--radius-full); border: 1px solid var(--color-line); background: var(--color-paper); font-weight: 600; color: var(--color-ink); transition: border-color var(--transition), background var(--transition), transform var(--transition); }
.pg-thanks .ty-chips a:hover { border-color: var(--color-accent); background: var(--color-card-tint-3); transform: translateY(-2px); }
.pg-thanks .ty-chips svg { color: var(--color-accent-dark); }
@media (prefers-reduced-motion: reduce) { .pg-thanks .ty-badge { animation: none; } .pg-thanks .ty-chips a, .pg-thanks .ty-chips a:hover { transition: none; transform: none; } }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-thanks">

  <section class="hero hero--interior ty-hero" aria-labelledby="ty-title">
    <div class="container">
      <div class="hero-copy">
        <span class="ty-badge"><?php echo icon('check', 32); ?></span>
        <span class="eyebrow">Request sent</span>
        <h1 class="hero-title" id="ty-title">Thanks. Your request is with <span class="text-accent"><?php echo e($siteName); ?></span></h1>
        <p class="hero-answer">Your details went straight to Dellona Electric in Reedsburg, and the company will call you back at the number you entered to talk through the job. If it can't wait, or you want to add something you forgot, call <?php echo e($phone); ?> now.</p>
        <div class="hero-actions">
          <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
          <a class="link-call" href="/">Back to the homepage</a>
        </div>
      </div>
    </div>
  </section>

  <section class="section ty-next" aria-labelledby="ty-next-title">
    <div class="container-wide">
      <div class="ty-next__grid">
        <div>
          <div class="ty-head">
            <span class="eyebrow">What to expect</span>
            <h2 id="ty-next-title">What happens now that you've contacted Dellona Electric?</h2>
            <p class="answer-block">Dellona Electric has your request with the service and details you entered. The next step is a call back to ask a few questions and set a time to look at the job, and nothing goes ahead until you decide it should.</p>
          </div>
          <ol class="ty-steps">
            <li><div><h3>Your request is in</h3><p>It reached <?php echo e($siteName); ?> with your name, phone, email and the details you typed.</p></div></li>
            <li><div><h3>You get a call back</h3><p>To ask a few questions about the job and set a time to look at the panel, wiring or space.</p></div></li>
            <li><div><h3>You decide</h3><p>Go ahead when you are ready. Requesting an estimate carries no obligation.</p></div></li>
          </ol>
        </div>
        <aside class="ty-side" aria-label="While you wait">
          <div class="ty-card ty-card--call">
            <h3>Is something sparking, smoking or hot?</h3>
            <p>Don't wait for the call back. Shut the power off at the breaker if it is safe to, call 911 for fire or smoke, then call <?php echo e($phone); ?>.</p>
            <a class="btn btn-accent btn-block" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call now</a>
          </div>
          <div class="ty-card ty-card--review">
            <span class="ty-stars" aria-hidden="true"><?php echo str_repeat(icon('star', 18), 5); ?></span>
            <h3>Happy with our work?</h3>
            <p>If Dellona Electric has worked for you before, a Google review helps your neighbors in Reedsburg find a local electrician.</p>
            <a class="btn btn-secondary btn-block" href="<?php echo e($reviewRequestUrl); ?>" target="_blank" rel="noopener">Leave us a Google review</a>
          </div>
        </aside>
      </div>
    </div>
  </section>

  <?php if ($tyServices): ?>
  <section class="section ty-more edge-curve-top" aria-labelledby="ty-more-title">
    <div class="container">
      <div class="ty-head">
        <span class="eyebrow">While you wait</span>
        <h2 id="ty-more-title">Want to read up on the job before the call?</h2>
        <p class="answer-block">Each Dellona Electric service page explains the signs to look for, what the work involves and the questions to ask, so you can go into the call back knowing what to mention.</p>
      </div>
      <ul class="ty-chips">
        <?php foreach ($tyServices as $tySvc): ?>
        <li><a href="<?php echo e($tySvc[0]); ?>"><?php echo icon($tySvc[2], 18); ?> <?php echo e($tySvc[1]); ?></a></li>
        <?php endforeach; ?>
        <?php if (p1_page_exists('/services/')): ?><li><a href="/services/"><?php echo icon('layers', 18); ?> All <?php echo count($services); ?> services</a></li><?php endif; ?>
        <?php if (p1_page_exists('/faq/')): ?><li><a href="/faq/"><?php echo icon('message-square', 18); ?> Common questions</a></li><?php endif; ?>
      </ul>
    </div>
  </section>
  <?php endif; ?>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
