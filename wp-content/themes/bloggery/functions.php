<?php

function bloggery_pattern_styles()
{
	wp_enqueue_style('bloggery-patterns', get_stylesheet_directory_uri() . '/assets/css/patterns.css', array(), filemtime(get_template_directory() . '/assets/css/patterns.css'));
	if (is_admin()) {
		global $pagenow;
		if ('site-editor.php' === $pagenow) {
			// Do not enqueue editor style in site editor
			return;
		}
		wp_enqueue_style('bloggery-editor', get_stylesheet_directory_uri() . '/assets/css/editor.css', array(), filemtime(get_template_directory() . '/assets/css/editor.css'));
	}
}
add_action('enqueue_block_assets', 'bloggery_pattern_styles');


add_theme_support('wp-block-styles');


// Register customer Bloggery pattern categories
function bloggery_register_block_pattern_categories()
{
	register_block_pattern_category(
		'heros',
		array(
			'label'       => __('Heros', 'bloggery'),
			'description' => __('Bloggery hero patterns', 'bloggery'),
		)
	);
	register_block_pattern_category(
		'navigation_headers',
		array(
			'label'       => __('Headers', 'bloggery'),
			'description' => __('Bloggery navigation header patterns', 'bloggery'),
		)
	);
	register_block_pattern_category(
		'teams',
		array(
			'label'       => __('Teams', 'bloggery'),
			'description' => __('Bloggery team patterns', 'bloggery'),
		)
	);
}

add_action('init', 'bloggery_register_block_pattern_categories');
