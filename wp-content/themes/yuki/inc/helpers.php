<?php
/**
 * Yuki Helper Functions
 *
 * @package Yuki
 */

use LottaFramework\Customizer\Controls\Info;

if ( ! function_exists( 'yuki_app' ) ) {
	/**
	 * Get global application
	 *
	 * @param null $abstract
	 * @param array $parameters
	 *
	 * @return \Illuminate\Container\Container|mixed|object
	 */
	function yuki_app( $abstract = null, array $parameters = [] ) {
		return \LottaFramework\Utils::app( $abstract, $parameters );
	}
}

if ( ! function_exists( 'yuki_do_elementor_location' ) ) {
	/**
	 * Do the Elementor location, if it does not exist, display the custom template part.
	 *
	 * @param $elementor_location
	 * @param string $template_part
	 * @param null $name
	 */
	function yuki_do_elementor_location( $elementor_location, $template_part = '', $name = null ) {
		if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( $elementor_location ) ) {
			get_template_part( $template_part, $name );
		}
	}
}

if ( ! function_exists( 'yuki_upsell_info' ) ) {
	/**
	 * @param $info
	 *
	 * @return string
	 */
	function yuki_upsell_info( $info ) {
		if ( yuki_fs()->is_anonymous() ) {
			$upsell_url = admin_url( 'themes.php?page=yuki-pricing' );
		} else {
			$upsell_url = admin_url( 'themes.php?page=yuki' );
		}

		return sprintf(
			$info, '<a href="' . esc_url( $upsell_url ) . '">', '</a>'
		);
	}
}

if ( ! function_exists( 'yuki_upsell_info_control' ) ) {
	/**
	 * @param $info
	 * @param null $id
	 *
	 * @return Info
	 */
	function yuki_upsell_info_control( $info, $id = null ): Info {
		return ( new Info( $id ) )
			->alignCenter()
			->hideBackground()
			->setInfo( yuki_upsell_info( $info ) );
	}
}

if ( ! function_exists( 'yuki_is_woo_shop' ) ) {
	/**
	 * Is products or product detail page
	 *
	 * @return bool
	 */
	function yuki_is_woo_shop() {
		return YUKI_WOOCOMMERCE_ACTIVE && is_woocommerce();
	}
}

if ( ! function_exists( 'yuki_current_loop' ) ) {
	/**
	 * @return string
	 * @since v1.3.15
	 */
	function yuki_current_loop() {
		global $wp_query;
		$loop = 'default';

		if ( $wp_query->is_page ) {
			$loop = is_front_page() ? 'front' : get_post_type();
		} elseif ( $wp_query->is_home ) {
			$loop = 'home';
		} elseif ( $wp_query->is_single ) {
			$loop = ( $wp_query->is_attachment ) ? 'attachment' : get_post_type();
		} elseif ( $wp_query->is_category ) {
			$loop = 'category';
		} elseif ( $wp_query->is_tag ) {
			$loop = 'tag';
		} elseif ( $wp_query->is_tax ) {
			$loop = 'tax';
		} elseif ( $wp_query->is_archive ) {
			if ( $wp_query->is_day ) {
				$loop = 'day';
			} elseif ( $wp_query->is_month ) {
				$loop = 'month';
			} elseif ( $wp_query->is_year ) {
				$loop = 'year';
			} elseif ( $wp_query->is_author ) {
				$loop = 'author';
			} else {
				$loop = 'archive';
			}
		} elseif ( $wp_query->is_search ) {
			$loop = 'search';
		} elseif ( $wp_query->is_404 ) {
			$loop = 'notfound';
		}

		return $loop;
	}
}

if ( ! function_exists( 'yuki_current_option_type' ) ) {
	/**
	 * @return string
	 * @since v1.3.15
	 */
	function yuki_current_option_type() {
		$post_type = 'archive';
		if ( is_page() ) {
			$post_type = 'pages';
		}

		if ( is_single() ) {
			$post_type = 'single_post';
		}

		if ( is_front_page() && ! is_home() ) {
			$post_type = 'homepage';
		}

		if ( yuki_is_woo_shop() ) {
			$post_type = 'store';
		}

		return $post_type;
	}
}

if ( ! function_exists( 'yuki_get_stylesheet_tag' ) ) {
	/**
	 * Get tag with stylesheet prefix
	 *
	 * @param $tag
	 *
	 * @return string
	 * @since v1.3.15
	 */
	function yuki_get_stylesheet_tag( $tag ) {
		return get_stylesheet() . '_' . $tag;
	}
}

if ( ! function_exists( 'yuki_get_option' ) ) {
	/**
	 * @param $option
	 * @param $default_value
	 *
	 * @return false|mixed|null
	 * @since v1.3.15
	 */
	function yuki_get_option( $option, $default_value = false ) {
		return get_option( yuki_get_stylesheet_tag( $option ), $default_value );
	}
}

if ( ! function_exists( 'yuki_update_option' ) ) {
	/**
	 * @param $option
	 * @param $value
	 * @param null $autoload
	 *
	 * @return false|mixed|null
	 * @since v1.3.15
	 */
	function yuki_update_option( $option, $value, $autoload = null ) {
		return update_option( yuki_get_stylesheet_tag( $option ), $value, $autoload = null );
	}
}

if ( ! function_exists( 'yuki_do_action' ) ) {
	/**
	 * @param $hook_name
	 * @param ...$arg
	 *
	 * @return void
	 * @since v1.3.15
	 */
	function yuki_do_action( $hook_name, ...$arg ) {
		do_action( yuki_get_stylesheet_tag( $hook_name ), ...$arg );
	}
}

if ( ! function_exists( 'yuki_add_action' ) ) {
	/**
	 * @param $hook_name
	 * @param $callback
	 * @param $priority
	 * @param $accepted_args
	 *
	 * @return true|null
	 * @since v1.3.15
	 */
	function yuki_add_action( $hook_name, $callback, $priority = 10, $accepted_args = 1 ) {
		return add_action( yuki_get_stylesheet_tag( $hook_name ), $callback, $priority, $accepted_args );
	}
}

if ( ! function_exists( 'yuki_apply_filters' ) ) {
	/**
	 * @param $hook_name
	 * @param $value
	 * @param ...$args
	 *
	 * @return mixed|null
	 * @since v1.3.15
	 */
	function yuki_apply_filters( $hook_name, $value, ...$args ) {
		return apply_filters( yuki_get_stylesheet_tag( $hook_name ), $value, ...$args );
	}
}

if ( ! function_exists( 'yuki_add_filter' ) ) {
	/**
	 * @param $hook_name
	 * @param $callback
	 * @param $priority
	 * @param $accepted_args
	 *
	 * @return true|null
	 * @since v1.3.15
	 */
	function yuki_add_filter( $hook_name, $callback, $priority = 10, $accepted_args = 1 ) {
		return add_filter( yuki_get_stylesheet_tag( $hook_name ), $callback, $priority, $accepted_args );
	}
}

if ( ! function_exists( 'yuki_get_theme_version' ) ) {
	/**
	 * Get current theme version
	 *
	 * @return array|false|string
	 * @since v1.3.15
	 */
	function yuki_get_theme_version() {
		$theme = wp_get_theme();

		return ( $theme->get( 'Version' ) ?: YUKI_VERSION ) . '_' . ( yuki_fs()->can_use_premium_code() ? 'premium' : 'free' );
	}
}
