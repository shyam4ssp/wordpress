<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_html_e( 'First name', 'unero' ); ?>" name="account_first_name" autocomplete="given-name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
	</p>
	<p class="woocommerce-FormRow woocommerce-FormRow--last form-row form-row-last">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_html_e( 'Last name', 'unero' ); ?>" name="account_last_name"  autocomplete="family-name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
	</p>
	<div class="clear"></div>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="account_display_name"><?php esc_html_e( 'Display name', 'unero' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'unero' ); ?></em></span>
	</p>
	<div class="clear"></div>

	<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" placeholder="<?php esc_html_e( 'Email address', 'unero' ); ?>" name="account_email" autocomplete="email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
	</p>

	<fieldset>
		<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" placeholder="<?php esc_html_e( 'Current Password', 'unero' ); ?>" name="password_current" autocomplete="off" id="password_current" />
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" placeholder="<?php esc_html_e( 'New Password', 'unero' ); ?>" name="password_1" autocomplete="off"  id="password_1" />
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" placeholder="<?php esc_html_e( 'Confirm New Password', 'unero' ); ?>" name="password_2" autocomplete="off" id="password_2" />
		</p>
	</fieldset>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p class="edit-btn">
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<input type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'unero' ); ?>" />
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
