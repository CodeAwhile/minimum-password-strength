<?php

/*
 * Plugin Name: Minimum Password Strength
 * Description: Enforce a specific password strength. Hides the option to ignore weak passwords.
 * Version: 2.0.0
 * Plugin URI: http://wordpress.org/extend/plugins/minimum-password-strength/
 * Author: Will Anderson, Tony Ferrell and Ryan Hellyer
 * Author URI: http://codeawhile.com/
 */


add_action( 'admin_enqueue_scripts', 'minimum_password_strength' );
/**
 * Hiding the "Confirm use of weak password" checkbox from view.
 */
function minimum_password_strength() {
	wp_add_inline_style( 'admin-menu', '.pw-weak {display: none !important;}' );
}
