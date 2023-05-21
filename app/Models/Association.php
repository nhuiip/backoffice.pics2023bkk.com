<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Association
 * 
 * @property int $id
 * @property int $countryId
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Country $country
 *
 * @package App\Models
 */
class Association extends Model
{
	use SoftDeletes;
	protected $table = 'associations';

	protected $casts = [
		'countryId' => 'int'
	];

	protected $fillable = [
		'countryId',
		'name'
	];

	public function country()
	{
		return $this->belongsTo(Country::class, 'countryId');
	}
}
