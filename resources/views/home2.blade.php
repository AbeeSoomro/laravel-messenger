@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app" style="min-height: 400px; overflow-y:auto;">
                <div id="plist" class="people-list">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <ul class="list-unstyled chat-list mt-2 mb-0">
                        {{-- <li class="clearfix">
                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                            <div class="about">
                                <div class="name">Vincent Porter</div>
                                <div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>                                            
                            </div>
                        </li> --}}
                        @foreach ($users as $user)
                            <li class="clearfix username" data-name={{$user->name}} data-id={{$user->id}}>
                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                <div class="about">
                                    <div class="name">{{$user->name}}</div>
                                    @if(Cache::has('is_online' . $user->id))
                                        <div class="status"> <i class="fa fa-circle online"></i> online </div>
                                    @else
                                        <div class="status"> <i class="fa fa-circle offline"></i> offline </div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                        {{-- <li class="clearfix">
                            <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="avatar">
                            <div class="about">
                                <div class="name">Mike Thomas</div>
                                <div class="status"> <i class="fa fa-circle online"></i> online </div>
                            </div>
                        </li>                                    
                        <li class="clearfix">
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                            <div class="about">
                                <div class="name">Christian Kelly</div>
                                <div class="status"> <i class="fa fa-circle offline"></i> left 10 hours ago </div>
                            </div>
                        </li>
                        <li class="clearfix">
                            <img src="https://bootdey.com/img/Content/avatar/avatar8.png" alt="avatar">
                            <div class="about">
                                <div class="name">Monica Ward</div>
                                <div class="status"> <i class="fa fa-circle online"></i> online </div>
                            </div>
                        </li>
                        <li class="clearfix">
                            <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="avatar">
                            <div class="about">
                                <div class="name">Dean Henry</div>
                                <div class="status"> <i class="fa fa-circle offline"></i> offline since Oct 28 </div>
                            </div>
                        </li> --}}
                    </ul>
                </div>
                <div class="chat">
                    <div class="chat-header clearfix">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                </a>
                                <div class="chat-about">
                                    <h6 class="m-b-0 chatwith">Aiden Chavez</h6>
                                    <small id="lastSeen">Last seen: 2 hours ago</small>
                                </div>
                            </div>
                            <div class="col-lg-6 hidden-sm text-right">
                                <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="chat-history" style="height: 500px; overflow-y:auto;">
                        <ul class="m-b-0 mychatwithuser">
                            {{-- <li class="clearfix">
                                <div class="message-data text-right">
                                    <span class="message-data-time">10:10 AM, Today</span>
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                                </div>
                                <div class="message other-message float-right"> Hi Aiden, how are you? How is the project coming along? </div>
                            </li>
                            <li class="clearfix">
                                <div class="message-data">
                                    <span class="message-data-time">10:12 AM, Today</span>
                                </div>
                                <div class="message my-message">Are we meeting today?</div>                                    
                            </li>                               
                            <li class="clearfix">
                                <div class="message-data">
                                    <span class="message-data-time">10:15 AM, Today</span>
                                </div>
                                <div class="message my-message">Project has been already finished and I have results to show you.</div>
                            </li> --}}
                        </ul>
                    </div>
                    <div class="welcome-default pt-5" style="min-height: 500px; overflow-y:auto;">
                        <div class="h3 text-center font-weight-bold text-info">
                            WELCOME TO MEODOW MESSENGER
                        </div>
                        <div class="h5 text-center">
                            Select any user to start chatting
                        </div>
                    </div>
                    <div class="chat-message clearfix">
                        <div class="input-group mb-0">
                            <input type="text" class="form-control mymessage" placeholder="Enter text here..."> 
                            <div class="input-group-prepend">
                                <span style="cursor: pointer" class="input-group-text send"><i class="fa fa-send"></i></span>
                            </div>                                   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
            $('.chat-header').hide();
            $('.chat-history').hide();
            $('.chat-message').hide();
        Echo.channel('sendmessage')
            .listen('NewMessage', (e) => {
                var addmessage = '';
                if(e.sender_id == {{(Auth::id())}})
                {
                    addmessage += '<li class="clearfix">'+
                        '    <div class="message-data text-right">'+
                        '        <span class="message-data-time">'+moment().format('LT')+', '+moment().format('MMM D,YY')+'</span>'+
                        '    </div>'+
                        '    <div class="message other-message float-right">'+e.message+'</div>'+                                    
                        '</li>';  
                }
                else if(e.reciever_id == {{(Auth::id())}})
                {
                    addmessage += '<li class="clearfix">'+
                        '    <div class="message-data">'+
                        '        <span class="message-data-time">'+moment().format('LT')+', '+moment().format('MMM D,YY')+'</span>'+
                        '    </div>'+
                        '    <div class="message my-message">'+e.message+'</div>'+                                    
                        '</li>';  
                }
                $(".mychatwithuser").append(addmessage);
                $('.chat-history').scrollTop($('.mychatwithuser').height());
            })
        var chatID = 0;
        // THE FUNCTION WiLL LOAD ALL THE MESSAGES ACCORDING TO CHAT ID - USER ID
        ///////////////////////////////////////////////////////////////////////////////
        function loadMessages(id)
        {
            var html = '';
            var mydata= {};
            mydata['sender_id'] = {{ Auth::id() }};
            mydata['reciever_id'] = id;
            // console.log($data);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'http://127.0.0.1:8000/api/lastSeenTime',
                type: 'POST',
                data:mydata,
                success:function(res){
                    //console.log(res);
                    var lastseen = "Last seen: "+res;
                    $('#lastSeen').html('');
                    $('#lastSeen').html(lastseen);
                }
            });
            $.ajax({
                url: 'http://127.0.0.1:8000/api/getmessages',
                type: 'POST',
                data:mydata,
                success:function(res){
                    //console.log(res);
                    if(res.length == 0)
                    {
                        html += '<div class="py-2 text-center font-weight-bold"> No messages found</div>';
                        //alert('No Data Found');
                    }
                    $.each(res, function(key,value){
                        if(value.sender_id == {{(Auth::id())}})
                        {
                            html += '<li class="clearfix">'+
                                '    <div class="message-data text-right">'+
                                '        <span class="message-data-time">'+moment(value.created_at).format('LT')+', '+moment(value.created_at).format('MMM D,YY')+'</span>'+
                                '    </div>'+
                                '    <div class="message other-message float-right">'+value.message+'</div>'+                                    
                                '</li>';  
                        }
                        else if(value.reciever_id == {{(Auth::id())}})
                        {
                            html += '<li class="clearfix">'+
                                '    <div class="message-data">'+
                                '        <span class="message-data-time">'+moment(value.created_at).format('LT')+', '+moment(value.created_at).format('MMM D,YY')+'</span>'+
                                '    </div>'+
                                '    <div class="message my-message">'+value.message+'</div>'+                                    
                                '</li>';  
                        }
                    });
                    $('.mychatwithuser').html(html);
                    $('.chat-history').scrollTop($('.mychatwithuser').height());
                }
            });
        }
        // THE FUNCTION WiLL OPEN UP CHAT ACCORDING TO USER
        ///////////////////////////////////////////////////////////////////////////////
        $(this).on('click','.username', function(){
            $('.chat-header').show();
            $('.chat-history').show();
            $('.chat-message').show();
            $('.welcome-default').hide();
            $('.chatwith').html($(this).data("name"));
            var chatWithId = $(this).data("id");
           
            chatID = chatWithId;
            loadMessages(chatWithId);
        });

        // THE FUNCTION WILL SEND THE NEW MESSAGE TO SELECTED USER
        ///////////////////////////////////////////////////////////////////////////////
        $('.send').on('click', function(){
            var mydata= {};
            mydata['sender_id'] = {{ Auth::id() }};
            mydata['reciever_id'] = chatID;
            mydata['message'] = $('.mymessage').val();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'http://127.0.0.1:8000/api/message',
                type: 'POST',
                data:mydata,
                success:function(res){
                    $('.mymessage').val('');
                }
            });
        });

        $('.mymessage').keypress(function(e){
            if(e.key == "Enter")
            {
                var mydata= {};
                mydata['sender_id'] = {{ Auth::id() }};
                mydata['reciever_id'] = chatID;
                mydata['message'] = $('.mymessage').val();
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: 'http://127.0.0.1:8000/api/message',
                    type: 'POST',
                    data:mydata,
                    success:function(res){
                        $('.mymessage').val('');
                    }
                });
            }
        });
        
    });
</script>
@endsection
