// eslint.config.mjs
import js from '@eslint/js';
import reactPlugin from 'eslint-plugin-react';
import jsxA11yPlugin from 'eslint-plugin-jsx-a11y';
import stylistic from '@stylistic/eslint-plugin';
import globals from 'globals';

export default [
	// 1. ESLint Recommended Rules
	js.configs.recommended,

	// 2. React Specific Configuration (for Gutenberg blocks/components)
	{
		files: [ '**/*.{js,jsx,mjs,ts,tsx}' ],
		ignores: [
			'**/node_modules/**',
			'**/dist/**',
			'**/build/**',
		],
		plugins: {
			react: reactPlugin,
			'jsx-a11y': jsxA11yPlugin,
		},
		languageOptions: {
			parserOptions: {
				ecmaFeatures: {
					jsx: true,
				},
			},
		},
		settings: {
			react: {
				version: 'detect',
			},
		},
		rules: {
			...reactPlugin.configs.recommended.rules,
			...jsxA11yPlugin.configs.recommended.rules,
			'react/react-in-jsx-scope': 'off', // https://github.com/jsx-eslint/eslint-plugin-react/blob/master/docs/rules/react-in-jsx-scope.md
			'react/prop-types': 'off', // https://github.com/jsx-eslint/eslint-plugin-react/blob/master/docs/rules/prop-types.md
			'react/jsx-filename-extension': [ 1, { 'extensions': [ '.js', '.jsx' ] } ], // https://github.com/jsx-eslint/eslint-plugin-react/blob/master/docs/rules/jsx-filename-extension.md
			'react/destructuring-assignment': [ 1 ], // https://github.com/jsx-eslint/eslint-plugin-react/blob/master/docs/rules/destructuring-assignment.md
			'react/hook-use-state': [ 'error', { 'allowDestructuredState': true } ], // https://github.com/jsx-eslint/eslint-plugin-react/blob/master/docs/rules/hook-use-state.md
			'react/jsx-indent-props': [ 2, 'tab' ], // https://github.com/jsx-eslint/eslint-plugin-react/blob/master/docs/rules/jsx-indent-props.md
			'react/jsx-curly-spacing': [ 2, 'always' ], // https://github.com/jsx-eslint/eslint-plugin-react/blob/master/docs/rules/jsx-curly-spacing.md
			'react/jsx-props-no-spread-multi': [ 2 ] // https://github.com/jsx-eslint/eslint-plugin-react/blob/master/docs/rules/jsx-props-no-spread-multi.md
		},
	},

	// 3. Stylistic
	{
		files: [ '**/*.{js,jsx,mjs,tsx,ts}' ],
		ignores: [
			'**/node_modules/**',
			'**/dist/**',
			'**/build/**',
		],
		plugins: {
			'@stylistic': stylistic,
		},
		rules: {
			'@stylistic/space-in-parens': [ 'warn', 'always' ], // https://eslint.style/rules/js/space-in-parens
			'@stylistic/semi': [ 'warn', 'always' ], // https://eslint.style/rules/js/semi
			'@stylistic/space-before-blocks': [ 'warn', 'always' ], // https://eslint.style/rules/js/space-before-blocks
			'@stylistic/object-curly-spacing': [ 'warn', 'always' ], // https://eslint.style/rules/js/object-curly-spacing
			'@stylistic/array-bracket-spacing': [ 'warn', 'always' ], // https://eslint.style/rules/js/object-curly-spacing
			'@stylistic/key-spacing': [ 'warn', { "beforeColon": false } ], // https://eslint.style/rules/js/object-curly-spacing
			'@stylistic/block-spacing': [ 'warn', 'always' ], //https://eslint.style/rules/js/block-spacing
		},
	},

	// 4. Gnist Overrides
	{
		files: [ '**/*.{js,jsx,mjs,tsx,ts}' ],
		ignores: [
			'**/node_modules/**',
			'**/dist/**',
			'**/build/**',
		],
		languageOptions: {
			globals: {
				...globals.browser,
				wp: 'readonly',
				propTypes: 'readonly'
			},
		},
		rules: {
			'strict': [ 'error', 'global' ], // https://eslint.org/docs/latest/rules/strict
			'yoda': [ 'error', 'always' ], // https://eslint.org/docs/latest/rules/yoda
			'array-callback-return': [ 'error', { checkForEach: true } ], // https://eslint.org/docs/latest/rules/array-callback-return
			'no-constructor-return': [ 'error' ], // https://eslint.org/docs/latest/rules/no-constructor-return
			'no-duplicate-imports': [ 'error' ], // https://eslint.org/docs/latest/rules/no-duplicate-imports
			'dot-notation': [ 'warn' ], //https://eslint.org/docs/latest/rules/dot-notation
			'vars-on-top': [ 'warn' ], // https://eslint.org/docs/latest/rules/vars-on-top
			'default-param-last': [ 'error' ], // https://eslint.org/docs/latest/rules/default-param-last
			'max-params': [ 'error', 4 ], // https://eslint.org/docs/latest/rules/max-params
			'max-statements': [ 'error', 30 ], // https://eslint.org/docs/latest/rules/max-statements
			'no-console': [ 'warn', { allow: [ 'warn', 'error' ] } ], // https://eslint.org/docs/latest/rules/no-console
			'camelcase': [ 'warn' ], // https://eslint.org/docs/latest/rules/camelcase
			'eqeqeq': [ 'error' ], // https://eslint.org/docs/latest/rules/eqeqeq
			'prefer-const': [ 'warn' ], // https://eslint.org/docs/latest/rules/prefer-const
			'prefer-arrow-callback': [ 'error' ], // https://eslint.org/docs/latest/rules/prefer-arrow-callback
			'prefer-destructuring': [ 'warn' ], // https://eslint.org/docs/latest/rules/prefer-destructuring
			'prefer-object-spread': [ 'warn' ], // https://eslint.org/docs/latest/rules/prefer-object-spread
			'prefer-template': [ 'warn' ], // https://eslint.org/docs/latest/rules/prefer-template
			'prefer-spread': [ 'warn' ], // https://eslint.org/docs/latest/rules/require-await
			'require-await': [ 'error' ], // https://eslint.org/docs/latest/rules/require-await
			'no-eval': [ 'error' ], // https://eslint.org/docs/latest/rules/no-eval
			'no-implied-eval': [ 'error' ], // https://eslint.org/docs/latest/rules/no-implied-eval
			'no-iterator': [ 'error' ], // http://eslint.org/docs/latest/rules/no-iterator
			'no-multi-assign': [ 'error' ], // https://eslint.org/docs/latest/rules/no-multi-assign
			'no-useless-constructor': [ 'warn' ], //https://eslint.org/docs/latest/rules/no-useless-constructor
			'no-useless-return': [ 'warn' ], // https://eslint.org/docs/latest/rules/no-useless-return
			'no-var': [ 'error' ], // https://eslint.org/docs/latest/rules/no-var
			'no-warning-comments': [ 'warn' ], // https://eslint.org/docs/latest/rules/no-warning-comments
			'no-use-before-define': [ 'error', { 'functions': true, 'classes': true, 'variables': true, 'allowNamedExports': false } ] // https://eslint.org/docs/latest/rules/no-use-before-define
		},
	},
];
