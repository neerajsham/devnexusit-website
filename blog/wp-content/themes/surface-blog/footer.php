<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package surface_blog
 */

?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php if ( is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) || is_active_sidebar( 'sidebar-4' ) ) : ?>
			<div id="footer-widgets" class="container">
				
				<?php
					get_template_part( 'inc/footer', 'widgets' );
				?>
				
			</div><!-- .container -->
		<?php endif; ?>

		<div class="site-info">
			<div class="container">
				<p>
					© 2024-2026 DevNexusIT - Web Design & Development Company. All Rights Reserved.</p>

				<?php echo $copyright_text; ?>
			</div><!-- .container -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

	<a href="#page" class="to-top"></a>
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
