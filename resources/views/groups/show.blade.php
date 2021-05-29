@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Group') }} {{ $group->topic }}</div>

                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="100">{{ __('Topic') }}</th>
                            <td>{{ $group->topic }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Description') }}</th>
                            <td>{{ $group->description }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Count Limit') }}</th>
                            <td>{{ $group->count_limit }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Group Owner') }}</th>
                            <td>{{ $group->user->username }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Group Members') }}</th>
                            <td>
                                @foreach($groupusers as $guser)
                                @if($guser->group->id == $group->id)
                                <p>{{ $guser->user->username}}</p>
                                @endif
                                @endforeach
                            </td>
                        </tr>
                        

                        

                    </table>

                    <p>
                        <a href="{{ route('groups.index') }}">{{ __('Back to list') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection