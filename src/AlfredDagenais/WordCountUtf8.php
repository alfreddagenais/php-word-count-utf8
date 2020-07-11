<?php

/**
 * Copyright (c) 2020 Alfred Dagenais <jesuis@alfreddagenais.com>
 * Use of this source code is governed by the GNU GPLv3 license, which
 * can be found in the LICENSE file.
 */

namespace AlfredDagenais;

class WordCountUtf8
{

    /**
     * Return the Word Count of a string
     *
     * @param string $sText Your string text
     * 
     * @return int The wordcount
     */
    public static function getWordCount(?string $sText): int
    {

        if (empty($sText)) {
            return 0;
        }

        $sText = self::getCleanedTextForCount($sText);

        // str_word_count not word correclty
        $sText = preg_replace('/\s+/', ' ', $sText); // For all whitespace (including tabs and line ends)

        if (empty($sText)) {
            return 0;
        }

        $aWords = explode(' ', trim($sText));

        return count($aWords);
    }

    /**
     * Return the Unique Word Count of a string
     *
     * @param string $sText Your string text
     * 
     * @return int The wordcount
     */
    public static function getUniqueWordCount(?string $sText): int
    {

        if (empty($sText)) {
            return 0;
        }

        $sText = self::getCleanedTextForCount($sText);
        if (empty($sText)) {
            return 0;
        }

        // str_word_count not word correclty
        $sText = preg_replace('/\s+/', ' ', $sText); // For all whitespace (including tabs and line ends)
        if (empty($sText)) {
            return 0;
        }

        $aWords = explode(' ', trim($sText));

        $aWords = array_unique($aWords);
        return count($aWords);
    }

    /**
     * Get character count
     *
     * @param string|null $sText
     * @return integer
     */
    public static function getCharacterCount(?string $sText): int
    {

        if (empty($sText)) {
            return 0;
        }

        $sText = self::getCleanedTextForCount($sText);
        if (empty($sText)) {
            return 0;
        }

        $nLineReturns = substr_count($sText, "\n");

        return strlen($sText) - $nLineReturns;
    }

    /**
     * Get character count without space 
     *
     * @param string|null $sText
     * @return integer
     */
    public static function getCharacterWithoutSpaceCount(?string $sText): int
    {

        if (empty($sText)) {
            return 0;
        }

        $sText = self::getCleanedTextForCount($sText);
        $sText = preg_replace('/\s+/', '', $sText); // For all whitespace (including tabs and line ends)
        if (empty($sText)) {
            return 0;
        }

        return strlen($sText);
    }

    /**
     * Get alphabetical character
     *
     * @param string|null $sText
     * @return integer
     */
    public static function getAlphabeticalCharacterCount(?string $sText): int
    {

        if (empty($sText)) {
            return 0;
        }

        $sText = self::getCleanedTextForCount($sText);
        $sText = preg_replace("/[^A-Za-z]/", "", $sText);
        if (empty($sText)) {
            return 0;
        }

        return strlen($sText);
    }

    /**
     * Get Cleaned Text for count
     *
     * @param string|null $sText string text
     * @param integer|null $nFlags A bitmask flags constants
     * 
     * @return string
     */
    public static function getCleanedTextForCount(?string $sText, ?int $nFlags = null): string
    {

        if (empty($sText)) {
            return '';
        }

        $nFlags = (empty($nFlags) ? ENT_QUOTES | ENT_HTML401 : $nFlags);

        $sText = htmlspecialchars_decode($sText, $nFlags); // Convert special HTML entities back to characters
        $sText = htmlentities($sText, $nFlags); // Convert all applicable characters to HTML entities
        $sText = htmlspecialchars_decode($sText, $nFlags); // Convert again special HTML entities back to characters

        $sText = self::getTextCleanedOfEmoji($sText);
        $sText = self::getTextCleanedOfNonPrintableCharacters($sText);

        $sUniqId = 'v@PZNP43FuSNG4WG5e*TmT3JbycG3YZB7SPRh##Y7UtaGb6E5V9hdu8wGPEjvKmrx5Q4Be'; // Unique patern to help Separator
        $sParagraphSeparator = "___{$sUniqId}___"; // Help string for Count
        $sText = self::cleanParagraphText($sText, $sParagraphSeparator, false);
        $sText = self::getTextCleanedOfQuoteHTMLTag($sText);
        $sText = self::getTextCleanedOfHyphenHTMLTag($sText, '');

        $sText = strip_tags($sText); // Remove All HTML Tags
        $sText = self::getTextFromHTMLEntities($sText);
        $sText = self::getTextCleanedOfMultipleTagItem($sText, ' '); // Replacing multiple spaces with a single space
        $sText = self::getTextCleanedOfMultipleTagItem($sText, '_'); // Replacing multiple underscore with a single underscore
        $sText = self::getTextCleanedOfMultipleTagItem($sText, '+'); // Replacing multiple plus with a single plus
        $sText = str_replace($sParagraphSeparator, "\n", $sText);

        $sText = self::getTextCleanedOfNonPrintableCharacters($sText);

        $sText = trim($sText); // Be sure no space or new line is at start or end of text

        return $sText;
    }

    /**
     * HTML entitites to regular Text
     *
     * @param string|null $sText string text
     * @param integer|null $nFlags A bitmask flags constants
     * 
     * @return string
     */
    public static function getTextFromHTMLEntities(?string $sText, ?int $nFlags = null): string
    {

        if (empty($sText)) {
            return '';
        }

        $nFlags = (empty($nFlags) ? ENT_QUOTES | ENT_HTML401 : $nFlags);
        $sText = htmlspecialchars_decode(html_entity_decode($sText, $nFlags));

        $sCharactersUtf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/_/'           =>   '_',
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );
        return preg_replace(array_keys($sCharactersUtf8), array_values($sCharactersUtf8), $sText);
    }

    /**
     * Clean Paragraphe Text
     *
     * @param string|null $sText string text
     * @param string $sParagraphTag A Paragraph Tag for replacement
     * @param bool $bStripTags Need Strip Tags ?
     * 
     * @return string
     */
    public static function cleanParagraphText(?string $sText, string $sParagraphTag = "\n", bool $bStripTags = true): string
    {

        if (empty($sText)) {
            return '';
        }

        $sText = str_replace(array("<p>", "</p>"), $sParagraphTag, $sText);
        $sText = str_replace(array("<P>", "</P>"), $sParagraphTag, $sText);
        $sText = str_replace(array("&nbsp;", "\t", PHP_EOL), ' ', $sText);
        $sText = self::getTextCleanedOfMultipleTagItem($sText, ' '); // Replacing multiple spaces with a single space
        $sText = self::getTextCleanedOfBRHTMLTag($sText, $sParagraphTag, true);
        $sText = str_replace(array("\n\r", " \n", " " . $sParagraphTag), $sParagraphTag, $sText);

        if ($bStripTags) {
            $sText = strip_tags($sText);
        }

        // Replace multiple $sParagraphTag with only one tag
        $sText = self::getTextCleanedOfMultipleTagItem($sText, $sParagraphTag);

        $sText = trim($sText);
        return $sText;
    }

    /**
     * Get Cleaned Text of Multiple Tag Item
     *
     * @param string|null $sText string text
     * @param string $sTag A Tag for replacement
     * 
     * @return string
     */
    public static function getTextCleanedOfMultipleTagItem(?string $sText, string $sTag, int $nTimeLooping = 10): string
    {

        if (empty($sText)) {
            return '';
        }

        // Replace multiple $sTag with only one tag
        if ($nTimeLooping > 0) {
            for ($i = $nTimeLooping; $i > 1; $i--) {
                $sText = str_replace(str_repeat($sTag, $i), $sTag, $sText);
            }
        }

        return $sText;
    }

    /**
     * Replace line breaks HTML Tag into text
     *
     * @param string|null $sText string text
     * @param string $sBRTag A line breaks Tag for replacement
     * @param bool $bReplaceNewLine Replace new line Tag
     * @param bool $bReplaceHtmlentitiesBR Replace Htmlentities of line breaks Tag for replacement
     * 
     * @return string
     */
    public static function getTextCleanedOfBRHTMLTag(?string $sText, string $sBRTag = '<br />', bool $bReplaceNewLine = false, bool $bReplaceHtmlentitiesBR = false): string
    {

        if (empty($sText)) {
            return '';
        }

        $aBR = array('<br>', '</br>', '<br/>', '<br />', '</ br>', '<BR>', '</BR>', '<BR/>', '<BR />', '</ BR>');
        if ($bReplaceHtmlentitiesBR) {
            foreach ($aBR as $nBR => $sBR) {
                $sText = str_replace(htmlentities($sBR), $sBRTag, $sText);
            }
        }

        $sText = str_replace($aBR, $sBRTag, $sText);
        if ($bReplaceNewLine) {
            $sText = str_replace(array("\n", "\r"), $sBRTag, $sText);
        }

        return $sText;
    }

    /**
     * Replace Simple And Double Quote into text
     *
     * @param string|null $sText string text
     * @param string $sQuoteTag A Quote tag for replacement
     * 
     * @return string
     */
    public static function getTextCleanedOfQuoteHTMLTag(?string $sText, string $sQuoteTag = '\''): string
    {

        if (empty($sText)) {
            return $sText;
        }

        $sText = self::getTextCleanedOfSingleQuoteHTMLTag($sText, $sQuoteTag);
        $sText = self::getTextCleanedOfDoubleQuoteHTMLTag($sText, $sQuoteTag);

        return $sText;
    }

    /**
     * Replace Single Quote into text
     *
     * @param string|null $sText string text
     * @param string $sQuoteTag A Quote tag for replacement
     * 
     * @return string
     * @link https://dev.w3.org/html5/html-author/charref
     */
    public static function getTextCleanedOfSingleQuoteHTMLTag(?string $sText, $sQuoteTag = '\''): string
    {

        if (empty($sText)) {
            return '';
        }

        $sText = str_replace(array(

            '\'', // &apos;
            '`',  // &grave;
            '´',  // &acute;
            '‘',  // &lsquo;
            '’',  // &lsquo;
            '′',  // &prime;
            '‵',  // &bprime;

            ''
        ), $sQuoteTag, $sText);
        $sText = str_replace(array(

            '&apos;', '&#x00027;', '&#39;', '&#039;', '&#0039;',
            '&grave;', '&DiacriticalGrave;', '&#x00060;', '&#96;', '&#096;', '&#0096;',
            '&acute;', '&DiacriticalAcute;', '&#x000B4;', '&#180;',
            '&lsquo;', '&OpenCurlyQuote;', '&#x02018;', '&#8216;',
            '&rsquo;', '&rsquor;', '&CloseCurlyQuote;', '&#x02019;', '&#8217;',
            '&prime;', '&#x02032;', '&#8242;',
            '&bprime;', '&backprime;', '&#x02035;', '&#8245;',

            ''
        ), $sQuoteTag, $sText);

        return $sText;
    }

    /**
     * Replace Double Quote into text
     *
     * @param string|null $sText string text
     * @param string $sQuoteTag A Quote tag for replacement
     * 
     * @return string
     * @link https://dev.w3.org/html5/html-author/charref
     */
    public static function getTextCleanedOfDoubleQuoteHTMLTag(?string $sText, string $sQuoteTag = '"'): string
    {

        if (empty($sText)) {
            return $sText;
        }

        $sText = str_replace(array(

            '"', // &quot;
            '“', // &ldquo;
            '”', // &rdquo;
            '″', // &Prime;

            ''
        ), $sQuoteTag, $sText);
        $sText = str_replace(array(

            '&quot;', '&QUOT;', '&#x00022;', '&#34;', '&#034;', '&#0034;',
            '&ldquo;', '&OpenCurlyDoubleQuote;', '&#x0201C;', '&#8220;',
            '&rdquo;', '&rdquor;', '&CloseCurlyDoubleQuote;', '&#x0201D;', '&#8221;',
            '&Prime;', '&#x02033;', '&#8243;',

            ''
        ), $sQuoteTag, $sText);

        return $sText;
    }

    /**
     * Replace Hyphen into text
     *
     * @param string|null $sText string text
     * @param string $sHyphenTag A Hyphen tag for replacement
     * 
     * @return string
     * @link https://dev.w3.org/html5/html-author/charref
     */
    public static function getTextCleanedOfHyphenHTMLTag(?string $sText, string $sHyphenTag = '-'): string
    {

        if (empty($sText)) {
            return '';
        }

        $sText = str_replace(array(

            '-', // &hyphen;
            '–', // &ndash;
            '—', // &mdash;
            '―', // &horbar;
            '⁃', // &hybull;
            '−', // &minus;

            ''
        ), $sHyphenTag, $sText);
        $sText = str_replace(array(

            '&hyphen;', '&dash;', '&#x02010;', '&#8208;',
            '&ndash;', '&#x02013;', '&#8211;',
            '&mdash;', '&#x02014;', '&#8212;',
            '&horbar;', '&#x02015;', '&#8213;',
            '&hybull;', '&#x02043;', '&#8259;',
            '&minus;', '&#x02212;', '&#8722;',

            ''
        ), $sHyphenTag, $sText);

        return $sText;
    }

    /**
     * Remove Emoji from text
     *
     * @param string|null $sText string text
     * 
     * @return string
     */
    public static function getTextCleanedOfEmoji(?string $sText): string
    {
        if (empty($sText)) {
            return '';
        }

        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $sCleanedText = preg_replace($regexEmoticons, '', $sText);

        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $sCleanedText = preg_replace($regexSymbols, '', $sCleanedText);

        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $sCleanedText = preg_replace($regexTransport, '', $sCleanedText);

        return $sCleanedText;
    }

    /**
     * Remove all non printable characters in a string
     *
     * @param string|null $sText string text
     * 
     * @return string
     */
    public static function getTextCleanedOfNonPrintableCharacters(?string $sText): string
    {
        if (empty($sText)) {
            return '';
        }

        // build an array we can re-use across several operations
        $aBadCharacters = array(
            // control characters
            chr(0), chr(1), chr(2), chr(3), chr(4), chr(5), chr(6), chr(7), chr(8), chr(9), chr(10),
            chr(11), chr(12), chr(13), chr(14), chr(15), chr(16), chr(17), chr(18), chr(19), chr(20),
            chr(21), chr(22), chr(23), chr(24), chr(25), chr(26), chr(27), chr(28), chr(29), chr(30),
            chr(31),
            // non-printing characters
            chr(127)
        );

        // replace the unwanted Characters
        $sText = str_replace($aBadCharacters, '', $sText);

        // Special end characters
        $sText = str_replace(array("&iuml;&raquo;&iquest;", 'ï»¿'), '', $sText);

        // remove BOM
        $bom = pack('H*', 'EFBBBF');
        $sText = preg_replace("/^$bom/", '', $sText);
        $sText = str_replace("\xEF\xBB\xBF", '', $sText);
        $sText = preg_replace('/\x{FEFF}/u', '', $sText);

        // Some time they have some invisible last characters
        // to detect this char : ord(substr( $sText, -1))
        $sText = str_replace(chr(226) . chr(128) . chr(139), '', $sText);

        return $sText;
    }
}
