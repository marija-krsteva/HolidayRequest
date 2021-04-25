<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

class HolidayRequest extends Model
{
    use HasFactory;
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
        'start_date',
        'end_date',
        'is_send'
    ];

    /**
     * Fill HolidayRequest with info from user
     *
     * @param User $user
     */
    public function fillFromUser(User $user)
    {
        $user_array = $user->attributesToArray();

        unset(
            $user_array['role'],
            $user_array['email_verified_at'],
            $user_array['created_at'],
            $user_array['updated_at']
        );

        $this->fill($user_array);
    }

    /**
     * Format the given date and return it
     *
     * @param $date
     * @return string
     */
    public function dateFormat($date)
    {
        return Carbon::createFromFormat('d-m-Y H:i', $date)->format('Y-m-d\TH:i');
    }

    public function getStartDateAttribute($value)
    {
          return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d-m-Y H:i');
    }

    public function getEndDateAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d-m-Y H:i');
    }


    /**
     * Update all request that were send - set is_send = 1
     *
     * @param $requests
     */
    static function updateIsSend($requests)
    {
        $requests->each(function ($item){
            $item->update(['is_send'=>1]);
        });
    }

    /**
     * Realtionship with the User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
