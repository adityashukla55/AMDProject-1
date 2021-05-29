@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Meetings') }}</div>

                <div class="card-body">
                   
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    @if(Auth::user()->role == 'Fsr')
                    <a href="{{ route('meetings.create') }}" class="btn btn-primary mb-3">
                        {{ __('Create new Meeting') }}
                    </a>
                    <a href="{{ route('hidden') }}" class="btn btn-secondary mb-3">
                        {{ __('View Hidden') }}
                    </a>
                    @endif
                    @if(Auth::user()->role == 'user')
                    <a href="{{ route('joinmeetings.create') }}" class="btn btn-secondary mb-3">
                        {{ __('Join Meeting') }}
                    </a>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Name') }}</th>                                
                                <th>{{ __('Location') }}</th>
                                <th>{{ __('Start time') }}</th>
                                <th>{{ __('End time') }}</th>
                                <th>{{ __('Group') }}</th>
                                <th>{{ __('Members') }}</th>
                                <th>{{ __('Hidden') }}</th>
                                <th width="280px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meetings as $meeting)
                            <div class="col-md-4">
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $meeting->name}}</td>
                                    <td>{{ $meeting->location}}</td>
                                    <td>{{ $meeting->start_time}}</td>
                                    <td>{{ $meeting->end_time}}</td>
                                    <td>{{ $meeting->group->topic }}</td>
                                    <td>
                                            @foreach($groupusers as $guser)
                                            @if($guser->group->id == $meeting->group->id)
                                            <p>{{ $guser->user->username}}</p>
                                            @endif
                                            @endforeach
                                    </td>
                                    <td>{{ $meeting->hidden ? __('Yes') : __('No')}}</td>
                                    <td>
                                     <form action="{{ route('meetings.destroy', $meeting->id) }}" method="POST" style="display: inline-block;">
                                        <a class="btn btn-primary" href="{{ route('meetings.show', $meeting->id) }}">
                                            {{ __('View') }}
                                        </a>
                                        
                                        @if(Auth::user()->role == 'Fsr')
                                        <a class="btn btn-info" href="{{ route('meetings.edit', $meeting->id) }}">
                                            {{ __('Edit') }}
                                        </a>
                                        @endif

                                        @method('DELETE')
                                        @csrf
                                        @if(Auth::user()->role == 'Fsr' and $meeting->hidden == ('1'))    
                                        <input type="submit" class="btn btn-danger" value="{{ __('Delete') }}">
                                        @endif                                      
                                     </form>
                                    </td>
                                </tr>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
