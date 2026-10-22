<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /privacy-policy/ — Phase 5, legal-compliance.md Privacy Policy template, adapted to
 * what this site actually does: forms post to the Page One leads endpoint (Formsubmit
 * is retired), includes/attribution.php sets the first-party p1_ft cookie, the contact
 * page embeds Google Maps, and GA4 runs only once $googleAnalyticsId is set.
 * No insurance-carrier or photo-upload clauses (not an insurance trade; no upload field).
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-helpers.php';

/* Section 1 variable block — populated from config.php / build-plan.json */
$companyEntityType = '';            // NOT in intake (LLC / sole proprietorship / corporation) — see content-confirmations.json
$companyName       = trim($siteName . ($companyEntityType !== '' ? ' ' . $companyEntityType : ''));
$companyState      = 'Wisconsin';   // state of operation; state of formation not in intake — confirm
$companyEmail      = $email;
$companyPhone      = $phone;
$companyPhoneE164  = $phoneRaw;
$companyAddress    = $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
$lastUpdated       = $legalUpdated;

$pageTitle       = 'Privacy Policy | Dellona Electric Electrician, Reedsburg, WI';
$pageDescription = 'How Dellona Electric in Reedsburg, WI collects, uses and protects data from its website, forms, calls and texts. Privacy questions? Call (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/privacy-policy/';
$ogImage         = $ogImageDefault;
$currentPage     = 'privacy-policy';
$pageType        = 'other';
$schemaMarkup    = p1_legal_schema($pageTitle, $pageDescription, $canonicalUrl, 'Privacy Policy', '/privacy-policy/');

$ppSections = [
    'introduction'   => 'Introduction',
    'information'    => 'Information we collect',
    'use'            => 'How we use it',
    'sharing'        => 'How we share it',
    'your-rights'    => 'Your privacy rights',
    'sms-calls'      => 'Text messages and calls',
    'email'          => 'Email',
    'cookies'        => 'Cookies',
    'retention'      => 'Data retention',
    'security'       => 'Data security',
    'children'       => 'Children\'s privacy',
    'third-parties'  => 'Third-party links',
    'changes'        => 'Changes to this policy',
    'contact'        => 'Contact us',
];
?>
<?php ob_start(); ?>
<?php echo p1_legal_page_css(); ?>
<style>
/* ==== /privacy-policy/ — "at a glance" summary card, rights grid ==== */
.pg-privacy .pp-glance { margin: 0 0 var(--space-8); padding: var(--space-6); border-radius: var(--radius-lg); background: var(--color-dark); color: var(--color-white); box-shadow: var(--shadow); }
.pg-privacy .pp-glance h2 { margin: 0 0 var(--space-4); padding: 0; border: 0; color: var(--color-white); font-size: var(--font-size-lg); }
.pg-privacy .pp-glance ul { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-3); }
.pg-privacy .pp-glance li { display: grid; grid-template-columns: 22px 1fr; gap: var(--space-3); margin: 0; color: color-mix(in srgb, var(--color-white) 85%, transparent); }
.pg-privacy .pp-glance svg { color: var(--color-accent-bright); margin-top: var(--space-1); }
.pg-privacy .pp-glance strong { color: var(--color-white); }
.pg-privacy .pp-rights { list-style: none; margin: 0 0 var(--space-4); padding: 0; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-3); }
.pg-privacy .pp-rights li { margin: 0; padding: var(--space-4); border-radius: var(--radius); background: var(--color-surface); border: 1px solid var(--color-line); font-size: var(--font-size-sm); }
.pg-privacy .pp-rights li:nth-child(3n+1) { background: var(--color-card-tint-1); }
.pg-privacy .pp-rights li:nth-child(3n+2) { background: var(--color-card-tint-2); }
.pg-privacy .pp-rights li:nth-child(3n) { background: var(--color-card-tint-3); }
.pg-privacy #ccpa-rights { padding: var(--space-3) var(--space-4); margin-left: calc(-1 * var(--space-4)); border-left: 4px solid var(--color-accent); background: var(--color-card-tint-3); border-radius: 0 var(--radius) var(--radius) 0; }
@media (max-width: 560px) { .pg-privacy .pp-rights { grid-template-columns: 1fr; } }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-legal pg-privacy">

  <section class="hero hero--legal" aria-labelledby="legal-title">
    <div class="container">
      <div class="lg-hero__copy">
        <span class="eyebrow">Legal</span>
        <h1 id="legal-title">Privacy Policy</h1>
        <span class="section-subtitle">Your data, our commitments</span>
        <p><?php echo e('How ' . $companyName . ' collects, uses and protects the information you give us through this website, our estimate forms, phone calls and text messages.'); ?></p>
        <?php echo p1_legal_dates(); ?>
      </div>
    </div>
  </section>
  <?php echo p1_legal_breadcrumb('Privacy Policy'); ?>

  <section class="lg-body" aria-label="Privacy Policy text">
    <div class="container lg-layout">
      <?php echo p1_legal_toc($ppSections); ?>
      <article class="legal-prose content-narrow">

        <div class="pp-glance">
          <h2>At a glance</h2>
          <ul>
            <li><?php echo icon('shield-check', 18); ?><span><strong>We do not sell your personal information.</strong> We use it to answer your request and do the work you ask for.</span></li>
            <li><?php echo icon('message-square', 18); ?><span><strong>Texts and marketing emails are opt-in.</strong> Each has its own unchecked box on our forms, and neither is required to get an estimate.</span></li>
            <li><?php echo icon('mail', 18); ?><span><strong>You can ask what we hold, or ask us to delete it,</strong> by emailing <?php echo e($companyEmail); ?>.</span></li>
          </ul>
        </div>

        <h2 id="introduction">1. Introduction</h2>
        <p>This Privacy Policy explains how <?php echo e($companyName); ?> ("we", "us", "our"), an electrical contractor based in <?php echo e($address['city']); ?>, <?php echo e($companyState); ?>, collects, uses and protects personal information when you visit <?php echo e($domain); ?>, send us a form, call us or receive messages from us.</p>

        <h2 id="information">2. Information We Collect</h2>
        <h3>Information you give us</h3>
        <ul>
          <li><strong>Estimate and contact forms:</strong> your name, phone number, email address, the service you are interested in, your message, and the consent choices you make (email updates, text messages, and agreement to our Terms and this policy).</li>
          <li><strong>Calls, texts, emails and visits:</strong> details you share about your property and the job, such as the service address, the problem you are having and the work you want done.</li>
        </ul>
        <h3>Information collected automatically</h3>
        <ul>
          <li><strong>With a form submission:</strong> the page and form you used, the version of the consent wording you saw, and basic visit details stored in our first-party attribution cookie: the first page you landed on, the website that referred you, any campaign tags in the link (UTM parameters or a Google Ads click ID), a random visit ID and your device type (mobile, tablet or desktop).</li>
          <li><strong>Server and security logs:</strong> IP address, browser type, pages requested and timestamps, kept by our hosting and form-processing providers to run the site and filter spam.</li>
          <li><strong>Analytics:</strong> if we turn on Google Analytics 4, it records pages viewed, approximate location, device and browser information and how you reached the site.</li>
          <li><strong>Cookies and similar technologies:</strong> see our <a href="/cookie-policy/">Cookie Policy</a>.</li>
        </ul>

        <h2 id="use">3. How We Use Your Information</h2>
        <ul>
          <li>Respond to your inquiry and call you back about your request</li>
          <li>Schedule site visits, estimates and electrical work, and communicate during a job</li>
          <li>Send text messages or marketing emails, only where you have opted in</li>
          <li>Understand which pages and advertising bring in inquiries, so we can improve the website</li>
          <li>Detect and block spam and abuse of our forms</li>
          <li>Keep business, tax and permit records and meet our legal obligations</li>
        </ul>

        <h2 id="sharing">4. How We Share Your Information</h2>
        <ul>
          <li>We do <strong>not</strong> sell personal information, and we do not share it for cross-context behavioral advertising.</li>
          <li><strong>Service providers that work on our behalf:</strong> Page One Insights, LLC, which designs and hosts this website and operates the form service that receives, stores and emails your submission to us (Page One Insights also receives a copy of each submission to confirm leads are delivered); our web hosting provider; our email provider; and Google, if analytics is enabled or when you load the map on our contact page.</li>
          <li><strong>Suppliers and subcontractors:</strong> only what they need to complete your job, such as a service address for a delivery.</li>
          <li><strong>Permits and utilities:</strong> details a building department or electric utility requires for permits, inspections or service changes on your property.</li>
          <li><strong>Legal compliance:</strong> where <?php echo e($companyState); ?> or federal law, a court order or a legal process requires it.</li>
          <li><strong>Business transfers:</strong> if the business is sold or merged, customer records may transfer to the new owner under this policy.</li>
        </ul>
        <p>We never share your mobile number or your text-message opt-in with third parties for their own marketing.</p>

        <h2 id="your-rights">5. Your Privacy Rights</h2>
        <h3 id="state-rights"><?php echo e($companyState); ?> Residents and Everyone Else</h3>
        <p>Wherever you live, you can ask us what personal information we hold about you, ask us to correct it, or ask us to delete it, subject to records we must keep by law. Contact us using the details below.</p>

        <h3 id="ccpa-rights">California Residents (CCPA / CPRA)</h3>
        <p>To the extent the California Consumer Privacy Act, as amended by the California Privacy Rights Act, applies to us, California residents have these rights:</p>
        <ul class="pp-rights">
          <li><strong>Right to know</strong> what personal information we collect, use and disclose.</li>
          <li><strong>Right to delete</strong> personal information we collected from you, with some exceptions.</li>
          <li><strong>Right to correct</strong> inaccurate personal information.</li>
          <li><strong>Right to opt out of sale or sharing.</strong> We do not sell or share personal information, but you may still submit an opt-out request for our records.</li>
          <li><strong>Right to limit use</strong> of sensitive personal information.</li>
          <li><strong>Right to non-discrimination</strong> for exercising any of these rights.</li>
        </ul>
        <p><strong>Do Not Sell or Share My Personal Information:</strong> to make a request, email <a href="mailto:<?php echo e($companyEmail); ?>"><?php echo e($companyEmail); ?></a> or call <a href="tel:<?php echo e($companyPhoneE164); ?>"><?php echo e($companyPhone); ?></a>. We also treat a Global Privacy Control signal from your browser as an opt-out request. We respond to verified requests within 45 days and will confirm when an opt-out has been honored. You may use an authorized agent to make a request for you.</p>

        <h3>Residents of Other States</h3>
        <p>Residents of states with comprehensive consumer privacy laws, including Colorado, Connecticut, Delaware, Indiana, Iowa, Kentucky, Maryland, Minnesota, Montana, Nebraska, New Hampshire, New Jersey, Oregon, Rhode Island, Tennessee, Texas, Utah and Virginia, may have similar rights to access, correct, delete and opt out, and to appeal a decision we make about a request. Contact us the same way to use them.</p>

        <h2 id="sms-calls">6. Text Messages and Phone Calls (TCPA)</h2>
        <p>When you send a form, we may call you at the number you provide about your request. We send text messages only if you check the separate, optional SMS box on our form. Those messages may include appointment reminders, service updates and promotional offers. Message frequency varies. Message and data rates may apply. Reply <strong>STOP</strong> to any text to unsubscribe, or <strong>HELP</strong> for help. Consent to texts is not a condition of purchase.</p>
        <p>You can also opt out of calls or texts by telling us on the phone, replying to any message, or emailing <a href="mailto:<?php echo e($companyEmail); ?>"><?php echo e($companyEmail); ?></a>. We honor any reasonable opt-out request.</p>

        <h2 id="email">7. Email</h2>
        <p>If you check the optional email box, we may send you emails about our services, promotions and news. Without it, we only email you about your own request or job. Every marketing email includes an unsubscribe link, or you can email <a href="mailto:<?php echo e($companyEmail); ?>"><?php echo e($companyEmail); ?></a>.</p>

        <h2 id="cookies">8. Cookies</h2>
        <p>This site uses a small number of cookies and similar technologies, including a first-party cookie that remembers how you first found us for 30 days. The <a href="/cookie-policy/">Cookie Policy</a> lists each one and explains how to control them.</p>

        <h2 id="retention">9. Data Retention</h2>
        <p>We keep inquiries and job records for as long as we need them to answer you, complete and stand behind our work, and meet tax, permit and other legal record-keeping requirements. When we no longer need information, we delete it or remove what identifies you.</p>

        <h2 id="security">10. Data Security</h2>
        <p>Form submissions travel over an encrypted (HTTPS) connection, and we limit access to the people and providers who need it. No system is completely secure, so we cannot guarantee absolute security, but we work to keep risks low.</p>

        <h2 id="children">11. Children's Privacy</h2>
        <p>This website is not directed to children under 13, and we do not knowingly collect their information. If you believe a child has sent us information, contact us and we will delete it.</p>

        <h2 id="third-parties">12. Third-Party Links</h2>
        <p>Our site links to and embeds services run by others, such as our Google Business Profile and Google Maps. Their privacy practices are governed by their own policies, which we encourage you to read.</p>

        <h2 id="changes">13. Changes to This Policy</h2>
        <p>We may update this Privacy Policy from time to time. The "Last Updated" date at the top of the page shows the most recent change, and material changes will be posted prominently on the site.</p>

        <h2 id="contact">14. Contact Us</h2>
        <?php echo p1_legal_contact_block('For privacy questions or to use any of the rights above:'); ?>

        <p class="lg-updated">Last Updated: <?php echo e($lastUpdated); ?></p>
      </article>
    </div>
  </section>

  <?php echo p1_legal_band('/privacy-policy/'); ?>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
