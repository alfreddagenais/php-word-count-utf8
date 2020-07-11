# PHP Word-Count for UTF-8 text

[![Latest Version on GitHub][ico-version]][link-github]
[![Software License][ico-license]](LICENSE.md)

Simple PHP implementation of Word-Count for UTF-8 text. Inspired by [sylae/word-count](https://github.com/sylae/word-count) 😗.

## Usage

`composer require alfreddagenais/php-word-count-utf8`

```php
<?php
use AlfredDagenais\WordCountUtf8;

// Example 1
$text = "This string has five words!";
$count = WordCountUtf8::getWordCount($text); // int(5)
$count = WordCountUtf8::getCharacterCount($text); // int(27)
$count = WordCountUtf8::getCharacterWithoutSpaceCount($text); // int(23)

// Example 2
$text = "When you don't create things, you become defined by your tastes rather than ability. your tastes only narrow and exclude people. so create.";
$count = WordCountUtf8::getWordCount($text); // int(23)
$count = WordCountUtf8::getCharacterCount($text); // int(139)
$count = WordCountUtf8::getCharacterWithoutSpaceCount($text); // int(117)

// Example 3
$text = "Un langage qui n'affecte pas votre manière de penser la programmation ne vaut pas la peine d'être connu.";
$count = WordCountUtf8::getWordCount($text); // int(18)
$count = WordCountUtf8::getCharacterCount($text); // int(104)
$count = WordCountUtf8::getCharacterWithoutSpaceCount($text); // int(87)
```

## Contributing

If you want, it's very nice to you 😍🔥

1. PSR-2 🎅.
2. Format code with [PHP Formatter](https://marketplace.visualstudio.com/items?itemName=Sophisticode.php-formatter) .
2. Write tests 🐛.
3. Send me a PR ✉️.
4. 😬🦄

## Todo

1. Check if `&` (ampersand) is considered as a word 🤔
 * Google Document : `NO`
 * Online Word Counter : `YES`
 * Microsoft Word : `YES`

## License

GNU GPLv3
