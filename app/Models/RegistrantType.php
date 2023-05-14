<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RegistrantType
 * 
 * @property int $id
 * @property string $name
 * @property string $image_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|RegistrationFee[] $registration_fees
 *
 * @package App\Models
 */
class RegistrantType extends Model
{
	protected $table = 'registrant_type';

	protected $fillable = [
		'name',
		'image_url'
	];

	public function registration_fees()
	{
		return $this->hasMany(RegistrationFee::class, 'registrantTypeId');
	}
}
