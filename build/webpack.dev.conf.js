const path = require('path')
const merge = require('webpack-merge')
const baseWebpackConfig = require('./webpack.base.conf')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')


module.exports = env =>
  merge(baseWebpackConfig(env), {
    mode: 'development',
    output: {
      path: path.resolve(__dirname, '../public/dist/js'),
      filename: '[name].js'
    },
    plugins: [
      new MiniCssExtractPlugin({
        filename: '../css/[name].css',
        chunkFilename: '[id].css'
      })
    ],
    optimization: {
		minimize: false,
      //minimize: true,
     //minimizer: [new OptimizeCSSAssetsPlugin({})]
    },
    watch: true,
    devServer: {
      stats: 'errors-only'
    }
  })
