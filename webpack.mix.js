let mix = require('laravel-mix');
require('laravel-mix-purgecss');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix
    .setPublicPath('./web')
    .react('assets/js/app.js', 'web/js')
    .postCss('assets/css/app.css', 'web/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('postcss-nested'),
        require('autoprefixer'),
    ])
    .version()

if (process.env.NODE_ENV == "development") {
    mix.browserSync({
        proxy: process.env.DEFAULT_SITE_URL,
        files: [
            "assets/**/*.css",
            "assets/**/*.js",
            "templates/**/*.twig"
        ]
    });
}

if (process.env.NODE_ENV == "production") {
    mix.purgeCss({
        globs: [
            path.join(__dirname, 'templates/**/*.twig'),
        ],
        extensions: ['html', 'js', 'jsx', 'ts', 'tsx', 'php', 'vue', 'twig'],
    });
}
