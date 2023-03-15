/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    '../templates/**/*.twig'
  ],
  theme: {
    fontFamily: {
      'sans': ['Helvetica', 'open-sans']
    },
    container: {
      screens: {
        sm: '100%',
        md: '768px',
        lg: '1024px',
        xl: '1100px',
        '2xl': '1100px', 
      }
    },
    extend: {
      colors: {
        primary: '#0034db',
        secondary: '#59595C',
      },
      borderWidth: {
        100: '100px',
        screen: '100vw',
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
