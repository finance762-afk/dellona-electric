<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ---------------------------------------------------------------------------
 * /service-areas/reedsburg/ — Phase 6 area page (researched 2026-10-22).
 * Company facts trace to build-plan.json / config.php and the client photos only.
 * No claims about past jobs in Reedsburg, no license/insurance/hours/prices/"free"
 * (all unconfirmed — see /content-confirmations.json).
 *
 * SOURCES
 *   Wikipedia, Reedsburg, Wisconsin — https://en.wikipedia.org/wiki/Reedsburg,_Wisconsin
 *     (2020 pop. 9,984; Baraboo River + Babb, Hay and Copper creeks; Lake Virginia; Main Street
 *      Commercial and Park Street historic districts, NRHP 1984, buildings 1873–1920; 400 State
 *      Trail to Elroy, ~22 mi, opened 1993; City Park donated 1848; Webb Park; 90th meridian marker;
 *      Butterfest since 1971; floods of 2008 and 2018)
 *   Housing age (American Community Survey via NeighborhoodScout, 2024 data) —
 *     https://www.neighborhoodscout.com/wi/reedsburg/real-estate
 *     (1939 or older 13.3% · 1940–1969 14.5% · 1970–1999 38.1% · 2000 or newer 34.1%)
 *   2018 flooding, west-side neighborhoods —
 *     https://www.wkow.com/archive/reedsburg-flooding-calls-for-duck-boats-as-neighborhoods-go-under-water/article_cae344d3-cf94-50b3-883f-94ca74b15326.html
 *     https://www.wiba.com/content/2018-09-05-reedsburg-braces-for-a-second-flood-within-a-week/
 *   Reedsburg Utility Commission (municipal electric + water + LightSpeed fiber, est. 1894;
 *     "New Construction / Meter Upgrade Application") — https://www.reedsburgutility.com/
 *     https://communitynetworks.org/content/wisconsin-gets-gig-reedsburg
 *   City of Reedsburg Building Inspection — https://www.reedsburgwi.gov/buildingsafety
 *   Town of Reedsburg building ordinance (adopts Wisconsin UDC SPS 320-325 incl. electrical) —
 *     https://tn.reedsburg.wi.gov/pdfs/building-ordinance
 *   Town of Dellona building page (GEC permit portal, Sauk County zoning) — https://www.dellonawi.gov/building
 *   Census geocoder: E8981 Briar Bluff Rd → Dellona town, Sauk County (43.5566 N, 89.8740 W);
 *     Reedsburg city centre 43.5325 N, 90.0026 W → ~6.6 mi straight line, east-northeast.
 *     https://geocoding.geo.census.gov/geocoder/
 *   2023 USDA Plant Hardiness Zone, ZIP 53959: 5a (-20 to -15 °F) — https://planthardiness.ars.usda.gov/
 *     (cross-checked via https://phzmapi.org/53959.json)
 *   ELEVATION: sources conflict — TopoQuest 895 ft (city), USGS GNIS 902 ft, NOAA COOP station 905 ft,
 *     airport C35 906 ft, USGS 3DEP spot heights 906–962 ft across town. Published as a range.
 *   Water-damaged electrical equipment: NEMA GD 1-2019, "Evaluating Water-Damaged Electrical Equipment" —
 *     https://www.nj.gov/dca/codes/publications/pdf_other/NEMA_GD_1__2019.pdf
 *   NOT USED (unverified): which utility serves rural addresses outside city limits; any
 *     neighbourhood names beyond the sources above; a confirmed service radius.
 * ------------------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/service-helpers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/area-helpers.php';

$area = [
    'name'   => 'Reedsburg',
    'slug'   => 'reedsburg',
    'county' => 'Sauk',
    'sameAs' => 'https://en.wikipedia.org/wiki/Reedsburg,_Wisconsin',
];
$citySlug        = $area['slug'];
$pageTitle       = 'Electrician in Reedsburg, WI | Electrical Repair | Dellona';
$pageDescription = 'Electrical repair in Reedsburg, WI: older-home wiring, panel upgrades with Reedsburg Utility, flood-damaged circuits and generators. Call (608) 477-8453.';
$canonicalUrl    = $siteUrl . '/service-areas/' . $area['slug'] . '/';
$currentPage     = 'service-areas';
$pageType        = 'city';

$heroImage   = 'garage-exterior-lighting-night-v1';
$heroSizes   = '(max-width: 900px) 100vw, 54vw';
$heroPreload = ['srcset' => p1_srcset($heroImage, 'avif'), 'sizes' => $heroSizes];
$ogImage     = '/assets/images/' . $heroImage . '.jpg';

$heroFormTitle = 'Need an electrician in Reedsburg?';

/* Service cards: six services whose catalog photos are not already used on this page. */
$rbCards = ['electrical-repair', 'emergency-electrician', 'commercial-electrical', 'ev-charger-installation', 'lighting-installation', 'smoke-detector-installation'];

$schemaMarkup = p1_area_schema($area, $pageTitle, $pageDescription, $canonicalUrl, $heroImage);

$phoneHref = 'tel:' . $phoneRaw;
?>
<?php ob_start(); ?>
<?php echo p1_service_page_css(); ?>
<?php echo p1_area_page_css(); ?>
<style>
/* ==== /service-areas/reedsburg/ — composition: town ledger, housing-era table, river band, who-to-call trio, winter split ==== */
.pg-reedsburg .rb-intro { background: var(--color-paper); }
.pg-reedsburg .rb-intro__grid { display: grid; grid-template-columns: minmax(0, .95fr) minmax(0, 1.05fr); gap: var(--space-12); align-items: end; margin-bottom: var(--space-10); }
.pg-reedsburg .rb-intro__grid .svc-head { margin-bottom: 0; }
.pg-reedsburg .rb-intro__note { margin: 0; padding-left: var(--space-5); border-left: 4px solid var(--color-accent); color: var(--color-ink-2); }
.pg-reedsburg .rb-intro .area-ledger { background: var(--color-surface); padding-inline: var(--space-6); border-radius: var(--radius-lg); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); }
@media (max-width: 900px) { .pg-reedsburg .rb-intro__grid { grid-template-columns: 1fr; gap: var(--space-6); } }

/* Housing era — table beside the basement photo */
.pg-reedsburg .rb-homes { background: var(--color-surface); }
.pg-reedsburg .rb-homes .svc-table tbody th { width: 22%; }
.pg-reedsburg .rb-share { font-family: var(--font-accent); font-size: var(--font-size-xl); color: var(--color-ink); white-space: nowrap; }
.pg-reedsburg .rb-share__bar { display: block; height: var(--space-1); margin-top: var(--space-2); border-radius: var(--radius-full); background: linear-gradient(90deg, var(--color-accent) var(--rb-pct), var(--color-line) var(--rb-pct)); }
.pg-reedsburg .rb-homes .area-photo .img-framed { aspect-ratio: 3 / 4; }
.pg-reedsburg .rb-homes .area-split { grid-template-columns: minmax(0, 1.35fr) minmax(0, .65fr); }
@media (max-width: 900px) { .pg-reedsburg .rb-homes .area-split { grid-template-columns: 1fr; } .pg-reedsburg .rb-homes .area-photo { max-width: 26rem; } }

/* Signature: river band — dark grain, a drawn river line through the heading area */
.pg-reedsburg .rb-river { color: var(--color-white); background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-dark-alt) 70%, var(--color-primary-deep) 120%); position: relative; isolation: isolate; overflow: clip; }
.pg-reedsburg .rb-river__line { position: absolute; inset: auto 0 var(--space-8) 0; width: 100%; height: 120px; z-index: -1; opacity: .5; pointer-events: none; }
.pg-reedsburg .rb-river__line path { fill: none; stroke: var(--color-accent); stroke-width: 2; stroke-dasharray: 6 10; }
.pg-reedsburg .rb-river h2, .pg-reedsburg .rb-river h3 { color: var(--color-white); }
.pg-reedsburg .rb-river .eyebrow { color: var(--color-accent-bright); }
.pg-reedsburg .rb-river p { color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.pg-reedsburg .rb-river p.answer-block { color: var(--color-white); background: color-mix(in srgb, var(--color-white) 7%, transparent); }
.pg-reedsburg .rb-river__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: var(--space-12); align-items: start; }
.pg-reedsburg .rb-river .area-steps { background: color-mix(in srgb, var(--color-white) 6%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); border-radius: var(--radius-lg); padding: var(--space-6); backdrop-filter: blur(6px); }
.pg-reedsburg .rb-river .area-steps span { color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.pg-reedsburg .rb-river a:not(.btn) { color: var(--color-accent-bright); text-decoration: underline; text-underline-offset: 3px; }
@media (max-width: 900px) { .pg-reedsburg .rb-river__grid { grid-template-columns: 1fr; gap: var(--space-8); } }

/* Who to call — three offices, tints rotate */
.pg-reedsburg .rb-offices { background: var(--color-paper-2); }
.pg-reedsburg .area-office:nth-child(1) { background: var(--color-card-tint-1); }
.pg-reedsburg .area-office:nth-child(2) { background: var(--color-card-tint-2); }
.pg-reedsburg .area-office:nth-child(3) { background: var(--color-card-tint-3); }

/* Winter split — generator photo left, stat chip on the photo */
.pg-reedsburg .rb-winter { background: var(--color-paper); }
.pg-reedsburg .rb-winter .area-photo { position: relative; }
.pg-reedsburg .rb-zone { position: absolute; right: calc(-1 * var(--space-5)); top: var(--space-8); display: grid; gap: var(--space-1); max-width: 13rem; padding: var(--space-4) var(--space-5); border-radius: var(--radius); background: var(--color-dark); color: var(--color-white); box-shadow: var(--shadow-lg); }
.pg-reedsburg .rb-zone b { font-family: var(--font-accent); font-size: clamp(2.2rem, 1.6rem + 2vw, 3.2rem); line-height: .95; color: var(--color-accent-bright); }
.pg-reedsburg .rb-zone span { font-size: var(--font-size-xs); color: color-mix(in srgb, var(--color-white) 80%, transparent); }
@media (max-width: 900px) { .pg-reedsburg .rb-zone { right: var(--space-4); } }

/* Services + why */
.pg-reedsburg .rb-services { background: var(--color-surface); }
.pg-reedsburg .rb-services .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.pg-reedsburg .rb-all { margin-top: var(--space-10); display: grid; gap: var(--space-4); }
.pg-reedsburg .rb-all h3 { font-size: var(--font-size-lg); }
@media (max-width: 900px) { .pg-reedsburg .rb-services .services-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 560px) { .pg-reedsburg .rb-services .services-grid { grid-template-columns: 1fr; } }
.pg-reedsburg .rb-why { background: var(--color-paper-2); }
.pg-reedsburg .rb-why .area-photo .img-framed { aspect-ratio: 3 / 4; max-width: 24rem; }
</style>
<?php $headExtra = ob_get_clean(); ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main id="main-content" class="pg-reedsburg">

  <!-- 1. HERO — layered dark band, lit garage photo right, compact estimate card -->
  <section class="hero hero--interior svc-hero" aria-labelledby="area-title">
    <div class="svc-hero__media">
      <?php echo p1_picture($heroImage, 'Newly built garage lit at night by exterior wall lights, both overhead doors open', ['sizes' => $heroSizes, 'priority' => true]); ?>
    </div>
    <div class="container">
      <?php echo p1_area_breadcrumb($area['name']); ?>
      <div class="hero-grid hero-grid--form">
        <div class="hero-copy">
          <span class="eyebrow">Service area · Sauk County, Wisconsin</span>
          <h1 class="hero-title" id="area-title">Electrical repair services in <span class="text-accent">Reedsburg, WI</span></h1>
          <p class="hero-answer">Dellona Electric is a Wisconsin electrician based on Briar Bluff Rd, about six and a half miles east of downtown Reedsburg. The crew handles electrical repair across the city, from century-old wiring near Main Street to panel and charger upgrades in newer homes.</p>
          <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
            <a class="link-call" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> or call <?php echo e($phone); ?></a>
          </div>
          <ul class="hero-chips">
            <li><?php echo icon('map-pin', 16); ?> Briar Bluff Rd shop</li>
            <li><?php echo icon('calendar-check', 16); ?> Since <?php echo (int) $yearEstablished; ?></li>
            <li><?php echo icon('wrench', 16); ?> 15 services</li>
          </ul>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/hero-form.php'; ?>
      </div>
    </div>
  </section>

  <article class="area-article" aria-labelledby="area-title">

    <!-- 2. TOWN LEDGER — what shapes electrical work here -->
    <section class="section rb-intro" aria-labelledby="intro-title">
      <div class="container-wide">
        <div class="rb-intro__grid">
          <div class="svc-head reveal-left">
            <span class="eyebrow">The city at a glance</span>
            <h2 id="intro-title">What shapes electrical work in Reedsburg?</h2>
            <p class="answer-block">Three things shape most electrical jobs in Reedsburg: a housing stock that runs from 1870s storefronts to homes built since 2000, a city-owned electric utility that handles meters and service changes, and the Baraboo River, which flooded parts of the city in 2008 and again in 2018.</p>
          </div>
          <p class="rb-intro__note reveal-right">Reedsburg grew up around David C. Reed's 1847 dam on the Baraboo River and became a city in 1887. Babb Creek, Hay Creek and Copper Creek all run through town to the river, and Lake Virginia sits on the east side. The city sits at roughly 895 to 960 feet above sea level, depending on where in town you measure and which survey you read.</p>
        </div>
        <ul class="area-ledger reveal-up">
          <li><b>9,984</b><span>Reedsburg residents at the 2020 census</span><cite>U.S. Census</cite></li>
          <li><b>1894</b><span>Year the city's own utility, now Reedsburg Utility Commission, started electric service</span><cite>Reedsburg Utility</cite></li>
          <li><b>28<small>%</small></b><span>Share of city homes built before 1970, the era of cloth-sheathed and ungrounded wiring</span><cite>American Community Survey</cite></li>
          <li><b>5a</b><span>2023 USDA zone for ZIP 53959: winter lows of −20 to −15 °F</span><cite>USDA</cite></li>
        </ul>
      </div>
    </section>

    <!-- 3. HOUSING ERA — real table + basement photo -->
    <section class="section rb-homes edge-torn-top" aria-labelledby="homes-title">
      <div class="container-wide">
        <div class="area-split">
          <div class="area-split__copy svc-body reveal-left">
            <span class="eyebrow">Homes by age</span>
            <h2 id="homes-title">What wiring is behind the walls of Reedsburg's homes and downtown buildings?</h2>
            <p class="answer-block">The wiring in a Reedsburg building usually matches its age. About 13% of the city's homes were built before 1940 and may still carry knob-and-tube. Homes from 1940 to 1969 often have cloth-sheathed cable with no ground, and the third of homes built since 2000 mostly need capacity, not repair.</p>
            <p>Downtown is the oldest wiring in town. The Main Street Commercial and Park Street historic districts, both listed on the National Register in 1984, are made up of buildings from 1873 to 1920. Many have been rewired in pieces over a century, so a storefront circuit and an upstairs apartment can run on very different generations of wire. For businesses, Dellona Electric's <a href="/services/commercial-electrical/">commercial electrical work</a> covers lighting, new equipment circuits and repairs in that kind of building.</p>
            <div class="svc-table-wrap">
              <table class="svc-table">
                <caption>Share of the city's housing units by year built (American Community Survey estimates). Wiring types are typical for each era, not a promise about any one house.</caption>
                <thead><tr><th scope="col">Built</th><th scope="col">Share of homes</th><th scope="col">Wiring you are likely to find</th></tr></thead>
                <tbody>
                  <tr><th scope="row">1939 or earlier</th><td><span class="rb-share">13.3%</span><span class="rb-share__bar" style="--rb-pct: 13.3%"></span></td><td>Knob-and-tube, later circuits spliced onto it, fuse boxes swapped for breakers</td></tr>
                  <tr><th scope="row">1940 – 1969</th><td><span class="rb-share">14.5%</span><span class="rb-share__bar" style="--rb-pct: 14.5%"></span></td><td>Cloth-sheathed cable, two-prong outlets, small panels</td></tr>
                  <tr><th scope="row">1970 – 1999</th><td><span class="rb-share">38.1%</span><span class="rb-share__bar" style="--rb-pct: 38.1%"></span></td><td>Grounded cable; panels often full after decades of added circuits</td></tr>
                  <tr><th scope="row">2000 or later</th><td><span class="rb-share">34.1%</span><span class="rb-share__bar" style="--rb-pct: 34.1%"></span></td><td>Modern grounded wiring; the question is room for chargers, heat pumps and additions</td></tr>
                </tbody>
              </table>
            </div>
            <p>If your house falls in the first two rows, start with <a href="/services/wiring-rewiring/">wiring repair and rewiring</a>. If it falls in the last two, the usual question is whether the panel can take one more big load.</p>
          </div>
          <figure class="area-photo reveal-right">
            <div class="img-framed">
              <?php echo p1_picture('panel-work-basement-v1', 'Two Dellona Electric electricians working at a breaker panel in an unfinished basement with log joists overhead', ['sizes' => '(max-width: 900px) 90vw, 380px']); ?>
            </div>
            <figcaption>Panel work in an older basement, cable runs dressed along the joists.</figcaption>
          </figure>
        </div>
      </div>
    </section>

    <!-- 4. SIGNATURE — river band: after a flood -->
    <section class="section rb-river texture-grain slant-top" aria-labelledby="river-title">
      <span class="grain-layer" aria-hidden="true"></span>
      <svg class="rb-river__line" viewBox="0 0 1200 120" preserveAspectRatio="none" aria-hidden="true" focusable="false"><path d="M0 70 C 150 20, 260 110, 420 64 S 700 18, 860 72 S 1080 104, 1200 48"/></svg>
      <div class="container-wide">
        <div class="rb-river__grid">
          <div class="svc-head reveal-left">
            <span class="eyebrow">When the Baraboo River rises</span>
            <h2 id="river-title">What should Reedsburg homeowners do with wiring after the Baraboo River floods a basement?</h2>
            <p class="answer-block">After a Reedsburg basement floods, leave the breakers off and have an electrician check every piece of equipment the water reached before power goes back on. Breakers, panels, outlets and GFCI devices that sat underwater are replaced, not dried out and reused.</p>
            <p>The Baraboo River flooded Reedsburg in 2008 and again in late summer 2018, when streets in west-side neighborhoods were passable only by boat and residents were warned of a second crest within a week. In a flooded basement the panel, the furnace and water-heater circuits, the sump pump outlet and the laundry circuits are usually the first things underwater.</p>
            <p>NEMA's guide to water-damaged electrical equipment calls for replacing submerged breakers, GFCI and AFCI devices, surge protectors and smoke alarms, because there is no reliable way to confirm they will still work after the water is gone. If a storm or flood has left part of the house without power, see <a href="/services/emergency-electrician/">emergency electrical repair</a>.</p>
          </div>
          <div class="reveal-right">
            <h3 class="sr-only">After a flood, step by step</h3>
            <ol class="area-steps">
              <li><b>Stay out of standing water</b><span>Never walk into a flooded basement to reach the panel. If the main breaker is underwater or you can't reach it safely, call Reedsburg Utility, or your own utility outside the city, to cut power at the meter.</span></li>
              <li><b>Don't reset anything</b><span>Leave breakers and GFCI outlets that tripped alone until they have been looked at. A breaker that sat in water can fail to trip the next time it needs to.</span></li>
              <li><b>Mark the water line</b><span>Note how high the water reached on walls and equipment. That line decides which outlets, boxes and cable runs need replacing.</span></li>
              <li><b>Replace, test, then re-energize</b><span>Wet devices and panel parts are swapped out, circuits are tested, and power comes back one circuit at a time.</span></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. WHO TO CALL — utility + inspectors by jurisdiction -->
    <section class="section rb-offices edge-curve-top" aria-labelledby="offices-title">
      <div class="container-wide">
        <div class="svc-head reveal-up">
          <span class="eyebrow">Permits and the utility</span>
          <h2 id="offices-title">Who else is involved in a Reedsburg panel or service upgrade?</h2>
          <p class="answer-block">Inside Reedsburg city limits, a panel or service upgrade involves two local offices besides the electrician: Reedsburg Utility Commission, which supplies the power and owns the meter, and the City of Reedsburg Building Inspection Department, which handles permits. Properties in the surrounding towns go through their own inspector instead.</p>
        </div>
        <div class="area-offices">
          <div class="area-office reveal-up reveal-delay-1">
            <span class="area-office__tag">The utility</span>
            <h3>Reedsburg Utility Commission</h3>
            <p>The city has run its own utility since 1894. Today it supplies electricity, water and LightSpeed fiber internet. Its electric department takes a New Construction / Meter Upgrade Application when a service is being upsized, so the meter work is scheduled alongside the new panel. Dellona Electric's <a class="svc-inline-link" href="/services/panel-upgrades/">panel upgrades</a> page explains when a bigger service makes sense.</p>
          </div>
          <div class="area-office reveal-up reveal-delay-2">
            <span class="area-office__tag">Inside the city</span>
            <h3>City of Reedsburg Building Inspection</h3>
            <p>The City's Building Inspection Department issues permits for work on homes and businesses within city limits and lists electrical alterations among the work that may need one. New circuits, panel changes and service upgrades are typical examples.</p>
          </div>
          <div class="area-office reveal-up reveal-delay-3">
            <span class="area-office__tag">Outside the city</span>
            <h3>Town of Reedsburg and Town of Dellona</h3>
            <p>The Town of Reedsburg's building ordinance adopts the Wisconsin Uniform Dwelling Code, electrical systems included. The Town of Dellona sits under Sauk County zoning and takes permits through its inspector's online portal. Its building page also notes that electrical work requires state licensing.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- 6. WINTER — generator photo, zone chip -->
    <section class="section rb-winter" aria-labelledby="winter-title">
      <div class="container">
        <div class="area-split area-split--flip">
          <div class="area-split__copy svc-body reveal-right">
            <span class="eyebrow">Outages in a zone 5a winter</span>
            <h2 id="winter-title">How can a Reedsburg home keep its heat on during a winter power outage?</h2>
            <p class="answer-block">A standby generator wired through a transfer switch keeps a Reedsburg home's furnace, well or sump pump and freezer running when the power goes out. A portable generator connected through an inlet and interlock covers the same essential circuits for less money, as long as someone is home to start it.</p>
            <p>ZIP code 53959 sits in USDA hardiness zone 5a, where the coldest night of a typical year reaches −20 to −15 °F. In weather like that, a long outage turns into frozen pipes quickly. A gas furnace still needs electricity for its blower and controls, and rural homes on wells lose water as soon as the pump stops.</p>
            <p>The photo shows Dellona Electric's crew running conduit beside a Kohler standby generator at a log home. Sizing, transfer switches and fuel choices are covered on the <a href="/services/generator-installation/">generator installation</a> page, and <a href="/services/surge-protection/">whole-house surge protection</a> protects electronics when the power comes back on with a spike.</p>
          </div>
          <figure class="area-photo reveal-left">
            <div class="img-framed">
              <?php echo p1_picture('standby-generator-log-home-v1', 'Two Dellona Electric electricians running conduit beside a Kohler standby generator at a log home', ['sizes' => '(max-width: 900px) 90vw, 420px']); ?>
            </div>
            <figcaption class="rb-zone"><b>−20 °F</b><span>Typical coldest night of the year in zone 5a, ZIP 53959</span></figcaption>
          </figure>
        </div>
      </div>
    </section>

    <!-- 7. SERVICES AVAILABLE — required services-grid + full list -->
    <section class="section rb-services edge-wave-top" aria-labelledby="rb-services-title">
      <div class="container-wide">
        <div class="section-title reveal-up">
          <span class="eyebrow-label">What We Do</span>
          <h2 id="rb-services-title">Which <span class="text-accent">electrical services</span> can you book in Reedsburg?</h2>
          <p class="hero-answer">Dellona Electric offers all 15 of its electrical services in Reedsburg. Rewiring, panel upgrades and generators are covered above. The six below round out what the city's buildings need: troubleshooting and urgent repair after storms and floods, commercial work for downtown storefronts, chargers and lighting for newer homes, and hardwired smoke alarms.</p>
          <span class="section-subtitle">More of what we do</span>
        </div>
        <?php echo p1_service_cards($rbCards); ?>
        <div class="rb-all reveal-up">
          <h3>Every other service</h3>
          <div class="service-links">
            <?php foreach ($services as $rbSvc):
                if (in_array($rbSvc['slug'], $rbCards, true)) continue;
                $rbHref = '/services/' . $rbSvc['slug'] . '/';
                if (!p1_page_exists($rbHref)) continue; ?>
            <a class="service-link-card" href="<?php echo e($rbHref); ?>"><?php echo e($rbSvc['name']); ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>

    <!-- 8. WHY US — crew photo + reasons -->
    <section class="section rb-why" aria-labelledby="why-title">
      <div class="container">
        <div class="area-split">
          <div class="area-split__copy reveal-left">
            <span class="eyebrow">Why Dellona Electric</span>
            <h2 id="why-title">Why do Reedsburg homeowners and businesses call Dellona Electric?</h2>
            <p class="answer-block">Dellona Electric is a local, owner-run electrical company with its shop in the Town of Dellona, a short drive east of Reedsburg. Owner Edward Giannoni has run it since 2018, and the same crew handles the diagnosis, the panel and the wiring on a job.</p>
            <ul class="area-why">
              <li><?php echo icon('map-pin', 22); ?><b>Close by, not passing through</b><span>The shop at E8981 Briar Bluff Rd carries a Reedsburg mailing address, about six and a half miles from downtown.</span></li>
              <li><?php echo icon('layers', 22); ?><b>One crew from panel to fixture</b><span>The crew that traces a fault in an older house also wires panels, generators, lighting and new construction, so one call covers the whole job.</span></li>
              <li><?php echo icon('users', 22); ?><b>Real photos of real work</b><span>Every photo on this page is Dellona Electric's own job site, from basement panel work to a standby generator at a log home.</span></li>
            </ul>
            <p class="svc-body">Not in the city itself? See <a href="/service-areas/">the full Dellona Electric service area</a>, or call <?php echo e($phone); ?> with your address.</p>
          </div>
          <figure class="area-photo reveal-right">
            <div class="img-framed">
              <?php echo p1_picture('crew-company-truck-v1', 'Two members of the Dellona Electric crew standing beside the lettered company truck', ['sizes' => '(max-width: 900px) 80vw, 384px']); ?>
            </div>
            <figcaption>The Dellona Electric crew and truck.</figcaption>
          </figure>
        </div>
      </div>
    </section>

  </article>

  <!-- 9. CTA -->
  <section class="closing-cta svc-cta texture-grain edge-parallelogram-top" aria-labelledby="rb-cta-title">
    <span class="grain-layer" aria-hidden="true"></span>
    <div class="container-wide reveal-up">
      <div>
        <span class="eyebrow">Estimates</span>
        <h2 id="rb-cta-title">Request an Estimate in Reedsburg</h2>
        <p>Call <?php echo e($phone); ?> or send the estimate form with your street, the age of the building and what's going on, whether that's a breaker that won't stay on, a basement that took water, or a panel with no room left. Dellona Electric will call you back.</p>
      </div>
      <div class="actions">
        <a class="btn btn-accent btn-lg" href="<?php echo e($phoneHref); ?>"><?php echo icon('phone', 18); ?> Call <?php echo e($phone); ?></a>
        <button type="button" class="btn btn-outline-white btn-lg" data-open-estimate><?php echo e($estimateCtaLabel); ?></button>
      </div>
    </div>
  </section>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
