<?php
/* Template Name: Blog Overview */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
global $wpdb;
?>

	<div <?php generate_do_attr( 'content' ); ?>>
		<main <?php generate_do_attr( 'main' ); ?>>
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			if ( generate_has_default_loop() ) {
				while ( have_posts() ) :

					the_post();

                    generate_do_template_part( 'page' );

                    $html = '';
                    $terms = custom_list_categories();
                    $cat_count = 1;

                    $html = '<div class="blog-container">
                        <section class="head_sec" id="head_sec">
                            <div class="discover_heading">
                                <h1>Discover All About Trading Articles Here</h1>
                            </div>
                            <div class="head_paragraph">
                                <p>
                                    Dictum fusce ut placerat orci nulla pellentessque. Purus ut faucibus pulvinar elementum. Libero justo laoreet sit amet cursus sit amet dictum sit quis nostrud exercitation ullamco laboris.
                                </p>
                            </div>
                        </section>
                        <section class="nav_bar_sec" id="nav_bar_sec">
                            <div class="nav-tabs">
                            <ul>
                                <li class="active tablinks">
                                    <a data-filter=".all_article">
                                        All
                                    </a>
        
                                </li>';
                                foreach ($terms as $term) {
                                    $tab_id = $term->slug;
                                    $html .= '<li class="tablinks">
                                    <a data-filter=".'.$tab_id.'">
                                    ' . $term->name . '
                                    </a>        
                                </li>';
                                }
                            $html .= '</ul>
                            <div class="input-box">
                                <div class="box">
                                    <form action="" id="posts_search_form" name="posts_search_form" class="arrow">
                                        <input type="text" id="search_keyword" name="search_keyword" placeholder="Search articles here">
                                        <input type="hidden" id="paged" name="paged" value="1">
                                        <input type="hidden" id="filter_post_cat" name="filter_post_cat" value="">
                                        <button type="submit" class="submit-arrow">
                                        <img src="'.get_stylesheet_directory_uri().'/images/right.svg" alt="Search">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </section>
                        <section class="body_sec" id="body_sec">
                            <div id="posts_content_wrap">';
                            $args = array(
                                'post_type' => 'post',
                                'posts_per_page' => 10,
                                'offset' => '0'
                            );

                            $html .= '<div class="main-box show all_article">';
                            $html .= fetch_blog_posts_by_category($args, 'show')['html'];
                            $html .= '</div>';

                            foreach ($terms as $term) {
                                $args['category_name'] = $term->slug;
                                $html .= '<div class="main-box '.$term->slug.'">';
                                //$html .= fetch_blog_posts_by_category($args);
                                $html .= '</div>';
                                $cat_count++;
                            }

                            $html .= '</div>
                            <div id="load_more_content"></div>
                            <div class="load_more_btn_wrap">
                                <div class="wp-block-button commGradBtn">
                                    <a class="wp-block-button__link wp-element-button load_more_posts">Load More 
                                        <img decoding="async" width="24" height="24" class="wp-image-60" style="width: 24px;" src="'.get_stylesheet_directory_uri().'/images/arrow-down-circle.svg" alt="Load More">
                                    </a>
                                </div>
                            </div>';

                            $html .= '</section>
                </div>';

                echo $html;

				endwhile;
			}

			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();

	get_footer();
