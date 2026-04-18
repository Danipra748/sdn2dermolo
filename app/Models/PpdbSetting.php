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
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the single instance of settings.
     */
    public static function getInstance()
    {
        return self::firstOrCreate(['id' => 1], [
            'is_active' => true,
        ]);
    }

    /**
     * Determine the current status of PPDB.
     * Returns: 'waiting', 'open', 'closing_soon', 'closed'
     */
    public function getStatus()
    {
        if (!$this->is_active) {
            return 'closed';
        }

        $now = Carbon::now();

        if ($this->start_date && $now->lt($this->start_date)) {
            return 'waiting';
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return 'closed';
        }

        // If it's within 48 hours of closing
        if ($this->end_date && $now->diffInHours($this->end_date) <= 48) {
            return 'closing_soon';
        }

        return 'open';
    }
}
