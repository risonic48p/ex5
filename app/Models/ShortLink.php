<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ShortLink
 *
 * @property int $id
 * @property string $url
 * @property string $hash
 * @property int $user_id
 * @property Carbon $created_at
 *
 * @property Collection|ShortLinksLog[] $short_links_logs
 *
 * @package App\Models
 */
final class ShortLink extends Model
{
	protected $table = 'short_links';
    const UPDATED_AT = null;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'url',
		'hash',
		'user_id'
	];

    public function shortUrl(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes)  {
                return route('short.redirect', ['hash' => $attributes['hash']]);
            });
    }

	public function shortLinksLogs(): HasMany
	{
		return $this->hasMany(ShortLinksLog::class, 'link_id');
	}
}
