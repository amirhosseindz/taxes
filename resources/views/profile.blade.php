@extends('layouts.app')

@section('css')
    <style>
        input[name='email'], input[name='mobile'], input[name='birthdate'] {
            direction: ltr;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <aside class="profile-nav col-lg-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="dist/img/user4-128x128.jpg" alt="User Image">
                    <h3 class="profile-username text-center">{{ $user->name }}</h3>
                    <p class="text-muted text-center">{{ $user->email }}</p>
                </div>
            </div>
        </aside>
        <aside class="profile-info col-lg-9">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Profile Information</h3>
                </div>
                <div class="box-body">
                    <form id="infoForm" class="form-horizontal" action="{{ route('profile.info') }}"
                          method="post">
                        @csrf

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Name</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Change Password</h3>
                </div>
                <div class="box-body">
                    <form id="passForm" class="form-horizontal" action="{{ route('profile.pass') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Current Password</label>
                            <div class="col-lg-7">
                                <input type="password" class="form-control" name="old_password" id="o-pwd">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">New Password</label>
                            <div class="col-lg-7">
                                <input type="password" class="form-control" name="new_password" id="n-pwd">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Confirm New Password</label>
                            <div class="col-lg-7">
                                <input type="password" class="form-control" name="password_confirmation" id="pwd-c">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </aside>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $('#infoForm').ajaxForm();
            $('#passForm').ajaxForm();
        });
    </script>
@endsection
