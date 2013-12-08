<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2008
 * Date:		$Date: 2012-05-01 13:28:27 +0200 (Di, 01. Mai 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: hoofy_leon $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 11769 $
 * 
 * $Id: ventrilo_portal.class.php 11769 2012-05-01 11:28:27Z hoofy_leon $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}
if(!class_exists("ventrilo_voice")) {
	class ventrilo_voice {
		private $config = array();
		
		public function __construct($arrOptions) {
			$this->config = $arrOptions;
		}
		
		public function output() {
			return '<iframe src="http://vspy.guildlaunch.net/srv/minispy.php?Address=' . $this->config('ventrilo_server') . '&Port=' . $this->config('ventrilo_port') . '&J=&Scroll=&T=8&E=&Main=&Color=' . $this->config('ventrilo_backgroundc') . '&S=' . $this->config('ventrilo_servercolor') . '&C=' . $this->config('ventrilo_channelc') . '&U=' . $this->config('ventrilo_usercolor') . '&Names=&Compact=" width="200" height="300" frameborder="0"></iframe>';
		}
		
		private function config($strKey){
			if (isset($this->config[$strKey])){
				return $this->config[$strKey];
			} else {
				return "";
			}
		}
	}
}
?>