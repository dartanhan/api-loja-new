<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\VendaProdutos;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Throwable;
use NumberFormatter;

class BestSellerController extends Controller
{

    protected $request, $bestSale,$formatter;

    public function __construct(Request $request, VendaProdutos $vendaProdutos){
        $this->request = $request;
        $this->vendaProdutos = $vendaProdutos;
        $this->formatter = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);
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
            //descricao ,qtd vendida no mes, qtd (média 3 ultimos meses) +3%, qtd estoque (atual),falta comprar (media - estoque - menos comprado (botão) )

            $dataCarbon = Carbon::parse(Carbon::now()->format("Y-m-d"));
            $inicioDiaSemana = $dataCarbon->startOfWeek()->format('Y-m-d');
            $fimDiaSemana = $dataCarbon->endOfWeek()->format('Y-m-d');


                $ret =  $this->vendaProdutos
                ->join('loja_produtos_variacao as lpv', 'loja_vendas_produtos.codigo_produto','=', 'lpv.subcodigo')
                ->join('loja_produtos_new as pn', 'lpv.products_id','=', 'pn.id')
                ->select(
                    "loja_vendas_produtos.codigo_produto",
                    "loja_vendas_produtos.descricao",
                    "lpv.quantidade",
                    "lpv.estoque",
                    DB::raw("sum(loja_vendas_produtos.valor_produto * loja_vendas_produtos.quantidade) as valor_produto_total"),
                    DB::raw("sum(loja_vendas_produtos.quantidade) as qtd_tot_mes"),
                )
                ->where(DB::raw('DATE_FORMAT(loja_vendas_produtos.created_at, "%Y%m")'),$date)
                ->whereNotIn("loja_vendas_produtos.troca", [1])
                ->groupBy("loja_vendas_produtos.codigo_produto","loja_vendas_produtos.descricao","lpv.quantidade","lpv.estoque")
                //->orderBy("qtd_tot_mes","desc")
                ->get();

                $responseArray = [];

                foreach ($ret as $key => $value) {
                    $medias = $this->vendaProdutos
                    ->select(
                        'codigo_produto',
                        DB::raw("sum(loja_vendas_produtos.quantidade) as tot_3_meses"),
                        DB::raw("sum(loja_vendas_produtos.quantidade)/3 as qtd_media"))
                    ->whereBetween('created_at', array( "2023-04-01", "2023-07-01"))
                    ->where('codigo_produto' , $value->codigo_produto)
                    ->groupBy('codigo_produto')
                    ->first();


                    $responseArray[$key]['falta_comprar'] = (round($medias->qtd_media) - $value->estoque - $value->quantidade < 0)
                                                                ? 0
                                                                : round($medias->qtd_media) - intVal($value->estoque) - intVal($value->quantidade);
                    $responseArray[$key]['estoque'] = intVal($value->estoque);
                    $responseArray[$key]['codigo_produto'] = $value->codigo_produto;
                    $responseArray[$key]['descricao'] = $value->descricao;
                    $responseArray[$key]['qtd_atual'] = intVal($value->quantidade);
                    $responseArray[$key]['qtd_total_mes'] = intVal($value->qtd_tot_mes);
                    $responseArray[$key]['valor_produto_total'] = $this->formatter->formatCurrency($value->valor_produto_total, 'BRL');
                    $responseArray[$key]['qtd_media_3_meses'] = round($medias->qtd_media);
                    $responseArray[$key]['tot_3_meses'] = round($medias->tot_3_meses);
                }

                return datatables($responseArray)->toJson();


        }catch (Throwable $e){
            return Response::json(array('success' => false, 'message' => $e->getMessage() ), 500);
        }

    }
}
