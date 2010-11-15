<?php
/*
Plugin Name: Automatic Term Link Plus
Description: This plugin will automatically links to terms in your content to that term's page. Can be used for tags, categories and custom taxonomies. Based on Chen Ju's Automatic Tag Links.
Version: 1.0
Author: William P. Davis, Chen Ju
Author URI: http://wpdavis.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
	Replace the content
*/

function sortbylength($a,$b){
    return strlen($b->name)-strlen($a->name);
}

function term2Link($content){
	global $ID;
	global $replace_times;
	if(is_single($ID)) {
		/*
			The number of times to replace a term
		*/	
		$useTimes=get_option('term2link_times');
		$replace_times=intval($useTimes);
		if($replace_times==0) $replace_times=3;
		
		/*
			Get all the terms
		*/
		$terms=get_terms( explode(',',get_option('term2link_taxonomies')) );
		if($terms==null) return $content;
		
		usort($terms,'sortbylength');
		foreach($terms as $term){
				$link=get_term_link($term,$term->taxonomy);
				$pattern='/(?<=[^a-zA-Z])\b('.$term->name.')\b(?!.*<\/a>)/i';
				$replace='<a href="'.$link.'">$1</a>';
				$content=preg_replace($pattern,$replace,$content,$replace_times);
		 }		
	}
	return $content;
}

/*
	The options page
*/
function term2linkOptions() { 
	if ('process' == $_POST['stage']) {
		update_option('term2link_times', $_POST['times']);
		update_option('term2link_taxonomies', implode(',',$_POST['taxonomies']));
	}
	$times = get_option('term2link_times');
	$set_taxonomies = explode(',',get_option('term2link_taxonomies'));
	?>
	<div class="wrap">
		<h2><?php _e('Terms to Link Options') ?></h2>
		<form name="form1" method="post" >		
				<input type="hidden" name="stage" value="process" />
			<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Save Options') ?> &raquo;" />
			</p>
			<table cellpadding="10" class="optiontable">
				<tr valign="top">
					<th scope="row"><label for="Replace_time"><?php _e('The number of times to convert a term to a link') ?>:</label></th>
					<td><input name="times" type="text"  size="20" id="times" value="<?php echo $times; ?>"/></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="use"><?php _e('Use the following taxonomies') ?>:</label></th>
					<td>
						<?php 
						$taxonomies=get_taxonomies('','names'); 
						foreach ($taxonomies as $taxonomy ) {
							$selected = false;
							if(in_array($taxonomy,$set_taxonomies)) { $selected = ' CHECKED'; }
							echo '<input type="checkbox" name="taxonomies[]" name="taxonomies[]" value="'.$taxonomy.'" '.$selected.'>'. $taxonomy. '</p>';
						}
						?>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Save Options') ?> &raquo;" />
			</p>
		</form>
	</div>
<?php }
function term2link_setting_options(){
		add_options_page('Terms to links', 'Terms to links', 'manage_options', 'term2linkOptions', 'term2linkOptions');
}
add_action('admin_menu','term2link_setting_options');
add_filter('the_content','term2link');

?>