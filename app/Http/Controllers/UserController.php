<?php

namespace App\Http\Controllers;

use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect('/home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        if (! Gate::allows('edit-user', $user, $user)) {
            abort(403);
        }
        $roles = User::getRoles();
        $is_admin_current_user = User::find(Auth::id())->isAdmin();

        return view('users.edit',[
            'user' => $user,
            'is_admin_current_user' => $is_admin_current_user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        if (! Gate::any(['edit-user'], $user)) {
            abort(403);
        }

        $request->validate([
            'firstname' => ['required', 'string', 'max:100', 'min:2'],
            'lastname' => ['required', 'string', 'max:100', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone_number' => ['integer','nullable'],
            'role' => 'required|in:' . implode(',', User::getRoles()),
        ]);

        if($user->role !== $request->role) {
            if($user->managers->isNotEmpty()) {
                $user->managers()->detach();
            } elseif ($user->employees->isNotEmpty()) {
                $user->employees()->detach();
            }
        }

        $user->update($request->all());
        return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        if (! Gate::any(['full-access'], $user)) {
            abort(403);
        }
        $user->delete();
        return redirect('/home');
    }

    /**
     * Open edit form for creating relationships between employees and a manager
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function relations(User $user) {
        if (! Gate::any(['full-access'], $user)) {
            abort(403);
        }

        $employee_role = User::getRole('employee');
        $all_employees = User::where('role', $employee_role)->get();
        $manager_to = $user->employees()->pluck('employee_id')->toArray();
        return view('users.relation', [
                'user' => $user,
                'all_employees' => $all_employees,
                'manager_to' => $manager_to,
        ]);
    }

    /**
     * Store / update the relationships between employees and a manager
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function relationsUpdate(Request $request, User $user) {
        if (! Gate::any(['full-access'], $user)) {
            abort(403);
        }
        $request->validate([
            'employee_ids' => ['required', 'employee_ids.*' => 'exists:users,id']
        ]);

        $user->employees()->sync($request->employee_ids);

        return redirect('/home');

    }
}
