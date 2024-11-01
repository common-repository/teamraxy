<?php
/*
Plugin Name: TeamRaxy
Plugin URI: http://www.dotsquares.com/
Description:  TeamRaxy plugin for custom-post types
Version: 3.0
Author: MythBusters
Plugin URI: http://linuxdemo.projectstatus.co.uk/wordpresspplugin/teamRaxy.zip 
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*=================================*/
/* Nivo Slider - ​http://dev7studios.com
/* License: Distributed under the terms of the License Name
/* Copyright: Gilbert Pellegrom, http://dev7studios.com
/*=================================*/


add_action( 'init', 'create_custom_post_types' );

function create_custom_post_types() {
	/** custom post type for Slider */
	$labelss = array(
    'name' => __('Slider','slider_textdomain'),
    'singular_name' => __('Slider', 'slider_textdomain'),
    'add_new' => __('Add New', 'slider_textdomain'),
    'add_new_item' => __('Add New Link','slider_textdomain'),
    'edit_item' => __('Edit Link','slider_textdomain'),
    'new_item' => __('New Link','slider_textdomain'),
    'all_items' => __('All Links','slider_textdomain'),
    'view_item' => __('View Link','slider_textdomain'),
    'search_items' => __('Search Links','slider_textdomain'),
    'not_found' =>  __('No Links found','slider_textdomain'),
    'not_found_in_trash' => __('No Links found in Trash','slider_textdomain'),
	);
  
  
  
        $argss = array(  
            'labels' => $labelss,   
            'public' => true,  
            'show_ui' => true,
            'capability_type' => 'post',  
            'hierarchical' => false,  
			'has_archive' => 'slider', 
		    'rewrite' => true,
			'supports' => array('title','editor','author','thumbnail','excerpt','comments','custom_type')  
           );  
      
        register_post_type( 'slider' , $argss ); 
	
	
	/** custom post type for Portfolio */
	
	$labels = array(
    'name' => __('Portfolio','portfolio_textdomain'),
    'singular_name' => __('Portfolio', 'portfolio_textdomain'),
    'add_new' => __('Add New', 'portfolio_textdomain'),
    'add_new_item' => __('Add New Link','portfolio_textdomain'),
    'edit_item' => __('Edit Link','portfolio_textdomain'),
    'new_item' => __('New Link','portfolio_textdomain'),
    'all_items' => __('All Links','portfolio_textdomain'),
    'view_item' => __('View Link','portfolio_textdomain'),
    'search_items' => __('Search Links','portfolio_textdomain'),
    'not_found' =>  __('No Links found','portfolio_textdomain'),
    'not_found_in_trash' => __('No Links found in Trash','portfolio_textdomain'),
);
  
  
  
        $args = array(  
            'labels' => $labels,   
            'public' => true,  
            'show_ui' => true,
            'capability_type' => 'post',  
            'hierarchical' => false,  
			'has_archive' => 'portfolio', 
		    'rewrite' => true,
			'supports' => array('title','editor'/*,'author','thumbnail','excerpt','comments','custom_type'*/)  
           );  
      
        register_post_type( 'portfolio' , $args );
	
}


	/**
	  * include nivo slider css and jquery
	**/ 
	
	function includeJqueryCss(){
			wp_enqueue_style('default', plugins_url('css/nivo/default/default.css', __FILE__ ));
			wp_enqueue_style('light', plugins_url('css/nivo/light/light.css', __FILE__ ));
			wp_enqueue_style('dark', plugins_url('css/nivo/dark/dark.css', __FILE__ ));
			wp_enqueue_style('bar', plugins_url('css/nivo/bar/bar.css', __FILE__ ));
			wp_enqueue_style('nivo-slider', plugins_url('css/nivo/nivo-slider.css', __FILE__ ));
			//wp_enqueue_script('jquery');
			if(!is_admin()) {
				wp_enqueue_script( 'jquery-1.9.0.min', plugins_url('js/jquery-1.9.0.min.js', __FILE__ ));
				wp_enqueue_script('jquery.nivo.slider', plugins_url('js/jquery.nivo.slider.js', __FILE__ ));
			}
			
	}


	/**
	  * create shortcode: for slider
	**/ 
	
	function postSlider_func() { ?>
		  <div class="slider-wrapper theme-default" style="margin-bottom:-120px;">
				<?php
					 // The Query
					 $the_query = new WP_Query(array('post_type' => 'slider'));
					// echo "<pre>";print_r($the_query);die;
				 if ( $the_query->have_posts() ) {
					 $i=1;
		
				?>
				
				<div id="slider" class="nivoSlider">
				<?php 
						while ( $the_query->have_posts() ) {
							 $the_query->the_post();
							$image_query = new WP_Query( array( 'post_type' => 'attachment','post_status' => 'inherit', 'post_mime_type' => 'image',  'post_parent' => get_the_ID() ) );
							$image_query->have_posts();
							$image_query->the_post();
				?>
				<img src="<?php echo wp_get_attachment_url( get_the_ID() ) ;?>" alt="" <?php  echo "title="."#htmlcaption".$i ; ?> />
				<?php
							$i++;
							}
				?>
				
				
				 
				</div>
				<?php } //end of  if ( $the_query->have_posts() )  ?>
				
				<?php 
						$i=1;
						while ( $the_query->have_posts() ) : $the_query->the_post();?>
		
					 <div <?php  echo "id="."htmlcaption".$i ; ?> class="nivo-html-caption">
							<span>
							 
							  <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
							<?php  the_excerpt();  ?> 
							 </span>
					</div>	
	
				<?php    $i++; endwhile;   ?>
				
			   
		
		</div> <!--end of slider-wrapper-->
		<script type="text/javascript">
		$(window).load(function() {
			$('#slider').nivoSlider();
		});
		</script>
		<?php
	}


	/**
	  * create shortcode: for portfolio
	**/ 
	
	function portFolio_func(){
		$the_query = new WP_Query(array('post_type'=>'portfolio'));
		if($the_query->have_posts()){
			while($the_query->have_posts()){
			$the_query->the_post();
			$postsid = get_the_ID();
			
			$attachmentImage = query_posts(array('post_type'=>'attachment','post_status'=>'inherit','posts_per_page' => 1,'post_mime_type' => 'image','post_parent'=>get_the_ID()));
				if(have_posts()){
					the_post();
					$image_attributes = wp_get_attachment_image_src(get_the_ID());
				
				  
				  $displaySpecificPost =  new WP_Query( array('post_type'=>'portfolio','post__in' => array($postsid)) );
				  if($displaySpecificPost->have_posts()){ $displaySpecificPost->the_post();		
			?>
						<article style="height: 210px;">
					
						
						<a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>">
						<img style="opacity: 1;" src="<?php echo $image_attributes[0] ?>" height="210" width="210">
						<span class="mask">
								<span class="content">
									<span class="title"><?php the_title_attribute() ?></span>
									in						<span class="tags">Photography</span>
								</span>
							</span>
						</a>
			
					
					
					</article>	
					
					<?php
				  }
				}
			
			}
			
		}
	}

add_action('init', 'includeJqueryCss');
add_shortcode('postSlider', 'postSlider_func');
add_shortcode('portFolio', 'portFolio_func');

