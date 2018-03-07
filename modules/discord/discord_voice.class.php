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
		$serverID = $this->config('discord_serverid');
		$height = ($this->config('discord_height')) ? $this->config('discord_height') : 500;
		$width = ($this->config('discord_width')) ? $this->config('discord_width') : '';
		$strUsername = ($this->user->id > 0) ? '&username='.sanitize($this->user->data['username']) : '';
		
		$strTheme =  ($this->config('discord_theme')) ? $this->config('discord_theme') : 'dark';
		
		if($serverID){
			$out = '<iframe src="https://discordapp.com/widget?id='.$serverID.'&theme='.$strTheme.$strUsername.'" height="'.$height.'" width="'.$width.'" allowtransparency="true" frameborder="0"></iframe>';
			
		}

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