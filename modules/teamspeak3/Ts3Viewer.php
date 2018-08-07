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

class Ts3Viewer extends gen_class {
	protected $ip, $port, $t_port, $info, $error, $alert, $timeout, $fp, $plist, $clist, $sinfo, $connected, $noError, $cgroups, $sgroups, $ssh_port, $ssh_user, $ssh_pass, $is_ssh, $objssh;
	private $_config = array();
	private $module_id = false;
	
	public function __construct($moduleID) {
		$this->module_id = $moduleID;
		
		//Configuration
		$this->_config['ts3_ip'] = $this->config->get('ts3_ip', 'pmod_'.$this->module_id);
		$this->_config['ts3_port'] = $this->config->get('ts3_port', 'pmod_'.$this->module_id);
		$this->_config['ts3_telnetport'] = $this->config->get('ts3_telnetport', 'pmod_'.$this->module_id);
		$this->_config['ts3_id'] = $this->config->get('ts3_id', 'pmod_'.$this->module_id);
		$this->_config['ts3_cache'] = $this->config->get('ts3_cache', 'pmod_'.$this->module_id);
		$this->_config['ts3_banner'] = $this->config->get('ts3_banner', 'pmod_'.$this->module_id);
		$this->_config['ts3_join'] = $this->config->get('ts3_join', 'pmod_'.$this->module_id);
		$this->_config['ts3_jointext'] = $this->config->get('ts3_jointext', 'pmod_'.$this->module_id);
		$this->_config['ts3_legend'] = $this->config->get('ts3_legend', 'pmod_'.$this->module_id);
		$this->_config['ts3_cut_names'] = $this->config->get('ts3_cut_names', 'pmod_'.$this->module_id);
		$this->_config['ts3_cut_channel'] = $this->config->get('ts3_cut_channel', 'pmod_'.$this->module_id);
		$this->_config['only_populated_channel'] = $this->config->get('only_populated_channel', 'pmod_'.$this->module_id);
		$this->_config['ts3_useron'] = $this->config->get('ts3_useron', 'pmod_'.$this->module_id);
		$this->_config['ts3_stats'] = $this->config->get('ts3_stats', 'pmod_'.$this->module_id);
		$this->_config['ts3_stats_showos'] = $this->config->get('ts3_stats_showos', 'pmod_'.$this->module_id);
		$this->_config['ts3_stats_version'] = $this->config->get('ts3_stats_version', 'pmod_'.$this->module_id);
		$this->_config['ts3_stats_numchan'] = $this->config->get('ts3_stats_numchan', 'pmod_'.$this->module_id);
		$this->_config['ts3_stats_uptime'] = $this->config->get('ts3_stats_uptime', 'pmod_'.$this->module_id);
		$this->_config['ts3_stats_install'] = $this->config->get('ts3_stats_install', 'pmod_'.$this->module_id);
		$this->_config['ts3_timeout'] = $this->config->get('ts3_timeout', 'pmod_'.$this->module_id);
		$this->_config['ts3_show_spacer'] = $this->config->get('ts3_show_spacer', 'pmod_'.$this->module_id);
		
		$this->_config['ts3_sshport'] = $this->config->get('ts3_sshport', 'pmod_'.$this->module_id);
		$this->_config['ts3_sshuser'] = $this->config->get('ts3_sshuser', 'pmod_'.$this->module_id);
		$this->_config['ts3_sshpass'] = $this->config->get('ts3_sshpass', 'pmod_'.$this->module_id);
		
		
		
		
		// INIT variables
		$this->connected = FALSE;
		$this->noError = TRUE;
		$this->is_ssh = FALSE;
		
		// (timeout in microseconds) 1000000 is 1 second - Default: 500000
		if (isset($H_MODE) && $H_MODE) {
			$this->timeout = 500000; // 500000 fixed for hosting-mode
		} else {
			$this->timeout = ($this->_config('ts3_timeout') == '') ? 500000 : $this->_config('ts3_timeout');
		}
		
		// The Server IP (without Port)
		// Die Server IP (ohne Port)
		$this->ip = ($this->_config('ts3_ip') == '') ? '127.0.0.1' : $this->_config('ts3_ip');


		// The port - Default: 9987
		// Der Port - Standart: 9987
		$this->port = ($this->_config('ts3_port') == '') ? '9987' : $this->_config('ts3_port');
		
		// SSH default port 10022
		$this->ssh_port = ($this->_config('ts3_sshport') == '') ? '10022' : $this->_config('ts3_sshport');

		// The Telnet Port of your Server - Default: 10011
		// Der Telnet Port deines Servers - Standart: 10011
		$this->t_port = ($this->_config('ts3_telnetport') == '') ? '10011' : $this->_config('ts3_telnetport');

		// The ID from your Virtual Server - Default: 1
		// Die ID deines Server - Standart - 1
		$this->sid = ($this->_config('ts3_id') == '') ? '1' : $this->_config('ts3_id');
		
		$this->ssh_user = $this->_config('ts3_sshuser');
		$this->ssh_pass = $this->_config('ts3_sshpass');
		
		if($this->ssh_user != "" && $this->ssh_pass != "") $this->is_ssh = true;
		
		$this->info['hide_spacer'] = !(int)$this->_config('ts3_show_spacer');
		
		// Shows banner if URL is avaible in TS - Yes=1 / No=0
		// Zeige das Banner, welches du im TS eingestellt hast - Ja=1 / Nein=0
		$this->info['banner'] = $this->_config('ts3_banner');
		
		// Shows join-link - Yes=1 / No=0
		// Zeige join-Link - Ja=1 / Nein=0
		$this->info['join'] = $this->_config('ts3_join');
		
		//Linktext des join-Links
		$this->info['jointext'] = $this->_config('ts3_jointext');

		// Shows groupinfo at the bottom - Yes=1 / No=0
		// Zeig unter der Tabelle eine Übersicht der Gruppen an - Ja=1 / Nein=0
		$this->info['legend'] = $this->_config('ts3_legend');

		// If you want to abridge the usernames, set this to the desired size - No cut = 0
		// Wenn du die Usernamen auf eine bestimmte Länge kürzen willst, gib hier die Anzahl der Zeichen ein - Kein Kürzen = 0
		$this->info['ts3_cut_names'] = $this->_config('ts3_cut_names');

		// If you want to abridge the channelnames, set this to the desired size - No cut = 0
		// Wenn du die Channelnamen auf eine bestimmte Länge kürzen willst, gib hier die Anzahl der Zeichen ein - Kein Kürzen = 0
		$this->info['ts3_cut_channel'] = $this->_config('ts3_cut_channel');
		
		// Show only populated channels - Yes=1 / No=0
		// Zeige nur bevölkerte Kanäle - Ja=1 / Nein=0
		$this->info['populated_only'] = $this->_config('only_populated_channel');

		// Show Online User / Possible Users - Yes=1 / No=0
		// Zeige die Anzahl der Online User und möglichen User an - Ja=1 / Nein=0
		$this->info['useron'] = $this->_config('ts3_useron');

		//Show a statistic box under the TS viewer. - Yes=1 / No=0
		//Zeigt eine Statistikbox unter dem TS Viewer - Ja=1 / Nein=0
		$this->info['stats'] = $this->_config('ts3_stats');
		
		//You can choose wich serverinfos will shown and change the label - Yes=1 / No=0
		//Du kannst Auswählen welcheServerinfo gezeigt werden soll und welche nicht. Ausserdem kannst Du die Bezeichnung ändern
		
		$this->info['serverinfo']['virtualserver_platform']['show'] = $this->_config('ts3_stats_showos'); //Show on wich OS TS3 run
		$this->info['serverinfo']['virtualserver_platform']['label'] = 'TS3 OS'; 

		$this->info['serverinfo']['virtualserver_version']['show'] = $this->_config('ts3_stats_version'); //Show the TS3 server version
		$this->info['serverinfo']['virtualserver_version']['label'] = 'TS3 Version'; 
		
		$this->info['serverinfo']['virtualserver_channelsonline']['show'] = $this->_config('ts3_stats_numchan'); //Show the number of channels
		$this->info['serverinfo']['virtualserver_channelsonline']['label'] = 'Channnels'; 
		
		$this->info['serverinfo']['virtualserver_uptime']['show'] = $this->_config('ts3_stats_uptime'); //Show the server uptime since the last restart
		$this->info['serverinfo']['virtualserver_uptime']['label'] = 'Uptime';

		$this->info['serverinfo']['virtualserver_created']['show'] = $this->_config('ts3_stats_install'); //Show when the server was installed
		$this->info['serverinfo']['virtualserver_created']['label'] = 'Online since';
	}
	
	public function __destruct() {
		//close the socket
		fclose($this->fp);
		parent::__destruct();
	}
	
	public function gethtml(){
		$htmlout = '';
		if ($this->noError) {
			// if no errors occured generate the html-output
			$htmlout	.= '<div id="tsbody">';
			$htmlout	.= '   <div style="text-align:center">';
			$htmlout	.= $this->banner();
			$htmlout	.= $this->link();
			$htmlout	.= '</div>';
			$htmlout	.= '<div id="tscont">';
			$htmlout	.= '<div class="tsca"><img src="' . $this->server_path . 'portal/voice/modules/teamspeak3/tsimages/serverimg.png'.'" alt="'.$this->replace($this->sinfo['virtualserver_welcomemessage']).'" title="'.$this->replace($this->sinfo['virtualserver_welcomemessage']).'"/></div>';
			$htmlout	.= '<div class="tsca">'.$this->replace($this->sinfo['virtualserver_name']).'</div>';
			$htmlout	.= '<div style="clear:both"></div>';
			$htmlout	.= $this->buildtree('0', '');
			$htmlout	.= $this->useron();
			$htmlout	.= $this->build_legend();
			$htmlout	.= $this->stats();
			$htmlout	.= $this->alerts();
			$htmlout	.= '</div></div>';
		}else{
			// in case of errors just output the error-strings and alerts
			$htmlout	.= $this->errors();
			$htmlout	.= $this->alerts();
		}
		return $htmlout;
	}
	
	public function connect(){
		// establish connection to ts3
		$errno = ''; $errstr = '';
		
		if($this->is_ssh){
			$ssh = new phpseclib\Net\SSH2($this->ip, $this->ssh_port);		
			if (!$ssh->login($this->ssh_user, $this->ssh_pass)) {
				$this->error[] = 'Can not connect to the server (using SSH with Credentials)';
				$this->noError = FALSE;
				$this->connected = FALSE;
				return false;
			} else {
				$this->objssh = $ssh;
				$this->connected = TRUE;
				return true;	
			}
		} else {
			$this->fp = @fsockopen($this->ip, $this->t_port, $errno, $errstr, 1);
			if ($this->fp) {
				stream_set_timeout($this->fp, 0, $this->timeout);
				$msg = $this->read();
				if(strpos($msg, 'TS3') === FALSE){
					$this->error[] = 'Server seems to be no TS3';
					$this->noError = FALSE;
					$this->connected = FALSE;
					return false;
				} else {
					$this->connected = TRUE;
					return true;
				}
			} else {
				$this->error[] = 'Can not connect to the server ('.$errno.')';
				$this->noError = FALSE;
				$this->connected = FALSE;
				return false;
			}
			
		}	
	}
	
	public function disconnect(){
		//send quit-command to the server
		if($this->is_ssh){
			$this->objssh->disconnect();
		} else {
			$cmd = "quit\n";
			fputs($this->fp, $cmd);
		}

		$this->connected = FALSE;
	}
	
	public function query(){
		//do a normal query of relevant server information
		$this->set_sid();
		$this->query_sinfo();
		$this->query_sgroups();
		$this->query_cgroups();
		$this->query_channels();
		$this->query_clients();
	}
	
	protected function set_sid(){
		//sets the sid to use
		if (!($this->connected and $this->noError)) {return;}
		if ($this->sid == '-1') {
			//try port
			$cmd = "use port=".$this->port."\n";
		} else {
			//use sid
			$cmd = "use sid=".$this->sid."\n";
		}
		$select = $this->sendCmd($cmd);
	}
	
	protected function query_sinfo(){
		//querys the server for some general infos
		if (!($this->connected and $this->noError)) {return;}
		$cmd = "serverinfo\n";
		if(!($info = $this->sendCmd($cmd))){
			$this->error[] = 'No Serverstatus';
		}else{
			$this->sinfo = $this->splitInfo($info);
		}
	}
	
	protected function query_channels(){
		//get the channel list
		if (!($this->connected and $this->noError)) {return;}
		$cmd = "channellist -topic -flags -voice -limits\n";
		if(!($clist_t = $this->sendCmd($cmd))){
			$this->error[] = 'No Channellist';
		}else{
			$clist_t = $this->splitInfo2($clist_t);
			foreach ($clist_t as $var) {
				$this->clist[] = $this->splitInfo($var);
			}
		}
	}
	
	protected function query_clients(){
		//get the client list
		if (!($this->connected and $this->noError)) {return;}
		$cmd = "clientlist -uid -away -voice -groups\n";
		if(!($plist_t = $this->sendCmd($cmd))){
			$this->error[] = 'No Playerlist';
		}else{
			$plist_t = $this->splitInfo2($plist_t);
			foreach ($plist_t as $var) {
				if(strpos($var, 'client_type=0') !== FALSE) {
					$this->plist[] = $this->splitInfo($var);
				}
			}
			if($this->plist != ''){
				foreach ($this->plist as $key => $var) {
					$temp = '';
					if(strpos($var['client_servergroups'], ',') !== FALSE){
						$temp = explode(',', $var['client_servergroups']);
					}else{
						$temp[0] = $var['client_servergroups'];
					}
					$this->plist[$key]['client_servergroups'] = $temp;
				}
				usort($this->plist, "ts3_cmp_group");
				//usort($this->plist, "ts3_cmp_admin");
			}

		}
	}
	
	protected function query_cgroups(){
		if (!($this->connected and $this->noError)) {return;}
		$cmd = "channelgrouplist\n";
		if(!($plist_t = $this->sendCmd($cmd))){
			$this->error[] = 'No Grouplist';
		}else{
			$plist_t = $this->splitInfo2($plist_t);
			foreach ($plist_t as $var) {
				$arr = $this->splitInfo($var);
				$this->cgroups[$arr['cgid']] = $arr;
			}
		}
	}
	
	protected function query_sgroups(){
		if (!($this->connected and $this->noError)) {return;}
		$cmd = "servergrouplist\n";
		if(!($plist_t = $this->sendCmd($cmd))){
			$this->error[] = 'No Grouplist';
		}else{
			$plist_t = $this->splitInfo2($plist_t);
			foreach ($plist_t as $var) {
				$arr = $this->splitInfo($var);
				$this->sgroups[$arr['sgid']] = $arr;
			}
		}
	}

	protected function link(){
		//generate the join-link
		$return = '';
		if($this->info['join'] == 1){
			$return = '<h3><a href="ts3server://'.$this->ip.'?port='.$this->port.'">'.$this->info['jointext'].'</a></h3>';
		}
		return $return;
	}
	
	protected function parse_error($msg){
		//add infos to known error-codes
		if (strpos($msg, 'error id=3329') !== false) {
			$this->error[] = 'Queryclient has ban, check flooding settings. Please take a look at the <a href="'.EQDKP_WIKI_URL.'/de/index.php/Teamspeak3">wiki</a>';
		}
		if (strpos($msg, 'error id=3331') !== false) {
			$this->error[] = 'Queryclient has ban, check flooding settings. Please take a look at the <a href="'.EQDKP_WIKI_URL.'/de/index.php/Teamspeak3">wiki</a>';
		}
		if (strpos($msg, 'error id=2568') !== false) {
			$this->error[] = 'Missing permissions to query the server, check your permission-settings in your TS3-Server';
		}
		return $msg;
	}
	
	protected function _formatSSH($strResult){
		$arrResult = explode("\n", $strResult);	
		unset($arrResult[0]);
		return $arrResult;
	}
	
	protected function sendCmd($cmd){
		if($this->is_ssh){
			$this->objssh->setTimeout(0.1);
			$d= $this->objssh->read($this->ssh_user.">");
			$c = $this->objssh->write($cmd);
			$this->objssh->setTimeout(0.1);
			$d= $this->objssh->read();
			
			$arrResult = $this->_formatSSH($d);
			if(count($arrResult) > 1){
				return $arrResult[1];
			} else {
				$this->error[] = $this->parse_error($this->replace($arrResult[1]));
				$this->noError = FALSE;
				return false;
			}
		}
		
		
		//sends a command to ts3 and gets the answer
		$msg = '';
		if ($this->connected and $this->noError){
			fputs($this->fp, $cmd);
			$msg = $this->read();
		} else {
			$msg = "No Connection or Connection lost";
		}
		if(!strpos($msg, 'msg=ok')){
			if (strlen($msg) > 0 and (strpos($msg, 'msg='))) {
				$this->error[] = $this->parse_error($this->replace($msg));
			}
			$this->noError = FALSE;
			return false;
		}else{
			return $msg;
		}
	}

	protected function read(){
		//read the answer from stream
		$msg = '';
		do {
			$msg .= fgets($this->fp);
			$meta = stream_get_meta_data($this->fp);
		} while (($meta['unread_bytes'] > 0) and (!$meta['timed_out']) and (strpos($msg, 'msg=ok') === FALSE) and (trim($msg) != "TS3"));
		if ($meta['timed_out']) {
			$this->alert[] = 'query timed out';
		}
		return $msg;
	}

	protected function splitInfo($info){
		//parses the output
		$info = trim(str_replace('error id=0 msg=ok', '', $info));
		$info = explode(' ', $info);
		foreach ($info as $var) {
			if(strpos($var, '=')=== FALSE){
				$return[$var] = '';
			}else{
				$return[substr($var, 0, (strpos($var, '=')))] = substr($var, (strpos($var, '=')+1));
			}
		}
		return $return;
	}

	protected function splitInfo2($info){
		//parses the output
		$info = trim(str_replace('error id=0 msg=ok', '', $info));
		$info = explode('|', $info);
		return $info;
	}

	protected function num_clients_recursive($chan_id){
		//returns the number of clients in the channel with id=$chan_id and all subchannels
		$count = 0;
		foreach ($this->clist as $key => $var) {
			if($var['cid'] == $chan_id){
				$count += $var['total_clients'];
			}
			if($var['pid'] == $chan_id){
				$count += $this->num_clients_recursive($var['cid'], $this->clist);
			}
		}
		return $count;
	}

	protected function buildtree($id,$platzhalter){
		//builds up the tree of channels and users in html
		$return = '';
		if($this->noError){
			foreach ($this->clist as $key => $var) {
				if($var['pid'] == $id){
				
					if ($this->channelIsSpacer($var)){
						if (!$this->info['hide_spacer']){
							$SpacerType = $this->channelSpacerGetType($var['channel_name']);
							$SpacerAlign = $this->channelSpacerGetAlign($var['channel_name']);
							if ($SpacerType == 'custom'){
								$return .='<div class="tsleer">&nbsp;</div>';
								$channelname = substr($var['channel_name'], strpos($var['channel_name'], ']')+1);
								switch($SpacerAlign){
									case 'left': $return .= '<div style="text-align:left">'.$this->cut_channel($channelname).'</div>'; break;
									case 'right': $return .= '<div style="text-align:right">'.$this->cut_channel($channelname).'</div>'; break;
									case 'center': $return .= '<div style="text-align:center">'.$this->cut_channel($channelname).'</div>'; break;
									case 'repeat': 
										$channelname = str_repeat($channelname, 5);
										$return .= '<div style="text-align:center">'.$this->cut_channel($channelname).'</div>';
									break;
								}
							} else {
								switch($SpacerType){
									case 'solidline': $return .= '<div style="border-bottom:1px solid;margin-left:20px; margin-top:2px; margin-bottom:2px; height:2px;">&nbsp;</div>'; break;
									case 'dashdotline':
									case 'dashline': $return .= '<div style="border-bottom:1px dashed;margin-left:20px; margin-top:2px; margin-bottom:2px; height:2px;">&nbsp;</div>'; break;
									case 'dashdotdotline':
									case 'dotline': $return .= '<div style="border-bottom:1px dotted;margin-left:20px; margin-top:2px; margin-bottom:2px; height:2px;">&nbsp;</div>'; break;
								}
							}
							$return .= '<div style="clear:both"></div>'.$this->buildtree($var['cid'],$platzhalter.'<div class="tsleer">&nbsp;</div>');
						}
						
					} else {
			
					
						if(($this->info['populated_only'] != '1') or ($this->num_clients_recursive($var['cid']) >= '1')){
							$return .= $platzhalter;
							$return .= '<div class="tsleer">&nbsp;</div>';
							$return .= '<div class="tsca"><img src="' . $this->server_path . 'portal/voice/modules/teamspeak3/tsimages/channel.png'.'" alt="'.$this->replace($var['channel_topic']).'" title="'.$this->replace($var['channel_topic']).'" /></div>';
							$return .= '<div class="tsca">'.$this->cut_channel($var['channel_name'],$this->info).'</div>';
							if($var['channel_flag_default'] == 1){
								$return .= '<div class="tsca" style="float:right;"><img src="' . $this->server_path . 'portal/voice/modules/teamspeak3/tsimages/home.png'.'" alt="'.$this->replace($var['channel_topic']).'" title="'.$this->replace($var['channel_topic']).'" /></div>';
							}

							if($var['channel_flag_password'] == 1){
								$return .= '<div class="tsca" style="float:right;"><img src="' . $this->server_path . 'portal/voice/modules/teamspeak3/tsimages/schloss.png'.'" alt="'.$this->replace($var['channel_topic']).'" title="'.$this->replace($var['channel_topic']).'" /></div>';
							}

							$return .= '<div style="clear:both"></div>';
						}
						if($var['total_clients'] >= '1'){
							if($this->plist != ''){
								foreach($this->plist as $u_key => $u_var){
									if($u_var['cid'] == $var['cid']){
										$p_img = 'player.png';
										if($u_var['client_input_muted'] == '1'){
											$p_img = 'mic.png';
										}
										if($u_var['client_output_muted'] == '1'){
											$p_img = 'head.png';
										}
										if($u_var['client_away'] == '1'){
											$p_img = 'away.png';
										}
										$g_img = '';
										$arrIcons = $arrGroups = array();
										foreach ($u_var['client_servergroups'] as $sg_var) {
											if (isset($this->sgroups[$sg_var])){
												if ($this->sgroups[$sg_var]['iconid'] > 0) {
													$arrIcons[] = $this->sgroups[$sg_var]['iconid'];
													$arrGroups[(int)$this->sgroups[$sg_var]['iconid']] = $this->replace($this->sgroups[$sg_var]['name']);
												}								
											}
										}
										if (isset($this->cgroups[$u_var['client_channel_group_id']])){
											if ($this->cgroups[$u_var['client_channel_group_id']]['iconid'] > 0) {
												$arrIcons[] = $this->cgroups[$u_var['client_channel_group_id']]['iconid'];
												$arrGroups[intval($this->cgroups[$u_var['client_channel_group_id']]['iconid'])] = $this->replace($this->cgroups[$u_var['client_channel_group_id']]['name']);
											}
										}
										arsort($arrIcons);
										$arrIcons = array_unique($arrIcons);
										foreach($arrIcons as $iconid){
											if(is_file($this->root_path.'portal/voice/modules/teamspeak3/tsimages/group_icon_'.intval($iconid).'.png')){
												$g_img .= '<div class="tsca" style="float:right"><img src="' . $this->server_path . 'portal/voice/modules/teamspeak3/tsimages/group_icon_'.intval($iconid).'.png" alt="'.$arrGroups[intval($iconid)].'" title="'.$arrGroups[intval($iconid)].'"/></div>';
											}
										}
										$return .= $platzhalter.'<div class="tsleer">&nbsp;</div><div class="tsleer">&nbsp;</div><div class="tsca"><img src="'.$this->server_path . 'portal/voice/modules/teamspeak3/tsimages/'.''.$p_img.'" alt="Player" /></div><div class="tsna">'.$this->autolink_username(trim($u_var['client_nickname']), htmlspecialchars($this->cut_names($u_var['client_nickname'],$this->info), ENT_COMPAT | ENT_HTML401, 'UTF-8')).'</div>'.$g_img.'<div style="clear:both"></div>';
									}
								}
							}
						}
						$return .= $this->buildtree($var['cid'],$platzhalter.'<div class="tsleer">&nbsp;</div>');
					}
				}
			}
		}
		return $return;
	}
	
	protected function autolink_username($strUsername, $strCleanedUsername){
		$intUserID = register('pdh')->get('user', 'userid', array($strUsername));
		if($intUserID > 0){
			return '<a href="'.register('routing')->build('user', $strUsername, 'u'.$intUserID).'">'.$strCleanedUsername.'</a>';
		}
		return $strCleanedUsername;
	}
	
	  protected function channelIsSpacer($channel){
		return (preg_match("/\[.*spacer.*\]/", $channel['channel_name']) && (int)$channel["channel_flag_permanent"] && !(int)$channel["pid"]) ? TRUE : FALSE;
	  }
	
	protected function replace($var){
		//some replacements for parsing and displaying ts3-answers
		$search[] = chr(92).chr(92);
		$replace[] = chr(92);
		$search[] = '\/';
		$replace[] = '/';
		$search[] = '\s';
		$replace[] = ' ';
		$search[] = '\p';
		$replace[] = '|';
		$search[] = '[URL]';
		$replace[] = '';
		$search[] = '[/URL]';
		$replace[] = '';
		$search[] = '[b]';
		$replace[] = '';
		$search[] = '[/b]';
		$replace[] = '';

		return sanitize(str_replace($search, $replace, $var));
	}
	
	protected function channelSpacerGetAlign($channelname){

		if(!preg_match("/\[(.*)spacer.*\]/", $channelname, $matches) || !isset($matches[1]))
		{
		  return "";
		}

		switch($matches[1])
		{
		  case "*":
			return 'repeat';

		  case "c":
			return 'center';

		  case "r":
			return 'right';

		  default:
			return 'left';
		}
	}
	
	protected function channelSpacerGetType($channelname){
		$section = substr($channelname, strpos($channelname, ']')+1);
		switch($section)
		{
		  case "___":
			return 'solidline';

		  case "---":
			return 'dashline';

		  case "...":
			return 'dotline';

		  case "-.-":
			return 'dashdotline';

		  case "-..":
			return 'dashdotdotline';

		  default:
			return 'custom';
		}
	}
	
	

	protected function cut_channel($var){
		//cuts channel-names if option is set
		$var = $this->replace($var);
		if($this->info['ts3_cut_channel'] >= '1'){
			$count = strlen($var);
			if($count > $this->info['ts3_cut_channel']){
				$pos = $this->info['ts3_cut_channel']-3;
				if (function_exists("mb_substr")){
					$var = mb_substr($var,0,$pos,'UTF-8').'...';
				} else  $var = substr($var, 0, $pos).'...';

			}
		}
		return $var;
	}
	
	protected function replace_spacer($var){
	
	}

	protected function cut_names($var){
	//cuts user-names if option is set
		$var = $this->replace($var);
		if($this->info['ts3_cut_names'] >= '1'){
			$count = strlen($var);
			if($count > $this->info['ts3_cut_names']){
				$pos = $this->info['ts3_cut_names']-3;
				if (function_exists("mb_substr")){
					$var = mb_substr($var,0,$pos,'UTF-8').'...';		
				} else  $var = substr($var, 0, $pos).'...';
			}
		}
		return $var;
	}

	protected function build_legend(){
		//generates html-ouput for the group legend
		$return = '';
		if($this->info['legend'] == '1'){
			$return .= '<div id="legend" ><h3>'.$this->user->lang('lang_ts3_legend').'</h3>';
			foreach ($this->info['sgroup'] as $var) {
				$return .= '<div class="tsle"><img src="' . $this->server_path . 'portal/voice/modules/teamspeak3/tsimages/'.''.sanitize($var['p']).'" alt="'.sanitize($var['n']).'" /></div>';
				$return .= '<div class="tsle">'.sanitize($var['n']).'</div>';
				$return .= '<div style="clear:both"></div>';
			}
			foreach ($this->info['cgroup'] as $var) {
				$return .= '<div class="tsle"><img src="' . $this->server_path . 'portal/voice/modules/teamspeak3/tsimages/'.''.sanitize($var['p']).'" alt="'.sanitize($var['n']).'" /></div>';
				$return .= '<div class="tsle">'.sanitize($var['n']).'</div>';
				$return .= '<div style="clear:both"></div>';
			}
			$return .= '</div>';
		}
		return $return;
	}

	protected function useron(){
		//generates html-output for the number of user online in ts3
		$return = '';
		if($this->info['useron'] == 1 && isset($this->sinfo['virtualserver_clientsonline'])){
			$return .= '<div class="useron">'.$this->user->lang('lang_ts3_user_online').': '.sanitize(($this->sinfo['virtualserver_clientsonline']-$this->sinfo['virtualserver_queryclientsonline']).'/'.$this->sinfo['virtualserver_maxclients']).' </div>';
		}
		return $return;
	}

	protected function banner(){
		//generates html-output for the ts3-banner if selected in options
		$return = '';
		if($this->info['banner'] == 1 && isset($this->sinfo['virtualserver_hostbanner_gfx_url']) && $this->sinfo['virtualserver_hostbanner_gfx_url'] != ''){
			$return .= '<img id="tsbanner" src="'.$this->replace($this->sinfo['virtualserver_hostbanner_gfx_url']).'" alt="TS Banner" />';
		}
		return $return;
	}

	protected function stats(){
		//generates html-output for some ts3-stats
		$return = '';
		$tag = floor($this->sinfo['virtualserver_uptime']/60/60/24);
		$std = ($this->sinfo['virtualserver_uptime']/60/60)%24;
		$min = ($this->sinfo['virtualserver_uptime']/60)%60;
		$this->sinfo['virtualserver_created'] = date('d M Y', $this->sinfo['virtualserver_created']);
		$uptimeLang = $this->user->lang('lang_ts3_uptime');
		$this->sinfo['virtualserver_uptime'] = $tag.' '.$uptimeLang[0].' '.$std.' '.$uptimeLang[1].' '.$min.' '.$uptimeLang[2];
		if($this->info['stats'] == 1){
			$return .= '<div id="ts3stats"><h3>'.$this->user->lang('lang_ts3_stats').'</h3><table>';
			foreach ($this->info['serverinfo'] as $key => $var){
				if($var['show'] == 1){
					$return .= '<tr><td style="font-weight:bold">'.sanitize($var['label']).':</td><td>'.$this->replace($this->sinfo[$key]).'</td></tr>';
				}
			}
			$return .= '</table></div>';
		}
		return $return;
	}

	protected function errors(){
		//generates html-output to display errors
		$return = '';
		if (isset($this->error[0])){
			$return .= '<div id="ts3errors"><h3>Errors</h3>';
			foreach ($this->error as $var) {
				$return .= sanitize($var).'<br />';
			}
			$return .= '</div>';
		}
		return $return;
	
	}
	
	protected function alerts(){
	//generates html-output to display alerts
		$return = '';
		if (isset($this->alert[0])){
			$return .= '<div id="ts3alerts"><h3>Alerts</h3>';
			foreach ($this->alert as $var) {
				$return .= sanitize($var).'<br />';
			}
			$return .= '</div>';
		}
		return $return;
	}
	
	private function _config($strKey){
		if (isset($this->_config[$strKey])){
			return $this->_config[$strKey];
		} else {
			return "";
		}
	}

} // End Ts3Viewer-Class

// Compare-Functions for User-Sorting
function ts3_cmp_admin($a, $b){
	return strcmp($b["s_admin"], $a["s_admin"]);
}
function ts3_cmp_group($a, $b){
	return strcmp($b["client_channel_group_id"], $a["client_channel_group_id"]);
}
?>
