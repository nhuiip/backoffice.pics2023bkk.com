<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProgramsAttachment
 * 
 * @property int $id
 * @property int $programId
 * @property string|null $name
 * @property string|null $file_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Program $program
 *
 * @package App\Models
 */
class ProgramsAttachment extends Model
{
	protected $table = 'programs_attachment';

	protected $casts = [
		'programId' => 'int'
	];

	protected $fillable = [
		'programId',
		'name',
		'file_url'
	];

	public function program()
	{
		return $this->belongsTo(Program::class, 'programId');
	}
}
