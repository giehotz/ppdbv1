<!-- Small Device Overlay Start -->
<div
  x-show="sidebarToggle"
  x-transition:enter="transition-opacity ease-linear duration-300"
  x-transition:enter-start="opacity-0"
  x-transition:enter-end="opacity-100"
  x-transition:leave="transition-opacity ease-linear duration-300"
  x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0"
  @click="sidebarToggle = false"
  class="fixed inset-0 z-999 bg-black/50 lg:hidden"
  style="display: none;"
></div>
<!-- Small Device Overlay End -->
