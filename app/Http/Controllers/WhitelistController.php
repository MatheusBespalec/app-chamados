<?php

namespace App\Http\Controllers;

use App\Http\Requests\WhitelistStoreRequest;
use App\Models\Whitelist;
use App\Repositories\WhitelistRepository;
use DateTimeImmutable;

class WhitelistController extends Controller
{
    public function store(WhitelistStoreRequest $request, WhitelistRepository $repository)
    {
        $expiration = null;
        if (isset($request->expiration)) {
            $expiration = new DateTimeImmutable($request->expiration);
        }

        $repository->create($request->ip, $expiration, $request->description);
        return redirect()->back()->with('success', 'O IP ' . $request->ip . ' foi liberado');
    }

    public function destroy(Whitelist $ip)
    {
        $ip->delete();
        return redirect()->back()->with('success', 'IP removido da WhiteList');
    }
}
