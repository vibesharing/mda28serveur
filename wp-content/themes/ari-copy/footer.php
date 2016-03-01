<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package dazzling
 */
?>
                </div><!-- close .row -->
            </div><!-- close .container -->
        </div><!-- close .site-content -->

	<div id="footer-area">
		<div class="container footer-inner">
			<?php get_sidebar( 'footer' ); ?>
		</div>

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info container">
				<?php if( of_get_option('footer_social') ) dazzling_social_icons(); ?>
				<nav role="navigation" class="col-md-7">
					<?php dazzling_footer_links(); ?>
				</nav>
				<div class="copyright col-md-5">
					<?php echo of_get_option( 'custom_footer_text'); ?>
				</div>
			</div><!-- .site-info -->
			<div class="scroll-to-top"><i class="fa fa-angle-up"></i></div><!-- .scroll-to-top -->
		</footer><!-- #colophon -->
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

<script>
  $(".profile").each(function(i){
    $(this).hover(function(){
			$(this).addClass('animated');
      $(this).addClass('flash');
    }, function(){
			$(this).removeClass('animated');
			$(this).removeClass('flash');
		});
  })
  $(".img-circle").each(function(i){
    $(this).hover(function(){
			$(this).addClass('animated');
      $(this).addClass('rubberBand');
    }, function(){
			$(this).removeClass('animated');
			$(this).removeClass('rubberBand');
		});
  })


</script>
</html>