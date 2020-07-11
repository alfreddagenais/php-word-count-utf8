# PHP Word-Count for UTF-8 text

![build](https://github.com/alfreddagenais/php-word-count-utf8/workflows/build/badge.svg?branch=master) ![Love Open Source](https://badges.frapsoft.com/os/v1/open-source.svg?v=103) ![Stars](https://img.shields.io/github/stars/alfreddagenais/php-word-count-utf8) ![Forks](https://img.shields.io/github/forks/alfreddagenais/php-word-count-utf8) ![Issues](https://img.shields.io/github/issues/alfreddagenais/php-word-count-utf8) ![License](https://img.shields.io/github/license/AkashRajpurohit/clipper) ![Visitors](https://visitor-badge.glitch.me/badge?page_id=alfreddagenais-php-word-count-utf8.visitor-badge) ![Tweet](https://img.shields.io/twitter/url?url=https%3A%2F%2Fgithub.com%2Falfreddagenais%2Fphp-word-count-utf8)

Simple PHP implementation of Word-Count for UTF-8 text. Inspired by [sylae/word-count](https://github.com/sylae/word-count) 😗.

## 🙌 Usage

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
4. 😬 🦄

## Testing

`composer test` or `./vendor/bin/phpunit tests`

## 💵 Support
> If you found this project helpful or you learned something from the source code and want to thank me, consider buying me a cup of :coffee:

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/AlfredDagenais)

## Todo

1. Check if `&` (ampersand) is considered as a word 🤔
 * Google Document : `NO`
 * Online Word Counter : `YES`
 * Microsoft Word : `YES`
 
## 🐛 Bugs or Requests

If you encounter any problems feel free to open an [issue](https://github.com/alfreddagenais/php-word-count-utf8/issues/new?template=bug_report.md). If you feel the library is missing a feature, please raise a [ticket](https://github.com/alfreddagenais/php-word-count-utf8/issues/new?template=feature_request.md) on GitHub and I'll look into it. Pull request are also welcome.

## License

GNU GPLv3

## Where to find me?
* [Website](https://alfreddagenais.com)
* [Linkedin](https://www.linkedin.com/in/AlfredDagenais)
* [Instagram](https://www.instagram.com/AlfredDagenaisWeb)
* [Twitter](https://www.twitter.com/ProgrammeurWeb)
* [Facebook](https://www.facebook.com/AlfredDagenaisWeb/)