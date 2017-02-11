<?php
global  $wpdb ; 
?>
<h1 class="wp-heading-inline">System Information </h1>



<table class="" cellspacing="0" id="">
	<thead>
		<tr>
			<th colspan="2" ><h2><?php _e( 'WordPress Environment', 'bsi' ); ?></h2></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td ><?php _e( 'Home URL', 'bsi' ); ?>:</td>
			
                        
			<td><?php form_option( 'home' ); ?></td>
		</tr>
		<tr>
			<td ><?php _e( 'Site URL', 'bsi' ); ?>:</td>
			
                        
			<td><?php form_option( 'siteurl' ); ?></td>
		</tr>
		 
		 
		<tr>
			<td ><?php _e( 'WP Version', 'bsi' ); ?>:</td>
			
			<td><?php bloginfo('version'); ?></td>
		</tr>
		<tr>
			<td ><?php _e( 'WP Multisite', 'bsi' ); ?>:</td>
			
			<td><?php if ( is_multisite() ) echo '<span class="dashicons dashicons-yes"></span>'; else echo '&ndash;'; ?></td>
		</tr>
		<tr>
			<td ><?php _e( 'WP Memory Limit', 'bsi' ); ?>:</td>
			
			<td><?php
				echo $memory =   WP_MEMORY_LIMIT ;

				 
				if ( $memory < 67108864 ) {
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( __( '%s - We recommend setting memory to at least 64MB. See: %s', 'bsi' ), size_format( $memory ), '<a href="https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . __( 'Increasing memory allocated to PHP', 'bsi' ) . '</a>' ) . '</mark>';
				} else {
					echo '<mark class="yes">' . size_format( $memory ) . '</mark>';
				}
			?></td>
		</tr>
		<tr>
			<td ><?php _e( 'WP Debug Mode', 'bsi' ); ?>:</td>
			
			<td>
				<?php if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) : ?>
					<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
				<?php else : ?>
					<mark class="no">&ndash;</mark>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td  ><?php _e( 'WP Cron', 'bsi' ); ?>:</td>
			
			<td>
				<?php if ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ) : ?>
					<mark class="no">&ndash;</mark>
				<?php else : ?>
					<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td  ><?php _e( 'Language', 'bsi' ); ?>:</td>
			
			<td><?php echo get_locale(); ?></td>
		</tr>
	</tbody>
</table>
<table   cellspacing="0">
	<thead>
		<tr>
			<th colspan="2"  ><h2><?php _e( 'Server Environment', 'bsi' ); ?></h2></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td  ><?php _e( 'Server Info', 'bsi' ); ?>:</td>
			
			<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
		</tr>
		<tr>
			<td  ><?php _e( 'PHP Version', 'bsi' ); ?>:</td>
			
			<td><?php
				// Check if phpversion function exists.
				if ( function_exists( 'phpversion' ) ) {
					$php_version = phpversion();

					if ( version_compare( $php_version, '5.6', '<' ) ) {
						echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( __( '%s - We recommend a minimum PHP version of 5.6. See: %s', 'bsi' ), esc_html( $php_version ), '<a href="https://docs.bsi.com/document/how-to-update-your-php-version/" target="_blank">' . __( 'How to update your PHP version', 'bsi' ) . '</a>' ) . '</mark>';
					} else {
						echo '<mark class="yes">' . esc_html( $php_version ) . '</mark>';
					}
				} else {
					_e( "Couldn't determine PHP version because phpversion() doesn't exist.", 'bsi' );
				}
				?></td>
		</tr>
		<?php if ( function_exists( 'ini_get' ) ) : ?>
			<tr>
				<td ><?php _e( 'PHP Post Max Size', 'bsi' ); ?>:</td>
				
				<td><?php echo size_format(ini_get( 'post_max_size' )  ); ?></td>
			</tr>
			<tr>
				<td  ><?php _e( 'PHP Time Limit', 'bsi' ); ?>:</td>
				
				<td><?php echo ini_get( 'max_execution_time' ); ?></td>
			</tr>
			<tr>
				<td  ><?php _e( 'PHP Max Input Vars', 'bsi' ); ?>:</td>
				
				<td><?php echo ini_get( 'max_input_vars' ); ?></td>
			</tr>
			<tr>
				<td  ><?php _e( 'cURL Version', 'bsi' ); ?>:</td>
				
				<td><?php
					if ( function_exists( 'curl_version' ) ) {
						$curl_version = curl_version();
						echo $curl_version['version'] . ', ' . $curl_version['ssl_version'];
					} else {
						_e( 'N/A', 'bsi' );
					}
				  ?></td>
			</tr>
			<tr>
				<td  ><?php _e( 'SUHOSIN Installed', 'bsi' ); ?>:</td>
				
				<td><?php echo extension_loaded( 'suhosin' ) ? '<span class="dashicons dashicons-yes"></span>' : '&ndash;'; ?></td>
			</tr>
		<?php endif;

		if ( $wpdb->use_mysqli ) {
			$ver = mysqli_get_server_info( $wpdb->dbh );
		} else {
			$ver = mysql_get_server_info();
		}

		if ( ! empty( $wpdb->is_mysql ) && ! stristr( $ver, 'MariaDB' ) ) : ?>
			<tr>
				<td  ><?php _e( 'MySQL Version', 'bsi' ); ?>:</td>
				
				<td>
					<?php
					$mysql_version = $wpdb->db_version();

					if ( version_compare( $mysql_version, '5.6', '<' ) ) {
						echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( __( '%s - We recommend a minimum MySQL version of 5.6. See: %s', 'bsi' ), esc_html( $mysql_version ), '<a href="https://wordpress.org/about/requirements/" target="_blank">' . __( 'WordPress Requirements', 'bsi' ) . '</a>' ) . '</mark>';
					} else {
						echo '<mark class="yes">' . esc_html( $mysql_version ) . '</mark>';
					}
					?>
				</td>
			</tr>
		<?php endif; ?>
		<tr>
			<td  ><?php _e( 'Max Upload Size', 'bsi' ); ?>:</td>
			
			<td><?php echo size_format( wp_max_upload_size() ); ?></td>
		</tr>
		<tr>
			<td  ><?php _e( 'Default Timezone is UTC', 'bsi' ); ?>:</td>
			
			<td><?php
				$default_timezone = date_default_timezone_get();
				if ( 'UTC' !== $default_timezone ) {
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( __( 'Default timezone is %s - it should be UTC', 'bsi' ), $default_timezone ) . '</mark>';
				} else {
					echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
				} ?>
			</td>
		</tr>
		<?php
			$posting = array();

			// fsockopen/cURL.
			$posting['fsockopen_curl']['name'] = 'fsockopen/cURL';
			

			if ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
				$posting['fsockopen_curl']['success'] = true;
			} else {
				$posting['fsockopen_curl']['success'] = false;
				 
			}

			// SOAP.
			$posting['soap_client']['name'] = 'SoapClient';
			

			if ( class_exists( 'SoapClient' ) ) {
				$posting['soap_client']['success'] = true;
			} else {
				$posting['soap_client']['success'] = false;
				$posting['soap_client']['note']    = sprintf( __( 'Your server does not have the %s class enabled - some gateway plugins which use SOAP may not work as expected.', 'bsi' ), '<a href="https://php.net/manual/en/class.soapclient.php">SoapClient</a>' );
			}

			// DOMDocument.
			$posting['dom_document']['name'] = 'DOMDocument';
			

			if ( class_exists( 'DOMDocument' ) ) {
				$posting['dom_document']['success'] = true;
			} else {
				$posting['dom_document']['success'] = false;
				$posting['dom_document']['note']    = sprintf( __( 'Your server does not have the %s class enabled - HTML/Multipart emails, and also some extensions, will not work without DOMDocument.', 'bsi' ), '<a href="https://php.net/manual/en/class.domdocument.php">DOMDocument</a>' );
			}

			// GZIP.
			$posting['gzip']['name'] = 'GZip';
			

			if ( is_callable( 'gzopen' ) ) {
				$posting['gzip']['success'] = true;
			} else {
				$posting['gzip']['success'] = false;
				$posting['gzip']['note']    = sprintf( __( 'Your server does not support the %s function - this is required to use the GeoIP database from MaxMind.', 'bsi' ), '<a href="https://php.net/manual/en/zlib.installation.php">gzopen</a>' );
			}

			// Multibyte String.
			$posting['mbstring']['name'] = 'Multibyte String';
			

			if ( extension_loaded( 'mbstring' ) ) {
				$posting['mbstring']['success'] = true;
			} else {
				$posting['mbstring']['success'] = false;
				$posting['mbstring']['note']    = sprintf( __( 'Your server does not support the %s functions - this is required for better character encoding. Some fallbacks will be used instead for it.', 'bsi' ), '<a href="https://php.net/manual/en/mbstring.installation.php">mbstring</a>' );
			}

			// WP Remote Post Check.
			$posting['wp_remote_post']['name'] = __( 'Remote Post', 'bsi');
			

			$response = wp_safe_remote_post( 'https://www.paypal.com/cgi-bin/webscr', array(
				'timeout'     => 60,
				'user-agent'  => 'bsi/' ,
				'httpversion' => '1.1',
				'body'        => array(
					'cmd'    => '_notify-validate'
				)
			) );

			if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
				$posting['wp_remote_post']['success'] = true;
			} else {
				$posting['wp_remote_post']['note']    = __( 'wp_remote_post() failed. PayPal IPN won\'t work with your server. Contact your hosting provider.', 'bsi' );
				if ( is_wp_error( $response ) ) {
					$posting['wp_remote_post']['note'] .= ' ' . sprintf( __( 'Error: %s', 'bsi' ), wc_clean( $response->get_error_message() ) );
				} else {
					$posting['wp_remote_post']['note'] .= ' ' . sprintf( __( 'Status code: %s', 'bsi' ), wc_clean( $response['response']['code'] ) );
				}
				$posting['wp_remote_post']['success'] = false;
			}

			// WP Remote Get Check.
			$posting['wp_remote_get']['name'] = __( 'Remote Get', 'bsi');
			

			$response = wp_safe_remote_get( 'https://bsi.com/wc-api/product-key-api?request=ping&network=' . ( is_multisite() ? '1' : '0' ) );

			if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
				$posting['wp_remote_get']['success'] = true;
			} else {
				$posting['wp_remote_get']['note']    = __( 'wp_remote_get() failed. The bsi plugin updater won\'t work with your server. Contact your hosting provider.', 'bsi' );
				if ( is_wp_error( $response ) ) {
					$posting['wp_remote_get']['note'] .= ' ' . sprintf( __( 'Error: %s', 'bsi' ), wc_clean( $response->get_error_message() ) );
				} else {
					$posting['wp_remote_get']['note'] .= ' ' . sprintf( __( 'Status code: %s', 'bsi' ), wc_clean( $response['response']['code'] ) );
				}
				$posting['wp_remote_get']['success'] = false;
			}

			$posting = apply_filters( 'bsi_debug_posting', $posting );

			foreach ( $posting as $post ) {
				$mark = ! empty( $post['success'] ) ? 'yes' : 'error';
				?>
				<tr>
					<td data-export-label="<?php echo esc_html( $post['name'] ); ?>"><?php echo esc_html( $post['name'] ); ?>:</td>
				 
					<td>
						<mark class="<?php echo $mark; ?>">
							<?php echo ! empty( $post['success'] ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no-alt"></span>'; ?> <?php echo ! empty( $post['note'] ) ? wp_kses_data( $post['note'] ) : ''; ?>
						</mark>
					</td>
				</tr>
				<?php
			}
		?>
	</tbody>
</table>


<table class="" cellspacing="0">
	<thead>
		<tr>
			<th colspan="2"  ><h2><?php _e( 'Active Plugins', 'bsi' ); ?> (<?php echo count( (array) get_option( 'active_plugins' ) ); ?>)</h2></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			$network_activated_plugins = array_keys( get_site_option( 'active_sitewide_plugins', array() ) );
			$active_plugins            = array_merge( $active_plugins, $network_activated_plugins );
		}

		foreach ( $active_plugins as $plugin ) {

			$plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
			$dirname        = dirname( $plugin );
			$version_string = '';
			$network_string = '';

			if ( ! empty( $plugin_data['Name'] ) ) {

				// Link the plugin name to the plugin url if available.
				$plugin_name = esc_html( $plugin_data['Name'] );

				if ( ! empty( $plugin_data['PluginURI'] ) ) {
					$plugin_name = '<a href="' . esc_url( $plugin_data['PluginURI'] ) . '" title="' . esc_attr__( 'Visit plugin homepage' , 'bsi' ) . '" target="_blank">' . $plugin_name . '</a>';
				}

				if ( strstr( $dirname, 'bsi-' ) && strstr( $plugin_data['PluginURI'], 'woothemes.com' ) ) {

					if ( false === ( $version_data = get_transient( md5( $plugin ) . '_version_data' ) ) ) {
						$changelog = wp_safe_remote_get( 'http://dzv365zjfbd8v.cloudfront.net/changelogs/' . $dirname . '/changelog.txt' );
						$cl_lines  = explode( "\n", wp_remote_retrieve_body( $changelog ) );
						if ( ! empty( $cl_lines ) ) {
							foreach ( $cl_lines as $line_num => $cl_line ) {
								if ( preg_match( '/^[0-9]/', $cl_line ) ) {

									$date         = str_replace( '.' , '-' , trim( substr( $cl_line , 0 , strpos( $cl_line , '-' ) ) ) );
									$version      = preg_replace( '~[^0-9,.]~' , '' ,stristr( $cl_line , "version" ) );
									$update       = trim( str_replace( "*" , "" , $cl_lines[ $line_num + 1 ] ) );
									$version_data = array( 'date' => $date , 'version' => $version , 'update' => $update , 'changelog' => $changelog );
									set_transient( md5( $plugin ) . '_version_data', $version_data, DAY_IN_SECONDS );
									break;
								}
							}
						}
					}

					if ( ! empty( $version_data['version'] ) && version_compare( $version_data['version'], $plugin_data['Version'], '>' ) ) {
						$version_string = ' &ndash; <strong style="color:red;">' . esc_html( sprintf( _x( '%s is available', 'Version info', 'bsi' ), $version_data['version'] ) ) . '</strong>';
					}

					if ( $plugin_data['Network'] != false ) {
						$network_string = ' &ndash; <strong style="color:black;">' . __( 'Network enabled', 'bsi' ) . '</strong>';
					}
				}

				?>
				<tr>
					<td><?php echo $plugin_name; ?></td>
					 
					<td><?php echo sprintf( _x( 'by %s', 'by author', 'bsi' ), $plugin_data['Author'] ) . ' &ndash; ' . esc_html( $plugin_data['Version'] ) . $version_string . $network_string; ?></td>
				</tr>
				<?php
			}
		}
		?>
	</tbody>
</table>