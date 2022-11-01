var script = document.createElement('script');
script.src = "../js/jquery.js";
document.getElementsByTagName('head')[0].appendChild(script);

$(document).ready(function(){
    let confinementLink = $('#confinement-link');
    let loadingScreen = $('#loading-screen');
    let confinementChargesModal = $('#confinement-charges-modal');
    let icusTable = $('#icus-table')
    let petIsInIcu = $('#pet-is-in-icu')
    let confinementsTable = $('#confinements-table')
    let globalConfinementId = 0;

    getConfinements()

    petIsInIcu.on('click', function(){
        if(confirm('Mark this pet as \'in ICU\' for today?') == true){
            loadingScreen.show()
            $.ajax({
                type: 'POST',
                url: 'php/inICU.php',
                data:{
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    loadingScreen.hide();
                    let data = JSON.parse(response);

                    addToICUSTable(data.date);
                }
            })
        }
    })

    function addToICUSTable(date){
        icusTable.append(`<tr><td>${date}</td></tr>`);
    }

    function getConfinements(){
        loadingScreen.show();
        $.ajax({
            type: 'GET',
            url: 'php/confinements.php',
            success: function(response){
                loadingScreen.hide();
                var data = JSON.parse(response);
                $(data).each(function(index, value){
                    addToConfinementsTable(index, value.id, value.pet_name, value.pet_weight, value.client_name, value.attending_vet, value.date);
                    
                })
            }
        })
    }

    function addToConfinementsTable(index, id, petName, petWeight, clientName, attendingVet, date){
        confinementsTable.append(`<tr>
                                    <td>${petName}</td>
                                    <td>${petWeight}</td>
                                    <td>${clientName}</td>
                                    <td>${attendingVet}</td>
                                    <td>${date}</td>
                                    <td>
                                        <button value="${id}" class="view btn btn-primary">View</button>
                                    </td>
                                    
                                </tr>`);
        let viewConfinementDetails = confinementsTable.children().eq(index).find('.view');

        viewConfinementDetails.on('click', function(){

            let confinementId = $(this).val();
            globalConfinementId = confinementId;
            confinementChargesModal.modal('show');
            loadingScreen.show();
            $.ajax({
                type: 'POST',
                url: 'php/confinementDetails.php',
                data:{
                    confinement_id: confinementId
                },
                success: function(response){
                    loadingScreen.hide()
                    var data = JSON.parse(response);
                    
                    $(data.icus).each(function(index, value){
                        
                    })
                }
            })
        })
    }
})