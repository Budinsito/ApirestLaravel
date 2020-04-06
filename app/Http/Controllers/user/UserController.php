<?php

namespace App\Http\Controllers\user;
use App\User;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios= User::all();
        // return response()->json( ['data' => $usuarios],200);
        return $this->showAll($usuarios);
        // return $usuarios;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
        $this->validate($request, $reglas);
        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
        $campos['verification_token'] = User::generarVerificationToken();
        $campos['admin'] = User::USUARIO_REGULAR;
        $usuario = User::create($campos);
        // return response()->json(['data' => $usuario],201);
        return $this->showOne($usuarios,201);
    }


 /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuarios= User::findOrFail($id);
        // return response()->json(['data' => $usuarios],200);
         return $this->showOne($usuarios,200);
    }

 

    public function edit($id)
    {
        //
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

        $user= User::findOrFail($id);

        $reglas = [
            //Usuario y email van a ser unicos excepto el usuario id que ya habia registrado antes
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR,
        ];
        $this->validate($request, $reglas);
            // has comprueba que exista el campo name
            if ($request->has('name')){
                $user->name = $request->name;
            }
            if($request->has('email') &&  $user->email != $request->email){
                    $user->verified = User::USUARIO_NO_VERIFICADO;
                    $user->verification_token = User::generarVerificationToken();  
                    $user->email = $request->email;    
            }

            if($request->has('password')){
                $user->password = bcrypt($request->password);
            }

            if($request->has('admin')){
                if(!$user->esverificado()){
                    // return response()->json(['error' => 'Unicamente los ususarios verificados pueden cambiar su valor de administrador', 'code' => 409 ],409);
                    return $this->errorResponse('Unicamente los ususarios verificados pueden cambiar su valor de administrador',409);
                }

                $user->admin = $request->admin;
            }

                if(!$user->isDirty()){
                    // return response()->json(['error' => 'Se debe especificar al menos un valor diferente para actualizar','code'=>422],422);
                     return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422);
                }

                $user->save();
                // return response()->json(['data' => $user],200);
                 return $this->showOne($user,200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $user= User::findOrFail($id);
         $user->delete();
         // return response()->json(['data' => $user],200);
         return $this->showOne($user,200);


    }
}
