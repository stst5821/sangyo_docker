<x-app>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Image_change') }}</div>
                <div class="card-body">
                    <form method="post" action="{{ route('upload') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="image" accept="image/png, image/jpeg">

                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn button_subColor">
                                {{ __('Change') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</x-app>