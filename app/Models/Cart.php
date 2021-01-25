<?php

namespace App\Models;

use App\Models\CartChange;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory, Notifiable;

    public function __construct()
    {
        $this->uuid = Str::uuid()->toString();
        parent::__construct();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        ''
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'cartChanges'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];

    public function cartChanges()
    {
        return $this->hasMany(CartChange::class);
    }
}
