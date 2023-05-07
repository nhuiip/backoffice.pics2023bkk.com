<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Program
 * 
 * @property int $id
 * @property string $name
 * @property string $room
 * @property Carbon|null $date
 * @property Carbon $startTime
 * @property Carbon $endTime
 * @property bool $is_highlight
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Program extends Model
{
	use SoftDeletes;
	protected $table = 'programs';

	protected $casts = [
		'date' => 'datetime',
		'startTime' => 'datetime',
		'endTime' => 'datetime',
		'is_highlight' => 'bool'
	];

	protected $fillable = [
		'name',
		'room',
		'date',
		'startTime',
		'endTime',
		'is_highlight'
	];
}
