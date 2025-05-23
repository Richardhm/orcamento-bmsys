<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request)
    {

        try {
            $validated = $request->validateWithBag('updatePassword', [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', Password::defaults(), 'confirmed'],
            ]);
            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);
            return redirect()->back()->with('success', 'Senha atualizado com sucesso!');
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage());
//            return response()->json([
//                'success' => false,
//                'message' => $e->getMessage(),
//                'errors' => $e->errors()
//            ], 422);
        }

    }
}
