<?php
/**
 * @package tinyHelp
 * @version 1.0.0
 */
/*
Plugin Name: tinyHelp
Description: A sample plugin to display usage of tinyHelp library
Author: Arūnas Liuiza
Version: 1.0.0
Author URI: httpa://arunas.co
*/

$args = array(
	'slug' => 'hello-dolly',
	'modules' => array(
		'test' => array(
			'name' => __( 'Test Module', 'tinyhelp' ),
			'short_description' => __( 'Short description for this injected module goes here', 'tinyhelp' ),
			'version' => '0.1.0',
			'author_name' => __( 'Arūnas', 'tinyhelp' ),
			'author_uri' => 'https://arunas.co',
			'search_terms' => array( 'test.*' ),
			'icons' => array(
				'1x'  => 'https://placeholder.pics/png/128',
				'2z'  => 'https://placeholder.pics/png/256',
				'svg' => 'https://placeholder.pics/svg/300',
				// '1x'  => plugins_url( "icon-128.png", __FILE__ ),
				// '2x'  => plugins_url( "icon-256.png", __FILE__ ),
				// 'svg' => plugins_url( "icon-256.svg", __FILE__ ),
			),
			'links' => array(
				array(
					'type' => 'button',
					'title' => __( 'Get started', 'tinyhelp' ),
					'link' => 'https://google.com',
					'attributes' => array(
						'target' => '_blank',
					),
				),
				array(
					'type' => 'link',
					'title' => __( 'Learn More', 'tinyhelp' ),
					'link' => 'https://google.com',
					'attributes' => array(
						'target' => '_blank',
					),
				),
			),
		),
		'test2' => array(
			'name' => __( 'Test Module 2', 'tinyhelp' ),
			'short_description' => __( 'Short description for this injected module goes here', 'tinyhelp' ),
			'version' => '0.1.0',
			'author_name' => __( 'Arūnas', 'tinyhelp' ),
			'author_uri' => 'https://arunas.co',
			'search_terms' => array( 'testing', 'beta' ),
			'icons' => array(
				'1x'  => 'https://placeholder.pics/png/128',
				'2z'  => 'https://placeholder.pics/png/256',
				'svg' => 'https://placeholder.pics/svg/300',
				// '1x'  => plugins_url( "icon-128.png", __FILE__ ),
				// '2x'  => plugins_url( "icon-256.png", __FILE__ ),
				// 'svg' => plugins_url( "icon-256.svg", __FILE__ ),
			),
			'links' => array(
				array(
					'type' => 'button',
					'title' => __( 'Get started', 'tinyhelp' ),
					'link' => 'https://google.com',
					'attributes' => array(
						'target' => '_blank',
					),
				),
			),
		),
	),
);

require_once( __DIR__ . '/class-tinyhelp.php' );
$th = new tinyHelp( $args );
