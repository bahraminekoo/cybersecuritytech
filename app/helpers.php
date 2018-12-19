<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    if (!is_admin() && remove_action('wp_head', 'wp_enqueue_scripts', 1)) {
        wp_enqueue_scripts();
    }

    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                    ];
                })
                ->concat([
                    "{$template}.blade.php",
                    "{$template}.php",
                ]);
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}

/**
 * Determines if string ends with a specific sub string.
 *
 * @param string $haystack The string to search in.
 * @param string $needle The sub-string to search for.
 * @return boolean
 */
function string_ends_with($haystack, $needle)
{
    $length = strlen($needle);

    return $length === 0 || (substr($haystack, -$length) === $needle);
}

/**
 * Print HTML img tag to output.
 *
 * @param array $img Array with keys "url", "alt", and "class".
 * @param string $css_class CSS class for img element.
 * @return void
 */
function print_img($img, $css_class = 'image')
{
    if ($img) {
        $css = esc_attr($css_class);
        $src = esc_url(is_array($img) ? $img['url'] : $img);
        $alt = esc_attr(is_array($img) ? $img['alt'] : '');
        echo '<img class="' . $css . ' img-fluid" src="' . $src . '" alt="' . $alt . '" />';
    }
}

/**
 * Print HTML picture tag with multiple img elements.
 *
 * @param array $imgs @see print_img.
 * @param string $css_class CSS class for picture element.
 * @return void
 */
function print_picture_many($imgs, $css_class = 'picture')
{
    $first = true;
    $has_image = false;

    foreach ($imgs as $img_class => $img) {
        if ($img) {
            if ($first) {
                echo '<picture class="' . esc_attr($css_class) . '">';
                $first = false;
                $has_image = true;
            }
            print_img($img, $img_class);
        }
    }

    if ($has_image) {
        echo '</picture>';
    }
}

/**
 * Print HTML picture with one img tag to output.
 *
 * @param array $img @see print_img.
 * @param string $css_class CSS class for picture element.
 * @param string $img_class CSS class for img element.
 * @return void
 */
function print_picture($img, $css_class = 'picture', $img_class = 'image')
{
    print_picture_many([$img_class => $img], $css_class);
}

/**
 * Print HTML picture with one img tag to output. Image properties read from sub field.
 *
 * @param string $field_name Name of image sub field.
 * @param string $css_class CSS class for picture element.
 * @param string $img_class CSS class for img element.
 * @return void
 */
function print_picture_sub_field($field_name, $css_class = 'picture', $img_class = 'image')
{
    print_picture(get_sub_field($field_name), $css_class, $img_class);
}

/**
 * Print HTML picture with multiple img tags for each responsive breakpoint. Reads images from sub fields.
 *
 * @param boolean|array $imgs If not provided reads images from sub fields "image", "image_tablet", and "image_mobile". Otherwise expects array with keys "default", "tablet", and "mobile" and subkeys "field" and "class".
 * @param string $css_class CSS class for picture element.
 * @return void
 */
function print_picture_responsive($imgs = false, $css_class = 'picture')
{
    if (!$imgs) {
        $imgs = [
            'default' => [
                'field' => 'image_desktop',
                'class' => 'image image-desktop',
            ],
            'tablet' => [
                'field' => 'image_tablet',
                'class' => 'image image-tablet',
            ],
            'mobile' => [
                'field' => 'image_mobile',
                'class' => 'image image-mobile',
            ],
        ];
    }
    $img = get_sub_field($imgs['default']['field']);
    $img_tablet = get_sub_field($imgs['tablet']['field']);
    $img_tablet = $img_tablet ? $img_tablet : $img;
    $img_mobile = get_sub_field($imgs['mobile']['field']);
    $img_mobile = $img_mobile ? $img_mobile : $img_tablet;
    $default_class = $imgs['default']['class'] . ' visible-desktop-only';
    $tablet_class = $imgs['tablet']['class'] . ' visible-tablet-only';
    $mobile_class = $imgs['mobile']['class'] . ' visible-mobile-only';
    print_picture_many(
        [
            $default_class => $img,
            $tablet_class => $img_tablet,
            $mobile_class => $img_mobile,
        ],
        $css_class
    );
}

/**
 * Print text field HTML.
 *
 * @param string $field Field name.
 * @param string $css_class CSS class for HTML element.
 * @return void
 */
function print_text_field($field = 'text', $css_class = 'text')
{
    print_text(get_field($field), $css_class);
}


/**
 * Print text sub field HTML.
 *
 * @param string $field Sub field name.
 * @param string $css_class CSS class for HTML element.
 * @return void
 */
function print_text_sub_field($field = 'text', $css_class = 'text')
{
    print_text(get_sub_field($field), $css_class);
}

/**
 * Print heading field HTML.
 *
 * @param string $field Field name.
 * @param string $css_class CSS class for HTML element.
 * @return void
 */
function print_title_field($field = 'title', $css_class = 'heading', $heading_elem = 'h1')
{
    print_heading(get_field($field), $css_class, $heading_elem);
}

/**
 * Print heading field HTML.
 *
 * @param string $field Field name.
 * @param string $css_class CSS class for HTML element.
 * @return void
 */
function print_title_sub_field($field = 'title', $css_class = 'heading', $heading_elem = 'h1')
{
    print_heading(get_sub_field($field), $css_class, $heading_elem);
}

/**
 * Print text HTML.
 *
 * @param string $text Text.
 * @param string $css_class CSS class for HTML element.
 * @return void
 */
function print_text($text, $css_class = 'text')
{
    if ($text) {
        echo '<p class="' . esc_attr($css_class) . '">';
        echo $text;
        echo '</p>';
    }
}

/**
 * Print a heading in HTML.
 *
 * @param string $text Text.
 * @param string $css_class CSS class for HTML element.
 * @return void
 */
function print_heading($text, $css_class = 'heading', $heading_elem = 'h1')
{
    if ($text) {
        echo '<' . $heading_elem . ' class="' . esc_attr($css_class) . '">';
        echo $text;
        echo '</' . $heading_elem . '>';
    }
}

function print_style_background_color($field = 'background_color')
{
    $background_color = get_sub_field($field);
    $style = ($background_color) ?
        "background-color: " . $background_color :
        "";
    echo $style;
}

function print_style_color($field = 'color')
{
    $color = get_sub_field($field);
    $style = ($color) ?
        "color: " . $color :
        "";
    echo $style;
}
