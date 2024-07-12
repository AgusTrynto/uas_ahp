<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            Log::info('Social User: ', ['user' => $socialUser]);
        } catch (\Exception $e) {
            Log::error('Error: ', ['message' => $e->getMessage()]);
            return redirect('/login');
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            $user->update([
                'name' => $socialUser->getName(),
                'avatar' => $socialUser->getAvatar(), // Menyimpan URL foto profil
            ]);
        } else {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'avatar' => $socialUser->getAvatar(), // Menyimpan URL foto profil
                'password' => Hash::make(uniqid()),
            ]);
        }

        Auth::login($user, true);

        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            Log::error('Authentication failed for user: ', ['user' => $user]);
            return redirect('/login');
        }
    }
}