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

class discordviewer extends gen_class {
	
	private $module_id = 0;
	private $serverID = false;
	private $cachetime = 60*5; //5 Minutes
	private $blnHideEmpty = false;
	private $blnShowOnline = false;
	private $blnHideGames = false;

	
	public function __construct($id){
		$this->module_id = $id;
		
		$this->serverID = $this->config->get('discord_serverid', 'pmod_'.$this->module_id);
		$this->blnHideEmpty = $this->config->get('discord_hideempty', 'pmod_'.$this->module_id);
		$this->blnShowOnline = $this->config->get('discord_showonline', 'pmod_'.$this->module_id);
		$this->blnHideGames = $this->config->get('discord_hidegame', 'pmod_'.$this->module_id);
	}
	
	function viewer(){
		$imgPath =  $this->server_path . 'portal/voice/modules/discord/images/';
		$strURL = "https://discordapp.com/api/guilds/".$this->serverID."/widget.json";

		$out = "";
		
		$strJson = register('urlfetcher')->fetch($strURL);
		if($strJson){
			$objJson = json_decode($strJson);
			
			$out = "<div><h3>" . sanitize($objJson->name). " <span class='bubble'>{VOICE_COUNT}</span></h3></div>";
			
			$memberVoiceCount = 0; // sets member number to 0
			$channel_members = array();
			
			$out .= '<div class="discordViewer">';
			
			if ($objJson->channels) {
				
				usort($objJson->channels, function($a, $b) {
					return $a->position > $b->position ? 1 : -1;
				});
					
					foreach ($objJson->members as $member) {
						if (!empty($member->channel_id)) {
							$channel_members[$member->channel_id][] = $member->username;
						}
					}
					
					
					foreach ($objJson->channels as $channel) {
						$intMembersInChannel = (isset($channel_members[$channel->id])) ? count($channel_members[$channel->id]) : 0;
						if($this->blnHideEmpty && $intMembersInChannel == 0) continue;
						
						$out .= '<div class="discord-channel-container"><div class="discord-channel">'.sanitize($channel->name).'</div>';
						$out .= '<div class="member-row">';
						foreach($objJson->{'members'} as $member) {
							if($member->channel_id == $channel->id) {
								$memberVoiceCount++;
								
								$out .= '<div class="discord-member">';
								$out .= "<div class='discord-avatar'><img class='discord-avatar-img' src=\"".sanitize($member->avatar_url)."?size=32\">";
								
								$out .= "&nbsp;<img class=\"discord-status\" src=\"".$imgPath.sanitize($member->status).".png\">";
								$out .= "</div>";
								
								if (isset($member->nick))  {
									$membername = sanitize($member->nick);
								} else {
									$membername = sanitize($member->username);
								}
								$out .= "<div class='discord-name' title='".$membername."'>";
								$out .= $membername."</div>";
								
								if (!$this->blnHideGames && isset($member->game->name)){
									$out .= ' <span class="discord-game" title="'.sanitize($member->game->name).'">'.sanitize($member->game->name).'</span>';
								}
								
								$out .= "<div class='discord-voice-status'>";
								
								if($member->self_mute && $member->self_mute == "true"){
									$out .= "&nbsp;<i class='fa fa-microphone-slash'></i>";
								}
								
								if($member->self_deaf && $member->self_deaf == "true"){
									$out .= "&nbsp;<i class='fa fa-deaf'></i>";
								}
								
								$out .= "</div>";
								
								$out .= '</div>';
							}
						}
						$out .= '</div></div>';
						
					}
			}
			if($this->blnShowOnline){
				$out .= '<h3>Members online <span class="bubble">{ONLINE_COUNT}</span></h3>';
				$memberCount = 0;
				
				foreach($objJson->{'members'} as $member) {
					if(is_null($member->channel_id)) {
						
						$memberCount++;
						
						$out .= '<div class="discord-member">';
						$out .= "<div class='discord-avatar'><img class='discord-avatar-img' src=\"".sanitize($member->avatar_url)."?size=32\">";
						
						$out .= "&nbsp;<img class=\"discord-status\" src=\"".$imgPath.sanitize($member->status).".png\">";
						$out .= "</div>";
						
						if (isset($member->nick))  {
							$membername = sanitize($member->nick);
						} else {
							$membername = sanitize($member->username);
						}
						$out .= "<div class='discord-name' title='".$membername."'>";
						$out .= $membername."</div>";
						
						if (!$this->blnHideGames && isset($member->game->name)){
							$out .= ' <span class="discord-game" title="'.sanitize($member->game->name).'">'.sanitize($member->game->name).'</span>';
						}
						
						$out .= "<div class='discord-voice-status'>";
						
						if($member->self_mute && $member->self_mute == "true"){
							$out .= "&nbsp;<i class='fa fa-microphone-slash'></i>";
						}
						
						if($member->self_deaf && $member->self_deaf == "true"){
							$out .= "&nbsp;<i class='fa fa-deaf'></i>";
						}
						
						$out .= "</div>";
						
						$out .= '</div>';
					}
				}
				
			}
			$out .= '</div>';
			
			
			if($objJson->instant_invite){
				$out .= "<br /><div><a href=\"".sanitize($objJson->instant_invite)."\"><i class='fa fa-mail-forward'></i> ".$this->user->lang('voice_f_discord_connect')."</a></div>";
			}
			
			$out = str_replace('{VOICE_COUNT}', $memberVoiceCount, $out);
			$out = str_replace('{ONLINE_COUNT}', $memberCount, $out);
		}
		
		return $out;
	}
}
?>