
<?php
/*	Project:	EQdkp-Plus
 *	Package:	EQdkp-Plus Language File
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

 
if (!defined('EQDKP_INC')) {
	die('You cannot access this file directly.');
}

//Language: English	
//Created by EQdkp Plus Translation Tool on  2014-12-17 23:17
//File: portal/voice/language/english.php
//Source-Language: german

$lang = array( 
	"voice" => 'Voiceserver Viewer',
	"voice_name" => 'Voiceserver Viewer',
	"voice_desc" => 'Viewer for Voiceserver like Teamspeak3, Mumble or Ventrilo',
	"voice_f_module" => 'Select your Voiceserver',
	"mumble" => 'Mumble',
	"voice_f_mumble_datauri" => 'Data URI',
	"voice_f_help_mumble_datauri" => 'Enter the CVP Uniform Resource Identifier given to you by your hosting provider.',
	"voice_f_mumble_dataformat" => 'Data Format',
	"voice_f_help_mumble_dataformat" => 'Select the data format specified by your hosting provider.',
	"voice_f_mumble_linkuri" => 'Link URI',
	"voice_f_help_mumble_linkuri" => 'Optional: Enter the mumble:// link address to join your server. It is used only, when your servers data does not include it.',
	"voice_f_mumble_iconstyle" => 'Icon Style',
	"voice_f_help_mumble_iconstyle" => 'Select the style of icons that prefer.',
	"ts3" => 'Teamspeak 3',
	"voice_f_ts3_ip" => 'Your Server IP (without Port)',
	"voice_f_ts3_port" => 'The port - Default: 9987',
	"voice_f_ts3_telnetport" => 'The Telnet Port of your Server - Default: 10011',
	"voice_f_ts3_id" => 'The ID from your Virtual Server - Default: 1',
	"voice_f_help_ts3_id" => 'Enter -1 to use the servers port to connect instead of the servers id.',
	"voice_f_ts3_cache" => 'Min. time between TS3-querys (seconds)',
	"voice_f_help_ts3_cache" => 'How long should the TS3-data be cached in seconds before TS3 ist queried again. 0 for disable caching.',
	"voice_f_ts3_banner" => 'Shows banner if URL is avaible in TS?',
	"voice_f_ts3_join" => 'Show link to join the server?',
	"voice_f_ts3_jointext" => 'Link text of the link to join the server',
	"voice_f_ts3_legend" => 'Show groupinfo at the bottom?',
	"voice_f_ts3_cut_names" => 'Cut Usernames',
	"voice_f_help_ts3_cut_names" => 'If you want to abridge the usernames, set this to the desired size - No cut = 0',
	"voice_f_ts3_cut_channel" => 'Cut Channelnames',
	"voice_f_help_ts3_cut_channel" => 'If you want to abridge the channelnames, set this to the desired size - No cut = 0',
	"voice_f_only_populated_channel" => 'Show only populated channels?',
	"voice_f_ts3_useron" => 'Show Online User / Possible Users?',
	"voice_f_ts3_stats" => 'Show a statistic box under the TS viewer?',
	"voice_f_ts3_stats_showos" => 'Show on wich OS TS3 runs?',
	"voice_f_ts3_stats_version" => 'Show the TS3 server version?',
	"voice_f_ts3_stats_numchan" => 'Show the number of channels?',
	"voice_f_ts3_stats_uptime" => 'Show the server uptime since the last restart?',
	"voice_f_ts3_stats_install" => 'Show when the server was installed?',
	"voice_f_ts3_timeout" => 'Timeout (DON\'T change)',
	"voice_f_help_ts3_timeout" => 'Leave this field blank, unless you are very sure what you are doing!',
	"voice_f_ts3_show_spacer" => 'Show Channel Spacer',
	"lang_ts3_user_online" => 'User online',
	"lang_ts3_stats" => 'Statistics',
	"lang_ts3_legend" => 'Legend',
	"lang_ts3_uptime" => array(
	0 => 'Days',
	1 => 'Hours',
	2 => 'Min',
	),
	"ventrilo" => 'Ventrilo',
	"voice_f_ventrilo_server" => 'Enter the ventrilo server address',
	"voice_f_ventrilo_port" => 'Enter the ventrilo server port',
	"voice_f_ventrilo_backgroundc" => 'Enter the 6 digit hex color for the BACKGROUND (TTTTTT = transparent (http://www.computerhope.com/htmcolor.htm))',
	"voice_f_ventrilo_channelc" => 'Enter the 6 digit hex color for the CHANNEL color',
	"voice_f_ventrilo_servercolor" => 'Enter the 6 digit hex color for the SERVER color',
	"voice_f_ventrilo_usercolor" => 'Enter the 6 digit hex color for the USER NAME color',
		
		'discord'						=> 'Discord',
		'voice_f_discord_serverid'		=> 'Server-ID',
		'voice_f_discord_height'		=> 'Height (in Pixels)',
		'voice_f_discord_connect'		=> 'Connect',
		'voice_f_discord_showonline'		=> 'Show online members',
		'voice_f_discord_hideempty' => 'Hide empty Voicechannels',
		'voice_f_discord_hidegame' => 'Hide played game',
);

?>