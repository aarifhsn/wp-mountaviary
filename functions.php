<?php

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Theme Title
 */

add_theme_support('title-tag');

/**
 * Enqueue scripts and styles.
 */
function mountaviary_scripts() {
	
	wp_register_style('tailwind_css', get_template_directory_uri() . './dist/output.css', array(), '3.4.0');
	wp_enqueue_style('tailwind_css');

	wp_enqueue_style( 'mountaviary-style', get_stylesheet_uri(), array(), _S_VERSION );

	wp_register_script( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js', array(), '6.5.1', true );
	wp_enqueue_script( 'fontawesome' );

	
	wp_register_style( 'mountaviary_google_fonts', 'https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,800&display=swap', false );
	wp_enqueue_style( 'mountaviary_google_fonts');

	wp_enqueue_script( 'mountaviary_script', get_template_directory_uri(  ). '/src/scripts.js', array(), _S_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'mountaviary_scripts' );


/*
*Theme logo customizar register
*Theme function
*/

function mountaviary_customizer_register ($wp_customize) {

	$wp_customize->add_section('mountaviary_header_area', array(
        'title'    => __('Header Area', 'mountaviary'),
        'description' => 'Change your desired logo.',
    ));

    $wp_customize->add_setting('mountaviary_header_logo', array(
        'default'        => get_bloginfo('template_directory').'/img/profile.webp',

    ));

	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'mountaviary_header_logo', array(
        'label'    => __('Logo Upload', 'mountaviary'),
        'section'  => 'mountaviary_header_area',
        'settings' => 'mountaviary_header_logo',
    )));

	// FOOTER BOTTOM TEXT CUSTOMIZE 

	$wp_customize->add_section('mountaviary_footer_area', array(
        'title'    => __('Footer Area', 'mountaviary'),
        'description' => 'Change Footer Text.',
    ));

    $wp_customize->add_setting('mountaviary_footer_text', array(
        'default'        => 'All Rights Reserved.',

    ));
	
    $wp_customize-> add_control('mountaviary_footer_text_control', array(
        'label'    => __('Footer Text', 'mountaviary'),
        'section'  => 'mountaviary_footer_area',
        'settings' => 'mountaviary_footer_text',
    ));

    $wp_customize->add_setting('mountaviary_footer_selection', array(
        'default'        => '&copy' . date('Y') ,

    ));
	
    $wp_customize-> add_control('mountaviary_footer_selcetion_control', array(
        'label'    => __('Select Footer Copyright option', 'mountaviary'),
        'type'     => 'select',
        'section'  => 'mountaviary_footer_area',
        'settings' => 'mountaviary_footer_selection',
    ));
}

add_action( 'customize_register', 'mountaviary_customizer_register' );


/*
* Register Menus
*/

if ( ! function_exists( 'mountaviary_register_nav_menu' ) ) {

	function mountaviary_register_nav_menu(){
		register_nav_menus( array(
	    	'screen_menu' => __( 'Screen Menu', 'mountaviary' ),
	    	'footer_menu'  => __( 'Footer Menu', 'mountaviary' ),
		) );
	}
	add_action( 'after_setup_theme', 'mountaviary_register_nav_menu', 0 );
}

// adding nav menu li class

function nav_menu_list_class($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'nav_menu_list_class', 1, 3);

// Adding nav menu anchor (a) class

function nav_menu_anchor_class($atts, $item, $args) {
    if(isset($args->nav_anchor_class)) {
        $atts['class'] = $args->nav_anchor_class;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'nav_menu_anchor_class', 1, 3);


// walker nav menu description 

function mountaviary_nav_description( $item_output, $item, $depth, $args ) {
    if ( !empty( $item->description ) ) {
        $item_output = str_replace( $args->link_after . '</a>', '<span class="font-sm text-slate-500 ml-2 lowercase block">' . $item->description . '</span>' . $args->link_after . '</a>', $item_output );
    }
 
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'mountaviary_nav_description', 10, 4 );

// excerpt length
function mpuntaviary_excerpt_length( $length ) {
    return 15;
}
add_filter( 'excerpt_length', 'mpuntaviary_excerpt_length');

// Post Excerpt Support 
function mountaviary_post_excerpt() {
    global $post;
    return '<a class="block mt-4 text-slate-700 hover:text-slate-900 duration-75" href="'. get_permalink($post->ID). ' ">' . 'Read More...' . '</a>';
}
add_filter( 'excerpt_more', 'mountaviary_post_excerpt' );