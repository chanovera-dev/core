<?php
/**
 * Core Theme Setup and Asset Loading
 *
 * Handles theme initialization, feature registration, and asset management:
 * - Navigation menus registration
 * - WordPress core features support
 * - Asset loading with cache busting
 *
 * Sets up theme defaults and registers support for various WordPress features
 * 
 * @package core
 * @since 2.0.0
 */

function setup_core() {

    /**
     * Register menus
     */
    register_nav_menus(
        array(
            'primary' => __( 'Main Menu', 'core' ),
            'social'  => __( 'Social Menu', 'core' ),
            'footer-1'   => __( 'Footer 1', 'core' ),
            'footer-2'   => __( 'Footer 2', 'core' ),
            'footer-3'   => __( 'Footer 3', 'core' ),
        )
    );

    /**
     * Add theme support
     */
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'custom-logo',
        array(
            'height'      => 32,
            'width'       => 172,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );

    add_theme_support( 'html5',
        apply_filters(
            'chanovera_html5_args',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'widgets',
                'style',
                'script',
            )
        )
    );

    add_theme_support( 'post-formats',
        array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'audio',
            'chat',
        )
    );

    add_theme_support( 'customize-selective-refresh-widgets' );

    add_theme_support( 'post-thumbnails', [ 'post', 'page' ] );
    set_post_thumbnail_size( 350, 200, true );

    add_image_size( 'loop-thumbnail', 300, 200, true );

    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    
}
add_action( 'after_setup_theme', 'setup_core' );

/**
 * Get an asset version for cache busting.
 *
 * Returns the file modification timestamp for the given asset (relative to the
 * theme root) so it can be used as a version string when enqueueing styles or
 * scripts. If the file does not exist the current time is returned to force
 * a cache refresh.
 *
 * Example: wp_enqueue_style( 'theme-style', get_stylesheet_uri(), array(),
 *     get_asset_version( '/style.css' ) );
 *
 * @param string $file_path Path to the asset file relative to the theme root (e.g. '/style.css').
 * @return int Unix timestamp to use as a cache-busting version.
 */
function get_asset_version( $file_path ) {
    $full_path = get_template_directory() . $file_path;

    return file_exists( $full_path ) ? filemtime( $full_path ) : time();
}

/**
 * Enqueues header styles with cache busting
 * 
 * Loads global stylesheet and form-specific styles in the header
 * with automatic versioning based on file modification time.
 */
function load_parts_header() {
    
    wp_register_style( 'global', get_template_directory_uri() . '/style.css', array(), get_asset_version('/style.css'), 'all' ); 
    wp_enqueue_style( 'global' );
     
}
add_action( 'wp_enqueue_scripts', 'load_parts_header' );

/**
 * Enqueues theme assets conditionally.
 *
 * Loads:
 * - WP root styles for all users (assets/css/wp-root.css)
 * - Form styles (assets/css/forms.css)
 * - Global JavaScript (assets/js/global.js) deferred to the footer
 * - Animate-in JavaScript (assets/js/animate-in.js) deferred to the footer
 * - Admin styles for logged-in users (assets/css/wp-logged-in.css)
 */
function footer_components() {
    $directory = get_template_directory();
    $uri = get_template_directory_uri();
        $assets_path = '/assets';

    $enqueue_style = function ( $handle, $path, $media = 'all' ) use ( $uri ) {
        wp_enqueue_style($handle, $uri . $path, [], get_asset_version( $path ), $media);
    };
    $enqueue_script = function ( $handle, $path ) use ( $uri ) {
        wp_enqueue_script($handle, $uri . $path, [], get_asset_version( $path ), true);
    };

    file_exists( $directory . "$assets_path/css/wp-root.css" ) ? $enqueue_style( 'wp-root', "$assets_path/css/wp-root.css" ) : null;
    file_exists( $directory . "$assets_path/css/forms.css" ) ? $enqueue_style( 'custom-forms', "$assets_path/css/forms.css" ) : null;
    file_exists( $directory . "$assets_path/css/shapes.css" ) ? $enqueue_style( 'shapes', "$assets_path/css/shapes.css" ) : null;
    file_exists( $directory . "$assets_path/js/global.js" ) ? $enqueue_script( 'global-scripts', "$assets_path/js/global.js" ) : null;
     
    if ( is_user_logged_in() ) {
        file_exists( $directory . "$assets_path/css/wp-logged-in.css" ) ? $enqueue_style( 'wp-logged-in', "$assets_path/css/wp-logged-in.css" ) : null;
    }
}
add_action( 'wp_enqueue_scripts', 'footer_components' );

/**
 * Register widgets areas
 */
function widgets_areas() {

    register_sidebar(
        array(
            'name'          => __( 'Posts sidebar', 'core' ),
            'id'            => 'sidebar-1',
            'before_widget' => '',
            'after_widget'  => '',
        )
    );

    register_sidebar(
        array(
            'name'          => __( 'Post sidebar', 'core' ),
            'id'            => 'sidebar-2',
            'before_widget' => '',
            'after_widget'  => '',
        )
    );

    register_sidebar(
        array(
            'name'          => __( 'Page sidebar', 'core' ),
            'id'            => 'sidebar-3',
            'before_widget' => '',
            'after_widget'  => '',
        )
    );

}
add_action( 'widgets_init', 'widgets_areas' );

/**
 * Breadcrumbs
 */
function wp_breadcrumbs() {
    $separator = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/></svg>';
    $icon_home = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.76c0-1.358 0-2.037.274-2.634c.275-.597.79-1.038 1.821-1.922l1-.857C9.96 5.75 10.89 4.95 12 4.95s2.041.799 3.905 2.396l1 .857c1.03.884 1.546 1.325 1.82 1.922c.275.597.275 1.276.275 2.634V17c0 1.886 0 2.828-.586 3.414S16.886 21 15 21H9c-1.886 0-2.828 0-3.414-.586S5 18.886 5 17z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14.5 21v-5a1 1 0 0 0-1-1h-3a1 1 0 0 0-1 1v5"/></g></svg>';
    $home = 'Inicio';
    $showCurrent = 1;
    $showOnHome = 0;
    $current = '';
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    global $post;
    $homeLink = get_bloginfo('url');
    echo '<section class="block breadcrumbs--wrapper"><div class="content"><div class="breadcrumbs">';
    echo '<a class="go-home" href="' . $homeLink . '">' . $icon_home . $home . '</a>' . $separator;

    if (is_category()) {
        if ($paged === 1) {
            echo 'Últimos artículos de la'; the_archive_title( '<h1 class="page-title">', '</h1>' );
        } else {
            echo esc_html('Página ' . $paged . ' de '); the_archive_title('<h1 class="page-title">', '</h1>');
        } 
    }
     elseif ( is_archive() ) {
        if ($paged === 1) {
            echo 'Últimos artículos de la'; the_archive_title( '<h1 class="page-title">', '</h1>' );
        } else {
            echo esc_html('Página ' . $paged . ' de '); the_archive_title('<h1 class="page-title">', '</h1>');
        } 
    } elseif (is_home()) {
        if ($paged === 1) {
            echo '<h1 class="page-title">' . esc_html_e( 'Últimos artículos', 'stories' ) . '</h1>';
        } else {
            echo esc_html('Página ' . $paged . ' de ') . '<h1 class="page-title">todos los artículos</h1>';
        }
    } elseif (is_page()) {
        if ($post->post_parent) {
            $ancestors = get_post_ancestors($post->ID);
            foreach ($ancestors as $ancestor) {
                $output = '<a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a>' . $separator;
            }
            echo $output;
            echo $current . ' ' . get_the_title();
        } else {
            if ($showCurrent == 1) echo $current . ' ' . get_the_title();
        }
    } elseif (is_search()) {
        if ($paged === 1) {
            echo '<h1 class="page-title">'; esc_html_e('Resultados de búsqueda de "', 'stories'); echo the_search_query(); esc_html_e('"', 'stories') . '</h1>';
        } else {
            echo '<h1 class="page-title">' . esc_html('Página ' . $paged) . '</h1>';
        }
    } elseif (is_day()) {
        echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $separator;
        echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $separator;
        echo get_the_time('d') . $separator;
        echo $current . ' ' . get_the_time('l');
    } elseif (is_month()) {
        echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $separator;
        echo $current . ' ' . get_the_time('F');
    } elseif (is_year()) {
        echo $current . ' ' . get_the_time('Y');
    } elseif (is_single() && !is_attachment()) {
        if (get_post_type() != 'post') {
            $post_type = get_post_type_object(get_post_type());
            $slug = $post_type->rewrite;
            echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>' . $separator;
            if ($showCurrent == 1) echo $current . ' ';
        } else
        {
            $cat = get_the_category();
            $cat = $cat[0];
            $cats = get_category_parents($cat, TRUE, $separator);
            if ($showCurrent == 0) $cats = preg_replace("#^(.+)$separator$#", "$1", $cats);
            echo $cats;
            echo $current . ' ';
        }
    } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {}
    echo '</div></div></section>';
}