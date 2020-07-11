<?php
namespace AlfredDagenais;
exit(); // No access to this page

if( !class_exists('WordCountUtf8') ){
    include_once('WordCountUtf8.php');
}

header('Content-Type: text/plain; charset=utf-8');
header("X-Robots-Tag: noindex, nofollow", true);

$strings = array(
    "This string has five words!",
    "emoji 😍😍 do not count in word",
    "<p>Bonjour madame Tremblay,</p>
    <p>Poète tourmenté et angoissé, Charles Baudelaire publie son célèbre recueil Les Fleurs du mal en 1857. Dans cette oeuvre, il rédige quatre poèmes qui mettent de l'avant un sentiment de désespoir, d’angoisse et d’ennui, état mental qu’il nomme le spleen.​</p>
    <p>Plusieurs romans ont présenté la situation difficile des Canadiens français durant les années 1940 et les répercussions de la guerre sur leur vie. Tit-Coq, une pièce de théâtre populaire, raconte justement l'histoire d'un jeune soldat revenant de guerre.</p>",
    "<p>Poète tourmenté et angoissé, Charles Baudelaire publie son célèbre recueil Les Fleurs du mal en 1857. Dans cette oeuvre, il rédige quatre poèmes qui mettent de l'avant un sentiment de désespoir, d’angoisse et d’ennui, état mental qu’il nomme le spleen.​</p>",
    "Poete tourmente et angoisse, Charles Baudelaire publie son celebre recueil Les Fleurs du mal en 1857. Dans cette oeuvre, il redige quatre poemes qui mettent de l'avant un sentiment de desespoir, d'angoisse et d'ennui, etat mental qu'il nomme le spleen.",
    "Un langage de programmation est censé être une façon conventionnelle de donner des ordres à un ordinateur. Il n'est pas censé être obscur, bizarre et plein de pièges subtils (ça ce sont les attributs de la magie).",
    "Programmez-vous pour être libre et libérez-vous de la programmation.",
    "Talk is cheap. Show me the code.",
    "When you don't create things, you become defined by your tastes rather than ability. your tastes only narrow and exclude people. so create.",
    "Un langage qui n'affecte pas votre manière de penser la programmation ne vaut pas la peine d'être connu.",
    'some "quoted text" does not impact',
    "also 'single quotes' are ok",
    'underbars are_too just one',
    'n-dash ranges 1–3 are NOT',
    'hyphenated words-are considered whole',
    'possessive’s are one word',
    '---',
    ' ',
    'hi',
    '___',
    'now with 23.17',
    'now with 23 a number'
);

$spacerElement = "\n";
$spacerEnd = "\n================================================================\n\n";
foreach( $strings as $string ){

    var_dump( $string );
    echo $spacerElement;

    echo 'WordCount : ';
    $count = WordCountUtf8::getWordCount( $string );
    var_dump( $count );

    echo 'CharacterCount : ';
    $count = WordCountUtf8::getCharacterCount( $string );
    var_dump( $count );

    echo 'CharacterWithoutSpaceCount : ';
    $count = WordCountUtf8::getCharacterWithoutSpaceCount( $string );
    var_dump( $count );

    echo $spacerEnd;

}