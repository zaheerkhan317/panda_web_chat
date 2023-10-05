@if( count($msgs) > 0 )
    @if(count($msgs) == 1)
        @foreach($msgs as $msg)
            <div id="msg-item-{{$msg->id}}" class="msg-item <?php echo ($msg->user_id == $me->id) ? 'me' : ''; ?>">
            
                @if($msg->user && !empty($msg->user->pic))
                    <img class="img-circle img-responsive msg-item-img" src="{{ asset('img/'.$msg->user->pic) }}">
                @else
                    <span class="placeholder-image"></span> <!-- Add a placeholder image or handle as needed -->
                @endif     
                <div class="draggable-content" draggable="{{$msg->dragged_message ? 'false' : 'true'}}">
                    @php
                        $hideMsgItemTxt = count($msg->chat->users) > 2;
                    @endphp
                <div class="msg-item-txt {{$hideMsgItemTxt ? '' : 'hide-name'}}"> 
                    @if($hideMsgItemTxt)
                        <strong>{{$msg->user->name ?? 'Unknown User'}} </strong> 
                    @endif
                    <div class="msg-item-msg">
                        @if(!empty($msg->dragged_message))
                            <div class="dragged-message" >
                                {{ $msg->dragged_message }}
                            </div>
                        @endif
                        @if(!empty($msg->msg) && empty($msg->attachment))
                            {{$msg->msg}}
                        @elseif(!empty($msg->attachment) && empty($msg->msg))
                            <div id="attachment-container">
                                @if (str_contains($msg->attachment, '.mp4') || str_contains($msg->attachment, '.mov'))
                                    <video controls style="max-width: 50%;" height="100%" width="100%">
                                        <source src="{{ asset($msg->attachment) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                @else
                                    @if (str_contains($msg->attachment, '.pdf'))
                                        <a href="{{ asset($msg->attachment) }}" target="_blank">
                                            <img src="{{ asset('img/pdf-icon.png') }}" class="lightbox-image" height="100px" width="100px" alt="PDF Attachment">
                                            <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                        </a>
                                    @elseif (str_contains($msg->attachment, '.pptx'))
                                        <a href="{{ asset($msg->attachment) }}" target="_blank">
                                            <img src="{{ asset('img/ppt-icon.png') }}" class="lightbox-image" height="100px" width="100px" alt="PPT Attachment">
                                            <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                        </a>
                                    @elseif (str_contains($msg->attachment, '.docx'))
                                        <a href="{{ asset($msg->attachment) }}" target="_blank">
                                            <img src="{{ asset('img/doc-icon.png') }}" class="lightbox-image" height="100px" width="100px" alt="DOC Attachment">
                                            <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                        </a>
                                    @else
                                        <a href="{{ asset($msg->attachment) }}" data-lightbox="attachment" data-title="<a href='{{ asset($msg->attachment) }}' download>Download</a>">
                                            <img src="{{ asset($msg->attachment) }}" class="lightbox-image" height="100px" width="100px" alt="Attachment">
                                        </a>
                                    @endif

                                @endif
                            </div>
                        @elseif(!empty($msg->msg) && !empty($msg->attachment))
                            <div id="attachment-container">
                                @if (str_contains($msg->attachment, '.mp4') || str_contains($msg->attachment, '.mov'))
                                    <video controls style="max-width: 50%;" height="100%" width="100%">
                                        <source src="{{ asset($msg->attachment) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                @else
                                    @if (str_contains($msg->attachment, '.pdf'))
                                        <a href="{{ asset($msg->attachment) }}" target="_blank">
                                            <img src="{{ asset('img/pdf-icon.png') }}" class="lightbox-image" height="100px" width="100px" alt="PDF Attachment">
                                            <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                        </a>
                                    @elseif (str_contains($msg->attachment, '.pptx'))
                                        <a href="{{ asset($msg->attachment) }}" target="_blank">
                                            <img src="{{ asset('img/ppt-icon.png') }}" class="lightbox-image" height="100px" width="100px" alt="PPT Attachment">
                                            <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                        </a>
                                    @elseif (str_contains($msg->attachment, '.docx'))
                                        <a href="{{ asset($msg->attachment) }}" target="_blank">
                                            <img src="{{ asset('img/doc-icon.png') }}" class="lightbox-image" height="100px" width="100px" alt="DOC Attachment">
                                            <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                        </a>
                                    @else
                                        <a href="{{ asset($msg->attachment) }}" data-lightbox="attachment" data-title="<a href='{{ asset($msg->attachment) }}' download>Download</a>">
                                            <img src="{{ asset($msg->attachment) }}" class="lightbox-image" height="100px" width="100px" alt="Attachment">
                                        </a>
                                    @endif
                                @endif
                            </div>
                            {{$msg->msg}}
                        @endif
                    </div>



                    <div class="msg-item-data">
                        
                        
                        <span class="timestamp">
                            @if ($msg->created_at->diffInHours(\Carbon\Carbon::now(), false) > 24)
                                {{ $msg->created_at->format('d F Y h:i A') }}
                            @else
                                {{ $msg->created_at->diffForHumans() }}
                            @endif
                        </span>
                        @if ($msg->user_id == Auth::user()->id)
                            <span><i class="fas {{ $msg->seen == 0 ? 'fa-check' : 'fa-check-double' }}" id="tick-icon"></i></span>
                        @endif

                    </div>
                </div>

            </div>
            </div>
        @endforeach
@else
    @foreach($msgs->reverse() as $msg)
        <div id="msg-item-{{$msg->id}}" class="msg-item <?php echo ($msg->user_id == $me->id) ? 'me' : ''; ?>" >
        
                @if($msg->user && !empty($msg->user->pic))
                    <img class="img-circle img-responsive msg-item-img" src="{{ asset('img/'.$msg->user->pic) }}">
                @else
                    <span class="placeholder-image"></span> <!-- Add a placeholder image or handle as needed -->
                @endif
                <div class="draggable-content" draggable="{{$msg->dragged_message ? 'false' :  'true'}}">
                @php
                    $hideMsgItemTxt = count($msg->chat->users) > 2;
                @endphp
                <div class="msg-item-txt {{$hideMsgItemTxt ? '' : 'hide-name'}}"> 
                    @if($hideMsgItemTxt)
                        <strong>{{$msg->user->name ?? 'Unknown User'}} </strong> 
                    @endif             
               
                <div class="msg-item-msg">
                    @if(!empty($msg->dragged_message))
                        <div class="dragged-message " >
                            {{ $msg->dragged_message }}
                        </div>
                    @endif
                    @if(!empty($msg->msg) && empty($msg->attachment))
                        {{$msg->msg}}
                    @elseif(!empty($msg->attachment) && empty($msg->msg))
                        <div id="attachment-container">
                            @if (str_contains($msg->attachment, '.mp4') || str_contains($msg->attachment, '.mov'))
                                <video controls style="max-width: 50%;" height="100%" width="100%">
                                    <source src="{{ asset($msg->attachment) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                            @else
                                    @if (str_contains($msg->attachment, '.pdf'))
                                        <a href="{{ asset($msg->attachment) }}" target="_blank">
                                            <img src="{{ asset('img/pdf-icon.png') }}" class="lightbox-image" height="100px" width="100px" alt="PDF Attachment">
                                            <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                        </a>
                                    @elseif (str_contains($msg->attachment, '.pptx'))
                                        <a href="{{ asset($msg->attachment) }}" target="_blank">
                                            <img src="{{ asset('img/ppt-icon.png') }}" class="lightbox-image" height="100px" width="100px" alt="PPT Attachment">
                                            <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                        </a>
                                    @elseif (str_contains($msg->attachment, '.docx'))
                                        <a href="{{ asset($msg->attachment) }}" target="_blank">
                                            <img src="{{ asset('img/doc-icon.png') }}" class="lightbox-image" height="100px" width="100px" alt="DOC Attachment">
                                            <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                        </a>
                                    @else
                                        <a href="{{ asset($msg->attachment) }}" data-lightbox="attachment" data-title="<a href='{{ asset($msg->attachment) }}' download>Download</a>">
                                            <img src="{{ asset($msg->attachment) }}" class="lightbox-image" height="100px" width="100px" alt="Attachment">
                                        </a>
                                    @endif
                            @endif
                        </div>
                    @elseif(!empty($msg->msg) && !empty($msg->attachment))
                        <div id="attachment-container">
                            @if (str_contains($msg->attachment, '.mp4') || str_contains($msg->attachment, '.mov'))
                                <video controls style="max-width: 50%;" height="100%" width="100%">
                                    <source src="{{ asset($msg->attachment) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                            @else
                                    @if (str_contains($msg->attachment, '.pdf'))
                                        <a href="{{ asset($msg->attachment) }}" target="_blank">
                                            <img src="{{ asset('img/pdf-icon.png') }}" class="lightbox-image" height="100px" width="100px" alt="PDF Attachment">
                                            <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                        </a>
                                    @elseif (str_contains($msg->attachment, '.pptx'))
                                        <a href="{{ asset($msg->attachment) }}" target="_blank">
                                            <img src="{{ asset('img/ppt-icon.png') }}" class="lightbox-image" height="100px" width="100px" alt="PPT Attachment">
                                            <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                        </a>
                                    @elseif (str_contains($msg->attachment, '.docx'))
                                        <a href="{{ asset($msg->attachment) }}" target="_blank">
                                            <img src="{{ asset('img/doc-icon.png') }}" class="lightbox-image" height="100px" width="100px" alt="DOC Attachment">
                                            <p style="color: black; text-align: center;">{{ isset(explode('_', basename($msg->attachment))[1]) ? explode('_', basename($msg->attachment))[1] : '' }}</p>
                                        </a>
                                    @else
                                        <a href="{{ asset($msg->attachment) }}" data-lightbox="attachment" data-title="<a href='{{ asset($msg->attachment) }}' download>Download</a>">
                                            <img src="{{ asset($msg->attachment) }}" class="lightbox-image" height="100px" width="100px" alt="Attachment">
                                        </a>
                                    @endif
                            @endif
                        </div>
                        {{$msg->msg}}

                    @endif
                </div>


                <div class="msg-item-data">
                    

                    <span class="timestamp">
                        @if ($msg->created_at->diffInHours(\Carbon\Carbon::now(), false) > 24)
                            {{ $msg->created_at->format('d F Y h:i A') }}
                        @else
                            {{ $msg->created_at->diffForHumans() }}
                        @endif
                    </span>

                        @if ($msg->user_id == Auth::user()->id)
                            <span><i class="fas {{ $msg->seen == 0 ? 'fa-check' : 'fa-check-double' }}" id="tick-icon"></i></span>
                        @endif

                </div>
            </div>
        </div>
        </div>
    @endforeach
@endif
@else
<div class="no-record text-center" style="display: flex; justify-content: center; align-items: center; height: 50vh;">
    No Message Exist
</div>


@endif



<script>
let draggedMessage = '';
let initialX = 0;
let isDragging = false;

document.addEventListener('dragstart', function(event) {
    draggedMessage = event.target.innerHTML;
    initialX = event.clientX;
  });

  document.addEventListener('dragover', function(event) {
    event.preventDefault();
  });

  document.addEventListener('drop', function(event) {
    event.preventDefault();
    
    const finalX = event.clientX;

    // Only append the message if the drag was primarily horizontal
    if (draggedMessage && Math.abs(finalX - initialX) > 50 ) {
      // Append the dragged message content to panel-dragged-msg
      const panelDraggedMsg = document.querySelector('.panel-dragged-msg');
      panelDraggedMsg.innerHTML = `
        <div class="dragged-message-content">${draggedMessage}</div>
        <button class="close-btn" onclick="closeDraggedMessage()">x</button>
      `;
      draggedMessage = '';
      isDragging = false;
    }
  });

  function closeDraggedMessage() {
    const panelDraggedMsg = document.querySelector('.panel-dragged-msg');
    panelDraggedMsg.innerHTML = ''; // Clear the content
  }


  

function handleTouchStart(event) {
    const draggableContent = event.target.closest('.draggable-content');
    if (draggableContent) {
        const draggable = draggableContent.getAttribute('draggable');
        if (draggable === 'false') {
            // If draggable is set to false, do not proceed with dragging
            return;
        }
        
        // Rest of the logic for dragging when draggable is true
        draggedMessage = draggableContent.innerHTML;
        console.log(draggedMessage);
        initialX = event.touches[0].clientX;
        isDragging = true;
    }
}

function handleTouchMove(event) {
    if (!isDragging) return;
    event.preventDefault();
    const touch = event.touches[0];
    const finalX = touch.clientX;

    // Only append the message if the drag was primarily horizontal
    if (draggedMessage && Math.abs(finalX - initialX) > 50) {
        const panelDraggedMsg = document.querySelector('.panel-dragged-msg');
        panelDraggedMsg.innerHTML = `
            <div class="dragged-message-content">${draggedMessage}</div>
            <button class="close-btn" onclick="closeDraggedMessage()">x</button>
        `;
        draggedMessage = ''; 
        isDragging = false;
    }

     // Disable dragging for mobile users
     const draggedMessageElement = document.querySelector('.dragged-message');
    if (draggedMessageElement && isMobileDevice()) {
        draggedMessageElement.style.touchAction = 'none';
    }
}

function isMobileDevice() {
    return window.innerWidth <= 767; // Adjust the width as needed
}


document.addEventListener('touchstart', handleTouchStart);
document.addEventListener('touchmove', handleTouchMove);
  






</script>





















