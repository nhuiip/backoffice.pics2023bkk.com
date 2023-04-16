<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Session
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|PricingMapping[] $pricing_mappings
 *
 * @package App\Models
 */
class Session extends Model
{
	protected $table = 'sessions';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function pricing_mappings()
	{
		return $this->hasMany(PricingMapping::class, 'sessionId');
	}
}
