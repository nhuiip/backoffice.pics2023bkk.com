<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Session
 * 
 * @property int $id
 * @property string $name
 *
 * @package App\Models
 */
class Session extends Model
{
	protected $table = 'sessions';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];
}
