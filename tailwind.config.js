export default {
  content: [
    './app/**/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',

    // penting untuk Filament widgets + pages
    './resources/views/filament/**/*.blade.php',

    // filament vendor views
    './vendor/filament/**/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        brandBlue: '#001C8E',
      },
    },
  },
  plugins: [],
}
