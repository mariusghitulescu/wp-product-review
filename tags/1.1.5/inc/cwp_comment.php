<?php

add_action( 'comment_form_logged_in_after', 'cwp_additional_fields' );
add_action( 'comment_form_after_fields', 'cwp_additional_fields' );
add_filter('comment_text', "cwp_pac_comment_single");

function cwp_pac_comment_single($text){
			global $post;
			global $comment;
			$return = '';


			for ($i=1; $i < 6 ; $i++) { 
				$post_options[$i] = get_post_meta($post->ID, "option_{$i}_content", true);
				$comment_meta_options["comment-meta-option-{$i}"] = get_comment_meta( $comment->comment_ID, "meta_option_{$i}", true);
			} 
			$filtered_post_options = array_filter($comment_meta_options);

			if(!empty($filtered_post_options))
			{

			$return .= "<div class='user-comments-grades'>";

			$k = 1; // keep track
			foreach ($comment_meta_options as $comment_meta_option => $comment_meta_value)
			{
				if(!empty($comment_meta_value))
				{
					$comment_meta_score = $comment_meta_value * 10;
					$return .=  "<div class='comment-meta-option'>
							<p class='comment-meta-option-name'>{$post_options[$k]}</p>
							<p class='comment-meta-option-grade'>$comment_meta_value</p>
							<div class='clearfix'></div>
							<div class='comment-meta-grade-bar'>
								<div class='comment-meta-grade' style='width: {$comment_meta_score}%'></div>
							</div><!-- end .comment-meta-grade-bar -->
						</div><!-- end .comment-meta-option -->
					";
				}

				$k++;
			}

			$return .=  "</div><!-- end .user-comments-grades -->";



		}
		
			return  $return.$text."<div class='clearfix'></div>";
}
function cwp_additional_fields () {
	
	global $post;
	$meta_options = array();

	$meta_options['meta_option_1'] = get_post_meta($post->ID, "option_1_content", true);
	$meta_options['meta_option_2'] = get_post_meta($post->ID, "option_2_content", true);	
	$meta_options['meta_option_3'] = get_post_meta($post->ID, "option_3_content", true);
	$meta_options['meta_option_4'] = get_post_meta($post->ID, "option_4_content", true);
	$meta_options['meta_option_5'] = get_post_meta($post->ID, "option_5_content", true);
 
	foreach ($meta_options as $k => $value) {
		if(empty($meta_options[$k])) { 
			unset($meta_options[$k]);
		}
	}
	$sliders = array();
	foreach ($meta_options as $k => $value) {
		$sliders[] =
		"<div class='comment-form-meta-option'>
			<label for='$k'>$meta_options[$k]</label>
			<input type='text' id='$k' class='meta_option_input' value='0' name='$k' readonly='readonly'>
			<div class='comment_meta_slider'></div>
			<div class='clearfix'></div>
		</div>"; 
	}  
	echo "<div id='cwp-slider-comment'>".implode("",$sliders)."<div class='clearfix'></div></div>";
}

function cwp_add_comment_meta_values($comment_id)
	{
		if(isset($_POST['meta_option_1'])) {
	        $meta_option_1 = wp_filter_nohtml_kses($_POST['meta_option_1']);
	        add_comment_meta($comment_id, 'meta_option_1', $meta_option_1, false);
	    }

		if(isset($_POST['meta_option_2'])) {
	        $meta_option_2 = wp_filter_nohtml_kses($_POST['meta_option_2']);
	        add_comment_meta($comment_id, 'meta_option_2', $meta_option_2, false);
	    }

		if(isset($_POST['meta_option_3'])) {
	        $meta_option_3 = wp_filter_nohtml_kses($_POST['meta_option_3']);
	        add_comment_meta($comment_id, 'meta_option_3', $meta_option_3, false);
	    }

		if(isset($_POST['meta_option_4'])) {
	        $meta_option_4 = wp_filter_nohtml_kses($_POST['meta_option_4']);
	        add_comment_meta($comment_id, 'meta_option_4', $meta_option_4, false);
	    }

		if(isset($_POST['meta_option_5'])) {
	        $meta_option_5 = wp_filter_nohtml_kses($_POST['meta_option_5']);
	        add_comment_meta($comment_id, 'meta_option_5', $meta_option_5, false);
	    }
	}

add_action ('comment_post', 'cwp_add_comment_meta_values', 1);
?>