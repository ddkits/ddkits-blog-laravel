<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;

class Admin extends Model
{
	protected $table = 'settings';
}
