@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!--- profile sectoion -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{$me->name}}'s Profile
                </div>

                <div class="panel-body">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                    @endif

                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{$error}}
                            </div>
                        @endforeach
                    @endif
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <form id="pic-save" enctype="multipart/form-data" action="{{route('pic-save')}}" method="POST">
                            {{ csrf_field() }}
                            <img class="profile-pic" src="{{ asset('img/'.$me->pic) }}" alt="">

                            <input type="button" name="pic_btn" id="pic_btn" class="btn-block btn btn-primary btn-sm" value="Upload">

                            <input style="display:none;" type="file" id="pic_file" name="pic_file">
                            <input style="display:none;" type="submit" id="pic_submit" name="pic_submit" value="Save">
                        </form>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <h3>Personal Details</h3>
                        <form id="profile-save" action="{{ route('profile-save') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" type="text" name="name" id="name" placeholder="Write your name..." value="{{$me->name}}">
                            </div>

                            <div class="form-group">
                                <label for="name">Email</label>
                                <input class="form-control" type="email" name="email" id="email" placeholder="Write your Email..." value="{{$me->email}}">
                            </div>
                            <input type="submit" name="submit" class="btn btn-sm btn-primary pull-right" value="Save">
                        </form>

                        <h3>Reset Password</h3>
                        <form id="pass-save" action="{{ route('pass-save') }}" method="POST">
                            {{ csrf_field() }}

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input class="form-control" type="password" name="new_password" id="new_password" >
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="new_password_confirmation">Confirm Password</label>
                                    <input class="form-control" type="password" name="new_password_confirmation" id="new_password_confirmation" >
                                </div>                                
                            </div>

                            <input name="submit-pass" type="submit" class="btn btn-sm btn-primary pull-right" value="Update Password">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--- profile section end ---> 
        
    </div>
</div>
@endsection
