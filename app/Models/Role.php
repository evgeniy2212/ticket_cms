<?php

    namespace App\Models;

    use Spatie\Permission\Models\Role as RoleModel;
    use Spatie\Permission\Guard;

    class Role extends RoleModel
    {
        public $guard_name = 'admin';
        protected $keyType = 'string';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable
            = [
                'name', 'guard_name', 'active',
            ];

        /**
         * Find a role by its names and guard name.
         *
         * @param array       $names
         * @param string|null $guardName
         *
         * @return \Spatie\Permission\Contracts\Role|RoleModel
         *
         */
        public static function findByNames(array $names, $guardName = null)
        {
            $guardName = $guardName ?? Guard::getDefaultName(static::class);
            $roles     = static::whereIn('name', $names)->where('guard_name', $guardName)->get();

            return $roles;
        }
    }
