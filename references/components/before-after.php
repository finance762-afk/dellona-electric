<?php
/**
 * before-after.php — reusable before/after comparison slider (Web Builder v8, 2026-10-09).
 * Canonical copy: ~/crm/references/components/before-after.php
 *
 * Default on service pages of visual trades (painting, roofing, landscaping, tree, cleaning, remodeling, tile,
 * concrete, fencing, detailing) whenever the image manifest has a before/after pair. Images come from the client's
 * own photos in /assets/images/ (480/960/1600 variants), never stock. Works without JS: both images are shown side
 * by side (the .ba-slider no-JS fallback that qa_audit checks for).
 *
 * Use:
 *   <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/before-after.php';
 *         echo p1_before_after('deck-before', 'deck-after', 'Weathered deck before staining', 'Same deck after cleaning and stain'); ?>
 * Args: before basename, after basename (without -960.webp), before alt, after alt, options ['caption' => '', 'id' => '']
 */
if (!function_exists('p1_before_after')) {
    function p1_before_after(string $before, string $after, string $beforeAlt, string $afterAlt, array $opt = []): string {
        $root = rtrim((string) ($_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
        $pick = function (string $base) use ($root): array {
            foreach (['960', '1600', '480'] as $w) {
                foreach (['webp', 'jpg', 'jpeg', 'png'] as $ext) {
                    $f = "/assets/images/{$base}-{$w}.{$ext}";
                    if ($root === '' || is_file($root . $f)) return [$f, (int) $w];
                }
            }
            foreach (['webp', 'jpg', 'jpeg', 'png'] as $ext) {
                $f = "/assets/images/{$base}.{$ext}";
                if ($root === '' || is_file($root . $f)) return [$f, 960];
            }
            return ['', 0];
        };
        [$bSrc] = $pick($before); [$aSrc] = $pick($after);
        if ($bSrc === '' || $aSrc === '') return '';
        $h = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
        static $n = 0; $n++;
        $id = preg_replace('/[^a-z0-9-]/', '', strtolower($opt['id'] ?? ('ba-' . $n))) ?: ('ba-' . $n);
        $caption = trim((string) ($opt['caption'] ?? ''));
        ob_start(); ?>
<figure class="ba-slider p1-ba" id="<?= $h($id) ?>" data-p1-component="before-after">
<style>
.p1-ba{margin:var(--space-lg,1.5rem) 0}
.p1-ba__stage{position:relative;display:grid;grid-template-columns:1fr 1fr;gap:.5rem;border-radius:var(--radius-lg,16px);overflow:hidden}
.p1-ba__stage img{display:block;width:100%;height:auto;aspect-ratio:4/3;object-fit:cover}
.p1-ba .ba-label{position:absolute;top:.75rem;padding:.3rem .6rem;border-radius:999px;background:var(--color-dark,rgba(0,0,0,.7));color:var(--color-white,#fff);font-size:.8rem;font-weight:700;letter-spacing:.02em}
.p1-ba .ba-label--before{left:.75rem}.p1-ba .ba-label--after{right:.75rem}
.p1-ba figcaption{margin-top:.5rem;font-size:.9rem;color:var(--color-muted,#666)}
.p1-ba__range{display:none}
.p1-ba.is-js .p1-ba__stage{display:block;aspect-ratio:4/3}
.p1-ba.is-js .p1-ba__stage img{position:absolute;inset:0;width:100%;height:100%}
.p1-ba.is-js .ba-panel--after{position:absolute;inset:0;clip-path:inset(0 0 0 var(--ba-pos,50%))}
.p1-ba.is-js .p1-ba__handle{position:absolute;top:0;bottom:0;left:var(--ba-pos,50%);width:2px;background:var(--color-white,#fff);box-shadow:0 0 0 1px rgba(0,0,0,.25);pointer-events:none}
.p1-ba.is-js .p1-ba__handle::after{content:"";position:absolute;top:50%;left:50%;width:40px;height:40px;transform:translate(-50%,-50%);border-radius:50%;background:var(--color-white,#fff);box-shadow:var(--shadow-md,0 4px 14px rgba(0,0,0,.25))}
.p1-ba.is-js .p1-ba__range{display:block;position:absolute;inset:0;width:100%;height:100%;margin:0;opacity:0;cursor:ew-resize}
.p1-ba.is-js.is-sweeping .ba-panel--after,.p1-ba.is-js.is-sweeping .p1-ba__handle{transition:clip-path 1.1s cubic-bezier(.45,0,.2,1),left 1.1s cubic-bezier(.45,0,.2,1)}
@media (prefers-reduced-motion:reduce){.p1-ba.is-js.is-sweeping .ba-panel--after,.p1-ba.is-js.is-sweeping .p1-ba__handle{transition:none}}
</style>
  <div class="p1-ba__stage">
    <div class="ba-panel ba-panel--before"><img src="<?= $h($bSrc) ?>" alt="<?= $h($beforeAlt) ?>" width="960" height="720" loading="lazy" decoding="async"><span class="ba-label ba-label--before">Before</span></div>
    <div class="ba-panel ba-panel--after"><img src="<?= $h($aSrc) ?>" alt="<?= $h($afterAlt) ?>" width="960" height="720" loading="lazy" decoding="async"><span class="ba-label ba-label--after">After</span></div>
    <div class="p1-ba__handle" aria-hidden="true"></div>
    <label class="sr-only" for="<?= $h($id) ?>-range">Drag to compare before and after</label>
    <input class="p1-ba__range" id="<?= $h($id) ?>-range" type="range" min="0" max="100" value="50" aria-valuetext="50% revealed">
  </div>
  <?php if ($caption !== ''): ?><figcaption><?= $h($caption) ?></figcaption><?php endif; ?>
<script defer>
(function(){var f=document.getElementById(<?= json_encode($id) ?>);if(!f)return;f.classList.add('is-js');var r=f.querySelector('.p1-ba__range');function set(){f.style.setProperty('--ba-pos',r.value+'%');r.setAttribute('aria-valuetext',r.value+'% revealed');}r.addEventListener('input',set);set();
/* v8.1 motion: one slow sweep (50→22→78→50) the first time the slider scrolls into view, so visitors see it is draggable; any touch cancels it */
var touched=false,timers=[];function stop(){touched=true;timers.forEach(clearTimeout);f.classList.remove('is-sweeping');}
['pointerdown','touchstart','keydown','input'].forEach(function(ev){r.addEventListener(ev,stop,{passive:true});});
if('IntersectionObserver' in window&&!(window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches)){var io=new IntersectionObserver(function(es){if(!es[0].isIntersecting||touched)return;io.disconnect();f.classList.add('is-sweeping');[[22,350],[78,1500],[50,2650]].forEach(function(st){timers.push(setTimeout(function(){if(touched)return;r.value=st[0];set();},st[1]));});timers.push(setTimeout(function(){f.classList.remove('is-sweeping');},3900));},{threshold:0.6});io.observe(f);}})();
</script>
</figure>
<?php   return ob_get_clean();
    }
}
