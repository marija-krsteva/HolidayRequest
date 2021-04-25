@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Holiday Request') }}</div>

                    <div class="card-body">
                        @if(isset($request->id))
                            <form method="POST"
                                  action="{{ route('holidayRequests.update', ['holidayRequest' => $request->id]) }}">
                                  @method('PUT')
                        @else
                            <form method="POST" action="{{ route('holidayRequests.store') }}">
                        @endif
                        @csrf

                        <div class="form-group row">
                            <label for="name"
                                   class="col-md-4 col-form-label text-md-right ">{{ __('First name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control @error('firstname') is-invalid @enderror"
                                       name="firstname"
                                       value="{{ old('firstname', $request->firstname) }}"
                                       required autocomplete="firstname" autofocus
                                >

                                @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Last name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control @error('lastname') is-invalid @enderror"
                                       name="lastname" value="{{ old('lastname', $request->lastname) }}"
                                       required autocomplete="lastname" autofocus
                                >

                                @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Phone number') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control @error('phone_number') is-invalid @enderror"
                                       name="phone_number"
                                       value="{{ old('phone_number', $request->phone_number) }}"
                                       autocomplete="phone_number" autofocus
                                >

                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email"
                                   class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email',$request->email) }}"
                                       required autocomplete="email"
                                >

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start_date"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Start date') }}</label>

                            <div class="col-md-6">
                                <input id="start_date" type="datetime-local"
                                       class="form-control @error('start_date') is-invalid @enderror"
                                       name="start_date"
                                       value="{{ old('start_date',$request->start_date_html) }}"
                                       required
                                >
                                @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_date"
                                   class="col-md-4 col-form-label text-md-right">{{ __('End date') }}</label>

                            <div class="col-md-6">
                                <input id="end_date" type="datetime-local"
                                       class="form-control @error('end_date') is-invalid @enderror"
                                       name="end_date"
                                       value="{{ old('end_date',$request->end_date_html) }}" required
                                >
                                @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    @if(isset($request->id))
                                        {{ __('Edit Holiday Request') }}
                                    @else
                                        {{ __('Save Holiday Request') }}
                                    @endif
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
