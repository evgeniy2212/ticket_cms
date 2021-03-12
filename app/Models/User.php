<?php

    namespace App\Models;

    use App\Traits\UuidTrait;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Spatie\Permission\Traits\HasRoles;

    class User extends Authenticatable
    {
        use Notifiable, HasRoles, SoftDeletes, UuidTrait;

        public $guard_name = 'admin';
        public $incrementing = false;
        protected $keyType = 'string';

        const SUPERADMIN = 'Superadmin';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable
            = [
                'name', 'email', 'phone', 'active',
            ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden
            = [
                'password', 'remember_token',
            ];

        /**
         * The attributes that should be cast to native types.
         *
         * @var array
         */
        protected $casts
            = [
                'email_verified_at' => 'datetime',
            ];
    }
