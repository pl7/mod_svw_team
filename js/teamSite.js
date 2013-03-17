var teamImage;
var teamKey
function toggleFullSizeImage(myImage, teamKey) {
    teamImage = myImage;
    teamImageCaption = document.getElementById(teamKey);

    if(myImage.className == "fullsize"){
       myImage.className = ""; 
    } else {
        myImage.className = "fullsize"; 
        document.onkeydown = function(evt) {
            evt = evt || window.event;
            if (evt.keyCode == 27) {
                toggleFullSizeImage(teamImage, teamKey);
            }
        };
    }
    if(teamImageCaption.className == "fullsize"){
       teamImageCaption.className = ""; 
    } else {
        teamImageCaption.className = "fullsize"; 
    }
}

/**
 Toggles contact info on contact page
 
 default switch between formular and contact details
*/
function toogleContactInfo(teamMemberId) {

    var teamMemberDO = $("#"+teamMemberId);
    
    if(teamMemberDO.hasClass('hide-info'))
    {
        teamMemberDO.removeClass('hide-info');
        teamMemberDO.addClass('show-info');
    }
    else
    {
        teamMemberDO.removeClass('show-info');
        teamMemberDO.addClass('hide-info');
    }
}

/**
 Flahes contact info in profile preview on team sites
*/
function flashContactInfo(teamMemberId) {

    var teamMemberDO = $("#"+teamMemberId);
    
    teamMemberDO.removeClass('flash-info');
    teamMemberDO.addClass('flash-info');

}