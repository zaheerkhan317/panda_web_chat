@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!--- chat list sectoion -->
        <div id="chat-list" class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Chat list</div>
                <div id="chat-body" class="panel-body">
                    @include("layouts.chat_list")
                </div>
            </div>
        </div>
        <!--- chat list section end --->

        <!--- message section --->
        <div id="msg-list" class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Conversation</div>
                <div id="msg-body" class="panel-body" >
                    <!--- <div class="no-chat">No Chat Selected</div> --->
                    @include("layouts.msg_list")
                    
                </div>
                <div class="panel-footer">
                    <div class="panel-dragged-msg"></div>
                    <div class="row" id="msg-controls">
                    <form id="create-msg-form" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                            <fieldset class="form-group">
                                <textarea name="msg" id="msg" class="form-control" placeholder="Write your Message....."></textarea>
                                @include("emoji")
                                <div id="typing_on"></div>
                                <input type="hidden" name="chat_id" id="chat-id" value="">
                            </fieldset>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <fieldset class="form-group">
                                <label for="attachment" class="btn btn-default btn-block">
                                    <i class="fa fa-paperclip" aria-hidden="true"></i>
                                    <input type="file" name="attachment" id="attachment" style="display: none;">
                                </label>
                            </fieldset>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <fieldset class="form-group">
                                <input disabled value="Send" class="btn btn-primary btn-block" type="button" name="sub" id="create-msg">
                            </fieldset>
                        </div>
                    </form>
                    <div id="attachment-preview" style="display: none;">
                        <img id="attachment-preview-img" src="" alt="Attachment Preview" style="display: block; margin: 0 auto; height: 100px; width: 100px;" />
                        <video id="attachment-preview-video" src="" alt="Attachment Video Preview" style="display: none; margin: 0 auto; height: 250px; width: 250px;" controls></video>
                        <img id="attachment-preview-document" src="{{ asset('img/pdf-icon.png') }}" style="margin: 0 auto; display: block; height: 100px; width: 100px; border: 1px solid #ccc; ">


                        <div id="attachment-img-name" style="text-align: center;"></div> <!-- This will display the image name -->
                    </div>

                    
                    
                    </div>
                </div>
            </div>
        </div>




                
        
    </div>
</div>




@endsection