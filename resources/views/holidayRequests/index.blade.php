@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>{{__('Date From')}}</th>
                        <th>{{__('Date To')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requests as $request)
                        <tr>
                            <td>{{$request->start_date}}</td>
                            <td>{{$request->end_date}}</td>
                            @if(!$request->is_send)
                                <td>
                                    <div class="btn-group float-right" role="group" aria-label="admin-actions">

                                        <a href="{{route('holidayRequests.edit',[$request->id])}}" class="btn btn-warning"><i class="bi bi-pencil-square" role="img" aria-label="Edit"></i></a>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteRequest{{$request->id}}">
                                            <i class="bi bi-x-square" role="img" aria-label="Delete"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteRequest{{$request->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteRequestLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteRequestLabel">{{__('Delete holiday request')}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{__('Are you sure?')}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('No')}}</button>
                                                        <form method="POST" action="{{ route('holidayRequests.destroy',[$request->id]) }}">
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
                            @else
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>{{__('Date From')}}</th>
                        <th>{{__('Date To')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                    </tfoot>
                </table>
                <div id="actions">
                    <a href="{{route('holidayRequests.create')}}" class="btn btn-warning"><i class="bi bi-calendar-range"></i> {{__('Create new')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
