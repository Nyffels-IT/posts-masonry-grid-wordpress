<?php
/**
* Plugin Name: Masonry grid
* Plugin URI: https://github.com/Nyffels-IT/masonry-grid-wordpress
* Description: A lightwight, open source masonry grid for your posts. Created and managed by Nyffels IT.
* Version: 1.0.0
* Requires at least: 6.0
* Requires PHP: 8.0
* Author: Nyffels IT
* Author URI: https://nyffels-it.be
* License: Apache 2.0
**/

add_shortcode('masonry-grid', 'mgnyf_retrieve_monastry_grid');
add_action('wp_enqueue_scripts', 'mgnyf_add_css' );
add_action('init', 'mgnyf_add_script');

function mgnyf_retrieve_monastry_grid($atts) {
    $default = array(
        'background_color' => "#000000",
        'font_color' => "#FFFFFF",
        'category' => null
    );
    $a = shortcode_atts($default, $atts);

    $args = array(
        'nopaging' => true,
        'category' => $a['category']
    );
    $posts = get_posts($args);
    
    ob_start();

    ?>        
        <div class="nyfit-masonry-grid">
            <?php
                foreach($posts as $post) {
                    $thumbnail = get_the_post_thumbnail($post);
                    ?>
                        <a href=<?php echo $post->guid; ?> class="nyfit-masonry-grid-item">
                        <div class="nyfit-masonry-grid-item">
                            <div class="nyfit-masonry-grid-content">
                                <div class="nyfit-masonry-grid-title" style=<?php echo "background-color:".$a['background_color']; ?>>
                                    <h3 style=<?php echo "color:".$a['font_color']; ?>>
                                        <?php echo $post->post_title; ?>
                                    </h3>
                                </div>
                                <?php echo $thumbnail; ?>
                            </div>
                        </div>
                        </a>
                    <?php
                }
            ?>
        </div>
    <?php

    return ob_get_clean();
}

function mgnyf_add_css() {
    wp_register_style( 'monastry-grid-style', plugins_url('masonry.css', __FILE__) );
    wp_enqueue_style( 'monastry-grid-style' );
}

function mgnyf_add_script() {
    wp_enqueue_script( 'masonry-grid-by-nyffels-it', plugins_url( '/masonry.js', __FILE__ ));
}

function mgnyf_log_as_json($vars) {
    if(is_resource($vars)) {
        return;
    }
    else {
        if($vars)
        {
            $json =  @json_encode($vars);
            print "<script>console.log($json);</script>";
        }

    }
}
