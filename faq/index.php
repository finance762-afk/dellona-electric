<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /faq/ — Phase 5. 18 questions in four categories (General, Services, Pricing,
 * Process). Visible FAQ text only — NO FAQPage JSON-LD (QA blocker since 2026-10-20).
 * Answers use only intake / config.php facts, the client photos and what the service
 * pages already state. Licence, insurance, hours, emergency availability, free
 * estimates and prices are unconfirmed, so those questions are left off and listed in
 * /content-confirmations.json instead of being answered with a guess.
 * Sources: City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php';

$pageTitle       = 'Electrician FAQ for Reedsburg, WI | Dellona Electric';
$pageDescription = 'Answers from Dellona Electric in Reedsburg, WI on service area, EV chargers, generators, panel upgrades, permits, pricing and what happens after you call.';
$canonicalUrl    = $siteUrl . '/faq/';
$currentPage     = 'faq';
$pageType        = 'faq';
$ogImage         = '/assets/images/panel-work-basement-v1.jpg';

$phoneHref = 'tel:' . $phoneRaw;

/** Internal link that renders only when the target page exists (link-integrity rule). */
$faqLink = function (string $href, string $text): string {
    return p1_page_exists($href) ? '<a href="' . e($href) . '">' . e($text) . '</a>' : e($text);
};
$faqServiceNames = implode(', ', array_map(function ($s) { return $s['name']; }, array_slice($services, 0, -1)))
                 . ' and ' . end($services)['name'];

/* Answers are HTML (author-controlled); every interpolated value is escaped. */
$faqCategories = [
    'general' => [
        'label' => 'General', 'icon' => 'info',
        'title' => 'Who is Dellona Electric and where does it work?',
        'intro' => 'Dellona Electric is an electrical company in Reedsburg, Wisconsin, owned by ' . e($ownerName) . ' and working since ' . (int) $yearEstablished . '. It serves homes, new construction and businesses in Reedsburg and the surrounding ' . e($serviceAreas[0]['county']) . ' County area.',
        'items' => [
            ['q' => 'Where is Dellona Electric based?',
             'a' => 'Dellona Electric is based at ' . e($address['street']) . ', ' . e($address['city']) . ', ' . e($address['state']) . ' ' . e($address['zip']) . '. The company is owned by ' . e($ownerName) . '. Most of the work happens at customers\' homes and businesses, so call <a href="' . e($phoneHref) . '">' . e($phone) . '</a> before stopping by.'],
            ['q' => 'Does Dellona Electric serve the area around Reedsburg?',
             'a' => 'Yes. Dellona Electric works in Reedsburg and the surrounding ' . e($serviceAreas[0]['county']) . ' County area. If your property is farther out, call ' . e($phone) . ' with the address and you will get a straight answer on whether the job is in range.'],
            ['q' => 'How long has Dellona Electric been in business?',
             'a' => 'Dellona Electric has been in business since ' . (int) $yearEstablished . ', which makes ' . (int) $yearsInBusiness . ' years in ' . date('Y') . ', all of them in Reedsburg under the same name and phone number. ' . $faqLink('/about/', 'The About page') . ' covers who runs the company and the kinds of jobs it has done.'],
            ['q' => 'Does Dellona Electric work on homes, businesses or both?',
             'a' => 'Both. Dellona Electric repairs and upgrades wiring in existing homes, wires new houses, garages, additions and outbuildings, and handles ' . $faqLink('/services/commercial-electrical/', 'commercial electrical work') . ' such as lighting and repairs for restaurants, shops and offices.'],
        ],
    ],
    'services' => [
        'label' => 'Services', 'icon' => 'zap',
        'title' => 'Which electrical jobs can Dellona Electric handle?',
        'intro' => 'Dellona Electric offers ' . count($services) . ' electrical services, from outlet and switch repair to panel upgrades, EV chargers, standby generators and new-construction wiring. The questions below cover the jobs Reedsburg customers ask about most.',
        'items' => [
            ['q' => 'Which electrical services does Dellona Electric offer?',
             'a' => 'Dellona Electric offers ' . count($services) . ' services: ' . e($faqServiceNames) . '. Each one has its own page on the ' . $faqLink('/services/', 'services page') . ', with signs to look for and what the job involves.'],
            ['q' => 'Can Dellona Electric install an EV charger in my garage?',
             'a' => 'Yes. Dellona Electric installs Level 2 home EV chargers, like the JuiceBox shown on this site, on a dedicated 240-volt circuit. The first step is checking whether your panel has room for that circuit or needs an upgrade. More on the ' . $faqLink('/services/ev-charger-installation/', 'EV charger installation page') . '.'],
            ['q' => 'Does Dellona Electric install standby generators?',
             'a' => 'Yes. Dellona Electric wires standby generators, like the Kohler unit at a log home in the crew\'s photos, and portable generator hookups. Each one goes in with a transfer switch or interlock, which keeps generator power separate from the utility line during an outage. See ' . $faqLink('/services/generator-installation/', 'generator installation') . '.'],
            ['q' => 'How do I know if my electrical panel needs an upgrade?',
             'a' => 'The common signs are breakers that trip again right after a reset, a panel that buzzes or feels warm, and a panel with no empty slots. Adding an EV charger, a heat pump or an addition can also mean the panel has run out of room. The ' . $faqLink('/services/panel-upgrades/', 'panel repair and upgrades page') . ' explains repair versus replacement.'],
            ['q' => 'Does Dellona Electric wire new homes, additions and outbuildings?',
             'a' => 'Yes. Dellona Electric wires new houses, additions, garages and outbuildings from rough-in through final, including the outlet and lighting layout. The night photo of a new garage with its exterior lights on is one of those jobs. See ' . $faqLink('/services/new-construction-wiring/', 'new construction wiring') . '.'],
            ['q' => 'What does whole-house surge protection do?',
             'a' => 'A whole-house surge protector is a device mounted at your main panel that limits voltage spikes before they reach every circuit in the house, protecting furnaces, air conditioners, appliances and electronics. It works best paired with point-of-use surge strips for computers and TVs. See ' . $faqLink('/services/surge-protection/', 'whole-house surge protection') . '.'],
        ],
    ],
    'pricing' => [
        'label' => 'Pricing', 'icon' => 'clipboard-list',
        'title' => 'How does pricing work for an electrical job?',
        'intro' => 'Electrical prices depend on the job itself: how many circuits are involved, what the panel can carry and how far new wire has to run. Dellona Electric looks at what is there before pricing the work, and these answers explain what moves the number.',
        'items' => [
            ['q' => 'How much does an electrical repair or installation cost?',
             'a' => 'It depends on the job: how many circuits are involved, the age and capacity of your panel, and how far new wiring has to run. Describe the work on the estimate form or call ' . e($phone) . ', and Dellona Electric will talk through what the job involves and how it is priced.'],
            ['q' => 'What affects the price of a panel upgrade or EV charger install?',
             'a' => 'Four things matter most: whether your panel and electrical service have spare capacity, the distance from the panel to where the new equipment goes, how easy it is to run wire through the walls or ceilings in between, and whether the job needs a permit and inspection. A full panel or an undersized service adds an upgrade to the job.'],
            ['q' => 'What should I include in an estimate request?',
             'a' => 'Say what is happening or what you want added, when it started, and which rooms or circuits are involved. If you know them, add the age of the house, where the panel is and anything you are planning soon, such as a charger, an addition or a generator. That lets the call-back go straight to the useful questions.'],
        ],
    ],
    'process' => [
        'label' => 'Process', 'icon' => 'route',
        'title' => 'What happens before, during and after an electrical job?',
        'intro' => 'A Dellona Electric job starts with a call or the estimate form, moves to a look at the panel, wiring and space, and ends with you being shown what was done. These answers cover permits, safety and how to get ready.',
        'items' => [
            ['q' => 'What happens after I send the estimate form?',
             'a' => 'Your request goes to Dellona Electric with the service and details you entered. You get a call back to answer a few questions about the job and set a time to look at it. Then you decide; requesting an estimate carries no obligation.'],
            ['q' => 'Do electrical repairs and upgrades need a permit in Reedsburg?',
             'a' => 'Often, yes. Panel upgrades, service changes, new circuits and new-construction wiring commonly need an electrical permit and inspection in Wisconsin. Inside city limits these go through the <a href="https://www.reedsburgwi.gov/buildingsafety" target="_blank" rel="noopener">City of Reedsburg Building Inspection</a> department; outside the city the process depends on the town. Ask when you call and you will hear whether your job needs one.'],
            ['q' => 'What should I do if a breaker keeps tripping or an outlet feels warm?',
             'a' => 'Stop using that circuit: unplug what is on it, leave the breaker off and do not keep resetting it. A breaker that trips again right away, or an outlet that is warm, discolored or buzzing, usually means an overload or a loose connection that needs repair. If you smell burning or see smoke, get out and call 911. See ' . $faqLink('/services/electrical-repair/', 'electrical repair') . '.'],
            ['q' => 'What counts as an electrical emergency?',
             'a' => 'Smoke, sparks, a burning smell, heat at an outlet or the panel, and water near anything electrical all need attention right away, as do lights that brighten in one room while they dim in another. Call 911 for fire, your utility for downed lines or a damaged meter, and an electrician for faults inside the building. See ' . $faqLink('/services/emergency-electrician/', 'emergency electrical repair') . '.'],
            ['q' => 'How can I get ready for an electrician\'s visit?',
             'a' => 'Clear a path to the electrical panel and to the area where the work will happen, and put pets in another room. Make a note of which outlets, lights or breakers act up and when, plus anything that changed recently, such as a new appliance or a remodel. Those details make the diagnosis faster.'],
        ],
    ],
];
$faqCount = array_sum(array_map(function ($c) { return count($c['items']); }, $faqCategories));

/* WebPage + BreadcrumbList only. FAQ content stays visible text — never FAQPage JSON-LD. */
$schemaGraph = [generateWebPageSchema($pageTitle, $pageDescription, $canonicalUrl, $ogImage)];
$schemaGraph[0]['speakable'] = ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']];
$faqCrumbs = generateBreadcrumbSchema([['name' => 'FAQ', 'url' => '/faq/']]);
unset($faqCrumbs['@context']);
$schemaGraph[] = $faqCrumbs;
$schemaMarkup = ['@graph' => $schemaGraph];
?>
<?php ob_start(); ?>
<?php echo p1_cta_band_css(); ?>
<style>
/* ==== /faq/ — page composition: type-led hero with category index, sticky category
   rails, numbered accordion rows, alternating bands ==== */
.pg-faq h1, .pg-faq h2, .pg-faq h3 { text-wrap: balance; }

/* -- C1.4 page hero: type-led, glow + grain, category index on the right -- */
.pg-faq .fq-hero { position: relative; isolation: isolate; overflow: clip; background: linear-gradient(110deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 120%); }
.pg-faq .fq-hero::before {
  content: ""; position: absolute; z-index: -1; pointer-events: none; inset: 10% -15% -50% 50%;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 22%, transparent), transparent 70%);
}
.pg-faq .fq-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.55'/%3E%3C/svg%3E");
}
.pg-faq .fq-hero__grid { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, .8fr); gap: clamp(2rem, 5vw, 4rem); align-items: end; }
.pg-faq .fq-hero .hero-copy { display: grid; gap: var(--space-4); }
.pg-faq .fq-hero h1 .text-accent { color: var(--color-accent-bright); }
.pg-faq .fq-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 86%, transparent); max-width: 36rem; }
.pg-faq .fq-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.pg-faq .fq-hero .link-call svg { color: var(--color-accent-bright); }
.pg-faq .fq-crumbs { color: color-mix(in srgb, var(--color-white) 70%, transparent); }
.pg-faq .fq-crumbs ol { display: flex; flex-wrap: wrap; gap: var(--space-2); align-items: center; }
.pg-faq .fq-crumbs [aria-current] { color: var(--color-white); }
.pg-faq .fq-crumbs a:hover { color: var(--color-white); text-decoration: underline; }
.pg-faq .fq-index { list-style: none; margin: 0; padding: var(--space-2); display: grid; gap: var(--space-1); border-radius: var(--radius-lg); background: color-mix(in srgb, var(--color-white) 6%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); backdrop-filter: blur(8px); }
.pg-faq .fq-index a { text-decoration: none; display: grid; grid-template-columns: 40px 1fr auto; gap: var(--space-3); align-items: center; padding: var(--space-3); border-radius: var(--radius); color: var(--color-white); transition: background var(--transition); }
.pg-faq .fq-index a:hover { background: color-mix(in srgb, var(--color-white) 10%, transparent); }
.pg-faq .fq-index__icon { width: 40px; height: 40px; border-radius: var(--radius); display: grid; place-items: center; background: color-mix(in srgb, var(--color-accent) 20%, transparent); color: var(--color-accent-bright); }
.pg-faq .fq-index b { font-family: var(--font-heading); }
.pg-faq .fq-index small { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: color-mix(in srgb, var(--color-white) 65%, transparent); }
@media (max-width: 900px) { .pg-faq .fq-hero__grid { grid-template-columns: 1fr; } }

/* -- Category sections: sticky rail with a large numeral, accordion column -- */
.pg-faq .fq-cat { scroll-margin-top: var(--nav-height); }
.pg-faq .fq-cat--general, .pg-faq .fq-cat--pricing { background: var(--color-paper); }
.pg-faq .fq-cat--services { background: var(--color-surface); }
.pg-faq .fq-cat--process { background: var(--color-paper-2); }
.pg-faq .fq-cat__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.2fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.pg-faq .fq-rail { position: sticky; top: calc(var(--nav-height) + var(--space-6)); display: grid; gap: var(--space-3); }
.pg-faq .fq-rail__num { font-family: var(--font-accent); font-size: clamp(3rem, 2rem + 3vw, 4.6rem); line-height: .85; color: transparent; -webkit-text-stroke: 2px var(--color-accent); }
.pg-faq .fq-rail p.answer-block { font-size: var(--fs-body); line-height: 1.6; color: var(--color-ink-2); margin: 0; }
.pg-faq .fq-rail .btn { justify-self: start; margin-top: var(--space-2); }
.pg-faq .fq-list { counter-reset: fq; border-bottom: 1px solid var(--color-line); }
.pg-faq .fq-list .faq { counter-increment: fq; padding: 0; transition: background var(--transition); }
.pg-faq .fq-list .faq summary { padding: var(--space-5) var(--space-2) var(--space-5) 0; gap: var(--space-4); }
.pg-faq .fq-list .faq summary::before { content: counter(fq, decimal-leading-zero); flex: 0 0 auto; width: 2.4rem; font-family: var(--font-accent); font-size: var(--font-size-lg); color: var(--color-muted); transition: color var(--transition); }
.pg-faq .fq-list .faq summary h3 { flex: 1; margin: 0; font-size: var(--font-size-lg); line-height: 1.35; }
.pg-faq .fq-list .faq[open] summary::before, .pg-faq .fq-list .faq summary:hover::before { color: var(--color-accent-dark); }
.pg-faq .fq-list .faq[open] { background: linear-gradient(90deg, var(--color-card-tint-3), transparent 70%); }
.pg-faq .fq-list .faq p { margin: 0; padding: 0 var(--space-6) var(--space-6) calc(2.4rem + var(--space-4)); font-size: var(--fs-body); line-height: 1.65; max-width: 64ch; }
.pg-faq .fq-list .faq p a { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-decoration-color: var(--color-accent); text-decoration-thickness: 2px; text-underline-offset: 3px; }
@media (max-width: 900px) { .pg-faq .fq-cat__grid { grid-template-columns: 1fr; } .pg-faq .fq-rail { position: static; } }
@media (max-width: 560px) { .pg-faq .fq-list .faq p { padding-left: 0; padding-right: 0; } .pg-faq .fq-list .faq summary::before { width: 1.8rem; } }

/* -- C9.2 closing CTA -- */
.pg-faq .fq-cta .container-wide { display: grid; grid-template-columns: minmax(0, 1.3fr) auto; gap: var(--space-8); align-items: center; }
.pg-faq .fq-cta h2 { max-width: 26ch; margin-bottom: var(--space-3); }
.pg-faq .fq-cta p { max-width: 58ch; margin: 0; }
.pg-faq .fq-cta .actions { display: flex; flex-wrap: wrap; gap: var(--space-3); }
@media (max-width: 800px) { .pg-faq .fq-cta .container-wide { grid-template-columns: 1fr; } }

@media (prefers-reduced-motion: reduce) { .pg-faq .fq-index a, .pg-faq .fq-list .faq { transition: none; } }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-faq">

  <!-- HERO — C1.4 type-led page hero with category index -->
  <section class="hero hero--interior fq-hero" aria-labelledby="faq-title">
    <div class="container">
      <nav class="breadcrumb fq-crumbs" aria-label="Breadcrumb"><ol><li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li><li><span aria-current="page">FAQ</span></li></ol></nav>
      <div class="fq-hero__grid">
        <div class="hero-copy">
          <span class="eyebrow">Common questions · <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
          <h1 class="hero-title" id="faq-title">Electrician questions, answered by <span class="text-accent"><?php echo e($siteName); ?></span></h1>
          <p class="hero-answer">These are straight answers from Dellona Electric, the Reedsburg electrical company owned by <?php echo e($ownerName); ?>, on the service area, EV chargers, generators, panel upgrades, permits, how pricing works and what happens after you call. If your question isn't here, call <?php echo e($phone); ?>.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-accent btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
        </div>
        <nav aria-label="FAQ categories">
          <ul class="fq-index">
            <?php foreach ($faqCategories as $fqKey => $fqCat): ?>
            <li><a href="#<?php echo e($fqKey); ?>"><span class="fq-index__icon"><?php echo icon($fqCat['icon'], 20); ?></span><span><small><?php echo count($fqCat['items']); ?> questions</small><br><b><?php echo e($fqCat['label']); ?></b></span><?php echo icon('chevron-right', 18); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </nav>
      </div>
    </div>
  </section>

  <?php $fqN = 0; foreach ($faqCategories as $fqKey => $fqCat): $fqN++; ?>
  <section class="section fq-cat fq-cat--<?php echo e($fqKey); ?><?php echo $fqKey === 'services' ? ' edge-curve-top' : ($fqKey === 'process' ? ' edge-wave-top' : ''); ?>" id="<?php echo e($fqKey); ?>" aria-labelledby="<?php echo e($fqKey); ?>-title">
    <div class="container-wide">
      <div class="fq-cat__grid">
        <div class="fq-rail <?php echo $fqN % 2 ? 'reveal-left' : 'reveal-right'; ?>">
          <span class="fq-rail__num" aria-hidden="true"><?php echo sprintf('%02d', $fqN); ?></span>
          <span class="eyebrow"><?php echo e($fqCat['label']); ?></span>
          <h2 id="<?php echo e($fqKey); ?>-title"><?php echo e($fqCat['title']); ?></h2>
          <p class="answer-block"><?php echo $fqCat['intro']; ?></p>
          <?php if ($fqKey === 'services' && p1_page_exists('/services/')): ?><a class="btn btn-secondary btn-sm" href="/services/">All <?php echo count($services); ?> services</a><?php endif; ?>
        </div>
        <div class="fq-list reveal-up">
          <?php foreach ($fqCat['items'] as $fqI => $fqItem): ?>
          <details class="faq"<?php echo $fqI === 0 ? ' open' : ''; ?>>
            <summary><h3><?php echo e($fqItem['q']); ?></h3></summary>
            <p><?php echo $fqItem['a']; ?></p>
          </details>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
  <?php if ($fqKey === 'general') echo p1_cta_band('Already know what you need?', 'Skip the reading. Send the basics and ' . $siteName . ' will call you back about the job.'); ?>
  <?php endforeach; ?>

  <!-- CLOSING CTA — C9.2 -->
  <section class="closing-cta fq-cta texture-grain slant-top" aria-labelledby="fq-cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Still wondering?</span>
        <h2 id="fq-cta-title">Didn't see your question about electrical work?</h2>
        <p>Call <?php echo e($phone); ?> or email <?php echo e($email); ?> and ask it. <?php echo e($siteName); ?> answers questions about a job before you commit to anything, from whether it needs a permit to whether your panel can take a charger.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
