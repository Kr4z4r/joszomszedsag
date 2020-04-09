const mix = require('laravel-mix');

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
mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/plugins/materialize/js/bin/materialize.min.js', 'public/js/')
    .js('resources/js/front.js', 'public/js/')
    .js('resources/js/plugins/dashboard/script.js', 'public/js/dashboard/')
    .scripts(['resources/js/plugins/jquery/jquery.anchorScroll.min.js'], 'public/js/plugins.js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/materialize/materialize.scss', 'public/css')
    .sass('resources/sass/dashboard/style.scss','public/css/dashboard');
