<?php
/*
Plugin Name: wp-config.php File Viewer
Plugin URI: https://wpxss.com.com/
Description: View and copy the content of wp-config.php file.
Version: 1.0
Author: Stefan Pejcic
Author URI: https://pejcic.rs/
*/

function wp_config_viewer_menu() {
    add_management_page('wp-config.php File Viewer', 'wp-config.php', 'manage_options', 'wp-config-viewer', 'wp_config_viewer_page');
}
add_action('admin_menu', 'wp_config_viewer_menu');

function wp_config_viewer_page() {
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    $config_path = ABSPATH . 'wp-config.php';
    $content = file_get_contents($config_path);
    ?>

    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?> <button class="button button-primary" onclick="copyCode()">Copy content</button></h1>

        <script>
    function copyCode() {
        // select the code block
        var codeBlock = document.querySelector('#code-block');

        // select the text inside the code block
        var selection = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(codeBlock);
        selection.removeAllRanges();
        selection.addRange(range);

        // copy the selected text
        document.execCommand('copy');

        // clear the selection
        selection.removeAllRanges();
    }
</script>
<style>/* Syntax Highlighter CSS */
pre {
    background-color: #292e34;
    border-left: 5px solid #389ce9;
    border-radius: unset;
    padding: 0;
    margin: .5em auto;
    position: relative;
    white-space: pre;
    word-wrap: break-word;
    word-break: normal;
    overflow: auto;
    -moz-tab-size: 2;
    -o-tab-size: 2;
    tab-size: 2;
    -webkit-hyphens: none;
    -moz-hyphens: none;
    -ms-hyphens: none;
    hyphens: none
}

pre.html:before {
    content: 'HTML';
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M12,17.56L16.07,16.43L16.62,10.33H9.38L9.2,8.3H16.8L17,6.31H7L7.56,12.32H14.45L14.22,14.9L12,15.5L9.78,14.9L9.64,13.24H7.64L7.93,16.43L12,17.56M4.07,3H19.93L18.5,19.2L12,21L5.5,19.2L4.07,3Z' fill='%231d2129'/%3E%3C/svg%3E")
}

pre.copsour:before {
    content: 'Copyright or Source';
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M10.08,10.86C10.13,10.53 10.24,10.24 10.38,10C10.5,9.74 10.72,9.53 10.97,9.37C11.21,9.22 11.5,9.15 11.88,9.14C12.11,9.15 12.32,9.19 12.5,9.27C12.71,9.36 12.89,9.5 13.03,9.63C13.17,9.78 13.28,9.96 13.37,10.16C13.46,10.36 13.5,10.58 13.5,10.8H15.3C15.28,10.33 15.19,9.9 15,9.5C14.85,9.12 14.62,8.78 14.32,8.5C14,8.22 13.66,8 13.24,7.84C12.82,7.68 12.36,7.61 11.85,7.61C11.2,7.61 10.63,7.72 10.15,7.95C9.67,8.18 9.27,8.5 8.95,8.87C8.63,9.26 8.39,9.71 8.24,10.23C8.09,10.75 8,11.29 8,11.87V12.14C8,12.72 8.08,13.26 8.23,13.78C8.38,14.3 8.62,14.75 8.94,15.13C9.26,15.5 9.66,15.82 10.14,16.04C10.62,16.26 11.19,16.38 11.84,16.38C12.31,16.38 12.75,16.3 13.16,16.15C13.57,16 13.93,15.79 14.24,15.5C14.55,15.25 14.8,14.94 15,14.58C15.16,14.22 15.27,13.84 15.28,13.43H13.5C13.5,13.64 13.43,13.83 13.34,14C13.25,14.19 13.13,14.34 13,14.47C12.83,14.6 12.66,14.7 12.46,14.77C12.27,14.84 12.07,14.86 11.86,14.87C11.5,14.86 11.2,14.79 10.97,14.64C10.72,14.5 10.5,14.27 10.38,14C10.24,13.77 10.13,13.47 10.08,13.14C10.03,12.81 10,12.47 10,12.14V11.87C10,11.5 10.03,11.19 10.08,10.86M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20Z' fill='%231d2129'/%3E%3C/svg%3E")
}

pre.php:before {
    content: 'wp-config.php';
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M12,18.08C5.37,18.08 0,15.36 0,12C0,8.64 5.37,5.92 12,5.92C18.63,5.92 24,8.64 24,12C24,15.36 18.63,18.08 12,18.08M6.81,10.13C7.35,10.13 7.72,10.23 7.9,10.44C8.08,10.64 8.12,11 8.03,11.47C7.93,12 7.74,12.34 7.45,12.56C7.17,12.78 6.74,12.89 6.16,12.89H5.29L5.82,10.13H6.81M3.31,15.68H4.75L5.09,13.93H6.32C6.86,13.93 7.3,13.87 7.65,13.76C8,13.64 8.32,13.45 8.61,13.18C8.85,12.96 9.04,12.72 9.19,12.45C9.34,12.19 9.45,11.89 9.5,11.57C9.66,10.79 9.55,10.18 9.17,9.75C8.78,9.31 8.18,9.1 7.35,9.1H4.59L3.31,15.68M10.56,7.35L9.28,13.93H10.7L11.44,10.16H12.58C12.94,10.16 13.18,10.22 13.29,10.34C13.4,10.46 13.42,10.68 13.36,11L12.79,13.93H14.24L14.83,10.86C14.96,10.24 14.86,9.79 14.56,9.5C14.26,9.23 13.71,9.1 12.91,9.1H11.64L12,7.35H10.56M18,10.13C18.55,10.13 18.91,10.23 19.09,10.44C19.27,10.64 19.31,11 19.22,11.47C19.12,12 18.93,12.34 18.65,12.56C18.36,12.78 17.93,12.89 17.35,12.89H16.5L17,10.13H18M14.5,15.68H15.94L16.28,13.93H17.5C18.05,13.93 18.5,13.87 18.85,13.76C19.2,13.64 19.5,13.45 19.8,13.18C20.04,12.96 20.24,12.72 20.38,12.45C20.53,12.19 20.64,11.89 20.7,11.57C20.85,10.79 20.74,10.18 20.36,9.75C20,9.31 19.37,9.1 18.54,9.1H15.79L14.5,15.68Z' fill='%231d2129'/%3E%3C/svg%3E")
}

pre.copsour:before,
pre.css:before,
pre.html:before,
pre.javascript:before,
pre.jquery:before,
pre.php:before {
    background-color: #90b7f8;
    font: 500 14px 'Google Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Oxygen', 'Roboto', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', Arial, sans-serif;
    color: #333;
    display: block;
    padding: 10px 35px;
    font-size: 16px;
    background-repeat: no-repeat;
    background-size: 20px 20px;
    background-position-x: 7px;
    background-position-y: center
}

code,
code.tutor,
pre,
pre code {
    -webkit-user-select: text;
    -khtml-user-select: text;
    -moz-user-select: text;
    -ms-user-select: text;
    user-select: text
}

pre code {
    display: block;
    padding: 10px 15px;
    line-height: 1.5em;
    white-space: pre;
    overflow: auto;
    color: #bfbf90;
    font-size: 13px
}

code,
code.tutor {
    color: #d85555;
    letter-spacing: -.3px;
    font-size: 1em
}

</style>
</style>






        <pre class="php"><code id="code-block">
<?php echo esc_html($content); ?>
        </code></pre>
    </div>
    <?php
}
