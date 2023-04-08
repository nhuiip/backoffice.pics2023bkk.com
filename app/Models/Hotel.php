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
 * Class Hotel
 * 
 * @property int $id
 * @property int $seq
 * @property string $name
 * @property string|null $description
 * @property string|null $content
 * @property string|null $content_journey
 * @property string|null $tel
 * @property string|null $email
 * @property string|null $address
 * @property int|null $ranging
 * @property float|null $priceSingle
 * @property float|null $priceDouble
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|HotelImage[] $hotel_images
 *
 * @package App\Models
 */
class Hotel extends Model
{
	use SoftDeletes;
	protected $table = 'hotels';

	protected $casts = [
		'seq' => 'int',
		'ranging' => 'int',
		'priceSingle' => 'float',
		'priceDouble' => 'float'
	];

	protected $fillable = [
		'seq',
		'name',
		'description',
		'content',
		'content_journey',
		'tel',
		'email',
		'address',
		'ranging',
		'priceSingle',
		'priceDouble'
	];

	public function hotel_images()
	{
		return $this->hasMany(HotelImage::class, 'hotelId');
	}
}
