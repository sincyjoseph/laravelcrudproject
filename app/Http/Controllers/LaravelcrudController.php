<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laravelcrud;
use Yajra\DataTables\Facades\DataTables;
class LaravelcrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userlist = Laravelcrud::get();
        // dd($userlist);
        if($request->ajax()){
            $allData = Datatables::of($userlist)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"
                        data-id="'.$row->id.'" data-original-title="Edit" 
                        class="edit btn btn-primary btn-sm editUser">Edit</a>&nbsp';
                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"
                        data-id="'.$row->id.'" data-original-title="Delete" 
                        class="delete btn btn-danger btn-sm deleteUser">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
            return $allData;
        }
        return view('home', compact('userlist'));

        /*The compact() function is used to convert given variable to array in which the key of the array
         will be the name of the variable and the value of the array will be the value of the variable.*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Laravelcrud::updateOrCreate(
            ['id'=>$request->HI],
            ['username'=>$request->username,
            'password'=>$request->password,
            'email'=>$request->email,
            'gender'=>$request->gender,
            'address'=>$request->address,
            'declaration'=>$request->declaration
            ]);
            return response()->json(['success'=>'User added successfully']);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Laravelcrud::find($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Laravelcrud::find($id)->delete();
        return response()->json(['success'=>'User data deleted successfully']);
    }
}
