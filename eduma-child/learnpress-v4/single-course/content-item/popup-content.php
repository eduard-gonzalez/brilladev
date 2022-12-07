<?php
/**
 * Content Poup.
 * Use for React Quiz.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

?>

<div id="popup-content">
	<?php
	LP()->template( 'course' )->course_content_item();
	?>
	<div class="content-comments-single-course">
	<?php
	LP()->template( 'course' )->course_item_comments();
	?>
	</div>	

</div>
