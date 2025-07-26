<?php

/**
 * Plugin Name: Latest Posts Plugin
 * Description: Menampilkan postingan terbaru menggunakan shortcode [latest_posts].
 * Version: 1.0
 * Author: Rendi
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require_once plugin_dir_path(__FILE__) . 'class-latest-posts.php';

function run_latest_posts_plugin()
{
    $plugin = new Latest_Posts_Plugin();
    $plugin->init();
}

run_latest_posts_plugin();
