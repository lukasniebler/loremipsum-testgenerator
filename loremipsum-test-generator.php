<?php
/*
Plugin Name: LoremIpsum Test Generator
Description: Plugin to create sitecontent based on loripsum API and ImageContent from Unsplash
Version: 1.0.2
Author: Lukas Niebler
*/


/** Inhaltsverzeichnis
 * I PluginClass
 *      I   List of words and word generation functions
 *      II  Register settings and settingspage setup
 *      III Uninstall function
 *      IV  Constructor
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

    function getSpecialCharset($type = 'default', $modus = '1') {
        if ($modus == 1){
            $standard = "— – ­ “ & ˆ ¡ ¦ ¨ ¯ ´ ¸ ¿ ˜ ‘ ’ ‚ “ ” „ ‹ › < > ± « » × ÷ ¢ £ ¤ ¥ § © ¬ ® ° µ ¶ · † ‡ ‰ € ¼ ½ ¾ ¹ ² ³ á Á â Â à À å Å ã Ã ä Ä ª æ Æ ç Ç ð Ð é É ê Ê è È ë Ë ƒ í Í î Î ì Ì ï Ï ñ Ñ ó Ó ô Ô ò Ò º ø Ø õ Õ ö Ö œ Œ š Š ß þ Þ ú Ú û Û ù Ù ü Ü ý Ý ÿ Ÿ";
            $paragraph = '<p>'.$standard.'</p>';
        } else if ($modus == 2){
            $unicode = "";
                for ($i = 0; $i<10626; $i++){
                    if($type == 'debug'){
                    $unicode .= '&#'.$i.";"." [$i] |";
                    } else if($type == 'default'){
                    $unicode .= '&#'.$i.";"." ";
                    };
                }   
            $paragraph = '<p>'.$unicode.'</p>';
            }

        return $paragraph;

    }

    public function field_callback( $arguments ) {
        $value = get_option( $arguments['uid'] ); // Get the current value, if there is one
        if( ! $value ) { // If no value exists
            $value = $arguments['default']; // Set to our default
        }
    
        // Check which type of field we want
        switch( $arguments['type'] ){
            case 'text': // If it is a text field
                printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
                break;
        }
    
        // If there is help text
        if( $helper = $arguments['helper'] ){
            printf( '<span class="helper"> %s</span>', $helper ); // Show it
        }
    
        // If there is supplemental text
        if( $supplimental = $arguments['supplemental'] ){
            printf( '<p class="description">%s</p>', $supplimental ); // Show it
        }
    }
    
    public function get_fields() {
        $fields = array(
            array(
                'uid' => 'unsplash_access_key',
                'label' => 'Access key',
                'section' => 'our_first_section',
                'type' => 'text',
                'options' => false,
                'placeholder' => 'Access key',
                'helper' => 'Enter your Access key for Unsplash API ',
                'supplemental' => '',
                'default' => ''
            ),
            array(
                'uid' => 'unsplash_secret_key',
                'label' => 'Secret key',
                'section' => 'our_first_section',
                'type' => 'text',
                'options' => false,
                'placeholder' => 'Secret key',
                'helper' => 'Enter your Secret key for Unsplash API.',
                'supplemental' => '',
                'default' => ''
            ),
        );
        return $fields;
    }

    public function setup_fields() {
        $fields = $this->get_fields();
        foreach( $fields as $field ){
            add_settings_field( $field['uid'], $field['label'], array( $this, 'field_callback' ), 'lorem_ipsum_testgen', $field['section'], $field );
            register_setting( 'lorem_ipsum_testgen', $field['uid'] );
        }
    }

    //callback method for settings page
    public function plugin_settings_page_content() { ?>
        <div class="wrap">
            <h2>Lorem Ipsum API Settings</h2>
            <form method="post" action="options.php">
                <?php
                    settings_fields( 'lorem_ipsum_testgen' );
                    do_settings_sections( 'lorem_ipsum_testgen' );
                    submit_button();
                ?>
            </form>
        </div> <?php
    }

    //Settings section callback
    public function section_callback( $arguments ) {
        switch( $arguments['id'] ){
            case 'our_first_section':
                echo "If you want to use the Unsplash API, please paste in your Unsplash API details. \n You can also use the Plugin without using the Unsplash API. \n Without your Unsplash API details the plugin will use 10 preset images out of the plugin-directory.";
                
                break;
            /*
            case 'our_second_section':
                break;
            */
        }
    }

    //Register section for settings page
    public function setup_sections() {
        add_settings_section( 'our_first_section', 'Unsplash API Token', array( $this, 'section_callback' ), 'lorem_ipsum_testgen' );
    }

    //Create field for settings in admin menu
    public function create_plugin_settings_page() {
        // Add the menu item and page
        $page_title = 'Lorem Ipsum Settings';
        $menu_title = 'Lorem Ipsum';
        $capability = 'manage_options';
        $slug = 'lorem_ipsum_testgen';
        $callback = array( $this, 'plugin_settings_page_content' );
        $icon = 'dashicons-admin-plugins';
        $position = 100;
    
        //add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position ); //Top menu position
        add_submenu_page( 'options-general.php', $page_title, $menu_title, $capability, $slug, $callback ); //Submenu under settings
    }
    
    // Constructor Method
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'create_plugin_settings_page' ) );
        add_action( 'admin_init', array( $this, 'setup_sections' ) );
        add_action( 'admin_init', array( $this, 'setup_fields' ) );
            // Plugin uninstall
        register_uninstall_hook(__FILE__, array( $this, 'unregister_hooks' ));
    }

    public function unregister_hooks() {
        $fields = $this->get_fields();
        foreach( $fields as $field ){
            unregister_setting( 'lorem_ipsum_testgen', $field['uid'] );
            delete_option($field['uid']);
        }
    }
}

new LoremIpsumTestgenerator();

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

add_shortcode('unicode', 'unicode_display_shortcode');
function unicode_display_shortcode( $atts ){
    $generator = new LoremIpsumTestgenerator();
    $output = $generator->getSpecialCharset($atts['type'], $atts['modus']);

    return $output;
}
