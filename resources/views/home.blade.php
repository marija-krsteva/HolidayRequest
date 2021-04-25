@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>{{__('First name')}}</th>
                    <th>{{__('Last name')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Phone number')}}</th>
                    @if($current_user_role === 'admin')
                    <th>{{__('Role')}}</th>
                    <th>{{__('Action')}}</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->firstname}}</td>
                            <td>{{$user->lastname}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone_number}}</td>
                            @if($current_user_role === 'admin')
                                <td>{{$user->role}}</td>
                                <td>
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="admin-actions">
                                        @if($user->hasRole('manager'))
                                            <a href="{{route('users.relations',[$user->id])}}" class="btn btn-info"><i class="bi bi-diagram-3"></i></a>
                                        @endif

                                        <a href="{{route('users.edit',[$user->id])}}" class="btn btn-warning"><i class="bi bi-pencil-square" role="img" aria-label="Edit"></i></a>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUser">
                                            <i class="bi bi-x-square" role="img" aria-label="Delete"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="deleteUserLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteUserLabel">{{__('Delete user')}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{__('Are you sure?')}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('No')}}</button>
                                                        <form method="POST" action="{{ route('users.destroy',[$user->id])}} }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                {{ __('Yes') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>{{__('First name')}}</th>
                    <th>{{__('Last name')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Phone number')}}</th>
                    @if($current_user_role === 'admin')
                        <th>{{__('Role')}}</th>
                        <th>{{__('Action')}}</th>
                    @endif
                </tr>
                </tfoot>
            </table>
            <div id="actions">
                @if($current_user_role === 'employee')
                    <a href="{{route('holidayRequests.index',[Auth::user()->id])}}" class="btn btn-warning"><i class="bi bi-calendar-range"></i> {{__('See holiday requests')}}</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
