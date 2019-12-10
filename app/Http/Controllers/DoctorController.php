<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class DoctorController extends Controller
{
    public $professions = array(
        User::PROFESSION_DOCTOR => 'Médico',
        User::PROFESSION_PSY => 'Psicólogo',
        User::PROFESSION_NUTRI => 'Nutricionista'
    );
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
        //
        $data['profession'] = $this->professions;
        $data['status'] = $this->status;
        $data['records'] = User::where("type",1)->get();
        return view('doctor.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //        
        $data['profession'] = $this->professions;
        $data['status'] = $this->status;
        return view('doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $this->validate($request, [
        //     'email' => 'required',
        //     'name' => 'required',
        //     'type' => 'required',
        //     'password' => 'required',
        // ],[
        //     'email.required' => 'O email é obrigatório.',
        //     'name.required' => 'O nome é obrigatório.',
        //     'type.required' => 'O CPF é obrigatório.',
        //     'password.required' => 'A senha é obrigatória.',
        // ]);
        
        $user = new \App\User();
        $user->status = $nameFile;
        $user->save();

        return redirect('doctor');
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
        $data['show']=true;
        $data['entity']=User::find($id);
        $data['profession'] = $this->professions;
        $data['status'] = $this->status;
        return view("doctor.create",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data['entity']=User::find($id);
        $data['profession'] = $this->professions;
        $data['status'] = $this->status;
        return view("doctor.create",$data);
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
        $data = $request->all();
        $update = User::find($id)->update($data);
        return redirect('doctor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        User::find($id)->delete();
        return redirect('doctor');
    }
}
