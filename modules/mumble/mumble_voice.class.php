<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2008
 * Date:		$Date: 2012-11-11 19:07:23 +0100 (So, 11. Nov 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: wallenium $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 12435 $
 * 
 * $Id: mumbleviewer_portal.class.php 12435 2012-11-11 18:07:23Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

class mumble_voice extends gen_class {
	
	private $config = array();
	
	public function __construct($arrOptions) {
		$this->config = $arrOptions;
	}
	
	public function output() {
		$dataUri = $this->config('mumbleviewer_datauri');
		$dataFormat = $this->config('mumbleviewer_dataformat');
		$iconStyle = $this->config('mumbleviewer_iconstyle');
		$cachetime = 30; //cachetime = 30 seconds
		
		$this->tpl->css_file($this->root_path . 'portal/voice/modules/mumble/mumbleChannelViewer.css');
		
		$output = $this->pdc->get('portal.modul.voice.mumble.outputdata', false, true);
		if ((!$output) or $cachetime == 0){
		
			$output = "<div id='mumbleViewer' class='".$iconStyle."'>";

			if ( $dataUri && $dataFormat ) {
				$mumbleViewerInclude = $this->root_path . 'portal/voice/modules/mumble/mumbleChannelViewer.php';
				if (is_file($mumbleViewerInclude)) {
					require_once( $mumbleViewerInclude );
					$output .= MumbleChannelViewer::render( html_entity_decode( $dataUri ), $dataFormat );
				}
			}
			$output .= "</div>";
			if ($cachetime >= 1) {$this->pdc->put('portal.modul.voice.mumble.outputdata', $output, $cachetime, false, true);}
		}

		return $output;
	}
	
	private function config($strKey){
		if (isset($this->config[$strKey])){
			return $this->config[$strKey];
		} else {
			return "";
		}
	}
}
?>