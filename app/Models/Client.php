<?php

    namespace App\Models;

    use App\Traits\UuidTrait;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class Client extends Authenticatable
    {
        use Notifiable;

        protected $keyType = 'string';

        protected $guarded = [];

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

        /**
         * Scope filter by active
         *
         * @param $query
         *
         * @return mixed
         */
        public function scopeOnlyActive($query)
        {
            return $query->whereActive(true);
        }
    }
