<?php

namespace App\Http\Controllers;

use App\Models\Administradora;
use App\Models\Layout;
use App\Models\Plano;
use App\Models\Tabela;
use App\Models\Pdf;
use App\Models\TabelaOrigens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDFFile;

class DashboardController extends Controller
{
    public function index()
    {
//        $base64Image = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/".auth()->user()->imagem)));
//        dd($base64Image);



        //echo "";
        //return;
        $cidades = TabelaOrigens::all();
        $administradoras = Administradora::all();
        $planos = Plano::all();
        return view('dashboard',[
            'cidades' => $cidades,
            'administradoras' => $administradoras,
            'planos' => $planos
        ]);
    }

    public function buscar_planos(Request $request)
    {

        $administradora_id = $request->input('administradora_id');
        $tabela_origens_id = $request->input('tabela_origens_id');
        $planos = DB::table('administradora_planos')
            ->where('administradora_id', $administradora_id)
            ->where('tabela_origens_id', $tabela_origens_id)
            ->pluck('plano_id');
        return response()->json(['planos' => $planos]);
    }

    public function orcamento(Request $request)
    {
        $ambulatorial = $request->ambulatorial;
        $sql = "";
        $chaves = [];
        foreach(request()->faixas[0] as $k => $v) {
            if($v != null AND $v != 0) {
                $sql .= " WHEN tabelas.faixa_etaria_id = {$k} THEN ${v} ";
                $chaves[] = $k;
            }
        }

        $keys = implode(",",$chaves);
        $cidade = request()->tabela_origem;
        $plano = request()->plano;
        $operadora = request()->operadora;
        $imagem_operadora = Administradora::find($operadora)->logo;
        $plano_nome = Plano::find($plano)->nome;
        $imagem_plano = Administradora::find($operadora)->logo;
        $cidade_nome = TabelaOrigens::find($cidade)->nome;
        if($ambulatorial == 0) {
            $dados = Tabela::select('tabelas.*')
                ->selectRaw("CASE $sql END AS quantidade")
                ->join('faixa_etarias', 'faixa_etarias.id', '=', 'tabelas.faixa_etaria_id')
                ->where('tabelas.tabela_origens_id', $cidade)
                ->where('tabelas.plano_id', $plano)
                ->where('tabelas.administradora_id', $operadora)
                //->where('acomodacao_id',"!=",3)
                ->whereIn('tabelas.faixa_etaria_id', explode(',', $keys))
                ->get();

            $status = $dados->contains('odonto', 0);
            return view("cotacao.cotacao2",[
                "dados" => $dados,
                "operadora" => $imagem_operadora,
                "plano_nome" => $plano_nome,
                "cidade_nome" => $cidade_nome,
                "imagem_plano" => $imagem_plano,
                "status" => $status
            ]);

        } else {
            $dados = Tabela::select('tabelas.*')
                ->selectRaw("CASE $sql END AS quantidade")
                ->join('faixa_etarias', 'faixa_etarias.id', '=', 'tabelas.faixa_etaria_id')
                ->where('tabelas.tabela_origens_id', $cidade)
                ->where('tabelas.plano_id', $plano)
                ->where('tabelas.administradora_id', $operadora)
                ->where('acomodacao_id',"=",3)
                ->whereIn('tabelas.faixa_etaria_id', explode(',', $keys))
                ->get();
            //return $dados;
            $status = $dados->contains('odonto', 0);
            return view("cotacao.cotacao-ambulatorial",[
                "dados" => $dados,
                "operadora" => $imagem_operadora,
                "plano_nome" => $plano_nome,
                "cidade_nome" => $cidade_nome,
                "imagem_plano" => $imagem_plano,
                "status" => $status
            ]);
        }
    }

    public function criarPDF()
    {

        $layout = Layout::find(auth()->user()->layout_id);
        $ambulatorial = request()->ambulatorial;
        $cidade = request()->tabela_origem;
        $plano = request()->plano;
        $operadora = request()->operadora;
        $odonto = request()->odonto;
        $sql = "";
        $chaves = [];
        $linhas = 0;

        foreach(request()->faixas[0] as $k => $v) {
            if($v != null AND $v != 0) {
                $sql .= " WHEN tabelas.faixa_etaria_id = {$k} THEN ${v} ";
                $chaves[] = $k;
            }
        }


        $linhas = count($chaves);
        $cidade_nome = TabelaOrigens::find($cidade)->nome;
        $plano_nome = Plano::find($plano)->nome;

        $cidade_uf = TabelaOrigens::find($cidade)->uf;
        $status_excecao = false;
        if(($cidade_uf == "MT" || $cidade_uf == "MS") && $plano == 3) {
            $status_excecao = true;
            $pdf_copar = PdfExcecao::where('plano_id', $plano)->first();
        } else {
            $hasTabelaOrigens = Pdf::where('plano_id', $plano)
                ->where('tabela_origens_id',$cidade)
                ->exists();
            if ($hasTabelaOrigens) {
                $pdf_copar = Pdf::where('plano_id', $plano)
                    ->where('tabela_origens_id',$cidade)
                    ->first();
            } else {
                $pdf_copar = Pdf::where('plano_id', $plano)->first();
            }
        }

        $admin_nome = Administradora::find($operadora)->nome;
        $odonto_frase = $odonto == 1 ? " c/ Odonto" : " s/ Odonto";
        $frase = $plano_nome.$odonto_frase;
        $keys = implode(",",$chaves);
        $image_user = "";
        if(auth()->user()->imagem) {
            //$image_user = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path(auth()->user()->image)));
            //$image_user = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/".auth()->user()->imagem)));
            $image_user = public_path("storage/".auth()->user()->imagem);
        }
        $nome = auth()->user()->name;
        $celular = auth()->user()->phone;
        $corretora = auth()->user()->corretora_id;
        $status_carencia = request()->status_carencia == "true" ? 1 : 0;
        $status_desconto = request()->status_desconto == "true" ? 1 : 0;
        if($ambulatorial == 0) {
            $dados = Tabela::select('tabelas.*')
                ->selectRaw("CASE $sql END AS quantidade")
                ->join('faixa_etarias', 'faixa_etarias.id', '=', 'tabelas.faixa_etaria_id')
                ->where('tabelas.tabela_origens_id', $cidade)
                ->where('tabelas.plano_id', $plano)
                ->where('tabelas.administradora_id', $operadora)
                ->where("tabelas.odonto",$odonto)
                ->where("acomodacao_id","!=",3)
                ->whereIn('tabelas.faixa_etaria_id', explode(',', $keys))
                ->get();

            //dd($image_user);

            //$carencias = Carencia::where("plano_id",$plano)->get();
            $base64Image = "";
            $view = \Illuminate\Support\Facades\View::make("cotacao.cotacao3",[
                'base64Image' => $base64Image,
                'layout' => $layout,
                'carencias' => "",
                'image' => $image_user,
                'dados' => $dados,
                'pdf' => $pdf_copar,
                'nome' => $nome,
                'cidade' => $cidade_nome,
                'plano_nome' => $plano_nome,
                'odonto_frase' => $odonto_frase,
                'administradora' => $admin_nome,
                'frase' => $frase,
                'status_carencia' => $status_carencia,
                'status_desconto' => $status_desconto,
                'odonto' => $odonto,
                'celular' => $celular,
                'status_excecao' => $status_excecao,
                'linhas' => $linhas,
                'corretora' => $corretora
            ]);
            $pdf = PDFFile::loadHTML($view);
            return $pdf->stream("teste.pdf");




        } else {

            $dados = Tabela::select('tabelas.*')
                ->selectRaw("CASE $sql END AS quantidade")
                ->join('faixa_etarias', 'faixa_etarias.id', '=', 'tabelas.faixa_etaria_id')
                ->where('tabelas.tabela_origens_id', $cidade)
                ->where('tabelas.plano_id', $plano)
                ->where('tabelas.administradora_id', $operadora)
                ->where("tabelas.odonto",$odonto)
                ->where("acomodacao_id","=",3)
                ->whereIn('tabelas.faixa_etaria_id', explode(',', $keys))
                ->get();
            $hasTabelaOrigens = Pdf::where('plano_id', $plano)
                ->where('tabela_origens_id',$cidade)
                ->exists();
            if ($hasTabelaOrigens) {
                $pdf_copar = Pdf::where('plano_id', $plano)
                    ->where('tabela_origens_id',$cidade)
                    ->first();
            } else {
                $pdf_copar = Pdf::where('plano_id', $plano)->first();
            }
            $view = \Illuminate\Support\Facades\View::make("cotacao.cotacao-ambulatorial-pdf",[
                'image' => $image_user,
                'dados' => $dados,
                'pdf' => $pdf_copar,
                'nome' => $nome,
                'cidade' => $cidade_nome,
                'plano' => $plano_nome,
                'odonto_frase' => $odonto_frase,
                'administradora' => $admin_nome,
                'frase' => $frase,
                'status_carencia' => $status_carencia,
                'status_desconto' => $status_desconto,
                'odonto' => $odonto,
                'celular' => $celular,
                'linhas' => $linhas,
                'corretora' => $corretora
            ]);
            $pdf = PDFFile::loadHTML($view);
            return $pdf->stream("teste.pdf");
        }
    }




}
