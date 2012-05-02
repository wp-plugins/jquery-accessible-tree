<?php
/*
Plugin Name: JQuery Accessible Tree
Plugin URI: http://wordpress.org/extend/plugins/jquery-accessible-tree/
Description: WAI-ARIA Enabled Tree Plugin for Wordpress
Author: Kontotasiou Dionysia
Version: 2.0
Author URI: http://www.iti.gr/iti/people/Dionisia_Kontotasiou.html
*/
include_once 'getRecentPosts.php';
include_once 'getRecentComments.php';
include_once 'getCategories.php';
include_once 'getMeta.php';

add_action("plugins_loaded", "JQueryAccessibleTree_init");
function JQueryAccessibleTree_init() {
    register_sidebar_widget(__('JQuery Accessible Tree'), 'widget_JQueryAccessibleTree');
    register_widget_control(   'JQuery Accessible Tree', 'JQueryAccessibleTree_control', 200, 200 );
    if ( !is_admin() && is_active_widget('widget_JQueryAccessibleTree') ) {
        wp_register_style('jquery.ui.all', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tree/lib/jquery-ui/themes/base/jquery.ui.all.css'));
        wp_enqueue_style('jquery.ui.all');

        wp_deregister_script('jquery');

        // add your own script
        wp_register_script('jquery-1.6.4', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tree/lib/jquery-ui/jquery-1.6.4.js'));
        wp_enqueue_script('jquery-1.6.4');

        wp_register_script('jquery.cookie', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tree/lib/jstree-a11y/jsTree.v.1.0rc2/lib/jquery.cookie.js'));
        wp_enqueue_script('jquery.cookie');

        wp_register_script('jquery.hotkeys', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tree/lib/jstree-a11y/jsTree.v.1.0rc2/lib/jquery.hotkeys.js'));
        wp_enqueue_script('jquery.hotkeys');

        wp_register_script('jquery.jstree', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tree/lib/jstree-a11y/jsTree.v.1.0rc2/jquery.jstree.js'));
        wp_enqueue_script('jquery.jstree');

        wp_register_style('demos', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tree/lib/jquery-ui/demos.css'));
        wp_enqueue_style('demos');

        wp_register_script('JQueryAccessibleTree', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tree/lib/JQueryAccessibleTree.js'));
        wp_enqueue_script('JQueryAccessibleTree');
    }
}

function widget_JQueryAccessibleTree($args) {
    extract($args);

    $options = get_option("widget_JQueryAccessibleTree");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'JQuery Accessible Tree',
            'categories' => 'Categories',
            'meta' => 'Meta',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    echo $before_widget;
    echo $before_title;
    echo $options['title'];
    echo $after_title;

    //Our Widget Content
    JQueryAccessibleTreeContent();
    echo $after_widget;
}

function JQueryAccessibleTreeContent() {
    $recentPosts = get_recent_posts();
    $recentComments = get_recent_comments();
    $categories = get_my_categories();
    $meta = get_my_meta();

    $options = get_option("widget_JQueryAccessibleTree");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'JQuery Accessible Tree',
            'categories' => 'Categories',
            'meta' => 'Meta',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    echo '<div class="demo" role="application">
            <div id="sampleTree">
                        <ul>
                            <li> <a href="#">' . $options['recentPosts'] . '</a><ul>
                                ' . $recentPosts . '
                            </ul></li>
                            <li> <a href="#">' . $options['recentComments'] . '</a><ul>
                                ' . $recentComments . '
                            </ul></li>
                            <li> <a href="#">' . $options['categories'] . '</a><ul>
                                ' . $categories . '
                            </ul></li>
                            <li> <a href="#">' . $options['meta'] . '</a><ul>
                                ' . $meta . '
                            </ul></li>
                        </ul>
                    </div>
          </div>';
}

function JQueryAccessibleTree_control() {
    $options = get_option("widget_JQueryAccessibleTree");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'JQuery Accessible Tree',
            'categories' => 'Categories',
            'meta' => 'Meta',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    if ($_POST['JQueryAccessibleTree-SubmitTitle']) {
        $options['title'] = htmlspecialchars($_POST['JQueryAccessibleTree-WidgetTitle']);
        update_option("widget_JQueryAccessibleTree", $options);
    }
    if ($_POST['JQueryAccessibleTree-SubmitCategories']) {
        $options['categories'] = htmlspecialchars($_POST['JQueryAccessibleTree-WidgetCategories']);
        update_option("widget_JQueryAccessibleTree", $options);
    }
    if ($_POST['JQueryAccessibleTree-SubmitMeta']) {
        $options['meta'] = htmlspecialchars($_POST['JQueryAccessibleTree-WidgetMeta']);
        update_option("widget_JQueryAccessibleTree", $options);
    }
    if ($_POST['JQueryAccessibleTree-SubmitRecentPosts']) {
        $options['recentPosts'] = htmlspecialchars($_POST['JQueryAccessibleTree-WidgetRecentPosts']);
        update_option("widget_JQueryAccessibleTree", $options);
    }
    if ($_POST['JQueryAccessibleTree-SubmitRecentComments']) {
        $options['recentComments'] = htmlspecialchars($_POST['JQueryAccessibleTree-WidgetRecentComments']);
        update_option("widget_JQueryAccessibleTree", $options);
    }
    ?>
    <p>
        <label for="JQueryAccessibleTree-WidgetTitle">Widget Title: </label>
        <input type="text" id="JQueryAccessibleTree-WidgetTitle" name="JQueryAccessibleTree-WidgetTitle" value="<?php echo $options['title'];?>" />
        <input type="hidden" id="JQueryAccessibleTree-SubmitTitle" name="JQueryAccessibleTree-SubmitTitle" value="1" />
    </p>
    <p>
        <label for="JQueryAccessibleTree-WidgetCategories">Translation for "Categories": </label>
        <input type="text" id="JQueryAccessibleTree-WidgetCategories" name="JQueryAccessibleTree-WidgetCategories" value="<?php echo $options['categories'];?>" />
        <input type="hidden" id="JQueryAccessibleTree-SubmitCategories" name="JQueryAccessibleTree-SubmitCategories" value="1" />
    </p>
    <p>
        <label for="JQueryAccessibleTree-WidgetMeta">Translation for "Meta": </label>
        <input type="text" id="JQueryAccessibleTree-WidgetMeta" name="JQueryAccessibleTree-WidgetMeta" value="<?php echo $options['meta'];?>" />
        <input type="hidden" id="JQueryAccessibleTree-SubmitMeta" name="JQueryAccessibleTree-SubmitMeta" value="1" />
    </p>
    <p>
        <label for="JQueryAccessibleTree-WidgetRecentPosts">Translation for "Recent Posts": </label>
        <input type="text" id="JQueryAccessibleTree-WidgetRecentPosts" name="JQueryAccessibleTree-WidgetRecentPosts" value="<?php echo $options['recentPosts'];?>" />
        <input type="hidden" id="JQueryAccessibleTree-SubmitRecentPosts" name="JQueryAccessibleTree-SubmitRecentPosts" value="1" />
    </p>
    <p>
        <label for="JQueryAccessibleTree-WidgetRecentComments">Translation for "Recent Comments": </label>
        <input type="text" id="JQueryAccessibleTree-WidgetRecentComments" name="JQueryAccessibleTree-WidgetRecentComments" value="<?php echo $options['recentComments'];?>" />
        <input type="hidden" id="JQueryAccessibleTree-SubmitRecentComments" name="JQueryAccessibleTree-SubmitRecentComments" value="1" />
    </p>
    
    <?php
}

?>
