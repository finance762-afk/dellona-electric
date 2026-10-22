<?php
/**
 * includes/header.php — skip link, fixed glass header, desktop nav, mobile overlay.
 * Include right after head.php. Every internal link is gated with p1_page_exists(),
 * so a page that is not built yet never appears in the nav (no 404s).
 * Loop/scratch variables are $nav-prefixed (shared-include variable rule).
 */
$navServicesHub = p1_page_exists('/services/');
$navServiceLinks = [];
foreach ($services as $navSvc) {
    $navHref = '/services/' . $navSvc['slug'] . '/';
    if (p1_page_exists($navHref)) $navServiceLinks[] = ['name' => $navSvc['name'], 'href' => $navHref];
}
$navAreaHref = p1_page_exists('/service-areas/') ? '/service-areas/' : areaHref($serviceAreas[0]);
$navItems = [];
if ($navServicesHub || $navServiceLinks) {
    $navItems[] = ['label' => 'Services', 'href' => $navServicesHub ? '/services/' : $navServiceLinks[0]['href'], 'section' => '/services/', 'dropdown' => $navServiceLinks];
}
if ($navAreaHref !== '') $navItems[] = ['label' => 'Service Area', 'href' => $navAreaHref, 'section' => $navAreaHref];
foreach ([['About', '/about/'], ['FAQ', '/faq/'], ['Contact', '/contact/']] as $navPair) {
    if (p1_page_exists($navPair[1])) $navItems[] = ['label' => $navPair[0], 'href' => $navPair[1], 'section' => $navPair[1]];
}
$navPhoneHref = 'tel:' . $phoneRaw;
?>
<a href="#main-content" class="skip-link">Skip to main content</a>
<header class="site-header" id="site-header">
  <div class="container header-inner">
    <a class="site-logo" href="/" aria-label="<?php echo e($siteName); ?> home"<?php echo isActivePage('/') ? ' aria-current="page"' : ''; ?>>
      <img class="site-logo__img" src="<?php echo e($logoDark); ?>" alt="<?php echo e($siteName); ?>" width="877" height="367">
    </a>
    <?php if ($navItems): ?>
    <nav aria-label="Main navigation">
      <ul class="navbar-links">
        <?php foreach ($navItems as $navItem):
            $navActive = isActivePage($navItem['section'], true);
            $navHasDrop = !empty($navItem['dropdown']); ?>
        <li<?php echo $navHasDrop ? ' class="has-dropdown"' : ''; ?>>
          <a href="<?php echo e($navItem['href']); ?>"<?php echo $navActive ? ' aria-current="page"' : ''; ?>><?php echo e($navItem['label']); ?><?php echo $navHasDrop ? icon('chevron-down', 14) : ''; ?></a>
          <?php if ($navHasDrop): ?>
          <ul class="dropdown" style="display:none">
            <?php foreach ($navItem['dropdown'] as $navDrop): ?>
            <li><a href="<?php echo e($navDrop['href']); ?>"<?php echo isActivePage($navDrop['href']) ? ' aria-current="page"' : ''; ?>><?php echo e($navDrop['name']); ?></a></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <?php endif; ?>
    <div class="navbar-cta">
      <a class="btn btn-secondary navbar-phone" href="<?php echo e($navPhoneHref); ?>"><?php echo icon('phone', 18); ?><span><?php echo e($phone); ?></span></a>
      <button type="button" class="btn btn-primary" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
    </div>
    <button type="button" class="hamburger" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
      <span class="hamburger-line"></span><span class="hamburger-line"></span><span class="hamburger-line"></span>
    </button>
  </div>
</header>
<div class="mobile-menu" id="mobile-menu" aria-hidden="true">
  <nav aria-label="Mobile navigation">
    <ul class="mobile-menu__links">
      <li><a href="/"<?php echo isActivePage('/') ? ' aria-current="page"' : ''; ?>>Home</a></li>
      <?php foreach ($navItems as $navItem): ?>
      <li><a href="<?php echo e($navItem['href']); ?>"<?php echo isActivePage($navItem['section'], true) ? ' aria-current="page"' : ''; ?>><?php echo e($navItem['label']); ?></a>
        <?php if (!empty($navItem['dropdown'])): ?>
        <ul class="sub">
          <?php foreach ($navItem['dropdown'] as $navDrop): ?>
          <li><a href="<?php echo e($navDrop['href']); ?>"><?php echo e($navDrop['name']); ?></a></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <div class="mobile-menu-cta">
    <a class="btn btn-accent btn-lg" href="<?php echo e($navPhoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
    <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
    <a class="btn btn-outline-white btn-lg" href="mailto:<?php echo e($email); ?>"><?php echo icon('mail', 18); ?> Email <?php echo e($siteName); ?></a>
  </div>
</div>
