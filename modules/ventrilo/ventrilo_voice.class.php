<?php
/*	Project:	EQdkp-Plus
 *	Package:	Voice Portal Module
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2015 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
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