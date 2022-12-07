<?php
/**
 * Template for displaying extra info as toggle
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $title ) || ! isset( $items ) ) {
	return;
}
?>

<div class="container-title">
			<h3 class="title-custom-single-course"><?php echo esc_html( $title ); ?></h3>
</div>
<div class="container">
<ul>
				<?php foreach ( $items as $item ) : ?>
					<li><?php echo wp_kses_post( $item ); ?></li>
				<?php endforeach; ?>
			</ul>
</div>