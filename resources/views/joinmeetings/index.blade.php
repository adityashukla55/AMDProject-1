@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Joined Meeting info') }}</div>

                <div class="card-body">
                    <!-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif -->
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <a href="{{ route('joinmeetings.create') }}" class="btn btn-primary mb-3">
                        {{ __('Join Meeting') }}
                    </a>
                    <a href="{{ route('meetings.index') }}" class="btn btn-secondary mb-3">
                        {{ __('View Meetings') }}
                    </a>
                   

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

                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Meeting') }}</th>
                                <th>{{ __('Group') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th width="280px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groupusers as $groupuser)
                            <div class="col-md-4">
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $groupuser->meeting->name ?? 'Not Created' }}</td>
                                    <td>{{ $groupuser->group->topic }}</td>
                                    <td>{{ $groupuser->user->username }}</td>
                                    <td>{{ $groupuser->joined ? __('Joined') : __('Not joined')}}</td>
                                    <td>
                                    @method('DELETE')
                                    @csrf
                                    @if ($groupuser->joined == ('1'))
                                    <a href="{{ route('leave') }}" type="submit"  class="btn btn-danger" >{{ __('Leave') }}</a>                                                   
                                    @endif
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
