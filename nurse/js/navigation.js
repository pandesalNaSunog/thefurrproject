var script = document.createElement('script');
script.src = "../js/jquery.js";
document.getElementsByTagName('head')[0].appendChild(script);

$(document).ready(function(){
    var confinementLink = $('#confinement-link');
    var loadingScreen = $('#loading-screen');
    loadingScreen.hide();
    confinementLink.on('click', function(){
        loadingScreen.show();

        
    })
})
