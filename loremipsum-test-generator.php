<?php
/*
Plugin Name: LoremIpsum Test Generator
Description: Plugin to create sitecontent based on loripsum API and ImageContent from Unsplash
Version: 1.0.0
Author: Lukas Niebler
*/


/** Inhaltsverzeichnis
 * I Klasse und Methode zum generieren der Wörter und Sätze
 * II Shortcodes
 * */

class LoremIpsumTestgenerator {
    
    function getWords() {

        $main = array(
            'Alice',
            'Schwester',
            'Bilder',
            'Gespräche',
            'Gänseblümchen',
            'Kette',
            'Kaninchen',
            'Augen',
            'Mühe',
            'Westentasche',
            'Grasplatz',
            'Neugierde',
            'Kaninchenbau',
            'Landkarten',
            'Küchenschränken',
            'Bücherbrettern',
            'Töpfchen',
            'Aufschrift',
            'Apfelsinen',
            'Miez',
        );
        
        $keywords = array(
            'Polymer',
            'Polysaccharid',
            'Lymphocyten',
            "Mendel'sche Regel",
            'K+',
            'Na-K-Pumpe',
            "Guanosin-5'-triphosphat",
            'Sakroplasmatisches',
            'Retikulum',
        );

        $polyfill = array(
            'an',
            'sich',
            'zu',
            'lange',
            'bei',
            'am',
            'und',
            'das',
            'der',
            'die',
            'ohne',
            'ob',
        );

            $words = array_merge($main, $keywords, $polyfill);
            shuffle($words);

            return $words;
    }

    function getSentence() {
        $words = $this->getWords();
        $randomNumber = rand(6, 10);
        $sentence = '';

        $words[0] = ucfirst($words[0]);

        if (count($words) > 0) {
            for ($i = 0; $i < $randomNumber; $i++) {
                $sentence .= $words[$i]." ";
            }
            $sentence = rtrim($sentence).".";
        }
        return $sentence;
    }

    function getParagraph() {
        $randomNumber = rand(3, 5);
        $paragraph = '';
        $output = '';
            for ($j = 0; $j < $randomNumber; $j++) {
                $paragraph .= $this->getSentence()." ";
            }
            $output .= "<p>".$paragraph."</p>";

        return $output;
    }
}



//Shortcode lorem


add_shortcode('lorem', 'lorem_display_shortcode');
function lorem_display_shortcode( $atts ) {
    $paragraphs = $atts['number'];
    $length = $atts['length'];
    $type = $atts['type'];
    $response = wp_remote_get( 'http://loripsum.net/api/'.$paragraphs.'/'.$length.'/'.$type );
    $body = wp_remote_retrieve_body( $response );
    return $body;
}

add_shortcode('ipsum', 'ipsum_display_shortcode');
function ipsum_display_shortcode( $atts ){
    $number = $atts['number'];
    $output = '';

    $generator = new LoremIpsumTestgenerator();
    
    for ($i = 0; $i < $number; $i++){
        $output .= $generator->getParagraph();
    }

    return $output;
}
