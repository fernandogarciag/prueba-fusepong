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
    .js("resources/js/project/index.js", "public/js/project")
    .js("resources/js/project/show.js", "public/js/project")
    .js("resources/js/project/create-edit.js", "public/js/project")
    .js("resources/js/history/index.js", "public/js/history")
    .js("resources/js/history/show.js", "public/js/history")
    .js("resources/js/history/create-edit.js", "public/js/history")
    .js("resources/js/ticket/index.js", "public/js/ticket")
    .js("resources/js/ticket/show.js", "public/js/ticket")
    .js("resources/js/ticket/create-edit.js", "public/js/ticket")
    .react();
