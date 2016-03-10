=== Minimum Password Strength ===
Contributors: itsananderson, Zer0Divisor
Donate link: 
Tags: security, password, administration
Requires at least: 3.0
Tested up to: 4.4.2
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Enforce a specific password strength. Uses the same strength calculations as the WordPress password strength meter

== Description ==

WordPress profile pages contain a visual indicator which shows the strength of a user's chosen password. This is nice, but WordPress doesn't actually enforce this in any way, so users are free to select weak passwords.

Minimum Password Strength uses the same method to calculate a password's strength, but forces users to meet a minimum strength requirement before they can change their password.

By default, passwords must have "Medium" strength, but administrators can change this to force passwords to be at least "Weak", "Medium", or "Strong". To change the minimum strength, go to Settings -> Password Strength after installing Minimum Password Strength.

For now, all users have the same password strength requirements, but a later release will allow administrators to select different strength requirements for different roles.

== Installation ==

1. Upload the 'minimum-password-strength' to the '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure your required password strength in Settings -> Password Strength

== Changelog ==

= 1.2.0 ==
* Enforce password strength during password reset
* Update "Tested up to" tag

= 1.1.2 =
* Fixing the installation instructions
* Updating the short and long descriptions
* Updating the "Tested up to" tag

= 1.1.1 =
* Fixing a broken author name

= 1.1 =
* Adding a readme.txt file

= 1.0 =
* Initial release
