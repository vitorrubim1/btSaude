/* global OT API_KEY TOKEN SESSION_ID SAMPLE_SERVER_BASE_URL */

var SAMPLE_SERVER_BASE_URL = 'https://app.monitorasaude.com.br/';

var API_KEY = '45190622';
var SESSION_ID;
var TOKEN;

var apiKey;
var sessionId;
var token;
var ringingSound;

function handleError(error) {
  if (error) {
    console.error(error);
  }
}

function initializeSession() {
  var session = OT.initSession(apiKey, sessionId);

  // Subscribe to a newly created stream
  session.on('streamCreated', function streamCreated(event) {
    var subscriberOptions = {
      insertMode: 'append',
      width: '50%',
      height: '50%'
    };
    session.subscribe(event.stream, 'subscriber', subscriberOptions, handleError);
  });

  session.on('sessionDisconnected', function sessionDisconnected(event) {
    console.log('You were disconnected from the session.', event.reason);
  });

  // initialize the publisher
  var publisherOptions = {
    insertMode: 'append',
    width: '100%',
    height: '100%'
  };
  $("#videos").show();
  var publisher = OT.initPublisher('publisher', publisherOptions, handleError);

  // Connect to the session
  session.connect(token, function callback(error) {
    if (error) {
      handleError(error);
    } else {
      // If the connection is successful, publish the publisher to the session
      session.publish(publisher, handleError);
    }
  });
}
function getSelfOpentokInformation() {    
    apiKey = API_KEY;
    sessionId = $("#ot_sessionId").val();
    token = $("#ot_token").val();
    initializeSession();    
}
$(document).ready(function(){
    
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


    $("#button_accept_call").on('click', function(){
        apiKey = API_KEY;
        sessionId = $("#ot_session_id_doctor").val();
        token = $("#ot_token_doctor").val();
        $('#videos').show();
        initializeSession();
    });
    $('#btn_start_call').on('click', function(){
        ringingSound.stop();
        $('#btn_start_call').hide();
    });

    $('.quitCall').click(function(){
        window.location = window.location.href.split('?')[0];
    });
    // Stoping call with patient
    $('.closeCall').click(function(){

        window.location = window.location.href.split('?')[0];

        // $.ajax({
        //     type: "POST",
        //     url: opentokEndCallURL,
        //     headers: {
        //         'X-CSRF-TOKEN': csrfToken
        //     },
        //     data: {
        //         'userId': userId,
        //     },
        //     dataType: "json",
        //     success: function(data) {
        //         console.log("Chamada encerrada!");
        //         disconnected();
        //         clearVariables();
        //         clearInterval(counter);
        //         timeout = constTimeout;
        //         $('#videos').hide();
        //         stopCalling = false;
        //         window.location = window.location.href.split('?')[0];
        //     },
        //     error: function(data){
        //         console.log("Houve um erro ao salvar os dados da chamada.");
        //         disconnected();
        //         clearVariables();
        //         clearInterval(counter);
        //         timeout = constTimeout;
        //         $('#videos').hide();
        //         stopCalling = false;
        //         window.location = window.location.href.split('?')[0];
        //     },
        // });
    });
    
});
// See the config.js file.
// if (API_KEY && TOKEN && SESSION_ID) {
//   apiKey = API_KEY;
//   sessionId = SESSION_ID;
//   token = TOKEN;
//   initializeSession();
// } else if (SAMPLE_SERVER_BASE_URL) {
//   // Make an Ajax request to get the OpenTok API key, session ID, and token from the server
//   fetch(SAMPLE_SERVER_BASE_URL + '/session').then(function fetch(res) {
//     return res.json();
//   }).then(function fetchJson(json) {
//     apiKey = json.apiKey;
//     sessionId = json.sessionId;
//     token = json.token;

//     initializeSession();
//   }).catch(function catchErr(error) {
//     handleError(error);
//     alert('Failed to get opentok sessionId and token. Make sure you have updated the config.js file.');
//   });
// }
