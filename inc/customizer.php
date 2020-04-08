<?php
/**
 * ekiline Theme Customizer.
 *
 * @package ekiline
 */

// Reemplazar la funcion de customizar fondo.
// https://developer.wordpress.org/reference/functions/add_theme_support/
// add_action( 'after_setup_theme', 'ekiline_remove_custom_background', 20 );
// function ekiline_remove_custom_background(){
	 // remove_theme_support( 'custom-background' ); 
// } 
 
/** 
 *  Los controladores del personalizador
 *  https://codex.wordpress.org/Theme_Customization_API
 *  https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data
 *  https://codex.wordpress.org/Data_Validation
 *  https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php
 **/

function ekiline_theme_customizer( $wp_customize ) {

// Identidad, logo en navbar
    $wp_customize->add_setting( 
        'ekiline_logo_max', array(
                'default' => '',
                'sanitize_callback' => 'absint'
        ) 
    );
    
// Logo personalizado
// https://developer.wordpress.org/reference/classes/WP_Customize_Cropped_Image_Control/	
	$wp_customize->add_control( 
		new WP_Customize_Cropped_Image_Control(
			$wp_customize, 'ekiline_logo_max', 
				array(
				    'label'         => __( 'Navbar brand', 'ekiline' ),
				    'description' => __( 'Show logo on menu (suggest 200x50px)', 'ekiline' ),
				    'section'       => 'title_tagline',
				    'settings' 		=> 'ekiline_logo_max',
				    'priority'      => 100,
				    'height'        => 50,
				    'width'         => 200,
				    'flex_height'   => true,
				    'flex_width'    => true,
				    'button_labels' => array(
				        'select'       => __( 'Select logo', 'ekiline' ),
				        'change'       => __( 'Change logo', 'ekiline' ),
				        'remove'       => __( 'Remove', 'ekiline' ),
				        'default'      => __( 'Default', 'ekiline' ),
				        'placeholder'  => __( 'No logo selected', 'ekiline' ),
				        'frame_title'  => __( 'Select logo', 'ekiline' ),
				        'frame_button' => __( 'Choose logo', 'ekiline' )
				    ),
				) 
		) 
	);	
	
// Usar favicon como identidad responsiva 
    $wp_customize->add_setting( 
        'ekiline_minilogo', array(
    				'default' => '',
    				'sanitize_callback' => 'ekiline_sanitize_checkbox'
        )
    );
    
    $wp_customize->add_control(
    	'ekiline_showFrontPageHeading', array(
    				'label'          => __( 'Use site icon as responsive navbar brand', 'ekiline' ),
    				'section'        => 'title_tagline',
    				'settings'       => 'ekiline_minilogo',
    				'type'           => 'checkbox',
	                'priority' 		 => 100
        )
    ); 
	
// Comportamientos Primary Menu
    $wp_customize->add_setting(
        'ekiline_primarymenuSettings', array(
                'default' => '0',
                'sanitize_callback' => 'ekiline_sanitize_select'
            ) 
    );
    
    $wp_customize->add_control(
        'ekiline_primarymenuSettings', array(
            'type' => 'select',
            'label' => __( 'Primary menu settings', 'ekiline' ),
            'description' => __( 'Add behaviors for this menu, fix to top, fix to bottom or fixed with scroll', 'ekiline' ),
            'section' => 'menu_locations',
            'priority'    => 100,
            'choices' => array(
                '0' => __( 'Default', 'ekiline' ),
                '1' => __( 'Fixed top', 'ekiline' ),
                '2' => __( 'Fixed bottom', 'ekiline' ),
                '3' => __( 'Fix to scroll', 'ekiline' ),
            ),
        )
    );    
	
    $wp_customize->add_setting(
        'ekiline_primarymenuStyles', array(
                'default' => '0',
                'sanitize_callback' => 'ekiline_sanitize_select'
            ) 
    );

    $wp_customize->add_control(
        'ekiline_primarymenuStyles', array(
            'type' => 'select',
        	'section' => 'menu_locations',
        	'priority'    => 100,
        	'choices' => array(
                '0' => __( 'Default', 'ekiline' ),
            	'1' => __( 'Right', 'ekiline' ),
                '2' => __( 'Centered', 'ekiline' ),
            	'3' => __( 'Centered between', 'ekiline' ),
            	'4' => __( 'Centered around', 'ekiline' ),
            	'5' => __( 'Offcanvas (responsive)', 'ekiline' ),
            	'6' => __( 'Top toggle', 'ekiline' ),
                '7' => __( 'Modal', 'ekiline' ),
                '8' => __( 'Modal from bottom', 'ekiline' ),
            	'9' => __( 'Modal from left', 'ekiline' ),
            	'10' => __( 'Modal from right', 'ekiline' ),
            ),
        )
    );  		       
	
// Colores, reemplazar el controlador de color de fondo.
    $wp_customize->remove_control('background_color');	// se remueve el controlador.

    // Colores, agregar un panel con subsecciones: https://developer.wordpress.org/themes/customize-api/customizer-objects/
    $wp_customize->add_panel(
        'ekiline_ThemeColors', array(
            'title' => __( 'Colors', 'ekiline' ),
            'description' => __( 'Customize the Bootstrap color palette and use the CSS classes set in your design. Or adjust the colors per item.', 'ekiline' ),
            'priority' => 30,
        ) 
    );

    $wp_customize->add_section(
        'colors' , array(
            'title' => __( 'Customize the Bootstrap color palette', 'ekiline' ),
            'panel' => 'ekiline_ThemeColors',
        ) 
    );

    $wp_customize->add_section(
        'colors_extended' , array(
            'title' => __( 'Customize colors per item', 'ekiline' ),
            'panel' => 'ekiline_ThemeColors',
        ) 
    );

    
// Colores base
    $colors = array();
    //pagina
    $colors[] = array( 'slug'=>'back_color', 'default' => '#ffffff', 'label' => __( 'Background color and text', 'ekiline' ), 'description' => '', 'priority' => 20, 'section'=>'colors_extended' );
    $colors[] = array( 'slug'=>'text_color', 'default' => '#333333', 'label' => '', 'description' => '', 'priority' => 20, 'section'=>'colors_extended' );
    // contenedor main
    $colors[] = array( 'slug'=>'main_color', 'default' => '#f8f9fa', 'label' => '', 'description' => __( 'Color on main container', 'ekiline' ), 'priority' => 20, 'section'=>'colors_extended' );
    //navbar
    $colors[] = array( 'slug'=>'menu_color', 'default' => '#343a40', 'label' => __( 'Navbar background', 'ekiline' ), 'description' => '', 'priority' => 30, 'section'=>'colors_extended' );
    //footer-bar
    $colors[] = array( 'slug'=>'fbar_color', 'default' => '#6c757d', 'label' => __( 'Bottom bar', 'ekiline' ), 'description' => '', 'priority' => 40, 'section'=>'colors_extended' );
    $colors[] = array( 'slug'=>'fbartxt_color', 'default' => '#ffffff', 'label' => '', 'description' => '', 'priority' => 40, 'section'=>'colors_extended' );
    $colors[] = array( 'slug'=>'fbarlks_color', 'default' => '#007bff', 'label' => '', 'description' => '', 'priority' => 40, 'section'=>'colors_extended' );
    //footer
    $colors[] = array( 'slug'=>'footer_color', 'default' => '#343a40', 'label' => __( 'Footer', 'ekiline' ), 'description' => '', 'priority' => 40, 'section'=>'colors_extended' );
    $colors[] = array( 'slug'=>'ftext_color', 'default' => '#ffffff', 'label' => '', 'description' => '', 'priority' => 40, 'section'=>'colors_extended' );
    $colors[] = array( 'slug'=>'flinks_color', 'default' => '#007bff', 'label' => '', 'description' => '', 'priority' => 40, 'section'=>'colors_extended' );
    //bootstrap
    $colors[] = array( 'slug'=>'b4_primary', 'default' => '#007bff', 'label' => '', 'description' => __( 'Change Bootstrap color palette and use default classes', 'ekiline' ) . __('<br><code style="float: right;margin: 6px 4px 0px 0px;width: 90px;">*-primary</code>','ekiline'), 'priority' => 10, 'section'=>'colors' );
    $colors[] = array( 'slug'=>'b4_secondary', 'default' => '#6c757d', 'label' => '', 'description' => __('<code style="float: right;margin: 6px 4px 0px 0px;width: 90px;">*-secondary</code>', 'ekiline'), 'priority' => 10, 'section'=>'colors' );
    $colors[] = array( 'slug'=>'b4_success', 'default' => '#28a745', 'label' => '', 'description' => __('<code style="float: right;margin: 6px 4px 0px 0px;width: 90px;">*-success</code>', 'ekiline'), 'priority' => 10, 'section'=>'colors' );
    $colors[] = array( 'slug'=>'b4_danger', 'default' => '#dc3545', 'label' => '', 'description' => __('<code style="float: right;margin: 6px 4px 0px 0px;width: 90px;">*-danger</code>', 'ekiline'), 'priority' => 10, 'section'=>'colors' );
    $colors[] = array( 'slug'=>'b4_warning', 'default' => '#ffc107', 'label' => '', 'description' => __('<code style="float: right;margin: 6px 4px 0px 0px;width: 90px;">*-warning</code>', 'ekiline'), 'priority' => 10, 'section'=>'colors' );
    $colors[] = array( 'slug'=>'b4_info', 'default' => '#17a2b8', 'label' => '', 'description' => __('<code style="float: right;margin: 6px 4px 0px 0px;width: 90px;">*-info</code>', 'ekiline'), 'priority' => 10, 'section'=>'colors' );
    $colors[] = array( 'slug'=>'b4_light', 'default' => '#f8f9fa', 'label' => '', 'description' => __('<code style="float: right;margin: 6px 4px 0px 0px;width: 90px;">*-light</code>', 'ekiline'), 'priority' => 10, 'section'=>'colors' );
    $colors[] = array( 'slug'=>'b4_dark', 'default' => '#343a40', 'label' => '', 'description' => __('<code style="float: right;margin: 6px 4px 0px 0px;width: 90px;">*-dark</code>', 'ekiline'), 'priority' => 10, 'section'=>'colors' );	

    	
    foreach($colors as $color){
        // add settings
        $wp_customize->add_setting(
        		$color['slug'], array( 
        				'default' => $color['default'], 
        				'type' => 'option', 
        				'capability' => 'edit_theme_options',
        				'sanitize_callback' => 'sanitize_hex_color'
				)
		);

        // add controls
        $wp_customize->add_control(
        		new WP_Customize_Color_Control(
        				$wp_customize, $color['slug'], 
        				array( 'label' => $color['label'], 
                				'description' => $color['description'], 
        						'section' => $color['section'], 
                                'settings' => $color['slug'],
                                'priority' => $color['priority']
						) ) 
		);
    }
    
    // Bootstrap inverse menu
    $wp_customize->add_setting( 
        'ekiline_inversemenu', array(
    				'default' => '',
                    'sanitize_callback' => 'ekiline_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
    	'ekiline_inversemenu', array(
    				'label'          => __( 'Use light navbar', 'ekiline' ),
    				'description'    => '',
    				'section'        => 'colors_extended',
    				'settings'       => 'ekiline_inversemenu',
                    'type'           => 'checkbox',
                    'priority'       => 30,
        )
    );  
    
    // Front page categories		
    $wp_customize->add_setting( 
        'ekiline_featuredcategories', array(
                    'default' => 0,
                    'transport'   => 'refresh',
                    'sanitize_callback' => 'ekiline_sanitize_multipleselect' 
        )
    );

    $wp_customize->add_control(
        new ekiline_controlMultipleSelect (
            $wp_customize, 'ekiline_featuredcategories', array(
                'settings' => 'ekiline_featuredcategories',
                'label'    => __( 'Featured category', 'ekiline' ),
                'section'  => 'static_front_page',
                'type'     => 'multiple-select',
                'choices' => ekiline_list_categories()
            )
        )
    );  

    // Page wide
    $wp_customize->add_section( 
        'ekiline_vista_section' , array(
            'title'       => __( 'Site view', 'ekiline' ),
            'priority'    => 120,
            'description' => __( 'Allow fullwidth of your website by content type: homepage, categories or single content' , 'ekiline' ),
        ) 
    );

    // Layout control and full width    
    $iLayout = array();
        $iLayout[] = array( 'name'=>'Home', 'label' => __( 'Home and blog page', 'ekiline' ) );
        $iLayout[] = array( 'name'=>'Archive', 'label' => __( 'Categories and archive pages', 'ekiline' ) );
        $iLayout[] = array( 'name'=>'Single', 'label' => __( 'Entries and single pages', 'ekiline' ) );

        foreach($iLayout as $value) {

            $wp_customize->add_setting(
                'ekiline_disableSb' . $value['name'], array(
                        'default' => '0',
                        'sanitize_callback' => 'ekiline_sanitize_select'
                    ) 
            );

            $wp_customize->add_control(
                'ekiline_disableSb' . $value['name'], array(
                    'type' => 'select',
                    'label' => $value['label'],
                    'section' => 'ekiline_vista_section',
                    'choices' => array(
                        '0' => __( 'Enabled sidebars', 'ekiline' ),
                        '1' => __( 'Disable left', 'ekiline' ),
                        '2' => __( 'Disable right', 'ekiline' ),
                        '3' => __( 'Disable both', 'ekiline' ),   
                    ),
                )
            );   
            
            $wp_customize->add_setting(
                'ekiline_ancho' . $value['name'], array(
                        'default' => '',
                        'sanitize_callback' => 'ekiline_sanitize_checkbox'
                    ) 
                );
            
            $wp_customize->add_control(
                'ekiline_ancho' . $value['name'], array(
                    'type' => 'checkbox',
                    'label' => __( 'Show full width layout', 'ekiline' ),
                    'section' => 'ekiline_vista_section',
                )
            );   

        } 
    
    // List grid items
    
    $wp_customize->add_setting(
        'ekiline_Columns', array(
                'default' => '0',
                'sanitize_callback' => 'ekiline_sanitize_select'
            ) 
    );
    
    $wp_customize->add_control(
        'ekiline_Columns', array(
            'type' => 'select',
            'label' => __( 'Columns', 'ekiline' ),
            'description' => __( 'Show your lists in columns', 'ekiline' ),
            'section' => 'ekiline_vista_section',
            'choices' => array(
                '0' => __( 'Default', 'ekiline' ),
                '1' => __( '2 columns', 'ekiline' ),
                '2' => __( '3 columns', 'ekiline' ),
                '3' => __( '4 columns', 'ekiline' ),   
                '4' => __( 'Cards grid', 'ekiline' ),   
            ),
        )
    );      
  
}
add_action('customize_register', 'ekiline_theme_customizer');


/* Asegurar la informacion de cada campo antes de ingresa a la BD */

function ekiline_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

function ekiline_sanitize_html( $html ) {
    return wp_filter_post_kses( $html );
}

function ekiline_sanitize_image( $image, $setting ) {

    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );

    $file = wp_check_filetype( $image, $mimes );
    return ( $file['ext'] ? $image : $setting->default );
}

function ekiline_sanitize_video( $video, $setting ) {

    $mimes = array(
        'asf|asx'       => 'video/x-ms-asf',
        'wmv'           => 'video/x-ms-wmv',
        'wmx'           => 'video/x-ms-wmx',
        'wm'            => 'video/x-ms-wm',
        'avi'           => 'video/avi',
        'divx'          => 'video/divx',
        'flv'           => 'video/x-flv',
        'mov|qt'        => 'video/quicktime',
        'mpeg|mpg|mpe'  => 'video/mpeg',
        'mp4|m4v'       => 'video/mp4',
        'ogv'           => 'video/ogg',
        'webm'          => 'video/webm',
        'mkv'           => 'video/x-matroska'
    );

    $file = wp_check_filetype( $video, $mimes );

    return ( $file['ext'] ? $video : $setting->default );
}


function ekiline_sanitize_number_range( $number, $setting ) {    
    $number = absint( $number );
    $atts = $setting->manager->get_control( $setting->id )->input_attrs;
    $min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
    $max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
    $step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
    return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

function ekiline_sanitize_select( $input, $setting ) {
    $input = sanitize_key( $input );
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function ekiline_sanitize_dropdown_pages( $page_id, $setting ) {
  $page_id = absint( $page_id );
  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

/*  Anotaciones  */

    // Guardar informacion en un campo
    // $wp_customize->add_setting( 
    //     'ekiline_themeCssJs', array(
    //         'default' => '',
    //         'capability' => 'edit_theme_options',
    //         'sanitize_callback' => 'wp_strip_all_tags',
    //   ) 
    // );

    // $wp_customize->add_control(
    //         'ekiline_themeCssJs', array(
    //             'type' => 'textarea',
    //             'label' => __( 'CSS de ekiline' ),
    //             'description' => __( 'Los colores se guardarán aqui' ),
    //             'section' => 'colors',
    //             'priority' => 50,
    //     ) 
    // );    