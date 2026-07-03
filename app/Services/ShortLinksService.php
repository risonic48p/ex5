<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\ShortLink;
use App\Models\ShortLinksLog;


final class ShortLinksService
{

    private ?ShortLink $linkRecord;
    private string $hash;
    private string $ip;
    public function __construct(string $hash, string $ip)
    {
        $this->hash = $hash;
        $this->ip = $ip;
    }

    public static function init(string $hash, string $ip): self
    {
        return new self($hash, $ip);
    }

    public function proceed(): self
    {
        if($this->getRecord())
        {
            ShortLinksLog::query()->insert([
                'link_id' => $this->linkRecord->id,
                'creator_id' => $this->linkRecord->user_id,
                'user_ip' => $this->ip,
            ]);

        }

        return $this;
    }

    public function getUrl(): ?string
    {
        $res = null;
        if($this->linkRecord)
        {
            $res = $this->linkRecord->url;
        }
        return $res;
    }

    private function getRecord(): ?string
    {
        if (empty($this->linkRecord)) {
            $this->linkRecord = Cache::remember('ShortLinks-' . $this->hash, 1800, function () {
                $res = ShortLink::query()->where('hash', $this->hash)->first();
                return $res;
            });
        }
        return $this->linkRecord;
    }


}
