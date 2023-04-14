<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class News
 * 
 * @property int $id
 * @property string $name
 * @property string $content
 * @property string|null $image_url
 * @property bool $is_announcement
 * @property int $visit
 * @property int $favorite
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class News extends Model
{
	use SoftDeletes;
	protected $table = 'news';

	protected $casts = [
		'is_announcement' => 'bool',
		'visit' => 'int',
		'favorite' => 'int'
	];

	protected $fillable = [
		'name',
		'content',
		'image_url',
		'is_announcement',
		'visit',
		'favorite'
	];
}
