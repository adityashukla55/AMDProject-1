@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Meeting') }} {{ $meeting->name }}</div>

                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="100">{{ __('Name') }}</th>
                            <td>{{ $meeting->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Location') }}</th>
                            <td>{{ $meeting->location }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Start Date') }}</th>
                            <td>{{ $meeting->start_time }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('End Date') }}</th>
                            <td>{{ $meeting->end_time }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Group') }}</th>
                            <td>{{ $meeting->group->topic }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Group Owner') }}</th>
                            <td>{{ $meeting->group->user->username }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Members') }}</th>
                            <td>
                                    @foreach($groupusers as $guser)
                                    @if($guser->group->id == $meeting->group->id)
                                    <p>{{ $guser->user->username}}</p>
                                    @endif
                                    @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('Hidden') }}</th>
                            <td>{{ $meeting->hidden ? __('Yes') : __('No') }}</td>
                        </tr>
                       
                    </table>

                    <p>
                        <a href="{{ route('meetings.index') }}">{{ __('Back to list') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
