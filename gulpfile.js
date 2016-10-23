const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {

    mix.scripts([
        'zd-video.js',
        'app.js'
    ],'public/js/app.js')
    .sass('app.scss')
    .styles([
        './public/css/app.css',
        './resources/assets/css/style.css'
    ],'public/css/app.css');
});
