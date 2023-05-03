/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",
    content: ["./resources/**/*.blade.php"],
    theme: {
        extend: {},
    },
    plugins: [require("@tailwindcss/forms")],
    corePlugins: {
        preflight: false,
    },
};
