module.exports = {
  theme: {
    extend: {
      fontFamily: {
        sans: "'Poppins', sans-serif"
      }
    },
  },
  variants: {},
  plugins: [
    requrie('@tailwindcss/ui'),
    requrie('@tailwindcss/typography'),
    requrie('@tailwindcss/custom-forms'),
  ],
};
