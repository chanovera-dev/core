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
                    echo '<div class="metadata"><div class="date">' . get_the_date() . '</div>';
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