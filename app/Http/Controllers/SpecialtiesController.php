<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SpecialtiesController extends Controller
{
    public $status = array(
        User::STATUS_ACTIVE => 'Ativo',
        User::STATUS_INACTIVE => 'Inativo'
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //$data['name'] = $this->name;
        $data['records'] = User::where("type",1)->get();
        return view('specialties.index',$data);
    }

    public function create(Request $request)
    {
                
        //return "função createe";
        //$data['name'] = $this->name;
        //$data['status'] = $this->status;

        return view('specialties.create');
    }

    public function edit($id)
    {
        $data['entity']=User::find($id);
        $data['name'] = $this->name;
        $data['status'] = $this->status;
        return view("specialties.create",$data);
    }

    public function store(Request $request)
    {
        
        $user = new \App\User();
        $user->status = $nameFile;
        $user->save();

        return redirect('specialties');
    }

    public function show($id)
    {
        //
        $data['show']=true;
        $data['entity']=User::find($id);
        $data['name'] = $this->name;
        //$data['status'] = $this->status;
        return view("specialties.create",$data);
    }

    public function update(Request $request, $id)
    {
        
        //return "função update";

        $data = $request->all();
        $update = User::find($id)->update($data);
        return redirect('specialties');
    }

    public function destroy($id)
    {
        //delete

        User::find($id)->delete();
        return redirect('specialties');
    }

    
}
