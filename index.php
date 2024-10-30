<?php

    /*  
    Plugin Name: csFormula1
    Description: Provides shortcodes to display the result tables for season, team and driver
    Author: Stephan Gerlach
    Version: 1.0.1
    Author URI: www.computersniffer.com 
    */  
    
    add_action('admin_menu', 'csformula1_admin_menu');
    function csformula1_admin_menu() {
        add_menu_page('csFormula1', 'csFormula1', 'administrator', 'csformula1_code', 'csformula1_code');
    }
    
    function csformula1_code() {
        
        echo '<div class="wrap">';
        echo '<h2>csFormula1 Shortcode Guide</h2>';
        echo '<p>This plugin will display a result table for Forumla 1 Season, Team and Driver from http://www.formula1.com</p>';
        echo '<p>Supported attributes: <code>type</code>,<code>season</code></p>';
        echo '<p>Supported types: <code>driver</code>,<code>team</code>,<code>season</code></p>';
        echo '<p>Supported season: <code>1950</code> till current or previous year</p>';
        echo '<h3>Samples</h3>';
        echo '<p><code>[csformula1 type="driver" season="2011"]</code></p>';
        echo '<p><code>[csformula1 type="team" season="1978"]</code></p>';
        echo '<p><code>[csformula1 type="season" season="1950"]</code></p>';
        echo '</div>';
        
    }
    
    add_shortcode( 'csformula1', 'csformula1' );
    function csformula1($atts) {
        
        extract( shortcode_atts( array(
		  'type' => 'driver',
          'season' => date('Y')
        ), $atts ) );
        
        $file = @file_get_contents('http://www.formula1.com/results/'.$type.'/'.$season.'/');
        
        $file = str_replace("\n",' ',$file);
        $file = str_replace("\r",' ',$file);
        
        $file = preg_replace('/\<\/a\>/','',$file);
        $file = preg_replace('#(<a.*?>)#', '', $file);
        
        
        preg_match_all('|<div class="contentContainer">(.*?)</div>|',$file,$m);
        
        
        return $m[1][0];
    }
    
?>