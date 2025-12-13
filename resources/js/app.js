import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()
function syncBrandLogo() {
  const img = document.querySelector('img.fi-logo');
  if (!img) return;

  const isDark = document.documentElement.classList.contains('dark');
  const nextSrc = isDark ? '/images/3.png' : '/images/2.png';

  if (!img.src.endsWith(nextSrc)) {
    img.src = nextSrc;
  }
}

// run once on load
document.addEventListener('DOMContentLoaded', () => {
  syncBrandLogo();

  // watch dark mode toggle (class "dark" di <html>)
  const observer = new MutationObserver(syncBrandLogo);
  observer.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['class'],
  });
});

// also rerun after Livewire updates (Filament pakai Livewire)
document.addEventListener('livewire:navigated', syncBrandLogo);
document.addEventListener('livewire:load', syncBrandLogo);

