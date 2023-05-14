<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RegistrantGroup
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|RegistrationFee[] $registration_fees
 *
 * @package App\Models
 */
class RegistrantGroup extends Model
{
	protected $table = 'registrant_group';

	protected $fillable = [
		'name'
	];

	public function registration_fees()
	{
		return $this->hasMany(RegistrationFee::class, 'registrantGroupId');
	}
}
