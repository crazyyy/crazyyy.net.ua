			<footer id="footer" class="site-footer" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
				<div class="wrap">
						
					<?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
					  <aside id="footer-sidebar" class="footer-sidebar widget_area clearfix" role="complementary">  
					  <?php dynamic_sidebar( 'footer-sidebar' ); ?>
					  </aside>
					<?php endif; ?>
	
					<div class="footer-info">
					  <?php do_action( 'underline-footer-info' ); ?>
					  <?php echo apply_filters( 'underline-footer-copyright', '<p class="copyright">' . sprintf( __( 'Copyright &copy; %s %s', 'underline' ), date('Y'), get_bloginfo('name') ) . '</p>' ); ?>
					  <?php echo apply_filters( 'underline-footer-credit', '<p class="credit">' . sprintf( __( 'Powered by %s and %s', 'underline' ), '<a href="http://wordpress.org">WordPress</a>', '<a href="http://wpmisc.com">Underline</a>' ) . '</p>' ); ?></p>
					</div>

				</div>
			</footer><!-- #footer -->
		</div><!-- #page -->
		<?php wp_footer(); ?>
	</body>
</html>