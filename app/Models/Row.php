<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property int $id
 * @property int $excel_id
 * @property string $name
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Row extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'rows';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'excel_id',
        'name',
        'date',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
    ];
}
