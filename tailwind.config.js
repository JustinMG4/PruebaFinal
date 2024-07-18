/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		"./*.{html,js,php}", 
		"./views/**/*.php", 
		"./views/*.php",
		"./public/**/*.html", 
	  ],
  theme: {
		container: {
			padding: {
				DEFAULT: '15px'
			}
		},
		screens: {
			sm: '640px',
			md: '768px',
			lg: '960px',
			xl: '1330px',
		},
		extend: {
			colors: {
				primary: '#2c222b',
				secondary: '#130818',
				accent: {
					DEFAULT: '#f46211',
					secondary: '#18abbc',
					tertiary: '#90c6cd',
				},
				grey: '#e8f0f1',
				'custom-gray-900': 'rgb(44, 34, 43)',
        		'custom-purple-900': 'rgb(19, 8, 24)',
			},
			fontFamily: {
				primary: 'Oswald'
			},
			boxShadow: {
				custom1: '0px 2px 40px 0px rgba(8, 70, 78, 0.08)',
				custom2: '0px 0px 30px 0px rgba(8, 73, 81, 0.06)',
			},
		},
	},
	plugins: [],
}
