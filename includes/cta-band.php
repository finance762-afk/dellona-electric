<?php
/**
 * includes/cta-band.php — the v6.3 mid-page estimate band for About, FAQ and blog posts
 * (CLAUDE.md "Lead Form Placement"): ONE <section class="cta-band" id="estimate"> after the
 * first content section, never a hero form on these pages.
 *   p1_cta_band_css()            component CSS (tokens only) — print once into $headExtra
 *   p1_cta_band($title, $copy)   the band: copy column ≈1/3, form card ≈2/3, fields three-up
 * Form id 'cta-band' (unique on the page; the footer dialog is 'dialog'). Scratch variables
 * are $cb-prefixed (shared-include variable rule).
 */

function p1_cta_band_css(): string {
    ob_start(); ?>
<style>
/* ==== cta-band — compact mid-page estimate band (sized to content, ≈300px desktop) ==== */
.cta-band { position: relative; isolation: isolate; overflow: clip; padding-block: clamp(2.5rem, 5vw, 3.5rem); background: linear-gradient(115deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 120%); color: var(--color-white); }
.cta-band::before { content: ""; position: absolute; z-index: -1; pointer-events: none; inset: -40% -10% auto 55%; height: 160%; background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 18%, transparent), transparent 70%); }
.cta-band__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 2fr); gap: clamp(1.5rem, 4vw, 3rem); align-items: center; }
.cta-band__copy { display: grid; gap: var(--space-3); }
.cta-band__copy .eyebrow { color: var(--color-accent-bright); }
.cta-band__copy h2 { color: var(--color-white); font-size: var(--fs-h3); line-height: 1.25; }
.cta-band__copy p { margin: 0; font-size: var(--font-size-sm); color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.cta-band__copy .link-call { color: var(--color-white); font-weight: 600; display: inline-flex; gap: var(--space-2); align-items: center; }
.cta-band__copy .link-call svg { color: var(--color-accent-bright); }
.cta-band__card { background: var(--color-surface); color: var(--color-ink); border-radius: var(--radius-lg); padding: var(--space-5) var(--space-6); box-shadow: var(--shadow-lg); }
.cta-band__form { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-3); align-items: end; }
.cta-band__form .cb-field { display: grid; gap: var(--space-1); }
.cta-band__form .cb-field label { font-size: var(--font-size-xs); font-weight: 600; color: var(--color-ink-2); }
.cta-band__form .cb-field--service { grid-column: span 2; }
.cta-band__form input:not([type=checkbox]):not([type=hidden]), .cta-band__form select { width: 100%; min-height: 46px; padding: var(--space-2) var(--space-3); font: inherit; font-size: var(--font-size-base); color: var(--color-ink); background: var(--color-paper); border: 1px solid var(--color-line); border-radius: var(--radius); transition: border-color var(--transition), box-shadow var(--transition); }
.cta-band__form input:focus, .cta-band__form select:focus { outline: none; border-color: var(--color-primary); box-shadow: 0 0 0 3px color-mix(in srgb, var(--color-accent) 30%, transparent); }
.cta-band__form .btn { min-height: 46px; width: 100%; }
.cta-band__form .consent { grid-column: span 2; margin: 0; }
.cta-band__foot { margin: 0; font-size: var(--font-size-xs); color: var(--color-muted); align-self: center; }
@media (max-width: 1000px) { .cta-band__grid { grid-template-columns: 1fr; } }
@media (max-width: 640px) {
  .cta-band__form { grid-template-columns: 1fr; }
  .cta-band__form .cb-field--service, .cta-band__form .consent { grid-column: auto; }
}
</style>
<?php
    return (string) ob_get_clean();
}

function p1_cta_band(string $title, string $copy): string {
    global $formAction, $phone, $phoneRaw, $siteName;
    ob_start(); ?>
<section class="cta-band" id="estimate" aria-labelledby="cta-band-title">
  <div class="container-wide cta-band__grid">
    <div class="cta-band__copy">
      <span class="eyebrow">Request an estimate</span>
      <h2 id="cta-band-title"><?php echo e($title); ?></h2>
      <p><?php echo e($copy); ?></p>
      <a class="link-call" href="tel:<?php echo e($phoneRaw); ?>"><?php echo icon('phone', 18); ?> Or call <?php echo e($phone); ?></a>
    </div>
    <div class="cta-band__card">
      <form action="<?php echo e($formAction); ?>" method="POST" class="cta-band__form" id="cta-band-form">
        <?php echo p1_lead_hidden_fields('cta-band'); ?>
        <div class="cb-field"><label for="cb-name">Name *</label><input id="cb-name" type="text" name="name" autocomplete="name" required></div>
        <div class="cb-field"><label for="cb-phone">Phone *</label><input id="cb-phone" type="tel" name="phone" autocomplete="tel" required></div>
        <div class="cb-field"><label for="cb-email">Email *</label><input id="cb-email" type="email" name="email" autocomplete="email" required></div>
        <div class="cb-field cb-field--service"><label for="cb-service">Service needed</label><select id="cb-service" name="service"><?php echo p1_service_options(); ?></select></div>
        <button type="submit" class="btn btn-primary">Send my request</button>
        <label class="consent" for="cb-terms"><input id="cb-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted about my request. *</span></label>
        <p class="cta-band__foot"><?php echo e($siteName); ?> calls you back to talk through the job. No obligation.</p>
      </form>
    </div>
  </div>
</section>
<?php
    return (string) ob_get_clean();
}
