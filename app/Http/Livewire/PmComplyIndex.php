<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class PmComplyIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;

    public function render()
    {
        $notcomply = Carbon::now()->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->setDay(1)->format('Y-m-d');

        $tablepmnotcomply = DB::table('msf620')
            ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
            ->where([
                ['msf620.work_group', '=', 'TELECT'],
                ['msf620.maint_type', '=', 'PM'],
                ['msf620.wo_status_m', '=', 'C'],
            ])
            ->whereBetween('msf620.plan_fin_date', [$notcomplydate, $notcomply])
            ->whereNull('msf623.completion_comment')
            ->orderBy('msf620.plan_fin_date', 'asc')
            ->paginate(10);

        return view('livewire.pm-comply-index', [
            'tablepmnotcomply' => $tablepmnotcomply,
        ]);
    }
}
