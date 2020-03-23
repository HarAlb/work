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

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
    'popper.js/dist/umd/popper.js': ['Popper'],
});


mix.styles([
    'public/css/bootstrap.min.css',
    'public/css/style.css'
] , 'public/css/app.css').version();

mix.js([
    'public/js/bootstrap.min.js',
    'public/js/script.js'
],'public/js/app.js').version();
