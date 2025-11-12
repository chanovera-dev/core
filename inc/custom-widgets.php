<?php
/**
 * Core custom widgets
 * 
 * @since 1.0.0
 * @version 1.0.0
 */

/**
 * custom output fot wp_archive_list()
 */
function custom_archives_link( $link_html, $url, $text, $format, $before, $after ) {
    $custom_link = '<li><a href="' . esc_url($url) . '">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar4-week" viewBox="0 0 16 16">
        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
        <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
    </svg>
    <span>' . $text . '</span></a></li>';
    // Return the modified link HTML
    return $before . $custom_link . $after;
}
add_filter( 'get_archives_link', 'custom_archives_link', 10, 6 );

/**
 * Custom output for category list in sidebar widget
 */
function custom_category_list($output, $args) {
    $categories = get_categories($args);

    $output = '';
    foreach ($categories as $category) {
        $svg_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags" viewBox="0 0 16 16"><path d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z"/><path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z"/></svg>';

        $output .= '<li>';
        $output .= '<a href="' . esc_url(get_category_link($category->term_id)) . '">';
        $output .= $svg_icon . '<span>' . esc_html($category->name);
        $output .= '</span></a>';
        $output .= '</li>';
    }
    $output .= '';

    return $output;
}
add_filter('wp_list_categories', 'custom_category_list', 10, 2);

/**
 * Add a custom output for latest posts block
 */
function custom_modify_latest_posts_block($block_content, $block) {
    // Verificamos que el bloque sea 'core/latest-posts'
    if ($block['blockName'] !== 'core/latest-posts') {
        return $block_content;
    }

    // Obtener las publicaciones recientes excluyendo formato "minientrada" e "image"
    $args = [
        'posts_per_page' => 5,
        'post_status'    => 'publish',
        'tax_query'      => [
            [
                'taxonomy' => 'post_format',
                'field'    => 'slug',
                'terms'    => ['post-format-aside', 'post-format-image'],
                'operator' => 'NOT IN'
            ]
        ]
    ];
    $recent_posts = get_posts($args);

    if (empty($recent_posts)) {
        return $block_content;
    }

    $output = '<ul class="wp-block-latest-posts__list wp-block-latest-posts">';

    foreach ($recent_posts as $post) {
        $post_id = $post->ID;
        $post_title = esc_html(get_the_title($post_id));
        $post_link = esc_url(get_permalink($post_id));
        $post_date = get_the_date('j \d\e F \d\e Y', $post_id);
        $post_thumbnail = get_the_post_thumbnail($post_id, 'thumbnail', ['class' => 'latest-post-thumbnail']);

        $output .= '<li><a class="latest-post__body" href="' . $post_link . '">';
        if ($post_thumbnail) {
            $output .= '<div class="latest-post-thumbnail-wrapper">' . $post_thumbnail . '</div>';
        }
        $output .= '<h4 class="wp-block-latest-posts__post-title">' . $post_title . '</h4>';
        $output .= '<div class="latest-post-date">' . $post_date . '</div>';
        $output .= '</li></a>';
    }

    $output .= '</ul>';

    return $output;
}
add_filter('render_block', 'custom_modify_latest_posts_block', 10, 2);