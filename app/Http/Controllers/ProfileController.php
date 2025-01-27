<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $imagemAntiga = $user->imagem;
        // Atualizar campos validados (nome, telefone, etc.)
        $user->fill($request->validated());

        // Verificar se uma nova imagem foi enviada
        if ($request->hasFile('imagem')) {
            if (!empty($user->imagem) && Storage::disk('public')->exists($imagemAntiga)) {
                Storage::disk('public')->delete($imagemAntiga);
            }
            // Salvar a nova imagem e armazenar o caminho
            $user->imagem = $request->file('imagem')->store('users', 'public');
        }

        // Salvar as alterações no banco de dados
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
