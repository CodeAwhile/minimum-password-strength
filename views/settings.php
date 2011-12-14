<div class="wrap">
	<h2><?php _e( 'Minimum Password Strength', 'minimum-password-strength' ); ?></h2>
	<form method="post">
        <?php echo wp_nonce_field( 'update_minimum_password_strength' ); ?>
		<table class="form-table">
			<tr>
				<th><label for="strength"><?php _e( 'Password must be at least', 'minimum-password-strength' ); ?></label></th>
				<td>
					<select name="strength" id="strength">
						<?php foreach ( $options as $value => $name ) { ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $required_strength ); ?>><?php echo esc_html( $name ); ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
		</table>
		<p>
			<input type="submit" name="submit" class="button-primary" value="Save Changes" />
		</p>
	</form>
</div>
