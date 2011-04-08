<?php

if (!function_exists('get_my_meta')) {

    function get_my_meta($before = '<li>', $after = '</li>') {
        /** Define ABSPATH as this files directory */
        define('ABSPATH', dirname(__FILE__) . '/../../../');
        include_once(ABSPATH . "wp-includes/general-template.php");
        include_once(ABSPATH . "wp-includes/formatting.php");
        include_once(ABSPATH . "wp-includes/l10n.php");

        $siteurl = get_bloginfo('siteurl');
        $siteadmin = $siteurl . '/wp-admin';
        $rss2 = $siteurl . '/?feed=rss2';
        $commentsrss2 = $siteurl . '/?feed=comments-rss2';
        $blogtitle = get_bloginfo();

        $output = '';
        $output .= $before . '<a href="' . $siteadmin . '" title="Administer ' . $blogtitle . '">'
                . 'Site Admin</a>' . $after;
        $output .= $before . wp_loginout('', false) . $after;
        $output .= $before . '<a href="' . $rss2 . '" title="' .
                esc_attr(__('Syndicate this site using RSS 2.0')) . '">' .
                __('Entries <abbr title="Really Simple Syndication">RSS</abbr>') . '</a>' . $after;
        $output .= $before . '<a href="' . $commentsrss2 . '" title="' .
                esc_attr(__('The latest comments to all posts in RSS')) . '">' .
                __('Comments <abbr title="Really Simple Syndication">RSS</abbr>') . '</a>' . $after;
        return $output;
    }

}
?>
