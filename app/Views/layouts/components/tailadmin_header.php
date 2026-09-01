<?php
$sessionName = session()->get('nama') ?? session()->get('username') ?? 'Pengguna';
$sessionRole = ucfirst(session()->get('role') ?? 'Admin');
$sessionFoto = session()->get('foto');
$avatarUrl = !empty($sessionFoto) && file_exists(FCPATH . 'uploads/profile/' . $sessionFoto)
    ? base_url('uploads/profile/' . esc($sessionFoto, 'url'))
    : base_url('assets/tailadmin/images/user/owner.jpg');
?>

<header
  x-data="{menuToggle: false}"
  class="sticky top-0 z-999 flex w-full border-b border-gray-200 bg-white/90 backdrop-blur-md dark:border-gray-800 dark:bg-gray-900/90"
>
  <div class="flex grow items-center justify-between px-4 py-3 sm:px-6 lg:py-3.5">
    <div class="flex items-center gap-3">
      <!-- Hamburger Toggle BTN -->
      <button
        :class="sidebarToggle ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white'"
        class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 transition-colors dark:border-gray-800 hover:bg-gray-100 dark:hover:bg-gray-800"
        @click.stop="sidebarToggle = !sidebarToggle"
        title="Toggle Menu Sidebar"
      >
        <svg
          class="fill-current"
          width="18"
          height="14"
          viewBox="0 0 16 12"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M0.583252 1C0.583252 0.585788 0.919038 0.25 1.33325 0.25H14.6666C15.0808 0.25 15.4166 0.585786 15.4166 1C15.4166 1.41421 15.0808 1.75 14.6666 1.75L1.33325 1.75C0.919038 1.75 0.583252 1.41422 0.583252 1ZM0.583252 11C0.583252 10.5858 0.919038 10.25 1.33325 10.25L14.6666 10.25C15.0808 10.25 15.4166 10.5858 15.4166 11C15.4166 11.4142 15.0808 11.75 14.6666 11.75L1.33325 11.75C0.919038 11.75 0.583252 11.4142 0.583252 11ZM1.33325 5.25C0.919038 5.25 0.583252 5.58579 0.583252 6C0.583252 6.41421 0.919038 6.75 1.33325 6.75L7.99992 6.75C8.41413 6.75 8.74992 6.41421 8.74992 6C8.74992 5.58579 8.41413 5.25 7.99992 5.25L1.33325 5.25Z"
          />
        </svg>
      </button>

      <!-- App Title Badge on Mobile -->
      <div class="flex items-center gap-2 lg:hidden">
        <span class="text-base font-bold tracking-tight text-gray-900 dark:text-white">
          <?= esc($app_alias ?? 'PPDB') ?>
        </span>
      </div>

      <!-- Quick Search input -->
      <div class="hidden sm:block">
        <div class="relative">
          <span class="absolute top-1/2 left-3.5 -translate-y-1/2 text-gray-400">
            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z" />
            </svg>
          </span>
          <input
            type="text"
            placeholder="Cari menu atau data... (Ctrl+K)"
            id="search-input"
            class="h-10 w-64 md:w-80 rounded-lg border border-gray-200 bg-gray-50/70 py-2 pr-12 pl-10 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-800 dark:bg-gray-800/50 dark:text-gray-100 dark:placeholder:text-gray-500 dark:focus:border-brand-400 dark:focus:bg-gray-800"
          />
        </div>
      </div>
    </div>

    <!-- Right Area Action Items -->
    <div class="flex items-center gap-2 sm:gap-3">
      <!-- Dark Mode Toggler -->
      <button
        class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
        @click.prevent="darkMode = !darkMode"
        title="Ganti Tema (Dark / Light Mode)"
      >
        <!-- Sun Icon (shown in dark mode) -->
        <svg class="hidden dark:block h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <!-- Moon Icon (shown in light mode) -->
        <svg class="dark:hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
      </button>

      <?php if (!empty($pendingUnlockCount) && $pendingUnlockCount > 0): ?>
      <!-- Notification Icon with Badge -->
      <a
        href="<?= base_url('admin/unlockrequest') ?>"
        class="relative flex h-10 w-10 items-center justify-center rounded-lg border border-amber-200 bg-amber-50/50 text-amber-600 transition-colors hover:bg-amber-100 dark:border-amber-900/50 dark:bg-amber-950/40 dark:text-amber-400"
        title="<?= $pendingUnlockCount ?> Permintaan Buka Kunci Menunggu"
      >
        <i class="fas fa-unlock-alt text-sm"></i>
        <span class="absolute -top-1 -right-1 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white shadow">
          <?= $pendingUnlockCount ?>
        </span>
      </a>
      <?php endif; ?>

      <!-- User Area Dropdown -->
      <div
        class="relative"
        x-data="{ dropdownOpen: false }"
        @click.outside="dropdownOpen = false"
      >
        <button
          class="flex items-center gap-2.5 rounded-lg p-1.5 transition-colors hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300"
          @click.prevent="dropdownOpen = !dropdownOpen"
        >
          <span class="h-9 w-9 overflow-hidden rounded-full ring-2 ring-brand-500/20">
            <img src="<?= $avatarUrl ?>" alt="Avatar" class="h-full w-full object-cover" />
          </span>

          <div class="hidden text-left md:block">
            <span class="block text-xs font-semibold text-gray-800 dark:text-gray-100">
              <?= esc($sessionName) ?>
            </span>
            <span class="block text-[10px] text-gray-400 dark:text-gray-500 font-medium leading-none mt-0.5">
              <?= esc($sessionRole) ?>
            </span>
          </div>

          <svg
            :class="dropdownOpen && 'rotate-180'"
            class="h-4 w-4 text-gray-400 transition-transform duration-200"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </button>

        <!-- Dropdown Menu -->
        <div
          x-show="dropdownOpen"
          x-transition:enter="transition ease-out duration-150"
          x-transition:enter-start="opacity-0 scale-95"
          x-transition:enter-end="opacity-100 scale-100"
          x-transition:leave="transition ease-in duration-100"
          x-transition:leave-start="opacity-100 scale-100"
          x-transition:leave-end="opacity-0 scale-95"
          class="absolute right-0 mt-2 w-56 rounded-xl border border-gray-200 bg-white p-2 shadow-xl dark:border-gray-800 dark:bg-gray-900"
          style="display: none;"
        >
          <div class="border-b border-gray-100 px-3 py-2 dark:border-gray-800">
            <p class="text-xs font-semibold text-gray-900 dark:text-white"><?= esc($sessionName) ?></p>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 truncate"><?= esc(session()->get('username') ?? 'user') ?></p>
          </div>

          <div class="py-1">
            <a
              href="<?= base_url('admin/profile') ?>"
              class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors"
            >
              <i class="fas fa-user-circle w-4 text-gray-400"></i>
              Profil Saya
            </a>
            <a
              href="<?= base_url('admin/settings') ?>"
              class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors"
            >
              <i class="fas fa-cog w-4 text-gray-400"></i>
              Pengaturan Sistem
            </a>
            <a
              href="<?= base_url() ?>"
              target="_blank"
              class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors"
            >
              <i class="fas fa-external-link-alt w-4 text-gray-400"></i>
              Lihat Halaman Publik
            </a>
          </div>

          <div class="border-t border-gray-100 pt-1 dark:border-gray-800">
            <a
              href="<?= base_url('logout') ?>"
              class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/40 transition-colors"
            >
              <i class="fas fa-sign-out-alt w-4 text-red-500"></i>
              Keluar (Logout)
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
