<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /accessibility/ — Phase 5, legal-compliance.md Accessibility Statement template.
 * The feature list names only what this build ships (skip link, landmarks, focus ring,
 * reduced motion, labelled forms, native <dialog>/<details>, aria-expanded menu).
 * No reply-time promise — the client has not confirmed one (content-confirmations.json).
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

$pageTitle       = 'Accessibility Statement | Dellona Electric, Reedsburg, WI';
$pageDescription = 'Dellona Electric\'s accessibility statement for its Reedsburg, WI website: WCAG 2.1 AA conformance, built-in features, known limits and how to report a barrier.';
$canonicalUrl    = $siteUrl . '/accessibility/';
$ogImage         = $ogImageDefault;
$currentPage     = 'accessibility';
$pageType        = 'other';
$schemaMarkup    = p1_legal_schema($pageTitle, $pageDescription, $canonicalUrl, 'Accessibility', '/accessibility/');

$axFeatures = [
    ['footprints', 'Skip link', 'A "Skip to main content" link is the first thing a keyboard reaches on every page.'],
    ['layers', 'Landmarks and headings', 'Pages use header, navigation, main and footer regions and one H1 with nested headings.'],
    ['eye', 'Visible focus', 'Every link, button and form field shows a clear outline when it has keyboard focus.'],
    ['pencil-ruler', 'Labelled forms', 'Each form field has a label, required fields are marked, and consent boxes are separate and unchecked.'],
    ['sparkles', 'Reduced motion', 'If your device asks for reduced motion, animations and transitions are switched off.'],
    ['menu', 'Keyboard menus', 'The mobile menu reports whether it is open, closes with Escape, and the estimate form opens in a native dialog.'],
    ['zap', 'Contrast and zoom', 'Body text and controls are designed to meet AA contrast, and layouts reflow when you zoom or use a small screen.'],
    ['check-circle', 'Text alternatives', 'Photos of our work carry descriptions of what they show; decorative images are hidden from screen readers.'],
];
$axSections = [
    'commitment'  => 'Our commitment',
    'conformance' => 'Conformance status',
    'features'    => 'Accessibility features',
    'limitations' => 'Known limitations',
    'feedback'    => 'Feedback and reporting',
    'alternatives'=> 'Other ways to reach us',
    'assessment'  => 'How we assess the site',
    'changes'     => 'Changes to this statement',
    'contact'     => 'Contact us',
];
?>
<?php ob_start(); ?>
<?php echo p1_legal_page_css(); ?>
<style>
/* ==== /accessibility/ — feature checklist grid and conformance badge ==== */
.pg-access .ax-badge { display: inline-flex; gap: var(--space-3); align-items: center; margin: 0 0 var(--space-4); padding: var(--space-3) var(--space-5); border-radius: var(--radius-full); background: var(--color-dark); color: var(--color-white); font-family: var(--font-accent); font-size: var(--font-size-base); letter-spacing: .08em; text-transform: uppercase; box-shadow: var(--shadow-sm); }
.pg-access .ax-badge svg { color: var(--color-accent-bright); }
.pg-access .ax-grid { list-style: none; margin: 0 0 var(--space-4); padding: 0; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-3); }
.pg-access .ax-grid li { margin: 0; display: grid; grid-template-columns: 40px 1fr; gap: var(--space-1) var(--space-3); padding: var(--space-4); border-radius: var(--radius); border: 1px solid var(--color-line); background: var(--color-surface); }
.pg-access .ax-grid li:nth-child(4n+1), .pg-access .ax-grid li:nth-child(4n+4) { background: var(--color-card-tint-1); }
.pg-access .ax-grid li:nth-child(4n+2), .pg-access .ax-grid li:nth-child(4n+3) { background: var(--color-card-tint-3); }
.pg-access .ax-icon { grid-row: span 2; width: 40px; height: 40px; border-radius: var(--radius); display: grid; place-items: center; background: var(--color-surface); color: var(--color-accent-dark); box-shadow: var(--shadow-sm); }
.pg-access .ax-grid b { font-family: var(--font-heading); color: var(--color-ink); }
.pg-access .ax-grid span:last-child { font-size: var(--font-size-sm); line-height: 1.55; }
@media (max-width: 640px) { .pg-access .ax-grid { grid-template-columns: 1fr; } }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-legal pg-access">

  <section class="hero hero--legal" aria-labelledby="legal-title">
    <div class="container">
      <div class="lg-hero__copy">
        <span class="eyebrow">Legal</span>
        <h1 id="legal-title">Accessibility Statement</h1>
        <span class="section-subtitle">A site everyone can use</span>
        <p><?php echo e($companyName . ' wants every visitor to be able to read about our services and reach us. This page explains how the site is built for that and how to tell us about a barrier.'); ?></p>
        <?php echo p1_legal_dates(); ?>
      </div>
    </div>
  </section>
  <?php echo p1_legal_breadcrumb('Accessibility'); ?>

  <section class="lg-body" aria-label="Accessibility Statement text">
    <div class="container lg-layout">
      <?php echo p1_legal_toc($axSections); ?>
      <article class="legal-prose content-narrow">

        <h2 id="commitment">1. Our Commitment</h2>
        <p><?php echo e($companyName); ?> is committed to making <?php echo e($domain); ?> usable by people with disabilities. We keep improving the experience for everyone and apply the relevant accessibility standards to the site.</p>

        <h2 id="conformance">2. Conformance Status</h2>
        <p class="ax-badge"><?php echo icon('badge-check', 20); ?> Target: WCAG 2.1 Level AA</p>
        <p>The Web Content Accessibility Guidelines (WCAG) define how to make web content more accessible to people with disabilities. This site is designed to conform with WCAG 2.1 Level AA. It <strong>partially conforms</strong>, meaning some content, mainly from third parties, does not yet fully meet the standard. We are working to address known issues.</p>

        <h2 id="features">3. Accessibility Features</h2>
        <ul class="ax-grid">
          <?php foreach ($axFeatures as $axF): ?>
          <li><span class="ax-icon"><?php echo icon($axF[0], 20); ?></span><b><?php echo e($axF[1]); ?></b><span><?php echo e($axF[2]); ?></span></li>
          <?php endforeach; ?>
        </ul>

        <h2 id="limitations">4. Known Limitations</h2>
        <ul>
          <li><strong>Google Maps:</strong> the map on our contact page is provided by Google and may not be fully accessible. The same address and a "Get Directions" link appear as plain text beside it.</li>
          <li><strong>Google reviews:</strong> any review text shown on the site is written by customers and published as written.</li>
          <li><strong>Photos:</strong> photos of our work are described in text, but fine detail in a photo may not come through in a description. Ask us and we will explain what a job involved.</li>
        </ul>

        <h2 id="feedback">5. Feedback and Reporting Issues</h2>
        <p>If something on this site is hard to use, please tell us. Let us know the page address, what you were trying to do and the browser or assistive technology you use. Email <a href="mailto:<?php echo e($companyEmail); ?>"><?php echo e($companyEmail); ?></a> or call <a href="tel:<?php echo e($companyPhoneE164); ?>"><?php echo e($companyPhone); ?></a>. We will get back to you and work with you to fix the problem or provide the information another way.</p>

        <h2 id="alternatives">6. Other Ways to Reach Us</h2>
        <p>You never need the website to get service. Call <a href="tel:<?php echo e($companyPhoneE164); ?>"><?php echo e($companyPhone); ?></a> to request an estimate by phone, or email us. On request, we can read any page of this site to you or send its content in another format.</p>

        <h2 id="assessment">7. How We Assess the Site</h2>
        <p>Accessibility is checked by self-evaluation: automated testing of each page while the site is built and updated, plus manual review of keyboard use, headings, labels and color contrast.</p>

        <h2 id="changes">8. Changes to This Statement</h2>
        <p>We review this statement when the site changes. The "Last Updated" date at the top of the page shows the latest version.</p>

        <h2 id="contact">9. Contact Us</h2>
        <?php echo p1_legal_contact_block('To report an accessibility barrier or ask for information in another format:'); ?>

        <p class="lg-updated">Last Updated: <?php echo e($lastUpdated); ?></p>
      </article>
    </div>
  </section>

  <?php echo p1_legal_band('/accessibility/'); ?>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
