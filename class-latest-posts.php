<?php

class Latest_Posts_Plugin
{

    public function init()
    {
        add_shortcode('latest_posts', array($this, 'render_latest_posts'));
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function render_latest_posts()
    {
        $number = get_option('latest_posts_number', 5);

        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => $number,
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $output = '<ul>';
            while ($query->have_posts()) {
                $query->the_post();
                $output .= '<li>';
                $output .= '<a href="' . get_permalink() . '">' . get_the_title() . '</a> ';
                $output .= '(' . get_the_date() . ')';
                $output .= '</li>';
            }
            wp_reset_postdata();
            $output .= '</ul>';
        } else {
            $output = '<p>Tidak ada postingan.</p>';
        }

        return $output;
    }

    public function add_settings_page()
    {
        add_options_page(
            'Latest Posts Settings',
            'Latest Posts',
            'manage_options',
            'latest-posts-settings',
            array($this, 'settings_page_html')
        );
    }

    public function register_settings()
    {
        register_setting('latest_posts_settings_group', 'latest_posts_number');
        add_settings_section('section', 'Pengaturan Jumlah Postingan', null, 'latest-posts-settings');
        add_settings_field('latest_posts_number', 'Jumlah posting yang ditampilkan:', array($this, 'number_field_html'), 'latest-posts-settings', 'section');
    }

    public function number_field_html()
    {
        $value = get_option('latest_posts_number', 5);
        echo '<input type="number" name="latest_posts_number" value="' . esc_attr($value) . '" min="1" />';
    }

    public function settings_page_html()
    {
?>
        <div class="wrap">
            <h1>Pengaturan Latest Posts</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('latest_posts_settings_group');
                do_settings_sections('latest-posts-settings');
                submit_button();
                ?>
            </form>
        </div>
<?php
    }
}
