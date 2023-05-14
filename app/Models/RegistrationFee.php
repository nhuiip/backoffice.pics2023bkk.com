<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RegistrationFee
 * 
 * @property int $id
 * @property int $registrationRateId
 * @property int $registrantTypeId
 * @property int $registrantGroupId
 * @property float $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property RegistrantGroup $registrant_group
 * @property RegistrantType $registrant_type
 * @property RegistrationRate $registration_rate
 *
 * @package App\Models
 */
class RegistrationFee extends Model
{
	use SoftDeletes;
	protected $table = 'registration_fee';

	protected $casts = [
		'registrationRateId' => 'int',
		'registrantTypeId' => 'int',
		'registrantGroupId' => 'int',
		'price' => 'float'
	];

	protected $fillable = [
		'registrationRateId',
		'registrantTypeId',
		'registrantGroupId',
		'price'
	];

	public function registrant_group()
	{
		return $this->belongsTo(RegistrantGroup::class, 'registrantGroupId');
	}

	public function registrant_type()
	{
		return $this->belongsTo(RegistrantType::class, 'registrantTypeId');
	}

	public function registration_rate()
	{
		return $this->belongsTo(RegistrationRate::class, 'registrationRateId');
	}
}
