<?php
/**
 * Template part for displaying post content in single.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @since 1.0.0
 * @version 1.0.0
 */

?>

<main id="main" class="site-main" role="main">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="block entry-header">
            <div class="content">
                <?php 
                    the_title( '<h1 class="entry-title">', '</h1>' ); 
                    echo '<div class="metadata"><div class="date"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar4-week" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/><path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/></svg>' . get_the_date() . '</div>';
                    if ( get_comments_number() > 0 ) :
                        echo '<div class="comments">';
                                if ( get_comments_number() == 1 ) {
                                    echo get_comments_number(); echo '<span></span>' . esc_html( 'Comentario', 'stories' );
                                } else {
                                    echo get_comments_number(); echo '<span></span>' . esc_html( 'Comentarios', 'stories' );
                                }
                        echo '</div>';
                    endif;
                ?>
            </div>
        </header><!-- .entry-header -->
        <div class="block">
            <div class="content">
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
                    if ( is_active_sidebar( 'sidebar-2' ) ) {
                        echo '
                        <aside class="sidebar post-body_sidebar">';
                        dynamic_sidebar( 'sidebar-2' ); echo '
                        </aside>';
                    }
                ?>
            </div>
        </div>
    </article><!-- #post-<?php the_ID(); ?> -->
</main>