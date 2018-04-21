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

class teamspeak3_voice extends gen_class {
	private $config = array();
	
	public function __construct($arrOptions) {
		$this->config = $arrOptions;
	}

	public function output() {
		$cachetime = ($this->config('ts3_cache')) ? $this->config('ts3_cache') : '30'; //default cachetime = 30 seconds
		
		$this->tpl->css_file($this->root_path . 'portal/voice/modules/teamspeak3/ts3view.css');
		
		$moduleID = $this->config('_module_id');
		
		$htmlout = $this->pdc->get('portal.module.voice.ts3.outputdata.'.$moduleID, false, true);
		if ((!$htmlout) or $cachetime == '0'){
			include_once($this->root_path . 'portal/voice/modules/teamspeak3/Ts3Viewer.php');
			$ts3v = registry::register("Ts3Viewer", array($moduleID));

			if ($ts3v->connect()) {
				$ts3v->query();
				$ts3v->disconnect();
			}

			$htmlout = $ts3v->gethtml();
			unset($ts3v);
			if ($cachetime >= '1') {$this->pdc->put('portal.module.voice.ts3.outputdata.'.$moduleID, $htmlout, $cachetime, false, true);}
		}
		
		$ajaxReloadTime = ((int)$cachetime < 60) ? 60 : intval($cachetime);
		
		$this->tpl->add_js('
			setInterval(function() {
				$.get("'.$this->server_path.'portal/voice/modules/teamspeak3/ajax.php'.$this->SID.'&mid='.$moduleID.'", function(data){
					if(data){
						$(".ts3_'.$moduleID.'_container").html(data);
					}
				});
				
			}, 1000*'.$ajaxReloadTime.');
		');

		$out  = '<div class="ts3_'.$moduleID.'_container">';
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