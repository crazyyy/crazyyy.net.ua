			<footer id="footer" class="site-footer" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
				<div class="wrap">
						
					<?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
					  <aside id="footer-sidebar" class="footer-sidebar widget_area clearfix" role="complementary">  
					  <?php dynamic_sidebar( 'footer-sidebar' ); ?>
					  </aside>
					<?php endif; ?>
	
					<div class="footer-info">
	
					</div>

				</div>
			</footer><!-- #footer -->
		</div><!-- #page -->
		<?php wp_footer(); ?>
	</body>
</html>