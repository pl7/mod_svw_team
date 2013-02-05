<?php 
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
    <nav class="back-to-top"><ul class="menu"><li><a href="#team_HEADER"><?php echo JText::_('MOD_SVW_TEAM_BACK_TO_TOP'); ?></a></li></ul></nav>
<? }

function displaySVWMemberPreview($member, $imgPath, $seasonKey, $teamKey, $teamorder) { ?>
    
    <a href="#?memberView=<?php echo $member->id; ?>" class="spieler" title="Steckbrief von <?php echo $member->vorname." ".$member->name; ?>">
    <?php 
    $filePath = $imgPath.$seasonKey."/team/".$teamKey."_".strtolower($member->name)."_".strtolower($member->vorname)."_tb.png";
    echo '<!--'.$filePath.'-->';
    $last_clubs = null;
    if(json_decode($member->last_clubs) != null){
        $last_clubs = json_decode($member->last_clubs);
    }
    
    if( JFile::exists(JPATH_ROOT.$filePath) ) : ?>
        <img src="<?php echo $filePath;?>" alt="" width="43" height="58" class="klein">
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
