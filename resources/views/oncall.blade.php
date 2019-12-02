@extends('layouts.app')
@section('content')
<style>
    #publisher{
        position:relative; left: 0; top: 0; width: 100%; height: 300px; z-index: 10;
    }
    @media (max-width : 768px) {
        #publisher{
            position:relative; left: 0; top: 0; width: 30%; height: 100px; z-index: 10;
        }
    }
    #box-opentok{
        display: none;
    }    
</style>
<style>
        .container{max-width:1170px; margin:auto;}
        img{ max-width:100%;}
        .inbox_people {
          background: #f8f8f8 none repeat scroll 0 0;
          float: left;
          overflow: hidden;
          width: 40%; border-right:1px solid #c4c4c4;
        }
        .inbox_msg {
          border: 1px solid #c4c4c4;
          clear: both;
          overflow: hidden;
        }
        .top_spac{ margin: 20px 0 0;}
        
        
        .recent_heading {float: left; width:40%;}
        .srch_bar {
          display: inline-block;
          text-align: right;
          width: 60%; padding:
        }
        .headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}
        
        .recent_heading h4 {
          color: #05728f;
          font-size: 21px;
          margin: auto;
        }
        .srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
        .srch_bar .input-group-addon button {
          background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
          border: medium none;
          padding: 0;
          color: #707070;
          font-size: 18px;
        }
        .srch_bar .input-group-addon { margin: 0 0 0 -27px;}
        
        .chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
        .chat_ib h5 span{ font-size:13px; float:right;}
        .chat_ib p{ font-size:14px; color:#989898; margin:auto}
        .chat_img {
          float: left;
          width: 11%;
        }
        .chat_ib {
          float: left;
          padding: 0 0 0 15px;
          width: 88%;
        }
        
        .chat_people{ overflow:hidden; clear:both;}
        .chat_list {
          border-bottom: 1px solid #c4c4c4;
          margin: 0;
          padding: 18px 16px 10px;
        }
        .inbox_chat { height: 550px; overflow-y: scroll;}
        
        .active_chat{ background:#ebebeb;}
        
        .incoming_msg_img {
          display: inline-block;
          width: 6%;
        }
        .received_msg {
          display: inline-block;
          padding: 0 0 0 10px;
          vertical-align: top;
          width: 92%;
         }
         .received_withd_msg p {
          background: #ebebeb none repeat scroll 0 0;
          border-radius: 3px;
          color: #646464;
          font-size: 14px;
          margin: 0;
          padding: 5px 10px 5px 12px;
          width: 100%;
        }
        .time_date {
          color: #747474;
          display: block;
          font-size: 12px;
          margin: 8px 0 0;
        }
        .received_withd_msg { width: 57%;}
        .mesgs {
          float: left;
          padding: 30px 15px 0 25px;
          width: 100%;
        }
        
         .sent_msg p {
          background: #05728f none repeat scroll 0 0;
          border-radius: 3px;
          font-size: 14px;
          margin: 0; color:#fff;
          padding: 5px 10px 5px 12px;
          width:100%;
        }
        .outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
        .sent_msg {
          float: right;
          width: 46%;
        }
        .input_msg_write input {
          background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
          border: medium none;
          color: #4c4c4c;
          font-size: 15px;
          min-height: 48px;
          width: 100%;
        }
        
        .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
        .msg_send_btn {
          background: #05728f none repeat scroll 0 0;
          border: medium none;
          border-radius: 50%;
          color: #fff;
          cursor: pointer;
          font-size: 17px;
          height: 33px;
          position: absolute;
          right: 0;
          top: 11px;
          width: 33px;
        }
        .messaging { padding: 0 0 50px 0;}
        .msg_history {
          height: 516px;
          overflow-y: auto;
        }    
        #status_ocupado, #status_pausa{
            display: none;
        }
        </style>
<div class="row col-md-12">
    <input type="hidden" id="ot_session_id_doctor" value="" />
    <input type="hidden" id="ot_token_doctor" value="" />
    <button class="btn btn-primary col-md-12" id="button_accept_call" style="margin-bottom: 40px">
        <i class="far fa-3x fa-thumbs-up"></i> 
        <h3>Aceitar Chamada</h3>
    </button>
    <button class="btn btn-danger col-md-12" id="button_decline_call">
        <i class="far fa-3x fa-thumbs-down"></i> 
        <h3>Recusar Chamada</h3>
    </button>
    {{-- <div class="col-md-12" id="msg_empty_operator" style="margin-top: 50px;">
        <div class="card" style="width: 100%;">  
            <div class="card-body">
                <div class="alert alert-primary alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Aguarde!</strong> Em instantes você será chamado por um de nossos médicos.
                </div>        
            </div>
        </div>
    </div>    --}}

    <div class="col-md-9">
        <div id="videos" class="row" style="height: 750px; display: none;">
            <div class="col-md-10">
                <div id="subscriber" style="position:absolute; left: 0; top: 0; width: 100%; height: 650px; z-index: 10; "></div>
                </div>
                <div class="col-md-2">
                <div id="publisher" style="position:relative; left: 0; top: 0; width: 100%; height: 100px; z-index: 10; "></div>
            </div>
        </div>        
    </div>
    <div class="col-md-3">
        
    </div>    
</div>


<div class="col-sm-12">
    <div class="row">
        <div id="videos" class="portlet-body" style="height: 450px; display: none;">
            <div class="col-md-8">
                <div id="subscriber" style="position:absolute; left: 0; top: 0; width: 100%; height: 430px; z-index: 10; "></div>
                </div>
                <div class="col-md-4">
                <div id="publisher"></div>
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button class="btn btn-info btn-lg" id="EndCall" onClick="window.location.reload()" style="width: 100%; margin-bottom: 20px; display: none">Finalizar Chamada</button>
        </div>
        <!-- <div class="col-lg-12 text-center">
            <button class="btn btn-danger btn-lg" id="callDoctor" style="width: 100%">
                <i class="fas fa-video"></i> Ativar Chamada de Pânico
            </button>
        </div> -->
        {{-- <div class="col-md-12 text-center" id="loader">
        <img src="{{url('images/loader.svg')}}" style="margin: 0 auto; display: block" alt="">
        <h4>Aguarde...</h4>
        </div> --}}
        <input type="hidden" id="type_call" />
        <div class="row col-md-12" style="margin-top: 20px" id="box-opentok">
            {{-- <div class="col-md-6">
                <div class="card" style="width: 100%;">  
                    <div class="card-body">
                        <h5 class="card-title text-center"><i class="fas fa-4x fa-comments"></i></h5>    
                        <a href="#" class="btn btn-primary col-md-12" id="callChat">Iniciar Chat</a>
                    </div>
                </div>            
            </div> --}}
            {{-- <div class="col-md-6">
                <div class="card" style="width: 100%;">  
                    <div class="card-body">
                        <a id="callChat" style="color: #fff" class="btn btn-primary col-md-12">
                            <h5 class="card-title text-center"><i class="fas fa-4x fa-video"></i></h5>    
                            <h3>Iniciar Chat</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="width: 100%;">  
                    <div class="card-body">
                        <a id="callDoctor" style="color: #fff" class="btn btn-primary col-md-12">
                            <h5 class="card-title text-center"><i class="fas fa-4x fa-video"></i></h5>    
                            <h3>Iniciar Vídeo</h3>
                        </a>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>

<div class="row" id="chat_operator" style="display: none">
        <div class="container">
            <h3 class=" text-center">CHAT</h3>
            <div class="messaging">
                <div class="inbox_msg">
                    <div class="mesgs">
                        <div class="msg_history" id="msg_history"></div>
                        <div class="type_msg">
                            <div class="input_msg_write">
                                <input type="text" class="write_msg" id="message_area" placeholder="Digite uma mensagem" />
                                <button class="msg_send_btn" id="sent_message" type="button"><i class="fas fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('myscript')
<script>
    var patientId = {{Auth::user()->id}};
</script>
<script src="{{ asset("js/opentokpatient.js") }}" type="text/javascript"></script>
@stop