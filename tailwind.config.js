const colors = require("tailwindcss/colors");
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  mode: 'jit',
  darkMode: false,
  purge: [
    'templates/**/*.twig',
    'modules/**/*.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['Inter', ...defaultTheme.fontFamily.sans],
      },
      typography: (theme) => ({
        DEFAULT: {
          css: {
            color: "inherit",
            'h1, h2, h3, h4, h5, h6': {
              color: 'inherit',
            },
            strong: {
              color: "inherit",
            },
            a: {
              color: "inherit"
            },
            'a:hover, a:active, a:focus, a:visited, a:link': {
              color: "inherit",
            },
          },
        },
      })
    }
  },
  plugins: [
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
  ],
};
