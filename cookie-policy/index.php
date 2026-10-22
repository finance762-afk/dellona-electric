<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /cookie-policy/ — Phase 5, legal-compliance.md Cookie Policy template, listing what
 * this build actually sets: p1_ft (includes/attribution.php, first-party, httpOnly,
 * 30 days), cookieBannerDismissed_v1 (localStorage, assets/js/main.js), GA4 _ga/_ga_*
 * only once $googleAnalyticsId is configured, Google Maps on /contact/ only.
 * Fonts are self-hosted (no Google Fonts requests); no ad pixels are installed.
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-helpers.php';

/* Section 1 variable block — populated from config.php / build-plan.json */
$companyEntityType = '';            // NOT in intake — see content-confirmations.json
$companyName       = trim($siteName . ($companyEntityType !== '' ? ' ' . $companyEntityType : ''));
$companyState      = 'Wisconsin';
$companyEmail      = $email;
$companyPhone      = $phone;
$companyPhoneE164  = $phoneRaw;
$companyAddress    = $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
$lastUpdated       = $legalUpdated;

$pageTitle       = 'Cookie Policy | Dellona Electric Electrician, Reedsburg, WI';
$pageDescription = 'The cookies the Dellona Electric website in Reedsburg, WI uses, what each does, how long it lasts and how to control it. Questions? Call (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/cookie-policy/';
$ogImage         = $ogImageDefault;
$currentPage     = 'cookie-policy';
$pageType        = 'other';
$schemaMarkup    = p1_legal_schema($pageTitle, $pageDescription, $canonicalUrl, 'Cookie Policy', '/cookie-policy/');

$ckRows = [
    ['p1_ft', 'Necessary / functional', 'First-party', 'Remembers how you first reached the site (landing page, referring site, campaign tags, a random visit ID, device type) so an estimate request can be credited to the right page and source.', '30 days'],
    ['cookieBannerDismissed_v1', 'Necessary', 'First-party (browser local storage)', 'Remembers that you dismissed the cookie notice so it is not shown again.', 'Until you clear site data'],
    ['_ga, _ga_*', 'Analytics', 'First-party, set by Google Analytics 4', 'Distinguishes visits and counts page views. Only set if we have Google Analytics turned on.', 'Up to 2 years'],
    ['Google Maps cookies', 'Third-party embed', 'Google', 'Set by Google when the map on our contact page loads, under Google\'s own privacy policy.', 'Set by Google'],
];
$ckSections = [
    'what'     => 'What are cookies?',
    'used'     => 'Cookies we use',
    'not-used' => 'What we don\'t use',
    'control'  => 'How to control cookies',
    'ga-optout'=> 'Opt out of Google Analytics',
    'notice'   => 'Our cookie notice',
    'changes'  => 'Changes to this policy',
    'contact'  => 'Contact us',
];
?>
<?php ob_start(); ?>
<?php echo p1_legal_page_css(); ?>
<style>
/* ==== /cookie-policy/ — cookie inventory table ==== */
.pg-cookies .ck-table-wrap { margin: 0 0 var(--space-6); overflow-x: auto; border: 1px solid var(--color-line); border-radius: var(--radius-lg); background: var(--color-surface); box-shadow: var(--shadow-sm); }
.pg-cookies .ck-table { width: 100%; min-width: 620px; border-collapse: collapse; font-size: var(--font-size-sm); }
.pg-cookies .ck-table th, .pg-cookies .ck-table td { text-align: left; vertical-align: top; padding: var(--space-3) var(--space-4); border-bottom: 1px solid var(--color-line); line-height: 1.5; }
.pg-cookies .ck-table thead th { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-muted); background: var(--color-paper-2); }
.pg-cookies .ck-table tbody th { font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-weight: 600; color: var(--color-ink); white-space: nowrap; }
.pg-cookies .ck-table td { color: var(--color-ink-2); }
.pg-cookies .ck-table tbody tr:last-child th, .pg-cookies .ck-table tbody tr:last-child td { border-bottom: 0; }
.pg-cookies .ck-table tbody tr:hover > * { background: var(--color-card-tint-3); }
.pg-cookies .ck-tag { display: inline-block; padding: var(--space-1) var(--space-2); border-radius: var(--radius-sm); font-size: var(--font-size-xs); font-weight: 600; background: var(--color-card-tint-1); color: var(--color-ink); }
.pg-cookies .ck-table caption { caption-side: bottom; text-align: left; padding: var(--space-3) var(--space-4); font-size: var(--font-size-xs); color: var(--color-muted); }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-legal pg-cookies">

  <section class="hero hero--legal" aria-labelledby="legal-title">
    <div class="container">
      <div class="lg-hero__copy">
        <span class="eyebrow">Legal</span>
        <h1 id="legal-title">Cookie Policy</h1>
        <span class="section-subtitle">What this site stores, and why</span>
        <p><?php echo e('The cookies and similar technologies ' . $companyName . '\'s website uses, what each one does, how long it lasts and how you can control it.'); ?></p>
        <?php echo p1_legal_dates(); ?>
      </div>
    </div>
  </section>
  <?php echo p1_legal_breadcrumb('Cookie Policy'); ?>

  <section class="lg-body" aria-label="Cookie Policy text">
    <div class="container lg-layout">
      <?php echo p1_legal_toc($ckSections); ?>
      <article class="legal-prose content-narrow">

        <h2 id="what">1. What Are Cookies?</h2>
        <p>Cookies are small text files a website stores in your browser. Similar technologies, such as browser local storage, do the same job. They let a site remember things between pages and visits, and tell the site owner how visitors use it.</p>

        <h2 id="used">2. Cookies We Use</h2>
        <p>This is everything the <?php echo e($companyName); ?> website stores, or allows a third party to store, in your browser:</p>
        <div class="ck-table-wrap">
          <table class="ck-table">
            <caption>Google Analytics cookies appear only while analytics is enabled on this site.</caption>
            <thead><tr><th scope="col">Name</th><th scope="col">Type</th><th scope="col">Set by</th><th scope="col">Purpose</th><th scope="col">Lasts</th></tr></thead>
            <tbody>
              <?php foreach ($ckRows as $ckRow): ?>
              <tr><th scope="row"><?php echo e($ckRow[0]); ?></th><td><span class="ck-tag"><?php echo e($ckRow[1]); ?></span></td><td><?php echo e($ckRow[2]); ?></td><td><?php echo e($ckRow[3]); ?></td><td><?php echo e($ckRow[4]); ?></td></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <h3>Strictly necessary and functional</h3>
        <p>The <strong>p1_ft</strong> cookie is set by our own server on your first page view. It cannot be read by scripts in the page and is sent only to this website. Its contents travel with an estimate request so we know which page and source led to it. The cookie-notice flag lives in your browser's local storage and is never sent anywhere.</p>
        <h3>Analytics (Google Analytics 4)</h3>
        <p>When enabled, Google Analytics 4 uses the <strong>_ga</strong> and <strong>_ga_*</strong> cookies to count visits and see which pages are useful. Google Analytics 4 does not log or store full IP addresses.</p>
        <h3>Third-party embeds</h3>
        <p>The map on our <a href="/contact/">contact page</a> is provided by Google Maps. When it loads, Google may set its own cookies, governed by <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Google's Privacy Policy</a>.</p>

        <h2 id="not-used">3. What We Don't Use</h2>
        <ul>
          <li>No advertising or retargeting pixels are installed on this site.</li>
          <li>Our fonts are hosted on our own server, so loading a page sends no request to a font service.</li>
          <li>We do not sell information collected through cookies.</li>
        </ul>

        <h2 id="control">4. How to Control Cookies</h2>
        <p>Every major browser lets you view, delete and block cookies and clear local storage, either for all sites or just this one. Blocking third-party cookies will not stop this site from working. Blocking all cookies still lets you browse and send a form, though we will not know how you found us. Instructions are in the help pages for Chrome, Firefox, Safari and Edge.</p>

        <h2 id="ga-optout">5. Opt Out of Google Analytics</h2>
        <p>You can stop Google Analytics from collecting data on any site by installing the <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">Google Analytics Opt-out Browser Add-on</a>.</p>

        <h2 id="notice">6. Our Cookie Notice</h2>
        <p>Shortly after you arrive, usually as soon as you scroll, we show a short notice about cookies. Once you select "Got it", it stays hidden on later visits. Clearing your browser's site data brings it back.</p>

        <h2 id="changes">7. Changes to This Policy</h2>
        <p>If we add or remove a cookie, we will update the table above and the "Last Updated" date at the top of the page.</p>

        <h2 id="contact">8. Contact Us</h2>
        <?php echo p1_legal_contact_block('Questions about cookies on this site:'); ?>
        <p>More on how we handle personal information is in our <a href="/privacy-policy/">Privacy Policy</a>.</p>

        <p class="lg-updated">Last Updated: <?php echo e($lastUpdated); ?></p>
      </article>
    </div>
  </section>

  <?php echo p1_legal_band('/cookie-policy/'); ?>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
