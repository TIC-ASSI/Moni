let mix = require('laravel-mix');
var tailwindcss = require('tailwindcss');

mix.sass('resources/assets/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false,
    postCss: [ tailwindcss('./tailwind.js') ],
  });