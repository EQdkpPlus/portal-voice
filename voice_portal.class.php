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
 * $Id: voice_portal.class.php 12321 2012-10-22 18:15:33Z godmod $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

class voice_portal extends portal_generic {
	protected static $path		= 'voice';
	protected static $data		= array(
		'name'			=> 'Voice Server',
		'version'		=> '0.1.0',
		'author'		=> 'GodMod',
		'icon'			=> 'fa-microphone',
		'contact'		=> EQDKP_PROJECT_URL,
		'description'	=> 'Voice Server',
		'multiple'		=> true,
		'reload_on_vis'	=> true,
		'lang_prefix'	=> 'voice_'
	);
	protected static $positions = array('left1', 'left2', 'right');
	
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
				'ts3_hide_spacer'		=> array(
					'type'		=> 'radio',
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
					'size'      => '30',
				),
				'mumble_dataformat'	=> array(
					'type'  	=> 'dropdown',
					'size'      => '30',
					'options'	=> array('json' => 'JSON', 'xml' => 'XML'),
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