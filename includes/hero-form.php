<?php
/**
 * includes/hero-form.php — compact hero estimate card for service (and later city) pages.
 * Desktop only (framework.css hides .hero-form-card below 900px; the page's
 * data-open-estimate button opens #estimate-dialog instead).
 *
 * Set before including:
 *   $heroFormService — config.php service name to preselect (optional)
 *   $heroFormTitle   — card heading, phrased as a question (optional)
 * Form id 'hero' (unique on the page; the dialog in footer.php is 'dialog').
 * Name + phone + email + service: the leads endpoint rejects a submission without email.
 * Scratch variables are $hf-prefixed (shared-include variable rule).
 */
$hfService = $heroFormService ?? '';
$hfTitle   = $heroFormTitle ?? 'Want a price on the job?';
?>
<aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
  <h2 id="hero-form-title"><?php echo e($hfTitle); ?></h2>
  <p class="hero-form-tagline">No obligation. Tell us what's going on and we'll call you back.</p>
  <form action="<?php echo e($formAction); ?>" method="POST" class="hero-form">
    <?php echo p1_lead_hidden_fields('hero'); ?>
    <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
    <div class="form-row hf-pair">
      <div><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" required></div>
      <div><label class="sr-only" for="hero-email">Email</label><input id="hero-email" type="email" name="email" placeholder="Email" autocomplete="email" required></div>
    </div>
    <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options($hfService); ?></select></div>
    <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
    <button type="submit" class="btn btn-primary btn-block">Send my request</button>
  </form>
</aside>
