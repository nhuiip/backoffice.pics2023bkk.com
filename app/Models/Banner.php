<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Banner
 * 
 * @property int $id
 * @property int $seq
 * @property int $type
 * @property string|null $url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Banner extends Model
{
	use SoftDeletes;
	protected $table = 'banners';

	protected $casts = [
		'seq' => 'int',
		'type' => 'int'
	];

	protected $fillable = [
		'seq',
		'type',
		'url'
	];
}
