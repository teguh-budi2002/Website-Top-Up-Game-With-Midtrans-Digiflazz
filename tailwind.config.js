/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",
    content: ["./resources/**/*.blade.php"],
    theme: {
        extend: {
            colors: {
                "primary-cyan": "#0a3f47",
                "primary-cyan-light": "#22d3ee",
                "primary-slate": "#03001c",
                "primary-slate-light": "#353349",
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
    corePlugins: {
        preflight: false,
    },
};
