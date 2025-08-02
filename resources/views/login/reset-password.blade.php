@extends('layouts.login')
@section('title') Reset Password @endsection
@section('content')
        <div class="container d-flex align-items-center justify-content-center vh-100">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10">
          <div class="card">
            <div class="card-header bg-primary">
              <div class="app-brand">
                  <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30" height="33"
                    viewBox="0 0 30 33">
                    <g fill="none" fill-rule="evenodd">
                      <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                      <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                    </g>
                  </svg>

                  <span class="brand-name">ToDo App</span>
                </a>
              </div>
            </div>

            <div class="card-body p-5">
              <h4 class="text-dark mb-5">Reset Password</h4>

              <form method="POST">
                @csrf
                <div class="row">
                  <div class="form-group col-md-12 ">
                    <input name="password" type="password" class="form-control input-lg" id="password" placeholder="Password">
                  </div>

                  <div class="form-group col-md-12 ">
                    <input name="confirmPassword" type="password" class="form-control input-lg" id="password" placeholder="Rewrite Password">
                  </div>

                    <a class="btn btn-lg btn-primary btn-block mb-4"href="{{route('reset-password.store')}}">Reset Password</a>

                    <p>Already have an account?
                      <a class="text-blue" href="{{route('login')}}">Sign in</a>
                    </p>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
