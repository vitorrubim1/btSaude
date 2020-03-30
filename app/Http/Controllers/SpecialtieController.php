<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialtie; 

class SpecialtieController extends Controller
{
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $specialtie = array(
    );
    public $status = array(
        //para ver se esta ativo ou n
        Specialtie::STATUS_ACTIVE => '1', //ativo
        Specialtie::STATUS_INACTIVE => '0'
    );
    public function index(Request $request)
    {   

        $name = $request->input('name');
        $data['status'] = $this->status;
        $data['records'] = Specialtie::where("status",1)->get();
        return view('specialtie.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $data = $request->name;

        // Specialtie::create($data);

        return view('specialtie.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $this -> validate($request,[
        //     //Aqui vai a verificação de campos vazios 

        //     'name' => 'required',
        //     'status' => 'required',
        // ],[
        //     'name.required' => 'O nome da especialidade do médico é Obrigatória!',
        //     'status.required' => 'O status é obrigatório',
        // ]);

        $name = $request->input('name');

        $specialtie = new \App\Specialtie();
        $specialtie->status = "teste";

        $specialtie->save();

        return redirect('specialtie');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['show']=true;
        $data['entity']=Specialtie::find($id);
        $data['name'] = $this->specialtie;
        $data['status'] = $this->status;
        
        return view("specialtie.create",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['entity']=Specialtie::find($id);
        $data=$this->specialtie ;
        $data=$this->status;
        return view("specialtie.create",$data);
        
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
        $data = $request->all();
        $update = Specialtie::find($id)->update($data);

        return redirect('specialtie');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Specialtie::find($id)->delete();
        return redirect('specialtie');   
    }
}
