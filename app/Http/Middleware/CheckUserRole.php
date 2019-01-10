<?php
namespace App\Http\Middleware;
use Closure;
use Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

      if($request->user() === null)
      {
        return redirect(route('login'));
      }

      $action = $request->route()->getAction();
      $roles = isset($action['roles']) ? $action['roles'] : null;
      $user_role = Auth::user()->role;

      if($user_role === $roles[0] || $user_role === $roles[1] || $user_role === $roles[2] || !$roles)
      {
        return $next($request);
      }
      else
      {
        abort(403,'not Authorized');
      }

    }
}
