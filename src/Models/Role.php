<?php

namespace Probytech\Proadmin\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table = 'roles';

    public const ADMIN = 1;
    public const USER = 2;

	protected $fillable = [
		'title',
	];
}
