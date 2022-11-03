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
    let petIsConfined = $('#pet-is-confined');
    let confinementRecordTable = $('#confinement-record-table')
    let patientDetails = $('#patient-details');
    let infusionPumpsTable = $('#infusion-pumps-table');
    let tickInfusionPump = $('#tick-infusion-pump');
    getConfinements()

    

    tickInfusionPump.on('click', function(){
        tickInfusionPump.prop('disabled', true);
        if(confirm('Please Confirm.') == true){
            $.ajax({
                type: 'POST',
                url: 'php/tickInfusionPump.php',
                data:{
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    tickInfusionPump.prop('disabled', false)
                    let data = JSON.parse(response)
                    addToInfusionPumpsTable(infusionPumpsTable.children().length, data.date, data.id)
                }
            })
        }
    })
    petIsConfined.on('click', function(){
        petIsConfined.prop('disabled', true);
        if(confirm('Mark this pet as \'Confined\' for today?') == true){
            $.ajax({
                type: 'POST',
                url: 'php/isConfined.php',
                data:{
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    petIsConfined.prop('disabled', false)
                    let data = JSON.parse(response)
                    addToConfinementRecordTable(confinementRecordTable.children().length, data.date, data.id)
                }
            })
        }
    })

    function addToConfinementRecordTable(index, date, id){
        confinementRecordTable.append(`<tr>
                                        <td>${date}</td>
                                        <td>
                                            <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                        </td>
                                    </tr>`)

        let deleteRecord = confinementRecordTable.children().eq(index).find('.delete');

        deleteRecord.on('click', function(){
            let thisDelete = $(this)
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true)
                $.ajax({
                    type: 'POST',
                    url: 'php/deleteConfinementRecord.php',
                    data:{
                        confinement_record_id: thisDelete.val()
                    },
                    success: function(response){
                        if(response == 'ok'){
                            thisDelete.parent().parent().remove()
                        }
                    }
                })
            }
        })
    }
    petIsInIcu.on('click', function(){
        petIsInIcu.prop('disabled', true);
        if(confirm('Mark this pet as \'in ICU\' for today?') == true){
            $.ajax({
                type: 'POST',
                url: 'php/inICU.php',
                data:{
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response);
                    petIsInIcu.prop('disabled', false);
                    addToICUSTable(icusTable.children().length, data.date, data.id);
                }
            })
        }
    })

    function addToICUSTable(index,date, id){
        icusTable.append(`<tr>
                            <td>${date}</td>
                            <td>
                                <button value="${id}" class="delete btn btn-outline-primary">Delete</button>
                            </td>
                        </tr>`);
        let deleteRecord = icusTable.children().eq(index).find('.delete');

        deleteRecord.on('click', function(){
            let thisDelete = $(this)
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true)
                $.ajax({
                    type: 'POST',
                    url: 'php/deleteIcuRecord.php',
                    data:{
                        icu_id: thisDelete.val()
                    },
                    success: function(response){
                        if(response == 'ok'){
                            thisDelete.parent().parent().remove()
                        }
                    }
                })
            }
        })
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

    function displayPatientDetails(petName, petWeight, clientName, attendingVet, date){
        patientDetails.append(`<p>Pet Name: <span class="fw-bold">${petName}</span><br>
                                Pet Weight: <span class="fw-bold">${petWeight}</span><br>
                                Client Name: <span class="fw-bold">${clientName}</span><br>
                                Attending Vet: <span class="fw-bold">${attendingVet}</span><br>
                                Date: <span class="fw-bold">${date}</span><br></p>`)
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
            icusTable.children().remove()
            confinementRecordTable.children().remove()
            infusionPumpsTable.children().remove()
            patientDetails.children().remove()
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
                        addToICUSTable(index,value.date,value.id);
                    })

                    $(data.confinement_records).each(function(index, value){
                        addToConfinementRecordTable(index, value.date, value.id)
                    })

                    $(data.infusion_pumps).each(function(index, value){
                        addToInfusionPumpsTable(index, value.date, value.id)
                    })

                    displayPatientDetails(data.pet_name, data.pet_weight, data.client_name, data.attending_vet, data.date)
                }
            })
        })
    }

    function addToInfusionPumpsTable(index, date, id){
        infusionPumpsTable.append(`<tr>
                            <td>${date}</td>
                            <td>
                                <button value="${id}" class="delete btn btn-outline-primary">Delete</button>
                            </td>
                        </tr>`);
        let deleteRecord = infusionPumpsTable.children().eq(index).find('.delete');

        deleteRecord.on('click', function(){
            let thisDelete = $(this)
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true)
                $.ajax({
                    type: 'POST',
                    url: 'php/deleteInfusionPump.php',
                    data:{
                        infusion_pump_id: thisDelete.val()
                    },
                    success: function(response){
                        if(response == 'ok'){
                            thisDelete.parent().parent().remove()
                        }
                    }
                })
            }
        })
    }
})