const mix = require('laravel-mix');
const path = require('path');
require('laravel-mix-imagemin');
const ImageminPlugin     = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin  = require('copy-webpack-plugin');
const imageminMozjpeg    = require('imagemin-mozjpeg');

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


let productionSourceMaps = false;

mix.webpackConfig({
        resolve: {
            alias: {
                ziggy: path.resolve('vendor/tightenco/ziggy/src/js/route.js'),
                '@': path.resolve(__dirname, 'resources/js'),
                '@components': path.resolve(__dirname, 'resources/js/views/Components'),
                '@views': path.resolve(__dirname, 'resources/js/views'),
                '@store': path.resolve(__dirname, 'resources/js/store'),
                '@img': path.resolve(__dirname, 'resources/images'),
                '@video': path.resolve(__dirname, 'resources/videos'),
                '@public': path.resolve(__dirname, 'public'),
            },
        },
        output: {
            chunkFilename: 'js/chunks/[name].js',
            filename: '[name].js',
            path: path.resolve(__dirname, 'public/'),
        },
        plugins: [
            //Compress images
            new CopyWebpackPlugin({
                patterns: [
                    {
                        from: 'resources/images',
                        to: 'images/',
                    }
                ]
            }),
            new ImageminPlugin({
                test: /\.(jpe?g|png|gif)$/i,
                pngquant: {
                    quality: '65-80'
                },
                cacheFolder: './app/cache',
                plugins: [
                    imageminMozjpeg({
                        quality: 65,
                        //Set the maximum memory to use in kbytes
                        // maxmemory: 1000 * 512
                    })
                ]
            })
        ],
    })
    .options({
        processCssUrls: false
    })
    .copyDirectory(path.resolve(__dirname, 'resources/fonts'), path.resolve(__dirname, 'public/fonts'))
    .copyDirectory(path.resolve(__dirname, 'resources/videos'), path.resolve(__dirname, 'public/videos'))
    .js('resources/js/app.js', 'public/js').sourceMaps(productionSourceMaps, 'eval-source-map')
    .js('resources/js/bundle.js', 'public/js/').sourceMaps(productionSourceMaps, 'eval-source-map')
    .sass('resources/sass/app.scss', 'public/css').sourceMaps(productionSourceMaps, 'source-map')
    .browserSync({
        proxy: 'localhost:8000',
        port: 9999,
        /* proxy: process.env.APP_URL + '/public/', */
        middleware: [
            require("compression")(),
        ],
    });
    
    mix.override(config => {
        config.module.rules.push(
            {
            test: /\.vue$/,
            use: [{
                loader: "vue-svg-inline-loader",
                options: { /* ... */ }
            }]
        },
        { test: /\.(html|htm)$/, loader: 'html?minimize=false' }
          )
    });