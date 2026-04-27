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
 * @package surface_blog
 */

get_header();
?>
<section class="blog-banner-page">
  <div class="blog-banner-overlay">
    <div class="blog-banner-content">
      <h1>DevNexus IT | Website Design and Development</h1>
      <p>Learn how professional website design can help grow your business online and improve user experience.</p>
    </div>

  </div>
</section>
<div id="content-wrap" class="container">
	<?php if( !is_paged() ) {
	    get_template_part( 'template-parts/featured', 'posts' );
		get_template_part( 'template-parts/popular', 'posts' );
	} ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			
			<div class="blog-archive columns-1 clear">
				<?php
				if ( have_posts() ) :
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_type() );

					endwhile;

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</div><!-- .blog-archive -->

			<?php
			the_posts_pagination(
				array(
					'prev_text'          => surface_blog_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'surface-blog' ) . '</span>',
					'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'surface-blog' ) . '</span>' . surface_blog_get_svg( array( 'icon' => 'arrow-right' ) ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'surface-blog' ) . ' </span>',
				)
			); ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>

</div><!-- .container -->

<?php
get_footer();
