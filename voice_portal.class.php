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
	public static function __shortcuts() {
		$shortcuts = array('core', 'pdc', 'config', 'tpl', 'user');
		return array_merge(parent::$shortcuts, $shortcuts);
	}

	protected $path		= 'voice';
	protected $data		= array(
		'name'			=> 'Voice Server',
		'version'		=> '0.1.0',
		'author'		=> 'GodMod',
		'contact'		=> EQDKP_PROJECT_URL,
		'description'	=> 'Voice Server',
	);
	protected $positions = array('left1', 'left2', 'right');
	
	public $LoadSettingsOnchangeVisibility = true;

	public function get_settings($state){
		$settings	= array(
			'pk_voice_module'	=> array(
					'name'		=> 'pk_voice_module',
					'language'	=> 'pk_voice_module',
					'property'	=> 'dropdown',
					'help'		=> '',
					'options'	=> array(
							'ts3'		=> 'Teamspeak 3',
							'mumble'	=> 'Mumble',
							'ventrilo'	=> 'Ventrilo',
					),
					'javascript'=> 'onchange="load_settings()"',
			),
		);
		
		$strModule = $this->config('pk_voice_module');
		
		if ($strModule == 'ts3'){
			$ts3_settings	= array(
					'pk_ts3_ip'		=> array(
							'name'		=> 'pk_ts3_ip',
							'language'	=> 'lang_pk_ts3_ip',
							'property'	=> 'text',
							'size'		=> '15',
							'help'		=> '',
					),
					'pk_ts3_port'		=> array(
							'name'		=> 'pk_ts3_port',
							'language'	=> 'lang_pk_ts3_port',
							'property'	=> 'text',
							'size'		=> '5',
							'help'		=> '',
					),
					'pk_ts3_telnetport'		=> array(
							'name'		=> 'pk_ts3_telnetport',
							'language'	=> 'lang_pk_ts3_telnetport',
							'property'	=> 'text',
							'size'		=> '5',
							'help'		=> '',
					),
					'pk_ts3_id'		=> array(
							'name'		=> 'pk_ts3_id',
							'language'	=> 'lang_pk_ts3_id',
							'property'	=> 'text',
							'size'		=> '2',
							'help'		=> 'lang_help_pk_ts3_id',
					),
					'pk_ts3_cache'		=> array(
							'name'		=> 'pk_ts3_cache',
							'language'	=> 'lang_pk_ts3_cache',
							'property'	=> 'text',
							'size'		=> '2',
							'help'		=> 'lang_help_pk_ts3_cache',
					),
					'pk_ts3_banner'		=> array(
							'name'		=> 'pk_ts3_banner',
							'language'	=> 'lang_pk_ts3_banner',
							'property'	=> 'checkbox',
							'size'		=> false,
							'options'	=> false,
							'help'		=> '',
					),
					'pk_ts3_join'		=> array(
							'name'		=> 'pk_ts3_join',
							'language'	=> 'lang_pk_ts3_join',
							'property'	=> 'checkbox',
							'size'		=> false,
							'options'	=> false,
							'help'		=> '',
					),
					'pk_ts3_jointext'		=> array(
							'name'		=> 'pk_ts3_jointext',
							'language'	=> 'lang_pk_ts3_jointext',
							'property'	=> 'text',
							'size'		=> '30',
							'help'		=> '',
					),
					'pk_ts3_legend'		=> array(
							'name'		=> 'pk_ts3_legend',
							'language'	=> 'lang_pk_ts3_legend',
							'property'	=> 'checkbox',
							'size'		=> false,
							'options'	=> false,
							'help'		=> '',
					),
					'pk_ts3_cut_names'		=> array(
							'name'		=> 'pk_ts3_cut_names',
							'language'	=> 'lang_pk_ts3_cut_names',
							'property'	=> 'text',
							'size'		=> '2',
							'help'		=> 'lang_help_pk_ts3_cut_names',
					),
					'pk_ts3_cut_channel'		=> array(
							'name'		=> 'pk_ts3_cut_channel',
							'language'	=> 'lang_pk_ts3_cut_channel',
							'property'	=> 'text',
							'size'		=> '2',
							'help'		=> 'lang_help_pk_ts3_cut_channel',
					),
					'pk_only_populated_channel'		=> array(
							'name'		=> 'pk_only_populated_channel',
							'language'	=> 'lang_pk_only_populated_channel',
							'property'	=> 'checkbox',
							'size'		=> false,
							'options'	=> false,
							'help'		=> '',
					),
					'pk_ts3_useron'		=> array(
							'name'		=> 'pk_ts3_useron',
							'language'	=> 'lang_pk_ts3_useron',
							'property'	=> 'checkbox',
							'size'		=> false,
							'options'	=> false,
							'help'		=> '',
					),
					'pk_ts3_stats'		=> array(
							'name'		=> 'pk_ts3_stats',
							'language'	=> 'lang_pk_ts3_stats',
							'property'	=> 'checkbox',
							'size'		=> false,
							'options'	=> false,
							'help'		=> '',
					),
					'pk_ts3_stats_showos'		=> array(
							'name'		=> 'pk_ts3_stats_showos',
							'language'	=> 'lang_pk_ts3_stats_showos',
							'property'	=> 'checkbox',
							'size'		=> false,
							'options'	=> false,
							'help'		=> '',
					),
					'pk_ts3_stats_version'		=> array(
							'name'		=> 'pk_ts3_stats_version',
							'language'	=> 'lang_pk_ts3_stats_version',
							'property'	=> 'checkbox',
							'size'		=> false,
							'options'	=> false,
							'help'		=> '',
					),
					'pk_ts3_stats_numchan'		=> array(
							'name'		=> 'pk_ts3_stats_numchan',
							'language'	=> 'lang_pk_ts3_stats_numchan',
							'property'	=> 'checkbox',
							'size'		=> false,
							'options'	=> false,
							'help'		=> '',
					),
					'pk_ts3_stats_uptime'		=> array(
							'name'		=> 'pk_ts3_stats_uptime',
							'language'	=> 'lang_pk_ts3_stats_uptime',
							'property'	=> 'checkbox',
							'size'		=> false,
							'options'	=> false,
							'help'		=> '',
					),
					'pk_ts3_stats_install'		=> array(
							'name'		=> 'pk_ts3_stats_install',
							'language'	=> 'lang_pk_ts3_stats_install',
							'property'	=> 'checkbox',
							'size'		=> false,
							'options'	=> false,
							'help'		=> '',
					),
					'pk_ts3_timeout'		=> array(
							'name'		=> 'pk_ts3_timeout',
							'language'	=> 'lang_pk_ts3_timeout',
							'property'	=> 'text',
							'size'		=> '20',
							'help'		=> 'lang_help_pk_ts3_timeout',
					),
					'pk_ts3_hide_spacer'		=> array(
							'name'		=> 'pk_ts3_hide_spacer',
							'language'	=> 'lang_pk_ts3_hide_spacer',
							'property'	=> 'checkbox',
							'size'		=> false,
							'options'	=> false,
							'help'		=> '',
					),
			);
			$settings = array_merge($settings, $ts3_settings);
		} elseif($strModule == "ventrilo"){
			$ventrilo_settings	= array(
					'pk_ventrilo_server'	=> array(
							'name'		=> 'pk_ventrilo_server',
							'language'	=> 'pk_ventrilo_server',
							'property'	=> 'text',
							'size'		=> '50',
							'help'		=> '',
					),
					'pk_ventrilo_port'	=> array(
							'name'		=> 'pk_ventrilo_port',
							'language'	=> 'pk_ventrilo_port',
							'property'	=> 'text',
							'size'		=> '30',
							'help'		=> '',
					),
					'pk_ventrilo_backgroundc'	=> array(
							'name'		=> 'pk_ventrilo_backgroundc',
							'language'	=> 'pk_ventrilo_backgroundc',
							'property'	=> 'text',
							'size'		=> '6',
							'help'		=> '',
					),
					'pk_ventrilo_channelc'	=> array(
							'name'		=> 'pk_ventrilo_channelc',
							'language'	=> 'pk_ventrilo_channelc',
							'property'	=> 'text',
							'size'		=> '6',
							'help'		=> '',
					),
					'pk_ventrilo_servercolor'	=> array(
							'name'		=> 'pk_ventrilo_servercolor',
							'language'	=> 'pk_ventrilo_servercolor',
							'property'	=> 'text',
							'size'		=> '6',
							'help'		=> '',
					),
					'pk_ventrilo_usercolor'	=> array(
							'name'		=> 'pk_ventrilo_usercolor',
							'language'	=> 'pk_ventrilo_usercolor',
							'property'	=> 'text',
							'size'		=> '6',
							'help'		=> '',
					)
			);
			$settings = array_merge($settings, $ventrilo_settings);
		} elseif($strModule == "mumble"){
			$mumble_settings	= array(
					'pk_mumbleviewer_datauri'     => array(
							'name'      => 'pk_mumbleviewer_datauri',
							'language'  => 'pk_mumbleviewer_datauri',
							'property'  => 'text',
							'size'      => '30',
							'help'      => 'pk_mumbleviewer_datauri_help',
					),
					'pk_mumbleviewer_dataformat'     => array(
							'name'      => 'pk_mumbleviewer_dataformat',
							'language'  => 'pk_mumbleviewer_dataformat',
							'property'  => 'dropdown',
							'size'      => '30',
							'options'	=> array('json' => 'JSON', 'xml' => 'XML'),
							'help'      => 'pk_mumbleviewer_dataformat_help',
					),
					'pk_mumbleviewer_iconstyle'     => array(
							'name'      => 'pk_mumbleviewer_iconstyle',
							'language'  => 'pk_mumbleviewer_iconstyle',
							'property'  => 'dropdown',
							'options'	=> array('mumbleViewerIconsDefault' => 'Default', 'mumbleViewerIconsFarCry2' => 'Far Cry 2', 'mumbleViewerIconsNextGen' => 'NextGen', 'mumbleViewerIconsSCGermania' => 'SC Germania'),
							'help'      => 'pk_mumbleviewer_iconstyle_help',
					)
			);
			$settings = array_merge($settings, $mumble_settings);
		}
		
		return $settings;
	}
		
	protected $multiple = true;

	public function output() {
		$strModule = $this->config('pk_voice_module');
		if (!strlen($strModule)) $strModule = "ts3";
		
		$arrSettingsArray = $this->get_settings('fetch_new');
		$arrOptions = array();
		foreach($arrSettingsArray as $key => $value){
			$arrOptions[$value['name']] = $this->config($value['name']);
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
	
	public function reset(){
		$this->pdc->del_prefix("portal.modul.voice");
	}
}
?>