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
 * @property string|null $tel
 * @property string|null $email
 * @property string|null $address
 * @property string|null $google_map
 * @property string|null $roomrate
 * @property string|null $remark
 * @property int|null $ranging
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
		'ranging' => 'int'
	];

	protected $fillable = [
		'seq',
		'name',
		'description',
		'content',
		'tel',
		'email',
		'address',
		'google_map',
		'roomrate',
		'remark',
		'ranging'
	];

	public function hotel_images()
	{
		return $this->hasMany(HotelImage::class, 'hotelId');
	}
}
