<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\VendaProdutos;
use Yajra\DataTables\Services\DataTable;

class BestSellerController extends Controller
{

    protected $request, $bestSale;

    public function __construct(Request $request, VendaProdutos $bestSale){
        $this->request = $request;
        $this->bestSale = $bestSale;
    }

    public function index()
    {
       $bestSales = $this->bestSale->paginate(15);

       print_r( $bestSales);
       exit;

        return view('admin.maisvendidos',compact('bestSales'));
    }
}
