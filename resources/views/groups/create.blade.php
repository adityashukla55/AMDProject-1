@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Group') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                          <strong>Whoops!</strong> There were some problems with your selection.<br><br>
                          <ul>
                              @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                              @endforeach
                           </ul>
                        </div>
                     @endif

                    <form method="POST" action="{{ route('groups.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="topic" class="col-md-4 col-form-label text-md-right">{{ __('Topic') }}</label>

                            <div class="col-md-6">
                                <input id="topic" type="text" class="form-control @error('topic') is-invalid @enderror" name="topic" value="{{ old('topic') }}" required>

                                @error('topic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea class="form-control  @error('description') is-invalid @enderror" style="height:100px" name="description" placeholder="Description" value="{{ old('description') }}" required></textarea>
		   
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="count_limit" class="col-md-4 col-form-label text-md-right">{{ __('Count Limit') }}</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control number @error('count_limit') is-invalid @enderror" name="count_limit" min="2" value="{{ old('count_limit') }}" required>
                                @error('count_limit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                       
                        

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                                <a class="btn btn-primary" href="{{ route('groups.index') }}"> Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
