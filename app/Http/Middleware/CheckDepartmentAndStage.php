<?php
namespace App\Http\Middleware;
use Closure;
use Auth;

class CheckDepartmentAndStage
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

      if(empty(Auth::user()->department_id) && empty(Auth::user()->stage_id))
      {
        return redirect(route('home'));
      }
      else
      {
        return $next($request);
      }

    }
}
