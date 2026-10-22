<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * 404.php — served by ErrorDocument 404 (.htaccess). Sends a real 404 status,
 * noindex. "Search" is server-side PHP (no JS, no search service): the visitor's
 * ?q= — or, on first load, the words in the broken URL — is matched against the
 * service registry and the main pages, and the best matches are suggested.
 * ------------------------------------------------------------------------- */
http_response_code(404);

$pageTitle       = 'Page Not Found | Dellona Electric Electrician, Reedsburg, WI';
$pageDescription = 'That page is not on the Dellona Electric site. Search the electrical services, or call (608) 477-8453 to reach the Reedsburg, WI electrician directly.';
$canonicalUrl    = $siteUrl . '/404';
$currentPage     = '404';
$pageType        = 'other';
$noindex         = true;

$phoneHref = 'tel:' . $phoneRaw;

/* Search corpus: every service page plus the main pages, only where the page exists. */
$nfPages = [];
foreach ($services as $nfSvc) {
    $nfPages[] = ['name' => $nfSvc['name'], 'href' => '/services/' . $nfSvc['slug'] . '/', 'desc' => $nfSvc['description'],
                  'hay' => strtolower($nfSvc['name'] . ' ' . $nfSvc['slug'] . ' ' . implode(' ', $nfSvc['keywords']) . ' ' . $nfSvc['description'])];
}
foreach ([
    ['All services', '/services/', 'Every electrical service Dellona Electric offers, grouped by repairs, installs and new builds.', 'services electrical electrician list all'],
    ['About Dellona Electric', '/about/', 'Who owns and runs the company, and the jobs behind the photos.', 'about owner company team history story crew license credentials'],
    ['Frequently asked questions', '/faq/', 'Service area, permits, pricing and what happens after you call.', 'faq questions price pricing cost permit area hours'],
    ['Contact', '/contact/', 'Phone, email, address, map and the full estimate form.', 'contact phone email address map directions estimate quote form'],
    ['Privacy Policy', '/privacy-policy/', 'How information from the website and forms is handled.', 'privacy policy data ccpa'],
] as $nfStatic) {
    $nfPages[] = ['name' => $nfStatic[0], 'href' => $nfStatic[1], 'desc' => $nfStatic[2], 'hay' => strtolower($nfStatic[0] . ' ' . $nfStatic[3])];
}
$nfPages = array_values(array_filter($nfPages, function ($p) { return p1_page_exists($p['href']); }));

$nfQuery     = trim(substr((string) ($_GET['q'] ?? ''), 0, 80));
$nfFromUrl   = $nfQuery === '';
$nfTermsText = $nfFromUrl ? str_replace(['/', '-', '_', '.php', '.html'], ' ', currentPath()) : $nfQuery;
$nfTerms     = array_values(array_filter(preg_split('/[^a-z0-9]+/', strtolower($nfTermsText)), function ($t) {
    return strlen($t) >= 3 && !in_array($t, ['the', 'and', 'for', 'www', 'index', 'page', 'php', 'html', '404'], true);
}));
$nfResults = [];
if ($nfTerms) {
    foreach ($nfPages as $nfPage) {
        $nfScore = 0;
        foreach ($nfTerms as $nfTerm) {
            if (strpos($nfPage['hay'], $nfTerm) !== false) $nfScore += 2;
            elseif (strlen($nfTerm) >= 5 && strpos($nfPage['hay'], substr($nfTerm, 0, 4)) !== false) $nfScore += 1;   // panel/panels, wire/wiring
        }
        if ($nfScore > 0) $nfResults[] = ['score' => $nfScore] + $nfPage;
    }
    usort($nfResults, function ($a, $b) { return $b['score'] <=> $a['score']; });
    $nfResults = array_slice($nfResults, 0, 5);
}

/* Popular pages grid. */
$nfPopular = array_values(array_filter([
    ['/services/', 'All electrical services', 'layers'],
    ['/services/electrical-repair/', 'Electrical repair', 'wrench'],
    ['/services/panel-upgrades/', 'Panel repair & upgrades', 'zap'],
    ['/services/ev-charger-installation/', 'EV charger installation', 'battery-charging'],
    ['/services/generator-installation/', 'Generator installation', 'power'],
    ['/about/', 'About Dellona Electric', 'users'],
    ['/faq/', 'Common questions', 'message-square'],
    ['/contact/', 'Contact & directions', 'map-pin'],
], function ($p) { return p1_page_exists($p[0]); }));
?>
<?php ob_start(); ?>
<style>
/* ==== 404 — page composition: outlined numeral hero with search, suggestion list,
   tinted popular-page tiles, closing CTA ==== */
.pg-404 h1, .pg-404 h2, .pg-404 h3 { text-wrap: balance; }
.pg-404 .nf-hero { position: relative; isolation: isolate; overflow: clip; background: linear-gradient(120deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 120%); }
.pg-404 .nf-hero::before { content: ""; position: absolute; z-index: -1; pointer-events: none; inset: -30% -10% -30% 40%; background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 22%, transparent), transparent 70%); }
.pg-404 .nf-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.55'/%3E%3C/svg%3E");
}
.pg-404 .nf-hero__grid { display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(0, .7fr); gap: clamp(1.5rem, 4vw, 3rem); align-items: center; }
.pg-404 .nf-hero .hero-copy { display: grid; gap: var(--space-4); }
.pg-404 .nf-hero h1 .text-accent { color: var(--color-accent-bright); }
.pg-404 .nf-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 86%, transparent); max-width: 36rem; }
.pg-404 .nf-hero code { font-size: var(--font-size-sm); padding: var(--space-1) var(--space-2); border-radius: var(--radius-sm); background: color-mix(in srgb, var(--color-white) 10%, transparent); color: var(--color-accent-bright); word-break: break-all; }
.pg-404 .nf-numeral { font-family: var(--font-accent); font-size: clamp(6rem, 4rem + 9vw, 12rem); line-height: .8; letter-spacing: .02em; color: transparent; -webkit-text-stroke: 2px color-mix(in srgb, var(--color-accent) 70%, transparent); text-align: right; user-select: none; }
.pg-404 .nf-numeral span { color: var(--color-accent); -webkit-text-stroke: 0; }
.pg-404 .nf-search { display: flex; gap: var(--space-2); max-width: 34rem; padding: var(--space-2); border-radius: var(--radius-lg); background: var(--color-surface); box-shadow: var(--shadow-lg); }
.pg-404 .nf-search label { flex: 1; display: flex; align-items: center; gap: var(--space-2); padding-left: var(--space-3); color: var(--color-muted); }
.pg-404 .nf-search input { flex: 1; min-width: 0; min-height: 46px; border: 0; background: transparent; font: inherit; font-size: var(--font-size-base); color: var(--color-ink); }
.pg-404 .nf-search input:focus { outline: none; }
.pg-404 .nf-search:focus-within { box-shadow: var(--shadow-lg), 0 0 0 3px color-mix(in srgb, var(--color-accent) 45%, transparent); }
.pg-404 .nf-crumbs { color: color-mix(in srgb, var(--color-white) 70%, transparent); }
.pg-404 .nf-crumbs ol { display: flex; flex-wrap: wrap; gap: var(--space-2); align-items: center; }
.pg-404 .nf-crumbs [aria-current] { color: var(--color-white); }
@media (max-width: 800px) { .pg-404 .nf-hero__grid { grid-template-columns: 1fr; } .pg-404 .nf-numeral { display: none; } }

/* -- Suggestions -- */
.pg-404 .nf-results { background: var(--color-paper); }
.pg-404 .nf-head { display: grid; gap: var(--space-3); max-width: 44rem; margin-bottom: var(--space-8); }
.pg-404 p.answer-block { font-size: var(--fs-lead); line-height: 1.55; color: var(--color-ink); margin: 0; }
.pg-404 .nf-list { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-3); max-width: 52rem; }
.pg-404 .nf-list a { text-decoration: none; display: grid; grid-template-columns: 1fr auto; gap: var(--space-1) var(--space-4); align-items: center; padding: var(--space-4) var(--space-5); background: var(--color-surface); border: 1px solid var(--color-line); border-left: 4px solid var(--color-accent); border-radius: var(--radius); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.pg-404 .nf-list a:hover { transform: translateX(4px); box-shadow: var(--shadow); }
.pg-404 .nf-list b { font-family: var(--font-heading); color: var(--color-ink); }
.pg-404 .nf-list span { grid-column: 1; font-size: var(--font-size-sm); color: var(--color-ink-2); }
.pg-404 .nf-list svg { grid-column: 2; grid-row: 1 / span 2; color: var(--color-accent-dark); }
.pg-404 .nf-empty { color: var(--color-ink-2); max-width: 52rem; }

/* -- Popular pages: tinted tiles -- */
.pg-404 .nf-popular { background: var(--color-surface); }
.pg-404 .nf-tiles { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-4); }
.pg-404 .nf-tiles a { text-decoration: none; display: grid; gap: var(--space-3); padding: var(--space-6); border-radius: var(--radius-lg); border: 1px solid var(--color-line); min-height: 100%; transition: transform var(--transition), box-shadow var(--transition); }
.pg-404 .nf-tiles a:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.pg-404 .nf-tiles a:hover .nf-tile__icon { transform: rotate(-8deg) scale(1.08); }
.pg-404 .nf-tile__icon { width: 44px; height: 44px; border-radius: var(--radius); display: grid; place-items: center; background: var(--color-surface); color: var(--color-accent-dark); box-shadow: var(--shadow-sm); transition: transform var(--transition); }
.pg-404 .nf-tiles b { font-family: var(--font-heading); color: var(--color-ink); }
@media (max-width: 1000px) { .pg-404 .nf-tiles { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 480px) { .pg-404 .nf-tiles { grid-template-columns: 1fr; } }

/* -- Closing CTA -- */
.pg-404 .nf-cta .container-wide { display: grid; grid-template-columns: minmax(0, 1.3fr) auto; gap: var(--space-8); align-items: center; }
.pg-404 .nf-cta h2 { margin-bottom: var(--space-3); }
.pg-404 .nf-cta p { max-width: 58ch; margin: 0; }
.pg-404 .nf-cta .actions { display: flex; flex-wrap: wrap; gap: var(--space-3); }
@media (max-width: 800px) { .pg-404 .nf-cta .container-wide { grid-template-columns: 1fr; } }
@media (prefers-reduced-motion: reduce) { .pg-404 .nf-list a, .pg-404 .nf-tiles a, .pg-404 .nf-tile__icon { transition: none; transform: none; } }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-404">

  <section class="hero hero--interior nf-hero" aria-labelledby="nf-title">
    <div class="container">
      <nav class="breadcrumb nf-crumbs" aria-label="Breadcrumb"><ol><li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li><li><span aria-current="page">Page not found</span></li></ol></nav>
      <div class="nf-hero__grid">
        <div class="hero-copy">
          <span class="eyebrow">Error 404</span>
          <h1 class="hero-title" id="nf-title">That page has <span class="text-accent">no power</span> right now</h1>
          <p class="hero-answer">The address <code><?php echo e(currentPath()); ?></code> isn't a page on the Dellona Electric site. It may have moved, or the link may have a typo. Search the electrical services below, pick a popular page, or call <?php echo e($phone); ?> to reach the Reedsburg electrician directly.</p>
          <form class="nf-search" method="get" role="search" aria-label="Search the site">
            <label for="nf-q"><?php echo icon('search', 18); ?><span class="sr-only">Search the site</span>
              <input id="nf-q" type="search" name="q" value="<?php echo e($nfQuery); ?>" placeholder="Try “panel”, “EV charger” or “generator”" autocomplete="off">
            </label>
            <button type="submit" class="btn btn-primary">Search</button>
          </form>
        </div>
        <div class="nf-numeral" aria-hidden="true">4<span>0</span>4</div>
      </div>
    </div>
  </section>

  <section class="section nf-results" aria-labelledby="nf-results-title">
    <div class="container">
      <div class="nf-head">
        <span class="eyebrow"><?php echo $nfFromUrl ? 'Suggestions' : 'Search results'; ?></span>
        <h2 id="nf-results-title"><?php echo $nfFromUrl ? 'Were you looking for one of these pages?' : 'Which pages match “' . e($nfQuery) . '”?'; ?></h2>
      </div>
      <?php if ($nfResults): ?>
      <ul class="nf-list">
        <?php foreach ($nfResults as $nfRes): ?>
        <li><a href="<?php echo e($nfRes['href']); ?>"><b><?php echo e($nfRes['name']); ?></b><span><?php echo e($nfRes['desc']); ?></span><?php echo icon('arrow-right', 20); ?></a></li>
        <?php endforeach; ?>
      </ul>
      <?php else: ?>
      <p class="nf-empty"><?php echo $nfFromUrl ? 'Nothing on the site matches that address closely.' : 'No page matches that search.'; ?> Try a shorter word such as “outlet”, “lighting” or “panel”, or use one of the popular pages below.</p>
      <?php endif; ?>
    </div>
  </section>

  <section class="section nf-popular edge-curve-top" aria-labelledby="nf-popular-title">
    <div class="container">
      <div class="nf-head">
        <span class="eyebrow">Popular pages</span>
        <h2 id="nf-popular-title">Where do most visitors go on the Dellona Electric site?</h2>
        <p class="answer-block">Most visitors to the Dellona Electric site head for the full services list, one of the repair and install pages, or the contact page with the phone number, map and estimate form.</p>
      </div>
      <ul class="nf-tiles">
        <?php foreach ($nfPopular as $nfI => $nfPop): ?>
        <li><a class="card-tint-<?php echo ($nfI % 3) + 1; ?>" href="<?php echo e($nfPop[0]); ?>"><span class="nf-tile__icon"><?php echo icon($nfPop[2], 22); ?></span><b><?php echo e($nfPop[1]); ?></b></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <section class="closing-cta nf-cta texture-grain slant-top" aria-labelledby="nf-cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide">
      <div>
        <span class="eyebrow">Skip the search</span>
        <h2 id="nf-cta-title">Need an electrician in Reedsburg?</h2>
        <p>Call <?php echo e($phone); ?> and describe the job, or send the estimate form. <?php echo e($siteName); ?> will call you back to talk it through.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <a class="btn btn-outline-white btn-lg" href="/">Back to the homepage</a>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
