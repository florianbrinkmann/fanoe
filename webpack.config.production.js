const webpack = require('webpack');
const path = require('path');

module.exports = {
	mode: 'production',
	entry: ['./assets/js/src/functions.js', './assets/css/scss/fanoe.scss'],
	output: {
		path: path.resolve(__dirname, 'assets'),
		filename: 'js/bundle.js',
	},
	module: {
		rules: [
			/**
			 * Running Babel on JS files.
			 */
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['env']
					}
				}
			},
			{
				test: /\.scss$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							name: 'css/[name].css',
						}
					},
					{
						loader: 'extract-loader'
					},
					{
						loader: 'css-loader?-url'
					},
					{
						loader: 'postcss-loader'
					},
					{
						loader: 'sass-loader'
					}
				]
			}
		]
	},
	plugins: [
		new webpack.BannerPlugin({
			banner: "Want to take a look at the JS before bundled by Webpack? Check out https://github.com/florianbrinkmann/fanoe"
		})
	]
};
