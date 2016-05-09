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

class voice_portal extends portal_generic {
	protected static $path		= 'voice';
	protected static $data		= array(
		'name'			=> 'Voice Server',
		'version'		=> '0.1.5',
		'author'		=> 'GodMod',
		'icon'			=> 'fa-microphone',
		'contact'		=> EQDKP_PROJECT_URL,
		'description'	=> 'Voice Server',
		'multiple'		=> true,
		'reload_on_vis'	=> true,
		'lang_prefix'	=> 'voice_'
	);
	protected static $positions = array('left1', 'left2', 'right');
	
	protected static $apiLevel = 20;
	
	public function get_settings($state){
		$settings	= array(
			'module'	=> array(
				'type'		=> 'dropdown',
				'class'		=> 'js_reload',
				'options'	=> array(
					'ts3'		=> 'Teamspeak 3',
					'mumble'	=> 'Mumble',
					'ventrilo'	=> 'Ventrilo',
				),
			),
		);
		
		$strModule = $this->config('module');
		if (!strlen($strModule)) $strModule = "ts3";
		
		if ($strModule == 'ts3'){
			$ts3_settings	= array(
				'ts3_ip'		=> array(
					'type'	=> 'text',
					'size'		=> '15',
				),
				'ts3_port'		=> array(
					'type'		=> 'text',
					'size'		=> '5',
				),
				'ts3_telnetport'		=> array(
					'type'		=> 'text',
					'size'		=> '5',
				),
				'ts3_id'		=> array(
					'type'		=> 'text',
					'size'		=> '2',
				),
				'ts3_cache'		=> array(
					'type'		=> 'text',
					'size'		=> '2',
				),
				'ts3_banner'		=> array(
					'type'		=> 'radio',
				),
				'ts3_join'		=> array(
					'type'		=> 'radio',
				),
				'ts3_jointext'		=> array(
					'type'		=> 'text',
					'size'		=> '30',
				),
				'ts3_legend'		=> array(
					'type'		=> 'radio',
				),
				'ts3_cut_names'		=> array(
					'type'		=> 'text',
					'size'		=> '2',
				),
				'ts3_cut_channel'	=> array(
					'type'		=> 'text',
					'size'		=> '2',
				),
				'only_populated_channel'		=> array(
					'type'		=> 'radio',
				),
				'ts3_useron'		=> array(
					'type'		=> 'radio',
				),
				'ts3_stats'		=> array(
					'type'		=> 'radio',
				),
				'ts3_stats_showos'		=> array(
					'type'		=> 'radio',
				),
				'ts3_stats_version'		=> array(
					'type'		=> 'radio',
				),
				'ts3_stats_numchan'		=> array(
					'type'		=> 'radio',
				),
				'ts3_stats_uptime'		=> array(
					'type'		=> 'radio',
				),
				'ts3_stats_install'		=> array(
					'type'		=> 'radio',
				),
				'ts3_timeout'		=> array(
					'type'		=> 'text',
					'size'		=> '20',
				),
				'ts3_show_spacer' => array(
					'type'		=> 'radio',
					'default'	=> 1,
				),
			);
			$settings = array_merge($settings, $ts3_settings);
		} elseif($strModule == "ventrilo"){
			$ventrilo_settings	= array(
				'ventrilo_server'		=> array(
					'type'		=> 'text',
					'size'		=> '50',
				),
				'ventrilo_port'			=> array(
					'type'		=> 'text',
					'size'		=> '30',
				),
				'ventrilo_backgroundc'	=> array(
					'type'		=> 'text',
					'size'		=> '6',
				),
				'ventrilo_channelc'		=> array(
					'type'		=> 'text',
					'size'		=> '6',
				),
				'ventrilo_servercolor'	=> array(
					'type'		=> 'text',
					'size'		=> '6',
				),
				'ventrilo_usercolor'	=> array(
					'type'		=> 'text',
					'size'		=> '6',
				)
			);
			$settings = array_merge($settings, $ventrilo_settings);
		} elseif($strModule == "mumble"){
			$mumble_settings	= array(
				'mumble_datauri'		=> array(
					'type'  	=> 'text',
					'size'		=> '30',
				),
				'mumble_dataformat'	=> array(
					'type'  	=> 'dropdown',
					'size'		=> '30',
					'options'	=> array('json' => 'JSON', 'xml' => 'XML'),
				),
				'mumble_linkuri' 		=> array(
					'type'		=> 'text',
					'size'		=> '30',
				),
				'mumble_iconstyle'		=> array(
					'type'		=> 'dropdown',
					'options'	=> array('mumbleViewerIconsDefault' => 'Default', 'mumbleViewerIconsFarCry2' => 'Far Cry 2', 'mumbleViewerIconsNextGen' => 'NextGen', 'mumbleViewerIconsSCGermania' => 'SC Germania'),
				)
			);
			$settings = array_merge($settings, $mumble_settings);
		}
		
		return $settings;
	}

	public function output() {
		$strModule = $this->config('module');
		if (!strlen($strModule)) $strModule = "ts3";
		
		$arrSettingsArray = $this->get_settings('fetch_new');
		$arrOptions = array();
		foreach($arrSettingsArray as $key => $value){
			$arrOptions[$key] = $this->config($key);
		}
		
		$out = "";
		if($strModule == "ts3"){
			include_once($this->root_path.'portal/voice/modules/teamspeak3/teamspeak3_voice.class.php');
			$ts3 = registry::register('teamspeak3_voice', array($arrOptions));
			$out = $ts3->output();
		} elseif($strModule == "ventrilo"){
			include_once($this->root_path.'portal/voice/modules/ventrilo/ventrilo_voice.class.php');
			$ventrilo = new ventrilo_voice($arrOptions);
			$out = $ventrilo->output();
		} elseif($strModule == "mumble"){
			include_once($this->root_path.'portal/voice/modules/mumble/mumble_voice.class.php');
			$mumble = registry::register('mumble_voice', array($arrOptions));
			$out = $mumble->output();
		}
		
		$this->header = $this->user->lang($strModule);
		return $out;
	}
}
?>
