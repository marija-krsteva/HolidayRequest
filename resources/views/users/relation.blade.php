@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Add relation') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.relations.update', ['user' => $user->id]) }}">
                            @csrf
                            <div class="col-md-6">
                                <span class="font-weight-bold">{{ __('Manager name') }}: {{ $user->firstname }} {{ $user->lastname }}</span>
                            </div>
                            <div class="form-group row">
                                <label for="employee_ids" class="col-md-12 col-form-label text-md-center">{{ __('Choose employees') }}</label>
                                <select id="employee_ids" class="selectpicker" multiple data-actionsBox="true" data-width="100%" name="employee_ids[]">
                                    @foreach($all_employees as $employee)
                                        <option value="{{ $employee->id }}"
                                                @if(in_array($employee->id, $manager_to)) selected @endif
                                        >
                                            {{ $employee->firstname }} {{ $employee->lastname }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary float-right mt-3">
                                        {{ __('Save relations') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
