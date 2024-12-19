<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class issue extends Model
{
    use HasFactory;
    // Các trường được phép gán giá trị hàng loạt
    protected $fillable = [
        'computer_id',
        'reported_by',
        'reported_date',
        'description',
        'urgency',
        'status',
    ];
    public $timestamps = false;
    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }
}