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
		
		$output = $this->pdc->get('portal.module.voice.mumble.outputdata', false, true);
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
			if ($cachetime >= 1) {$this->pdc->put('portal.module.voice.mumble.outputdata', $output, $cachetime, false, true);}
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