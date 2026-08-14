module.exports = {
  content: ["./**/*.php", "./**/*.html", "./assets/js/**/*.js"],
  theme: {
    extend: {
      colors: {
        primary: { DEFAULT: '#239BA8', light: '#79F5FF', dark: '#12A19A' },
        accent: { blue: '#014581', green: '#007A3D', yellow: '#F3CC30' },
        text: { primary: '#071D2C', secondary: '#3A3A3A', dark: '#041424' },
        background: { page: '#F4F7FE', section: '#E5F0F6', dark: '#041424' },
        neutral: { white: '#FFFFFF', dark: '#041424' }
      },
      fontFamily: {
        sans: ['Inter', 'Tajawal', 'Cairo', 'sans-serif'],
        heading: ['Outfit', 'Cairo', 'sans-serif']
      },
      borderRadius: {
        '3xl': '30px',
      }
    }
  },
  plugins: [],
}
