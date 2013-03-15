<?php 
function displayAttachments($attachment) { ?>
    
    <span><a class="attachment" target="_blank" href="<?php echo $attachment->url; ?>"><?php echo $attachment->title.' ['.strtoupper($attachment->type).']'; ?></a><br/></span>
<?php }

function displaySVWEventDateBox($eventDate, $rowSpan) { ?>

	<td class="svwDateTd" rowspan="<?php echo $rowSpan; ?>">
		<div class="svwDate month"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_SVW_MONTH')); ?></div>
		<div class="svwDate date"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_SVW_DATE')); ?></div>
		<div class="svwDate day"><?php echo JHtml::_('date', $eventDate, JText::_('DATE_FORMAT_SVW_DAY')); ?></div>
	</td>
<?php }

function displayTimeLabelsTds($event){
	if($event->time_begin != "00:00:00") { echo '<th class="beginLabel">'; echo JText::_('MOD_SVW_EVENT_BEGIN_LABEL'); echo'</th>'; }
	if($event->time_meeting != "00:00:00") { echo '<th class="meetingLabel">'; echo JText::_('MOD_SVW_EVENT_MEETING_LABEL'); echo'</th>';}
}
function displayGameTimeLabelsTds($event){
	if($event->time_begin != "00:00:00") { echo '<th class="beginLabel">'; echo JText::_('MOD_SVW_GAME_BEGIN_LABEL'); echo'</th>'; }
	if($event->time_meeting != "00:00:00") { echo '<th class="meetingLabel">'; echo JText::_('MOD_SVW_EVENT_MEETING_LABEL'); echo'</th>';}
}

function displayTimeValueTds($event, $begin, $end, $meeting){ ?>
	<td class="startEndTime">
		<?php if($event->time_begin != "00:00:00" || $event->time_end != "00:00:00") : ?>
		<?php echo '<time datetime="'.$begin.'">'.$begin->format('H:i').'</time>'; ?><?php if($event->time_end != "00:00:00") echo " - ".$end->format('H:i'); ?> Uhr<?php endif; ?>
	</td>
	<td class="meetingTime"><?php if($event->time_meeting != "00:00:00") : ?><?php echo $meeting->format('H:i'); ?> Uhr <?php endif; ?></td>
<?php }

function displaySVWEventDescription($event) { 

	if(strlen($event->home)>2 && strlen($event->guest)>2) : ?>
	<div itemscope itemtype="http://schema.org/Organization" itemprop="attendee">
		<h6><span itemprop="name"><?php echo $event->home;?></span></h6>
		<p><?php echo $event->guest; ?></p>
	</div>	
	<?php endif; 
}

function displaySVWEventLocation($event) { ?>
	<?php if(strlen($event->meeting_place) > 2) : ?>
	<div itemprop="location" itemscope itemtype="http://schema.org/Place">
		<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
			<p>
				<img class="location" src="<?php echo JURI::base(); ?>media/mod_svw_team/images/location.png" alt="Location Symbol">
				<span itemprop="addressLocality"><?php echo $event->meeting_place; ?></span>
			</p>
		</div>
	</div>
	<?php endif;
}

function displaySVWMember($member, $imgPath, $seasonKey, $teamKey) { ?>

    <tr onmouseout="this.className='odd'" onmouseover="this.className='datasite_actRow'" class="odd" height="39">
    <td></td>
    <td align="left"><?php echo $member->jersey_nr;?></td>
    <td width="180" align="left"><a href="teams/bundesliga/spieler/spielerportraits/?s1p1=2871"><?php echo $member->vorname." ".$member->name; ?></a></td>
    <td width="80" align="center">
        <?php 
        $filePath = $imgPath.$seasonKey."/team/".$teamKey."_".strtolower($member->name)."_".strtolower($member->vorname)."_tb.png";
        echo '<!--'.$filePath.'-->';
        $last_clubs = null;
        if(json_decode($member->last_clubs) != null){
            $last_clubs = json_decode($member->last_clubs);
        }
        
        if( JFile::exists(JPATH_ROOT.$filePath) ) : ?>
            <img class="noPrint" itemprop="image" src="<?php echo $filePath;?>" alt="Spieler">
        <?php else : ?>
            <img class="noPrint" itemprop="image" src="/images/Default_Profile_Picture_small.png" alt="Spieler">
        <?php endif; ?>
    </td>
    <td width="100" align="center"><?php echo $member->games;?></td>
    <td width="100" align="center"><?php echo $member->scores;?></td>
    <td width="88" align="center"><?php echo $member->bday;?></td>
    </tr>
    
    <? } 
        /*        <table width="624" cellspacing="0"><tbody>
            <tr class="kader_th" height="21">
            <th width="5"></th>
            <th width="24" align="left">Nr.</th>
            <th width="180" align="left">Name</th>
            <th width="80" align="center">Portrait</th>
            <th width="100" align="center">Spiele</th>
            <th width="100" align="center">Tore</th>
            <th width="88" align="center">Geb.datum</th>
            </tr>
            <?php foreach ($memberDefenseItems as $member){ ?>
            <?php displaySVWMember($member, $imgPath, $seasonKey, $teamKey); ?>
            <?php } ?>
            </tbody>
            </table>*/
        
    ?>

<?php 

function displayBackToTopLink() { ?>
    <nav class="back-to-top noPrint"><ul class="menu"><li><a href="#team_HEADER"><?php echo JText::_('MOD_SVW_TEAM_BACK_TO_TOP'); ?></a></li></ul></nav>
<? }

function displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, $teamorder) { ?>
    
    <a href="#?memberView=<?php echo $member->id; ?>" class="spieler" title="Steckbrief von <?php echo $member->vorname." ".$member->name; ?>">
    <?php 
    $filePath = $imgPath.$seasonKey."/team/".$teamKey."_".strtolower($member->name)."_".strtolower($member->vorname)."_tb.png";
	$filePathJpg = $imgPath.$seasonKey."/team/".$teamKey."_".strtolower($member->name)."_".strtolower($member->vorname)."_tb.jpg";
    echo '<!--'.$filePath.'-->';
    $last_clubs = null;
    if(json_decode($member->last_clubs) != null){
        $last_clubs = json_decode($member->last_clubs);
    }
    
    if( JFile::exists(JPATH_ROOT.$filePath) ) : ?>
        <img src="<?php echo $filePath;?>" alt="" width="43" height="58" class="klein">
    <?php elseif (JFile::exists(JPATH_ROOT.$filePathJpg) ) : ?>
		<img src="<?php echo $filePathJpg;?>" alt="" width="43" height="58" class="klein">
	<?php endif; ?>  
    <?php 
    $filePath = $imgPath.$seasonKey."/team/gross/".$teamKey."_".urldecode(strtolower($member->name))."_".urldecode(strtolower($member->vorname)).".jpg";
    echo '<!--'.$filePath.'-->';
    $last_clubs = null;
    if(json_decode($member->last_clubs) != null){
        $last_clubs = json_decode($member->last_clubs);
    }
    
    if( JFile::exists(JPATH_ROOT.$filePath) ) : ?>
        <img src="<?php echo $filePath;?>" alt="" width="226" height="58" class="gross">
    <?php endif; ?>    
      
      <span class="spielername players-overview"><?php echo $member->vorname." ".$member->name; ?></span>

  		<span class="spielerinfo players-overview">
  			<span class="nummer"><?php if($member->jersey_nr != 0) {echo $member->jersey_nr; } else {echo'&nbsp;';}?></span>
  			<span class="position"><?php echo $member->title != null ? $member->title : $teamorder; ?></span>
  			<span class="alter"><?php if($member->bday != '0000-00-00') {echo JHtml::_('date', $member->bday, JText::_('DATE_FORMAT_LC4')); }?></span>
  		</span>
    </a>
    
<? }

function displayTeamMember($member, $imgPath, $seasonKey, $teamKey) { 
    
    $canEdit = JFactory::getUser()->authorise('core.edit', 'com_languages');
?>
    
    <section class="teamMember" id="member<?php echo $member->id;?>" itemscope itemtype="http://schema.org/Person">
        <header>
            <h4><span itemprop="name"><span itemprop="givenName"><?php echo $member->vorname; ?></span>&nbsp;<span itemprop="familyName"><?php echo $member->name; ?></span></h4>
        </header>
        <table class="playerCard">
            <tbody>
                <tr>
                    <td rowspan="10" class="img">
                        <?php 
                        $filePath = $imgPath.$seasonKey."/team/".$teamKey."_".strtolower($member->name)."_".strtolower($member->vorname)."_tb.png";
                        echo '<!--'.$filePath.'-->';
                        $last_clubs = null;
                        if(json_decode($member->last_clubs) != null){
                            $last_clubs = json_decode($member->last_clubs);
                        }
                        
                        if( JFile::exists(JPATH_ROOT.$filePath) ) : ?>
                            <img class="noPrint" itemprop="image" src="<?php echo $filePath;?>">
                        <?php else : ?>
                            <img class="noPrint" itemprop="image" src="/images/Default_Profile_Picture_small.png">
                        <?php endif; ?>
                    </td>
                </tr>
                <?php if($member->title != null) : ?>
                <tr>
                    <th colspan="2"><span itemprop="jobTitle"><?php echo $member->title; ?></span></th>
                </tr>
                <?php endif; ?>
                <?php if($member->bday != '0000-00-00') : ?>
                <tr>
                    <td class="label"><?php echo JText::_('TPL_MEINVEREIN_SVW_TEAM_MEMBER_BDAY_LABEL'); ?></td>
                    <td><?php echo JHtml::_('date', $member->bday, JText::_('DATE_FORMAT_LC4')); ?></td>
                </tr>
                <?php endif; ?>
                <?php if($member->svw_since != '0000-00-00') : ?>
                <tr>
                    <td class="label"><?php echo JText::_('TPL_MEINVEREIN_SVW_TEAM_MEMBER_SVW_SINCE_LABEL'); ?></td>
                    <td><?php echo JHtml::_('date', $member->svw_since, JText::_('DATE_FORMAT_LC4')); ?></td>
                </tr>
                <?php endif; ?>
                <?php if($last_clubs != null) : ?>
                <tr>
                    <td class="label"><?php echo JText::_('TPL_MEINVEREIN_SVW_TEAM_MEMBER_LAST_CLUBS_LABEL'); ?></td>
                    <td><?php echo $member->last_clubs; ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td class="label" colspan="2">&nbsp;</td>
                </tr>
                <?php if($member->games > 0) : ?>
                <tr>
                    <td class="label"><?php echo JText::_('TPL_MEINVEREIN_SVW_TEAM_MEMBER_STATS_GAMES_LABEL'); ?></td>
                    <td><?php echo $member->games; ?></td>
                </tr>
                <?php endif; if($member->scores > 0) : ?>
                <tr>
                    <td class="label"><?php echo JText::_('TPL_MEINVEREIN_SVW_TEAM_MEMBER_STATS_SCORES_LABEL'); ?></td>
                    <td><?php echo $member->scores; ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td class="adresses" colspan="2">
                        <?php if(!empty($member->mail)) : ?>
                            <p><span class="adressLabel"><?php echo JText::_('JGLOBAL_EMAIL'); ?></span>
                            <?php echo JHtml::_('email.cloak', $member->mail); ?></p>
                        <?php endif; ?>
                        <?php if(!empty($member->tel_1) && $member->tel_1_label != 'Tel.') : ?>
                            <p><span class="adressLabel"><?php echo $member->tel_1_label ?></span>
                            <span  itemprop="telephone"><?php echo $member->tel_1; ?></span></p>
                        <?php endif; ?>
                        <?php if(!empty($member->tel_2) && $member->tel_2_label != 'Tel.') : ?>
                            <p><span class="adressLabel"><?php echo $member->tel_2_label ?></span>
                            <span  itemprop="telephone"><?php echo $member->tel_2; ?></span></p>
                        <?php endif; ?>
                        <?php if(!empty($member->tel_3) && $member->tel_3_label != 'Tel.') : ?>
                            <p><span class="adressLabel"><?php echo $member->tel_3_label ?></span>
                            <span  itemprop="telephone"><?php echo $member->tel_3; ?></span></p>
                        <?php endif; ?>
                        <div itemprop="worksFor" itemscope itemtype="http://schema.org/Organization" style="display:none">
                            <span itemprop="name">SV Wiesbaden 1899 e.V.</span>
                            
                        </div>
                    </td>
                </tr>
                </tbody>
        </table>
    </section>
<? } ?>
