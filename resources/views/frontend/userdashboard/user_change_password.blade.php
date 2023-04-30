@extends('dashboard')
@section('user')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 m-auto">
                        <div class="row">
                        @include('frontend.body.dashboard_sidebar_menu')
                            <div class="col-md-9">
                                <div class="tab-content account dashboard-content pl-50">
                                    <div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Change Password</h5>
                                            </div>
                                            <div class="card-body">
                                                <form method="post" action="{{ route('user.update.password') }}">
                                                    @csrf

                                                    @if(session('status'))
                                                    <div class="alert alert-success" role="alert">
                                                        {{ session('status') }}
                                                    </div>
                                                    @elseif(session('error'))
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ session('error') }}
                                                    </div>
                                                    @endif

                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label>Old Password <span class="required">*</span></label>
                                                            <input id="current_password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" type="password" placeholder="Old Password" />
                                                            @error('old_password')
                                                                <span class="text-danger">{{ $message }}<span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>New Password <span class="required">*</span></label>
                                                            <input id="new_password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" type="password" placeholder="New Password" />
                                                            @error('new_password')
                                                                <span class="text-danger">{{ $message }}<span>
                                                            @enderror              
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Confirm New Password <span class="required">*</span></label>
                                                            <input id="new_password_confirmation" class="form-control" name="new_password_confirmation" type="password" placeholder="Confirm New Password" />
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Save Change</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection