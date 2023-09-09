<?php

namespace Modules\Reimbursment\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Reimbursment\Entities\Reimbursment;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\ValidationException;

class ReimbursmentController extends Controller
{
    /**
     * Display a ajax of the resource.
     * @return Renderable
    */
    public function ajax(){
        try {
            $job_position = Auth::user()->job_position;
            if($job_position == 'STAFF') {
                $data = Reimbursment::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->whereNull('delete_at');
            } else {
                $data = Reimbursment::orderBy('id', 'desc')->whereNull('delete_at');
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_name', function($row){
                    return $row->user->name;
                })
                ->addColumn('status', function($row) {
                    if($row->status == 'pending') {
                        return '<span class="badge badge-warning">Pending</span>';
                    } elseif ($row->status == 'approved') {
                        return '<span class="badge badge-success">Disetujui</span>';
                    } elseif ($row->status == 'rejected') {
                        return '<span class="badge badge-danger">Ditolak</span>';
                    } else {
                        return '<span class="badge badge-dark">undefined status</span>';
                    }
                })
                ->addColumn('date', function($row) {
                    return Carbon::parse($row->date)->format('d F Y');
                })
                ->addColumn('file', function($row) {
                    if($row->file != null) {
                        return '<a href="'.asset('/assets/file/'.$row->file).'" target="_blank" download="'.$row->file.'">Download<a/>';
                    } else {
                        return '-';
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '  <a href="#" class="btn btn-warning reimbursment-edit" data-id="'.$row->id.'">Edit</a>
                                ';
                    
                    if(Auth::user()->job_position != 'STAFF') {
                        return $actionBtn;
                    } else {
                        return '-';
                    }
                })
                ->rawColumns(['action', 'user_name', 'status', 'file'])
                ->make(true);
        } catch (Throwable $e) {
            return redirect()->route('employee.index')->with(['error' => 'Ajax Failed! ' . $e->getMessage()]);
        }
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $users = User::whereNull('delete_at')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('reimbursment::index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('reimbursment::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'   => 'nullable',
            'name'      => 'required',
            'date'      => 'required',
            'description'   => 'nullable'
        ]);

        try {
            if($request->hasFile('file')) {
                $file = $request->file('file');
                $name_file = time()."_".$file->getClientOriginalName();
                
                $destination = 'assets/file';
                $file->move($destination, $name_file);
            } else {
                $name_file = null;
            }

            if($validated['user_id']) {
                if(Auth::user()->job_position == 'STAFF') {
                    return response()->json([
                        'code'      => 500,
                        'message'   => 'Gagal simpan, jabatan kamu kurang tinggi!',
                    ]);
                }

                $user_id = $validated['user_id'];
            } else {
                $user_id = Auth::user()->id;
            }

            Reimbursment::create([
                'user_id'       => $user_id,
                'name'          => $validated['name'],
                'date'          => $validated['date'],
                'description'   => $validated['description'],
                'file'          => $name_file,
                'status'        => 'pending',
                'created_by'    => $user_id
            ]);

            return response()->json([
                'code'      => 200,
                'message'   => 'success'
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'code'      => 400,
                'message'   => 'Ada inputan yang tidak sesuai.',
                'data'      => $e->errors(),
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'code'      => 500,
                'message'   => 'Gagal simpan reimbusment.',
                'data'      => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('reimbursment::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $Reimbursment = Reimbursment::where('id', $id)
            ->whereNull('delete_at')
            ->first();

            return response()->json([
                'code'      => 200,
                'message'   => 'success',
                'data'      => $Reimbursment
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'code'      => 500,
                'message'   => 'Gagal mengambil data.',
                'data'      => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status'   => 'required',
        ]);

        try {
            Reimbursment::where('id', $id)->update([
                'status'        => $validated['status'],
                'updated_by'    => Auth::user()->id,
            ]);

            return response()->json([
                'code'      => 200,
                'message'   => 'success'
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'code'      => 400,
                'message'   => 'Ada inputan yang tidak sesuai.',
                'data'      => $e->errors(),
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'code'      => 500,
                'message'   => 'Gagal update reimbusment.',
                'data'      => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
