<?php

class ModSvwTeamHelper {
    public function getTeamInfoFromDb($teamKey) {
        
        $db = &JFactory::getDBO();
        
        $query = 'SELECT * FROM `svw_teams` WHERE team_key LIKE "'.$teamKey.'" LIMIT 1';
        
        $db->setQuery($query);
        
        $items = ($items = $db->loadObjectList())?$items:array(); // loads results in an array
        
        return $items;
    }

    public function getTeamMembersFromDb($teamKey, $seasonKey) {
        
        $db = &JFactory::getDBO();
        
        $query = 'SELECT * FROM `svw_player` WHERE `season` LIKE "'.$seasonKey.'" AND team LIKE "'.$teamKey.'" ORDER BY position DESC, name DESC';
        
        $db->setQuery($query);
        
        $items = ($items = $db->loadObjectList())?$items:array(); // loads results in an array
        
        return $items;
    }
    
    public function getTeamMembersBySeason($teamKey, $seasonKey) {
        
        $db = &JFactory::getDBO();
        
        $query = 'SELECT svw_team_members.name, svw_team_members.vorname, svw_team_members.bday, svw_team_members.last_clubs, svw_team_members.svw_since, games, scores, jersey_nr, team_part, title
                    FROM svw_team_members_season_data
                    INNER JOIN svw_team_members ON svw_team_members_season_data.id = svw_team_members.id 
                    WHERE svw_team_members_season_data.team_key LIKE "'.$teamKey.'" AND season_key LIKE "'.$seasonKey.'" ORDER BY team_part DESC, jersey_nr DESC, name DESC';
        
        $db->setQuery($query);
        
        $items = ($items = $db->loadObjectList())?$items:array(); // loads results in an array
        
        return $items;
    }
    
    public function getTeamEventsBySeasonAndType($teamKey, $seasonKey, $type, $limit) {
        
        $db = &JFactory::getDBO();
        
        if($type == 0){
            $query = 'SELECT * FROM `svw_team_events` WHERE `season_key` LIKE "'.$seasonKey.'" AND `team_key` LIKE "'.$teamKey.'" AND type = '.$type.' AND CURDATE() <= date_end ORDER BY date_start';
            
        } else {
            $query = 'SELECT * FROM `svw_team_events` WHERE `season_key` LIKE "'.$seasonKey.'" AND `team_key` LIKE "'.$teamKey.'" AND type = '.$type.' AND CURDATE() <= date_end ORDER BY date_start';    
        }
        if($limit != 0) $query+=' LIMIT '.$limit;        
        $db->setQuery($query);
        
        $items = ($items = $db->loadObjectList())?$items:array(); // loads results in an array
        
        return $items;
    }
    
    public function getTeamMembersByPositionAndSeason($teamKey, $seasonKey, $position) {
        
        $db = &JFactory::getDBO();
        
        
        $query = 'SELECT svw_team_members.id, svw_team_members.name, svw_team_members.vorname, svw_team_members.bday, svw_team_members.last_clubs, svw_team_members.svw_since, games, scores, jersey_nr, team_part, title
                    FROM svw_team_members_season_data
                    INNER JOIN svw_team_members ON svw_team_members_season_data.id = svw_team_members.id 
                    WHERE svw_team_members_season_data.team_key LIKE "'.$teamKey.'" AND season_key LIKE "'.$seasonKey.'" AND team_part LIKE "'.$position.'" ORDER BY team_part DESC, jersey_nr DESC, name DESC';
        
        $db->setQuery($query);
        
        $items = ($items = $db->loadObjectList())?$items:array(); // loads results in an array
        
        return $items;
    }

    public function getTeamMembersWithAdressesByPositionAndSeason($teamKey, $seasonKey, $teamPart) {
        
        $db = &JFactory::getDBO();
        
        
        $query = 'SELECT  members.id, members.name, members.vorname, members.bday, members.last_clubs, members.svw_since, data.games, data.scores, data.jersey_nr, data.team_part, data.title, adresses.mail,
                    adresses.tel_1_label, adresses.tel_1,
                    adresses.tel_2_label, adresses.tel_2,
                    adresses.tel_3_label, adresses.tel_3
                    FROM svw_team_members members
                    INNER JOIN svw_team_members_season_data data ON data.id = members.id
                    INNER JOIN svw_members_adresses adresses ON adresses.id = members.id
                    WHERE data.team_key LIKE "'.$teamKey.'" AND data.season_key LIKE "'.$seasonKey.'" AND data.team_part LIKE "'.$teamPart.'" ORDER BY data.team_part DESC, data.jersey_nr DESC, members.name DESC';
        //if($teamPart == 0) echo $query;
        $db->setQuery($query);
        
        $items = ($items = $db->loadObjectList())?$items:array(); // loads results in an array
        
        return $items;
    }
    
    public function getTeamMembersByPositionFromDb($teamKey, $seasonKey, $position) {
        
        $db = &JFactory::getDBO();
        
        $query = 'SELECT * FROM `svw_player` WHERE `season` LIKE "'.$seasonKey.'" AND team LIKE "'.$teamKey.'" AND position LIKE '.$position.' ORDER BY position DESC, name DESC';
        
        $db->setQuery($query);
        
        $items = ($items = $db->loadObjectList())?$items:array(); // loads results in an array
        
        return $items;
    }
    
    public function getTeamMemberStats($teamKey, $seasonKey, $teamMember) {
        $db = &JFactory::getDBO();
        
        $query = 'SELECT * FROM `svw_player_stats` WHERE `season` LIKE "'.$seasonKey.'" AND team LIKE "'.$teamKey.'" AND id = '.$teamMember->id." LIMIT 1";

        $db->setQuery($query);
        
        $items = ($items = $db->loadObjectList())?$items:array(); // loads results in an array
        
        return $items;
    }

}
?>