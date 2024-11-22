<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="customer-login">

	<div class="row">

		<div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3 col-login">
			<div class="unero-tabs">
				<ul class="tabs-nav">
					<li class="active"><a href="#" class="active"><?php esc_html_e( 'Login', 'unero' ); ?></a></li>
					<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
						<li><a href="#"><?php esc_html_e( 'Register', 'unero' ); ?></a></li>
					<?php endif; ?>
				</ul>
				<div class="tabs-content">

					<div class="tabs-panel active">

		<form class="woocommerce-form woocommerce-form-login login" method="post">

							<?php do_action( 'woocommerce_login_form_start' ); ?>

							<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
								<input type="text" placeholder="<?php esc_html_e( 'Username', 'unero' ); ?>" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php if ( ! empty( $_POST['username'] ) ) {
									echo esc_attr( $_POST['username'] );
								} ?>" />
							</p>

							<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide form-row-password">
								<input placeholder="<?php esc_html_e( 'Password', 'unero' ); ?>" class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
								<a class="lost-password" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot?', 'unero' ); ?></a>
							</p>

							<?php do_action( 'woocommerce_login_form' ); ?>

							<p class="form-row">
								<label for="rememberme" class="inline rememberme">
									<input class="woocommerce-Input woocommerce-Input--checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /><span class="label"> <?php esc_html_e( 'Remember me', 'unero' ); ?></span>
								</label>
								<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
								<input type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Login', 'unero' ); ?>" />

							</p>

							<?php do_action( 'woocommerce_login_form_end' ); ?>

						</form>
					</div>

					<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

						<div class="tabs-panel">


							<form method="post" class="woocommerce-form woocommerce-form-register register">

								<?php do_action( 'woocommerce_register_form_start' ); ?>

								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

									<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
										<input type="text" placeholder="<?php esc_html_e( 'Username', 'unero' ); ?>" autocomplete="username" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) {
											echo esc_attr( $_POST['username'] );
										} ?>" />
									</p>

								<?php endif; ?>

								<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
									<input type="email" placeholder="<?php esc_html_e( 'Email address', 'unero' ); ?>"  autocomplete="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) {
										echo esc_attr( $_POST['email'] );
									} ?>" />
								</p>

								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

									<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
										<input type="password" placeholder="<?php esc_html_e( 'Password', 'unero' ); ?>" autocomplete="new-password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" />
									</p>

								<?php else : ?>

                                    <p><?php esc_html_e( 'A password will be sent to your email address.', 'unero' ); ?></p>

								<?php endif; ?>

								<?php do_action( 'woocommerce_register_form' ); ?>
								<?php do_action( 'register_form' ); ?>

								<p class="woocomerce-FormRow form-row">
									<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
									<input type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'unero' ); ?>" />
								</p>

								<?php do_action( 'woocommerce_register_form_end' ); ?>

							</form>

						</div>

					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
