<aside id="secondary" class="main-sidebar widget-area" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
<?php if ( is_active_sidebar( 'main-sidebar' ) ) : ?>
  <?php dynamic_sidebar( 'main-sidebar' ); ?>
<?php else : ?>
  <section class="widget widget_none">
    <div class="notice">
      <p><?php _e( "You haven't set any widget on this sidebar yet.", "underline" ); ?></p>
      <p class="setup"><a href="<?php echo admin_url( 'widgets.php' ); ?>"><?php _e( 'Set it up', 'underline' ); ?></a></p>
    </div>
  </section>
<?php endif; ?>
</aside><!-- #secondary -->
