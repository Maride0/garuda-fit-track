<script>
(function () {
  const DARK_SRC  = '/images/3.png';
  const LIGHT_SRC = '/images/2.png';

  function isDarkNow() {
    const html = document.documentElement;

    // 1) class "dark"
    if (html.classList.contains('dark')) return true;

    // 2) beberapa kemungkinan key localStorage
    const lsKeys = ['theme', 'filament-theme', 'filamentTheme', 'color-theme'];
    for (const k of lsKeys) {
      const v = localStorage.getItem(k);
      if (v === 'dark') return true;
      if (v === 'light') return false;
    }

    // 3) fallback: OS preference
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
  }

  function setLogo() {
    const img = document.querySelector('img.fi-logo');
    if (!img) return false;

    const dark = isDarkNow();
    const next = dark ? DARK_SRC : LIGHT_SRC;

    // jangan overwrite kalau udah benar
    if (img.getAttribute('data-gft') === (dark ? 'dark' : 'light')) return true;

    img.src = next;
    img.setAttribute('data-gft', dark ? 'dark' : 'light');

    // tandain siap (buat CSS anti-flicker)
    document.documentElement.setAttribute('data-gft-logo-ready', '1');
    return true;
  }

  // jalanin ASAP
  setLogo();

  // retry kalau logo belum ada (render telat)
  let tries = 0;
  const t = setInterval(() => {
    tries++;
    if (setLogo() || tries > 60) clearInterval(t);
  }, 50);

  // observe perubahan class html
  const obs = new MutationObserver(setLogo);
  obs.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

  document.addEventListener('livewire:navigated', setLogo);
})();
</script>
