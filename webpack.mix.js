let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/assets/sass/app.sass', 'public/css')
   .scripts([
   		'node_modules/uikit/dist/js/uikit.min.js',
   		'node_modules/uikit/dist/js/uikit-icons.min.js',
   		'resources/assets/js/app.js'
   	], 'public/js/app.js');
