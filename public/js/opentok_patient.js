+/**
 * OPENTOK - APPLICATION (PATIENT)
 */

var opentok_key;
var opentok_session_id;
var opentok_token;
var session;
var userId;
var userName;
var userType = "PATIENT";
var userTypeDoctor = "QUEUE";
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

/**
 * This function waiting some time before stop calling
 */
function timer() {
    timeout = timeout -1;
    console.log("Aguardando Ligação - "+timeout+"s para Timeout...");
    if (timeout <= 0) {
        clearInterval(counter);
        $('#modalStartingCallTitle').html("<strong>A ligação não foi atendida!</strong>");
        $('#modalStartingCallText').html("O(A) médico(a) não respondeu a sua solicitação de ligação. Por favor, tente novamente!");
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
    $('#callDoctor').click(function(){   
        $("#type_call").val(2);     
        if (isCalling == false) {
            $("#msg_empty_operator").hide();
            disconnected();
            clearVariables();
            isCalling = true;

            $('#modalStartingCallTitle').html("Iniciando Ligação...");
            $('#modalStartingCallText').html("Por favor <strong> aguarde! </strong>, Estamos completando a sua ligação...");
            $('#buttonOkModalStartingCall').hide();
            $('#modal-startingCalling').modal('show');

            console.log('Você foi desconectado com sucesso!');
            console.log('Obtendo informações de sessão do paciente');
            getDoctorOpentokInformation();
            $('#videos').show();
            $('#EndCall').show();
        }        
    
    });

    $('#callChat').click(function(){   
        $("#type_call").val(1);     
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
            getDoctorOpentokInformation();
            $('#chat_operator').show();
            $('#EndCall').show();
        }        
    
    });

    // Stoping call with patient
    $('#closeCall').click(function(){
        stopCalling = true;
        // Sent signal
        session.signal({
            type: 'stopCall',
            data: {
                userName: userName,
                appointmentDate: $('#appointmentDate').val()
            }
        });
        disconnected();
        clearVariables();
        clearInterval(counter);
        timeout = constTimeout;
        $('#videos').hide();
        stopCalling = false;
        window.location = window.location.href.split('?')[0];
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
            width: '100%',
            height: '100%'
        };
        session.subscribe(event.stream, 'subscriber', subscriberOptions, handleError);
    });

    // Event when psicologist call patient
    session.on('signal:callPatient', function(event){
        if (receivingCalling == false) {
            receivingCalling = true;
            $('#modalCallTitle').html("Recebendo Ligação do(a) Médico(a) "+event.data.userName);
            $('#modalCallDate').html(event.data.appointmentDate);
            $('#modal-call').modal('show');
            ringingSound.play();

            // Accepts call button is clicked
            $('#buttonAcceptsCall').click(function(){
                ringingSound.stop();
                $('#modal-call').modal('hide');
                url = Routing.generate('appointment_start_session', {code: event.data.appointmentId});
                current_url = window.location.href;

                if (current_url.indexOf(url) != -1) {
                    $('#videos').show();
                    disabledCallButton();
                    // Sent Accepts Signal
                    session.signal({
                        type: 'answerCall',
                        data: {
                            answer: 'ACCEPT',
                            userName: userName
                        }
                    });
                } else {
                    window.location.href = Routing.generate('appointment_start_session', {
                        code: event.data.appointmentId,
                        call: "true"
                    });
                }
            });

            // Reject call button is clicked
            $('#buttonRejectCall').click(function(){
                receivingCalling = false;
                ringingSound.stop();
                $('#modal-call').modal('hide');
                url = Routing.generate('appointment_start_session', {code: event.data.appointmentId});
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
            console.log('O(A) psicólogo(a) '+event.data.userName+' encerrou a ligação!');
            disconnected();
            clearVariables();
            $('#videos').hide();
            window.location = window.location.href.split('?')[0];
        }
    });

    // Event when Patient answer call from Doctor
    session.on('signal:answerCall', function(event){
        // Accepts call
        if (event.data.answer == 'ACCEPT') {
            clearInterval(counter);
            timeout = constTimeout;
            if (publisher == null) {
                if($("#type_call").val() == 1){
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
            }else{}
            clearInterval(counterConnection);
            ringingSound.stop();
            disabledCallButton();
            $('#modal-startingCalling').modal('hide');
        } else {
            clearInterval(counter);
            timeout = constTimeout;
            $('#modalStartingCallTitle').html("Ligação <spam class='red sbold'> Cancelada! </spam>");
            $('#modalStartingCallText').html("O(A) Psicólogo(a) <strong>"+event.data.userName+"</strong> recusou a sua ligação");
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
                console.log('Não foi possível conectar nos servidores do Opentok: '+ error.message);
                return;
            }
            if (isCalling == true) {
                // Sent signal
                session.signal({
                    type: 'callDoctor',
                    data: {
                        userName: userName,
                        userId: patientId,
                        patient_id: patientId,
                        call_type: $("#type_call").val()
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
            $("#box-opentok").css('display','flex');
            $("#loader").hide();
        });
    }
}


/**
 * This function get from server the Opentok users information and start the session with Opentok servers
 */
function getSelfOpentokInformation() {
    console.log('getSelfOpentokInformation');
    console.log(opentokUserInformationURL);
    $.ajax({
        type: "POST",
        url: opentokUserInformationURL,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            UserType: userType,
            patientId: patientId
        },
        success: function(data){
            console.log("data ---> ",data);
            userId = data.userId;
            userName = data.userName;
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
                    console.log("data opentok -->",data);
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
            console.log("Não foi possível obter as informações do usuário autenticado!");
        },
        dataType: "json"
    });
}

/**
 * This function get Other users Opentok information
 * @param id
 */
function getDoctorOpentokInformation() {
    $.ajax({
        type: "POST",
        url: opentokInformationURL,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            'UserType': userTypeDoctor
        },
        success: function(data) {
            console.log("Informações do Opentok obtidas com sucesso do servidor!");
            opentok_key = data.api_key;
            opentok_session_id = data.session_id;
            opentok_token = data.token;
            startOpenTokSession();
        },
        error: function(data) {            
            console.log("Houve um erro ao obter as informações do Opentok");
            $("#msg_empty_operator").show();
            $('#videos').hide();
            $('#EndCall').hide();
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
    $('#callDoctor').prop('disabled', false);
    $('#closeCall').prop('disabled', true);
}

/**
 * This function block MakeCall and release CloseCall
 */
function disabledCallButton() {
    $('#callDoctor').prop('disabled', true);
    $('#closeCall').prop('disabled', false);
}

/**
 * This function block all buttons
 */
function blockAllCallButtons() {
    $('#callDoctor').prop('disabled', true);
    $('#closeCall').prop('disabled', true);
}

/**
 * This function checks if page is the call page and enables call buttons
 */
function checkUrlToEnableButtons() {
    url = demoRoute;
    current_url = window.location.href;
    if (current_url.indexOf(url) != -1) {
        enabledCallButton();
    }
}

/**
 * This function checks if page is the call page and block all call buttons
 */
function checkUrlToBlockAllButtons() {
    console.log('checkUrlToBlockAllButtons');
    url = demoRoute;
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
    url = demoRoute;
    current_url = window.location.href;
    if (current_url.indexOf(url) != -1) {
        if (param == "true") {
            console.log('ENTREI AKI!');
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
            name: "Paciente",
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
