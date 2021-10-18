const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
	mode: 'jit',
	purge: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./vendor/laravel/jetstream/**/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
	],

	theme: {
		extend: {
			colors: {
				graylight: {
					DEFAULT: '#F0F3F8',
					dark: '#E6E9ED',
				},
			},
			fontFamily: {
				sans: ['Nunito', ...defaultTheme.fontFamily.sans],
			},
		},
	},

	plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
