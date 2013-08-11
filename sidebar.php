<aside id="sidebar" role="sidebar">
    <div id="sidebar-content">
		<?php if (!function_exists('dynamic_sidebar')|| dynamic_sidebar('Sidebar') ): ?>
        
		<?php endif;?>

		<?php wp_nav_menu( array( 'theme_location' => 'sidebar-menu', 'container_class' => 'widget', 'container_id' => 'sidebar_menu', 'menu_id' => 'sidebar_menu_content', 'fallback_cb' => 'fanoe_link_to_menu_editor' ) ); ?>
		
        <div class="widget copyright">
			<h4>Copyright</h4>
			<p><?php $copyright = htmlspecialchars_decode(get_theme_mod( 'copyright' )); if($copyright !=''){echo $copyright;}else{?>&copy; <?php echo date('Y'); ?>  <?php bloginfo( 'name' ); ?><?php }?>  | <?php _e('Theme: Fanoe by <a href="http://webdesign-florian-brinkmann.de">Webdesign Florian Brinkmann</a>', 'fanoe')?></p> 
        </div>
    </div>
</aside>