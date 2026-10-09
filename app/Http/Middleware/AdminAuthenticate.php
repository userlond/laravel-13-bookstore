<?php

namespace App\Http\Middleware;

use App\Enums\UserType;
use Closure;
use Filament\Http\Middleware\Authenticate;

class AdminAuthenticate extends Authenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (auth()->user()?->role != UserType::ADMIN->value) {
            auth()->logout();
            abort(403);
        }

        return parent::handle($request, $next, ...$guards);
    }
}
