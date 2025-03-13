import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            screens: {
                "max-960": { max: "960px" },
            },
            fontFamily: {
                sans: ["Istok Web", ...defaultTheme.fontFamily.sans],
                koho: ["KoHo", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary_white: "#F7F7F7",
                secondary_blue: "#2867A4",
                accent_blue: "#2D336B",
                secondary_black: "#212121",
                accent_grey: "#EEEEEE",
                secondary_green: '#388E3C',
                accent_red : '#D1042D'
            },
        },
    },

    plugins: [
        forms,
        require("tailwindcss-animated"),
        require("tailwindcss-children"),
    ],
};
