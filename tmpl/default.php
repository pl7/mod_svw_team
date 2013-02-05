<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
    
    jimport( 'joomla.filesystem.file' );
    $canEdit = JFactory::getUser()->authorise('core.edit', 'com_languages');
    
    $tpath = '/templates/'.$app->getTemplate();
?>
<section id="teamSite">
    <?php if($showTrainEvents or $showEvents or $showCups or $showTurnaments or $showFriendlies) : ?>
    
    <?php
        $showCount = 0;
        if($showTrainEvents) $showCount++;
        if($showEvents) $showCount++;
        if($showCups) $showCount++;
        if($showTurnaments) $showCount++;
        if($showFriendlies) $showCount++;
    ?>
    
    
    <?php if($showCount >= 2) : ?>
    <? /* ***************
            //!Menü Events
        *****************  */ ?>
    <section class="contentMenu" id="newsSelection">
        <nav class="top noPrint">
        	<ul id="menu" class="menu">
                <?php if($showTrainEvents == 1) : ?><li class="current active"><a href="#trainDates"><?php echo JText::_('MOD_SVW_TRAIN_H3'); ?></a></li><?php endif;?>
                <?php if($showEvents == 1) : ?><li class=""><a href="#events" ><?php echo JText::_('MOD_SVW_EVENTS_H3'); ?></a></li><?php endif;?>
                <?php if($showFriendlies == 1) : ?><li class=""><a href="#friendlies" ><?php echo JText::_('MOD_SVW_FRIENDLIES_H3'); ?></a></li><?php endif;?>
                <?php if($showCups == 1) : ?><li class=""><a href="#cups" ><?php echo JText::_('MOD_SVW_CUPS_H3'); ?></a></li><?php endif;?>
                <?php if($showTurnaments == 1) : ?><li class=""><a href="#turnaments" ><?php echo JText::_('MOD_SVW_TURNAMENTS_H3'); ?></a></li><?php endif;?>
            </ul>					
        </nav>
    </section>
    <?php endif; ?>

    
    <section class="page-item ac" id="teamInfos">
        <header>
            <h3><?php echo JText::_('MOD_SVW_DISPLAY_TEAM_INFOS_LABEL'); ?></h3>
        </header>
         
        <? /* ***************
                //!Trainingszeiten 
            *****************  */ ?>
        <?php if($showTrainEvents && sizeof($teamTrainData) > 0) : ?>
        <article class="eventTimeTable ac">
            <header><h4><img src="<?php echo $tpath; ?>/images/ball_football_clock" alt="Fussball und Uhr"><?php echo JText::_('MOD_SVW_TRAIN_H3'); ?></h4></header>
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
                <h4><img src="<?php echo $tpath; ?>/images/ball_football_clock.png" alt="Fussball und Uhr"><?php echo JText::_('MOD_SVW_EVENTS_H3'); ?> (<?php echo sizeof($teamEventsData);?>)</h4>
            </header>
            <table>
                <?php foreach ($teamEventsData as $event){ 
                    $eventDate = new JDate($event->date_start);
                    $begin = new JDate($event->time_begin);
                    $end = new JDate($event->time_end);
                    $meeting = new JDate($event->time_meeting);
    
                ?>
                    <tr class="dateTr">
                        <td class="eventText"><?php echo $event->text ?></td>
    					<td class="eventDate" colspan="2"><time datetime="<?php echo $eventDate;?>"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_LC1')); ?></time></td>
                    </tr>
                    <tr class="eventTr">
                        <td class="eventPlace"><?php if(strlen($event->home)>0) echo "<p>Gastgeber: ".$event->home."</p>"; echo "<p>Veranstaltungsort: ".$event->meeting_place."</p>" ?></td>
                        <td class="startEndTime">
                            <?php if($event->time_begin != "00:00:00" || $event->time_end != "00:00:00") : ?>
                            <?php echo '<time datetime="'.$begin.'">'.$begin->format('H:i').'</time>'; ?><?php if($event->time_end != "00:00:00") echo " - ".$end->format('H:i'); ?> Uhr<?php endif; ?></td>
                        <td class="meetingTime"><?php if($event->time_meeting != "00:00:00") : ?> Treffpunkt: <?php echo $meeting->format('H:i'); ?> Uhr <?php endif; ?></td>
                    </tr>
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
                <h4><img src="<?php echo $tpath; ?>/images/ball_football_clock.png" alt="Fussball und Uhr"><?php echo JText::_('MOD_SVW_FRIENDLIES_H3'); ?> (<?php echo sizeof($teamFriendliesData);?>)</h4>
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
                    <td rowspan="3">
                        <div class="svwDate month"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_SVW_MONTH')); ?></div>
                        <div class="svwDate date"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_SVW_DATE')); ?></div>
                        <div class="svwDate day"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_SVW_DAY')); ?></div>
                    </td>
                    <td class="eventText">
                        <h5 itemprop="name"><?php echo $event->text ?></h5>
                        <span style="display:none" itemprop="description">SV Wiesbaden - <?php echo $teamInfo[0]->long_key ?>, Saison <?php echo $seasonKey ?></span>
                    </td>
                    <?php if($event->time_begin != "00:00:00") { echo '<th class="beginLabel">'; echo JText::_('TPL_SVW_TEAM_FRIENDLY_BEGIN_LABEL'); echo'</th>'; }?>
                    <?php if($event->time_meeting != "00:00:00") { echo '<th class="meetingLabel">'; echo JText::_('TPL_SVW_TEAM_FRIENDLY_MEETING_LABEL'); echo'</th>';} ?>
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
                    <?php if($begin != "00:00:00" || $end != "00:00:00") {
                       echo'<td class="startEndTime">';
                       if($event->time_begin != "00:00:00") { echo $begin->format('H:i');  }
                       if($event->time_end != "00:00:00") { echo " - ".$end->format('H:i'); }
                       echo ' Uhr</td>';
                    }    
                    if($event->time_meeting != "00:00:00")  { 
                        echo '<td class="meetingTime">'; echo $meeting->format('H:i'); echo' Uhr</td>';
                    } ?>
                </tr>
                <tr class="eventGame">
                    <td colspan="4">
                        <?php if($event->meeting_place != 0) : ?>
                         <div itemprop="location" itemscope itemtype="http://schema.org/Place">
                            <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                <p><img class="location" src="<?php echo $tpath; ?>/images/location_2.png" alt="Fussballpokal"><Veranstaltungsort: <span itemprop="addressLocality"><?php echo $event->meeting_place; ?></span></p>
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
            //!POKALSPIELE 
            ********************  */ ?>
        <?php if($showCups && sizeof($teamCupsData) > 0) : ?>
        <article class="eventTimeTable ac" id="friendlies">
            <header>
                <h4><img src="<?php echo $tpath; ?>/images/trophy.png" alt="Fussball und Uhr"><?php echo JText::_('MOD_SVW_CUPS_H3'); ?> (<?php echo sizeof($teamCupsData);?>)</h4>
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
                    <td rowspan="3">
                        <div class="svwDate month"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_SVW_MONTH')); ?></div>
                        <div class="svwDate date"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_SVW_DATE')); ?></div>
                        <div class="svwDate day"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_SVW_DAY')); ?></div>
                    </td>
                    <td class="eventText">
                        <h5 itemprop="name"><?php echo $event->text ?></h5>
                        <span style="display:none" itemprop="description">SV Wiesbaden - <?php echo $teamInfo[0]->long_key ?>, Saison <?php echo $seasonKey ?></span>
                    </td>
                    <?php if($event->time_begin != "00:00:00") { echo '<th class="beginLabel">'; echo JText::_('TPL_SVW_TEAM_FRIENDLY_BEGIN_LABEL'); echo'</th>'; }?>
                    <?php if($event->time_meeting != "00:00:00") { echo '<th class="meetingLabel">'; echo JText::_('TPL_SVW_TEAM_FRIENDLY_MEETING_LABEL'); echo'</th>';} ?>
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
                    <?php if($begin != "00:00:00" || $end != "00:00:00") {
                       echo'<td class="startEndTime">';
                       if($event->time_begin != "00:00:00") { echo $begin->format('H:i');  }
                       if($event->time_end != "00:00:00") { echo " - ".$end->format('H:i'); }
                       echo ' Uhr</td>';
                    }    
                    if($event->time_meeting != "00:00:00")  { 
                        echo '<td class="meetingTime">'; echo $meeting->format('H:i'); echo' Uhr</td>';
                    } ?>
                </tr>
                <tr class="eventGame">
                    <td colspan="4">
                        <?php if($event->meeting_place != 0) : ?>
                         <div itemprop="location" itemscope itemtype="http://schema.org/Place">
                            <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                <p><img class="location" src="<?php echo $tpath; ?>/images/location_2.png" alt="Fussballpokal"><Veranstaltungsort: <span itemprop="addressLocality"><?php echo $event->meeting_place; ?></span></p>
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
                <h4><img src="<?php echo $tpath; ?>/images/trophy.png" alt="Fussballpokal"><?php echo JText::_('MOD_SVW_TURNAMENTS_H3'); ?> (<?php echo sizeof($teamTurnamentsData);?>)</h4>
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
                    <td rowspan="2">
                        <div class="svwDate month"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_SVW_MONTH')); ?></div>
                        <div class="svwDate date"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_SVW_DATE')); ?></div>
                        <div class="svwDate day"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_SVW_DAY')); ?></div>
                    </td>
                    <td class="eventText">
                        <h5 itemprop="name"><?php echo $event->text ?></h5>
                        <span style="display:none" itemprop="description">SV Wiesbaden - <?php echo $teamInfo[0]->long_key ?>, Saison <?php echo $seasonKey ?></span>
                    </td>
                </tr>
                <tr class="eventTr">
                    <td class="eventPlace">
                    
                        <?php if(strlen($event->meeting_place) > 1) : ?>
                        <div itemprop="location" itemscope itemtype="http://schema.org/Place">
                        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                            <p><img class="location" src="<?php echo $tpath; ?>/images/location_2.png" alt="Fussballpokal"><Veranstaltungsort: <span itemprop="addressLocality"><?php echo $event->meeting_place; ?></span></p>
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
                    </td>
                    <td class="startEndTime"><?php if($event->time_begin != "00:00:00" || $event->time_end != "00:00:00") : ?><?php echo $begin->format('H:i'); ?><?php if($event->time_end != "00:00:00") echo " - ".$end->format('H:i'); ?> Uhr<?php endif; ?></td>
                    <td class="meetingTime"><?php if($event->time_meeting != "00:00:00") : ?> Treffpunkt: <?php echo $meeting->format('H:i'); ?> Uhr <?php endif; ?></td>
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
                <?php if($showCoaches == 1 && sizeof($memberCoachesItems) > 0) : ?><li class="current active"><a href="#team_COACHES"><?php echo JText::_('MOD_SVW_TEAM_COACH_TITLE'); ?></a></li><?php endif;?>
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
            <h2><?php echo JText::_('MOD_SVW_TEAM_COACH_TITLE'); ?></h2>
        </header>

		<section class="teamPosition contentItem" id="team_COACHES">
			<article class="ac">
				<header>
					<h3><?php echo JText::_('MOD_SVW_TEAM_COACH_TITLE'); ?></h3>
				</header>
				<?php foreach ($memberCoachesItems as $member){ ?>
				<?php displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, JText::_('MOD_SVW_TEAM_COACH_TITLE')); ?>
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

		<section class="teamPosition contentItem" id="team_COACHES">
			<article class="ac">
				<header>
					<h3><?php echo JText::_('MOD_SVW_TEAM_KEEPER_TITLE'); ?></h3>
				</header>
				<?php foreach ($memberCoachesItems as $member){ ?>
				<?php displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, JText::_('MOD_SVW_TEAM_COACH_TITLE')); ?>
				<?php } ?>
			</article>
		<?php endif; ?>
		
        <? /*!TEAM MEMBERS  */?>
        <?php if($showMembers == 1) : ?>
            <?php if(sizeof($memberGKItems) > 0) : ?>
            <section class="teamPosition contentItem" team="team_GK">
                <article class="ac">
    
                <header>
                    <h3 class="teamorder"><?php echo JText::_('MOD_SVW_TEAM_GK_TITLE'); ?></h3>
                </header>
                <?php foreach ($memberGKItems as $member){ ?>
                <?php displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, JText::_('MOD_SVW_TEAM_GK_TITLE')); ?>
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
                <?php displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, JText::_('MOD_SVW_TEAM_DF_TITLE')); ?>
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
                <?php displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, JText::_('MOD_SVW_TEAM_MF_TITLE')); ?>
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
                <?php displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, JText::_('MOD_SVW_TEAM_FW_TITLE')); ?>
                <?php } displayBackToTopLink(); ?>
            </article>
            </section>
            <?php endif; ?>
        <?php endif; ?>
    </section>
<?php endif; ?>
</section>