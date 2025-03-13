<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['en', 'fr', 'id'];
        $getSession = $request->session()->has('locale');

        if (in_array($getSession, $supportedLocales)) {
            App::setLocale($request->session()->get('locale'));
        } else {
            App::setLocale('fr');
        }

        // if (!$request->session()->has('locale')) {
        //     $request->session()->put('locale', 'fr');
        // }
        // App::setLocale($request->session()->get('locale'));

        return $next($request);
        // $supportedLocales = ['en', 'fr', 'id'];

        // // Ambil locale dari session, jika tidak ada gunakan 'fr' sebagai default
        // $locale = $request->session()->get('locale', 'fr');

        // // Jika locale yang disimpan tidak termasuk dalam daftar yang didukung, atur ke 'fr'
        // if (!in_array($locale, $supportedLocales)) {
        //     $locale = 'fr';
        //     $request->session()->put('locale', $locale);
        // }

        // App::setLocale($locale);

        // return $next($request);
    }
}
