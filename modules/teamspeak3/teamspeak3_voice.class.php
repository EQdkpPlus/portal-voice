<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2008
 * Date:		$Date: 2012-10-22 20:15:33 +0200 (Mo, 22. Okt 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 12321 $
 * 
 * $Id: teamspeak3_portal.class.php 12321 2012-10-22 18:15:33Z godmod $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

class teamspeak3_voice extends gen_class {
	public static $shortcuts = array('core', 'pdc', 'config', 'tpl');
	
	private $config = array();
	
	public function __construct($arrOptions) {
		$this->config = $arrOptions;
	}

	public function output() {
		$cachetime = ($this->config('pk_ts3_cache')) ? $this->config('pk_ts3_cache') : '30'; //default cachetime = 30 seconds
		
		$this->tpl->css_file($this->root_path . 'portal/voice/modules/teamspeak3/ts3view.css');
		
		$htmlout = $this->pdc->get('portal.modul.voice.ts3.outputdata', false, true);
		if ((!$htmlout) or $cachetime == '0'){
			include_once($this->root_path . 'portal/voice/modules/teamspeak3/Ts3Viewer.php');
			$ts3v = registry::register("Ts3Viewer", array($this->config));

			if ($ts3v->connect()) {
				$ts3v->query();
				$ts3v->disconnect();
			}

			$htmlout = $ts3v->gethtml();
			unset($ts3v);
			if ($cachetime >= '1') {$this->pdc->put('portal.modul.voice.ts3.outputdata', $htmlout, $cachetime, false, true);}
		}

		$out  = '<div>';
		$out .= $htmlout;
		$out .= '</div>';
		return $out;
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