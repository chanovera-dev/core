<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @since 1.0.0
 * @version 1.0.0
 */

?>

<main id="main" class="site-main" role="main">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="block">
            <div class="content">
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header><!-- .entry-header -->
                <div class="entry-content is-layout-constrained">
                    <?php
                        the_content();

                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . __( 'Páginas:', 'core' ),
                                'after'  => '</div>',
                            )
                        );
                        ?>
                </div><!-- .entry-content -->
                <?php
                    if ( is_active_sidebar( 'sidebar-3' ) ) {
                        echo '
                        <aside class="sidebar page-body_sidebar">';
                        dynamic_sidebar( 'sidebar-3' ); echo '
                        </aside>';
                    }
                ?>
            </div>
        </div>
    </article><!-- #post-<?php the_ID(); ?> -->
</main>