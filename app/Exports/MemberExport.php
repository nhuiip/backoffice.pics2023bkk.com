<?php

namespace App\Exports;

use App\Models\Member;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MemberExport implements FromView,ShouldAutoSize
{

    public function view(): View
    {
        return view('member.report', [
            'data' => Member::with('members_visas')->get()
        ]);
    }
}
