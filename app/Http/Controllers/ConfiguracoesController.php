<?php

namespace App\Http\Controllers;

use App\Models\Administradora;
use App\Models\AdministradoraPlano;
use App\Models\Assinatura;
use App\Models\Desconto;
use App\Models\Pdf;
use App\Models\Plano;
use App\Models\Tabela;
use App\Models\TabelaOrigens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ConfiguracoesController extends Controller
{




    public function index()
    {
        return view('configuracoes.index');
    }

    public function salvarTabela(Request $request)
    {
        foreach($request->valoresApartamento as $k => $v) {
            $tabela = new Tabela();

            $tabela->administradora_id = $request->administradora;
            $tabela->plano_id = $request->planos;
            $tabela->tabela_origens_id = $request->tabela_origem;
            $tabela->acomodacao_id = 1;

            $tabela->coparticipacao = ($request->coparticipacao == "sim" ? true : false);
            $tabela->odonto = ($request->odonto == "sim" ? true : false);
            $tabela->faixa_etaria_id = $k + 1;
            $tabela->valor = str_replace([".",","],["","."],$request->valoresApartamento[$k]);

            if(!$tabela->save()) {
                return "error";
            }
        }

        foreach($request->valoresEnfermaria as $k => $v) {
            $tabela = new Tabela();

            $tabela->administradora_id = $request->administradora;
            $tabela->plano_id = $request->planos;
            $tabela->tabela_origens_id = $request->tabela_origem;
            $tabela->acomodacao_id = 2;

            $tabela->coparticipacao = ($request->coparticipacao == "sim" ? true : false);
            $tabela->odonto = ($request->odonto == "sim" ? true : false);

            $tabela->faixa_etaria_id = $k + 1;
            $tabela->valor = str_replace([".",","],["","."],$request->valoresEnfermaria[$k]);

            if(!$tabela->save()) {
                return "error";
            }
        }

        foreach($request->valoresAmbulatorial as $k => $v) {
            $tabela = new Tabela();

            $tabela->administradora_id = $request->administradora;
            $tabela->plano_id = $request->planos;
            $tabela->tabela_origens_id = $request->tabela_origem;
            $tabela->acomodacao_id = 3;

            $tabela->coparticipacao = ($request->coparticipacao == "sim" ? true : false);
            $tabela->odonto = ($request->odonto == "sim" ? true : false);

            $tabela->faixa_etaria_id = $k + 1;
            $tabela->valor = str_replace([".",","],["","."],$request->valoresAmbulatorial[$k]);


            if(!$tabela->save()) {
                return "error";
            }
        }

        return "sucesso";

    }





    public function cidadeStore(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'uf' => 'required|string|size:2'
        ]);
        TabelaOrigens::create($request->all());
        return redirect()->back()->with('success', 'Cidade cadastrada!');
    }

    public function cidadeDestroy($id)
    {

        try {
            $cidade = TabelaOrigens::findOrFail($id);
            if ($cidade->tabelaModels()->exists()) {
                return redirect()->back()
                    ->with('error', 'Não é possível excluir: cidade possui registros vinculados!');
            }
            TabelaOrigens::destroy($id);
            return redirect()->back()->with('success', 'Cidade excluída!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao excluir: ' . $e->getMessage());
        }

    }

    public function storeAdministradora(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store(
                '', // Não usar subdiretório
                ['disk' => 'administradoras'] // Especificar o disco
            );
            $data['logo'] = 'administradoras/' . $path; // Adiciona o caminho completo
        }

        Administradora::create($data);
        return back()->with('success', 'Administradora cadastrada!');
    }

    public function administradoraDestroy(Administradora $administradora)
    {
        try {
            if ($administradora->dependentes()->exists()) {
                return back()->with('error', 'Existem registros vinculados!');
            }


            if ($administradora->logo) {
                $filename = str_replace('administradoras/', '', $administradora->logo);
                Storage::disk('administradoras')->delete($filename);
            }

            $administradora->delete();
            return back()->with('success', 'Administradora excluída!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro: ' . $e->getMessage());
        }
    }

    public function storePlanos(Request $request)
    {

        $request->validate([
            'nome' => 'required|string|max:255',
            'empresarial' => 'nullable|boolean'
        ]);

        Plano::create([
            'nome' => $request->nome,
            'empresarial' => $request->filled('empresarial')
        ]);

        return back()->with('success', 'Plano cadastrado!');
    }

    public function planosDestroy(Plano $plano)
    {
        try {
            if ($plano->dependentes()->exists()) {
                return back()->with('error', 'Existem registros vinculados!');
            }

            $plano->delete();
            return back()->with('success', 'Plano excluído!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro: '.$e->getMessage());
        }
    }

    public function getCidades(Assinatura $assinatura)
    {
        $todasCidades = TabelaOrigens::all();
        $cidadesVinculadas = $assinatura->cidades()->pluck('tabela_origens.id')->toArray();
        $cidades = $todasCidades->map(function($cidade) use ($cidadesVinculadas) {
            return [
                'id' => $cidade->id,
                'nome' => $cidade->nome,
                'uf' => $cidade->uf,
                'vinculado' => in_array($cidade->id, $cidadesVinculadas)
            ];
        });
        return response()->json(['cidades' => $cidades]);
    }

    public function vincular(Request $request)
    {
        $request->validate([
            'assinatura_id' => 'required|exists:assinaturas,id',
            'cidade_id' => 'required|exists:tabela_origens,id'
        ]);

        $assinatura = Assinatura::find($request->assinatura_id);
        $assinatura->cidades()->syncWithoutDetaching([$request->cidade_id]);

        return response()->json(['success' => true]);
    }

    public function desvincular(Request $request)
    {
        $request->validate([
            'assinatura_id' => 'required|exists:assinaturas,id',
            'cidade_id' => 'required|exists:tabela_origens,id'
        ]);

        $assinatura = Assinatura::find($request->assinatura_id);
        $assinatura->cidades()->detach($request->cidade_id);

        return response()->json(['success' => true]);
    }

    public function storePdf(Request $request)
    {

        $request->merge([
            'linha02' => $request->linha02_part1 . '|' . $request->linha02_part2
        ]);

        $data = $request->validate([
            'plano_id' => 'required|exists:planos,id',
            'tabela_origens_id' => 'nullable|exists:tabela_origens,id',
            'linha01' => 'nullable|string|max:35',
            'linha02_part1' => 'nullable|string|max:35',
            'linha02_part2' => 'nullable|string|max:35',
            'linha03' => 'nullable|string|max:35',
            // Adicionar validação para todos os campos total/parcial
            'consultas_eletivas_total' => 'nullable|string',
            'consultas_de_urgencia_total' => 'nullable|string',
            'exames_simples_total' => 'nullable|string',
            'exames_complexos_total' => 'nullable|string',
            'terapias_especiais_total' => 'nullable|string',
            'demais_terapias_total' => 'nullable|string',
            'internacoes_total' => 'nullable|string',
            'cirurgia_total' => 'nullable|string',
            'consultas_eletivas_parcial' => 'nullable|string',
            'exames_simples_parcial' => 'nullable|string',
            'exames_complexos_parcial' => 'nullable|string',
            'terapias_especiais_parcial' => 'nullable|string',
            'demais_terapias_parcial' => 'nullable|string',
            'internacoes_parcial' => 'nullable|string',
            'cirurgia_parcial' => 'nullable|string',
            'consultas_de_urgencia_parcial' => 'nullable|string',
        ]);
        $data['linha02'] = implode('|', [
            $data['linha02_part1'] ?? '',
            $data['linha02_part2'] ?? ''
        ]);



        Pdf::create($data);
        return back()->with('success', 'Configuração salva!');
    }

    public function editPdf(Pdf $pdf)
    {
        return response()->json($pdf);
    }

    public function updatePdf(Request $request, Pdf $pdf)
    {
        $request->merge([
            'linha02' => $request->linha02_part1 . '|' . $request->linha02_part2
        ]);

        $data = $request->validate([
            'plano_id' => 'required|exists:planos,id',
            'tabela_origens_id' => 'nullable|exists:tabela_origens,id',
            'linha01' => 'nullable|string|max:35',
            'linha02_part1' => 'nullable|string|max:35',
            'linha02_part2' => 'nullable|string|max:35',
            'linha03' => 'nullable|string|max:35',
            'consultas_eletivas_total' => 'nullable|string',
            'consultas_de_urgencia_total' => 'nullable|string',
            'exames_simples_total' => 'nullable|string',
            'exames_complexos_total' => 'nullable|string',
            'terapias_especiais_total' => 'nullable|string',
            'demais_terapias_total' => 'nullable|string',
            'internacoes_total' => 'nullable|string',
            'cirurgia_total' => 'nullable|string',
            'consultas_eletivas_parcial' => 'nullable|string',
            'exames_simples_parcial' => 'nullable|string',
            'exames_complexos_parcial' => 'nullable|string',
            'terapias_especiais_parcial' => 'nullable|string',
            'demais_terapias_parcial' => 'nullable|string',
            'internacoes_parcial' => 'nullable|string',
            'cirurgia_parcial' => 'nullable|string',
            'consultas_de_urgencia_parcial' => 'nullable|string',
        ]);
        $data['linha02'] = implode('|', [
            $data['linha02_part1'] ?? '',
            $data['linha02_part2'] ?? ''
        ]);

        $pdf->update($data);
        return back()->with('success', 'Configuração atualizada!');
    }

    public function destroyPdf(Pdf $pdf)
    {
        $pdf->delete();
        return back()->with('success', 'Coparticipação excluído!');
    }


    public function mudarTabela(Request $request)
    {
        $ta = Tabela::find($request->id);
        $ta->valor = str_replace([".",","],["","."],$request->valor);
        $ta->save();
    }


    public function verificar(Request $request)
    {

        $administradora_id = $request->administradora;
        $plano_id = $request->planos;
        $tabela_origem_id = $request->tabela_origem;
        $coparticipacao = $request->coparticipacao == "sim" ? 1 : 0;
        $odonto = $request->odonto == "sim" ? 1 : 0;



        $tabela = DB::table('tabelas')
            ->where("administradora_id",$administradora_id)
            ->where("tabela_origens_id",$tabela_origem_id)
            ->where("plano_id",$plano_id)
            ->where("coparticipacao",$coparticipacao)
            ->where("odonto",$odonto)
            ->select("acomodacao_id", "valor","id")
            ->get();



        if($tabela->count() >= 1) {
            $ta = $tabela->map(function ($item) {

                $item->valor_formatado = number_format($item->valor, 2, ',', '.');
                return $item;
            });
            return $ta;
        } else {
            return "empty";
        }
    }

    public function salvar(Request $request)
    {

    }


    public function storeDesconto(Request $request)
    {



        $request->validate([
            'planos' => 'required|array|min:1',
            'planos.*' => 'exists:planos,id',
            'cidades' => 'required|array|min:1',
            'cidades.*' => 'exists:tabela_origens,id',
            'valor' => 'nullable|numeric|min:0',
            'administradora' => 'required|array|min:1',
            'administradora.*' => 'exists:administradoras,id',
        ]);

        try {
            foreach ($request->planos as $planoId) {
                foreach ($request->cidades as $cidadeId) {
                    foreach ($request->administradora as $administradoraId) {
                        Desconto::updateOrCreate(
                            [
                                'plano_id' => $planoId,
                                'tabela_origens_id' => $cidadeId,
                                'administradora_id' => $administradoraId
                            ],
                            ['valor' => $request->valor]
                        );
                    }
                }
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro: ' . $e->getMessage()
            ]);
        }
    }

    public function destroyDesconto(Desconto $desconto)
    {
        $desconto->delete();
        return back()->with('success', 'Desconto excluído!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'assinatura_id' => 'required|array',
            'administradora_id' => 'required|array',
            'plano_id' => 'required|array',
            'tabela_origem_id' => 'nullable|array',
        ]);

        $assinaturas = $request->assinatura_id;
        $administradoras = $request->administradora_id;
        $planos = $request->plano_id;
        $tabelas = $request->tabela_origem_id ?? [];

        $inserts = [];

        foreach ($assinaturas as $assinaturaId) {
            foreach ($administradoras as $administradoraId) {
                foreach ($planos as $planoId) {
                    foreach ($tabelas as $tabelaId) {

                        // Verifica se já existe antes de adicionar no array
                        $exists = AdministradoraPlano::where([
                            'administradora_id' => $administradoraId,
                            'plano_id' => $planoId,
                            'tabela_origens_id' => $tabelaId,
                            'assinatura_id' => $assinaturaId
                        ])->exists();

                        if (!$exists) {
                            $inserts[] = [
                                'administradora_id' => $administradoraId,
                                'plano_id' => $planoId,
                                'tabela_origens_id' => $tabelaId,
                                'assinatura_id' => $assinaturaId,
                                'created_at' => now(),  // Necessário se sua tabela usa timestamps
                                'updated_at' => now(),
                            ];
                        }
                    }
                }
            }
        }

        if (!empty($inserts)) {
            AdministradoraPlano::insert($inserts);
        }

        return response()->json(['success' => 'Associações criadas com sucesso!']);
    }



    public function destroy($id)
    {
        $vinculo = AdministradoraPlano::findOrFail($id);
        $vinculo->delete();

        return back()->with('success', 'Associação removida!');
    }





}
