// https://eslint.org/docs/user-guide/configuring

module.exports = {
<<<<<<< HEAD
    extends: [
        // add more generic rulesets here, such as:
        // 'eslint:recommended',
        'plugin:vue/recommended',
    ],
    rules: {
        // override/add rules settings here, such as:
        // 'vue/no-unused-vars': 'error'
        'vue/no-v-html': 'off',
    },
=======
    root: true,
    parserOptions: {
        "parser": "babel-eslint",
        "ecmaVersion": 2017,
        "sourceType": "module"
    },
    env: {
        browser: true,
    },
    // https://github.com/standard/standard/blob/master/docs/RULES-en.md
    extends: 'plugin:vue/recommended',
    // required to lint *.vue files
    plugins: [
        'html'
    ],
    // add your custom rules here
    rules: {
        // allow async-await
        'generator-star-spacing': 'off',
        // allow debugger during development
        'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
        'vue/no-v-html': 'off',
    }
>>>>>>> dropjs
}
