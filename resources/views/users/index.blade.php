@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Users Management') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
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
                               <th>username</th>
                               <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="col-md-4">
                                <tr>
                                    <td>{{ Auth::user()->username }}</td>
                                    <td>
                                     <form action="{{ route('users.destroy',Auth::user()->id) }}" method="POST" style="display: inline-block;">                                                
                                        <a class="btn btn-info" href="{{ route('users.edit', Auth::user()->id) }}">
                                            {{ __('Change') }}
                                        </a>                    
                                     </form>
                                    </td>
                                </tr>
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
