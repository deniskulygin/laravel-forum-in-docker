<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * @return HasMany
     */
    public function threads(): HasMany
    {
       return $this->hasMany(Thread::class)->latest();
    }

    /**
     * @return HasOne
     */
    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function activity(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * @param Thread $thread
     *
     * @return string
     */
    public function visitedThreadCacheKey(Thread $thread): string
    {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
    }

    /**
     * @param Thread $thread
     *
     * @throws \Exception
     */
    public function read(Thread $thread)
    {
        cache()->forever($this->visitedThreadCacheKey($thread), Carbon::now());
    }
}
