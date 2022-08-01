<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Models\Attack;
use App\Models\Call;
use App\Models\Error;
use App\Models\Log;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home(Request $request)
    {
        $attacksQtd = Attack::query()
            ->where('updated_at', '>=', ($request?->from ?? date('Y-m-d')) . ' 00:00:00')
            ->where('updated_at', '<=', ($request?->until ?? date('Y-m-d')) .  '23:59:59')
            ->count();
        $errorsQtd = Log::query()
            ->whereLogableType(Error::class)
            ->where('updated_at', '>=', ($request?->from ?? date('Y-m-d')) . ' 00:00:00')
            ->where('updated_at', '<=', ($request?->until ?? date('Y-m-d')) . ' 23:59:59')
            ->count();
        $callsQtd = Call::query()->open()->count();
        return inertia('Dashboard', compact('attacksQtd', 'errorsQtd', 'callsQtd'));
    }
}
