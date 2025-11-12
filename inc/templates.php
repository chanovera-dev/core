<?php
/**
 * Theme Templates and Asset Loader
 *
 * Handles enqueueing of CSS and JS assets for different page templates and conditions.
 * 
 * This file provides helper functions to enqueue styles and scripts with automatic
 * versioning, and selectively loads assets for:
 * - Single posts and pages (including featured images, related posts, and comments)
 * - Post listing pages (home, archives, search)
 * - 404 error page
 * - Front page
 *
 * The goal is to optimize performance by loading only the necessary assets
 * for each page type, reducing unnecessary HTTP requests.
 *
 * @package core
 * @since 1.0.0
 */

/**
 * Helper: Enqueue style file with automatic versioning
 *
 * @param string $handle
 * @param string $path
 * @param string $media
 * @return void
 */
function core_enqueue_style( $handle, $path, $media = 'all' ) {
    $uri = get_template_directory_uri();
    wp_enqueue_style( $handle, $uri . $path, [], get_asset_version( $path ), $media );
}

/**
 * Helper: Enqueue script file with automatic versioning
 *
 * @param string $handle
 * @param string $path
 * @return void
 */
function core_enqueue_script( $handle, $path ) {
    $uri = get_template_directory_uri();
    wp_enqueue_script( $handle, $uri . $path, [], get_asset_version( $path ), true );
}

/**
 * Returns a centralized registry of all theme asset paths.
 *
 * Provides a single source of truth for referencing CSS and JS files used
 * throughout the theme. This ensures consistency, reduces repetition across
 * enqueue functions, and simplifies maintenance when updating asset locations.
 *
 * The returned array is organized into 'css' and 'js' subarrays, where each key
 * corresponds to an asset handle and each value is its relative path from the
 * theme directory.
 *
 * Example:
 * $assets = core_get_assets();
 * wp_enqueue_style( 'frontpage', get_template_directory_uri() . $assets['css']['frontpage'] );
 *
 * @since 1.0.0
 * @package core
 * @return array Associative array of asset paths grouped by type ('css' and 'js').
 */
function core_get_assets() {
    $assets_path = '/assets';

    return [
        'css' => [
            'page'               => "$assets_path/css/page.css",
            'sidebar'            => "$assets_path/css/sidebar.css",
        ],
        'js' => [
            'slideshow-script'   => "$assets_path/js/slideshow.js",
        ]
    ];
}

/**
 * Enqueues styles and scripts for single posts and pages.
 *
 * Loads page-specific assets when viewing single posts or pages.
 * Includes optional styles for featured images, related posts,
 * and comments, as well as JS effects such as parallax and blur typing.
 * Related posts and comment styles are loaded conditionally.
 *
 * @since 2.0.0
 * @return void
 */
function page_template() {
    $assets_path = '/assets';

    if ( is_page() or is_single() ) {
        $a = core_get_assets();

        core_enqueue_style( 'page', $a['css']['page'] );

        if ( is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) ) {
            core_enqueue_style( 'sidebar', $a['css']['sidebar'] );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'page_template' );