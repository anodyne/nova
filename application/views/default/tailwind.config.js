const colors = require('tailwindcss/colors');
const defaultTheme = require('tailwindcss/defaultTheme');
const { default: flattenColorPalette } = require('tailwindcss/lib/util/flattenColorPalette');

const scale = Array.from({ length: 9 }, (_, i) => parseInt(`${i + 1}00`));

const createColorScale = (color) => ({
    [color]: Object.assign(
        {},
        ...scale.map((s) => ({
            [s]: ({ opacityVariable, opacityValue }) => {
                if (opacityValue !== undefined) {
                    return `rgba(var(--${color}-${s}), ${opacityValue})`;
                }
                if (opacityVariable !== undefined) {
                    return `rgba(var(--${color}-${s}), var(${opacityVariable}, 1))`;
                }
                return `rgb(var(--${color}-${s}))`;
            },
        })),
    ),
});

module.exports = {
  content: [],
  safelist: [
    'italic',
    'uppercase',
    'lowercase',
    'hidden',
    'text-primary-600',
  ],
  theme: {
    colors: {
      transparent: colors.transparent,
      current: colors.current,
      black: colors.black,
      white: colors.white,
      gray: colors.gray,
      ...createColorScale('primary'),
      ...createColorScale('success'),
      ...createColorScale('danger'),
      ...createColorScale('info'),
      ...createColorScale('warning'),
    },
    extend: {
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    function ({ matchUtilities, theme }) {
        matchUtilities(
            {
                highlight: (value) => ({ boxShadow: `inset 0 1px 0 0 ${value}` }),
            },
            { values: flattenColorPalette(theme('backgroundColor')), type: 'color' }
        )
    },
  ],
}
