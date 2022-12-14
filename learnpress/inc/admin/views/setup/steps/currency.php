<?php
/**
 * Template for displaying currency form while setting up.
 *
 * @author  ThimPres
 * @package LearnPress/Admin/Views
 * @version 3.0.0
 */

defined( 'ABSPATH' ) or exit;

// $settings      = LP_Settings::instance()->refresh();
$settings      = LP_Settings::instance();
$currency      = $settings->get( 'currency', 'USD' );
$preview_price = '';
?>

<h2><?php _e( 'Currency', 'learnpress' ); ?></h2>

<table>
	<tr>
		<th><?php _e( 'Currency', 'learnpress' ); ?></th>
		<td>
			<select id="currency" name="settings[currency][currency]">
				<?php
				$payment_currencies = learn_press_currencies();
				if ( $payment_currencies ) {
					foreach ( $payment_currencies as $code => $symbol ) {
						?>
						<option value="<?php echo esc_attr( $code ); ?>"
								data-symbol="<?php echo learn_press_get_currency_symbol( $code ); ?>" <?php selected( $code == $currency ); ?>>
							<?php echo wp_kses_post( $symbol ); ?>
						</option>
						<?php
					}
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<th><?php _e( 'Currency position', 'learnpress' ); ?></th>
		<td>
			<select id="currency-pos" name="settings[currency][currency_pos]">
				<?php
				$positions = array();
				foreach ( learn_press_currency_positions() as $pos => $text ) {
					?>
					<option value="<?php echo esc_attr( $pos ); ?>"<?php selected( $pos == $settings->get( 'currency_pos' ) ); ?>><?php echo wp_kses_post( $text ); ?></option>
					<?php
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<th><?php _e( 'Thousands Separator', 'learnpress' ); ?></th>
		<td>
			<input id="thousands-separator" type="text" name="settings[currency][thousands_separator]"
				value="<?php echo esc_attr( $settings->get( 'thousands_separator', ',' ) ); ?>">
		</td>
	</tr>
	<tr>
		<th><?php _e( 'Decimal separator', 'learnpress' ); ?></th>
		<td>
			<input id="decimals-separator" type="text" name="settings[currency][decimals_separator]"
				value="<?php echo esc_attr( $settings->get( 'decimals_separator', '.' ) ); ?>">
		</td>
	</tr>
	<tr>
		<th><?php _e( 'The number of decimals', 'learnpress' ); ?></th>
		<td>
			<input id="number-of-decimals" type="text" name="settings[currency][number_of_decimals]"
				value="<?php echo esc_attr( $settings->get( 'number_of_decimals', '2' ) ); ?>">
		</td>
	</tr>
	<tr>
		<th></th>
		<td>
			<div id="preview-price"><?php echo learn_press_format_price( 1234.56, true ); ?></div>
		</td>
	</tr>
</table>
