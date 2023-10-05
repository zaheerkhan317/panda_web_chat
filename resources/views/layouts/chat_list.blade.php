@if( count($chats) > 0)
@foreach($chats as $chat)
    <?php $total_msg =[]; ?>
    <div id="{{$chat->id}}" class="chat-item">
        @if( count($chat->users) > 2)
        <img class="img-circle img-responsive chat-item-img" src="{{ asset('img/default-group.png') }}">
        @else
            <?php 
                $img = null;
                foreach ($chat->users as $u) {
                    if ($me->id !== $u->id) {
                        $img = $u->pic;
                    }
                }
            ?>

        <img class="img-circle img-responsive chat-item-img" src="{{ asset('img/'. $img) }}">
        @endif
        <div class="chat-item-users">
            <?php 
                $un = [];
                foreach ($chat->users as $u){
                    if($me->id !== $u->id){
                        $un[] = $u->name;
                    }
                }
                $un = implode(", ", $un);
                echo ( strlen($un) > 17 ) ? substr($un, 0, 17) ."...":$un;
                
            ?>
        <?php if (count($chat->users) <= 2): ?>
           <?php foreach ($chat->users as $user): ?>
                <?php if ($me->id !== $user->id): ?>
                    <span id="user-status" data-user-id="<?= $user->id ?>">
                        <?php if (Cache::has('is_online' . $user->id)): ?>
                            <span class="dot online"></span>
                        <?php else: ?>
                            <span class="dot offline"></span>
                            <span class="last-seen"><?= \Carbon\Carbon::parse($user->last_seen)->diffForHumans() ?></span>
                        <?php endif; ?>
                    </span>
                <?php endif; ?>
            <?php endforeach; ?>


        <?php endif; ?>
        </div>

        <?php 
            if(array_key_exists($chat->id, $total_msg)){
                $c = ($total_msg[$chat->id] > 20 ) ? "20+" : $total_msg[$chat->id];
                echo "<div class='new-msg-count'>".$c."</div>";
            }
        ?>
        

           
        
    </div>

    @endforeach
@else
    <div class="no-record text-center">No chat Exist</div>
@endif


<script>

function toggleBlockOptions(chatId) {
    var blockOptions = document.getElementById('block-options-' + chatId);
    if (blockOptions.style.display === 'none') {
        blockOptions.style.display = 'block';
    } else {
        blockOptions.style.display = 'none';
    }
}

    function updateOnlineStatus() {
        // Retrieve the user ID from the data attribute
        var userId = $('#user-status').data('user-id');

        $.ajax({
            url: '/check-online-status/' + userId,
            method: 'GET',
            success: function (response) {
                if (response.isOnline) {
                    $('#user-status').html(' <span class="dot online"></span>');
                } else {
                    $('#user-status').html(' <span class="dot offline"></span><span class="last-seen">' + response.lastSeen + '</span>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error updating online status:', error);
            }
        });
    }

    setInterval(updateOnlineStatus, 2000);  // Update every 2 seconds
</script>
