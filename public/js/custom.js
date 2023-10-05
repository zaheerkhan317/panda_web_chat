/* modified code */
var load_no = 20;
var no_more = false;
jQuery(document).ready(function($) {
    deselectall();

    $("#pic_btn").click(function(){
        $("#pic_file").click();
    });

    $("#pic_file").change(function(){
        $("#pic_submit").click();
    });

    $("#msg-body").on("scroll", function(){
        var scrollTop = $(this).scrollTop();
        if (scrollTop <= 0 && no_more == false) {
            $(this).prepend("<div id='load_more'>Load more</div>");
        }else{
            $(this).find("#load_more").remove();
        }
    });

    

    $("body").on("click", "#load_more", function(){
        var c_id = $("#chat-id").val();
        var tk = $("#create-msg-form").find("input[name=_token]").val();
        var el = $("#"+ c_id);
        msg_load(c_id,tk, load_no, false, el);
    });

    $(".selectpicker").change(function() {
      var selectedOptions = $(this).val();
      if (selectedOptions && selectedOptions.length > 0) {
        $("#create").prop("disabled", false);
      } else {
        $("#create").prop("disabled", true);
      }
    });

    $('.selectpicker').selectpicker({
        style: "btn-info",
        size: 4
    });


    $("body").on("click","#create",function(){
        var bt = $(this);
        bt.empty().html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
        var tk = $("#create-form").find('input[name=_token]').val();
        var users = $("#create-data").val();

        $.ajax({
            method: "POST",
            url: "chat",
            data: {
                'users': users,
                '_token': tk,
            }
        }).done(function(resp){

            try{
                resp = $.parseJSON(resp); 
            }catch(e){
                window.location = "/chat/public/login";
            }
            
            deselectall();
            if(resp.status == 1) {
                $(".create-chat-status").removeClass("alert alert-danger").addClass("alert alert-success").text(resp.txt);
                bt.empty().text("Create");
                bt.prop("disabled", true);
                setTimeout(function(){
                    chat_list();
                    $("#myModal").modal('hide');
                }, 2000);
            }else if (resp.status == 0){
                
                $(".create-chat-status").removeClass("alert alert-success").addClass("alert alert-danger").text(resp.txt);
                bt.empty().text("Create");
                bt.prop("disabled", true);
                
            }
        }).fail(function(jqXHR){
            if(jqXHR.status == 422){
                $(".create-chat-status").removeClass("alret alert-success").addClass("alert alert-danger").text("Select at least one user");
            }else{
                $(".create-chat-status").removeClass("alret alert-success").addClass("alert alert-danger").text("Something went wrong");
            }
            bt.empty().text('Create');
            bt.prop('disabled');
        });
    });

    $("body").on("click",".chat-item",function(){
        $(this).addClass("chat-select").siblings().removeClass("chat-select");
        var c_id = $(this).attr("id");
        var tk = $("#create-msg-form").data("token"); 
        $("#create-msg-form #chat-id").val(c_id);
        var el = $(this);
        msg_load(c_id, tk, 10, true, el);
    });
    


    $("body").on("click","#create-msg",function(){
        var bt = $(this);
        var tf = $("#msg");
        var attachmentInput = $("#attachment");
        var attachmentPreview = $("#attachment-preview"); // Added to hide the attachment preview
        var panelDraggedMsg = document.querySelector('.panel-dragged-msg');
        var draggedMessage = $(panelDraggedMsg).find('.msg-item-msg').html();
            if (typeof draggedMessage !== 'undefined') {
                draggedMessage = draggedMessage.trim();
            }
        bt.prop('disabled',true).html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
        var tk = $("#create-msg-form").find('input[name=_token]').val();
        var msg = $("#msg").val();
        var c_id = $("#chat-id").val();
        

        var formData = new FormData();
        formData.append('msg', msg);
        formData.append('c_id', c_id);
        formData.append('_token', tk);
        formData.append('attachment', $('#attachment')[0].files[0]);
        if (draggedMessage) {
            formData.append('dragged_message', draggedMessage);
        }
    
        
        $.ajax({
            method: "POST",
            url: "message",
            data: formData,
            contentType: false, // Important: prevent jQuery from automatically setting the content type
            processData: false,
            headers: {
                'X-CSRF-TOKEN': tk // Set CSRF token in headers
        }
        }).done(function(resp){

            try{
                resp = $.parseJSON(resp); 
            }catch(e){
                window.location = "/chat/public/login";
                return;
            }
            
            if(resp.status == 1) {
                tf.val('');
                
                if(resp.fst == 0){
                    var fst =0;
                    
                }else{
                    var fst =1;
                }
                
                new_msg_load(c_id, tk, 1, fst);
                if (resp.obj.attachment) {
                    // Create an img element
                    var imgElement = $('<a>').attr('href', resp.obj.attachment).attr('data-lightbox', 'attachment').append($('<img>').attr('src', resp.obj.attachment).attr('alt', 'Attachment'));
                       
    
                    // Append the image to a container
                    $('#attachment-container').html(imgElement);
                }
                // Reset the file input to clear the selected file
                attachmentInput.val('');

                // Hide the attachment preview after sending
                attachmentPreview.css('display', 'none');
                // Close the dragged message panel
                closeDraggedMessage();
                // Display ticks for the sent message
            
            }else if (resp.status == 0){
                
                
            }
        }).fail(function(jqXHR){
            if(jqXHR.status == 422){
                $(".create-chat-status").removeClass("alert alert-success").addClass("alert alert-danger").text("Select at least one user");
            }else{
                $(".create-chat-status").removeClass("alert alert-success").addClass("alert alert-danger").text("Something went wrong");
            }
            bt.prop('disabled',false).html('Create');
            tf.val('').prop('disabled',true);
            
        });
    });

    function closeDraggedMessage() {
        const panelDraggedMsg = document.querySelector('.panel-dragged-msg');
        panelDraggedMsg.innerHTML = ''; // Clear the content
    }
    
    

    $("body").on("click", ".enlarge-image", function () {
        // Open the image in a new window or lightbox, for example:
        window.open($(this).attr('src'), '_blank');
    });

    

    var textarea = $("#msg");
    var typingStatus = $("#typing_on");
    var lastTypedTime = new Date(0);
    var typingDelayMillis = 4000;

    function refreshTypingStatus() {
        if ( !textarea.attr("disabled") && textarea.is(':focus')){
            if (textarea.val() == '' || new Date().getTime() - lastTypedTime.getTime() > typingDelayMillis){
                set_typing(0);
            }else{
                set_typing(1);
            }
        }
    }

    function updateLastTypedTime() {
        lastTypedTime = new Date();
    }

    setInterval(refreshTypingStatus, 2000);
    textarea.keypress(updateLastTypedTime);
    textarea.blur(function(){
        set_typing(0);
    });

    setInterval(new_msg_load, 5000);
    setInterval(chat_update, 1200);
    setInterval(check_typing, 1000);

});


var deselectall = function(){
    $(".selectpicker").selectpicker('deselectAll');
}

var chat_list = function() {
    $.ajax({
        method: "get",
        url: "chat-list",
        
    }).done(function(resp){
        try{
            resp = $.parseJSON(resp); 
        }catch(e){
            window.location = "/chat/public/login";
        }
        if(resp.status == 1) {
            $("#chat-body").empty().append(resp.txt);
        }
    }).fail(function(jqXHR){

    });
}


var msg_load = function(c_id=null, tk=null, limit=10, first=false, el=null){
    
    if(c_id == null || c_id == ''){
        var c_id = $("#chat-id").val();
    }

    if(tk == null || tk == ''){
        var tk = $("#create-msg-form").find('input[name=_token]').val();
    }

    if(c_id != null && c_id != ''){
        $.ajax({
            method: "post",
            url: "message-list",
            data: {
                'c_id': c_id,
                'limit': limit,
                '_token': tk,
            }
        }).done( function(resp){
            try{
                resp = $.parseJSON(resp); 
            }catch(e){
                window.location = "/chat/public/login";
            }
            if(resp.status == 1){

                
                if(first == false) {
                    $("#msg-body").prepend(resp.txt);
                    load_no = load_no +10;
                    if (resp.end == true) {
                        no_more = true;
                        $("#load_more").remove();
                    }else{
                        no_more = false;
                        $("#load_more").show();
                    }
                }else{
                    $("#msg-body").empty().html(resp.txt);
                    var objDiv = document.getElementById("msg-body");

                    if( (Math.ceil($("#msg-body").scrollTop() + $("#msg-body").innerHeight() ) ) >= objDiv.scrollHeight - 110 || first == true){
                        objDiv.scrollTop = objDiv.scrollHeight;
                    }
                }
                
                
                $("#create-msg-form").find("#msg").prop("disabled",false);
                $("#create-msg-form").find("#create-msg").prop("disabled",false);
                msg_seen(c_id, tk, el);
                make_active(c_id, tk, el);
            }
        }).fail(function(jqXHR){

        });
    }
    
}
 


var new_msg_load = function(c_id=null, tk=null, me=0, fst=0){
    
    if(c_id == null || c_id == ''){
        var c_id = $("#chat-id").val();
    }

    if(tk == null || tk == ''){
        var tk = $("#create-msg-form").find('input[name=_token]').val();
    }

    if(c_id != null && c_id != ''){
        $.ajax({
            method: "post",
            url: "new-message-list",
            data: {
                'c_id': c_id,
                'me': me,
                '_token': tk,
            }
        }).done( function(resp){
            try{
                resp = $.parseJSON(resp); 
            }catch(e){
                window.location = "/chat/public/login";
            }
            if(resp.status == 1){
                
                if(fst == 0){

                    $("#msg-body").append(resp.txt);
                }else{
                    $("#msg-body").html(resp.txt);
                }


                
                
                var objDiv = document.getElementById("msg-body");

                if( (Math.ceil($("#msg-body").scrollTop() + $("#msg-body").innerHeight() ) ) >= objDiv.scrollHeight - 110 || fst == 1){
                    objDiv.scrollTop = objDiv.scrollHeight;
                }
                $("#create-msg-form").find("#msg").prop("disabled",false);
                $("#create-msg-form").find("#create-msg").prop("disabled",false);
                msg_seen(c_id, tk);
                make_active(c_id,tk);
                
            }
        }).fail(function(jqXHR){

        });
    }
}


var msg_seen = function(c_id, tk, el=null){

    if (el = null) {
        el = $("#" + c_id);
    }

    $.ajax({
        method: "post",
        url: "message-seen",
        data: {
            'c_id': c_id,
            '_token': tk,
        }
    }).done( function(resp){
        try{
            resp = $.parseJSON(resp); 
        }catch(e){
            window.location = "/chat/public/login";
        }
        if(resp.status == 1){
            if (el != null){
                el.removeClass('new-msg');
                el.find(".new-msg-count").remove();
            }
        }
    }).fail(function(jqXHR){

    });
}

// Function to periodically check for updates and update UI
function checkForUpdates() {
    // Send an AJAX request to fetch updated 'seen' status
    // Modify the URL and data according to your application
    $.ajax({
        method: "get",
        url: "check-seen-updates",
        data: {
            // Add any required parameters
        }
    }).done(function (response) {
        // Update the UI based on the response
        // For simplicity, let's assume the response contains the message IDs that were seen
        var seenMessageIds = response.seenMessageIds;

        // Update the tick icons for seen messages
        seenMessageIds.forEach(function (messageId) {
            $('#msg-item-' + messageId).find('#tick-icon').removeClass('fa-check').addClass('fa-check-double');
        });
    }).fail(function (jqXHR) {
        console.error("Error checking for updates:", jqXHR);
    });
}

// Call the function every 5 seconds (5000 milliseconds)
setInterval(checkForUpdates, 7000);




var make_active = function(c_id, tk){
    if(c_id != null && c_id != '' && !$("#msg").attr('disabled')){
        $.ajax({
            method: "post",
            url: "active",
            data: {
                'c_id': c_id,
                '_token': tk,
            }
        }).done( function(resp){
            try{
                resp = $.parseJSON(resp); 
            }catch(e){
                window.location = "/chat/public/login";
            }
            if(resp.status == 1){
                
            }
        }).fail(function(jqXHR){
    
        });
    }
}


var set_typing = function(con) {
    var c_id = $("#chat-id").attr("id");
    var tk = $("#create-msg-form").find('input[name=_token]').val();
    if (c_id != null && c_id != '' && !$("#msg").attr("disabled")){
        $.ajax({
            method: "post",
            url: "set-active",
            data: {
                'con' : con,
                'c_id': c_id,
                '_token': tk,
            }
        }).done( function(resp){
            try{
                resp = $.parseJSON(resp); 
            }catch(e){
                window.location = "/chat/public/login";
            }
            if(resp.status == 1){
                
            }
        }).fail(function(jqXHR){
    
        });
    }
}



var check_typing = function(con) {
    var c_id = $("#chat-id").val();
    var tk = $("#create-msg-form").find('input[name=_token]').val();
    if (c_id != null && c_id != '' && !$("#msg").attr("disabled")){
        $.ajax({
            method: "post",
            url: "check-active",
            data: {
                'c_id': c_id,
                '_token': tk,
            }
        }).done( function(resp){
            try{
                resp = $.parseJSON(resp); 
            }catch(e){
                window.location = "/chat/public/login";
            }
            if(resp.status == 1){
                $("#typing_on").html(resp.user_name + ' typing....')
            }else{
                $("#typing_on").html('');
            }
        }).fail(function(jqXHR){
    
        });
    }
}


var chat_update = function(){

    $.ajax({
        method: "get",
        url: "chat-update"
    }).done( function(resp){
        try{
            resp = $.parseJSON(resp);
        } catch(e) {
            window.location = "/chat/public/login";
        }

        $(".chat-item").each(function(){
            var el = $(this);
            var id = el.attr("id");

            if (resp != ''){
                $.each(resp, function(k, v){
                    if (id == k) {
                        el.addClass('new-msg');
                        el.append('<div class="new-msg-count">'+ v +'</div>');
                    }
                });
            }else{
                el.removeClass('new-msg');
                el.find('.new-msg-count').remove();
            }
        });
    }).fail(function(jqXHR){

    });
}





/* modified code ends */



/* Register number verification code */

