<?php

namespace App\Models;

use App\Jobs\AuthJobs\ResetPasswordJobs;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

protected $guard_name = 'web';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    

     /**
     * static boot di bawah ini membuat suatu value di insert scara otomatis tanpa harus di insert melalui insert command
     * jadi walaupun kita kita memasukan default value ke dalam sepefik cloumn maka, funcsi di bawah ini akan memasukan secara
     * otomatis (seperti initate value before insert)
     */
    protected static function boot() {
        parent::boot();

        static::creating(function($model){
            if(empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }
    
    public function sendPasswordResetNotification($token)
    {
        
        $url = env('APP_URL').'/auth/public/reset-new-password?token='.$token.'&email='.$this->email;   

        ResetPasswordJobs::dispatch($this,$url)->onQueue('resetEmailNotif');
   
    }
}
