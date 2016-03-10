<?php

/*
 * Plugin Name: Minimum Password Strength
 * Description: Enforce a specific password strength. Uses the same strength calculations as the WordPress password strength meter
 * Version: 1.2.0
 * Plugin URI: http://wordpress.org/extend/plugins/minimum-password-strength/
 * Author: Will Anderson and Tony Ferrell
 * Author URI: http://codeawhile.com/
 */

 class Minimum_Password_Strength {
	
	const STRENGTH_KEY = 'minimum_password_strength';
	const PASS_LENGTH = 4;
	const SHORT_PASS = 1;
	const BAD_PASS = 2;
	const GOOD_PASS = 3;
	const STRONG_PASS = 4;
	const MISMATCH = 5;
	const DEFAULT_REQUIRED_STRENGTH = self::GOOD_PASS;
	
	public static $strengths = array(
		2 => 'Weak',
		3 => 'Medium',
		4 => 'Strong',
	);

 	public static function start() {
		add_action( 'user_profile_update_errors', array( __CLASS__, 'check_password_strength' ) );
		add_action( 'admin_menu', array( __CLASS__, 'add_menu' ) );
		add_action( 'validate_password_reset', array( __CLASS__, 'check_password_strength' ) );
	}

	public static function check_password_strength( $errors ) {
		$password1 = isset( $_POST['pass1'] ) ? $_POST['pass1'] : '';
		$password2 = isset( $_POST['pass2'] ) ? $_POST['pass2'] : '';
		if ( isset( $_POST['user_id'] ) ) {
			// Editing user profile page
			$user_id = intval( $_POST['user_id'] );
			$user = get_userdata( $user_id );
			$username = $user->user_login;
		} else {
			// Creating a new user
			$username = $_POST['user_login'];
		}
		
		if ( empty( $password1 ) && empty( $password2 ) ) {
			return;
		}

		$strength = self::get_password_strength( $username, $password1, $password2 );

		$required_strength = get_option( self::STRENGTH_KEY, 3 );

		if ( self::MISMATCH == $strength ) {
			$errors->add( 'mismatched-password', 'The passwords you entered do not match', array( 'form-field' => 'pass1' ) );
		} elseif ( $strength < $required_strength ) {
			$errors->add( 'weak-password', sprintf( __( 'You must choose a "%s" password', 'minimum-password-strength' ), self::$strengths[$required_strength] ), array( 'form-field' => 'pass1' ) );
		}
	}

	public static function add_menu() {
		add_options_page( __( 'Minimum Password Strength', 'minimum-password-strength' ), __( 'Password Strength', 'minimum-password-strength' ), 'manage_options', __FILE__, array( __CLASS__, 'show_settings_page' ) );
	}

	public static function show_settings_page() {
		if ( isset( $_POST['submit'] ) && isset( $_POST['_wpnonce'] ) &&
				wp_verify_nonce( $_POST['_wpnonce'], 'update_minimum_password_strength' ) ) {
			$strength = intval( $_POST['strength'] );
			update_option( self::STRENGTH_KEY, $strength );
		}
		
		$required_strength = self::get_required_strength();
		$options = self::$strengths;

		include plugin_dir_path( __FILE__ ) . 'views/settings.php';
	}

	public static function get_required_strength() {
		return get_option( self::STRENGTH_KEY, self::DEFAULT_REQUIRED_STRENGTH );
	}

	public static function get_password_strength( $username, $password1, $password2 ) {
		$symbolSize = 0;

		// password 1 != password 2
		if ( $password1 != $password2 )
			return self::MISMATCH;

		//password < self::PASS_LENGTH
		if ( strlen( $password1 ) < self::PASS_LENGTH )
			return self::SHORT_PASS;

		//password1 == username
		if ( strtolower( $password1 ) == strtolower( $username ) )
			return self::BAD_PASS;

		if ( preg_match( '/[0-9]/', $password1 ) )
			$symbolSize += 10;
		if ( preg_match( '/[a-z]/', $password1 ) )
			$symbolSize += 26;
		if ( preg_match( '/[A-Z]/', $password1 ) )
			$symbolSize += 26;
		if ( preg_match( '/[^a-zA-Z0-9]/', $password1 ) )
			$symbolSize += 31;

		$natLog = log( pow( $symbolSize, strlen( $password1 ) ) );
		$score = $natLog / log( 2 );

		if ( $score < 40 )
			return self::BAD_PASS;

		if ( $score < 56 )
			return self::GOOD_PASS;
		
		return self::STRONG_PASS;
	}
 }

 Minimum_Password_Strength::start();
