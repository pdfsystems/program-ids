<?php

namespace App\Models;

use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'application',
        'user_id',
        'name',
        'description',
        'application_program_id',
    ];

    protected $casts = [
        'application_program_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @throws LockTimeoutException
     */
    public static function getNextApplicationProgramId(string $key): int
    {
        return Cache::lock("programs:{$key}:next_id", 10)->block(5, function () use ($key) {
            $maxId = self::where('application', $key)
                ->max('application_program_id') ?? 0;

            return $maxId + 1;
        });
    }
}
