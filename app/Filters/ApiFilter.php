<?php
// ApiFilter adalah kelas dasar untuk menyaring data berdasarkan parameter dari URL.
namespace App\Filters;

// Menggunakan kelas Request dari Illuminate
use illuminate\Http\Request;

class ApiFilter{
    // Daftar parameter yang diizinkan untuk filtering
    protected $safeParams = [];

    // Pemetaan kolom untuk mengubah nama parameter menjadi nama kolom dalam database
    protected $columnMap = [];

    // Pemetaan operator untuk mengubah operator yang digunakan dalam query Eloquent
    protected $operatorMap = [];
    
    // Metode untuk mengubah parameter dari URL menjadi array query Eloquent
    public function transform(Request $request) {
        $eloQuery = [];
        foreach ($this->safeParams as $parm => $operators) {
            $query = $request->query($parm);

            // Jika nilai parameter tidak ada, lanjutkan ke parameter berikutnya
            if (!isset($query)) {
                continue;
            }

            // Mengambil nama kolom dari pemetaan atau menggunakan nama parameter jika tidak ada pemetaan
            $column = $this->columnMap[$parm] ?? $parm;

            // Iterasi melalui operator-operator yang diizinkan
            foreach ($operators as $operator) {
                // Jika operator tersebut ada dalam nilai parameter, tambahkan kondisi ke dalam array query Eloquent
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }
        // Mengembalikan array query Eloquent
        return $eloQuery;
    }
}