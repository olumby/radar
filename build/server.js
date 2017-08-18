var browserSync = require('browser-sync').create();
var webpack = require('webpack');
var webpackDevMiddleware = require('webpack-dev-middleware');
var webpackHotMiddleware = require('webpack-hot-middleware');

var webpackConfig = require('./webpack.conf.js')
var compiler = webpack(webpackConfig);

var proxyHost = "radar.dev";

browserSync.init({
    open: false,
    proxy: {
        target: proxyHost,
        ws: true,

        middleware: [
            webpackDevMiddleware(compiler, {
                publicPath: webpackConfig.output.publicPath,
                stats: { 
                    colors: true,
                    modules: false,
                    children: false,
                    chunks: false,
                    chunkModules: false,
                    hash: false,
                    timings: false
                },
            }),
            webpackHotMiddleware(compiler)
        ]
    },
    
    files: [
        'public/**.html',
        'public/**.php'
    ]
});
