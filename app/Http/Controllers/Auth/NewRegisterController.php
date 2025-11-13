<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NewRegisterController extends Controller
{
    public function showForm()
    {
        // Página abierta, sin token
        return view('auth.new-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'    => ['required','email'],
            // 'name'     => ['required','string','max:255'],
            'password' => ['required','confirmed','min:8'],
        ], [
            'email.required' => 'Ingresa tu correo.',
            'email.email'    => 'Correo inválido.',
        ]);

        $user = User::where('email', $request->email)->first();

        // 1) ¿Existe el correo?
        if (!$user) {
            return back()->withErrors([
                'email' => 'No encontramos una invitación para este correo.',
            ])->withInput($request->except('password','password_confirmation'));
        }

        // 2) ¿Ya tiene contraseña?
        if (!empty($user->password)) {
            return back()->withErrors([
                'email' => 'Este correo ya tiene contraseña registrada. Usa Iniciar sesión o Recuperar contraseña.',
            ])->withInput($request->except('password','password_confirmation'));
        }

        // 3) ¿Tiene invitation_token activo?
        if (empty($user->invitation_token)) {
            return back()->withErrors([
                'email' => 'Este correo no tiene una invitación activa.',
            ])->withInput($request->except('password','password_confirmation'));
        }

        // OK: completar registro
        // $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->invitation_token = null;   // invalidar invitación
        $user->email_verified_at = now(); // opcional
        $user->save();

        // (Opcional) marcar invitación aceptada en pivot cliente_user
        DB::table('cliente_user')
            ->where('user_id', $user->id)
            ->where('status', 'invited')
            ->update([
                'status' => 'accepted',
                'accepted_at' => now(),
                'updated_at' => now(),
            ]);

        return redirect()->route('login')
            ->with('status', 'Tu contraseña fue registrada. Ya puedes iniciar sesión.');
    }
}
