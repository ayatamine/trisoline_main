import preset from './vendor/filament/support/tailwind.config.preset'
const colors = require('tailwindcss/colors')

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        // fontFamily: {
        //   'smooth': 'Nunito, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji',
        //   'sans': '"Montserrat", ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
        // },
        colors: {
          transparent: 'transparent',
          gray: colors.gray,
          red: colors.red,
          orange: colors.orange,
          yellow: colors.amber,
          lime: colors.lime,
          green: colors.emerald,
          cyan: colors.cyan,
          blue: colors.blue,
          indigo: colors.indigo,
          purple: colors.purple,
          pink: colors.pink,
          black: colors.black,
          white: colors.white,
        },
    }
}
