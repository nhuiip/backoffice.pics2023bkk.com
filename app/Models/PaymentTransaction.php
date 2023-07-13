<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentTransaction
 * 
 * @property int $id
 * @property int $memberId
 * @property int $transaction_id
 * @property string $payment_url
 * @property float $amount
 * @property string $paylink_token
 * @property Carbon $startDate
 * @property Carbon $expiredDate
 * @property bool $isExpired
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Member $member
 *
 * @package App\Models
 */
class PaymentTransaction extends Model
{
	protected $table = 'payment_transaction';

	protected $casts = [
		'memberId' => 'int',
		'transaction_id' => 'int',
		'amount' => 'float',
		'startDate' => 'datetime',
		'expiredDate' => 'datetime',
		'isExpired' => 'bool'
	];

	protected $hidden = [
		'paylink_token'
	];

	protected $fillable = [
		'memberId',
		'transaction_id',
		'payment_url',
		'amount',
		'paylink_token',
		'startDate',
		'expiredDate',
		'isExpired'
	];

	public function member()
	{
		return $this->belongsTo(Member::class, 'memberId');
	}
}
