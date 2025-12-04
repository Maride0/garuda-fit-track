<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expenses_code',
        'expense_date',
        'applicant_name',
        'type',
        'amount',
        'description',
        'status',
        'receipt',
    ];

    public static function getExpensesCode()
    {
        $lastCode = self::max('expenses_code') ?? 'EXP000';
        $lastNumber = intval(substr($lastCode, -3));
        $next = $lastNumber + 1;

        return 'EXP' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }

}