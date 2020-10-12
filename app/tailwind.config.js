module.exports = {
  future: {
    removeDeprecatedGapUtilities: true, 
    purgeLayersByDefault: true, 
  },
  theme: {
    extend: {
      fontFamily: {
        sans: "'Poppins', sans-serif"
      }
    },
  },
  variants: {},
  plugins: [
    require('@tailwindcss/ui'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/custom-forms'),
  ],
};
