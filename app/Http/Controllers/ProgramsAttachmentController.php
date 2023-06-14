<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramsAttachment;
use Illuminate\Http\Request;
use Storage;
use Yajra\DataTables\Facades\DataTables;

class ProgramsAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($programId)
    {
        $program = Program::findOrFail($programId);
        $breadcrumbs = [
            ['route' => '', 'name' => 'Program Management'],
            ['route' => '', 'name' => 'Attachment Management'],
        ];
        return view('program-attachment.main', [
            'title' => $program->name . ' Attachment Management',
            'breadcrumbs' => $breadcrumbs,
            'program' => $program,
            'data' => ProgramsAttachment::where('programId', $programId)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasfile('file')) {
            foreach ($request->file('file') as $value) {
                $data = new ProgramsAttachment($request->all());
                $data->save();

                $filename = $value->getClientOriginalName();
                $file_url = "program/".$data->programId."/" . $filename;
                Storage::disk('public')->put($file_url, file_get_contents($value));

                // !update file url
                $data->name = $filename;
                $data->file_url = config('app.url') . "/storage/" . $file_url;
                $data->save();
            }
            return redirect()->route('programs-attachment.index', ['programId' => $request->programId])->with('toast_success', 'Create data succeed!');
        }

        return redirect()->route('programs-attachment.index', ['programId' => $request->programId]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ProgramsAttachment::findOrFail($id);
        $data->delete();
        return back()->with('toast_success', 'Delete data succeed!');
    }

    public function jsontable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');
        $order = $request->get('order');

        $programId = $request->get('programId');


        $columnorder = array(
            'id',
            'registrationRateId',
            'registrantTypeId',
            'price',
            'created_at',
            'updated_at',
            'action',
        );

        if (empty($order)) {
            $sort = 'registrationRateId';
            $dir = 'asc';
        } else {
            $sort = $columnorder[$order[0]['column']];
            $dir = $order[0]['dir'];
        }
        // query
        $keyword = trim($search['value']);

        $data = ProgramsAttachment::when($keyword, function ($query, $keyword) {
            return $query->where(function ($query) use ($keyword) {
                $query->orWhere('name', 'LIKE', '%' . $keyword . '%');
            });
        })
            ->when($programId, function ($query, $programId) {
                if (!empty($programId)) {
                    return $query->where('programId', $programId);
                }
            })
            ->offset($start)
            ->limit($length)
            ->orderBy($sort, $dir)
            ->get();
        $recordsTotal = ProgramsAttachment::select('id')->when($programId, function ($query, $programId) {
            if (!empty($programId)) {
                return $query->where('programId', $programId);
            }
        })->count();
        $recordsFiltered = ProgramsAttachment::select('id')
            ->when($keyword, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->orWhere('name', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->when($programId, function ($query, $programId) {
                if (!empty($programId)) {
                    return $query->where('programId', $programId);
                }
            })
            ->count();
        $resp = DataTables::of($data)
            ->editColumn('id', function ($data) {
                return str_pad($data->id, 5, "0", STR_PAD_LEFT);
            })
            ->editColumn('created_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->created_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->created_at)) . '</small>';
            })
            ->editColumn('updated_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->updated_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->updated_at)) . '</small>';
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                $file_url = $data->file_url;
                return view('program-attachment._action', compact('id', 'file_url'));
            })
            ->setTotalRecords($recordsTotal)
            ->setFilteredRecords($recordsFiltered)
            ->escapeColumns([])
            ->skipPaging()
            ->addIndexColumn()
            ->make(true);
        return $resp;
    }
}
