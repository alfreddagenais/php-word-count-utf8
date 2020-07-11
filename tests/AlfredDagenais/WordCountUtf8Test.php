<?php
/**
 * Copyright (c) 2020 2020 Alfred Dagenais <jesuis@alfreddagenais.com>
 * Use of this source code is governed by the GNU GPLv3 license, which
 * can be found in the LICENSE file.
 */
namespace AlfredDagenais;

use PHPUnit\Framework\TestCase;

class WordCountUtf8Test extends TestCase
{

    /**
     * Word Count Accuracy testing
     * Some copy-pasted from Iarna's test suite.
     */
    public function testWordCountAccuracy()
    {

        $this->assertEquals(WordCountUtf8::getWordCount('This is a test'), 4, 'plain text');
        $this->assertEquals(WordCountUtf8::getWordCount('now with 23 a number'), 5, 'integer');
        $this->assertEquals(WordCountUtf8::getWordCount('now with 23.17'), 3, 'decimal');
        $this->assertEquals(WordCountUtf8::getWordCount("emoji 😍😍 do not count"), 4, 'emoji');
        $this->assertEquals(WordCountUtf8::getWordCount("possessive's are one word"), 4, 'possessive');
        $this->assertEquals(WordCountUtf8::getWordCount('possessive’s are one word'), 4, 'possessive unicode');
        $this->assertEquals(WordCountUtf8::getWordCount('some "quoted text" does not impact'), 6, 'quotes');
        $this->assertEquals(WordCountUtf8::getWordCount("also 'single quotes' are ok"), 5, 'single quotes');
        $this->assertEquals(WordCountUtf8::getWordCount("don't do contractions"), 3, 'contractions count as a single word');
        $this->assertEquals(WordCountUtf8::getWordCount('hyphenated words-are considered whole'), 4, 'hyphenated words');
        $this->assertEquals(WordCountUtf8::getWordCount('underbars are_too just one'), 4, 'underbars');
        $this->assertEquals(WordCountUtf8::getWordCount('n-dash ranges 1–3 are NOT'), 5, 'en-dash');
        $this->assertEquals(WordCountUtf8::getWordCount('m-dash connected—bits also are not'), 5, 'em-dash');
        $this->assertEquals(WordCountUtf8::getWordCount("Un langage qui n'affecte pas votre manière de penser la programmation ne vaut pas la peine d'être connu."), 18, 'french accent');
        $this->assertEquals(WordCountUtf8::getWordCount('<strong>This is a html test</strong>'), 5, 'html simple');
        $this->assertEquals(WordCountUtf8::getWordCount("<p>This is a paragraph</p><p>An other paragraph</p>"), 7, 'html paragraph');
        $this->assertEquals(WordCountUtf8::getWordCount("<p>This is a paragraph</p>\n<p>An other paragraph</p>"), 7, 'html paragraph2');

    }

    /**
     * Tests some weird shit that might result from parser stuff being wonky.
     */
    public function testCountWeirdShit()
    {

        $this->assertEquals(WordCountUtf8::getWordCount(''), 0, 'empty string');
        $this->assertEquals(WordCountUtf8::getWordCount('---'), 0, 'just some hyphens');
        $this->assertEquals(WordCountUtf8::getWordCount(' '), 0, 'just a space');
        $this->assertEquals(WordCountUtf8::getWordCount('hi'), 1, 'just one word');

    }

    /**
     * Word Count Accuracy
     */
    public function testCharacterCountAccuracy()
    {

        $this->assertEquals(WordCountUtf8::getCharacterCount('This is a test'), 14, 'plain text');
        $this->assertEquals(WordCountUtf8::getCharacterCount('now with 23 a number'), 20, 'integer');
        $this->assertEquals(WordCountUtf8::getCharacterCount('now with 23.17'), 14, 'decimal');
        $this->assertEquals(WordCountUtf8::getCharacterCount("emoji 😍😍 do not count"), 18, 'emoji');
        $this->assertEquals(WordCountUtf8::getCharacterCount("possessive's are one word"), 25, 'possessive');
        $this->assertEquals(WordCountUtf8::getCharacterCount('possessive’s are one word'), 25, 'possessive unicode');
        $this->assertEquals(WordCountUtf8::getCharacterCount('some "quoted text" does not impact'), 34, 'quotes');
        $this->assertEquals(WordCountUtf8::getCharacterCount("also 'single quotes' are ok"), 27, 'single quotes');
        $this->assertEquals(WordCountUtf8::getCharacterCount("don't do contractions"), 21, 'contractions count as a single word');
        $this->assertEquals(WordCountUtf8::getCharacterCount('hyphenated words-are considered whole'), 36, 'hyphenated words');
        $this->assertEquals(WordCountUtf8::getCharacterCount('underbars are_too just one'), 26, 'underbars');
        $this->assertEquals(WordCountUtf8::getCharacterCount('n-dash ranges 1–3 are NOT'), 23, 'en-dash');
        $this->assertEquals(WordCountUtf8::getCharacterCount('m-dash connected—bits also are not'), 32, 'em-dash');
        $this->assertEquals(WordCountUtf8::getCharacterCount("Un langage qui n'affecte pas votre manière de penser la programmation ne vaut pas la peine d'être connu."), 104, 'french accent');
        $this->assertEquals(WordCountUtf8::getCharacterCount('<strong>This is a html test</strong>'), 19, 'html simple');
        $this->assertEquals(WordCountUtf8::getCharacterCount("<p>This is a paragraph</p><p>An other paragraph</p>"), 38, 'html paragraph');
        $this->assertEquals(WordCountUtf8::getCharacterCount("<p>This is a paragraph</p>\n<p>An other paragraph</p>"), 38, 'html paragraph2');

    }
    
}
