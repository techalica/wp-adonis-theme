<?php

class Theme_Setup
{
    public static function bootstrap()
    {
        self::clean();
        self::support();
        self::autoload();
        self::posts();
        self::fields();
        self::options();
        self::navigations();
    }

    protected static function autoload()
    {
        require_once get_template_directory().'/vendor/autoload.php';
    }

    protected static function posts()
    {
        add_action('init', function () {
            $custom_post_types = glob(__DIR__ . "/custom-post-type/*.php");
            foreach ($custom_post_types as $custom_post_type) {
                require_once $custom_post_type;
            }
        });
    }

    protected static function fields()
    {
        $acf_fields = glob(__DIR__ . "/acf/*.php");
        foreach ($acf_fields as $acf_field) {
            require_once $acf_field;
        }
    }

    protected static function options()
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page(
                array(
                    'page_title' => 'Options',
                    'menu_title' => 'Options',
                    'menu_slug' => 'options',
                    'capability' => 'edit_posts',
                    'redirect' => FALSE
                )
            );
        }
    }

    protected static function clean(){

        remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
        remove_action('wp_head', 'wp_generator'); // remove wordpress version

        remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
        remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links

        remove_action('wp_head', 'index_rel_link'); // remove link to index page
        remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)

        remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
        remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
        remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );

        // REMOVE WP EMOJI
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');

        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );


        remove_action( 'wp_head', 'wp_resource_hints', 2 );

        // Disable REST API link tag
        remove_action('wp_head', 'rest_output_link_wp_head', 10);

        // Disable oEmbed Discovery Links
        remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

        // Disable REST API link in HTTP headers
        remove_action('template_redirect', 'rest_output_link_header', 11, 0);


        // Remove the REST API endpoint.
        remove_action( 'rest_api_init', 'wp_oembed_register_route' );

        // Turn off oEmbed auto discovery.
        add_filter( 'embed_oembed_discover', '__return_false' );

        // Don't filter oEmbed results.
        remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

        // Remove oEmbed discovery links.
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

        // Remove oEmbed-specific JavaScript from the front-end and back-end.
        remove_action( 'wp_head', 'wp_oembed_add_host_js' );

        add_action( 'wp_enqueue_scripts',function (){
            wp_dequeue_style( 'wp-block-library' );
            wp_dequeue_style( 'wp-block-library-theme' );
        } );

    }

    public static function support(){
        add_action('after_setup_theme',function (){
            // Add theme support for Automatic Feed Links
            add_theme_support( 'automatic-feed-links' );

            // Add theme support for document Title tag
            add_theme_support( 'title-tag' );

            // Add theme support for Post Formats
            add_theme_support( 'post-formats', array('aside','image','gallery','video','audio','link','quote','status'));

            // Add theme support for Featured Images
            add_theme_support( 'post-thumbnails' );

            // Add theme support for HTML5 Semantic Markup
            add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
        });
    }

    public static function navigations(){
        add_action('after_setup_theme', function (){
            register_nav_menus(
                array('main-menu' => __('Main Menu'))
            );

            register_nav_menus(
                array('footer-menu' => __('Footer Menu'))
            );
        });
    }
}

Theme_Setup::bootstrap();
