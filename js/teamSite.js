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
