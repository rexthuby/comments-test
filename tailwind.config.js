/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.frontend",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
    safelist: [
        {
            pattern: /(bg|text)-(green|blue|red|sky|teal)-(100|200|300|400|500)/,
            variants: ['hover', "focus", 'active']
        },
        {
            pattern: /[hw]-(0.5|1|1.5|2|3|4|5|6|7|8|9|10|60)/,
        },
        {
            pattern: /(p|py|px|pl|pr|pt|pb)-(0.5|1|1.5|2|3|4|5|6|7|8|9|10)/,
        },
        {
            pattern: /(m|my|mx|ml|mr|mt|mb)-(0.5|1|1.5|2|3|4|5|6|7|8|9|10)/,
        },
    ]
}

