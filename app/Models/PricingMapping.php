<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PricingMapping
 * 
 * @property int $id
 * @property int $pricingId
 * @property int $sessionId
 * @property float $price
 * @property bool $invited
 * @property int|null $invited_person
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Pricing $pricing
 * @property Session $session
 *
 * @package App\Models
 */
class PricingMapping extends Model
{
	protected $table = 'pricing_mapping';

	protected $casts = [
		'pricingId' => 'int',
		'sessionId' => 'int',
		'price' => 'float',
		'invited' => 'bool',
		'invited_person' => 'int'
	];

	protected $fillable = [
		'pricingId',
		'sessionId',
		'price',
		'invited',
		'invited_person'
	];

	public function pricing()
	{
		return $this->belongsTo(Pricing::class, 'pricingId');
	}

	public function session()
	{
		return $this->belongsTo(Session::class, 'sessionId');
	}
}
