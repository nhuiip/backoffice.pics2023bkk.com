<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HotelImage
 * 
 * @property int $id
 * @property int $hotelId
 * @property bool $is_cover
 * @property string $image_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Hotel $hotel
 *
 * @package App\Models
 */
class HotelImage extends Model
{
	protected $table = 'hotel_image';

	protected $casts = [
		'hotelId' => 'int',
		'is_cover' => 'bool'
	];

	protected $fillable = [
		'hotelId',
		'is_cover',
		'image_url'
	];

	public function hotel()
	{
		return $this->belongsTo(Hotel::class, 'hotelId');
	}
}
