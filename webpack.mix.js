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
   .js('resources/js/bs4navbar.js', 'public/js')
   .js('resources/js/entradaestoque.js', 'public/js')
   .js('resources/js/entradatanque.js', 'public/js')
   .js('resources/js/saidaestoque.js', 'public/js')
   .js('resources/js/inventarioestoque.js', 'public/js')
   .js('resources/js/estoqueproduto.js', 'public/js')
   .js('resources/js/osservico.js', 'public/js')
   .js('resources/js/os.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');