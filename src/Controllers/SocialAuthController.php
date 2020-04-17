<?php
namespace Capmega\Base\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Validator, Hash, Auth};
use Illuminate\Support\Str;
use App\User;

class SocialAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest', 'web']);
    }

    public function login($type)
    {
        $providers = array_keys(config('base.hybridauth'));

        if (in_array($type, $providers)) {
            $class   = '\Hybridauth\Provider\\'. ucfirst($type);
            $adapter = new $class(config('base.hybridauth.' . $type));
            $adapter->authenticate();
            $userProfile = $adapter->getUserProfile();

            if ($userProfile) {
                $user = User::where('social_login', $type)->where('social_id', $userProfile->identifier)->first();

                if (!$user) {
                    $user               = new User();
                    $user->name         = $userProfile->displayName;
                    $user->firstname    = $userProfile->firstName;
                    $user->lastname1    = $userProfile->lastName;
                    $user->email        = $userProfile->email;
                    $user->password     = Hash::make(Str::random(15));
                    $user->social_login = $type;
                    $user->social_id    = $userProfile->identifier;
                    $user->save();
                }

                Auth::login($user);
                $adapter->disconnect();
                return redirect()->route('dashboard');
            }

        }

        throw new \Exception("Provider " . $type . ' is not supported', 1);
    }
}
