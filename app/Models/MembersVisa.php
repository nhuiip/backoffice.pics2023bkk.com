<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MembersVisa
 * 
 * @property int $id
 * @property int $memberId
 * @property string|null $nationality
 * @property string|null $gender
 * @property string|null $identification_number
 * @property string|null $passport_number
 * @property string|null $passport_expiry_date
 * @property string|null $passport_issue_date
 * @property string|null $date_of_birth
 * @property string|null $place_of_birth
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Member $member
 *
 * @package App\Models
 */
class MembersVisa extends Model
{
	protected $table = 'members_visa';

	protected $casts = [
		'memberId' => 'int',
		'start_date' => 'datetime',
		'end_date' => 'datetime'
	];

	protected $fillable = [
		'memberId',
		'nationality',
		'gender',
		'identification_number',
		'passport_number',
		'passport_expiry_date',
		'passport_issue_date',
		'date_of_birth',
		'place_of_birth',
		'start_date',
		'end_date'
	];

	public function member()
	{
		return $this->belongsTo(Member::class, 'memberId');
	}
}
