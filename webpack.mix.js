const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.browserSync({
  proxy: 'vinylshop7.lrv',
  port: 3000
});