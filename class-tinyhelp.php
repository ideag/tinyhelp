<?php
class tinyHelp {
	protected $slug = 'slug';
	protected $modules = array();
	public function __construct( $args ) {
		if ( ! apply_filters( 'tinyhelp_show', true ) ) {
			return false;
		}
		if ( ! apply_filters( "tinyhelp_{$this->slug}_show", true ) ) {
			return false;
		}
		$this->slug = $args['slug'];
		$this->modules = $args['modules'];
		add_action( 'current_screen', array( $this, 'start' ) );
	}
	public function start( $screen ) {
		if ( 'plugin-install' !== $screen->base ) {
			return false;
		} 
		if ( isset( $_GET['paged'] ) && 1 !== $_GET['paged'] ) {
			return false;
		}
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		add_filter( 'plugins_api_result', array( $this, 'inject' ), 10, 3 );
		add_filter( 'self_admin_url', array( $this, 'details' ) );
		add_filter( 'plugin_install_action_links', array( $this, 'links' ), 10, 2 );
	}
	public function assets() {}
	public function inject( $result, $action, $args ) {
		if ( ! property_exists( $args, 'search' ) ) {
			return $result;
		}
		$modules = $this->filter( $this->modules, $args->search );
		foreach ( $modules as $module => $data ) {
			$inject = $this->prepare( $module );
			array_unshift( $result->plugins, $inject );			
		}
		return $result;
	}
	public function details( $link ) {
		foreach ( $this->modules as $module => $data ) {
			$link = str_replace( "plugin={$module}", "plugin={$this->slug}&module={$module}", $link );
		}
		return $link;
	}
	public function links( $links, $plugin ) {
		if ( ! isset( $plugin['tinyhelp'] ) || ! $plugin['tinyhelp'] ) {
			return $links;
		}
		if ( ! in_array( $plugin['slug'], array_keys( $this->modules ), true ) ) {
			return $links;
		}

		remove_filter( 'self_admin_url', array( $this, 'details' ) );
		
		$links = array();
		foreach ( $this->modules[ $plugin['slug'] ]['links'] as $link ) {
			$attributes = $link['attributes'];
			$attributes['href'] = $link['link'];
			$attributes['class'] = 'tinyhelp-action-link';
			if ( 'button' === $link['type'] ) {
				$attributes['class'] .= ' button';
			}
			foreach ( $attributes as $key => $value ) {
				$attributes[ $key] = $key . '="' . esc_attr( $value ) . '"';
			}
			$attributes = implode( ' ', $attributes );
			$links[] = '<a ' . $attributes . '>' . esc_html( $link['title'] ). '</a>'; 
		}		
		return $links;
	}
	protected function filter( $modules, $search ) {
		foreach ( $modules as $key => $item ) {
			$match = false;
			foreach ( $item['search_terms'] as $term ) {
				$term = "/{$term}/ims";
				if ( 1 === preg_match( $term, $search ) ) {
					$match = true;
				}
			}
			if ( ! $match ) {
				unset( $modules[ $key ] );
			}
		}
		return $modules;
	}
	protected function prepare( $module ) {
		if ( ! isset( $this->modules[ $module ] ) ) {
			return false;
		}
		$inject = $this->modules[ $module ];
		$defaults = array();
		$defaults['tinyhelp'] = true;
		$defaults['slug'] = $module;
		$defaults['num_ratings'] = 0;
		$defaults['rating'] = 0;
		$defaults['last_updated'] = 0;
		$defaults['active_installs'] = 0;
		$defaults['author'] = "<a href='{$inject['author_uri']}' target='_blank'>{$inject['author_name']}</a>";
		$inject = wp_parse_args( $inject, $defaults );
		
		unset( $inject['search_terms'] );
		unset( $inject['author_uri'] );
		unset( $inject['author_name'] );
		return $inject;
	}
}
