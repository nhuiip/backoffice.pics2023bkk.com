<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Pricing
 * 
 * @property int $id
 * @property string $name
 * @property string $image_iimg
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|PricingMapping[] $pricing_mappings
 *
 * @package App\Models
 */
class Pricing extends Model
{
	use SoftDeletes;
	protected $table = 'pricing';

	protected $fillable = [
		'name',
		'image_iimg'
	];

	public function pricing_mappings()
	{
		return $this->hasMany(PricingMapping::class, 'pricingId');
	}
}
