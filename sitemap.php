<?php
/**
 * sitemap.php — dynamic XML sitemap. .htaccess rewrites /sitemap.xml here, so robots.txt
 * and Search Console always reference /sitemap.xml. Never ship a static sitemap.xml.
 *
 * Page registry: the static pages below + config.php $services + $serviceAreas, plus
 * $blogPosts from includes/blog-data.php once real posts exist. A URL is listed only
 * when its page is on disk (p1_page_exists). Never listed: the noindexed /blog/
 * placeholder, /thank-you and 404.php.
 * Priorities: home 1.0 · services 0.8 · other pages 0.6 · legal 0.3 (yearly).
 * Image entries: each page's hero photo, with the alt text from its p1_picture() call.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$smRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
$smBase = rtrim($siteUrl, '/');

/** Page file behind a trailing-slash path. */
function sm_page_file(string $path): string {
    global $smRoot;
    return $smRoot . $path . 'index.php';
}

/** Hero image entry for a page: its $heroImage photo and the alt text passed to p1_picture(). */
function sm_hero_image(string $file): array {
    global $smRoot;
    $src = is_file($file) ? (string) file_get_contents($file) : '';
    if (!preg_match('/\$heroImage\s*=\s*\'([a-z0-9-]+)\'/', $src, $img)) return [];
    if (!is_file($smRoot . '/assets/images/' . $img[1] . '.jpg')) return [];
    $caption = '';
    if (preg_match('/p1_picture\(\$heroImage,\s*\'((?:[^\'\\\\]|\\\\.)*)\'/', $src, $alt)) {
        $caption = stripslashes($alt[1]);
    }
    return [['src' => '/assets/images/' . $img[1] . '.jpg', 'caption' => $caption]];
}

$smPages = [];
$smAdd = function (string $path, string $changefreq, string $priority) use (&$smPages) {
    if (!p1_page_exists($path)) return;
    $file = sm_page_file($path);
    $smPages[] = [
        'path'       => $path,
        'lastmod'    => date('Y-m-d', is_file($file) ? filemtime($file) : time()),
        'changefreq' => $changefreq,
        'priority'   => $priority,
        'images'     => sm_hero_image($file),
    ];
};

$smAdd('/', 'weekly', '1.0');
$smAdd('/services/', 'monthly', '0.8');
foreach ($services as $smSvc) {
    $smAdd('/services/' . $smSvc['slug'] . '/', 'monthly', '0.8');
}
$smAdd('/service-areas/', 'monthly', '0.6');
foreach ($serviceAreas as $smArea) {
    $smAdd('/service-areas/' . $smArea['slug'] . '/', 'monthly', '0.6');
}
foreach (['/about/', '/contact/', '/faq/'] as $smPath) {
    $smAdd($smPath, 'monthly', '0.6');
}
foreach (['/privacy-policy/', '/terms/', '/cookie-policy/', '/accessibility/'] as $smPath) {
    $smAdd($smPath, 'yearly', '0.3');
}

/* Blog posts join automatically once the registry exists (the /blog/ index stays out
 * while it is the noindexed "coming soon" placeholder). */
$blogPosts = [];
if (is_file($smRoot . '/includes/blog-data.php')) {
    require $smRoot . '/includes/blog-data.php';
}
if (!empty($blogPosts)) {
    /* The blog hub is the parent of the post URLs; it is listed only once posts exist. */
    $smAdd(preg_replace('#[^/]+/$#', '', '/blog/' . $blogPosts[0]['slug'] . '/'), 'weekly', '0.6');
    foreach ($blogPosts as $smPost) {
        $smPath = '/blog/' . $smPost['slug'] . '/';
        if (!p1_page_exists($smPath)) continue;
        $smPages[] = [
            'path'       => $smPath,
            'lastmod'    => $smPost['dateISO'] ?? date('Y-m-d', filemtime(sm_page_file($smPath))),
            'changefreq' => 'monthly',
            'priority'   => '0.6',
            'images'     => !empty($smPost['image']) ? [['src' => $smPost['image'], 'caption' => $smPost['alt'] ?? '']] : [],
        ];
    }
}

header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<?php foreach ($smPages as $smPage): ?>
  <url>
    <loc><?php echo htmlspecialchars($smBase . $smPage['path'], ENT_XML1); ?></loc>
    <lastmod><?php echo $smPage['lastmod']; ?></lastmod>
    <changefreq><?php echo $smPage['changefreq']; ?></changefreq>
    <priority><?php echo $smPage['priority']; ?></priority>
<?php foreach ($smPage['images'] as $smImg): ?>
    <image:image>
      <image:loc><?php echo htmlspecialchars(strpos($smImg['src'], 'http') === 0 ? $smImg['src'] : $smBase . $smImg['src'], ENT_XML1); ?></image:loc>
<?php if ($smImg['caption'] !== ''): ?>
      <image:caption><?php echo htmlspecialchars($smImg['caption'], ENT_XML1); ?></image:caption>
<?php endif; ?>
    </image:image>
<?php endforeach; ?>
  </url>
<?php endforeach; ?>
</urlset>
