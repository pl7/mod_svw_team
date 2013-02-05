<?php

//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

//include helper file

require_once (dirname(__FILE__).DS.'helper.php');
// require_once __DIR__ . 'helper.php'; // joomla 3.0

require_once (dirname(__FILE__).DS.'teamMember.php');
// require_once __DIR__ . 'teamMember.php'; // joomla 3.0

jimport('joomla.application.component.helper'); 
$doc =& JFactory::getDocument();   
$doc->addScript("/media/mod_svw_team/js/teamSite.js");

$app = JFactory::getApplication(); 
$appParams  = $app->getParams();

$teamKey    = $appParams->get('team_key');
$seasonKey  = $appParams->get('season_key');

$teamType   = $appParams->get('team_type');

$imgPath = '/images/';

if($teamType == 0){
    $imgPath    .= "senioren/".$appParams->get('img_path_seniors')."/";
} else {
    $imgPath    .= "jugend/".$appParams->get('img_path')."/";    
}

$showMembers = $appParams->get('show_members');
$showCoaches = $appParams->get('show_coaches');
$showKeepers = $appParams->get('show_keepers');

$showTrainEvents = $appParams->get('show_train_events');
$showEvents = $appParams->get('show_events');
$showFriendlies = $appParams->get('show_friendlies');
$showTurnaments = $appParams->get('show_turnaments');
$showCups = $appParams->get('show_cups');



//get the items to display from the helper
$memberItems = ModSvwTeamHelper::getTeamMembersFromDb($teamKey, $seasonKey);
$teamInfo = ModSvwTeamHelper::getTeamInfoFromDb($teamKey);

if($showCoaches = 1){
	$memberCoachesItems = ModSvwTeamHelper::getTeamMembersWithAdressesByPositionAndSeason($teamKey, $seasonKey, 0);
}
if($showKeepers == 1){
	$memberKeeperItems = ModSvwTeamHelper::getTeamMembersByPositionAndSeason($teamKey, $seasonKey, 5);
}
if($showMembers == 1){
	$memberGKItems = ModSvwTeamHelper::getTeamMembersByPositionAndSeason($teamKey, $seasonKey, 1);
	$memberDefenseItems = ModSvwTeamHelper::getTeamMembersByPositionAndSeason($teamKey, $seasonKey, 2);
	$memberMidfieldItems = ModSvwTeamHelper::getTeamMembersByPositionAndSeason($teamKey, $seasonKey, 3);
	$memberForwardItems = ModSvwTeamHelper::getTeamMembersByPositionAndSeason($teamKey, $seasonKey, 4);
}
if($showTrainEvents == 1){
	$teamTrainData = ModSvwTeamHelper::getTeamEventsBySeasonAndType($teamKey, $seasonKey, 0, 0);
}
if($showCups == 1){
	$teamCupsData = ModSvwTeamHelper::getTeamEventsBySeasonAndType($teamKey, $seasonKey, 2, 0);
}
if($showFriendlies == 1){
	$teamFriendliesData = ModSvwTeamHelper::getTeamEventsBySeasonAndType($teamKey, $seasonKey, 3, 0);
}
if($showTurnaments == 1){
	$teamTurnamentsData = ModSvwTeamHelper::getTeamEventsBySeasonAndType($teamKey, $seasonKey, 4, 0);
}
if($showEvents == 1){
	$teamEventsData = ModSvwTeamHelper::getTeamEventsBySeasonAndType($teamKey, $seasonKey, 5, 0);
}

//include template
require(JModuleHelper::getLayoutPath('mod_svw_team'));

?>