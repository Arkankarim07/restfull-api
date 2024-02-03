<?php
// CostumerFilter adalah kelas yang digunakan untuk menyaring data pelanggan berdasarkan parameter dari URL.
namespace App\Filters\V1;

// Menggunakan kelas induk ApiFilter
use App\Filters\ApiFilter;
use illuminate\Http\Request;

class CostumerFilter extends ApiFilter{
    
    // Daftar parameter yang diizinkan untuk filtering dan operator-operator yang dapat digunakan
    protected $safeParams = [
        'name' => ['eq'], // Equal
        'type'=> ['eq'], // Equal
        'email' => ['eq'], // Equal
        'address' => ['eq'], // Equal
        'city' => ['eq'], // Equal
        'state' => ['eq'], // Equal
        'postalCode' => ['eq', 'gt', 'lt'], // Equal, Greater than, Less than
    ];

    // Pemetaan kolom untuk mengubah nama parameter menjadi nama kolom dalam database
    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    // Pemetaan operator untuk mengubah operator yang digunakan dalam query Eloquent
    protected $operatorMap = [
        'eq' => '=', // Equal
        'gt' => '>', // Greater than
        'lt' => '<', // Less than
        'lte' => '<=', // Less than or equal
        'gte' => '>=', // Greater than or equal
    ];
}