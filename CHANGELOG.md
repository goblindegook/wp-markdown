# Change Log

## [unreleased]

* Exports Markdown document metadata.
* New `markdown_metadata` filter.
* Fixed rewrite rules for the `.text` pseudo-extension on pages and subpages.

## [1.0.3]

* Fixed rewrite rules for the `.text` pseudo-extension.

## [1.0.2]

* Supports adding `.text` to a post slug to get its raw Markdown content. Only works with public, non-password protected posts. (Adding `?export=markdown` to a single post request also works.)

## [1.0.1]

* Fixes shortcode processing.

## 1.0.0

* Initial release.
* Markdown rendering using Parsedown.
* Syntax highlighting using Prism.js.

[unreleased]: https://github.com/goblindegook/wp-markdown-g/compare/1.0.3...HEAD
[1.0.3]: https://github.com/goblindegook/wp-markdown-g/compare/1.0.2...1.0.3
[1.0.2]: https://github.com/goblindegook/wp-markdown-g/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/goblindegook/wp-markdown-g/compare/1.0.0...1.0.1
