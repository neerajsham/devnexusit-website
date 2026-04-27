<?php
$featured_posts_id = get_theme_mod( 'featured_posts_category', '' );

$query = new WP_Query( apply_filters( 'surface_blog_featured_posts_args', array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 3,
	'cat'                 => $featured_posts_id,
	'offset'              => 0,
	'ignore_sticky_posts' => 1
)));

$posts_array = $query->get_posts();
$show_featured_posts = count( $posts_array ) > 0 && is_home();

if( get_theme_mod( 'featured_posts', true ) && $show_featured_posts ){
	?>
	<section class="section-featured-posts">
		<div class="custom-row">
		<?php
			$main_post = true;
			$i 		   = 1;
			while ( $query->have_posts() ) : $query->the_post();
			$image 	= get_the_post_thumbnail_url( get_the_ID(), 'large' );

			if( $main_post ){ $main_post = false; ?>
				<div class="custom-col-12 custom-col-lg-7">
			        <article class="post feature-posts-content-wrap feature-big-posts">
			        	<div class="featured-image" style="background-image: url( <?php echo esc_url( $image ); ?> );">
				        	<div class="entry-container">
				        		<header class="entry-header">
				        			<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				        		</header>

								<?php $excerpt = get_the_excerpt();
								if ( !empty($excerpt) ) { ?>
									<div class="entry-content">
										<?php the_excerpt(); ?>
									</div><!-- .entry-content -->
								<?php } ?>

					            <div class="entry-meta">
									<?php surface_blog_entry_footer() ?>
									<?php surface_blog_posted_on() ?>
								</div>
				        	</div>
			        	</div>
			        </article>
			    </div>
			<?php }else{
				if( $i == 2 ){ ?>
				<div class="custom-col-md-12 custom-col-lg-5">
			        <div class="custom-row">
			        <?php } ?>
			        	<div class="custom-col-md-12">
				            <article class="post feature-posts-content-wrap">
				            	<div class="featured-image" style="background-image: url( <?php echo esc_url( $image ); ?> );">
					            	<div class="entry-container">
										<header class="entry-header">
						        			<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						        		</header>

							            <div class="entry-meta">
											<?php surface_blog_entry_footer() ?>
											<?php surface_blog_posted_on() ?>
										</div>
						        	</div>
					        	</div>
				            </article>
			        	</div>
			        <?php if( count( $posts_array ) == $i ){ ?>
			        </div>
			    </div>
				<?php } ?>
			<?php } ?>
			<?php
			$i++;
			endwhile; 
			wp_reset_postdata();
		?>
		</div>
	</section>
<?php } ?>