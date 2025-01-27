<?php

namespace App\Http\Controllers;

use App\Models\Layout;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
    public function index()
    {
        $layouts = Layout::all(); // Obter todos os layouts
        return view('layout_imagem.index', [
            "layouts" => $layouts,
            "user" => auth()->user()
        ]);
    }

    public function select(Request $request)
    {
        $user = auth()->user();
        $user->layout_id = $request->input('layout_id');
        $user->save();
        return redirect()->back()->with('success', 'Layout selecionado com sucesso!');
    }


}
