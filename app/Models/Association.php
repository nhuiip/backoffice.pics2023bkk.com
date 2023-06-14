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
 * @property int $registrantTypeId
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Country $country
 * @property RegistrantType $registrant_type
 *
 * @package App\Models
 */
class Association extends Model
{
	use SoftDeletes;
	protected $table = 'associations';

	protected $casts = [
		'countryId' => 'int',
		'registrantTypeId' => 'int'
	];

	protected $fillable = [
		'countryId',
		'registrantTypeId',
		'name'
	];

	public function country()
	{
		return $this->belongsTo(Country::class, 'countryId');
	}

	public function registrant_type()
	{
		return $this->belongsTo(RegistrantType::class, 'registrantTypeId');
	}
}
