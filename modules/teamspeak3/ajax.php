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

//Check Permission
$objPortal = register('portal');
if(!$objPortal->check_visibility($moduleID)) exit;

$htmlout = register('pdc')->get('portal.module.voice.ts3.outputdata.'.$moduleID, false, true);

$cachetime = (register('config')->get('ts3_cache', 'pmod_'.$moduleID)) ? register('config')->get('ts3_cache', 'pmod_'.$moduleID) : '30';

if ((!$htmlout) or $cachetime == '0'){
	include_once($eqdkp_root_path . 'portal/voice/modules/teamspeak3/Ts3Viewer.php');
	$ts3v = registry::register("Ts3Viewer", array($moduleID));
	
	if ($ts3v->connect()) {
		$ts3v->query();
		$ts3v->disconnect();
	}
	
	$htmlout = $ts3v->gethtml();
	unset($ts3v);
	if ($cachetime >= '1') {register('pdc')->put('portal.module.voice.ts3.outputdata.'.$moduleID, $htmlout, $cachetime, false, true);}
}

header('content-type: text/html; charset=UTF-8');
echo $htmlout;
exit;