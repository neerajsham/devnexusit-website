<?php
/**
 * Theme Options.
 *
 * @package surface_blog
 */

// Add Panel.
$wp_customize->add_panel( 'theme_option_panel',
	array(
	'title'      => __( 'Theme Options', 'surface-blog' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	)
);

// Feature post one section
$wp_customize->add_section('featured_posts_section', array(    
	'title'       => __('Featured Posts Section', 'surface-blog'),
	'panel'       => 'theme_option_panel'    
));

$wp_customize->add_setting('featured_posts', 
	array(
		'default' 			=> true,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'surface_blog_sanitize_checkbox',
		'transport'         => 'refresh',
	)
);

$wp_customize->add_control('featured_posts', 
	array(		
		'label' 	=> __('Enable Featured Posts', 'surface-blog'),
		'section' 	=> 'featured_posts_section',
		'settings'  => 'featured_posts',
		'type' 		=> 'checkbox',
	)
);

$wp_customize->add_setting('featured_posts_category', 
	array(
		'default' 			=> '',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'surface_blog_sanitize_select',
		'transport'         => 'refresh',
	)
);

$wp_customize->add_control('featured_posts_category', 
	array(		
		'label' 	=> __('Select Categories', 'surface-blog'),
		'section' 	=> 'featured_posts_section',
		'settings'  => 'featured_posts_category',
		'type' 		=> 'select',
		'choices' 	=> surface_blog_get_post_categories(),
	)
);

// Popular Post section
$wp_customize->add_section('popular_posts_section', array(    
	'title'       => __('Popular Posts Section', 'surface-blog'),
	'panel'       => 'theme_option_panel'    
));

$wp_customize->add_setting('popular_posts', 
	array(
		'default' 			=> true,
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'surface_blog_sanitize_checkbox',
		'transport'         => 'refresh',
	)
);

$wp_customize->add_control('popular_posts', 
	array(		
		'label' 	=> __('Enable Popular Posts', 'surface-blog'),
		'section' 	=> 'popular_posts_section',
		'settings'  => 'popular_posts',
		'type' 		=> 'checkbox',
	)
);

$wp_customize->add_setting('popular_posts_section_title', 
	array(
		'default'           => 'Popular Posts',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('popular_posts_section_title', 
	array(
		'label'       => __('Section Title', 'surface-blog'),
		'section'     => 'popular_posts_section',   
		'settings'    => 'popular_posts_section_title',	
		'type'        => 'text'
	)
);

$wp_customize->add_setting('number_of_popular_posts_items', 
	array(
	'default' 			=> 3,
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'surface_blog_sanitize_number_range'
	)
);

$wp_customize->add_control('number_of_popular_posts_items', 
	array(
	'label'       => __('Number of Items (Max: 50)', 'surface-blog'),
	'section'     => 'popular_posts_section',   
	'settings'    => 'number_of_popular_posts_items',		
	'type'        => 'number',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 50,
			'step'	=> 1,
		),
	)
);

$wp_customize->add_setting('popular_posts_category', 
	array(
		'default' 			=> '',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'surface_blog_sanitize_select',
		'transport'         => 'refresh',
	)
);

$wp_customize->add_control('popular_posts_category', 
	array(		
		'label' 	=> __('Select Categories', 'surface-blog'),
		'section' 	=> 'popular_posts_section',
		'settings'  => 'popular_posts_category',
		'type' 		=> 'select',
		'choices' 	=> surface_blog_get_post_categories(),
	)
);

// Sidebar section
$wp_customize->add_section('section_sidebar', array(    
	'title'       => __('Sidebar Options', 'surface-blog'),
	'panel'       => 'theme_option_panel'    
));

// Blog Sidebar Option
$wp_customize->add_setting('blog_sidebar', 
	array(
	'default' 			=> 'right-sidebar',
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'surface_blog_sanitize_select',
	'transport'         => 'refresh',
	)
);

$wp_customize->add_control('blog_sidebar', 
	array(		
	'label' 	=> __('Blog Sidebar', 'surface-blog'),
	'section' 	=> 'section_sidebar',
	'settings'  => 'blog_sidebar',
	'type' 		=> 'radio',
	'choices' 	=> array(		
		'left-sidebar' 	=> __( 'Left Sidebar', 'surface-blog'),						
		'right-sidebar' => __( 'Right Sidebar', 'surface-blog'),	
		'no-sidebar' 	=> __( 'No Sidebar', 'surface-blog'),	
		),	
	)
);

// Single Post Sidebar Option
$wp_customize->add_setting('single_post_sidebar', 
	array(
	'default' 			=> 'right-sidebar',
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'surface_blog_sanitize_select',
	'transport'         => 'refresh',
	)
);

$wp_customize->add_control('single_post_sidebar', 
	array(		
	'label' 	=> __('Single Post Sidebar', 'surface-blog'),
	'section' 	=> 'section_sidebar',
	'settings'  => 'single_post_sidebar',
	'type' 		=> 'radio',
	'choices' 	=> array(		
		'left-sidebar' 	=> __( 'Left Sidebar', 'surface-blog'),						
		'right-sidebar' => __( 'Right Sidebar', 'surface-blog'),	
		'no-sidebar' 	=> __( 'No Sidebar', 'surface-blog'),	
		),	
	)
);

// Archive Sidebar Option
$wp_customize->add_setting('archive_sidebar', 
	array(
	'default' 			=> 'right-sidebar',
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'surface_blog_sanitize_select',
	'transport'         => 'refresh',
	)
);

$wp_customize->add_control('archive_sidebar', 
	array(		
	'label' 	=> __('Archive Sidebar', 'surface-blog'),
	'section' 	=> 'section_sidebar',
	'settings'  => 'archive_sidebar',
	'type' 		=> 'radio',
	'choices' 	=> array(		
		'left-sidebar' 	=> __( 'Left Sidebar', 'surface-blog'),						
		'right-sidebar' => __( 'Right Sidebar', 'surface-blog'),	
		'no-sidebar' 	=> __( 'No Sidebar', 'surface-blog'),	
		),	
	)
);

// Page Sidebar Option
$wp_customize->add_setting('page_sidebar', 
	array(
	'default' 			=> 'no-sidebar',
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'surface_blog_sanitize_select',
	'transport'         => 'refresh',
	)
);

$wp_customize->add_control('page_sidebar', 
	array(		
	'label' 	=> __('Page Sidebar', 'surface-blog'),
	'section' 	=> 'section_sidebar',
	'settings'  => 'page_sidebar',
	'type' 		=> 'radio',
	'choices' 	=> array(		
		'left-sidebar' 	=> __( 'Left Sidebar', 'surface-blog'),						
		'right-sidebar' => __( 'Right Sidebar', 'surface-blog'),	
		'no-sidebar' 	=> __( 'No Sidebar', 'surface-blog'),	
		),	
	)
);

// Excerpt Length
$wp_customize->add_section('section_excerpt_length', 
	array(    
	'title'       => __('Excerpt Length', 'surface-blog'),
	'panel'       => 'theme_option_panel'    
	)
);

$wp_customize->add_setting( 'excerpt_length', array(
	'default'           => '12',
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'surface_blog_sanitize_number_range',
	'transport'         => 'refresh',
) );

$wp_customize->add_control( 'excerpt_length', array(
	'label'       => __( 'Excerpt Length', 'surface-blog' ),
	'description' => __( 'Note: Min 5 & Max 100.', 'surface-blog' ),
	'section'     => 'section_excerpt_length',
	'type'        => 'number',
	'input_attrs' => array( 'min' => 5, 'max' => 100, 'style' => 'width: 55px;' ),
) );

// Read More
$wp_customize->add_section('section_read_more', 
	array(    
	'title'       => __('Read More', 'surface-blog'),
	'panel'       => 'theme_option_panel'    
	)
);

$wp_customize->add_setting( 'read_more_label', array(
	'default'           => esc_html__('Read More', 'surface-blog'),
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	'transport'         => 'refresh',
) );

$wp_customize->add_control( 'read_more_label', array(
	'label'       => __( 'Read More Label', 'surface-blog' ),
	'section'     => 'section_read_more',
	'type'        => 'text',
) );