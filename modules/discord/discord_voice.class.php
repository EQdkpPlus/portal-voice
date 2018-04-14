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

class discord_voice extends gen_class {
	private $config = array();
	
	public function __construct($arrOptions) {
		$this->config = $arrOptions;
	}

	public function output() {
		$moduleID = $this->config('_module_id');
		
		$out = $this->pdc->get('portal.module.voice.discord.'.$moduleID);
		if($out == null || !$out){
			include_once($this->root_path.'/portal/voice/modules/discord/discordviewer.class.php');
			$objViewer = register('discordviewer', array($moduleID));
			
			$out = $objViewer->viewer();
			$this->pdc->put('portal.module.voice.discord.'.$moduleID, $out, 5*60);
		}
		
		$this->tpl->add_js('
			setInterval(function() {
				$.get("'.$this->server_path.'portal/voice/modules/discord/ajax.php'.$this->SID.'&mid='.$moduleID.'", function(data){
					if(data){
						$(".discord_'.$moduleID.'_container").html(data);
					}
				});

			}, 1000*60*5);
		');
		
		$this->tpl->add_css('
			img.mutedeaf {
			    width: 5%;
			    vertical-align: middle;
			}
				
			img.moremutedeaf {
			    width: 5.5%;
			    vertical-align: middle;
			}
				
			.discord-avatar-img {
			    border-radius:100%;
			    width: 22px;
			    display:inline;
			    margin-top: 3px;
			    margin-bottom: 0px;
			    margin-right:5px!important;
			    vertical-align:middle
			}
				
			.discord-status {
			    border-radius:100%;
			    width: 8px;
			    border:solid 1px #fff!important;
			    border-color:#282b30!important;
			    display:inline;
			    margin-top: 14px;
			    margin-left: -17px;
			    vertical-align:middle
			}
				
			.discord-game {
			    -ms-flex: 1;
			    -webkit-box-flex: 1;
			    flex: 1;
			    overflow: hidden;
			    text-align: right;
			    text-overflow: ellipsis;
			    white-space: nowrap;
				width: 30px;
				font-style: italic;
				font-size: 0.8em;
				margin-left: 5px;
				padding-right: 5px;
			}
				
			.discord-member {
			    -ms-flex-align: center;
			    -webkit-box-align: center;
			    align-items: center;
			    display: -webkit-box;
			    display: -ms-flexbox;
			    display: flex;
			    margin: 6px 0;
			    padding-left: 10px;
			}
				
			.discord-name {
			    -ms-flex: 1;
			    -webkit-box-flex: 1;
			    flex: 1;
			    overflow: hidden;
			    text-overflow: ellipsis;
			    white-space: nowrap;
			}
				
			.discord-channel {
				font-size: 1.2em;
			}
				
			.discord-channel-container {
				margin-bottom: 8px;
			}
				
		', true);
		
		$intHeight = intval($this->config('discord_height'));
		
		if($this->config('discord_height') != "" && $intHeight){
			$this->tpl->add_css('
			#portalbox'.$moduleID.' .discordViewer {
				max-height: '.$intHeight.'px;
				overflow: scroll;
				overflow-x: hidden;
			}
					
			', true);
		}

		return '<div class="discord_'.$moduleID.'_container">'.$out.'</div>';
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