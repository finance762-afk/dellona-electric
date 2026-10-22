<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /terms/ — Phase 5, legal-compliance.md Terms of Service template. Adapted:
 * no "licensed and insured" / workers' comp / accepted-payment-method / financing
 * claims (none are in intake — content-confirmations.json), no Insurance Claim Work
 * clause (electricians are not an insurance-restoration trade).
 * Governing law: Wisconsin, Sauk County courts — the client's state of operation;
 * state of formation is not in intake and is listed for confirmation.
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-helpers.php';

/* Section 1 variable block — populated from config.php / build-plan.json */
$companyEntityType = '';            // NOT in intake (LLC / sole proprietorship / corporation) — see content-confirmations.json
$companyName       = trim($siteName . ($companyEntityType !== '' ? ' ' . $companyEntityType : ''));
$companyState      = 'Wisconsin';   // state of operation; state of formation not in intake — confirm
$companyCounty     = $serviceAreas[0]['county'];
$companyEmail      = $email;
$companyPhone      = $phone;
$companyPhoneE164  = $phoneRaw;
$companyAddress    = $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
$lastUpdated       = $legalUpdated;

$pageTitle       = 'Terms of Service | Dellona Electric, Reedsburg, WI';
$pageDescription = 'Terms of Service for the Dellona Electric website and work in Reedsburg, WI: estimates, payment, cancellation and Wisconsin law. Questions? Call (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/terms/';
$ogImage         = $ogImageDefault;
$currentPage     = 'terms';
$pageType        = 'other';
$schemaMarkup    = p1_legal_schema($pageTitle, $pageDescription, $canonicalUrl, 'Terms of Service', '/terms/');

$tosSections = [
    'agreement'     => 'Agreement to terms',
    'site-use'      => 'Use of this website',
    'information'   => 'Website information',
    'estimates'     => 'Estimates and quotes',
    'work'          => 'Electrical work',
    'warranties'    => 'Warranties',
    'payment'       => 'Payment',
    'cancellation'  => 'Cancellation',
    'messages'      => 'Calls, texts and email',
    'liability'     => 'Limitation of liability',
    'ip'            => 'Intellectual property',
    'law'           => 'Governing law',
    'changes'       => 'Changes to these terms',
    'contact'       => 'Contact us',
];
?>
<?php ob_start(); ?>
<?php echo p1_legal_page_css(); ?>
<style>
/* ==== /terms/ — numbered clause markers and a highlighted safety note ==== */
.pg-terms .legal-prose h2 { display: flex; gap: var(--space-3); align-items: baseline; }
.pg-terms .tos-num { flex: 0 0 auto; min-width: 2.4rem; font-family: var(--font-accent); font-size: var(--font-size-xl); color: var(--color-accent-dark); letter-spacing: .02em; }
.pg-terms .tos-note { display: grid; grid-template-columns: 28px 1fr; gap: var(--space-3); margin: 0 0 var(--space-4); padding: var(--space-4) var(--space-5); border-radius: var(--radius); background: color-mix(in srgb, var(--color-danger) 7%, var(--color-surface)); border: 1px solid color-mix(in srgb, var(--color-danger) 25%, var(--color-line)); }
.pg-terms .tos-note svg { color: var(--color-danger); margin-top: var(--space-1); }
.pg-terms .tos-note p { margin: 0; }
.pg-terms .legal-prose ol.tos-sub { list-style: lower-alpha; }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-legal pg-terms">

  <section class="hero hero--legal" aria-labelledby="legal-title">
    <div class="container">
      <div class="lg-hero__copy">
        <span class="eyebrow">Legal</span>
        <h1 id="legal-title">Terms of Service</h1>
        <span class="section-subtitle">The ground rules</span>
        <p><?php echo e('The terms that apply when you use this website or ask ' . $companyName . ' to quote or carry out electrical work.'); ?></p>
        <?php echo p1_legal_dates(); ?>
      </div>
    </div>
  </section>
  <?php echo p1_legal_breadcrumb('Terms of Service'); ?>

  <section class="lg-body" aria-label="Terms of Service text">
    <div class="container lg-layout">
      <?php echo p1_legal_toc($tosSections); ?>
      <article class="legal-prose content-narrow">

        <h2 id="agreement"><span class="tos-num">01</span> Agreement to Terms</h2>
        <p>By using <?php echo e($domain); ?> (the "Site") or engaging <?php echo e($companyName); ?> ("we", "us", "our") for electrical services, you agree to these Terms of Service. If you do not agree, please do not use the Site. A signed estimate, proposal or contract for a specific job takes priority over these terms where the two differ.</p>

        <h2 id="site-use"><span class="tos-num">02</span> Use of This Website</h2>
        <ul>
          <li>You may use the Site for personal, non-commercial purposes to learn about our services and contact us.</li>
          <li>You may not use the Site for anything unlawful, try to access non-public systems, scrape or copy content without written permission, submit false information or someone else's details through our forms, or use automated tools to send form submissions or extract data.</li>
        </ul>

        <h2 id="information"><span class="tos-num">03</span> Website Information</h2>
        <p>Articles, answers and photos on the Site are general information about electrical work in and around <?php echo e($address['city']); ?>. They are not a diagnosis of your property and not instructions for doing electrical work yourself.</p>
        <div class="tos-note">
          <?php echo icon('alert-triangle', 22); ?>
          <p><strong>Safety first.</strong> Electrical work can cause shock, fire and serious injury. If you see smoke or fire, leave the building and call 911. Contact your electric utility about downed lines or problems with the meter or service drop.</p>
        </div>

        <h2 id="estimates"><span class="tos-num">04</span> Service Estimates and Quotes</h2>
        <p>Estimates are based on the information you give us and the conditions we can see at the time. Final pricing may change if the scope of work changes, if hidden conditions are found once walls, ceilings or panels are opened, if material costs change between the estimate and the start of work, or if code, permit or utility requirements differ from what was assumed. Verbal quotes are non-binding; only a written estimate, proposal or contract that you accept is a final agreement.</p>

        <h2 id="work"><span class="tos-num">05</span> Electrical Work</h2>
        <ul>
          <li>Each job is governed by the written estimate, proposal or contract for that job.</li>
          <li>We perform work to the electrical code in force in <?php echo e($companyState); ?> and to local requirements. Where a job needs a permit and inspection, how they are handled is stated in your written agreement.</li>
          <li>You agree to give us safe, reasonable access to the work area and the electrical panel, and to tell us about anything you know of that affects the work, such as earlier repairs, damage or plans for the space.</li>
          <li>Some jobs depend on others, such as your electric utility for a service change. We are not responsible for delays they cause.</li>
        </ul>

        <h2 id="warranties"><span class="tos-num">06</span> Warranties</h2>
        <p>Any workmanship warranty is stated in your written estimate, proposal or contract. Manufacturer warranties on equipment we install, such as chargers, generators, fixtures and surge protective devices, come from those manufacturers and pass through to you. Warranties do not cover damage from misuse, alteration or repair by others, power events beyond a product's rating, or conditions that existed before our work and were disclosed to you.</p>

        <h2 id="payment"><span class="tos-num">07</span> Payment</h2>
        <p>Payment amounts, accepted payment methods and due dates are stated on your estimate, contract or invoice. Where a job is large enough to need a deposit or progress payments, your written agreement will say so. Past-due balances may accrue interest or charges as permitted by <?php echo e($companyState); ?> law.</p>

        <h2 id="cancellation"><span class="tos-num">08</span> Cancellation</h2>
        <p>Cancellation terms are set out in your written agreement. Where it is silent:</p>
        <ol class="tos-sub">
          <li>Before materials are ordered, you may cancel without charge for the work itself.</li>
          <li>After materials are ordered for your job, you pay for materials that cannot be returned, and they become yours.</li>
          <li>After work begins, you pay for the work completed and materials used to that point.</li>
        </ol>
        <p>Nothing here limits any cancellation right you have by law, such as the federal three-day right to cancel certain sales made at your home.</p>

        <h2 id="messages"><span class="tos-num">09</span> Calls, Texts and Email</h2>
        <p>By sending a form you agree that we may contact you by phone or email about your request. Text messages and marketing emails are sent only if you opt in with the separate boxes on our forms. Reply STOP to any text to unsubscribe or HELP for help; message and data rates may apply; consent is not a condition of purchase. Details are in our <a href="/privacy-policy/#sms-calls">Privacy Policy</a>.</p>

        <h2 id="liability"><span class="tos-num">10</span> Limitation of Liability</h2>
        <p>To the fullest extent permitted by <?php echo e($companyState); ?> law, <?php echo e($companyName); ?>'s total liability for any claim related to the Site or our services will not exceed the amount you paid for the specific service that gave rise to the claim. We are not liable for indirect, incidental, special or consequential damages. Nothing in these terms limits liability that cannot be limited by law.</p>

        <h2 id="ip"><span class="tos-num">11</span> Intellectual Property</h2>
        <p>Content on the Site, including text, graphics, logos and photographs of our work, is owned by <?php echo e($companyName); ?> or used with permission and is protected by copyright. You may not reproduce, distribute or create derivative works from it without written permission.</p>

        <h2 id="law"><span class="tos-num">12</span> Governing Law and Disputes</h2>
        <p>These Terms are governed by the laws of the State of <?php echo e($companyState); ?>, without regard to conflict-of-laws principles. Any dispute will be resolved in the state or federal courts serving <?php echo e($companyCounty); ?> County, <?php echo e($companyState); ?>.</p>

        <h2 id="changes"><span class="tos-num">13</span> Changes to These Terms</h2>
        <p>We may update these Terms at any time. The "Last Updated" date at the top of the page shows the current version. Continuing to use the Site after an update means you accept the revised Terms; changes do not alter a written agreement you have already signed.</p>

        <h2 id="contact"><span class="tos-num">14</span> Contact Us</h2>
        <?php echo p1_legal_contact_block('Questions about these Terms:'); ?>

        <p class="lg-updated">Last Updated: <?php echo e($lastUpdated); ?></p>
      </article>
    </div>
  </section>

  <?php echo p1_legal_band('/terms/'); ?>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
