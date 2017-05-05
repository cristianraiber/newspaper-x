<?php
/**
 * Template part for displaying the main slider
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */

$cats = get_theme_mod( 'newspaper_x_recent_posts_category', array( '1' ) );

if ( ! $cats || ! is_array( $cats ) || ( is_array( $cats ) && empty( array_filter( $cats ) ) ) ) {
	$cats = array( '1' );
}

$order    = get_theme_mod( 'newspaper_x_recent_posts_ordering', 'DESC' );
$order_by = get_theme_mod( 'newspaper_x_recent_posts_order_by', 'date' );
$order    = is_array( $order ) ? $order[0] : $order;
$order_by = is_array( $order_by ) ? $order_by[0] : $order_by;

$args = array(
	'numberposts' => 3,
	'orderby'     => $order_by,
	'order'       => $order,
	'post_type'   => 'post',
	'post_status' => 'publish',
	//'category'    => implode( ',', $cats )
);

$recent_posts = wp_get_recent_posts( $args, OBJECT );
wp_reset_postdata();
if ( ! $recent_posts ) {
	return false;
}
?>

<?php
$i = 0;
foreach ( $recent_posts as $post ) {
	$cat         = get_the_category( $post->ID );
	$cat_link    = get_category_link( $cat[0]->term_id );
	$cat         = $cat[0]->name;
	$image       = get_template_directory_uri() . '/assets/images/picture_placeholder.jpg';
	$placeholder = $image;
	$h = ($i == 0) ? '1' : '6' ;


	if ( has_post_thumbnail() ) {
		$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),
		                                    'newspaper-x-recent-post-big',
		                                    false,
		                                    '' );

		$srcsmall = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),
		                                         'newspaper-x-recent-post-list-image',
		                                         false,
		                                         '' );

		$image       = $src[0];
		$placeholder = $srcsmall[0];
		if ($i == 0) {?>
			<div class="newspaper-x-recent-post-containter" >
				<div class="recent-mirror" style="background-image:url('<?php echo esc_url( $placeholder ) ?>')"></div> <!-- image bg -->
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="newspaper-x-recent-posts">
								<ul>
		<?php }	}?>

									<li class="blazy" id="newspaper-x-recent-post-<?php echo $i; ?>" data-src="<?php echo esc_url( $image ) ?>"
									    style="background-image:url('<?php echo esc_url( $placeholder ) ?>')">
										<div class="newspaper-x-post-info">
											<h<?php echo $h; ?>>
												<a href="<?php echo esc_url( get_permalink( $post->ID ) ) ?>">
													<?php echo wp_kses_post( wp_trim_words( $post->post_title, 6, $more = '&hellip;' ) ) ?>
												</a>
											</h<?php echo $h; ?>>
											<span class="newspaper-x-category">
												<a href="<?php echo esc_url( $cat_link ) ?>"><?php echo esc_html( $cat ) ?></a> 
											</span>
											<span class="newspaper-x-date"><?php echo esc_html( get_the_date() ) ?></span>
										</div>
									</li>
							<?php $i ++;
						} ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>