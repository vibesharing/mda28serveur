 <?php
/**
 * The template for displaying the footer.
 *
 * @package Ari
 */
?>

<div id="footer" class="clearfix">
		<p class="alignright">&copy; <?php echo date ('Y'); ?> <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>. <?php printf( __( 'Theme: %1$s by %2$s.', 'ari' ), 'Ari', '<a href="http://www.elmastudio.de/en/themes/">Elmastudio</a>' ); ?> Proudly powered by <a href="http://wordpress.org/">WordPress</a>.</p>
</div>
<!--end Footer-->

</div>
<!--end Wrap-->

<?php wp_footer(); ?>
</body>
</html>

