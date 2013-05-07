<?php

/***
Plugin name: Wordpress Test Plug-in
plugin URI: n.a 
Description: This is a basic plug in that works with wordpress. It's purpose is a simple
test to ensure some of the basics work.
Author: Chris Tully
Author URI:
Version:1.0
*/

//global
$testPlugin_options = get_option('testPluginsettings');

//original article
$original = $testPlugin_options['original'];
//spun articles
$rewritten = $testPlugin_options['rewrite'];

//comparing articles: using similar_Text
$testPluginFunc = similar_text($original,$rewritten,$result);

 
//admin page

function testPlugInPage(){
//make sure to declare global variables inside of functions
global $testPlugin_options;
global $result;

//used when you want to start writing html
ob_start();?>

<!--create a settings page -->
<div class="wrap">
 <form action="options.php" method="POST">
 <!-- you must have this in order to save settings properly after making a commit. -->
 <!--http://codex.wordpress.org/Function_Reference/settings_fields -->
 <!--settings_fields( $option_group ) -->
 
  <?php settings_fields('testPluginGroup'); ?>
  
  <h1> Wordpress testPage settings </h1>
  
	<p><h3> Paste your oringinal article here </h3> </p> 
 <!-- make sure to set the name to the register_settings param2 -->
 <textarea name="testPluginsettings[original]" rows="20" cols="100"> <?php echo $testPlugin_options['original']; ?> </textarea>
 <p>
 <h3>Paste in your rewritten article here </h3>
 </p>
 <textarea name="testPluginsettings[rewrite]" rows="20" cols="100"> <?php echo $testPlugin_options['rewrite']; ?> </textarea>
	 <p>
	 <input type="submit" class="button-primary" Value="Compare Spun Articles">
	 <input type="button" class="button" value="<?php echo $result . "%" ;?>">
	 </p>
 </form>
</div>

<?php 
echo ob_get_clean();
}
//admin tab
 //create func first (1)
 
 function wp_dupe_cop_tab()
 {
 //add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
 //http://codex.wordpress.org/Function_Reference/add_options_page
	add_options_page(' testPlugin','test_plugin','manage_options','wpdupecop','testPlugInPage');	
 
 }
add_action('admin_menu', 'wp_dupe_cop_tab');

//register settings
//this is the connection to the settings/options page (wp php)
function testPlugin_setting(){
//http://codex.wordpress.org/Function_Reference/register_setting
//register_setting( $option_group, $option_name, $sanitize_callback )
register_setting('testPluginGroup','testPluginsetting');
}
//http://codex.wordpress.org/Function_Reference/add_action
// add_action( $tag, $function_to_add, $priority,$accepted_args );
add_action('admin_init', 'testPlugin_setting');
//
