/**
 * OPENTOK - APPLICATION (DOCTOR)
 */

var opentok_key;
var opentok_session_id;
var opentok_token;
var session;
var userId;
var userName;
var userType = "OPERATOR";
var userTypePatient = "PATIENT";
var ringingSound;
var publisher;
var subscriber;
var isCalling = false;
var receivingCalling = false;
var stopCalling = false;
var sessionIsConnected = false;
var counter;
var counterConnection;
var constTimeout = 10;
var timeout = constTimeout;
var retryConnection = 3;
var isOperatorAvailable = true;
var chatSession = null;
var qtdChatTry = 0;
var ot_sessionId;
var ot_token;

function date_ptBR(date){
    var date = new Date(date);

    return ("0"+date.getDay()).slice(-2)+"/"+("0"+date.getMonth()).slice(-2)+"/"+date.getFullYear()+" as "+("0"+date.getHours()).slice(-2)+":"+("0"+date.getMinutes()).slice(-2);
}

function patient(patient_id){   
    $("#info-load").show();
    $.ajax({
        url: "/admin/patient_ajax",
        type: "GET",
        cache : false,
        data: {
                id: patient_id
            },
        success: function(response){
            $("#info-load").hide();
            $("#tab-content").show();

            var result = response.patient;
            console.log(result);

            if(result.type == 1){
                
                $("#select_patient").show();

                $.each(response.patients, function(i , row_patient){
                    if(row_patient){                    
                        $('#patient_id').append('<option value="'+row_patient.id+'">'+row_patient.name+'</option>');
                    }                           
                });

            }

            // Dados Paciente
            $("#patientId").val(result.id);
            $("#patient_name").html(result.name);
            $("#patient_phone_number").html(result.phone_number);
            $("#patient_cpf").html(result.cpf);
            $("#patient_address").html(result.address);
            $("#patient_complement").html(result.complement);
            $("#patient_neighborhood").html(result.neighborhood);
            $("#patient_state").html(result.state);
            $("#patient_city").html(result.city);

            // Contatos
            $.each(result.contact, function(i , row_contact){
                console.log(row_contact);
                if(row_contact){                    
                    $('#table_contact').append('<tr><td>'+row_contact.name+'</td>\
                        <td>'+row_contact.phone+'</td>\
                        </tr>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            // Prontuario - Atendimentos Recentes
            $.each(result.allergy, function(i , row_allergy){
                console.log(row_allergy);
                if(row_allergy){
                    $('#table_allergy').append('<tr><td>'+row_allergy.name+'</td></tr>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            // Prontuario - Atendimentos Recentes
            $.each(result.attendance, function(i , row_attendance){
                console.log(row_attendance);
                if(row_attendance){
                    // $('#table_attendance').append('<div class="panel panel-primary">\
                    //                     <div class="panel-heading">Atendimento em '+date_ptBR(row_attendance.created_at)+'</div>\
                    //                     <div class="panel-body"><p>'+row_attendance.description+'</p></div>\
                    //                     </div>');
                    $('#table_attendance').append('<div class="card text-white bg-dark"><div class="card-header text-white bg-dark">Atendimento de '+date_ptBR(row_attendance.created_at)+'</div><div class="card-body">'+row_attendance.description+'</div></div>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            // Prontuario - Atendimentos Recentes
            $.each(result.treatment, function(i , row_treatment){
                console.log(row_treatment);
                if(row_treatment){                  
                    $('#table_treatment').append('<tr><td>'+row_treatment.name+'</td>\
                        <td>'+row_treatment.start_date+'</td>\
                        <td>'+(row_treatment.final_date?row_treatment.final_date:"-")+'</td>\
                        </tr>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            // Prontuario - Exams
            $.each(result.exam, function(i , row_exam){
                console.log(row_exam);
                if(row_exam){
                    $('#table_exam').append('<tr><td>'+row_exam.name+'</td>\
                        <td>'+row_exam.date+'</td>\
                        <td>'+row_exam.doctor_name+'</td>\
                        <td><img src="/exam/'+row_exam.image+'" alt="" style="width: 100px" class="img-thumbnail"></td>\
                        </tr>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            // Prontuario - Medição
            $.each(result.measurement, function(i , row_measurement){
                console.log(row_measurement);
                if(row_measurement){
                    $('#table_measurement').append('<tr><td>'+row_measurement.category+'</td>\
                        <td>'+(row_measurement.frequency?row_measurement.frequency:"-")+'</td>\
                        <td>'+row_measurement.times_day+'</td>\
                        </tr>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            // Prontuario - Sintomas
            $.each(result.symptom, function(i , row_symptom){
                console.log(row_symptom);
                console.log('SIINTOMAAS');
                if(row_symptom){
                    $('#table_symptom').append('<tr><td>'+row_symptom.name+'</td>\
                        <td>'+(row_symptom.intensity?row_symptom.intensity:"-")+'</td>\
                        <td>'+row_symptom.start_date+'</td>\
                        <td>'+row_symptom.reason_symptom+'</td>\
                        </tr>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            

            // Prontuario - Exams
            $.each(result.recommendation, function(i , row_recommendation){
                console.log(row_recommendation);
                if(row_recommendation){
                    $('#table_recommendation').append('<div class="panel panel-primary">\
                                        <div class="panel-heading">Recomendação em '+date_ptBR(row_recommendation.created_at)+'</div>\
                                        <div class="panel-body"><p>'+row_recommendation.description+'</p></div>\
                                        </div>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            // Prontuario - Diagnosticos
            $.each(result.diagnostico, function (i, row_diagnostico) {
                console.log(row_diagnostico);
                if (row_diagnostico) {
                    $('#table_diagnostico').append('<div class="panel panel-primary">\
                                        <div class="panel-heading">Diagnóstico em '+ date_ptBR(row_diagnostico.created_at) + '</div>\
                                        <div class="panel-body"><p>'+ row_diagnostico.description + '</p></div>\
                                        </div>');
                } else {
                    $('#table_call').hide();
                    $('#call_empty').show();
                }
            });

            $.each(result.conduct, function (i, row_conduct) {
                console.log(row_conduct);
                if (row_conduct) {
                    $('#table_conduct').append('<div class="panel panel-primary">\
                                        <div class="panel-heading">Criado em '+ date_ptBR(row_conduct.created_at) + '</div>\
                                        <div class="panel-body"><p>'+ row_conduct.description + '</p></div>\
                                        </div>');
                } else {
                    $('#table_call').hide();
                    $('#call_empty').show();
                }
            });


            // Prontuario - Remérios
            $.each(result.medicine, function(i , row_medicine){
                console.log(row_medicine);
                if(row_medicine){
                   $('#list_medicine').append('<tr><td>'+row_medicine.name+'</td>\
                        <td>'+row_medicine.dosage+'</td>\
                        <td>'+row_medicine.date_initial+'</td>\
                        <td>'+row_medicine.date_final+'</td>\
                        <td>'+row_medicine.description+'</td>\
                        </tr>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            // Prontuario - Familiar
            $.each(result.family, function(i , row_family){
                console.log(row_family);
                if(row_family){
                   $('#table_family').append('<tr><td>'+row_family.kinship+'</td>\
                        <td>'+row_family.disease+'</td>\
                        </tr>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            // Prontuario - Vacinas
            $.each(result.vaccine, function(i , vaccine){
                console.log(vaccine);
                if(vaccine){
                   $('#table_vaccine').append('<tr><td>'+vaccine.name+'</td>\
                        </tr>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });


            // Prontuario - evaluation
            $.each(result.evaluation, function(i , row_evaluation){
                console.log(row_evaluation);
                if(row_evaluation){
                    // $('#box_add_evaluation').append('<div class="panel panel-primary">\
                    //                     <div class="panel-heading">Diagnóstico em '+date_ptBR(row_evaluation.created_at)+'</div>\
                    //                     <div class="panel-body"><p>'+row_evaluation.description+'</p></div>\
                    //                     </div>');
                    $('#box_add_evaluation').append('<div class="card text-white bg-dark"><div class="card-header text-white bg-dark">Avaliação em '+date_ptBR(row_evaluation.created_at)+'</div><div class="card-body">'+row_evaluation.description+'</div></div>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            // Prontuario - SInais Vitais
            $.each(result.vitalsign, function(i , row_vitalsign){
                console.log(row_vitalsign);
                if(row_vitalsign){
                    $('#table_vitalsign').append('<tr><td>'+row_vitalsign.pressure+'</td>\
                        <td>'+row_vitalsign.oximeter+'</td>\
                        <td>'+row_vitalsign.glycemia+'</td>\
                        <td>'+row_vitalsign.temperature+'</td>\
                        <td>'+row_vitalsign.ecg+'</td>\
                        <td>'+date_ptBR(row_vitalsign.created_at)+'</td>\
                        </tr>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            if(result.quantitative[0].weight)                  $("#exam_weight").html(result.quantitative[0].weight);
            if(result.quantitative[0].height)                  $("#exam_height").html(result.quantitative[0].height);
            if(result.quantitative[0].temperature)             $("#exam_temperature").html(result.quantitative[0].temperature);
            if(result.quantitative[0].imc)                     $("#exam_imc").html(result.quantitative[0].imc);
            if(result.quantitative[0].abdominal_circumference) $("#exam_abdominal_circumference").html(result.quantitative[0].abdominal_circumference);
            if(result.quantitative[0].pressure_sitting)        $("#exam_pressure_sitting").html(result.quantitative[0].pressure_sitting);
            if(result.quantitative[0].pressure_lying)          $("#exam_pressure_lying").html(result.quantitative[0].pressure_lying);


            if(result.qualitative[0].lymph_nodes)       $("#exam_lymphnodes").html(result.qualitative[0].lymph_nodes);
            if(result.qualitative[0].respiratory)       $("#exam_respiratory").html(result.qualitative[0].respiratory);
            if(result.qualitative[0].adome)             $("#exam_abdomen").html(result.qualitative[0].adome);
            if(result.qualitative[0].mucous)            $("#exam_mucous").html(result.qualitative[0].mucous);
            if(result.qualitative[0].eyes_face)         $("#exam_eyesFace").html(result.qualitative[0].eyes_face);
            if(result.qualitative[0].cardiovascular)    $("#exam_cardiovascular").html(result.qualitative[0].cardiovascular);
            if(result.qualitative[0].skin)              $("#exam_skin").html(result.qualitative[0].skin);
            if(result.qualitative[0].members_body)      $("#exam_limbs").html(result.qualitative[0].members_body);
            

            // Prontuario - questionario
            $.each(response.questions, function(i , question){
                if(question){
                    $('#box_questions').append('<p><strong>'+question.quest.label+'</strong></p><p style="padding-left: 30px;">'+question.answer+'</p>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            // Prontuario - links
            $.each(result.link, function(i , row_link){

                if(row_link){
                    $('#box_links').append('<div class="panel panel-primary">\
                                        <div class="panel-heading">'+row_link.title+'</div>\
                                        <div class="panel-body"><a target="_blank" href="'+row_link.link+'" style="display:block;">'+row_link.link+'</a><p>'+row_link.description+'</p></div>\
                                        </div>');
                }else{
                    $('#table_call').hide();
                    $('#call_empty').show();
                }                           
            });

            // if(result){
            //  alert('Avaliação criada com Sucesso');
            //  $('#box_add_evaluation').prepend('<div class="panel panel-primary"><div class="panel-heading">Avaliação em 18/11/2017</div><div class="panel-body"><p>'+data_evaluation_description+'</p></div></div>');
            //  $('#data_evaluation_description').val('');
            // }
            //$('#submit_donate').button('reset');
        }               
    });
}
// patient(15);
$("#patient_id").on("change", function(){
    patient($(this).val());
})
/**
 * This function waiting some time before stop calling
 */
function timer() {
    timeout = timeout -1;
    console.log("Aguardando Ligação - "+timeout+"s para Timeout...");
    if (timeout <= 0) {
        clearInterval(counter);
        $('#modalStartingCallTitle').html("<strong>A ligação não foi atendida!</strong>");
        $('#modalStartingCallText').html("O paciente não respondeu a sua solicitação de ligação. Por favor, tente novamente!");
        $('#buttonOkModalStartingCall').show();
        console.log("Timeout na ligação!");
        session.signal({
            type: "timeOut"
        });
        timeout = constTimeout;
    }
}

/**
 * This function disconnect from session
 */
function disconnected() {
    checkUrlToBlockAllButtons();
    // Remove Stream publishes
    if (publisher != null) {
        session.unpublish(publisher);
        publisher.destroy();
    }
    if (subscriber != null) {
        session.unsubscribe(subscriber);
        subscriber.destroy();
    }
    if (session != null) {
        // Disconnect from session
        console.log('Desconectando dos servidores do Opentok...');
        sessionIsConnected = false;
        session.disconnect();
    }
    ringingSound.stop();
}

/**
 * This function clear all variables
 */
function clearVariables() {
    isOperatorAvailable = true;
    opentok_key = null;
    opentok_session_id = null;
    opentok_token = null;
    session = null;
    userId = null;
    publisher = null;
    subscriber = null;
    isCalling = false;
    stopCalling = false;
    receivingCalling = false;
    clearInterval(counterConnection);
    clearInterval(counter);
}

/**
 * This function define all signals
 */
function defineAllSignals() {
    // Starting call with patient
    $('#callPatient').click(function(){
        if (isCalling == false) {
            disconnected();
            clearVariables();
            isCalling = true;

            $('#modalStartingCallTitle').html("Iniciando Ligação...");
            $('#modalStartingCallText').html("Por favor <strong> aguarde! </strong>, Estamos completando a sua ligação...");
            $('#buttonOkModalStartingCall').hide();
            $('#modal-startingCalling').modal('show');

            console.log('Você foi desconectado com sucesso!');
            console.log('Obtendo informações de sessão do paciente');
            getPatientOpentokInformation($('#buttonCallPatient').val());
            $('#videos').show();
        }
    });

    $('.quitCall').click(function(){

        $.ajax({
            type: "POST",
            url: opentokEndCallURL,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                'userId': userId,
            },
            dataType: "json",
            success: function(data) {
                console.log("Chamada encerrada!");
                disconnected();
                clearVariables();
                clearInterval(counter);
                timeout = constTimeout;
                $('#videos').hide();
                stopCalling = false;                
                window.location = window.location.href.split('?')[0];
            },
            error: function(data){
                console.log("Houve um erro ao salvar os dados da chamada.");
                disconnected();
                clearVariables();
                clearInterval(counter);
                timeout = constTimeout;
                $('#videos').hide();
                stopCalling = false;
                window.location = window.location.href.split('?')[0];
            },
        });
    });


    // Stoping call with patient
    $('.closeCall').click(function(){
        stopCalling = true;
        // Sent signal
        session.signal({
            type: 'stopCall',
            data: {
                userName: userName,
                appointmentDate: $('#appointmentDate').val()
            }
        });

        $.ajax({
            type: "POST",
            url: opentokEndCallURL,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                'userId': userId,
            },
            dataType: "json",
            success: function(data) {
                console.log("Chamada encerrada!");
                disconnected();
                clearVariables();
                clearInterval(counter);
                timeout = constTimeout;
                $('#videos').hide();
                stopCalling = false;
                $.ajax({
                    url: "/callcenter/send_sms",
                    type: "GET",
                    cache : false,            
                    success: function(result){
                        console.log('SEND SMS');
                    }               
                });
                window.location = window.location.href.split('?')[0];
            },
            error: function(data){
                console.log("Houve um erro ao salvar os dados da chamada.");
                disconnected();
                clearVariables();
                clearInterval(counter);
                timeout = constTimeout;
                $('#videos').hide();
                stopCalling = false;
                $.ajax({
                    url: "/callcenter/send_sms",
                    type: "GET",
                    cache : false,            
                    success: function(result){
                        console.log('SEND SMS');
                    }               
                });
                window.location = window.location.href.split('?')[0];
            },
        });
    });
}

function handleError(error) {
    if (error) {
      console.error(error);
    }
}

/**
 * This function define all listeners
 */
function defineAllListeners() {
    // Event when patient start publish there streaming
    // session.on('streamCreated', function(event){
    //     console.log('subscriber');
    //     console.log(event);
    //     if (subscriber == null) {
    //         subscriber = session.subscribe(event.stream, 'subscriber', {
    //             insertMode: 'append',
    //             width: '100%',
    //             height: '100%',
    //             name: event.name,
    //         });
    //     }
    //     clearInterval(counterConnection);
    // });

    session.on('streamCreated', function streamCreated(event) {
        console.log('======================= > subscriber');
        console.log(event);
        var subscriberOptions = {
            insertMode: 'append',
            width: '50%',
            height: '50%'
        };
        session.subscribe(event.stream, 'subscriber', subscriberOptions, handleError);
    });

    // Event when patient call doctor
    session.on('signal:callDoctor', function(event){
        if (receivingCalling == false) {
            receivingCalling = true;
            console.log('=============> EVENT INFO <===============');
            console.log(event.target.sessionId);
            $("#ot_session_id").val(event.target.sessionId);
            console.log('=============> ---- <===============');
            console.log(event.target.token);
            $("#ot_token").val(event.target.token);
            // $('#modalCallTitle').html("Recebendo Ligação do(a) Paciente "+event.data.userName);
            // $('#modalCallDate').html(event.data.appointmentDate);
            // $('#modal-call').modal('show');
            patient(event.data.patient_id);
            ringingSound.play();
            console.log('callDoctor', event);

            // $.ajax({
            //     url: "/callcenter/send_sms",
            //     type: "GET",
            //     cache : false,            
            //     success: function(result){
            //         console.log('SEND SMS');
            //     }               
            // });

            $('#btn_start_call').show();
            
            $('#btn_start_call').on('click', function(){
                ringingSound.stop();
                $('#btn_start_call').hide();
            });

            // Accepts call button is clicked
            if(isOperatorAvailable){
                isOperatorAvailable = false;
                //ringingSound.stop();
                $('#modal-call').modal('hide');
                url = callcenterStartRoute;
                current_url = window.location.href;

                if (current_url.indexOf(url) != -1) {
                    if(event.data.call_type == 1){
                        $("#chat_operator").show();
                    }else{
                        $('#videos').show();
                    }                    
                    disabledCallButton();     
                    console.log('USER_NAME');
                    // Sent Accepts Signal
                    session.signal({
                        type: 'answerCall',
                        data: {
                            answer: 'ACCEPT',
                            userName: 'Gabriel Gandolfo'
                        }
                    });
                    // console.log(userName);
                } else {
                    window.location.href = callcenterStartRoute + '?call=true';
                }
            };

            // Reject call button is clicked
            $('#buttonRejectCall').click(function(){
                receivingCalling = false;
                //ringingSound.stop();
                $('#modal-call').modal('hide');
                url = Routing.generate('appointment_start', {code: event.data.appointmentId});
                current_url = window.location.href;

                // Sent Reject Signal
                session.signal({
                    type: 'answerCall',
                    data: {
                        answer: 'REJECT',
                        userName: userName
                    }
                });

                if (current_url.indexOf(url) != -1) {
                    enabledCallButton();
                }

            });
        }
    });

    // Event when patient stop a call
    session.on('signal:stopCall', function(event){
        if (stopCalling == false) {
            console.log('O(A) paciente '+event.data.userName+' encerrou a ligação!');
            disconnected();
            clearVariables();
            $('#videos').hide();
            window.location = window.location.href.split('?')[0];
        }
    });

    // Event when Patient answer call from Doctor
    session.on('signal:answerCall', function(event){
        console.log('PUBLISHER');
        console.log(event)
        // Accepts call
        if (event.data.answer == 'ACCEPT') {
            clearInterval(counter);
            timeout = constTimeout;
            if (publisher == null) {
                if(event.data.call_type == 1){
                    publisher = OT.initPublisher('publisher', {
                        insertMode: 'append',
                        width: '100%',
                        height: '100%',
                        name: userName,
                        publishAudio:false, 
                        publishVideo:false
                    });
                }else{
                    publisher = OT.initPublisher('publisher', {
                        insertMode: 'append',
                        width: '100%',
                        height: '100%',
                        name: userName
                    });
                }                
                session.publish(publisher);
            }
            clearInterval(counterConnection);
            //ringingSound.stop();
            disabledCallButton();
            $('#modal-startingCalling').modal('hide');
        } else {
            clearInterval(counter);
            timeout = constTimeout;
            $('#modalStartingCallTitle').html("Ligação <spam class='red sbold'> Cancelada! </spam>");
            $('#modalStartingCallText').html("O(A) Paciente <strong>"+event.data.userName+"</strong> recusou a sua ligação");
            $('#buttonOkModalStartingCall').show();
            $('#modal-startingCalling').modal('show');
            $('#videos').hide();
            disconnected();
            clearVariables();
            getSelfOpentokInformation();
        }

    });

    // Event when patient calling is in timeout
    session.on('signal:timeOut', function(data){
        $('#modal-call').modal('hide');
        ringingSound.stop();
        $('#videos').hide();
        disconnected();
        clearVariables();
        getSelfOpentokInformation();
    });
}

/**
 * This function start a session with opentok servers
 */
function startOpenTokSession() {
    console.log('Conectando aos servidores do Opentok...');
    if (OT.checkSystemRequirements() == 0) {
        console.log("O cliente não suporta a tecnologia 'webRTC'...")
        clearInterval(counterConnection);
    } else {
        if (opentok_key == null || opentok_session_id == null) {
            console.log('Os valores da sessão é nulo!');
        }
        session = OT.initSession(opentok_key, opentok_session_id);
        session.connect(opentok_token, function(error){
            if (error) {
                console.log('Não foi possí­vel conectar nos servidores do Opentok: '+ error.message);
                return;
            }
            if (isCalling == true) {
                // Sent signal
                session.signal({
                    type: 'callPatient',
                    data: {
                        userName: userName,
                        appointmentId: $('#appointmentId').val(),
                        appointmentDate: $('#appointmentDate').val()
                    }
                });
                blockAllCallButtons();
                counter = setInterval(timer, 1000);
            }

            // Define all listeners
            defineAllListeners();
            startListeners();
            console.log('Conectado com sucesso aos servidores do Opentok!');
            sessionIsConnected = true;
            clearInterval(counterConnection);
            checkUrlToEnableButtons();
            defineAllSignals();
            startCallingFromAnotherPage();
            clearInterval(counterConnection);
        });
    }
}


/**
 * This function get from server the Opentok users information and start the session with Opentok servers
 */
function getSelfOpentokInformation() {
    console.log('getSelfOpentokInformation', opentokUserInformationURL);
    $.ajax({
        type: "POST",
        url: opentokUserInformationURL,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {UserType: userType},
        success: function(data){
            userId = data.userId;
            userName = data.userName;
            console.log('userId: '+userId);
            $.ajax({
                type: "POST",
                url: opentokInformationURL,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    'ID': userId,
                    'UserType': userType
                },
                success: function(data) {
                    console.log("Informações do Opentok obtidas com sucesso do servidor!");
                    opentok_key = data.api_key;
                    opentok_session_id = data.session_id;
                    opentok_token = data.token;
                    startOpenTokSession();
                },
                error: function(data){
                    console.log("Houve um erro ao obter as informações do Opentok");
                },
                dataType: "json"
            });

        },
        error: function(data){
            console.log("Não foi possí­vel obter as informações do usuário autenticado!");
        },
        dataType: "json"
    });
}

/**
 * This function get Other users Opentok information
 * @param id
 */
function getPatientOpentokInformation(id) {
    //console.log('DATA_OPENTOK_USER: '+id);
    $.ajax({
        type: "POST",
        url: Routing.generate('tokbox_users_information'),
        data: {
            'ID': id,
            'UserType': userTypePatient
        },
        success: function(data) {
            console.log("Informações do Opentok obtidas com sucesso do servidor!");
            opentok_key = data.api_key;
            opentok_session_id = data.session_id;
            opentok_token = data.new_token;
            startOpenTokSession();
        },
        error: function(data) {
            $('#modalStartingCallTitle').html(
                "<span class='fa fa-warning font-red-thunderbird'></span><strong class='font-red-thunderbird'> ATENÇÃO </strong>");
            $('#modalStartingCallText').html("Não foi possível completar sua ligação. Por favor, tente novamente!");
            $('#buttonOkModalStartingCall').show();
            console.log("Houve um erro ao obter as informações do Opentok");
            clearVariables();
            getSelfOpentokInformation();
        },
        dataType: "json"
    });
}

/**
 * This function block CloseCall and release MakeCall
 */
function enabledCallButton() {
    $('#callPatient').prop('disabled', false);
    $('#closeCall').prop('disabled', true);
}

/**
 * This function block MakeCall and release CloseCall
 */
function disabledCallButton() {
    $('#callPatient').prop('disabled', true);
    $('#closeCall').prop('disabled', false);
}

/**
 * This function block all buttons
 */
function blockAllCallButtons() {
    console.log('blockAllCallButtons');
    $('#callPatient').prop('disabled', true);
    $('#closeCall').prop('disabled', true);
}

/**
 * This function checks if page is the call page and enables call buttons
 */
function checkUrlToEnableButtons() {
    url = callcenterStartRoute;
    current_url = window.location.href;
    if (current_url.indexOf(url) != -1) {
        enabledCallButton();
    }
}

/**
 * This function checks if page is the call page and block all call buttons
 */
function checkUrlToBlockAllButtons() {
    console.log('checkUrlToBlockAllButtons', callcenterStartRoute);
    url = callcenterStartRoute;
    current_url = window.location.href;
    if (current_url.indexOf(url) != -1) {
        blockAllCallButtons();
    }
}

/**
 * This function checks if answer is from another page
 */
function startCallingFromAnotherPage() {
    var param = getParameter('call');
    url = callcenterStartRoute;
    current_url = window.location.href;
    if (current_url.indexOf(url) != -1) {
        if (param == "true") {
            // Sent Accepts Signal
            session.signal({
                type: 'answerCall',
                data: {
                    answer: 'ACCEPT',
                    userName: userName
                }
            });
            $('#videos').show();
        }
    }
}

/**
 * Get URL Param
 * @param name
 * @returns {*}
 */
function getParameter(name)
{
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS, "g" );
    var results = regex.exec( window.location.href );
    if( results == null )
        return "";
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
}



// ======================== CHAT
function getTime()
{
    var current_date = new Date();
    var hours = current_date.getHours();
    var minutes = current_date.getMinutes();

    if(minutes <= 9){
        minutes = "0"+minutes;
    }
    if(hours <= 9){
        hours = "0"+hours;
    }
    return hours+":"+minutes;
}

function sentMessage()
{
    var message = $('#message_area').val();
    session.signal({
        type: 'chat_message',
        data: {
            name: "Operador BrasilTelemedicina",
            message: message
        }
    });
    $('#message_area').val('');
}

function writeGuestMessageInScreen(data)
{
    console.log('received', data);
    var item = '<div class="incoming_msg">'+
                    '<div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>'+
                    '<div class="received_msg">'+
                        '<div class="received_withd_msg">'+
                            '<p>'+data.message+'</p>'+
                            '<span class="time_date"> '+getTime()+'</span>'+
                        '</div>'+
                    '</div>'+
                '</div>';
    $('#msg_history').append(item);
    $('#msg_history').stop().animate({
        scrollTop: $('#msg_history')[0].scrollHeight
    }, 800);
    

}

function writeMineMessageInScreen(data)
{
    var item = '<div class="outgoing_msg">'+
                    '<div class="sent_msg">'+
                        '<p>'+data.message+'</p>'+
                        '<span class="time_date">'+getTime()+'</span> '+
                    '</div>'+
                '</div>';
    $('#msg_history').append(item);
    $('#msg_history').stop().animate({
        scrollTop: $('#msg_history')[0].scrollHeight
    }, 800);

}

function startChatSession(chat_key, chat_session, chat_token)
{
    chatSession = OT.initSession(chat_key, chat_session, chat_token);
    chatSession.connect(chat_token, function(error){
        if(error) {
            console.log("Não foi possível conectar o chat!");
        }
        console.log("Conectado com sucesso aos servidores do opentok (CHAT)");
        console.log(chat_session);
        startListeners();
        setInterval(function(){
            chatSession.signal({
                type: 'online_check'
            });
            qtdChatTry++;
            if (qtdChatTry >= 2) {
                setGuestStatus(false);
            }
        }, 3000);
    })
}

function startListeners()
{
    console.log("START_LISTENERS_CHAT");
    session.on('signal:chat_message', function(event){
        if (event.from.connectionId === session.connection.connectionId) {
            writeMineMessageInScreen(event.data);
        } else {
            writeGuestMessageInScreen(event.data);
        }
    });

    session.on('signal:online_check', function(event){
        if (event.from.connectionId !== session.connection.connectionId) {
            setGuestStatus(true);
        }
    });

}

function getChatSessionInformation()
{
    $.ajax({
        type: 'POST',
        url: Routing.generate('tokbox_chat_information'),
        data: {
            'appointmentId': $('#appointmentId').val()
        },
        success: function(data) {
            if(data.notification == 'success'){
                console.log("Conectando aos Servidores do Opentok (CHAT)");
                startChatSession(data.chat_key, data.chat_session, data.chat_token);
            }
        },
        error: function(data) {
            console.log("Houve um problema para iniciar o chat")
        }
    });
}

function setGuestStatus(status)
{
    if (status == true) {
        $('#guest_status').prop('class', 'font-green-jungle sbold');
        $('#guest_status').html('ONLINE');
        qtdChatTry = 0;
        $('#sent_message').prop('disabled', false);
    } else {
        $('#guest_status').prop('class', 'font-red-thunderbird sbold');
        $('#guest_status').html('OFFLINE');
        $('#sent_message').prop('disabled', true);
    }
}



/**
 * This function starts always the document (page) is loaded
 */
$(document).ready(function() {
    // Block all buttons until opentok is connected
    checkUrlToBlockAllButtons();

    // Define call sound
    soundManager.setup({
        onready: function() {
            ringingSound = soundManager.createSound({
                id: 'aSound',
                loops: 5,
                url: '/assets/tokbox/ring-2.mp3',
            });
        },
        ontimeout: function() {
            console.log(ringingSound);
        }
    });

    // Start self Session
    getSelfOpentokInformation();

    $('#sent_message').prop('disabled', true);
    // getChatSessionInformation();
    $("#sent_message").on("click", function(){
        sentMessage();
    })
    $("#message_area").on('keyup', function(event){
        event.preventDefault();
        if (event.keyCode === 13)
            sentMessage();
    });
    $('#clear_history').click(function() {
        $('#messages').empty();
        scrollingPos = 300;
    });
    $('#clear_text').click(function(){
        $('#message_area').val('');
    });

    
});
