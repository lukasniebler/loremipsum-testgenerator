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
    
    function wortgenerierung() {

        $schlagwoerter = array(
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
        
        $fachwoerter = array(
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

        $fuellwoerter = array(
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

            $woerter = array_merge($schlagwoerter, $fachwoerter, $fuellwoerter);
            shuffle($woerter);

            return $woerter;
    }

    function satzgenerierung() {
        $woerter = $this->wortgenerierung();
        $satz = '';

        if (count($woerter) > 0) {
            for ($i = 0; $i < 24; $i++) {
                $satz .= $woerter[$i]." ";
            }
        }
        return $satz;
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
};

add_shortcode('ipsum', 'ipsum_display_shortcode');
function ipsum_display_shortcode(){
    $generator = new LoremIpsumTestgenerator();
    $output = $generator->satzgenerierung();

    return $output;
}