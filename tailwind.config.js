// tailwind.config.js
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.vue",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: "#76C6D1", // warna utama
          light: "#24336B",
          dark: "#0B122E",
        },
      },
    },
  },
  plugins: [],
};
