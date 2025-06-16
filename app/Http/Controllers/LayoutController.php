<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
use App\Models\Layout;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
    public function index()
    {
        $assinaturas = Assinatura::find(auth()->user()->assinaturas()->first()->id);
        $folder = "";
        if($assinaturas->folder) {
            $folder = $assinaturas->folder;
        }

        $layouts = Layout::all();

        return view('layout_imagem.index', [
            "layouts" => $layouts,
            "user" => auth()->user(),
            "folder" => $folder
        ]);
    }

    public function select(Request $request)
    {
        $user = auth()->user();
        $user->layout_id = $request->input('valor');
        if($user->save()) {
            return "sucesso";
        } else {
            return "error";
        }
    }


}
