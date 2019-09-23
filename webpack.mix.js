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

mix.webpackConfig(webpack => {
    return {
        plugins: [
            new webpack.NormalModuleReplacementPlugin(/element-ui[\/\\]lib[\/\\]locale[\/\\]lang[\/\\]zh-CN/, 'element-ui/lib/locale/lang/es')
        ],
        resolve: {
            alias: {
                '@components': path.resolve(
                    __dirname,
                    'resources/js/components'
                ),
                '@api': path.resolve(
                    __dirname,
                    'resources/js/api'
                )
            }
        },
        output: {
            chunkFilename: `chunks/chunk[name].js`
        }
    };
});


mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

mix.styles(["resources/css/main.css", "resources/css/util.css"], "public/css/login_styles.css");
mix.styles("resources/css/style_404.css", "public/css/style_404.css");
mix.copy("resources/img/", "public/imagenes/");
mix.copy("resources/fonts/montserrat", "public/fonts/montserrat");
