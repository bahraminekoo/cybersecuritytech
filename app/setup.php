<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}, 100);

add_theme_support( 'custom-header', array(
    'video' => true,
) );

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage')
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});

/**
 * Only show Custom Fields admin page on ".local" address.
 */
add_filter('acf/settings/show_admin', function () {
    $site_url = get_bloginfo('url');

    if (string_ends_with($site_url, '.local')) {
        return true;
    } else {
        return false;
    }
});


/**
 * Allow SVG uploads.
 */
add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';

    return $mimes;
});

function cptui_register_my_cpts_resource()
{
    /**
     * Post Type: Resources.
     */

    $labels = array(
        "name" => __("Resources", "cyberproof"),
        "singular_name" => __("Resource", "cyberproof"),
    );

    $args = array(
        "label" => __("Resources", "cyberproof"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "has_archive" => false,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "page",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array("slug" => "resource", "with_front" => true),
        "query_var" => true,
        "menu_icon" => "dashicons-media-document",
        "supports" => array("title", "editor", "thumbnail", "custom-fields"),
    );

    register_post_type("resource", $args);
}

/**
 * Add option pages.
 */
add_action('acf/init', function () {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => __('Cyberproof Theme Settings', 'cyberproof'),
            'menu_title' => __('Cyberproof Settings', 'cyberproof'),
            'menu_slug' => 'cyberproof-settings',
        ));

        acf_add_options_sub_page(array(
            'page_title' => __('General Settings', 'cyberproof'),
            'menu_title' => __('General', 'cyberproof'),
            'parent_slug' => 'cyberproof-settings',
        ));
    }

    cptui_register_my_cpts_resource();
});

// Register footer widgets on the widgets_init hook.
add_action('widgets_init', function () {
    // First Middle Footer widget area.
    register_sidebar(array(
        'name' => __('First Footer Widget Area', 'cyberproof'),
        'id' => 'first-footer-widget-area',
        'description' => __('Use a text widget and added a header and ul in the body for all these footer sections, thanks', 'cyberproof'),
        'before_widget' => '<div id="first-footer-widget-area" class="col-auto">',
        'after_widget' => '</div>',
        'before_title' => '<h6 class="foot-wg-title">',
        'after_title' => '</h6>',
    ));

    // Second Middle Footer Widget Area.
    register_sidebar(array(
        'name' => __( 'Second Footer Widget Area', 'cyberproof'),
        'id' => 'second-footer-widget-area',
        'description' => __('Use a text widget and added a header and ul in the body for all these footer sections, thanks', 'cyberproof'),
        'before_widget' => '<div id="second-footer-widget-area" class="col-auto">',
        'after_widget' => '</div>',
        'before_title' => '<h6 class="foot-wg-title">',
        'after_title' => '</h6>',
    ));

    // Third Middle Footer Widget Area.
    register_sidebar(array(
        'name' => __( 'Third Footer Widget Area', 'cyberproof'),
        'id' => 'third-footer-widget-area',
        'description' => __('Use a text widget and added a header and ul in the body for all these footer sections, thanks', 'cyberproof'),
        'before_widget' => '<div id="third-footer-widget-area" class="col-auto">',
        'after_widget' => '</div>',
        'before_title' => '<h6 class="foot-wg-title">',
        'after_title' => '</h6>',
    ));

    // Fourth Middle Footer Widget Area.
    register_sidebar(array(
        'name' => __( 'Fourth Footer Widget Area', 'cyberproof'),
        'id' => 'fourth-footer-widget-area',
        'description' => __('Use a text widget and added a header and ul in the body for all these footer sections, thanks', 'cyberproof'),
        'before_widget' => '<div id="fourth-footer-widget-area" class="col-auto">',
        'after_widget' => '</div>',
        'before_title' => '<h6 class="foot-wg-title">',
        'after_title' => '</h6>',
    ));

    // Fifth Middle Footer Widget Area.
    register_sidebar(array(
        'name' => __('Fifth Footer Widget Area', 'cyberproof'),
        'id' => 'fifth-footer-widget-area',
        'description' => __('Use a text widget and added a header and ul in the body for all these footer sections, thanks', 'cyberproof'),
        'before_widget' => '<div id="fifth-footer-widget-area" class="col-auto">',
        'after_widget' => '</div>',
        'before_title' => '<h6 class="foot-wg-title">',
        'after_title' => '</h6>',
    ));

    // Sixth Middle Footer Widget Area.
    register_sidebar(array(
        'name' => __('Sixth Footer Widget Area', 'cyberproof'),
        'id' => 'sixth-footer-widget-area',
        'description' => __('Use a text widget, add no header but put an h6 tag with the heading (the socials links will be added on the admin panel under the theme settings), thanks', 'cyberproof'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h6 class="foot-wg-title">',
        'after_title' => '</h6>',
    ));

});
