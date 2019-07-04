<?php
/**
 * HH-Prog Theme Customizer
 *
 * @package HH-Prog
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function hh_prog_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'hh_prog_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'hh_prog_customize_partial_blogdescription',
		) );
	}


	/* МОЙ ПРИМЕР РАБОТЫ С КАСТОМАЙЗЕРОМ */
	// Добавляю секцию в кастомайзер
	$wp_customize->add_section('vk_api_items', array(
			'title'     	=> 'VK API',
			'description' 	=> 'Настройки отображения фотографий, полученных из VK',
			'priority'  	=> 201 
		)
	);
 
	// Текст заголовка
	$wp_customize->add_setting('vk_api_header', array(
			'default'      => 'Мои фото из VK',
		)
	);

	$wp_customize->add_control('vk_api_header', array(
			'label'    => 'Заголовок блока с фотографиями',
			'settings' => 'vk_api_header',
			'section'  => 'vk_api_items',
		)
	);

	// Отображать или нет описание к фотографиям
	$wp_customize->add_setting('vk_api_items_description', array(
			'default'      => true,
			'transport'    => $true_transport
		)
	);

	$wp_customize->add_control('vk_api_items_description', array(
			'label'    => 'Отображение описания фотографий',
			'settings' => 'vk_api_items_description',
			'section'  => 'vk_api_items',
			'type'     => 'checkbox'
		)
	);

	
	// Отступы между фотографиями
	$wp_customize->add_setting('vk_api_items_margins', array(
			'default'      => false,
		)
	);

	$wp_customize->add_control('vk_api_items_margins', array(
			'label'    => 'Добавить отступы между фотографиями',
			'settings' => 'vk_api_items_margins',
			'section'  => 'vk_api_items',
			'type'     => 'checkbox'
		)
	);



}
add_action( 'customize_register', 'hh_prog_customize_register' );

function hh_prog_customizer_css() { 
	echo '<style>';

		// Отображать или нет описание к фотографиям
		if ( false === get_theme_mod( 'vk_api_items_description' ) ) {
			echo '.vk-api__photo-desc { 
				display: none; 
			}'; 
		}

		// Добавить отступы к фотографиям
		if ( true === get_theme_mod( 'vk_api_items_margins' ) ) {
			echo '
				.vk-api__photo-block {
					margin-right: 0;
				}
				.vk-api__photo-item {
					-webkit-box-flex: 0;
					-webkit-flex: 0 1 25%;
					-ms-flex: 0 1 25%;
					flex: 0 1 25%;
					margin-right: 0%;
					margin-bottom: 0%;
				}
				@media (max-width: 991px) and (min-width: 768px) {
					.vk-api__photo-item {
						-webkit-box-flex: 0;
						-webkit-flex: 0 1 33.33%;
						-ms-flex: 0 1 33.33%;
						flex: 0 1 33.33%;
					}
				}
				@media (max-width: 767px) and (min-width: 576px) {
					.vk-api__photo-item {
						-webkit-box-flex: 0;
						-webkit-flex: 0 1 50%;
						-ms-flex: 0 1 50%;
						flex: 0 1 50%;
					}
				}
				@media (max-width: 575px) {
					.vk-api__photo-item {
						-webkit-box-flex: 0;
						-webkit-flex: 0 1 100%;
						-ms-flex: 0 1 100%;
						flex: 0 1 100%;
						margin-right: 0;
						margin-bottom: 0;
					}
				}

			'; 
		}

	echo '</style>';

}
add_action( 'wp_head', 'hh_prog_customizer_css' );



/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function hh_prog_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function hh_prog_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function hh_prog_customize_preview_js() {
	wp_enqueue_script( 'hh-prog-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'hh_prog_customize_preview_js' );
