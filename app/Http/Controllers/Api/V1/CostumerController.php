<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Costumer;
use Illuminate\Http\Request;
use App\Filters\V1\CostumerFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCostumerRequest;
use App\Http\Resources\V1\CostumerResource;
use App\Http\Requests\V1\UpdateCostumerRequest;
use App\Http\Resources\V1\CostumerCollection;

class CostumerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CostumerFilter();
         // Mendapatkan array kondisi dari URL
        $filterItems = $filter->transform($request); // ['column', 'operator', 'value'] atau [[postalCode[gt]=8400]] postalcode > 8400

         // Mendapatkan nilai 'includeInvoices' dari URL
        $includeInvoices = $request->query('includeinvoices');

        // Membuat query berdasarkan kondisi filter
        $costumers = Costumer::where($filterItems);

        // Jika 'includeInvoices' bernilai true, menggabungkan data invoices dengan eager loading
        if($includeInvoices) {
           $costumers = $costumers->with('invoice');
        }
        
        // Mengembalikan data pelanggan dalam bentuk CostumerCollection
        // Ini juga menyertakan parameter dari URL agar tidak hilang ketika melakukan paginasi
        return new CostumerCollection($costumers->paginate()->appends($request->query()));
        

        // contoh penggunaan filter URL http://127.0.0.1:8000/api/v1/costumers?postalCode[gt]=84800&temail[eq]=obednar@bailey.info



    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCostumerRequest $request)
    {
        return new CostumerResource(Costumer::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Costumer $costumer)
    {
        // Mendapatkan nilai 'includeInvoices' dari URL
        $includeInvoices = request()->query('includeinvoices');

        if($includeInvoices) {
            return new CostumerResource($costumer->loadMissing('invoice'));
        }
        
        return new CostumerResource($costumer);

        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Costumer $costumer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCostumerRequest $request, Costumer $costumer)
    {
        $costumer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Costumer $costumer)
    {
        //
    }
}
