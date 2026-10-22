<?php
/**
 * includes/footer.php — estimate dialog, designed footer (entity block, NAP, legal row,
 * dofollow credit, partner badge), mobile sticky bar, cookie bar, scripts. Closes </body></html>.
 * Internal links are gated with p1_page_exists() (no 404s while pages are still being built).
 * Loop/scratch variables are $foot-prefixed (shared-include variable rule).
 */
$footPhoneHref = 'tel:' . $phoneRaw;
$footAddressLine = $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
$footCompany = [];
foreach ([['About', '/about/'], ['Services', '/services/'], ['Service Area', '/service-areas/'], ['Contact', '/contact/']] as $footPair) {
    if (p1_page_exists($footPair[1])) $footCompany[] = $footPair;
}
$footLegal = [];
foreach ([
    ['Privacy Policy', '/privacy-policy/', true],
    ['Terms of Service', '/terms/', true],
    ['Cookie Policy', '/cookie-policy/', false],
    ['Accessibility', '/accessibility/', false],
    ['Do Not Sell or Share My Personal Information', '/privacy-policy/#ccpa-rights', true],
    ['Sitemap', '/sitemap.xml', false],
] as $footPair) {
    if (p1_page_exists($footPair[1])) $footLegal[] = $footPair;
}
?>
<dialog class="estimate-dialog" id="estimate-dialog" aria-labelledby="estimate-dialog-title">
  <div class="dialog-head">
    <div>
      <h3 id="estimate-dialog-title"><?php echo e($estimateCtaLabel); ?></h3>
      <p class="footnote">Tell us what's going on and we'll call you back.</p>
    </div>
    <button type="button" class="dialog-close" aria-label="Close" data-close-estimate><?php echo icon('x', 20); ?></button>
  </div>
  <div class="dialog-body">
    <?php echo p1_full_lead_form('dialog', 'dlg', 'Send my request'); ?>
  </div>
</dialog>

<footer class="site-footer">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <img class="footer-logo__img" src="<?php echo e($logoLight); ?>" alt="<?php echo e($siteName); ?>" width="877" height="367" decoding="async">
        <p><?php echo e($siteName); ?> is an electrician based in <?php echo e($address['city']); ?>, Wisconsin, working on homes, new construction and businesses since <?php echo (int) $yearEstablished; ?>.</p>
        <a class="btn btn-accent btn-sm" href="<?php echo e($footPhoneHref); ?>"><?php echo icon('phone', 16); ?> <?php echo e($phone); ?></a>
      </div>
      <div class="footer-col">
        <h4>Services</h4>
        <ul>
          <?php foreach (array_slice($services, 0, 8) as $footSvc):
              $footHref = '/services/' . $footSvc['slug'] . '/'; ?>
          <li><?php if (p1_page_exists($footHref)): ?><a href="<?php echo e($footHref); ?>"><?php echo e($footSvc['name']); ?></a><?php else: echo e($footSvc['name']); endif; ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="/">Home</a></li>
          <?php foreach ($footCompany as $footPair): ?>
          <li><a href="<?php echo e($footPair[1]); ?>"><?php echo e($footPair[0]); ?></a></li>
          <?php endforeach; ?>
          <?php if (p1_page_exists('/faq/')): ?><li><a href="/faq/">FAQ</a></li><?php endif; ?>
          <li><a href="<?php echo e($gbpMapsUrl); ?>" target="_blank" rel="noopener">Find us on Google</a></li>
          <li><a href="<?php echo e($reviewRequestUrl); ?>" target="_blank" rel="noopener">Leave a Google review</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Contact</h4>
        <div class="footer-nap">
          <div><?php echo icon('phone', 18); ?><a href="<?php echo e($footPhoneHref); ?>"><?php echo e($phone); ?></a></div>
          <div><?php echo icon('mail', 18); ?><a href="mailto:<?php echo e($email); ?>"><?php echo e($email); ?></a></div>
          <?php if ($addressPublic): ?>
          <div><?php echo icon('map-pin', 18); ?><a href="<?php echo e($directionsUrl); ?>" target="_blank" rel="noopener"><?php echo e($footAddressLine); ?></a></div>
          <?php endif; ?>
          <?php if ($businessHours !== ''): ?>
          <div><?php echo icon('clock', 18); ?><span><?php echo e($businessHours); ?></span></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <p class="footer-entity"><strong><?php echo e($siteName); ?></strong> · <?php echo e($footAddressLine); ?> · <a href="<?php echo e($footPhoneHref); ?>"><?php echo e($phone); ?></a> · <?php echo e($email); ?>. Owner: <?php echo e($ownerName); ?>. Electrical repair, wiring, panel upgrades, lighting, EV charger and generator installation in <?php echo e($address['city']); ?> and the surrounding <?php echo e($serviceAreas[0]['county']); ?> County area.</p>
  </div>
  <div class="footer-bottom">
    <div class="container footer-bottom-inner">
      <?php if ($footLegal): ?>
      <nav class="footer-legal-links" aria-label="Legal">
        <?php foreach ($footLegal as $footI => $footPair): ?>
        <?php if ($footI > 0): ?><span class="footer-legal-divider" aria-hidden="true">|</span><?php endif; ?>
        <a href="<?php echo e($footPair[1]); ?>"<?php echo $footPair[2] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo e($footPair[0]); ?></a>
        <?php endforeach; ?>
      </nav>
      <?php endif; ?>
      <p class="footer-credit">&copy; <?php echo date('Y'); ?> <?php echo e($siteName); ?>. All rights reserved. · <a href="https://pageoneinsights.com" rel="dofollow" target="_blank">Web Design & Hosting by Page One Insights, LLC</a></p>
    </div>
  </div>
  <?php include __DIR__ . '/partner-badge.php'; ?>
</footer>

<div class="mobile-cta-bar" aria-label="Quick contact">
  <a class="mobile-cta-bar__call" href="<?php echo e($footPhoneHref); ?>"><?php echo icon('phone', 18); ?> Call Now</a>
  <button type="button" class="mobile-cta-bar__estimate" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
</div>

<div class="cookie-bar cookie-banner" id="cookie-bar" role="region" aria-label="Cookie notice">
  <p class="cookie-banner__text">This site uses cookies to remember how you found us.<?php if (p1_page_exists('/cookie-policy/')): ?> <a href="/cookie-policy/">Learn more</a>.<?php endif; ?></p>
  <button type="button" class="cookie-banner__dismiss" aria-label="Dismiss cookie notice">Got it</button>
</div>

<script src="/assets/js/main.js?v=<?php echo e($cssVersion); ?>" defer></script>
</body>
</html>
