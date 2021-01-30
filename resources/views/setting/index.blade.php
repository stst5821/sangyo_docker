@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('UserInfo') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if (!$auth->email_verified_at)
                    <div class="alert alert-warning" role="alert">
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email,') }}
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another.') }}</button>
                        </form>
                    </div>
                    @endif

                    <div class="list-group mb-3" style="max-width:400px; margin:auto;">
                        <a href="{{ route('name.form') }}" @if ($auth->email_verified_at)
                            class="list-group-item list-group-item-action d-flex justify-content-between
                            align-items-center"
                            @else
                            class="list-group-item list-group-item-action d-flex justify-content-between
                            align-items-center disabled" tabindex="-1" aria-disabled="true"
                            @endif
                            >
                            <dl class="mb-0">
                                <dt>{{ __('Name') }}</dt>
                                <dd class="mb-0">{{ $auth->name }}</dd>
                            </dl>
                            <div><i class="fas fa-chevron-right"></i></div>
                        </a>

                        <a href="{{ route('username.form')}}"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <dl class="mb-0">
                                <dt>{{ __('UserName') }}</dt>
                                <dd class="mb-0">{{ $auth->username }}</dd>
                            </dl>
                            @if ($auth->email_verified_at)
                            <div><i class="fas fa-chevron-right"></i></div>
                            @endif
                        </a>

                        <a href="{{ route('email.form') }}" @if ($auth->email_verified_at)
                            class="list-group-item list-group-item-action d-flex justify-content-between
                            align-items-center"
                            @else
                            class="list-group-item list-group-item-action d-flex justify-content-between
                            align-items-center disabled" tabindex="-1" aria-disabled="true"
                            @endif
                            >
                            <dl class="mb-0">
                                <dt>{{ __('E-Mail Address') }}</dt>
                                <dd class="mb-0">{{ $auth->email }}</dd>
                            </dl>
                            @if ($auth->email_verified_at)
                            <div><i class="fas fa-chevron-right"></i></div>
                            @endif
                        </a>

                        <a href="{{ route('password.form') }}" @if ($auth->email_verified_at)
                            class="list-group-item list-group-item-action d-flex justify-content-between
                            align-items-center"
                            @else
                            class="list-group-item list-group-item-action d-flex justify-content-between
                            align-items-center disabled" tabindex="-1" aria-disabled="true"
                            @endif
                            >
                            <dl class="mb-0">
                                <dt>{{ __('Password') }}</dt>
                                <dd class="mb-0">********</dd>
                            </dl>
                            @if ($auth->email_verified_at)
                            <div><i class="fas fa-chevron-right"></i></div>
                            @endif
                        </a>
                    </div>
                    <div class="list-group" style="max-width:400px; margin:auto;">
                        <a href="{{ route('deactive.form') }}"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>{{ __('Deactive') }}</div>
                            <div><i class="fas fa-chevron-right"></i></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection