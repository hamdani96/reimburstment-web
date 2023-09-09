<?php

namespace Modules\Employee\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a ajax of the resource.
     * @return Renderable
    */
    public function ajax(){
        try {
            $data = User::orderBy('created_at', 'desc')->whereNull('delete_at');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '  <a href="#" class="btn btn-warning employee-edit" data-id="'.$row->id.'">Edit</a>
                                    <a href="#" class="btn btn-danger employee-delete" data-id="' . $row->id . '">Hapus</a>
                                ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
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
        return view('employee::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('employee::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required',
            'nip'           => 'required|unique:users,nip',
            'job_position'  => 'required',
            'password'      => 'required',
        ]);

        try {
            User::create([
                'name'          => $validated['name'],
                'nip'           => $validated['nip'],
                'job_position'  => $validated['job_position'],
                'password'      => Hash::make($validated['password']),
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
                'message'   => 'Gagal simpan karyawan.',
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
        return view('employee::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $user = User::select(
                'id',
                'name',
                'nip',
                'job_position'
            )->where('id', $id)
            ->first();
    
            return response()->json([
                'code'      => 200,
                'message'   => 'success',
                'data'      => $user
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'code'      => 500,
                'message'   => 'Gagal mangambil data edit.',
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
            'name'          => 'required',
            'nip'           => 'required|unique:users,nip,'.$id,
            'job_position'  => 'required',
            'password'      => 'nullable',
        ]);

        try {
            $user = User::where('id', $id)->first();
            if($validated['password'] != null) {
                $password = Hash::make($validated['password']);
            } else {
                $password = $user->password;
            }

            User::where('id', $id)->update([
                'name'          => $validated['name'],
                'nip'           => $validated['nip'],
                'job_position'  => $validated['job_position'],
                'password'      => $password,
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
                'message'   => 'Gagal update karyawan.',
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
        try {
            User::where('id', $id)->update([
                'delete_at' => Carbon::now()
            ]);

            return response()->json([
                'code'      => 200,
                'message'   => 'success'
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'code'      => 500,
                'message'   => 'Gagal hapus karyawan.',
                'data'      => $e->getMessage(),
            ], 500);
        }
    }
}
