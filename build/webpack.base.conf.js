const webpack = require('webpack')
const path = require('path')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin')
const StylelintPlugin = require('stylelint-webpack-plugin')

function resolve(dir) {
  return path.join(__dirname, '..', dir)
}

module.exports = env => {
  return {
    entry: {
      core: ['./resources/src/js/core.js']
    },
    resolve: {
      alias: {
        '@': resolve('src')
      }
    },
    optimization: {
      minimize: true,
      minimizer: [new OptimizeCSSAssetsPlugin({})]
    },
    plugins: [
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jQuery',
        'window.jQuery': 'jquery'
      }),
      new webpack.DefinePlugin({
        'process.env': {
          PREVIEW: env ? env.PREVIEW : false
        }
      })
    ],
    module: {
      rules: [

        {
          test: /\.m?js$/,
          exclude: /(node_modules|bower_components)/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env']
            }
            ,
          }
        },
        {
            test: /\.js$/,
            enforce: 'pre',
            use: ['source-map-loader'],
        },
        {
          test: /\.(png|woff|woff2|eot|ttf|svg)$/,
          loader: 'url-loader',
          options: {
            limit: 250000
          }
        },
        {
          test: /\.(jpg|gif)$/,
          use: [
            {
              loader: 'file-loader',
              options: {
                name: '../[path][name].[ext]'
              }
            }
          ]
        },
        {
          test: /\.css$/,
          use: [
            {
                loader: MiniCssExtractPlugin.loader,
                options: {
                    publicPath: ''
                }
            },
            'css-loader'
          ]
        },
		{
          test: /rtl.(scss)$/,
          use: [
            {
              loader: 'file-loader',
              options: {
                name: '../css/rtl.css'
              }
            },
            {
              loader: 'extract-loader'
            },
            {
              loader: 'css-loader'
            },
            {
              loader: 'postcss-loader',
              options: {
                plugins: function() {
                  return [require('postcss-import'), require('precss'), require('autoprefixer'), require('pixrem'), require('postcss-inline-svg')]
                }
              }
            },
            {
              loader: 'sass-loader'
            }
          ]
        },
        {
          test: /theme-.+\.(scss)$/,
          use: [
            {
              loader: 'file-loader',
              options: {
                name: '../css/[name].css'
              }
            },
            {
              loader: 'extract-loader'
            },
            {
              loader: 'css-loader'
            },
            {
              loader: 'postcss-loader',
              options: {
                plugins: function() {
                  return [require('postcss-import'), require('precss'), require('autoprefixer'), require('pixrem'), require('postcss-inline-svg')]
                }
              }
            },
            {
              loader: 'sass-loader'
            }
          ]
        },
        {
          test: /\.(scss)$/,
          exclude: [/theme-.+\.(scss)$/,/rtl.(scss)$/],
          use: [
            {
                loader: MiniCssExtractPlugin.loader,
                options: {
                    publicPath: ''
                }
            },
            {
              loader: 'css-loader'
            },
            {
              loader: 'postcss-loader',
              options: {
                plugins: function() {
                  return [require('postcss-import'), require('precss'), require('autoprefixer'), require('pixrem'), require('postcss-inline-svg')]
                }
              }
            },
            {
              loader: 'sass-loader'
            }
          ]
        }
      ]
    }
  }
}
