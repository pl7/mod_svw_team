var teamImage;

function toggleFullSizeImage(myImage) {
    teamImage = myImage;
    if(myImage.className == "fullsize"){
       myImage.className = ""; 
    } else {
        myImage.className = "fullsize"; 
        document.onkeydown = function(evt) {
            evt = evt || window.event;
            if (evt.keyCode == 27) {
                toggleFullSizeImage(teamImage);
            }
        };
    }
}
