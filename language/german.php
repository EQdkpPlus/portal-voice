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

$lang = array(
	'voice'							=> "Voiceserver Viewer",
	'voice_name'					=> "Voiceserver Viewer",
	'voice_desc'					=> "Viewer für Voiceserver wie Teamspeak3, Mumble oder Ventrilo",
	'voice_f_module'				=> "Voiceserver auswählen",

	//Mumble
	'mumble'     					=> 'Mumble',
	'voice_f_mumble_datauri'   		=> 'Data URI',
	'voice_f_help_mumble_datauri'   => 'Enter the CVP Uniform Resource Identifier given to you by your hosting provider.',
	'voice_f_mumble_dataformat'     => 'Data Format',
	'voice_f_help_mumble_dataformat'=> 'Select the data format specified by your hosting provider.',
	'voice_f_mumble_linkuri'	=> 'Link URI',
	'voice_f_help_mumble_linkuri'	=> 'Optional: Enter the link address to join your server.',
	'voice_f_mumble_iconstyle'	=> 'Icon Stil',
	'voice_f_help_mumble_iconstyle'	=> 'Select the style of icons that prefer.',

	//Teamspeak 3
	'ts3'							=> 'Teamspeak 3',
	'voice_f_ts3_ip'				=> 'Die Server IP (ohne Port)',
	'voice_f_ts3_port'				=> 'Der Port - Standard: 9987',
	'voice_f_ts3_telnetport'		=> 'Der Telnet Port deines Servers - Standard: 10011',
	'voice_f_ts3_id'				=> 'Die ID deines Server - Standard: 1',
	'voice_f_help_ts3_id'			=> 'Gib -1 ein um anstatt der ID den Port deines Server zum Verbinden zu nutzen.',
	'voice_f_ts3_cache'				=> 'Mindestabstand zwischen TS3-Abfragen (Sekunden)',
	'voice_f_help_ts3_cache'		=> 'Gibt in Sekunden an wie lange vom TS3 abgefragte Daten zwischengespeichert werden sollen bevor der TS3 neu abgefragt wird. 0 um das Zwischenspeichern abzuschalten.',
	'voice_f_ts3_banner'			=> 'Zeige das Banner, welches du im TS eingestellt hast?',
	'voice_f_ts3_join'				=> 'Zeige Link zum Beitreten des TS-Servers?',
	'voice_f_ts3_jointext'			=> 'Text des Links zum Beitreten des TS-Servers',
	'voice_f_ts3_legend'			=> 'Zeig unter der Tabelle eine Übersicht der Gruppen an?',
	'voice_f_ts3_cut_names'			=> 'Benutzernamen kürzen',
	'voice_f_help_ts3_cut_names'	=> 'Wenn du die Usernamen auf eine bestimmte Länge kürzen willst, gib hier die Anzahl der Zeichen ein - Kein Kürzen = 0',
	'voice_f_ts3_cut_channel'		=> 'Channelnamen kürzen',
	'voice_f_help_ts3_cut_channel'	=> 'Wenn du die Channelnamen auf eine bestimmte Länge kürzen willst, gib hier die Anzahl der Zeichen ein - Kein Kürzen = 0',
	'voice_f_only_populated_channel'=> 'Zeige nur Channel an, in denen sich auch jemand befindet?',
	'voice_f_ts3_useron'			=> 'Zeige die Anzahl der Online User und möglichen User an?',
	'voice_f_ts3_stats'				=> 'Zeige eine Statistikbox unter dem TS3-Viewer?',
	'voice_f_ts3_stats_showos'		=> 'Zeige das OS des Servers in der Statistikbox?',
	'voice_f_ts3_stats_version'		=> 'Zeige die Version des Servers in der Statistikbox?',
	'voice_f_ts3_stats_numchan'		=> 'Zeige die Channelanzahl des Servers in der Statistikbox?',
	'voice_f_ts3_stats_uptime'		=> 'Zeige die Laufzeit des Servers in der Statistikbox?',
	'voice_f_ts3_stats_install'		=> 'Zeige das Installationsdatum des Servers in der Statistikbox?',
	'voice_f_ts3_timeout'			=> 'Timeout (NICHT ändern)',
	'voice_f_help_ts3_timeout'		=> 'Dieses Feld dringend leer lassen, es sei denn du weißt ganz genau was du tust!',
	'voice_f_ts3_show_spacer'		=> 'Zeige Channel-Spacer an',
	'lang_ts3_user_online'			=> 'User online',	
	'lang_ts3_stats'				=> 'Statistiken',
	'lang_ts3_legend'				=> 'Legende',
	'lang_ts3_uptime'				=> array('Tage', 'Stunden', 'Minuten'),

	//Ventrilo
	'ventrilo'						=> 'Ventrilo',
	'voice_f_ventrilo_server'		=> 'IP Adresse des Ventrilo Servers',
	'voice_f_ventrilo_port'			=> 'Port des Ventrilo Servers',
	'voice_f_ventrilo_backgroundc'	=> 'Hex Code der Hintrgrundfarbe (6 Stellen) (TTTTTT = für Transparent (http://www.computerhope.com/htmcolor.htm))',
	'voice_f_ventrilo_channelc'		=> 'Hex Code der Channelfarbe',
	'voice_f_ventrilo_servercolor'	=> 'Hex Code der Serverfarbe',
	'voice_f_ventrilo_usercolor'	=> 'Hex Code der Usernamefarbe',
);
?>
