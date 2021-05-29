@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Join Group') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('joingroups.store') }}">
                        @csrf

                        <div class="alert alert-warning"> {{ __('This Action can update your group selection.') }}</div>
                        <div class="form-group row">
                            <label for="group" class="col-md-4 col-form-label text-md-right">{{ __('Join Group') }}</label>

                            <div class="col-md-6">
                                <select id="group" class="form-control @error('group_id') is-invalid @enderror" name="group_id" value="{{ old('group_id') }}"  required>
                                    @foreach($groups as $group)
                                    @if($group->count_limit > $group->filled)
                                     <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>{{ $group->topic }}</option>
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
                                <a class="btn btn-primary" href="{{ route('joingroups.index') }}"> Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
