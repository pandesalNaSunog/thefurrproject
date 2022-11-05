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
    let tickSyringePump = $('#tick-syringe-pump');
    let syrignePumpsTable = $('#syringe-pumps-table');
    let addAntibiotic = $('#add-antibiotic');
    let antibioticInput = $('#antibiotic-input')
    let antibioticInputError = $('#antibiotic-input-error')
    let antibioticsTable = $('#antibiotics-table');
    let vitaminsTable = $('#vitamins-table');
    let vitaminsInput = $('#vitamins-input');
    let vitaminsInputError = $('#vitamins-input-error');
    let addVitamins = $('#add-vitamins');
    let specialMedicinesTable = $('#special-medicines-table');
    let specialMedicineInput = $('#special-medicine-input');
    let specialMedicineInputError = $('#special-medicine-input-error');
    let addSpecialMedicine = $('#add-special-medicine');
    let otherMedicinesTable = $('#other-medicines-table');
    let otherMedicineInput = $('#other-medicine-input');
    let otherMedicineInputErro = $('#other-medicine-input-error');
    let addOtherMedicine = $('#add-other-medicine');
    let laboratoryTable = $('#laboratory-table');
    let laboratoryInput = $('#laboratory-input');
    let laboratoryInputError = $('#laboratory-input-error');
    let addLaboratory = $("#add-laboratory");
    let foodTable = $('#food-table');
    let addFood = $('#add-food');
    let ivCanullaTable = $('#iv-canulla-table');
    let addIvCanulla = $('#add-iv-canulla');
    let ivLineTable = $('#iv-line-table');
    let addIvLine = $('#add-iv-line');
    let ivFluidTable = $('#iv-fluid-table');
    let addIvFluid = $('#add-iv-fluid');
    let underpadsTable = $('#underpads-table');
    let addUnderpads = $('#add-underpads');
    let nebulizationTable = $('#nebulization-table');
    let addNebulization = $('#add-nebulization');
    let laserTable = $('#laser-table');
    let addLaser= $('#add-laser');
    let oxygenTable = $('#oxygen-table');
    let addOxygen = $('#add-oxygen');
    getConfinements()
    

    removeErrorFromInputs(antibioticInput)
    removeErrorFromInputs(vitaminsInput)
    removeErrorFromInputs(specialMedicineInput)
    removeErrorFromInputs(otherMedicineInput)
    removeErrorFromInputs(laboratoryInput)
    

    function removeErrorFromInputs(input){
        input.on('keydown', function(){
            input.removeClass('is-invalid');
        })
    }


    addOxygen.on('click', function(){
        if(confirm('Please Confirm') == true){
           
            addOxygen.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'php/addOxygen.php',
                data:{
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response)
                    addOxygen.prop('disabled', false)
                    addToOxygenTable(oxygenTable.children().length, data.id, data.date, data.hours);
                }
            })
        }
    })

    addIvCanulla.on('click', function(){
        if(confirm('Please Confirm') == true){
           
            addIvCanulla.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'php/addIvCanulla.php',
                data:{
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response)
                    addIvCanulla.prop('disabled', false)
                    addToIvCanulla(ivCanullaTable.children().length, data.id, data.date);
                }
            })
        }
    })

    addLaser.on('click', function(){
        if(confirm('Please Confirm') == true){
           
            addLaser.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'php/addLaser.php',
                data:{
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response)
                    addLaser.prop('disabled', false)
                    addToLaserTable(laserTable.children().length, data.id, data.date);
                }
            })
        }
    })

    addNebulization.on('click', function(){
        if(confirm('Please Confirm') == true){
           
            addNebulization.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'php/addNebulization.php',
                data:{
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response)
                    addNebulization.prop('disabled', false)
                    addToNebulization(nebulizationTable.children().length, data.id, data.date);
                }
            })
        }
    })
    addUnderpads.on('click', function(){
        if(confirm('Please Confirm') == true){
           
            addUnderpads.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'php/addUnderpads.php',
                data:{
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response)
                    addUnderpads.prop('disabled', false)
                    addToUnderpadsTable(underpadsTable.children().length, data.id, data.date);
                }
            })
        }
    })

    addIvFluid.on('click', function(){
        if(confirm('Please Confirm') == true){
           
            addIvFluid.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'php/addIvFluid.php',
                data:{
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response)
                    addIvFluid.prop('disabled', false)
                    addToIvFluidTable(ivFluidTable.children().length, data.id, data.date);
                }
            })
        }
    })

    addIvLine.on('click', function(){
        if(confirm('Please Confirm') == true){
           
            addIvLine.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'php/addIvLine.php',
                data:{
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response)
                    addIvLine.prop('disabled', false)
                    addToIvLineTable(ivLineTable.children().length, data.id, data.date);
                }
            })
        }
    })

    addFood.on('click', function(){
        if(confirm('Please Confirm') == true){
           
            addFood.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'php/addFood.php',
                data:{
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response)
                    addFood.prop('disabled', false)
                    addToFoodTable(foodTable.children().length, data.id, data.date);
                }
            })
        }
    })

    addLaboratory.on('click', function(){
        if(laboratoryInput.val() == ""){
            laboratoryInput.addClass('is-invalid');
            laboratoryInputError.text('Please fill out this field')
        }else{
            addLaboratory.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'php/addLaboratory.php',
                data:{
                    lab: laboratoryInput.val(),
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response)
                    addLaboratory.prop('disabled', false)
                    laboratoryInput.val('')
                    addToLaboratoryTable(laboratoryTable.children().length, data.id, data.laboratory, data.date);
                }
            })
        }
    })

    addOtherMedicine.on('click', function(){
        if(otherMedicineInput.val() == ""){
            otherMedicineInput.addClass('is-invalid');
            otherMedicineInputErro.text('Please fill out this field')
        }else{
            addOtherMedicine.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'php/addOtherMedicine.php',
                data:{
                    other_medicine: otherMedicineInput.val(),
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response)
                    addOtherMedicine.prop('disabled', false)
                    otherMedicineInput.val('')
                    addToOtherMedicinesTable(otherMedicinesTable.children().length, data.id, data.other_medicine, data.date);
                }
            })
        }
    })

    addSpecialMedicine.on('click', function(){
        if(specialMedicineInput.val() == ""){
            specialMedicineInput.addClass('is-invalid');
            specialMedicineInputError.text('Please fill out this field')
        }else{
            addSpecialMedicine.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'php/addSpecialMedicine.php',
                data:{
                    special_medicine: specialMedicineInput.val(),
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response)
                    addSpecialMedicine.prop('disabled', false)
                    specialMedicineInput.val('')
                    addToSpecialMedicinesTable(specialMedicinesTable.children().length, data.id, data.special_medicine, data.date);
                }
            })
        }
    })

        

    addVitamins.on('click', function(){
        if(vitaminsInput.val() == ""){
            vitaminsInput.addClass('is-invalid');
            vitaminsInputError.text('Please fill out this field')
        }else{
            addVitamins.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'php/addVitamins.php',
                data:{
                    vitamins: vitaminsInput.val(),
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response)
                    addVitamins.prop('disabled', false)
                    vitaminsInput.val('')
                    addToVitaminsTable(vitaminsTable.children().length, data.id, data.vitamins, data.date);
                }
            })
        }
    })

    addAntibiotic.on('click', function(){
        if(antibioticInput.val() == ""){
            antibioticInput.addClass('is-invalid');
            antibioticInputError.text('Please fill out this field')
        }else{
            addAntibiotic.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'php/addAntibiotic.php',
                data:{
                    antibiotic: antibioticInput.val(),
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    let data = JSON.parse(response)
                    addAntibiotic.prop('disabled', false)
                    antibioticInput.val('')
                    addToAntibioticsTable(antibioticsTable.children().length, data.id, data.antibiotic, data.date);
                }
            })
        }
    })

    function addToAntibioticsTable(index, id, antibiotic, date){
        antibioticsTable.append(`<tr>
                                    <td>${antibiotic}</td>
                                    <td>${date}</td>
                                    <td>
                                        <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                    </td>
                                </tr>`)

        let thisDelete = antibioticsTable.children().eq(index).find('.delete');

        thisDelete.on('click', function(){
            let antibioticId = $(this).val()
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: 'php/deleteAntibiotic.php',
                    data:{
                        antibiotic_id: antibioticId
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

    function addToVitaminsTable(index, id, vitamins, date){
        vitaminsTable.append(`<tr>
                                    <td>${vitamins}</td>
                                    <td>${date}</td>
                                    <td>
                                        <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                    </td>
                                </tr>`)

        let thisDelete = vitaminsTable.children().eq(index).find('.delete');

        thisDelete.on('click', function(){
            let vitaminsId = $(this).val()
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: 'php/deleteVitamins.php',
                    data:{
                        vitamins_id: vitaminsId
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

    function addToSpecialMedicinesTable(index, id, specialMedicine, date){
        specialMedicinesTable.append(`<tr>
                                    <td>${specialMedicine}</td>
                                    <td>${date}</td>
                                    <td>
                                        <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                    </td>
                                </tr>`)

        let thisDelete = specialMedicinesTable.children().eq(index).find('.delete');

        thisDelete.on('click', function(){
            let specialMedicineId = $(this).val()
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: 'php/deleteSpecialMedicine.php',
                    data:{
                        special_medicine_id: specialMedicineId
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

    function addToOtherMedicinesTable(index, id, otherMedicine, date){
        otherMedicinesTable.append(`<tr>
                                    <td>${otherMedicine}</td>
                                    <td>${date}</td>
                                    <td>
                                        <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                    </td>
                                </tr>`)

        let thisDelete = otherMedicinesTable.children().eq(index).find('.delete');

        thisDelete.on('click', function(){
            let otherMedicineId = $(this).val()
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: 'php/deleteOtherMedicine.php',
                    data:{
                        other_medicine_id: otherMedicineId
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

    function addToFoodTable(index, id, date){
        foodTable.append(`<tr>
                                    <td>${date}</td>
                                    <td>
                                        <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                    </td>
                                </tr>`)

        let thisDelete = foodTable.children().eq(index).find('.delete');

        thisDelete.on('click', function(){
            let foodId = $(this).val()
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: 'php/deleteFood.php',
                    data:{
                        food_id: foodId
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
    function addToNebulization(index, id, date){
        nebulizationTable.append(`<tr>
                                    <td>${date}</td>
                                    <td>
                                        <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                    </td>
                                </tr>`)

        let thisDelete = nebulizationTable.children().eq(index).find('.delete');

        thisDelete.on('click', function(){
            let nebulizationId = $(this).val()
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: 'php/deleteNebulization.php',
                    data:{
                        nebulization_id: nebulizationId
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
    function addToUnderpadsTable(index, id, date){
        underpadsTable.append(`<tr>
                                    <td>${date}</td>
                                    <td>
                                        <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                    </td>
                                </tr>`)

        let thisDelete = underpadsTable.children().eq(index).find('.delete');

        thisDelete.on('click', function(){
            let underpadId = $(this).val()
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: 'php/deleteUnderpad.php',
                    data:{
                        underpad_id: underpadId
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
    function addToIvLineTable(index, id, date){
        ivLineTable.append(`<tr>
                                    <td>${date}</td>
                                    <td>
                                        <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                    </td>
                                </tr>`)

        let thisDelete = ivLineTable.children().eq(index).find('.delete');

        thisDelete.on('click', function(){
            let ivCanullaId = $(this).val()
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: 'php/deletIvLine.php',
                    data:{
                        iv_line_id: ivCanullaId
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
    function addToIvCanulla(index, id, date){
        ivCanullaTable.append(`<tr>
                                    <td>${date}</td>
                                    <td>
                                        <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                    </td>
                                </tr>`)

        let thisDelete = ivCanullaTable.children().eq(index).find('.delete');

        thisDelete.on('click', function(){
            let ivCanullaId = $(this).val()
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: 'php/deleteIvCanulla.php',
                    data:{
                        iv_canulla_id: ivCanullaId
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

    function addToOxygenTable(index, id, date, hours){
        oxygenTable.append(`<tr>
                                    <td>${date}</td>
                                    <td class="stopped-at">${hours}</td>
                                    <td>
                                        <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                    </td>
                                </tr>`)

        let thisDelete = oxygenTable.children().eq(index).find('.delete');
        thisDelete.on('click', function(){
            let ivCanullaId = $(this).val()
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: 'php/deleteIvCanulla.php',
                    data:{
                        iv_canulla_id: ivCanullaId
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

    function addToLaserTable(index, id, date){
        laserTable.append(`<tr>
                                    <td>${date}</td>
                                    <td>
                                        <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                    </td>
                                </tr>`)

        let thisDelete = laserTable.children().eq(index).find('.delete');

        thisDelete.on('click', function(){
            let laserId = $(this).val()
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: 'php/deleteLaser.php',
                    data:{
                        laser_id: laserId
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
    function addToIvFluidTable(index, id, date){
        ivFluidTable.append(`<tr>
                                    <td>${date}</td>
                                    <td>
                                        <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                    </td>
                                </tr>`)

        let thisDelete = ivFluidTable.children().eq(index).find('.delete');

        thisDelete.on('click', function(){
            let ivFLuidId = $(this).val()
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: 'php/deleteIvFluid.php',
                    data:{
                        iv_fluid_id: ivFLuidId
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


    function addToLaboratoryTable(index, id, laboratory, date){
        laboratoryTable.append(`<tr>
                                    <td>${laboratory}</td>
                                    <td>${date}</td>
                                    <td>
                                        <button value="${id}" class="btn btn-outline-primary delete">Delete</button>
                                    </td>
                                </tr>`)

        let thisDelete = laboratoryTable.children().eq(index).find('.delete');

        thisDelete.on('click', function(){
            let laboratoryId = $(this).val()
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: 'php/deleteLaboratory.php',
                    data:{
                        laboratory_id: laboratoryId
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
    tickSyringePump.on('click', function(){
        tickInfusionPump.prop('disabled', true);
        if(confirm('Please Confirm.') == true){
            $.ajax({
                type: 'POST',
                url: 'php/tickSyringePump.php',
                data:{
                    confinement_id: globalConfinementId
                },
                success: function(response){
                    tickInfusionPump.prop('disabled', false)
                    let data = JSON.parse(response)
                    addToSyringePumpsTable(infusionPumpsTable.children().length, data.date, data.id)
                }
            })
        }
    })
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
                    petIsInIcu.prop('disabled', false);
                    if(response != 'invalid'){
                        let data = JSON.parse(response);
                        addToICUSTable(icusTable.children().length, data.date, data.id);
                    }
                    
                    
                    
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
            syrignePumpsTable.children().remove()
            antibioticsTable.children().remove()
            vitaminsTable.children().remove()
            specialMedicinesTable.children().remove()
            otherMedicinesTable.children().remove()
            laboratoryTable.children().remove()
            foodTable.children().remove()
            ivCanullaTable.children().remove()
            ivLineTable.children().remove()
            ivFluidTable.children().remove()
            underpadsTable.children().remove()
            nebulizationTable.children().remove()
            laserTable.children().remove()
            oxygenTable.children().remove()
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

                    $(data.syringe_pumps).each(function(index, value){
                        addToSyringePumpsTable(index, value.date, value.id)
                    })

                    $(data.antibiotics).each(function(index, value){
                        addToAntibioticsTable(index, value.id, value.antibiotic, value.date);
                    })
                    $(data.vitamins).each(function(index, value){
                        addToVitaminsTable(index, value.id, value.vitamins, value.date);
                    })

                    $(data.special_medicines).each(function(index, value){
                        addToSpecialMedicinesTable(index, value.id, value.special_medicine, value.date);
                    })
                    $(data.other_medicines).each(function(index, value){
                        addToOtherMedicinesTable(index, value.id, value.other_medicine, value.date);
                    })
                    $(data.laboratories).each(function(index, value){
                        addToLaboratoryTable(index, value.id, value.laboratory, value.date);
                    })

                    $(data.food).each(function(index, value){
                        addToFoodTable(index, value.id, value.date);
                    })
                    $(data.iv_canullas).each(function(index, value){
                        addToIvCanulla(index, value.id, value.date);
                    })
                    $(data.iv_lines).each(function(index, value){
                        addToIvLineTable(index, value.id, value.date);
                    })

                    $(data.iv_fluids).each(function(index, value){
                        addToIvFluidTable(index, value.id, value.date);
                    })

                    $(data.underpads).each(function(index, value){
                        addToUnderpadsTable(index, value.id, value.date);
                    })

                    $(data.nebulizations).each(function(index, value){
                        addToNebulization(index, value.id, value.date);
                    })

                    $(data.laser_therapies).each(function(index, value){
                        addToLaserTable(index, value.id, value.date);
                    })
                    $(data.oxygens).each(function(index, value){
                        addToOxygenTable(index, value.id, value.date, value.hours);
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

    function addToSyringePumpsTable(index, date, id){
        syrignePumpsTable.append(`<tr>
                            <td>${date}</td>
                            <td>
                                <button value="${id}" class="delete btn btn-outline-primary">Delete</button>
                            </td>
                        </tr>`);
        let deleteRecord = syrignePumpsTable.children().eq(index).find('.delete');

        deleteRecord.on('click', function(){
            let thisDelete = $(this)
            if(confirm('Delete this record?') == true){
                thisDelete.prop('disabled', true)
                $.ajax({
                    type: 'POST',
                    url: 'php/deleteSyringePump.php',
                    data:{
                        syringe_pump_id: thisDelete.val()
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