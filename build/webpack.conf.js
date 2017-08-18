var path = require('path')
var merge = require('webpack-merge')
var webpack = require('webpack')
var ExtractTextPlugin = require("extract-text-webpack-plugin");

var activeCommand = process.env.npm_lifecycle_event;

var common = {
    entry: [
       './resources/assets/js/app.js', './resources/assets/less/app.less'
    ],
    output: {
        path: path.resolve(__dirname, '../public/'),
        publicPath: "/",
        filename: "js/app.js"
    }
}

if (activeCommand === 'dev') {
    module.exports = merge(common, {
        devtool: '#eval-source-map',

        entry: [
            'webpack/hot/dev-server',
            'webpack-hot-middleware/client',
        ],

        module: {
            loaders: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader'
                },
                {
                    test: /\.js$/,
                    loader: 'babel-loader',
                    exclude: /node_modules/
                },
                {
                    test: /\.css$/,
                    loader: 'style-loader!css-loader',
                },
                {
                    test: /\.less$/,
                    loader: 'style-loader!css-loader!less-loader',
                },
                {
                    test: /\.(woff2?|ttf|eot|jpe?g|png|gif|svg)$/,
                    loader: 'url-loader?limit=1'
                }
            ]
        },

        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.esm.js'
            }
        },

        plugins: [
            new webpack.HotModuleReplacementPlugin()
        ]
    });
}

if (activeCommand === 'production') {
    module.exports = merge(common, {
        devtool: 'source-map',

        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                    options: { extractCSS: true }
                },
                {
                    test: /\.js$/,
                    loader: 'babel-loader',
                    exclude: /node_modules/
                },
                {
                    test: /\.(png|jpg|gif|svg)$/,
                    loader: 'file-loader',
                    options: { name: '[name].[ext]?[hash]' }
                },
                {
                    test: /\.less$/,
                    use: ExtractTextPlugin.extract({
                        fallback: "style-loader",
                        use: [
                            "css-loader?sourceMap",
                            { 
                                loader: 'postcss-loader?sourceMap',
                                options: {
                                    sourceMap: true,
                                    plugins: (loader) => [
                                        require('autoprefixer')({
                                            browsers: ['last 2 versions', '> 2%']
                                        })
                                    ]
                                }
                            },
                            "less-loader?sourceMap"
                        ]
                    })
                }
            ]
        },

        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.esm.js'
            }
        },

        plugins: [
            new ExtractTextPlugin({filename: 'css/app.css', allChunks: true }),
            new webpack.optimize.UglifyJsPlugin({
                sourceMap: true,
                compress: {
                    warnings: false
                }
            }),
            new webpack.LoaderOptionsPlugin({
                minimize: true
            })
        ]
    });
}
