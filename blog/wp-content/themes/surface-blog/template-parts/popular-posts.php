<?php
$popular_posts_section_title = get_theme_mod( 'popular_posts_section_title', 'Popular Posts' );
$number_of_popular_posts_items     = get_theme_mod( 'number_of_popular_posts_items', 3 );
$popular_posts_id 			  = get_theme_mod( 'popular_posts_category', '' );

$query = new WP_Query( apply_filters( 'surface_blog_popular_posts_args', array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => absint( $number_of_popular_posts_items ),
	'cat'                 => $popular_posts_id,
	'offset'              => 0,
	'ignore_sticky_posts' => 1
)));

$posts_array = $query->get_posts();
$show_popular_posts = count( $posts_array ) > 0 && is_home();

if( get_theme_mod( 'popular_posts', true ) && $show_popular_posts ) {
	?>
	<section class="section-popular-posts">
		<div class="section-header">
			<h2 class="section-title"><?php echo esc_html($popular_posts_section_title); ?></h2>
		</div><!-- .section-header -->

		<div class="columns-3 clear">
			<?php
			while ( $query->have_posts() ) : $query->the_post(); ?>

	            <article>
	            	<div class="popular-post-item">
			        	<?php if ( has_post_thumbnail() ) : ?>
							<div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
								<a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
							</div><!-- .featured-image -->
						<?php endif; ?>

			            <div class="entry-container">
			            	<div class="entry-meta">
				        		<?php surface_blog_entry_footer() ?>
								<?php surface_blog_posted_on() ?>
				        	</div><!-- .entry-meta -->

							<header class="entry-header">
								<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							</header>

							<?php $excerpt = get_the_excerpt();
							if ( !empty($excerpt) ) { ?>
								<div class="entry-content">
									<?php the_excerpt(); ?>
								</div><!-- .entry-content -->
							<?php } ?>

							<?php $read_more_label = get_theme_mod( 'read_more_label' , 'Read More' );
							if ( !empty($read_more_label) ) { ?>
								<div class="read-full">
									<a href="<?php the_permalink(); ?>"><?php echo esc_html($read_more_label);?></a>
								</div><!-- .read-more -->
							<?php } ?>
				        </div><!-- .entry-container -->
				       <!-- .popular-post-item -->
	            </article>
		        
			<?php
			endwhile; 
			wp_reset_postdata(); ?>
		</div><!-- .columns-4 -->
	</section>
<?php } ?>