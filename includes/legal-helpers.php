<?php
/**
 * includes/legal-helpers.php — Phase 5 shared pieces for the four legal pages
 * (/privacy-policy/, /terms/, /cookie-policy/, /accessibility/) per legal-compliance.md.
 *   p1_legal_page_css()        shared legal CSS (tokens only) — each page adds its own <style>
 *   p1_legal_dates()           Effective / Last Updated chips for the 40vh .hero--legal (pages write their own H1)
 *   p1_legal_breadcrumb()      breadcrumb bar under the hero
 *   p1_legal_toc()             sticky "On this page" list (collapses on mobile)
 *   p1_legal_contact_block()   the standard contact block every legal page ends with
 *   p1_legal_schema()          WebPage + BreadcrumbList nodes for head.php's @graph
 * Legal pages carry no reveal classes and no attorney-review disclaimer (Sep 29 2026 rule).
 * Scratch variables are $lg-prefixed (shared-include variable rule).
 */

/* Fixed review date. A date('F j, Y') stamp would claim the policy changed on every visit;
 * bump this string whenever a legal page's text actually changes. */
$legalUpdated = 'October 22, 2026';

function p1_legal_page_css(): string {
    ob_start(); ?>
<style>
/* ==== Legal pages — shared (Phase 5). Clean and functional: no image hero, no reveals. ==== */
.pg-legal h1, .pg-legal h2, .pg-legal h3 { text-wrap: balance; }

/* -- 40vh solid hero: brushed dark band, faint glow + grain, copy anchored low -- */
.pg-legal .hero--legal { position: relative; isolation: isolate; overflow: clip; min-height: 40vh; display: flex; align-items: flex-end; background: linear-gradient(120deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 130%); }
.pg-legal .hero--legal::before { content: ""; position: absolute; z-index: -1; pointer-events: none; inset: -50% -20% -40% 55%; background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 16%, transparent), transparent 70%); }
.pg-legal .hero--legal::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .25; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.55'/%3E%3C/svg%3E");
}
.pg-legal .hero--legal .container { width: 100%; }
.pg-legal .lg-hero__copy { display: grid; gap: var(--space-3); max-width: 46rem; }
.pg-legal .lg-hero__copy .section-subtitle { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: color-mix(in srgb, var(--color-white) 70%, transparent); }
.pg-legal .lg-hero__copy p { margin: 0; color: color-mix(in srgb, var(--color-white) 84%, transparent); max-width: 40rem; }
.pg-legal .lg-dates { display: flex; flex-wrap: wrap; gap: var(--space-2); margin-top: var(--space-2); }
.pg-legal .lg-dates span { display: inline-flex; gap: var(--space-2); align-items: center; padding: var(--space-1) var(--space-3); border-radius: var(--radius-full); font-size: var(--font-size-sm); color: var(--color-white); background: color-mix(in srgb, var(--color-white) 8%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 16%, transparent); }
.pg-legal .lg-dates svg { color: var(--color-accent-bright); }

/* -- Breadcrumb bar -- */
.pg-legal .lg-crumbs { margin: 0; padding-block: var(--space-2); background: var(--color-surface); border-bottom: 1px solid var(--color-line); }
.pg-legal .lg-crumbs [aria-current] { color: var(--color-ink); font-weight: 600; }
.pg-legal .lg-crumbs a:hover { color: var(--color-primary); text-decoration: underline; }

/* -- Body: sticky contents list + narrow prose column -- */
.pg-legal .lg-body { background: var(--color-paper); padding-block: clamp(2.5rem, 6vw, 4.5rem); }
.pg-legal .lg-layout { display: grid; grid-template-columns: minmax(200px, 250px) minmax(0, 1fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.pg-legal .lg-toc { position: sticky; top: calc(var(--nav-height) + var(--space-6)); padding: var(--space-5); border-radius: var(--radius-lg); background: var(--color-surface); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); }
.pg-legal .lg-toc summary { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); cursor: pointer; list-style: none; }
.pg-legal .lg-toc summary::-webkit-details-marker { display: none; }
.pg-legal .lg-toc ol { list-style: none; margin: var(--space-3) 0 0; padding: 0; display: grid; gap: var(--space-1); counter-reset: lgtoc; }
.pg-legal .lg-toc li { counter-increment: lgtoc; }
.pg-legal .lg-toc a { text-decoration: none; display: grid; grid-template-columns: 1.8rem 1fr; padding: var(--space-1) 0; font-size: var(--font-size-sm); color: var(--color-ink-2); border-radius: var(--radius-sm); transition: color var(--transition); }
.pg-legal .lg-toc a::before { content: counter(lgtoc) "."; color: var(--color-accent-dark); font-weight: 700; }
.pg-legal .lg-toc a:hover { color: var(--color-ink); }
.pg-legal .legal-prose { max-width: 65ch; }
.pg-legal .legal-prose > p:first-child { font-size: var(--fs-lead); color: var(--color-ink); }
.pg-legal .legal-prose h2 { color: var(--color-ink); font-size: var(--fs-h3); margin-top: var(--space-10); margin-bottom: var(--space-3); padding-top: var(--space-6); border-top: 1px solid var(--color-line); scroll-margin-top: calc(var(--nav-height) + var(--space-4)); }
.pg-legal .legal-prose h3 { color: var(--color-ink); font-size: var(--font-size-lg); margin-top: var(--space-6); margin-bottom: var(--space-2); scroll-margin-top: calc(var(--nav-height) + var(--space-4)); }
.pg-legal .legal-prose p, .pg-legal .legal-prose li { color: var(--color-ink-2); line-height: 1.7; }
.pg-legal .legal-prose p { margin: 0 0 var(--space-3); }
.pg-legal .legal-prose ul, .pg-legal .legal-prose ol { margin: 0 0 var(--space-4) var(--space-5); padding: 0; }
.pg-legal .legal-prose li { margin-bottom: var(--space-2); }
.pg-legal .legal-prose li::marker { color: var(--color-accent-dark); }
.pg-legal .legal-prose strong { color: var(--color-ink); }
.pg-legal .legal-prose a { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-decoration-color: color-mix(in srgb, var(--color-accent) 70%, transparent); text-decoration-thickness: 2px; text-underline-offset: 3px; transition: text-decoration-color var(--transition); }
.pg-legal .legal-prose a:hover { text-decoration-color: var(--color-primary); }

/* -- Contact block + last-updated footer line -- */
.pg-legal .lg-contact { margin-top: var(--space-6); padding: var(--space-6); border-radius: var(--radius-lg); background: var(--color-surface); border: 1px solid var(--color-line); border-left: 4px solid var(--color-accent); box-shadow: var(--shadow-sm); display: grid; gap: var(--space-3); }
.pg-legal .lg-contact b { font-family: var(--font-heading); font-size: var(--font-size-lg); color: var(--color-ink); }
.pg-legal .lg-contact ul { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-2); }
.pg-legal .lg-contact li { display: flex; gap: var(--space-3); align-items: center; margin: 0; }
.pg-legal .lg-contact svg { color: var(--color-accent-dark); flex: 0 0 auto; }
.pg-legal .lg-updated { margin-top: var(--space-8); font-size: var(--font-size-sm); color: var(--color-muted); }

/* -- Small closing band (curved edge) -- */
.pg-legal .lg-band { background: var(--color-paper-2); padding-block: var(--space-12); }
.pg-legal .lg-band .container { display: flex; flex-wrap: wrap; gap: var(--space-4); align-items: center; justify-content: space-between; }
.pg-legal .lg-band p { margin: 0; color: var(--color-ink-2); max-width: 60ch; }
.pg-legal .lg-band nav { display: flex; flex-wrap: wrap; gap: var(--space-2); }

@media (max-width: 900px) {
  .pg-legal .lg-layout { grid-template-columns: 1fr; }
  .pg-legal .lg-toc { position: static; }
}
</style>
<?php
    return (string) ob_get_clean();
}

/** Effective / Last Updated chips for the top of the 40vh .hero--legal (each page writes its own hero and H1). */
function p1_legal_dates(): string {
    global $legalUpdated;
    return '<div class="lg-dates"><span>' . icon('calendar', 16) . ' Effective Date: ' . e($legalUpdated) . '</span>'
         . '<span>' . icon('clock', 16) . ' Last Updated: ' . e($legalUpdated) . '</span></div>';
}

function p1_legal_breadcrumb(string $name): string {
    return '<nav class="breadcrumb lg-crumbs" aria-label="Breadcrumb"><div class="container"><ol>'
         . '<li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">›</li>'
         . '<li aria-current="page">' . e($name) . '</li></ol></div></nav>';
}

/** Sticky contents list. $sections = ['anchor-id' => 'Heading', ...]. Open by default; collapsible on small screens. */
function p1_legal_toc(array $sections): string {
    $out = '<details class="lg-toc" open><summary>On this page</summary><ol>';
    foreach ($sections as $lgId => $lgLabel) {
        $out .= '<li><a href="#' . e($lgId) . '">' . e($lgLabel) . '</a></li>';
    }
    return $out . '</ol></details>';
}

/** Standard contact block (every legal page ends with it). */
function p1_legal_contact_block(string $lead = 'Questions about this page, or a request about your information:'): string {
    global $companyName, $companyEmail, $companyPhone, $companyPhoneE164, $companyAddress;
    ob_start(); ?>
<div class="lg-contact">
  <p><?php echo e($lead); ?></p>
  <b><?php echo e($companyName); ?></b>
  <ul>
    <li><?php echo icon('mail', 18); ?><a href="mailto:<?php echo e($companyEmail); ?>"><?php echo e($companyEmail); ?></a></li>
    <li><?php echo icon('phone', 18); ?><a href="tel:<?php echo e($companyPhoneE164); ?>"><?php echo e($companyPhone); ?></a></li>
    <li><?php echo icon('map-pin', 18); ?><span><?php echo e($companyAddress); ?></span></li>
  </ul>
</div>
<?php
    return (string) ob_get_clean();
}

/** Closing band linking the sibling legal pages (only the ones that exist). */
function p1_legal_band(string $current): string {
    $lgPages = [['/privacy-policy/', 'Privacy Policy'], ['/terms/', 'Terms of Service'], ['/cookie-policy/', 'Cookie Policy'], ['/accessibility/', 'Accessibility']];
    $out = '<section class="lg-band edge-curve-top" aria-label="Other legal pages"><div class="container"><p>Related policies for this website and the estimate forms on it.</p><nav aria-label="Legal pages">';
    foreach ($lgPages as $lgPage) {
        if ($lgPage[0] === $current || !p1_page_exists($lgPage[0])) continue;
        $out .= '<a class="btn btn-secondary btn-sm" href="' . e($lgPage[0]) . '">' . e($lgPage[1]) . '</a>';
    }
    return $out . '</nav></div></section>';
}

/** WebPage + BreadcrumbList nodes (head.php merges them into the sitewide @graph). */
function p1_legal_schema(string $title, string $description, string $url, string $crumbName, string $crumbPath): array {
    global $legalUpdated;
    $lgPage = generateWebPageSchema($title, $description, $url);
    $lgPage['dateModified'] = date('Y-m-d', strtotime($legalUpdated));
    $lgCrumbs = generateBreadcrumbSchema([['name' => $crumbName, 'url' => $crumbPath]]);
    unset($lgCrumbs['@context']);
    return ['@graph' => [$lgPage, $lgCrumbs]];
}
