const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/assets/js/app.js');

mix.sass('resources/sass/styles.scss', 'public/assets/css/styles.css');

mix.vue();
mix.extract();
mix.version();
mix.sourceMaps(false, 'source-map');
