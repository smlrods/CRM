<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'deals-range' => ['sometimes', Rule::in([7, 30, 90])],
        ]);

        $dealChartRange = $request->input('deals-range', 7);

        return Inertia::render('Dashboard', [
            'dealChartData' => fn() => $this->getChartDataDashboard($dealChartRange),
            'dealRange' => $dealChartRange,
        ]);
    }

    protected function getChartDataDashboard(int $range): array
    {
        $organization = Organization::find(session('organization_id'));

        $daysAgo = now()->subDays($range - 1);

        $totalValueRange = $organization->deals()
            ->where('close_date', '>=', $daysAgo)
            ->sum('value');

        $dailyTotals = [];

        for ($data = $daysAgo->copy(); $data <= now(); $data->addDay()) {
            $dailyTotals[] = ['value' => $organization->deals()
                ->where('close_date', $data->format('Y-m-d'))
                ->sum('value'), 'date' => $data->format('j F')];
        }

        // get the percentage in comparison with the previous period
        $previousRange = $organization->deals()
            ->where('close_date', '>=', $daysAgo->copy()->subDays($range))
            ->where('close_date', '<', $daysAgo)
            ->sum('value');


        $percentage = $previousRange ? (($totalValueRange - $previousRange) / $previousRange) * 100 : 0;

        return [
            'total' => $totalValueRange,
            'dailyTotals' => $dailyTotals,
            'percentage' => $percentage,
        ];
    }
}
