<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * Os proxies confiáveis para esta aplicação.
     *
     * @var array<int, string>|string|null
     */

    // Mude para '*' para confiar em qualquer proxy.
    // O Cloud Run usa IPs dinâmicos, então '*' é o mais seguro.
    protected $proxies = '*';

    /**
     * Os cabeçalhos que devem ser usados para detectar o proxy.
     *
     * @var int
     */

    // Esta é a MÁGICA.
    // Diz ao Laravel para confiar em TODOS os cabeçalhos "X-Forwarded-*"
    // incluindo o "X-Forwarded-Proto" (que o Cloud Run envia como 'https')
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
