# Markdown for WordPress

A plugin that adds Markdown support and code syntax highlighting to WordPress.

I developed this for personal use, and I offer it as-is, with no intention to please any crowds.  There are many Markdown plugins in the repository and I encourage you to try those first, I only created this because none of them gave me exactly what I needed.

This plugin uses [PHP Markdown](https://michelf.ca/projects/php-markdown/) to render Markdown, with [Prism.js](http://prismjs.com) for syntax highlighting.

## Installation

This plugin is not available in the repository, [Composer](https://getcomposer.org) is the recommended way to install it:

```bash
$ composer require goblindegook/wp-markdown-g
```

If you want to know more about using Composer with WordPress, there's [a good introduction at the Roots project site](https://roots.io/using-composer-with-wordpress/).

## Syntax Highlighting

The plugin is bundled with Prism.js to highlight code in the following languages:

* Bash
* C/C++
* CoffeeScript
* CSS
* Git
* Handlebars
* HTML
* HTTP
* INI
* Java
* JavaScript (and JSX)
* LESS
* Makefile
* Markdown
* Objective-C
* Perl
* PHP
* Python
* Ruby
* Scala
* SCSS
* SQL
* Swift
* Twig
* TypeScript
* YAML

### Overriding the colour scheme

The plugin uses Paul Livingstone's [Okaidia](http://prismjs.com/index.html?theme=prism-okaidia) theme by default.  If you need to override Okaidia on your theme (or in some other plugin), I recommend you dequeue ours first:

```php
wp_dequeue_style( 'wp-markdown-prism' );
```

