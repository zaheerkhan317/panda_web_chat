<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Panda Web Chat</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        

        <!-- Styles -->
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            /* Custom styles for the Bootstrap navbar */

            .navbar {
                background-color: #f8f9fa; /* Background color */
                padding: 10px 0; /* Vertical padding */
            }

            .navbar-brand {
                color: #2ecc71; /* Brand text color */
                font-weight: bold;
            }

            .navbar-nav .nav-item {
                margin-right: 10px; /* Adjust spacing between items */
            }

            .navbar-nav .nav-link {
                    color: #000000; /* Nav link text color */
                    transition: color 0.3s; /* Smooth color transition */
                }

                .navbar-nav .nav-link:hover {
                    color: #2ecc71; /* Hover state text color */
                }



            .flex-center {
                display: flex;
                justify-content: center;
                background-color: #6c757d;
                align-items: center;
                height:10%;
            }

            .position-ref {
                position: relative;
            }


            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }



            body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .landing {
            position: relative;
            background-image: url('../img/image5.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 0;
            box-shadow: inset 0 0 0 2000px rgba(0,0,0,0.5); /* Add a shadow effect */
        }

        .landing h1,
        .landing p,
        .landing .btn {
            position: relative;
            z-index: 1;
            color: white;
            opacity: 0; /* Initially set opacity to 0 for the fadeIn effect */
        }

        .landing h1 {
            font-size: 48px;
            font-weight: bold;
            color: #2ecc71;
            margin-bottom: 20px;
            animation: fadeInUp 1s forwards 0.5s; /* Apply fadeInUp animation */
        }

        .landing p {
            font-size: 24px;
            margin-bottom: 40px;
            animation: fadeInUp 1s forwards 1s; /* Apply fadeInUp animation */
        }

        .landing .btn {
            font-size: 24px;
            font-weight: bold;
            padding: 15px 30px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            animation: fadeInUp 1s forwards 1.5s; /* Apply fadeInUp animation */
        }

        .landing .btn:hover {
            background-color: #28a745;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }



                .features {
                    padding: 70px;
                    text-align: center;
                }

                .features .row {
                    display: flex;
                    justify-content: center;
                }

                .features .col-md-4 {
                    text-align: center;
                    margin-bottom: 30px;
                    animation: fadeInUp 1s ease-in-out;
                }

                .features h2 {
                    font-size: 36px;
                    font-weight: bold;
                    color: #2ecc71;
                    margin-bottom: 60px;
                }

                .features p {
                    font-size: 18px;
                    color: #6c757d;
                }

                .features i {
                    font-size: 50px;
                    color: #6c757d;
                }

                .cta {
                    background-color: #2ecc71;
                    text-align: center;
                    padding: 15px 0;
                    margin-bottom: 0;
                }

                .cta h2 {
                    font-size: 36px;
                    font-weight: bold;
                    color: #ffffff;
                    margin-bottom: 20px;
                }

                .cta .btn {
                    font-size: 24px;
                    font-weight: bold;
                    padding: 15px 30px;
                    background-color: #ffffff;
                    color: #2ecc71;
                    border-radius: 5px;
                    transition: background-color 0.3s;
                }

                .cta .btn:hover {
                    background-color: #ffffff;
                    color: #2ecc71;
                }

                .footer {
                    background-color: #2ecc71;
                    text-align: center;
                    padding: 20px 0;
                    color: #ffffff;
                }

                @keyframes fadeInUp {
                    0% {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    100% {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
    
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Panda Web Chat</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        @if (Route::has('login'))
                            <li class="nav-item">
                                @if (Auth::check())
                                    <a class="nav-link" style="color:#000000;" href="{{ url('/home') }}">Home</a>
                                @else
                                    <a class="nav-link" style="color:#000000;" href="{{ url('/login') }}">Login</a>
                                @endif
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color:#000000;" href="{{ url('/register') }}">Register</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>



    <div class="landing">
        <div class="overlay"></div>
        <h1>Welcome to Panda Web Chat</h1>
        <p>Connect and chat with your friends and colleagues in real-time.</p>
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Get Started</a>
    </div>

    <section id="features" class="features">
        <div class="container">
            <h2>Features</h2>
            <div class="row">
                <div class="col-md-4">
                    <i class="icon fas fa-comments"></i>
                    <h3>Real-time Chat</h3>
                    <p>Chat with your friends and colleagues in real-time.</p>
                </div>
                <div class="col-md-4">
                    <i class="icon fas fa-users"></i>
                    <h3>Group Chat</h3>
                    <p>Create and join group chats to collaborate with multiple people.</p>
                </div>
                <div class="col-md-4">
                    <i class="icon fas fa-lock"></i>
                    <h3>Secure</h3>
                    <p>Your conversations are encrypted and secure.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="cta" class="cta">
        <div class="container">
            <h2>Get Started with Panda Web Chat</h2>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Sign Up</a>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; Created By <a href="https://zaheerkhan317.github.io/zaheer-portfolio/">Zaheer khan</a> | 2023 Panda Web Chat. All rights reserved.  </p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    
    </body>
</html>
