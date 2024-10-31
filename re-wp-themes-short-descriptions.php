<?php
/*
Plugin Name: wp themes short descriptions
Plugin URI: http://oneconsult.dk/wordpress
Description: For WP 3.3 and less, this is no longer needed for WP > 3.4... Makes theme desctiptions short (like excerpt), mouseover theme to see full descriptions.
Version: 1.2
Author: maxemil
Author URI: http://oneconsult.dk
*/

add_action('admin_enqueue_scripts', 'rewptsd_scripts');
function rewptsd_scripts($hook)
{
  if( 'themes.php' == $hook )
  {
    // if on theme overview page..
    wp_enqueue_script( 'rewptsd', plugins_url('rewptsd.js', __FILE__), array( 'jquery' ), '1.0', true);

    $rewptsdStyleUrl = plugins_url('rewptsd.css', __FILE__);
    $rewptsdStyleFile = WP_PLUGIN_DIR . '/re-wp-themes-short-descriptions/rewptsd.css';
    if ( file_exists($rewptsdStyleFile) )
    {
      wp_register_style('rewptsd', $rewptsdStyleUrl);
      wp_enqueue_style( 'rewptsd');
    }
  }
}

// 1.2 - detect WP version, if 3.4 or better, autodisable plugin.
add_action( 'admin_init', 'rewptsd_deactivate_plugin_conditional' );
function rewptsd_deactivate_plugin_conditional()
{
  global $wp_version;
  $thiswpver = substr($wp_version, 0, 3); // substring because BETA versions have version format like "3.4-beta3"
  if ( version_compare( $thiswpver, '3.5', '>=' ) )
  {
    if ( is_plugin_active( 're-wp-themes-short-descriptions/re-wp-themes-short-descriptions.php') )
    {
      deactivate_plugins( 're-wp-themes-short-descriptions/re-wp-themes-short-descriptions.php' );
    }
  }
}


// remove option to activate plugin on 3.4+
register_activation_hook( __file__, 'rewptsd_register_activation_hook' );
function rewptsd_register_activation_hook()
{
  global $wp_version;
  $thiswpver = substr($wp_version, 0, 3); // substring because BETA versions have version format like "3.4-beta3"
  if ( version_compare( $thiswpver, '3.5', '>=' ) )
  {
    echo '<br/>is activating.. and version is too high<br/>';
    deactivate_plugins(basename(__FILE__)); // Deactivate ourself
    wp_die("This Plugin is depricated for WP version less than 3.4!");
  }
}

?>