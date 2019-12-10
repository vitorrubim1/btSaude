<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Log;
use Auth;

class UserController extends Controller
{
    //
    public function login(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($credentials)) {
            $user = User::find(Auth::user()->id);
            $user->firebase_token = $request->firebase_token;
            $user->save();

            $token = auth()->user()->createToken('FaleComOMedico')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Não Autorizado'], 401);
        }
    }

    public function register(Request $request){
        Log::info("Test");
        Log::info($request->file('front'));
        Log::info($request->file('back'));

        if ($request->hasFile('front') && $request->file('front')->isValid()) {
            // Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));

            // Recupera a extensão do arquivo
            $extension = $request->front->extension();

            // Define finalmente o nome
            $nameFileFront = "{$name}.{$extension}";

            // Faz o upload:
            $upload = $request->front->storeAs('front', $nameFileFront, 'front');
            // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao

            // Verifica se NÃO deu certo o upload (Redireciona de volta)
            if ( !$upload )
                return redirect()
                            ->back()
                            ->with('error', 'Falha ao fazer upload')
                            ->withInput();

        }else{
            $nameFileFront = 'undefined.jpg';
        }

        if ($request->hasFile('back') && $request->file('back')->isValid()) {
            // Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));

            // Recupera a extensão do arquivo
            $extension = $request->back->extension();

            // Define finalmente o nome
            $nameFileBack = "{$name}.{$extension}";

            // Faz o upload:
            $upload = $request->back->storeAs('back', $nameFileBack, 'back');
            // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao

            // Verifica se NÃO deu certo o upload (Redireciona de volta)
            if ( !$upload )
                return redirect()
                            ->back()
                            ->with('error', 'Falha ao fazer upload')
                            ->withInput();

        }else{
            $nameFileBack = 'undefined.jpg';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'photo_front' => $nameFileFront,
            'photo_back' => $nameFileBack,
            'cpf' => str_replace(array('.','-'), '', $request->taxid),
            'phone' => str_replace(array('(',')','-', ' '), '', $request->telephone),
            'cell' => str_replace(array('(',')','-', ' '), '', $request->cellphone),
            'profession' => $request->profession,
            'status' => 0,
            'type' => 1,
            'firebase_token' => $request->firebase_token
        ]);
 
        $token = $user->createToken('FaleComOMedico')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }

    public function view(){
        return response()->json(['user' => auth()->user()], 200);
    }
}
