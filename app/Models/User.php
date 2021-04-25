<?php

namespace App\Models;

use App\Exports\HolidayRequestsExport;
use App\Mail\holidayRequests;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'phone_number',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Called before removing an user, to remove all relations
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user) { // before delete() method call this
            $user->managers()->delete();
            $user->employees()->delete();
            $user->holidayRequests()->delete();
        });
    }

    /**
     * Defining the roles
     */
    private const ROLES = [
        'employee' => 'employee',
        'manager' => 'manager',
        'admin' => 'admin'
    ];

    /**
     * Returns a role
     *
     * @param $role
     * @return string
     */
    static function getRole($role): string
    {
        return self::ROLES[$role];
    }

    /**
     * Returns all roles
     *
     * @return string[]
     */
    static function getRoles(): array
    {
        return self::ROLES;
    }

    /**
     * Checks if a user has a role
     * @param $role_key
     * @return bool
     */
    public function hasRole($role_key): bool
    {
        return $this->role === self::ROLES[$role_key];
    }

    /**
     * Checks if given user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Filtering needed for Home page, what users can see based on their role
     * If no users are found, or the user has an undefined role,
     * the function returns a new collection
     *
     * @return User[]|Collection|BelongsToMany
     */
    public function filterUsers()
    {
        if ($this->hasRole('admin')) {
            $users = User::all();
        } elseif ($this->hasRole('manager')) {
            $users = $this->employees()->get();
        } elseif ($this->hasRole('employee')) {
            $users = $this->managers()->get();
        } else {
            return (new User)->newCollection();
        }

        if ($users->count() === 0) {
            $users = (new User)->newCollection();
        }

        return $users;

    }

    /**
     * Logic for creating and mailing .csv files - Holiday Requests to all managers
     */
    static function sendRequests()
    {
        // Grab all managers
        $managers = User::where('role', User::getRole('manager'))->get();
        // Today's date
        $date = Carbon::now()->format('d_m_Y');
        // Create a new folder named by today's date
        Storage::disk('local')->makeDirectory('holidayRequests/' . $date);
        $all_requests = new Collection();

        foreach ($managers as $manager) {
            if ($manager->employees->isNotEmpty()) {
                $manager_requests = new Collection();
                foreach ($manager->employees as $employee) {
                    if ($employee->holidayRequests->isNotEmpty() &&
                        $employee->holidayRequests()->whereIsSend(0)->get(['firstname','lastname'])->isNotEmpty()) {
                        $manager_requests = $manager_requests->concat(
                            $employee->holidayRequests()->whereIsSend(0)->get()
                        );
                    }
                }

                if ($manager_requests->isNotEmpty()) {
                    // Define a path where the .csv file will be saved
                    $path = "holidayRequests/{$date}/{$date}_{$manager->firstname}_{$manager->lastname}.csv";
//                    //Create and store the .csv file
                    Excel::store(new HolidayRequestsExport($manager_requests), $path);
//                    // Send the .csv to the manager
                    Mail::to($manager->email)->send(new holidayRequests($manager, $path, $date));
                    $all_requests = $all_requests->concat($manager_requests);
                }
            }
        }

        if ($all_requests->isNotEmpty()) {
            // Update all request that were send and set is_set = 1
            HolidayRequest::updateIsSend($all_requests);
        }
        // if no files were created,delete the folder
        if (count(Storage::files($date)) === 0) {
            Storage::deleteDirectory($date);
        }
    }

    // Relationships

    /**
     * Many to many relationship with table employee_manager,
     * returns all managers related to an employee
     *
     * @return BelongsToMany
     */
    public function managers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'employee_manager',
            'employee_id',
            'manager_id'
        )->withTimestamps();
    }

    /**
     * Many to many relationship with table employee_manager,
     * returns all employees related to a manager
     *
     * @return BelongsToMany
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'employee_manager',
            'manager_id',
            'employee_id'
        )->withTimestamps();

    }

    /**
     * One to many relationship, return all holiday requests
     * related to an employee
     *
     * @return HasMany
     */
    public function holidayRequests(): HasMany
    {
        return $this->hasMany(HolidayRequest::class);
    }

    /**
     * One to many relationship, return all holiday requests
     * related to an employee
     *
     * @return HasMany
     */
    public function holidayRequestsForMail(): HasMany
    {
        return $this->hasMany(HolidayRequest::class)->with(['firstname','lastname','email','phone_number','start_date','end_date']);
    }


}
