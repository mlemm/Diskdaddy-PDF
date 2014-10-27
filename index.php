<?php
/***********************************************************************
Plugin Name: PDF Thumbnail Shortcode Plugin
Plugin URI:  http://www.diskdaddy.com
Description: Shortcode to generate a pdf image linked to pdf media file.
Version:     1.0
Author:      Diskdaddy Software & Web Development Inc.*/


// Register the shortcode
function pdf_thumbnail_func($atts, $content = null) {
    $output = '';
    
    // suck out the attributes
    $a = shortcode_atts( array(
        'width' => '300',
        'height' => '300'
        // ...etc
    ), $atts );
    
    
    $im = new imagick();
    $im->setResolution(100, 100);
    $im->setCompressionQuality(65);
    
    // get the file
    file_put_contents("tmpfile.pdf", fopen($content, 'r'));
    
    $im->readimage("tmpfile.pdf[0]"); 
    $im->setImageFormat('jpeg'); 
    
    $upload_dir = wp_upload_dir();
    //$thumbnail_url = "//thumb.jpg";
    $im->writeImage("tmpfile.jpg"); 
    $im->clear(); 
    $im->destroy();
    
    $output .= "<a href='" . $content . "'><img src='https://www.diskdaddy.com/tmpfile.jpg'/></a>";
    
	return do_shortcode($output);
}
add_shortcode( 'pdf_thumb', 'pdf_thumbnail_func' );
?>
