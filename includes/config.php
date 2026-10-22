<?php
/**
 * includes/config.php — site-wide configuration for Dellona Electric.
 * All pages: require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php'; before head.php.
 * Generated Phase 1 (scaffold) from build-plan.json (research brief generated 2026-10-22).
 * Pages set their own $canonicalUrl, $pageType, $serviceSlug / $citySlug — never here.
 */

/* ---------------------------------------------------------------------------
 * Identity
 * ------------------------------------------------------------------------- */
$slug            = 'dellona-electric';                      // exact build directory name
$siteName        = 'Dellona Electric';
$tagline         = '';                                      // none supplied at intake — do not invent one
$ownerName       = 'Edward Giannoni';
$phone           = '(608) 477-8453';
$phoneRaw        = '+16084778453';                          // tel: friendly (E.164)
$phoneSecondary  = '';
$email           = 'dellonaelectric@outlook.com';
$tier            = 'premium';

$address = [
    'street' => 'E8981 Briar Bluff Rd',
    'city'   => 'Reedsburg',
    'state'  => 'WI',
    'zip'    => '53959',
];
$addressPublic = true;

/* ---------------------------------------------------------------------------
 * Domain / URL
 *   build-plan.json has no production_domain → default to the preview domain.
 *   $domain must NEVER be blank; $siteUrl must always be a valid absolute URL.
 * ------------------------------------------------------------------------- */
$domain   = $slug . '.pageone.cloud';                       // dellona-electric.pageone.cloud
$siteUrl  = 'https://' . $domain;                           // absolute site root, no trailing slash
$industry = 'Electrician';

/* ---------------------------------------------------------------------------
 * Keywords — build-plan seo.primary_keyword / seo.secondary_keywords, verbatim
 * ------------------------------------------------------------------------- */
$primaryKeyword = 'Electrical repair services';
$secondaryKeywords = [
    'Electrical wiring repair',
    'Circuit breaker repair',
    'Electrical panel repair',
    'Outlet repair',
    'Light switch repair',
    'Ceiling fan installation',
    'Lighting installation',
    'Faulty wiring repair',
    'Electrical troubleshooting',
    'Power outage repair',
    'Short circuit repair',
    'Electrician',
    'Professional electrician',
    'Licensed electrician',
    'Local electrician',
    'Residential electrician',
    'Commercial electrician',
    'Industrial electrician',
    'Electrical contractor',
    'Electrical services',
    'Electric repair services',
    'Emergency electrician',
    'Certified electrician',
    'Hire an electrician',
    'Electrician service near me',
    'Emergency electrical repair',
    'Same-day electrician',
    'Affordable electrical services',
    'Electrical contractor near me',
    'Book an electrician',
    'Electrical panel upgrade',
    'Home rewiring service',
    'Commercial electrical repair',
    'Licensed electrical company',
    '24/7 emergency electrical services',
    'EV charger installation',
    'Generator installation',
    'Home electrical inspection',
    'Whole-house surge protection',
    'Indoor lighting installation',
    'Outdoor lighting installation',
    'Smart home wiring',
    'Security lighting installation',
    'New construction electrical wiring',
    'Electrical maintenance services',
    'Smoke detector installation',
];

/* ---------------------------------------------------------------------------
 * Services — build-plan "services" is empty; this list groups the intake
 *   keyword list (seo.primary_keyword + seo.secondary_keywords) into 15
 *   services, under the premium cap of 16. Each: name, slug (dir under
 *   /services/), description, keywords. Descriptions are factual placeholders —
 *   the copywriter owns final client-facing copy.
 *   NOTE: business hours and after-hours availability are NOT in intake —
 *   confirm before any "24/7" or "same-day" claim on Emergency Electrical Repair.
 * ------------------------------------------------------------------------- */
$services = [
    [
        'name'        => 'Electrical Repair & Troubleshooting',
        'slug'        => 'electrical-repair',
        'description' => 'Diagnosis and repair of electrical faults in homes and businesses, including short circuits, dead circuits and partial power loss.',
        'keywords'    => ['Electrical repair services', 'Electric repair services', 'Electrical troubleshooting', 'Short circuit repair', 'Power outage repair'],
    ],
    [
        'name'        => 'Wiring Repair & Rewiring',
        'slug'        => 'wiring-rewiring',
        'description' => 'Faulty wiring repair and whole-home rewiring for older houses, additions and renovations.',
        'keywords'    => ['Electrical wiring repair', 'Faulty wiring repair', 'Home rewiring service'],
    ],
    [
        'name'        => 'Panel Repair & Upgrades',
        'slug'        => 'panel-upgrades',
        'description' => 'Electrical panel repair, circuit breaker repair and panel or service upgrades for buildings that need more capacity or a safer panel.',
        'keywords'    => ['Electrical panel repair', 'Electrical panel upgrade', 'Circuit breaker repair'],
    ],
    [
        'name'        => 'Outlet & Switch Repair',
        'slug'        => 'outlet-switch-repair',
        'description' => 'Repair and replacement of dead or loose outlets, faulty light switches and GFCI outlets.',
        'keywords'    => ['Outlet repair', 'Light switch repair'],
    ],
    [
        'name'        => 'Lighting Installation',
        'slug'        => 'lighting-installation',
        'description' => 'Indoor, outdoor and security lighting installation, including fixtures, recessed lights and exterior lights.',
        'keywords'    => ['Lighting installation', 'Indoor lighting installation', 'Outdoor lighting installation', 'Security lighting installation'],
    ],
    [
        'name'        => 'Ceiling Fan Installation',
        'slug'        => 'ceiling-fan-installation',
        'description' => 'Ceiling fan installation on boxes rated for fan weight, with wall switch or remote controls.',
        'keywords'    => ['Ceiling fan installation'],
    ],
    [
        'name'        => 'EV Charger Installation',
        'slug'        => 'ev-charger-installation',
        'description' => 'Home EV charger installation on a dedicated circuit, with a check of panel capacity before the charger goes in.',
        'keywords'    => ['EV charger installation'],
    ],
    [
        'name'        => 'Generator Installation',
        'slug'        => 'generator-installation',
        'description' => 'Standby and portable generator hookups with transfer switches to keep power on during outages.',
        'keywords'    => ['Generator installation'],
    ],
    [
        'name'        => 'Whole-House Surge Protection',
        'slug'        => 'surge-protection',
        'description' => 'Panel-mounted surge protection that guards appliances, electronics and HVAC equipment against voltage spikes.',
        'keywords'    => ['Whole-house surge protection'],
    ],
    [
        'name'        => 'Smart Home Wiring',
        'slug'        => 'smart-home-wiring',
        'description' => 'Wiring for smart switches, smart thermostats, doorbells and other connected devices.',
        'keywords'    => ['Smart home wiring'],
    ],
    [
        'name'        => 'Smoke Detector Installation',
        'slug'        => 'smoke-detector-installation',
        'description' => 'Hardwired, interconnected smoke and carbon monoxide detector installation and replacement.',
        'keywords'    => ['Smoke detector installation'],
    ],
    [
        'name'        => 'Electrical Inspections & Maintenance',
        'slug'        => 'electrical-inspections',
        'description' => 'Home electrical inspections and routine maintenance to find worn wiring, overloaded circuits and code issues before they fail.',
        'keywords'    => ['Home electrical inspection', 'Electrical maintenance services'],
    ],
    [
        'name'        => 'New Construction Wiring',
        'slug'        => 'new-construction-wiring',
        'description' => 'Electrical wiring for new homes, additions and outbuildings, from rough-in through final inspection.',
        'keywords'    => ['New construction electrical wiring'],
    ],
    [
        'name'        => 'Commercial Electrical',
        'slug'        => 'commercial-electrical',
        'description' => 'Electrical repair, installation and upgrades for commercial and light industrial buildings.',
        'keywords'    => ['Commercial electrician', 'Commercial electrical repair', 'Industrial electrician'],
    ],
    [
        'name'        => 'Emergency Electrical Repair',
        'slug'        => 'emergency-electrician',
        'description' => 'Urgent troubleshooting for power loss, tripping breakers, burning smells and other electrical hazards.',
        'keywords'    => ['Emergency electrician', 'Emergency electrical repair', 'Same-day electrician', '24/7 emergency electrical services'],
    ],
];

/* ---------------------------------------------------------------------------
 * Service areas — build-plan service_areas holds Reedsburg only. The research
 *   brief's "nearby communities in Sauk County" is unverified — add a town here
 *   only after the client confirms it. Phase 6 (2026-10-22): the shop address
 *   geocodes to the Town of Dellona (Census geocoder), ~6.6 mi ENE of downtown
 *   Reedsburg; the Reedsburg mailing address is correct. Area pages live at
 *   /service-areas/<slug>/ (areaHref() in functions.php).
 * ------------------------------------------------------------------------- */
$serviceAreas = [
    ['name' => 'Reedsburg', 'slug' => 'reedsburg', 'zip' => '53959', 'county' => 'Sauk', 'primary' => true],
];
$targetRadiusMiles = 25;   // build-plan seo.target_radius

/* ---------------------------------------------------------------------------
 * Social links (only platforms the client uses; none supplied at intake)
 * ------------------------------------------------------------------------- */
$socialLinks = [];

/* ---------------------------------------------------------------------------
 * Analytics (placeholder — replace with client GA4 ID post-launch)
 * ------------------------------------------------------------------------- */
$googleAnalyticsId = 'G-XXXXXXXXXX';

/* ---------------------------------------------------------------------------
 * Brand colors — Phase 2 logo analysis (2026-10-22). The logo is monochrome
 *   black line-art on #f8f8f8, so primary = the logo's ink and the single
 *   accent is filament amber. Mirrors framework.css :root and build-plan
 *   design.colors.
 * ------------------------------------------------------------------------- */
$colors = [
    'primary'   => '#1c1f22',
    'secondary' => '#5b6570',
    'accent'    => '#e9a21b',
];
$archetype = 'minimal-tech';   // build-plan design.archetype (Phase 2)

/* Logo assets (Phase 2): the delivered logo.png is a JPEG-style RGB file with
 *   two phone numbers and a URL baked in under the mark. These are the cropped,
 *   knocked-out derivatives — never overwrite them in place (immutable cache). */
$logoDark   = '/assets/images/logo-mark-v1.png';        // 877x367, black mark, transparent
$logoLight  = '/assets/images/logo-mark-white-v1.png';  // 877x367, white mark for dark bands
$logoRatio  = 877 / 367;                                // 2.39:1 combination mark
$ogImageDefault = '/assets/images/og-default-v1.jpg';   // 1200x630

/* Estimate CTA label — intake does not confirm that estimates are free, so the
 *   sitewide button says "Request an Estimate". Switch to "Free Estimate" only
 *   after the client confirms it. */
$estimateCtaLabel = 'Request an Estimate';

/* ---------------------------------------------------------------------------
 * Company age — intake: "in business since 2018" (content.years = 8)
 * ------------------------------------------------------------------------- */
$yearEstablished = 2018;
$yearsInBusiness = (int) date('Y') - $yearEstablished;

/* ---------------------------------------------------------------------------
 * Hours — build-plan business_hours is empty. Do not publish hours or build an
 *   OpeningHoursSpecification until the client supplies them.
 * ------------------------------------------------------------------------- */
$businessHours    = '';
$openingHoursSpec = [];

/* ---------------------------------------------------------------------------
 * Credentials — build-plan content.certifications and content.insurance are
 *   empty. The research brief's license/insurance wording is an unverified
 *   placeholder — never publish a license number or insurance claim until intake
 *   supplies it.
 * ------------------------------------------------------------------------- */
$licenseLabel = '';

/* ---------------------------------------------------------------------------
 * CSS cache-bust — SINGLE source of truth. Pages MUST NOT set their own.
 * Bump this on every framework.css change.
 * ------------------------------------------------------------------------- */
$cssVersion = '2';

/* ---------------------------------------------------------------------------
 * Forms — Page One leads endpoint (build-plan form_action, verbatim)
 * ------------------------------------------------------------------------- */
$formAction       = 'https://db.pageone.cloud/functions/v1/leads/dellona-electric';
$leadsFormSecret  = 'bac7714a8f41505ab12d75311ccbb11a6374e38b1a010d69111c84a652cfa0f3'; // spam-shield HMAC (matches leads fn LEADS_FORM_SECRET)
$leadNotificationEmail = 'dellonaelectric@outlook.com';
$leadNotificationPhone = '(608) 477-8453';

/* ---------------------------------------------------------------------------
 * Google Business Profile (build-plan integrations + google_business_profile_url).
 *   integrations.gbp_map_embed and integrations.geo are null — the embed below is
 *   built from the listing's own cid; $geo stays null until real coordinates
 *   are supplied (never guessed).
 * ------------------------------------------------------------------------- */
$gbpPlaceId       = 'ChIJvUznawxFB4gRY1CyrNja_xA';
$gbpMapsUrl       = 'https://maps.google.com/?cid=1224938247813222499';
$directionsUrl    = 'https://www.google.com/maps/dir/?api=1&destination=place_id:ChIJvUznawxFB4gRY1CyrNja_xA';
$reviewRequestUrl = 'https://search.google.com/local/writereview?placeid=ChIJvUznawxFB4gRY1CyrNja_xA';
$gbpMapEmbed      = 'https://maps.google.com/maps?cid=1224938247813222499&output=embed';
$geo              = null;
$acceptsSms       = false;

/* ---------------------------------------------------------------------------
 * v8 component variables (2026-10-09) — copied from build-plan "integrations".
 *   Empty = component renders nothing. Never fill these without the plan.
 * ------------------------------------------------------------------------- */
$estimateTool   = [];   // integrations.estimate_tool.authorized = false
$bookingWindows = [];   // integrations.booking.authorized = false
$textUsNumber   = '';   // integrations.text_us_number = null
$financing      = [];   // integrations.financing = null
$serviceZips    = [];   // integrations.service_zips not present

/* ---------------------------------------------------------------------------
 * Lead attribution (v6.3) — MUST be last. Sets first-touch cookie and
 * provides p1_attribution_fields(). Never edit includes/attribution.php.
 * ------------------------------------------------------------------------- */
require_once __DIR__ . '/attribution.php';
