<?php
class Ithemes_Sync_Verb_Backupbuddy_Get_Overview extends Ithemes_Sync_Verb {
	public static $name = 'backupbuddy-get-overview';
	public static $description = 'Get overview and status information.';
	
	private $default_arguments = array(
	);
	
	/*
	 * Return:
	 *		array(
	 *			'success'	=>	'0' | '1'
	 *			'status'	=>	'Status message.'
	 *			'overview'	=>	[array of overview information]
	 *		)
	 *
	 */
	public function run( $arguments ) {
		
		$arguments = Ithemes_Sync_Functions::merge_defaults( $arguments, $this->default_arguments );
		
		if ( ! class_exists( 'backupbuddy_core' ) ) {
			require_once( pb_backupbuddy::plugin_path() . '/classes/core.php' );
		}
		
		
		$overview = backupbuddy_api0::getOverview();
		
		
		return array(
			'version' => '4',
			'status' => 'ok',
			'message' => 'Overview retrieved successfully.',
			'overview' => $overview,
		);
		
	} // End run().
	
	
} // End class.
