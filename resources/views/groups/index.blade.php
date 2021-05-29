@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Groups') }}</div>

                <div class="card-body">
                    @if(Auth::user()->role == 'user')
                    <a href="{{ route('groups.create') }}" class="btn btn-primary mb-3">
                        {{ __('Create new Group') }}
                    </a>
                    <a href="{{ route('joingroups.index') }}" class="btn btn-secondary mb-3">
                        {{ __('Join Group') }}
                    </a>
                    @endif

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

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
                               <th>No</th>
                               <th>Topic</th>
                               <th>Description</th>
                               <th>Filled/Limit</th>
                               <th>Group Owner</th>                               
                               <th>Members</th>
                               <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @foreach($groups as $group)
                            <div class="col-md-4">
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $group->topic }}</td>
                                    <td>{{ $group->description }}</td>
                                    <td>{{ $group->filled }}/{{ $group->count_limit }}</td>
                                    <td>{{ $group->user->username }}</td>                              
                                    <td>
                                            @foreach($groupusers as $guser)
                                            @if($guser->group->id == $group->id)
                                            <p>{{ $guser->user->username}}</p>
                                            @endif
                                            @endforeach
                                    </td>
                                    <td>
                                     <form action="{{ route('groups.destroy',$group->id) }}" method="POST" style="display: inline-block;">
                                        <a class="btn btn-primary" href="{{ route('groups.show', $group->id) }}">
                                            {{ __('Show') }}
                                        </a>
                 
                                        @if ($group->user_id == (Auth::user()->id))
                                        <a class="btn btn-info" href="{{ route('groups.edit', $group->id) }}">
                                            {{ __('Edit') }}
                                        </a>
                                        @else                  
                                        @endif  
                                        
                                        @method('DELETE')
                                        @csrf 
                                        @if ($group->user_id == (Auth::user()->id)) 
                                        <input type="submit" onclick="return confirm('Are you sure?');"  class="btn btn-danger " value="{{ __('Delete') }}">
                                        @endif   
                                     </form>
                                    </td>
                                </tr>
                            </div>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- {!! $groups->links() !!} -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
