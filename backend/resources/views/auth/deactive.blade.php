@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Deactive') }}</div>

                <div class="card-body text-center">
                    <form method="POST" action="{{ route('deactive') }}">
                        @csrf
                        <h2>{{ __('This will deactivate your account.') }}</h2>
                        <p>{{ __('Press the Deactive button to continue the process.') }}</p>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Deactive') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection