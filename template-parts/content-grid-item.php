<?php
/**
 * The template used for displaying posts in a grid
 *
 * @package Latest
 */
?>

<?php
  $post_type = get_post_type( $post );
  if( 'sfwd-lessons' == $post_type || 'sfwd-topic' == $post_type || 'sfwd-courses' == $post_type ) {
    $post_type = 'course';
  }
?>


	<article id="post-<?php the_ID(); ?>" <?php post_class( 'grid-thumb post' ); ?>>
		<?php if ( has_post_thumbnail() ) { ?>
			<a class="grid-thumb-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<!-- Grab the image -->
				<?php
					$post_layout = get_option( 'latest_layout_style' );
					if ( $post_layout == 'two-column-masonry' || $post_layout == 'three-column-masonry' ) {
						the_post_thumbnail( 'latest-grid-thumb-masonry' );
					} else {
						the_post_thumbnail( 'latest-grid-thumb' );
					}
				?>
			</a>
		<?php } ?>

		<!-- Post title and categories -->
		<div class="grid-text">
			<?php echo latest_list_cats( 'grid' ); ?>

      <?php if( 'course' == $post_type && !is_user_logged_in() ): ?>

          <h3 class="entry-title"><?php the_title(); ?></h3>

      <?php else: ?>

        <h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
        <?php
  				$excerpt_length = get_theme_mod( 'latest_multi_column_excerpt_length', '25' );
  				if ( $excerpt_length > 0 && is_user_logged_in() ) {
  			?>
  				<p><?php echo wp_trim_words( get_the_excerpt(), $excerpt_length, '...' ); ?></p>
  			<?php } ?>

      <?php endif;  ?>


			<div class="grid-date">
				<?php the_author_posts_link(); ?> <span>/</span>
        <?php if( 'post' == $post_type ): ?>
				<span class="date"><?php echo get_the_date(); ?></span> <span>/</span>
        <?php endif; ?>
				<span class="post-type">
          <?php echo $post_type; ?>
          <?php if( 'course' == $post_type && !is_user_logged_in() ): ?>
            <span>/ Course Access Required</span>
          <?php endif; ?>
        </span>
			</div>
		</div><!-- .grid-text -->
	</article><!-- .post -->
