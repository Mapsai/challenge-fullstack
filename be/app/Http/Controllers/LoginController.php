<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LoginController extends Controller
{
    public function login(Request $req)
    {
        try {
            if (!$req->email || !$req->password) {
                throw new BadRequestHttpException('Missing email or password');
            }

            $user = User::query()->where('email', '=', $req->email)->first();

            if (!$user || !Hash::check($req->password, $user->password)) {
                throw new NotFoundHttpException('Invalid email or password');
            }

            $token = Hash::make(Str::random(32));

            $user->token = $token;
            $user->token_valid_until = date('Y-m-d H:i:s', time() + 86400); // 1 day
            $user->save();

            return response()->json(['success' => true, 'message' => $token]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
