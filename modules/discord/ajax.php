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

define('EQDKP_INC', true);

$eqdkp_root_path = './../../../../';
include_once($eqdkp_root_path.'common.php');

$moduleID = registry::register('input')->get('mid');

$out = register('pdc')->get('portal.module.voice.discord.'.$moduleID);
if($out == null || !$out){
	include_once($eqdkp_root_path.'portal/voice/modules/discord/discordviewer.class.php');
	$objViewer = register('discordviewer', array($moduleID));
	
	$out = $objViewer->viewer();
	register('pdc')->put('portal.module.voice.discord.'.$moduleID, $out, 5*60);
}

header('content-type: text/html; charset=UTF-8');
echo $out;
exit;