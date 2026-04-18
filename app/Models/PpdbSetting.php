<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PpdbSetting extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
        'form_url',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Get the single instance of settings.
     */
    public static function getInstance()
    {
        return self::firstOrCreate(['id' => 1]);
    }

    /**
     * Determine the current status of PPDB based on time.
     * Returns: 'waiting', 'open', 'closing_soon', 'closed'
     */
    public function getStatus()
    {
        // If dates are not set, consider it closed
        if (!$this->start_date || !$this->end_date) {
            return 'closed';
        }

        $now = Carbon::now();

        if ($now->lt($this->start_date)) {
            return 'waiting';
        }

        if ($now->gt($this->end_date)) {
            return 'closed';
        }

        // If it's within 24 hours of closing
        if ($now->diffInHours($this->end_date) <= 24) {
            return 'closing_soon';
        }

        return 'open';
    }
}
