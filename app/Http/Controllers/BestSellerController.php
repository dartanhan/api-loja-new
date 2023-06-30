<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\VendaProdutos;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class BestSellerController extends Controller
{

    protected $request, $bestSale;

    public function __construct(Request $request, VendaProdutos $bestSale){
        $this->request = $request;
        $this->bestSale = $bestSale;
    }

    public function index()
    {
        try{

           return view('admin.maisvendidos');

        }catch (Throwable $e) {
            return Response::json(array('success' => false, 'message' => $e->getMessage() ), 500);
        }
    }
    


     /**
     * Show the form for editing the specified resource.
     *
     * @param $date
     * @return JsonResponse
     */
    public function edit($date)
    {
        try {
            
            $ret =  $this->bestSale
                ->join('loja_produtos_variacao as lpv', 'loja_vendas_produtos.codigo_produto','=', 'lpv.subcodigo')
                ->join('loja_produtos_new as pn', 'lpv.products_id','=', 'pn.id')
                ->select(
                    "pn.id",
                    "pn.descricao",
                    "pn.codigo_produto",
                    DB::raw("sum(loja_vendas_produtos.quantidade) as quantidade"),
                    DB::raw('DATE_FORMAT(loja_vendas_produtos.created_at, "%m/%Y") as data')
                )
                ->where(DB::raw('DATE_FORMAT(loja_vendas_produtos.created_at, "%Y%m")'),$date)
                ->groupBy("pn.descricao","pn.codigo_produto","pn.id","loja_vendas_produtos.created_at")
                ->orderBy("quantidade","desc")
                ->get();

                
                return datatables($ret)->toJson();
            //return  DataTables::of($ret)->make(true);


        }catch (Throwable $e){
            return Response::json(array('success' => false, 'message' => $e->getMessage() ), 500);
        }

    }
}
