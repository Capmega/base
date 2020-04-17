<?php

namespace Capmega\Base\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Admin
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//                 $response = $next($request);
//                 dd($this->auth);
// dd(     auth()->id());
//             dd($request->user());
//
//         dd($this->auth);
//         dd(user());
//         if (!$this->auth->check()) {
//             return redirect('login');
//         }
//
//         if ($this->auth->user()->hasRole(['admin'])) {
//             abort(403, 'Unauthorized action.');
//         }

        return $next($request);
    }
}
