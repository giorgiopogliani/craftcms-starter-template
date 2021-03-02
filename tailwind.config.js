const colors = require("tailwindcss/colors");

module.exports = {
  darkMode: false,
  purge: [
    'templates/**/*.twig',
    'modules/**/*.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['Poppins', 'Helvetica', 'sans-serif']
      },
      typography: (theme) => ({
        DEFAULT: {
          css: {
            color: "inherit",
            strong: {
              color: "inherit",
            },
          },
        },
      }),
      colors: {
        black: colors.black,
        white: colors.white,
        gray: colors.blueGray,
        blue: colors.blue,
        red: colors.red,
        yellow: colors.yellow,
        teal: colors.teal
      }
    },
  },
  variants: {},
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
  ],
};
