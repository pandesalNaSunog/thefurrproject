var script = document.createElement('script');
script.src = "../js/jquery.js";
document.getElementsByTagName('head')[0].appendChild(script);

$(document).ready(function(){
    let confinementLink = $('#confinement-link');
    let confinementChagesModal = $('#confinement-charges-modal');
    let confinement = new Confinement()
    confinement.getConfinements();

    confinementLink.on('click', function(){
        confinement.getConfinements();
    })
})