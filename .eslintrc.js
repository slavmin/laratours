// https://eslint.org/docs/user-guide/configuring

module.exports = {
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
        'vue/html-self-closing': 'off',
        'vue/max-attributes-per-line': [2, {
            'singleline': 20,
            'multiline': {
                'max': 1,
                'allowFirstLine': false
            }
        }],
        'vue/singleline-html-element-content-newline': 'off'
    }
}
