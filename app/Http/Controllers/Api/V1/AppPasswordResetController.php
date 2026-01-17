<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\AppPasswordResetMail;
use App\Models\AppPasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AppPasswordResetController extends Controller
{
    /**
     * POST /api/app/password/forgot
     * Body: { email }
     *
     * Siempre responde OK para evitar enumeración.
     */
    public function forgot(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = strtolower(trim($data['email']));

        // Respuesta genérica (anti-enumeración)
        $genericResponse = response()->json([
            'ok' => true,
            'message' => 'If the email exists, we sent you a recovery code.',
        ]);

        // Buscar usuario (si no existe, regresamos genérico)
        $user = User::where('email', $email)->first();
        if (!$user) {
            return $genericResponse;
        }

        // Invalida intentos previos vigentes (opcional pero recomendado)
        AppPasswordReset::where('email', $email)
            ->whereNull('used_at')
            ->update(['used_at' => now()]);

        // OTP 6 dígitos
        $code = (string) random_int(100000, 999999);

        // Crear intento
        $reset = AppPasswordReset::create([
            'email'      => $email,
            'code_hash'  => Hash::make($code),
            'expires_at' => now()->addMinutes(15),
            'used_at'    => null,
        ]);

        // Link con rid (configurable)
        $base = rtrim(config('app.app_reset_url', ''), '/');
        // Ejemplos:
        // - cubic33://password-reset-confirm?rid=
        // - https://tudominio.com/password-reset-confirm?rid=
        $link = $base ? ($base . (str_contains($base, '?') ? '' : '?') . 'rid=' . $reset->id) : null;

        // Enviar correo
        Mail::to($email)->send(new AppPasswordResetMail(
            code: $code,
            rid:  $reset->id,
            link: $link
        ));

        return $genericResponse;
    }

    /**
     * POST /api/app/password/reset
     * Body: { rid, code, password, password_confirmation }
     */
    public function reset(Request $request)
    {
        $data = $request->validate([
            'rid'      => ['required', 'uuid'],
            'code'     => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $rid  = $data['rid'];
        $code = $data['code'];

        $reset = AppPasswordReset::where('id', $rid)->valid()->first();

        if (!$reset) {
            return response()->json([
                'ok' => false,
                'message' => 'Invalid or expired reset request.',
            ], 422);
        }

        if (!Hash::check($code, $reset->code_hash)) {
            return response()->json([
                'ok' => false,
                'message' => 'Invalid code.',
            ], 422);
        }

        $user = User::where('email', $reset->email)->first();
        if (!$user) {
            // Caso raro: el usuario fue eliminado después de pedir reset
            $reset->markUsed();
            return response()->json([
                'ok' => false,
                'message' => 'User not found.',
            ], 404);
        }

        // Actualizar contraseña
        $user->password = Hash::make($data['password']);
        $user->save();

        // Marcar usado (uso único)
        $reset->markUsed();

        // Opcional: revocar tokens de sesión si usas Sanctum
        // $user->tokens()->delete();

        return response()->json([
            'ok' => true,
            'message' => 'Password updated successfully.',
        ]);
    }
}