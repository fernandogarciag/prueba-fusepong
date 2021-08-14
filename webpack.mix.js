const mix = require("laravel-mix");

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

mix.css("resources/css/app.css", "public/css")
    .js("resources/js/Example.js", "public/js")
    .js("resources/js/app.js", "public/js")
    .js("resources/js/login.js", "public/js")
    .js("resources/js/register.js", "public/js")
    .react();
