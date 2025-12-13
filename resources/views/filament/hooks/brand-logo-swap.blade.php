<script>
(function () {
  function syncBrandLogo() {
    const img = document.querySelector('img.fi-logo');
    if (!img) return;
    const isDark = document.documentElement.classList.contains('dark');
    img.src = isDark ? '/images/3.png' : '/images/2.png';
  }

  document.addEventListener('DOMContentLoaded', () => {
    syncBrandLogo();
    const observer = new MutationObserver(syncBrandLogo);
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
  });

  document.addEventListener('livewire:navigated', syncBrandLogo);
})();
</script>
