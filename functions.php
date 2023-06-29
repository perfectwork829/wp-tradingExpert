<?php
/*
 * This is the child theme for GeneratePress theme, generated with Generate Child Theme plugin by catchthemes.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */
add_action('wp_enqueue_scripts', 'generatepress_child_enqueue_styles');
function generatepress_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style'),
        filemtime( get_stylesheet_directory() . '/style.css' )
    );

    wp_enqueue_style(
        'owl-minnimum-style',
        get_stylesheet_directory_uri() . '/owl-css/owl.carousel.min.css',
        array('parent-style'),
        filemtime( get_stylesheet_directory() . '/owl-css/owl.carousel.min.css' )
    );

    /*wp_enqueue_style(
        'custumstyle',
        get_stylesheet_directory_uri() . '/css/custumstyle.css',
        array('parent-style'),
        filemtime( get_stylesheet_directory() . '/css/custumstyle.css' )
    );*/

    wp_enqueue_style(
        'tx-common',
        get_stylesheet_directory_uri() . '/css/common.css',
        array('parent-style'),
        filemtime( get_stylesheet_directory() . '/css/common.css' )
    );

    wp_enqueue_style(
        'child-header',
        get_stylesheet_directory_uri() . '/css/header.css',
        array('parent-style'),
        filemtime( get_stylesheet_directory() . '/css/header.css' )
    );

    wp_enqueue_style(
        'child-footer',
        get_stylesheet_directory_uri() . '/css/footer.css',
        array('parent-style'),
        filemtime( get_stylesheet_directory() . '/css/footer.css' )
    );

    if( is_front_page() ) {
        wp_enqueue_style(
            'tx-home',
            get_stylesheet_directory_uri() . '/css/home.css',
            array('parent-style'),
            filemtime( get_stylesheet_directory() . '/css/home.css' )
        );
    }

    if ( is_single()) {
        wp_enqueue_style(
            'blog-single',
            get_stylesheet_directory_uri() . '/css/blog-single.css',
            array('parent-style'),
            filemtime( get_stylesheet_directory() . '/css/blog-single.css' )
        );
    }
    if ( is_page_template('tpl-blog.php')) {
        wp_enqueue_style(
            'blog-overview',
            get_stylesheet_directory_uri() . '/css/blog-overview.css',
            array('parent-style'),
            filemtime( get_stylesheet_directory() . '/css/blog-overview.css' )
        );
    }
    if ( is_page('services-2')) {
        // Enqueue block editor styles
        wp_enqueue_style(
            'tx-service-css',
            get_stylesheet_directory_uri() . '/css/services.css',
            array('parent-style'),
            filemtime( get_stylesheet_directory() . '/css/services.css' )
        );
    }
}

/**
 * Enqueue frontend and editor JavaScript and CSS
 */
function tx_block_plugin_scripts() {	
    
}

// Hook the enqueue functions into the frontend and editor
add_action( 'enqueue_block_assets', 'tx_block_plugin_scripts' );

function popper_enqueue_styles()
{
    wp_enqueue_script('js-custom', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), '', true);
    wp_enqueue_script('css-carousel-js', get_stylesheet_directory_uri() . '/js/owl.carousel.js', array(), '', true);
    wp_enqueue_script('glitebox-js', get_stylesheet_directory_uri() . '/js/glightbox.js', array(), '', true);
    wp_enqueue_script('tab-js', get_stylesheet_directory_uri() . '/js/tab.js', array(), '', true);
    wp_enqueue_script('pkdf-js', get_stylesheet_directory_uri() . '/js/isotope.pkgd.js', array(), '', true);
    wp_localize_script('js-custom', 'tx_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}



add_action('wp_enqueue_scripts', 'popper_enqueue_styles', 999);
/*
 * Your code goes below
 */



add_action('init', 'testimonials_post_type');
function testimonials_post_type()
{
    $labels = array(
        'name' => 'Testimonials',
        'singular_name' => 'Testimonial',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Testimonial',
        'edit_item' => 'Edit Testimonial',
        'new_item' => 'New Testimonial',
        'view_item' => 'View Testimonial',
        'search_items' => 'Search Testimonials',
        'not_found' =>  'No Testimonials found',
        'not_found_in_trash' => 'No Testimonials in the trash',
        'parent_item_colon' => '',
    );

    register_post_type('testimonials', array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'exclude_from_search' => false,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => true,
        'menu_position' => 8,
        'supports' => array('title', 'editor', 'thumbnail'),
    ));
}

/* ----------post category list---------*/

add_shortcode('category_list', 'category_list_function');
function category_list_function()
{

    $categories = custom_list_categories();
    
  
    $html = '<div class="tabSelect tgfh">
        <select>
            <option data-filter=".all_category">All Category</option>';
    foreach ($categories as $category) {
      
        $html .= '<option data-filter=".' . $category->slug . '">' . $category->name . '</option>';
    }
    $html .= '</select>
    </div>';
    return $html;
}

add_shortcode('testimonial_carosol', 'testimonial_carosol_function');
function testimonial_carosol_function()
{
    $html = '<div class="owl-carousel owl-theme testimonial_slider" id="testislider">';
    $args = array('post_type' => 'testimonials');
    $loop = new WP_Query($args);
    while ($loop->have_posts()) : $loop->the_post();
        $feat_image = wp_get_attachment_url(get_post_thumbnail_id());
        $content = get_the_content();
        $out = strlen($content) > 150 ? substr($content, 0, 150) . "..." : $content;
        $html .= '<div class="item">
                <div class="testi_authorCard">
                    <div class="authorDescription">
                        <p>' . $out . '</p>
                    </div>
                    <div class="bottomPart">
                        <img class="authorImag" src="' . $feat_image . '">
                        <h3 class="authorName">' . get_the_title() . '</h3>
                    </div>
                </div>
            </div>';
    endwhile;
    $html .= '</div>';
    return $html;
}
function counter_shortcode_function($_atts)
{
    $defaults = array(
        'number' => '',
    );
    $atts = shortcode_atts($defaults, $_atts);
    $html = '<div class="counter_flex"><h1 class="wp-block-heading has-text-align-left counter has-white-color has-text-color" style="font-size:72px">' . $atts['number'] . 'k</h1><span>+</span></div>';
    return $html;
}
add_shortcode("counter", "counter_shortcode_function");

function category_post_tab_list_function($_atts)
{
    $html = '';
    $terms = custom_list_categories();

    $html .= '<div class="first-box">
    <div class="grid-container">
        <h2 class="subtitle">
            BEST TRADING KNOWLEDGE
        </h2>
        <h2 class="common_heading">
            Our Most Popular Articles
        </h2>
        <div class="nav-tabs">
            <ul>
                <li class="active">
                    <a data-filter=".all_category">All Category</a>
                </li>';
                foreach ($terms as $cat) {
                    $html .= '<li><a data-filter=".' . $cat->slug . '">' . $cat->name . '</a></li>';
                }
            $html .= '</ul>
        </div>';
		
		
		
		$html .= do_shortcode( '[category_list]' );

        $getdata = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 4,
        );

        $query = new WP_Query($getdata);

        $html .= '<div class="all-grid all_category show">';
        $html .= fetch_posts_data_by_cat( $query );
        $html .= '</div>';

        $cat_count = 1;
        foreach ($terms as $cat) {
            $cat_id = $cat->term_id;
            $cat_class = $cat->slug;
            $getdata['cat'] = $cat_id;
            $query = new WP_Query($getdata);

            $html .= '<div class="all-grid '.$cat_class.'">';
            $html .= fetch_posts_data_by_cat( $query );
            $html .= '</div>';
            $cat_count++;
        }
    //}

    $html .= '</div>
    </div></div>';

    wp_reset_query();
    wp_reset_postdata();

    return $html;
}
add_shortcode("category_post_tab_list", "category_post_tab_list_function");

add_action('wp_ajax_nopriv_all_article_search', 'all_article_callback');
add_action('wp_ajax_all_article_search', 'all_article_callback');

function all_article_callback()
{
    // print_r('dfbsdj');
    // die;
    $terms = get_terms(array(
        'taxonomy' => 'category',
        'hide_empty' => true,
    ));
    $html = '';

    $html .= '<div class="tab">';
    $tab_id = "'all_article'";
    $html .= '<button class="tablinks" onclick="openCity(event, ' . $tab_id . ')">All Category</button>';
    foreach ($terms as $term) {
        $tab_id = "'" . $term->slug . "'";
        $html .= '<button class="tablinks" onclick="openCity(event, ' . $tab_id . ')">' . $term->name . '</button>';
    }
    $html .= '<form role="search" method="post" id="searchform" class="searchform" action="' . esc_url(home_url('/')) . '">
                <div>
                    <label class="screen-reader-text" for="s">' . _x('Search for:', 'label') . '</label>
                    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
                    <input type="submit" id="searchsubmit" value="' . esc_attr_x('Search', 'submit button') . '" />
                </div>
            </form>';
    $html .= ' </div>
              <div id="all_article" class="tabcontent">';
    $html .= '</div>';

    foreach ($terms as $term) {
        $html .= '<div id="' . $term->slug . '" class="tabcontent">';
        $args = array(
            'category_name' => $term->slug,
            'post_type' => 'post',
            'posts_per_page' => 9,
        );

        $the_query = new WP_Query($args);
        $i = 1;
        while ($the_query->have_posts()) :
            $the_query->the_post();
            $thumb_id = get_post_thumbnail_id(get_the_ID());

            if ('' != $thumb_id && 1 != $thumb_id) {

                $image_data = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');

                $image_url = $image_data[0];
            } else {

                $image_url = get_stylesheet_directory_uri() . "/images/default.png";
            }

            if ($i == 1) {
                $html .= '<div class="article_box_first">
                            <div class="article_content">
                                <img src="' . $image_url . '"/>
                                <div class="article_category">
                                    <h4 class="cat_name">' . $term->name . '</h4>                             
                                    <a href="' . get_permalink() . '" rel="bookmark">' . get_the_date() . '</a> 
                                </div>
                                <div class="article_title">
                                 <h3>  <a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a> </h3>                                                                                          
                                </div>
                            </div>                       
                        </div>';
            } else {
                $html .= '<div class="article_box">
                            <div class="article_content">
                                <img src="' . $image_url . '"/>
                                <div class="article_category">
                                    <h4 class="cat_name">' . $term->name . '</h4>                             
                                    <a href="' . get_permalink() . '" rel="bookmark">' . get_the_date() . '</a> 
                                </div>
                                <div class="article_title">
                                 <h3><a href="' . get_permalink() . '" rel="bookmark"> ' . get_the_title() . '</a> </h3>                                                                             
                                </div>
                            </div>                       
                        </div>';
            }
            $i++;
        endwhile;
        wp_reset_postdata();
        $html .= '</div>';
    }


    return $html;
}
add_shortcode("all_article", "all_article_callback");

function fetch_posts_data_by_cat( $query ){
    $html = '';
    if ($query->have_posts()) {

        $count = 1;
        while ($query->have_posts()) {
            $query->the_post();

            $thumb_id = get_post_thumbnail_id(get_the_ID());

            if ('' != $thumb_id && 1 != $thumb_id) {

                $image_data = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');

                $image_url = $image_data[0];
            } else {

                $image_url = get_stylesheet_directory_uri() . "/images/default.png";
            }

            $postid = get_the_ID();    
            $post_terms = get_the_category();
            $terms_html = '';

            $term = $post_terms[0];
            if( $term ) {
                $terms_html .= '<div class="t-for">
                <a href="'.get_category_link($term->term_id).'">' . $term->name . '</a>
                </div>';
            }

            if( $count == 1 ) {

                $html .= '<div class="first-grid-box" style="background-image: url('.$image_url.');">
                    <div class="bg_first_overlay"></div>
                    <div class="treding tred-1">
                        <div class="t-big">
                        '. $terms_html .'
                        </div>';
                        $html .= '</div>
                    <div class="bg-dark">
                        <div class="sub-title">
                            <h1>
                            <a href="' . get_permalink() . '">'.get_the_title().'</a>
                            </h1>
                        </div>
                    </div>
                </div>';

                $count++;
                continue;
            
            } 

            if($count == 2) {
                $html .= '<div class="second-grid-box">';
            }

            $html .= '<div class="ipsam">
                <div class="first-ipsum" style="background-image: url('.$image_url.');"></div>
                <div class="treding">
                    <div class="t-big">
                        '. $terms_html .'
						<div class="date">
						<img class="date_icon" src="'.get_stylesheet_directory_uri().'/images/calendor1.svg">
                        <span>' . get_the_date() . '</span>
						</div>
                        
                    </div>
					<h1 class="posthead">
                        <a href="' . get_permalink() . '">'.get_the_title().'</a>
                    </h1>
                    
                </div>
            </div>';

            if($count == 4) {
            $html .= '</div>';
            }

            $count++;
        }
    }
    
    return $html;
}

function custom_list_categories() {
    $categories = get_categories(array(
        'hide_empty' => true,
        'meta_key'=>'category_order',
        'orderby'=>'meta_value_num',
        'order'=>'ASC'
    ));
    $uncategorized_id = get_cat_ID( 'Uncategorized' );
//    echo "<pre>";
//    print_r($categories);

    foreach ( $categories as $key => $category ) {

        if ( $category->category_parent == $uncategorized_id
                || $category->cat_ID == $uncategorized_id ) {
            unset($categories[$key]);
        }
    }

    return $categories;
}

function fetch_blog_posts_by_category($args, $show = false){
    global $wpdb;
    $html = $load_more = '';
    $return            = array();
    $paged             = isset($args['paged']) ? $args['paged'] : 1;
    $args['tax_query'] = array(
                            array(
                                'taxonomy' => 'category',
                                'field'    => 'slug',
                                'terms'    => 'uncategorized',
                                'operator' => 'NOT IN',
                            ),
                        );
    $the_query      = new WP_Query($args);
    $i              = 1;
    $found_posts    = $the_query->found_posts;
    $offset         = $args['offset'];
    $posts_per_page = $args['posts_per_page'];
    $remaining_post = $the_query->found_posts-$offset-$posts_per_page;
    $load_more      =  ($remaining_post < 1 ? 'hide' : 'show');
    $return['load_more'] = $load_more;

    if( $the_query->have_posts() ) :
    
        while ($the_query->have_posts()) :
            $the_query->the_post();
            $thumb_id = get_post_thumbnail_id(get_the_ID());
            $post_terms = get_the_category();
            $term_html = '';

            if ('' != $thumb_id && 1 != $thumb_id) {                        
                $image_data = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');                        
                $image_url = $image_data[0];
            } else {                        
                $image_url = get_stylesheet_directory_uri() . "/images/default.png";
            }

            $cat = $post_terms[0];

            if($cat){
                $term_html .= '<p><a href="'.get_category_link($cat->term_id).'">' . $cat->name . '</a></p>';
            }

            $description = wp_strip_all_tags(get_the_content());
            $desc= expert_length($description, 270);
          
            if ($i == 1 && $paged == 1) {
            $html .= '<div class="box1">
                <div class="pic">
                    <img src="' . $image_url . '" alt="' . get_the_title() . '">
                </div>
                <div class="main_detail"> 
                    <div class="main_detail_btn">
                        '. $term_html .'
                    </div>
                    <div class="main_detail_heading">
                        <h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>
                    </div>

                    <div class="main_detail_para">
                        <p>'.$desc.'</p>
                      
                    </div>							
                    <div class="main_detail_userinfo">
                        <div class="userimg">
                            '. get_avatar(get_the_author_meta( 'ID' )) .'
                        </div>
                        <div class="username">
                            <p class="name">'.get_the_author().'</p>
                            <p class="doj">' . get_the_date() . '</p>
                        </div>
                    </div>
                </div>
            </div>';
            } else {
                $html .= '<div class="box2">
                    <div class="pic">
                        <div class="icon-hover overlay">
                            <a href="' . get_permalink() . '" class="text">
                                <img src="'. get_stylesheet_directory_uri() .'/images/right-next.svg" alt="' . get_the_title() . '">
                            </a>
                        </div>
                        <img src="' . $image_url . '">
                    </div>
                    <div class="main_detail">
                        <div class="upper">
                            <div class="main_detail_btn">
                                '. $term_html .'
                            </div>
                            <div class="calender ">
							<img class="date_icon" src="'.get_stylesheet_directory_uri().'/images/calendor1.svg">
                            <p>' . get_the_date() . '</p>
                            </div>
                        </div>
                        <div class="main_detail_heading">
                        <h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>
                        </div>
                        <div class="main_detail_para">
                            <p>'.get_the_excerpt().'</p>
                        </div>							
                    </div>
                </div>';
            }

            $i++;
        endwhile;
        wp_reset_postdata();
        
        $return['html'] = $html;

    else :

        $html .= '<div class="no_content_found">No article found.</div>';
        $return['load_more'] = 'hide';
        $return['html'] = $html;

    endif;

    return $return;
}

add_action( 'wp_ajax_nopriv_tx_load_more_posts', 'tx_load_more_posts_ajax' );
add_action( 'wp_ajax_tx_load_more_posts', 'tx_load_more_posts_ajax' );
function tx_load_more_posts_ajax(){
    $paged = isset($_POST['paged']) ? $_POST['paged'] : 1;
    $paged++;
    $posts_per_page = ($paged == 1 ? 10 : 9);
    $category = isset($_POST['cat']) ? $_POST['cat'] : '';
    $category = str_replace('.', '', $category);
    $category = str_replace('all_article', '', $category);
    $search = isset($_POST['search']) ? $_POST['search'] : '';
    $category_class = '';
    $offset = ($paged - 1) * $posts_per_page;
    $offset = ($paged > 1 ? $offset+1 : $offset);
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'offset' => $offset,
    );
    if($category) {
        $args['category_name'] = $category;
        $category_class = '.' . $category;
    }
    if($search) {
        $args['s'] = $search;
    }

    $blog_post = fetch_blog_posts_by_category($args, 'show');
    $html = $blog_post['html'];

    $data = array(
        'remaining_posts' => $blog_post['load_more'],
        'html' => $html,
        'paged' => $paged,
        'category' => $_POST['cat'],
        'search' => $search,
    );
    echo json_encode($data);
    wp_die();
}

function custom_excerpt_length( $length ) {
    return 12;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// Changing excerpt more
function new_excerpt_more($more) {
    global $post;
    remove_filter('excerpt_more', 'new_excerpt_more'); 
    return ' ...';
}
add_filter('excerpt_more','new_excerpt_more',999);


function expert_length($description , $length){
    $desc = strlen($description) > $length ? substr($description,0,$length)."..." : $description;
    return $desc;
    
}

add_filter('comment_form_default_fields', 'website_remove', 999);
function website_remove($fields)
{
    if(isset($fields['url']))
    unset($fields['url']);
    return $fields;
}

add_shortcode('display_post_comment', 'display_comments_shortcode');
function display_comments_shortcode($atts) {
    ob_start();                     
    echo '<div class="comments-pagination"><div class="slider_loader d_none" id="slider_loader" style="z-index:999;"><div class="loader"></div></div><ol class="commentlist" id="single_commentlist">';
    echo single_post_comments();
    echo '</ol></div>';
    return ob_get_clean();
}

function single_post_comments(){
    $page              = isset($_POST['page']) ? $_POST['page'] : 1;
    $post_id           = isset($_POST['post_id']) ? $_POST['post_id'] : get_the_ID();
    $per_page          = get_option( 'comments_per_page' );
    $total_comments    = get_comments_number($post_id);
    $total_pages       = ceil($total_comments / $per_page);
    $args = array(
        'post_id' => $post_id,
        'status'  => 'approve',
        'offset'  => ($page - 1) * $per_page,
        'number'  => $per_page,
    );
    $comments = get_comments($args);
    $html     = wp_list_comments(array('echo'=> false), $comments);
    $html .='<div class="pagination">';
    if ($page > 1) {
        $prev_page = $page - 1;
        $html .='<div class="prev_post pagination_btn"><a href="javascript:void(0);" class="comment_pagination prev" data-post_id="' . $post_id . '" data-page="'.$prev_page.'">Newest Comments <img src="'.get_stylesheet_directory_uri().'/images/prev_comment.png" alt="prev"></a></div>';
    }
    if ($page < $total_pages) {
        $next_page = $page + 1;
        $html .='<div class="next_post pagination_btn"><a href="javascript:void(0);" class="comment_pagination next" data-post_id="' . $post_id . '" data-page="'.$next_page.'"><img src="'.get_stylesheet_directory_uri().'/images/next_comment.png" alt="next"> Older Comments</a></div>';
    }
    $html .='</div>';
    return $html;
}

add_action('wp_ajax_load_comments', 'load_comments_ajax');
add_action('wp_ajax_nopriv_load_comments', 'load_comments_ajax');
function load_comments_ajax() {
    $post_id = $_POST['post_id'];
    $page = $_POST['page'];
    $comments_html = single_post_comments();
    $response = array(
        'comment_html' => $comments_html,
        'next_page' => $page + 1, // Provide the next page number to be used in JavaScript
        'prev_page' => $page - 1, // Provide the previous page number to be used in JavaScript
    );
    wp_send_json_success($response);
    wp_die(); 
}

// add_action('admin_head', 'post_content_css', 999);

// function post_content_css() {
//     if($_GET['post'] == '597' || $_GET['post'] == '8'){
//         echo '<style>
//             .wp-block-post-content{background: #4f1f24;} 
//         </style>';
//     }
// }



add_action( 'category_add_form_fields', 'add_category_order_field' );
add_action ( 'category_edit_form_fields', 'add_category_order_field');

function add_category_order_field( $tag ){
    $cat_order = get_term_meta( $tag->term_id, 'category_order', true );
    $default_value = !empty($cat_order) ? $cat_order : 1 ;
    ?>
    <tr class='form-field'>
        <th scope='row'><label for='cat_page_title'><?php _e('Category Order'); ?></label></th>
        <td>
            <input type='number' name='category_order' id='category_order' value='<?php echo $default_value ?>' >
            <p class='description'><?php _e('Enter the order value for the category'); ?></p>
        </td>
    </tr> <?php
};

add_action( 'created_category', 'save_category_order_field' );
add_action ( 'edited_category', 'save_category_order_field' );
function save_category_order_field( $term_id ) {
    if ( isset( $_POST['category_order'] ) )
        update_term_meta( $term_id , 'category_order', $_POST['category_order'] );
};
