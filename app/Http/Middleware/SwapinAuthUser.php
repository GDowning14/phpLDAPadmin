<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use LdapRecord\Container;

use App\Ldap\Guard;

class SwapinAuthUser
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
	 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
	 * @throws \LdapRecord\Configuration\ConfigurationException
	 */
	public function handle(Request $request,Closure $next): mixed
	{
		$key = config('ldap.default');

		if (! array_key_exists($key,config('ldap.connections')))
			abort(599,sprintf('LDAP default server [%s] configuration doesnt exist?',$key));

		if (Session::has('username_encrypt') && Session::has('password_encrypt')) {
			Config::set('ldap.connections.'.$key.'.username',Crypt::decryptString(Session::get('username_encrypt')));
			Config::set('ldap.connections.'.$key.'.password',Crypt::decryptString(Session::get('password_encrypt')));

			Log::debug('Swapping out configured LDAP credentials with the user\'s session.',['key'=>$key]);
		}

		// We need to override our Connection object so that we can store and retrieve the logged in user and swap out the credentials to use them.
		$c = Container::getInstance()
			->getConnection($key);

		$c->setConfiguration(config('ldap.connections.'.$key));
		$c->setGuardResolver(fn()=>new Guard($c->getLdapConnection(),$c->getConfiguration()));

		return $next($request);
	}
}