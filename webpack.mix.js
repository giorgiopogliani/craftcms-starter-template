let mix = require('laravel-mix');

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
  .setPublicPath('./web/')
  .js('./assets/js/app.js', 'web/dist/js')
  .postCss('./assets/css/app.css', 'web/dist/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('postcss-nested'),
    require('autoprefixer'),
  ])
  .version()
  .browserSync({
    proxy: process.env.DEFAULT_SITE_URL,
    files: [
      "templates/**/*.css",
      "templates/**/*.twig",
      "templates/**/*.js",
      "templates/**/*.html"
    ]
  });