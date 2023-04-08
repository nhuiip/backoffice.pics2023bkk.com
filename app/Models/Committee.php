<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Committee
 * 
 * @property int $id
 * @property string $name
 * @property string $position
 * @property string $organization
 * @property int $seq
 * @property string $image_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Committee extends Model
{
	use SoftDeletes;
	protected $table = 'committees';

	protected $casts = [
		'seq' => 'int'
	];

	protected $fillable = [
		'name',
		'position',
		'organization',
		'seq',
		'image_url'
	];
}
