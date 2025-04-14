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
    public function update(ProfileUpdateRequest $request)
    {
        {
            try {
                $user = $request->user();
                $imagemAntiga = $user->imagem;

                $user->fill($request->validated());

                if ($request->hasFile('imagem')) {
                    if (!empty($user->imagem) && Storage::disk('public')->exists($imagemAntiga)) {
                        Storage::disk('public')->delete($imagemAntiga);
                    }
                    $user->imagem = $request->file('imagem')->store('users', 'public');
                }
                $user->save();
//                return response()->json([
//                    'success' => true,
//                    'message' => 'Atualizado com sucesso',
//                    'imagem' => $user->imagem ? Storage::url($user->imagem) : null
//                ]);
                return redirect()->back()->with('success', 'Atualizado com sucesso!');
            } catch (\Exception $e) {
//                return response()->json([
//                    'error' => true,
//                    'message' => 'Erro ao atualizar: ' . $e->getMessage()
//                ], 500);
                return redirect()->back()->with('error', 'Erro ao atualizar: ' . $e->getMessage());
            }
        }
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
