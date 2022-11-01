

class Confinement {
    constructor(){
        this.confinementsTable = $('#confinements-table')
        this.loadingScreen = $('#loading-screen');
        this.confinementChargesModal = $('#confinement-charges-modal');
    }
    getConfinements(){
        this.confinementsTable.children().remove();
        let confinementsTable = this.confinementsTable;
        let loadingScreen = this.loadingScreen;
        loadingScreen.show();
        $.ajax({
            type: 'GET',
            url: 'php/confinements.php',
            success: function(response){
                loadingScreen.hide();
                var data = JSON.parse(response);
                $(data).each(function(index, value){
                    confinementsTable.append(`<tr>
                                            <td>${value.pet_name}</td>
                                            <td>${value.pet_weight}</td>
                                            <td>${value.client_name}</td>
                                            <td>${value.attending_vet}</td>
                                            <td>${value.date}</td>
                                            <td>
                                                <button value="${value.id}" class="view btn btn-primary">View</button>
                                            </td>
                                            
                                        </tr>`)
                    let confinementRow = new ConfinementRow(confinementsTable.children().eq(index).find('.view'));
                    confinementRow.view.on('click', function(){
                        confinementRow.showModal()
                        confinementRow.getConfinementDetails()
                    })
                })
            }
        })
    }      
}


class ConfinementRow{
    constructor(view){
        this.view = view
        this.loadingScreen = $('#loading-screen');
        this.confinementChargesModal = $('#confinement-charges-modal');
        this.icusTable = $('#icus-table')
    }

    getConfinementDetails(){
        let viewButton = this.view
        let loadingScreen = this.loadingScreen
        loadingScreen.show()
        $.ajax({
            type: 'POST',
            url: 'php/confinementDetails.php',
            data:{
                confinement_id: viewButton.val()
            },
            success: function(response){
                loadingScreen.hide()
                var data = JSON.parse(response);
            }
        }) 
    }
    showModal(){
        this.confinementChargesModal.modal('show')
    }
}



    