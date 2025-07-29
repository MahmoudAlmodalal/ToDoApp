@extends('layouts.login')
@section('title') Forget Password @endsection
@section('content')
        <div class="container d-flex align-items-center justify-content-center vh-100">
      <div class="row justify-content-center">
        <div>
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
              <h4 class="text-dark mb-5">Send code</h4>

              <form method="POST" action="{{route('forget-password.store')}}">
                @csrf
                  <div class="form-group col-md-12 mb-4">
                    <input name="user_name" type="text" class="form-control input-lg" id="username" aria-describedby="nameHelp" placeholder="Username">
                  </div>
                    <div class="form-group col-md-12 mb-4">
                    <input name="email" type="email" class="form-control input-lg" id="email" aria-describedby="emailHelp" placeholder="email">
                  </div>
                    <button type="submit" class="btn btn-lg btn-primary btn-block mb-4">Send</button>

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
