<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RegistrationRate
 * 
 * @property int $id
 * @property string $name
 * @property Carbon $startDate
 * @property Carbon $endDate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|RegistrationFee[] $registration_fees
 *
 * @package App\Models
 */
class RegistrationRate extends Model
{
	protected $table = 'registration_rate';

	protected $casts = [
		'startDate' => 'datetime',
		'endDate' => 'datetime'
	];

	protected $fillable = [
		'name',
		'startDate',
		'endDate'
	];

	public function registration_fees()
	{
		return $this->hasMany(RegistrationFee::class, 'registrationRateId');
	}
}
