<x-app>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Change userName') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('username.change') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('userName') }}</label>
                            <div class="col-md-6">
                                <input id="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username', $auth->username) }}" required autocomplete="username">

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn button_subColor mr-5">
                                    {{ __('Change') }}
                                </button>
                                <a href="{{ route('setting') }}" class="btn bg-danger text-white"><i class="fas fa-arrow-left"></i>  {{ __('return') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
</div>
    </div>
</div>
</x-app>