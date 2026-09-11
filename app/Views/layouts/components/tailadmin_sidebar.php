<?php
$webData = $web ?? \Config\Services::renderer()->getData()['web'] ?? [];
$sekolahName = $webData['nama_sekolah'] ?? 'Sekolah';
$webLogo = $webData['logo'] ?? ($web_logo ?? null);
$currentUri = trim(uri_string(), '/');

// Determine logo redirection based on current role context
$logoUrl = 'admin/dashboard';
if (strpos($currentUri, 'verifikator') === 0) {
    $logoUrl = 'verifikator/dashboard';
} elseif (strpos($currentUri, 'siswa') === 0) {
    $logoUrl = 'siswa/dashboard';
}

// Extract all menu URLs to find the single most specific match (longest prefix)
$allMenuUrls = [];
foreach ($sidebarMenus ?? [] as $groupItems) {
    foreach ($groupItems as $mItem) {
        if (!empty($mItem['url'])) {
            $allMenuUrls[] = trim($mItem['url'], '/');
        }
    }
}

$activeMenuUrl = null;
$bestMatchLen = -1;

foreach ($allMenuUrls as $menuUrl) {
    $isMatch = false;
    if ($menuUrl === 'admin/dashboard' && ($currentUri === 'admin' || $currentUri === 'admin/dashboard')) {
        $isMatch = true;
    } elseif ($menuUrl === 'verifikator/dashboard' && ($currentUri === 'verifikator' || $currentUri === 'verifikator/dashboard')) {
        $isMatch = true;
    } elseif ($menuUrl === 'siswa/dashboard' && ($currentUri === 'siswa' || $currentUri === 'siswa/dashboard')) {
        $isMatch = true;
    } elseif ($currentUri === $menuUrl || strpos($currentUri, $menuUrl . '/') === 0) {
        $isMatch = true;
    }

    if ($isMatch) {
        $len = strlen($menuUrl);
        if ($len > $bestMatchLen) {
            $bestMatchLen = $len;
            $activeMenuUrl = $menuUrl;
        }
    }
}

// Grup yang boleh di-collapse (accordion). Default: tidak ada.
$collapsibleGroups = $collapsibleGroups ?? [];
?>

<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[80px]' : '-translate-x-full lg:w-[270px]'"
  class="fixed top-0 left-0 z-9999 flex h-screen flex-col overflow-y-hidden border-r border-gray-200 bg-white duration-300 ease-in-out dark:border-gray-800 dark:bg-gray-900 lg:static lg:translate-x-0"
>
  <!-- SIDEBAR HEADER -->
  <div
    :class="sidebarToggle ? 'justify-center px-2' : 'justify-between px-6'"
    class="flex items-center gap-3 border-b border-gray-100 py-4.5 dark:border-gray-800"
  >
    <a href="<?= base_url($logoUrl) ?>" class="flex items-center gap-3 overflow-hidden">
      <?php if (!empty($webLogo) && file_exists(FCPATH . 'uploads/logo/' . $webLogo)): ?>
        <img
          src="<?= base_url('uploads/logo/' . esc($webLogo, 'url')) ?>"
          alt="Logo"
          class="h-8 w-8 object-contain shrink-0 rounded"
        />
      <?php else: ?>
        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-brand-500 text-white font-bold text-sm shadow-sm">
          P
        </div>
      <?php endif; ?>

      <div :class="sidebarToggle ? 'lg:hidden' : 'block'" class="flex flex-col truncate">
        <span class="text-sm font-bold tracking-tight text-gray-900 dark:text-white uppercase leading-tight truncate">
          <?= esc($app_alias ?? 'PPDB Online') ?>
        </span>
        <span class="text-[11px] text-gray-500 dark:text-gray-400 truncate leading-none mt-0.5">
          <?= esc($sekolahName) ?>
        </span>
      </div>
    </a>

    <!-- Mobile Close Button -->
    <button
      @click.stop="sidebarToggle = false"
      class="block text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white lg:hidden"
    >
      <svg class="fill-current h-5 w-5" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
      </svg>
    </button>
  </div>
  <!-- SIDEBAR HEADER END -->

  <!-- SIDEBAR NAVIGATION -->
  <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar flex-1 py-4">
    <nav class="space-y-6 px-3">
      <?php foreach ($sidebarMenus as $groupLabel => $items): ?>
        <?php
          $isCollapsible = in_array($groupLabel, $collapsibleGroups, true);
          $groupKey = 'ssb_' . preg_replace('/[^a-z0-9]+/', '_', strtolower($groupLabel));
          $groupDefaultOpen = true;
          $hasActiveInGroup = false;
          foreach ($items as $gItem) {
              if (trim($gItem['url'] ?? '', '/') === $activeMenuUrl) {
                  $hasActiveInGroup = true;
                  break;
              }
          }
          if ($hasActiveInGroup) {
              $groupDefaultOpen = true;
          }
        ?>
        <div x-data="{ open: (() => { try { const v = localStorage.getItem('<?= $groupKey ?>'); return v === null ? <?= $groupDefaultOpen ? 'true' : 'false' ?> : v === '1'; } catch (e) { return <?= $groupDefaultOpen ? 'true' : 'false' ?>; } })() }">
          <!-- Group Title / Toggle -->
          <?php if ($isCollapsible): ?>
            <button
              type="button"
              @click="open = !open; try { localStorage.setItem('<?= $groupKey ?>', open ? '1' : '0'); } catch (e) {}"
              :disabled="sidebarToggle"
              class="mb-2 flex w-full items-center justify-between gap-2 text-left text-[11px] font-semibold tracking-wider text-gray-400 uppercase dark:text-gray-500
                     <?= $hasActiveInGroup ? 'text-brand-600 dark:text-brand-400' : '' ?>"
            >
              <span :class="sidebarToggle ? 'lg:text-center lg:px-0' : 'px-0'">
                <span :class="sidebarToggle ? 'lg:hidden' : 'inline'"><?= esc($groupLabel) ?></span>
                <span :class="sidebarToggle ? 'hidden lg:inline text-base font-bold' : 'hidden'">•</span>
              </span>
              <span :class="sidebarToggle ? 'lg:hidden' : 'inline-flex'" class="shrink-0 text-gray-400">
                <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
              </span>
            </button>
          <?php else: ?>
            <h3
              :class="sidebarToggle ? 'lg:text-center lg:px-0' : 'px-3'"
              class="mb-2 text-[11px] font-semibold tracking-wider text-gray-400 uppercase dark:text-gray-500"
            >
              <span :class="sidebarToggle ? 'lg:hidden' : 'inline'"><?= esc($groupLabel) ?></span>
              <span :class="sidebarToggle ? 'hidden lg:inline text-base font-bold' : 'hidden'">•</span>
            </h3>
          <?php endif; ?>

          <!-- Items List -->
          <ul <?= $isCollapsible
            ? 'x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1"'
            : '' ?> class="space-y-1">
            <?php foreach ($items as $item): ?>
              <?php
                $itemUrl = trim($item['url'] ?? '', '/');
                $active = ($itemUrl === $activeMenuUrl);
                $badge = $item['badge'] ?? null;
              ?>
              <li>
                <a
                  href="<?= base_url($item['url']) ?>"
                  :class="sidebarToggle ? 'lg:justify-center lg:px-2' : 'px-3'"
                  class="group relative flex items-center gap-3 rounded-lg py-2.5 text-xs font-medium transition-all duration-200 <?= $active
                    ? 'bg-brand-500 text-white shadow-sm shadow-brand-500/30 dark:bg-brand-500 dark:text-white'
                    : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' ?>"
                  title="<?= esc($item['label']) ?>"
                >
                  <i class="fas fa-<?= $item['icon'] ?> text-sm w-4 text-center shrink-0 <?= $active ? 'text-white' : 'text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300' ?>"></i>

                  <span :class="sidebarToggle ? 'lg:hidden' : 'inline'" class="truncate flex-1">
                    <?= esc($item['label']) ?>
                  </span>

                  <?php if (!empty($badge) && $badge > 0): ?>
                    <span
                      :class="sidebarToggle ? 'lg:hidden' : 'inline-flex'"
                      class="ml-auto inline-flex items-center justify-center rounded-full bg-red-500 px-1.5 py-0.5 text-[10px] font-bold text-white shadow-sm"
                    >
                      <?= $badge ?>
                    </span>
                  <?php endif; ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </nav>
  </div>
  <!-- SIDEBAR NAVIGATION END -->

  <!-- SIDEBAR FOOTER / ROLE INFO -->
  <div
    :class="sidebarToggle ? 'lg:hidden' : 'block'"
    class="border-t border-gray-100 p-4 dark:border-gray-800"
  >
    <div class="flex items-center justify-between rounded-xl bg-gray-50 p-3 dark:bg-gray-800/60">
      <div class="flex items-center gap-2.5 overflow-hidden">
        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-emerald-500/10 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400">
          <i class="fas fa-shield-alt text-xs"></i>
        </div>
        <div class="truncate">
          <p class="text-[11px] font-semibold text-gray-800 dark:text-gray-200 truncate">Sistem PPDB</p>
          <p class="text-[10px] text-gray-400 dark:text-gray-500 truncate">v1.0 • TailAdmin</p>
        </div>
      </div>
      <a
        href="<?= base_url('logout') ?>"
        title="Logout"
        class="text-gray-400 hover:text-red-500 dark:text-gray-500 dark:hover:text-red-400 transition-colors p-1"
      >
        <i class="fas fa-power-off text-xs"></i>
      </a>
    </div>
  </div>
</aside>
