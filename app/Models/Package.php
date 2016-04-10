<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
		'name',
		'disk_space',
		'bandwidth',
		'emails',
		'dbs',
		'sub_domains',
		'parked_domains',
		'addon_domains',
	];
}
