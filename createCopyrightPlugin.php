<?php
/*
Plugin Name: Create Copyright Plugin
Plugin URI: https://createcopyright.com
Description: This plugin is my first time develop plugin.
Version: 1.0.0
Author: Yi
Author URI: https://createcopyright.com
License: GPLv2 or later
*/


register_activation_hook( __FILE__, 'display_copyright_install');
register_deactivation_hook( __FILE__, 'display_copyright_remove' );
function display_copyright_install() {
    add_option("display_copyright_text", "<p style='color:#ff0d00'> Notice: All articles of this site are original, if reproduced please indicate the source!</p>", ' ', 'yes');
}

function display_copyright_remove() {
    delete_option('display_copyright_text');
}

if( is_admin() ) {
    add_action('admin_menu', 'display_copyright_menu');
}

function display_copyright_menu() {
    add_options_page('Copyright Settings page', 'Copyright Settings menu', 'administrator','display_copyright', 'display_copyright_html_page');
}

function display_copyright_html_page()
{
?>
    <div>
        <h2>Copyright Settings</h2>
        <form method=“post” action=“options.php”>
            <?php ?>
            <?php wp_nonce_field('update-options'); ?>
            <p>
                <textarea
                    name=“display_copyright_text”
                    id=“display_copyright_text”
                    cols=“40”
                    rows=“6”><?php echo get_option('display_copyright_text'); ?></textarea>
            </p>
            <p>
                <input type=“hidden” name=“action” value=“update” />
                <input type=“hidden” name=“page_options” value=“display_copyright_text” />
                <input type=“submit” value=“save_settings” class=“button-primary” />
            </p>
        </form>
    </div>
<?php
}
add_filter( 'the_content',  'display_copyright');

function display_copyright( $content ) {
    if( is_single() )
        $content = $content . get_option('display_copyright_text');
    return $content;
}
?>
