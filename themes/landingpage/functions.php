<?php

/**
 * Funções e definições do tema LandingPage.
 *
 * @package LandingPage
 */

if (! defined('ABSPATH')) {
	exit;
}


/**
 * Registra e carrega os estilos e scripts.
 */
function landingpage_scripts()
{
	// Bootstrap CSS.
	wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '5.3.3');

	// Estilo do tema.
	wp_enqueue_style('landingpage-style', get_stylesheet_uri(), array('bootstrap-css'), wp_get_theme()->get('Version'));

	// Bootstrap JS.
	wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array(), '5.3.3', true);
}
add_action('wp_enqueue_scripts', 'landingpage_scripts');




if (! function_exists('landingpage_setup')) {
	/**
	 * Configurações básicas do tema.
	 */
	function landingpage_setup()
	{
		//suporte ao gerenciamento automatico da tag title(titulo). Dessa forma o wp gerencia o titulo da página dinamicamente de acordo com a página acessada
		add_theme_support('title-tag');
		//suporte a imagens destacadas
		add_theme_support('post-thumbnails');
		//suporte a marcação HTML5 e os elemento destacados
		add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
		//Registro de menus
		register_nav_menus(
			array(
				'main-menu' => __('Menu Principal', 'landingpage'),
				'footer-menu' => __('Menu Rodape', 'landingpage'),
			)
		);
	}
}
add_action('after_setup_theme', 'landingpage_setup');
