<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayRequestRequest;
use App\Models\HolidayRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HolidayRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());

        $requests = $user->holidayRequests()->orderBy('start_date', 'DESC')->get();

        return view('holidayRequests.index',[
            'requests' => $requests,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(Auth::id());
        $request = new HolidayRequest();
        $request->fillFromUser($user);

        return view('holidayRequests.createOrUpdate',['request' => $request]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param HolidayRequestRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(HolidayRequestRequest $request)
    {
        $validated = $request->validated();

        $user = User::find(Auth::id());
        $user->holidayRequests()->create($validated);

        return redirect()->route('holidayRequests.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HolidayRequest $holidayRequest
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(HolidayRequest $holidayRequest)
    {
        $holidayRequest->setAttribute('start_date_html', $holidayRequest->dateFormat($holidayRequest->start_date));
        $holidayRequest->setAttribute('end_date_html', $holidayRequest->dateFormat($holidayRequest->end_date));

        return view('holidayRequests.createOrUpdate',['request' => $holidayRequest]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HolidayRequestRequest $request
     * @param HolidayRequest $holidayRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(HolidayRequestRequest $request, HolidayRequest $holidayRequest)
    {
        $validated = $request->validated();

        $holidayRequest->update($validated);
        return redirect()->route('holidayRequests.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HolidayRequest $holidayRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(HolidayRequest $holidayRequest)
    {
        $holidayRequest->delete();
        return redirect()->route('holidayRequests.index');
    }
}
