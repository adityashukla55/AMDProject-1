@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Join Group') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('joinmeetings.store') }}">
                        @csrf

                        <div class="alert alert-warning"> {{ __('This Action can update your group selection.') }}</div>
                        <div class="form-group row">
                            <label for="group" class="col-md-4 col-form-label text-md-right">{{ __('Join Meeting/Group') }}</label>

                            <div class="col-md-6">
                            
                                <select class="form-control @error('group_id') is-invalid @enderror" name="group_id" value="{{ old('group_id') }}"  required>
                                    @foreach($meetings as $meeting)
                                     @if($meeting->group->count_limit > $meeting->group->filled)
                                     <option value="{{ $meeting->id }}" {{ old('group_id') == $meeting->id ? 'selected' : '' }}>{{ $meeting->name }} / {{ $meeting->group->topic }}</option>
                                     @endif
                                    @endforeach
                                </select>

                                @error('group_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Join') }}
                                </button>
                                <a class="btn btn-primary" href="{{ route('joinmeetings.index') }}"> Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
