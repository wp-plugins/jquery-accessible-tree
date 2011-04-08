<?php

if (!function_exists('get_my_categories')) {

    function get_my_categories($before = '<li>', $after = '</li>') {
        /** Define ABSPATH as this files directory */
        define('ABSPATH', dirname(__FILE__) . '/../../../');
        include_once(ABSPATH . "wp-config.php");
        include_once(ABSPATH . "wp-load.php");
        include_once(ABSPATH . "wp-includes/wp-db.php");
        include_once(ABSPATH . "wp-includes/category.php");

        global $wpdb;

        $args = array(
            'orderby' => 'name',
            'order' => 'ASC'
        );
        $categories = get_categories($args);
        $output = '';
        foreach ($categories as $category) {
            $output .= $before . '<a href="' . get_category_link($category->term_id) .
                    '" title="' . sprintf(__("View all posts in %s"), $category->name) .
                    '" ' . '>' . $category->name . '</a> </p> ';
            $output .= $after;
        }
        return $output;
    }

}
?>
