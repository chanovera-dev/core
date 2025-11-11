<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @since 1.0.0
 * @version 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
    <header class="block">
        <div class="content">
            <h1 class="page-title"><?php _e( 'Índice', 'core' ); ?></h1>
        </div>
    </header>
</main><!-- .site-main -->

<?php 
get_footer();