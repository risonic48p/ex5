<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ShortLinksLog
 *
 * @property int $id
 * @property int $link_id
 * @property int $creator_id
 * @property string $user_ip
 * @property Carbon $created_at
 *
 * @property User $user
 * @property ShortLink $short_link
 *
 * @package App\Models
 */
final class ShortLinksLog extends Model
{
	protected $table = 'short_links_logs';
    const UPDATED_AT = null;

	protected $casts = [
		'link_id' => 'int',
		'creator_id' => 'int'
	];

	protected $fillable = [
		'link_id',
		'creator_id',
		'user_ip'
	];

    public function shortinurl(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes)  {
                return 123;
            });
    }


	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, 'creator_id');
	}

	public function shortLink(): BelongsTo
	{
		return $this->belongsTo(ShortLink::class, 'link_id');
	}
}
