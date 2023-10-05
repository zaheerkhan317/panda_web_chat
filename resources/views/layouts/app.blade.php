<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Panda Web Chat</title>

    <!-- Styles -->
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!--- i added this links --->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- JavaScript -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
   

    
    
    <!--- i added this links end --->
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        Panda Web Chat
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else

                        <li class="">
                            <button type="button" class="btn btn-primary navbar-btn" data-toggle="modal" data-target="#myModal1">
                                <span class="glyphicon glyphicon-plus font-weight-bold"></span>
                                Add A Friend
                            </button>
                        </li>

                        <!-- Add some space between the buttons -->
                        <li class="" style="margin-left: 20px;">
                            <button type="button" class="btn btn-primary navbar-btn" data-toggle="modal" data-target="#myModal">
                                <span class="glyphicon glyphicon-plus font-weight-bold"></span>
                                Create Group
                            </button>
                        </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('home') }}">
                                            Home
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('profile') }}">
                                            Profile
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>



<!-- Modal1 -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal1 content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create New Chat</h4>
      </div>
      <div class="modal-body">
        <div class="create-chat-status1"></div>
        <form id="create-form1">
            {{ csrf_field() }}
            <fieldset class="form-group">
                <label for="formGroupExampleInput2">
                Search Users
                </label>
                <input type="text" id="searchPhoneInput" class="form-control" placeholder="Ex: +91 1234567891">
                
            </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <button data-deselectAllText="Deselect All" type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
        <button disabled type="button" class="btn btn-primary" id="create1">Create</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal-->




<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create New Chat</h4>
      </div>
      <div class="modal-body">
        <div class="create-chat-status"></div>
        <form id="create-form">
            {{ csrf_field() }}
            <fieldset class="form-group">
                <label for="formGroupExampleInput2">
                    Select Users
                </label>
                <select id="create-data" class="selectpicker" multiple>
                @if(isset($users))
                    @php
                    $encounteredUserIds = [];
                    @endphp
                    @foreach(Auth::user()->chats as $chat)
                        @foreach($chat->users as $user)
                            @if($user->id !== Auth::user()->id && !in_array($user->id, $encounteredUserIds))
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @php
                                $encounteredUserIds[] = $user->id;
                                @endphp
                            @endif
                        @endforeach
                    @endforeach
                @endif


                </select>
            </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <button data-deselectAllText="Deselect All" type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
        <button disabled type="button" class="btn btn-primary" id="create">Create</button>
      </div>
    </div>

  </div>
</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.2/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.2/firebase-database.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    
    
    <!-- Include JoyPixels Emoji Picker CSS and JavaScript -->

    <script src="{{ asset('js/app.js') }}"></script>
    
    <script src="{{ asset('js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    

    <script>
    $(document).ready(function () {
        $('#searchPhoneInput').on('input', function () {
            var searchValue = $(this).val().trim();
            if (searchValue !== '') {
                fetchUserSuggestions(searchValue);
            } else {
                $('#phoneSuggestions').empty();
                enableCreateButton(false);
            }
        });

        $('#phoneSuggestions').on('click', '.user-suggestion', function () {
            var selectedName = $(this).data('name');
            $('#searchPhoneInput').val(selectedName);
            $('#phoneSuggestions').empty();
            enableCreateButton(true);
        });

        

        function fetchUserSuggestions(searchValue) {
            const minDigits = 13;
            const createButton = $("#create1"); // Replace with your actual button ID
            if (searchValue.length >= minDigits) {
                var tk = $("#create-form1 input[name=_token]").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': tk // Include CSRF token in request headers
                    }
                });
                $.ajax({
                    url: '/get-user-suggestions', // Adjust the URL
                    method: 'POST',
                    data: { q: searchValue },
                    success: function (data) {
                        if (data.length > 0) {
                            // Extract user IDs from the response
                            const userIds = data.map(item => item.id);
                            //console.log("User IDs:", userIds);
                            
                            // Enable the "Create" button if there are user IDs
                            if (userIds.length > 0) {
                                //console.log("User IDs exist in the response.");
                                createButton.prop("disabled", false);
                            } else {
                                //console.log("User IDs do not exist in the response.");
                                createButton.prop("disabled", true);
                            }

                            const suggestionList = $('#phoneSuggestions');
                            suggestionList.empty();
                            data.forEach(item => {
                                const listItem = `<li>${item.name} - ${item.phone}</li>`;
                                suggestionList.append(listItem);
                            });
                            $('#create1').on('click', function () {
                                var selectedName = $('#searchPhoneInput').val();
                                if (selectedName !== '') {
                                    createNewChat(selectedName);
                                    //console.log(selectedName);
                                }
                            });
                        } else {
                            //console.log("Phone number does not exist in the database.");
                            createButton.prop("disabled", true);
                            $('#phoneSuggestions').empty();
                        }
                    },
                    error: function (error) {
                        //console.error('Error:', error);
                        createButton.prop("disabled", true);
                        $('#phoneSuggestions').empty();
                    }
                });
            } else {
                // Disable the "Create" button if digits are less than minDigits
                createButton.prop("disabled", true);
            }
        }



        function enableCreateButton(enable) {
            $('#create1').prop('disabled', !enable);
        }




        
        function createNewChat(selectedName) {
           
            var bt = $("#create1");
            bt.empty().html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
            var tk = $("#create-form1").find('input[name=_token]').val();
            var requestData = {
                'phone': selectedName,
                '_token': tk,
            };

            $.ajax({
                url: "/store-chat", // Adjust the URL
                method: "POST",
                data: requestData,
                dataType: "json",
            }).done(function (resp) {
                // Handle success or failure response
            if (resp.hasOwnProperty('status')) {
          
                    if (resp.status == 1) {
                        $(".create-chat-status1").removeClass("alert alert-danger").addClass("alert alert-success").text(resp.txt);
                        bt.empty().text("Create");
                        bt.prop("disabled", true);
                        setTimeout(function () {
                            chat_list();
                            $("#myModal").modal('hide');
                        }, 2000);
                        //console.log("Chat created successfully.");
                    } else if (resp.status == 0) {
                        $(".create-chat-status1").removeClass("alert alert-success").addClass("alert alert-danger").text(resp.txt);
                        bt.empty().text("Create");
                        bt.prop("disabled", true);
                    } else {
                        //console.log('Response is not a valid JSON string.');
                        handleAjaxError();
                    }
                } else {
                    //console.log('Invalid response format:', resp);
                    handleAjaxError();
                }
                
            }).fail(function (jqXHR) {
                // Handle failure
                //console.log("Ajax request failed.");
                if(jqXHR.status == 422){
                    $(".create-chat-status1").removeClass("alret alert-success").addClass("alert alert-danger").text("Select at least one user");
                }else{
                    $(".create-chat-status1").removeClass("alret alert-success").addClass("alert alert-danger").text("Something went wrong");
                }
                handleAjaxError();
            });
        }

        function handleAjaxError() {
            var bt = $("#create1");
            bt.empty().text('Create');
            bt.prop('disabled', false); // Enable the button
        }
    });

    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'template': '<div class="lightbox">' +
                        '<div class="lb-container">' +
                            '<div class="lb-nav">' +
                                '<a class="lb-prev" href=""></a>' +
                                '<a class="lb-next" href=""></a>' +
                            '</div>' +
                            '<div class="lb-loader">' +
                                '<a class="lb-cancel"></a>' +
                            '</div>' +
                            '<div class="lb-dataContainer">' +
                                '<div class="lb-data">' +
                                    '<div class="lb-details">' +
                                        '<span class="lb-caption"></span>' +
                                        '<span class="lb-number"></span>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="lb-closeContainer">' +
                                    '<a class="lb-close"></a>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>'
    });





    // Function to handle file selection and preview
    function handleFileSelect(evt) {
        var file = evt.target.files[0];
        var previewImg = document.getElementById('attachment-preview-img');
        var previewVideo = document.getElementById('attachment-preview-video');
        var previewDocument = document.getElementById('attachment-preview-document');
        var preview = document.getElementById('attachment-preview');
        var imgNameElement = document.getElementById('attachment-img-name');

         // Mapping of file extensions to icons
        var fileIcons = {
            'pdf': 'pdf-icon.png',
            'doc': 'doc-icon.png',
            'docx': 'docx-icon.png',
            'ppt': 'ppt-icon.png',
            'pptx': 'pptx-icon.png',
            // Add more file types and icons as needed
        };

        // Function to get file extension
        function getFileExtension(fileName) {
            return fileName.split('.').pop().toLowerCase();
        }

        // Hide both image and video previews
        previewImg.style.display = 'none';
        previewVideo.style.display = 'none';

        var fileExtension = getFileExtension(file.name);

        // Check if it's an image file
        if (file.type.match('image.*')) {
                previewImg.src = URL.createObjectURL(file);
                previewImg.style.display = 'block';
                previewVideo.style.display = 'none';
                previewDocument.style.display = 'none';
                preview.style.display = 'block';
                imgNameElement.innerHTML = `${file.name}`;
            }

        // Check if it's a video file
        else if (file.type.match('video.*')) {
           
                // Display video preview
                previewImg.style.display = 'none';
                previewVideo.src = URL.createObjectURL(file);
                previewVideo.style.display = 'block';
                previewDocument.style.display = 'none';
                preview.style.display = 'block';
                previewVideo.controls = true;

                // Display video name
                imgNameElement.innerHTML = `${file.name}`;
            
        }
        // Check if it's a PDF document
        /*else if (fileExtension === 'pdf') {
            // Display PDF using iframe
            
            previewDocument.src = URL.createObjectURL(file);
            previewDocument.style.display = 'block';
            preview.style.display = 'block';
            imgNameElement.innerHTML = `${file.name}`;
        }*/

       
        // Check if it's a document file (PDF, DOC, DOCX, PPT, PPTX, etc.)
        else if (['pdf','doc', 'docx', 'ppt', 'pptx'].includes(fileExtension)) {
            previewImg.style.display = 'none';
            previewVideo.style.display = 'none';
            var iconPath = "{{ asset('img/') }}" + '/' + fileExtension + "-icon.png";
            previewDocument.src = iconPath;
            previewDocument.style.display = 'block';
            preview.style.display = 'block';
            imgNameElement.innerHTML = `${file.name}`;
        }

        else {
             // Display a default icon for unsupported file types
            previewImg.src = 'default-icon.png';
            previewImg.style.display = 'block';
            previewVideo.style.display = 'none';
            previewDocument.style.display = 'none';
            preview.style.display = 'block';
            imgNameElement.innerHTML = `${file.name}`;
        }
    }

    // Add event listener to the file input
    document.getElementById('attachment').addEventListener('change', handleFileSelect, false);



    




</script>










   
    @stack('script')
</body>
</html>
