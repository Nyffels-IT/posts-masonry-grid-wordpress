<?php
/**
* Plugin Name: Masonry grid
* Plugin URI: https://github.com
* Description: A lightwight, open source masonry grid for your posts. Created and managed by Nyffels IT.
* Version: 0.0.1
* Author: Nyffels IT
* Author URI: https://nyffels-it.be
**/

add_shortcode('monastry-grid', 'mgnyf_retrieve_monastry_grid');
add_action('wp_enqueue_scripts', 'mgnyf_add_css' );
add_action('init', 'mgnyf_add_script');

function mgnyf_retrieve_monastry_grid() {
    echo '<script>console.log("The \"monastry grid\" plugin is an open sourced and free plugin created by Nyffels IT. Give us a visit at https://nyffels-it.be or contribute to the development of the plugin on the repository https://github.com")</script>';
    $args = array(
        'nopaging' => true
    );
    $posts = get_posts($args);
    mgnyf_log_as_json($posts);
    
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
                                <div class="nyfit-masonry-grid-title" style="background-color: #232220">
                                    <h3>
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