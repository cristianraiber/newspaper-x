<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */


if ( is_single() ) {
	/**
	 * Enable breadcrumbs
	 */
	$breadcrumbs_enabled = get_theme_mod( 'newspaper_x_enable_post_breadcrumbs', true );
	if ( $breadcrumbs_enabled ) {
		newspaper_x_breadcrumbs();
	}
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
		<?php
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		}
		?>
        <div class="newspaper-x-image">
			<?php
			$image = '<img class="wp-post-image" alt="" src="' . get_template_directory_uri() . '/assets/images/picture_placeholder.jpg" />';
			if ( has_post_thumbnail() ) {
				$image = is_single() ? get_the_post_thumbnail( get_the_ID(), 'newspaper-x-single-post' ) : get_the_post_thumbnail( get_the_ID(), 'newspaper-x-recent-post-big' );
			}

			$image_obj = array( 'id' => get_the_ID(), 'image' => $image );
			$new_image = apply_filters( 'newspaper_x_widget_image', $image_obj );

			$allowed_tags = array(
				'img'      => array(
					'data-srcset' => true,
					'data-src'    => true,
					'srcset'      => true,
					'sizes'       => true,
					'src'         => true,
					'class'       => true,
					'alt'         => true,
					'width'       => true,
					'height'      => true
				),
				'noscript' => array()
			);

			echo ! is_single() ? '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' : '';

			echo wp_kses( $new_image, $allowed_tags );

			echo ! is_single() ? '</a>' : '';
			?>
        </div>
		<?php
		if ( ! is_single() ) {
			echo '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . wp_trim_words( get_the_title(), 8 ) . '</a></h4>';
		}
		if ( 'post' === get_post_type() ) : ?>
            <div class="newspaper-x-post-meta">
				<?php newspaper_x_posted_on(); ?>
            </div><!-- .entry-meta -->
			<?php
		endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
		<?php
		if ( is_single() ) {
			the_content();

			wp_link_pages( array(
				               'before' => '<ul class="newspaper-x-pager">',
				               'after'  => '</ul>',
			               ) );

			$prev = get_previous_post_link();
			$prev = str_replace( '&laquo;', '<span class="fa fa-caret-left"></span>', $prev );
			$next = get_next_post_link();
			$next = str_replace( '&raquo;', '<span class="fa fa-caret-right"></span>', $next );
			?>
            <div class="newspaper-x-next-prev row">
                <div class="col-md-6 text-left">
					<?php echo $prev ?>
                </div>
                <div class="col-md-6 text-right">
					<?php echo $next ?>
                </div>
            </div>
			<?php
		} else {
			the_excerpt();
		}

		?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
		<?php
		if ( is_single() ) {
			// Include author information
			get_template_part( 'template-parts/author-info' );
			// Include the related posts
			do_action( 'newspaper_x_single_after_article' );
		}
		?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
