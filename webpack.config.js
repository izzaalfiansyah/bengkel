const path = require('path');

module.exports = {
	mode: 'development',
	entry: {
		home: './resources/js/home.js',
		admin: './resources/js/admin.js'
	},
	output: {
		path: path.resolve(__dirname, './public/asset'),
		filename: '[name].js'
	},
	module: {
		rules: [
			{
				test: /\.svelte$/,
				use: 'svelte-loader'
			}
		]
	},
	resolve: {
		alias: {
			'$component': path.resolve(__dirname, './resources/js/components/'),
			'$app': path.resolve(__dirname, './resources/js/app.js')
		}
	}
};