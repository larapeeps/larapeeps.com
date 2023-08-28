const plugin = require('tailwindcss/plugin')

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
    ],
    theme: {
        extend: {},
    },
    plugins: [
        plugin(function ({ addUtilities }) {
            addUtilities({
              '.scrollbar-hide': {
                /* IE and Edge */
                '-ms-overflow-style': 'none',
          
                /* Firefox */
                'scrollbar-width': 'none',
          
                /* Safari and Chrome */
                '&::-webkit-scrollbar': {
                  display: 'none'
                }
              },
              
              '.scrollbar-default': {
                /* IE and Edge */
                '-ms-overflow-style': 'auto',
          
                /* Firefox */
                'scrollbar-width': 'auto',
          
                /* Safari and Chrome */
                '&::-webkit-scrollbar': {
                  display: 'block'
                }
              }
            }, ['responsive'])
        }),
        require('@tailwindcss/forms'),
    ],
}
