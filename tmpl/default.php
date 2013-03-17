<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
    
    jimport( 'joomla.filesystem.file' );
    $canEdit = JFactory::getUser()->authorise('core.edit', 'com_languages');
    
    $tpath = '/templates/'.$app->getTemplate();

	$showCount = 0;
	if($showTrainEvents) $showCount++;
	if($showEvents) $showCount++;
	if($showCups) $showCount++;
	if($showTurnaments) $showCount++;
	if($showFriendlies) $showCount++;
	if($showLeagueGames) $showCount++;
    
?>
<section id="teamSite" showCount="<?php echo $showCount ?>">
    <?php if($showCount > 0) : ?>
    
    <?php if($showCount >= 2) : ?>
    <? /* ***************
            //!Menü Events
        *****************  */ ?>
    <section class="contentMenu" id="newsSelection">
        <nav class="top noPrint">
        	<ul id="menu" class="menu">
                <?php if($showTrainEvents == 1 && sizeof($teamTrainData) > 0) : ?><li class=""><a href="#trainDates"><?php echo JText::_('MOD_SVW_TRAIN_H3'); ?></a></li><?php endif;?>
                <?php if($showEvents == 1 && sizeof($teamEventsData) > 0) : ?><li class=""><a href="#events" ><?php echo JText::_('MOD_SVW_EVENTS_H3'); ?></a></li><?php endif;?>
                <?php if($showFriendlies == 1 && sizeof($teamFriendliesData) > 0) : ?><li class=""><a href="#friendlies" ><?php echo JText::_('MOD_SVW_FRIENDLIES_H3'); ?></a></li><?php endif;?>
                <?php if($showCups == 1 && sizeof($teamCupsData) > 0) : ?><li class=""><a href="#cups" ><?php echo JText::_('MOD_SVW_CUPS_H3'); ?></a></li><?php endif;?>
                <?php if($showTurnaments == 1 && sizeof($teamTurnamentsData) > 0) : ?><li class=""><a href="#turnaments" ><?php echo JText::_('MOD_SVW_TURNAMENTS_H3'); ?></a></li><?php endif;?>
            </ul>					
        </nav>
    </section>
    <?php endif; ?>

    <section class="page-item ac" id="teamInfos">
        <header>
            <h3><?php 
				if($appParams->get('event_title') && strlen($appParams->get('event_title')) > 1)
					echo $appParams->get('event_title'); 
				else
					echo JText::_('MOD_SVW_DISPLAY_TEAM_INFOS_LABEL'); 
				?>
			</h3>
        </header>
         
        <? /* ***************
                //!Trainingszeiten 
            *****************  */ ?>
        <?php if($showTrainEvents && sizeof($teamTrainData) > 0) : ?>
        <article class="eventTimeTable ac">
            <header><h4><img src="<?php echo $tpath; ?>/images/icons/ball_football_clock.png" alt="Fussball und Uhr"><?php echo JText::_('MOD_SVW_TRAIN_H3'); ?></h4></header>
            <table id="trainDates">
                <?php foreach ($teamTrainData as $event){ 
                    $trainDate = new JDate($event->date_start);
                    $begin = new JDate($event->time_begin);
                    $end = new JDate($event->time_end);                    
                ?>
                    <tr>
                        <td class="weekDay"><?php echo $trainDate->format('l'); ?></td>
                        <td class="startEndTime"><?php echo $begin->format('H:i'); ?> - <?php echo $end->format('H:i'); ?> Uhr</td>
                        <td class="eventPlace"><?php echo $event->meeting_place ?></td>
                    </tr>
                <?php } ?>
            </table>
        </article>
        <?php endif; ?>
        <? /* ***************
                //!TERMINE 
            *****************  */ ?>
        <?php if($showEvents && sizeof($teamEventsData) > 0) : ?>
        <article class="eventTimeTable ac"  id="events">
            <header>
                <h4><img src="<?php echo $tpath; ?>/images/icons/ball_football_clock.png" alt="Fussball und Uhr"><?php echo JText::_('MOD_SVW_EVENTS_H3'); ?> (<?php echo sizeof($teamEventsData);?>)</h4>
				<time style="display:none" datetime="<?php echo $eventDate;?>"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_LC1')); ?></time>
            </header>
            <table>
                <?php foreach ($teamEventsData as $event){ 
                    $eventDate = new JDate($event->date_start);
                    $begin = new JDate($event->time_begin);
                    $end = new JDate($event->time_end);
                    $meeting = new JDate($event->time_meeting);
    
                ?>
                    <tr class="dateTr">
						<?php displaySVWEventDateBox($eventDate, 2); ?>
                        <td class="eventText">
							<h5 itemprop="name"><?php echo $event->text ?></h5>
							<span style="display:none" itemprop="description">SV Wiesbaden - <?php echo $teamInfo[0]->long_key ?>, Saison <?php echo $seasonKey ?></span>
						</td>
						<?php displayTimeLabelsTds($event); ?>
                    </tr>
                    <td class="eventPlace">
						<?php displaySVWEventLocation($event); ?>                    
                    </td>
				    <?php displayTimeValueTds($event, $begin, $end, $meeting); ?>  
                <?php } ?>
            </table>
        </article>
        <?php endif; ?>
        <? /* ******************
            //!FREUNDSCHAFTSSPIELE 
            ********************  */ ?>
        <?php if($showFriendlies && sizeof($teamFriendliesData) > 0) : ?>
        <article class="eventTimeTable ac" id="friendlies">
            <header>
                <h4><img src="<?php echo $tpath; ?>/images/icons/ball_football_clock.png" alt="Fussball und Uhr"><?php echo JText::_('MOD_SVW_FRIENDLIES_H3'); ?> (<?php echo sizeof($teamFriendliesData);?>)</h4>
            </header>
            <?php foreach ($teamFriendliesData as $event){ 
                $eventDateTime = new JDate($event->date_start.$event->time_begin);
                $eventDate = new JDate($event->date_start);
                $begin = new JDate($event->time_begin);
                $end = new JDate($event->time_end);
                $meeting = new JDate($event->time_meeting);

            ?>
            <table id="friendlie<?php echo $eventDateTime;?>" itemscope itemtype="http://schema.org/Event" typeof="SportsEvent">
                <tr class="dateTr">
                    <?php displaySVWEventDateBox($eventDate, 3); ?>
                    <td class="eventText">
                        <h5 itemprop="name"><?php echo $event->text ?></h5>
                        <span style="display:none" itemprop="description">SV Wiesbaden - <?php echo $teamInfo[0]->long_key ?>, Saison <?php echo $seasonKey ?></span>
                    </td>
					<?php displayGameTimeLabelsTds($event); ?>
                </tr>
                <tr class="eventTr">
                    <td class="eventGame">

                        <?php if(strlen($event->home)>0 && strlen($event->guest)>0) : ?>
                        <div itemscope itemtype="http://schema.org/Organization" itemprop="attendee">
                        <span itemprop="name">
                        <?php echo $event->home.' - '.$event->guest; ?>
                        </span>
                        </p>
						</div>	
                        <?php endif; ?>                        
                    </td>
                    <?php displayTimeValueTds($event, $begin, $end, $meeting); ?>    
                </tr>
                <tr class="eventLocation">
                    <td colspan="4">
                        <?php if($event->meeting_place != 0) : ?>
                         <div itemprop="location" itemscope itemtype="http://schema.org/Place">
                            <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                <p><img class="location" src="<?php echo $tpath; ?>/images/icons/location.png" alt="Fussballpokal">Veranstaltungsort: <span itemprop="addressLocality"><?php echo $event->meeting_place; ?></span></p>
                            </div>
                        </div>
                        <?php endif; ?>
					</td>
                </tr>
            </table>
            <?php } ?>
        </article>
        <?php endif; ?>
		<? /* ******************
            //!LIGASPIELE 
            ********************  */ ?>
        <?php if($showLeagueGames && sizeof($teamLeagueGamesData) > 0) : ?>
        <article class="eventTimeTable ac" id="friendlies">
            <header class="noPrint">
                <h4><img src="<?php echo $tpath; ?>/images/icons/ball_football_clock.png" alt="Fussball und Uhr"><?php echo JText::_('MOD_SVW_LEAGUE_H3'); ?> (<?php echo sizeof($teamLeagueGamesData);?>)</h4>
            </header>
            <?php foreach ($teamLeagueGamesData as $event){ 
                $eventDateTime = new JDate($event->date_start.$event->time_begin);
                $eventDate = new JDate($event->date_start);
                $begin = new JDate($event->time_begin);
                $end = new JDate($event->time_end);
                $meeting = new JDate($event->time_meeting);

            ?>
            <table id="friendlie<?php echo $eventDateTime;?>" itemscope itemtype="http://schema.org/Event" typeof="SportsEvent">
                <tr class="dateTr">
                    <?php displaySVWEventDateBox($eventDate, 3); ?>
                    <td class="eventText">
						<?php if(strlen($event->home)>0 && strlen($event->guest)>0) : ?>
                        <h5 itemscope itemtype="http://schema.org/Organization" itemprop="attendee">
                        <span itemprop="name">
                        <?php echo $event->home.' - '.$event->guest; ?>
                        </span>                        
						</h5>	
                        <?php endif; ?>    
                        <span style="display:none" itemprop="description">SV Wiesbaden - <?php echo $teamInfo[0]->long_key ?>, Saison <?php echo $seasonKey ?></span>
                    </td>
					<th class="print game-result-label">Ergebnis</td>
					<?php displayGameTimeLabelsTds($event); ?>
                </tr>
                <tr class="eventTr">
                    <td class="eventPlace">
						<?php displaySVWEventLocation($event); ?>                    
						<p itemprop="name"><?php echo $event->text ?></p>
                    </td>
					<td class="print game-result"><span class="result-home">&nbsp;</span>:<span class="result-guest">&nbsp;</span></td>
				    <?php displayTimeValueTds($event, $begin, $end, $meeting); ?>    
                </tr>
            </table>
            <?php } ?>
        </article>
        <?php endif; ?>
        <? /* ******************
            //!POKALSPIELE 
            ********************  */ ?>
        <?php if($showCups && sizeof($teamCupsData) > 0) : ?>
        <article class="eventTimeTable ac" id="friendlies">
            <header>
                <h4><img src="<?php echo $tpath; ?>/images/icons/trophy.png" alt="Fussball und Uhr"><?php echo JText::_('MOD_SVW_CUPS_H3'); ?> (<?php echo sizeof($teamCupsData);?>)</h4>
            </header>
            <?php foreach ($teamCupsData as $event){ 
                $eventDateTime = new JDate($event->date_start.$event->time_begin);
                $eventDate = new JDate($event->date_start);
                $begin = new JDate($event->time_begin);
                $end = new JDate($event->time_end);
                $meeting = new JDate($event->time_meeting);

            ?>
            <table id="friendlie<?php echo $eventDateTime;?>" itemscope itemtype="http://schema.org/Event" typeof="SportsEvent">
                <tr class="dateTr">
                    <?php displaySVWEventDateBox($eventDate, 3); ?>
                    <td class="eventText">
                        <h5 itemprop="name"><?php echo $event->text ?></h5>
                        <span style="display:none" itemprop="description">SV Wiesbaden - <?php echo $teamInfo[0]->long_key ?>, Saison <?php echo $seasonKey ?></span>
                    </td>
					<?php displayGameTimeLabelsTds($event); ?>
                </tr>
                <tr class="eventTr">
                    <td class="eventPlace">

                        <?php if(strlen($event->home)>0 && strlen($event->guest)>0) : ?>
                        <div itemscope itemtype="http://schema.org/Organization" itemprop="attendee">
                        <span itemprop="name">
                        <?php echo $event->home.' - '.$event->guest; ?>
                        </span>
                        </p>
						</div>	
                        <?php endif; ?>                        
                   </td>
				    <?php displayTimeValueTds($event, $begin, $end, $meeting); ?>    
                </tr>
                <tr class="eventGame">
                    <td colspan="4">
                        <?php if($event->meeting_place != 0) : ?>
                         <div itemprop="location" itemscope itemtype="http://schema.org/Place">
                            <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                <p><img class="location" src="<?php echo $tpath; ?>/images/icons/location.png" alt="Fussballpokal">Veranstaltungsort: <span itemprop="addressLocality"><?php echo $event->meeting_place; ?></span></p>
                            </div>
                        </div>
                        <?php endif; ?>
                </td>
                </tr>
            </table>
            <?php } ?>
        </article>
        <?php endif; ?>
        <? /* ***************
                //!TURNIERE 
            *****************  */ ?>
        <?php if($showTurnaments && sizeof($teamTurnamentsData) > 0) : ?>
        <article class="ac eventTimeTable" id="turnaments">
            <header>
                <h4><img src="<?php echo $tpath; ?>/images/icons/trophy.png" alt="Fussballpokal"><?php echo JText::_('MOD_SVW_TURNAMENTS_H3'); ?> (<?php echo sizeof($teamTurnamentsData);?>)</h4>
            </header>
            <?php foreach ($teamTurnamentsData as $event){ 
                $eventDateTime = new JDate($event->date_start.$event->time_begin);
                $eventDate = new JDate($event->date_start);
                $begin = new JDate($event->time_begin);
                $end = new JDate($event->time_end);
                $meeting = new JDate($event->time_meeting);

            ?>
            <table id="turnament<?php echo $eventDateTime;?>" itemscope itemtype="http://schema.org/Event" typeof="SportsEvent">
                <tr class="dateTr">
                    <?php displaySVWEventDateBox($eventDate, 3); ?>
                    <td class="eventText">
                        <h5 itemprop="name"><?php echo $event->text ?></h5>
                        <span style="display:none" itemprop="description">SV Wiesbaden - <?php echo $teamInfo[0]->long_key ?>, Saison <?php echo $seasonKey ?></span>
                    </td>
					<?php displayTimeLabelsTds($event); ?>
                </tr>
                <tr class="eventTr">
                    <td class="eventPlace">
                    
                        <?php if(strlen($event->meeting_place) > 1) : ?>
                        <div itemprop="location" itemscope itemtype="http://schema.org/Place">
                        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                            <p><img class="location" src="<?php echo $tpath; ?>/images/icons/location.png" alt="Fussballpokal"><Veranstaltungsort: <span itemprop="addressLocality"><?php echo $event->meeting_place; ?></span></p>
                        </div>
                        </div>
                        <?php endif; ?>
                        <?php if(strlen($event->home)>0) : ?>
                        <div itemscope itemtype="http://schema.org/Organization" itemprop="attendee">
                            <p>Gastgeber:&nbsp;
                            <span itemprop="name">
                            <?php echo $event->home; ?>
                            </span>
                            </p>
    							<?php if($canEdit) : ?>								
    								<?php $guest_teams = json_decode($event->guest); ?>
    								<?php if(json_last_error() === JSON_ERROR_NONE && is_object($guest_teams)) : ?>
    									<?php $team_count = $guest_teams->{'count'}; ?>
    									<?php if($team_count > 0) : ?>
    										<p><span>Gastmannschaften:</span></p>
    											<?php for($i=0;$i<$team_count;$i++) { 
    												echo "<p>";
    												echo "<b>".$guest_teams->{$i}->{'name'}.":</b>&nbsp;";
    												$teamCount = $guest_teams->{'teamCount'};
    												for ($j=1;$j<=$teamCount;$j++) {
    													if(strpos($guest_teams->{$i}->{'team'.$j}, "SV Wiesbaden") !== false) echo'<em>';
    													echo $guest_teams->{$i}->{'team'.$j};
    													if(strpos($guest_teams->{$i}->{'team'.$j}, "SV Wiesbaden") !== false) echo'</em>';
    													if($j<$teamCount) echo ', ';
    												}
    												echo "</p>";
    											} ?>
    									<?php endif; ?>
    								<?php endif; ?>
    							<?php endif; ?>
						</div>	
                        <?php endif; ?>
                        <?php if(strlen($event->attachment)>0) : ?>
                            <?php $event_attachment = json_decode($event->attachment); ?>

                            <?php if(json_last_error() === JSON_ERROR_NONE && is_object($event_attachment)) : ?>
                                <?php foreach ($event_attachment->data as $attachment) {
                                    displayAttachments($attachment);   
                                } ?>    
    					    <?php endif; ?>			
                        <?php endif; ?>
                    </td>
				    <?php displayTimeValueTds($event, $begin, $end, $meeting); ?>    
                </tr>
            </table>
            <?php } ?>
        </article>
        <?php endif; ?>
        <?php  displayBackToTopLink(); ?>
    </section>
    <?php endif; ?>
    
    
<? /* ***************
        //!KADER 
    *****************  */ ?>
<?php if($showMembers == 1) : ?>
    <? /* ***************
            //!Menü 
        *****************  */ ?>
    <section class="contentMenu" id="newsSelection">
        <nav class="top noPrint">
        	<ul id="menu" class="menu">
                <?php if($showCoaches == 1 && sizeof($memberCoachesItems) > 0) : ?><li class=""><a href="#team_COACHES"><?php echo JText::_('MOD_SVW_TEAM_COACH_TITLE'); ?></a></li><?php endif;?>
                <?php if($showKeepers == 1 && sizeof($memberKeeperItems) > 0) : ?><li class=""><a href="#team_KEEPER" ><?php echo JText::_('MOD_SVW_TEAM_KEEPER_TITLE'); ?></a></li><?php endif;?>
                <?php if($showMembers == 1 && sizeof($memberGKItems) > 0) : ?><li class=""><a href="#team_KEEPER" ><?php echo JText::_('MOD_SVW_TEAM_GK_TITLE'); ?></a></li><?php endif;?>
                <?php if($showMembers == 1) : ?>
                    <?php if(sizeof($memberDefenseItems) > 0) : ?><li class=""><a href="#team_DF" ><?php echo JText::_('MOD_SVW_TEAM_DF_TITLE'); ?></a></li><?php endif;?>
                    <?php if(sizeof($memberMidfieldItems) > 0) : ?><li class=""><a href="#team_MF" ><?php echo JText::_('MOD_SVW_TEAM_MF_TITLE'); ?></a></li><?php endif;?>
                    <?php if(sizeof($memberForwardItems) > 0) : ?><li class=""><a href="#team_FW" ><?php echo JText::_('MOD_SVW_TEAM_FW_TITLE'); ?></a></li><?php endif;?>
                <?php endif; ?>
            </ul>					
        </nav>
    </section>
<?php endif; ?>
	
<?php if($showMembers == 1 or $showCoaches == 1 or $showKeepers == 1) : ?>
	<section class="page-item" id="teamMembers">
		<?php if($showCoaches == 1 && sizeof($memberCoachesItems) > 0) : ?>
        <? /* ***************
                //!Trainer 
            *****************  */ ?>
	    <header style="display:none">
            <h2>
                <?php 
                    if($teamKey == 'profis' or $teamKey == 'reserve') echo JText::_('MOD_SVW_TEAM_COACH_TITLE_SENIORS'); 
                    else echo JText::_('MOD_SVW_TEAM_COACH_TITLE'); 
                ?>
            </h2>
        </header>

		<section class="teamPosition contentItem" id="team_COACHES">
			<article class="ac">
				<header>
					<h3>    					
                        <?php 
                            if($teamKey == 'profis' or $teamKey == 'reserve') echo JText::_('MOD_SVW_TEAM_COACH_TITLE_SENIORS'); 
                            else echo JText::_('MOD_SVW_TEAM_COACH_TITLE'); 
                        ?>
					</h3>
				</header>
				<?php foreach ($memberCoachesItems as $member){ ?>
				<?php displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, JText::_('MOD_SVW_TEAM_COACH_TITLE'), $tpath, $teamType); ?>
				<?php } ?>
			</article>
		</section>
		<?php endif; ?>
		
		<?php if($showKeepers == 1 && sizeof($memberKeeperItems) > 0) : ?>
        <? /* ***************
                //!Betreuer 
            *****************  */ ?>
	    <header style="display:none">
            <h2><?php echo JText::_('MOD_SVW_TEAM_KEEPER_TITLE'); ?></h2>
        </header>

		<section class="teamPosition contentItem" id="team_KEEPER">
			<article class="ac">
				<header>
					<h3><?php echo JText::_('MOD_SVW_TEAM_KEEPER_TITLE'); ?></h3>
				</header>
				<?php foreach ($memberKeeperItems as $member){ ?>
				<?php displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, JText::_('MOD_SVW_TEAM_COACH_TITLE'), $tpath, $teamType); ?>
				<?php } ?>
			</article>
		</section>
		<?php endif; ?>
		
        <? /*!TEAM MEMBERS  */?>
        <?php if($showMembers == 1) : ?>
            <?php if($teamType == 1 && sizeof($memberJuniorItems) > 0) : ?>
            <section class="teamPosition contentItem" team="team_GK">
                <article class="ac">
					<header>
						<h3 class="teamorder"><?php echo JText::_('MOD_SVW_TEAM_JUNIOR_TITLE'); ?></h3>
					</header>
					<?php foreach ($memberJuniorItems as $member){ ?>
					<?php displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, JText::_('MOD_SVW_TEAM_JUNIOR_TITLE'), $tpath, $teamType); ?>
					<?php } displayBackToTopLink(); ?>
				</article>
            </section>
            <?php endif; ?>
			
            <?php if(sizeof($memberGKItems) > 0) : ?>
            <section class="teamPosition contentItem" team="team_GK">
                <article class="ac">
    
                <header>
                    <h3 class="teamorder"><?php echo JText::_('MOD_SVW_TEAM_GK_TITLE'); ?></h3>
                </header>
                <?php foreach ($memberGKItems as $member){ ?>
                <?php displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, JText::_('MOD_SVW_TEAM_GK_TITLE'), $tpath, $teamType); ?>
                <?php } displayBackToTopLink(); ?>
            </article>
            </section>
            <?php endif; ?>
            
            <?php if(sizeof($memberDefenseItems) > 0) : ?>
            <section class="teamPosition contentItem" id="team_DF">
                <article class="ac">
                <header>
                    <h3 class="teamorder"><?php echo JText::_('MOD_SVW_TEAM_DF_TITLE'); ?></h3>
                </header>
                <?php foreach ($memberDefenseItems as $member){ ?>
                <?php displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, JText::_('MOD_SVW_TEAM_DF_TITLE'), $tpath, $teamType); ?>
                <?php }  displayBackToTopLink(); ?>
            </article>
            </section>
            <?php endif; ?>
            
            <?php if(sizeof($memberMidfieldItems) > 0) : ?>
            <section class="teamPosition contentItem" id="team_MF">
            <article class="ac">
                <header>
                    <h3 class="teamorder"><?php echo JText::_('MOD_SVW_TEAM_MF_TITLE'); ?></h3>
                </header>
                <?php foreach ($memberMidfieldItems as $member){ ?>
                <?php displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, JText::_('MOD_SVW_TEAM_MF_TITLE'), $tpath, $teamType); ?>
                <?php } displayBackToTopLink(); ?>
            </article>
            </section>
            <?php endif; ?>
            
            <?php if(sizeof($memberForwardItems) > 0) : ?>
            <section class="teamPosition contentItem" id="team_FW">
                <article class="ac">
                <header>
                    <h3 class="teamorder"><?php echo JText::_('MOD_SVW_TEAM_FW_TITLE'); ?></h3>
                </header>
                <?php foreach ($memberForwardItems as $member){ ?>
                <?php displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, JText::_('MOD_SVW_TEAM_FW_TITLE'), $tpath, $teamType); ?>
                <?php } displayBackToTopLink(); ?>
            </article>
            </section>
            <?php endif; ?>
        <?php endif; ?>
    </section>
<?php endif; ?>
</section>