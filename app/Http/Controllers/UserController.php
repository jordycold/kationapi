<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Illuminate\Support\Facades\Mail;



class UserController extends Controller
{
    public function register(Request $request) {

        $req = $request->input('json', null);
        $params = json_decode($req);
        $params_array = json_decode($req, true);

        if(!empty($params) && !empty($params_array)){

            $params_array = array_map('trim', $params_array);

            $validate = \Validator::make($params_array,[

                'name' => 'required|alpha',
                'lname' => 'required|alpha',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ]);


            if($validate->fails()){

                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No se pudo completar el registro. Intente nuevamente.',
                    'errors' => $validate->errors()
                );

            }else{
              
            $pwd = hash('sha256', $params->password);
            

            $user = new User();
            $user->name = $params_array['name'];
            $user->lname = $params_array['lname'];
            $user->email= $params_array['email'];
            $user->pwd = $pwd;
            $user->save();


        $data = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'El usuario se ha creado correctamente',
            'user' => $user

        );
     }

    }else{

           
        $data = array(
            'status' => 'error',
            'code' => 400,
            'message' => 'Los datos enviados no son correctos'
        );

        
        }
            return response()->json($data, $data['code']);

}


public function login(Request $request){

    $jwtAuth = new \JwtAuth();


    $json = $request->input('json', null);
    $params = json_decode($json);
    $params_array = json_decode($json, true);


    $validate = \Validator::make($params_array,
    [
            'email' =>   'required|email',
            'password' => 'required'

    ]);

    if($validate->fails()){
        

        $signup = array(
            'status' => 'error',
            'code' => 400,
            'message' => 'El usuario no se ha podido identificar',
            'errors' => $validate->errors()


        );

    }else{

        $pwd = hash('sha256', $params->password);
        $signup = $jwtAuth->signup($params->email, $pwd);

        $last_login = array("last_login" => now());
        \DB::table('users')->where('email', $params->email)->update($last_login);

        if(!empty($params->gettoken)){
            $signup = $jwtAuth->signup($params->email, $pwd, true);

        }
 }

    return response()->json($signup,200);

}


public function update(Request $request){


    //Comprobar si el usuario está autorizado
    $token = $request->header('Authorization');
    $jwtAuth = new \JwtAuth();
    $checkToken = $jwtAuth->checkToken($token);


    //Recoger los datos por post
    $json = $request->input('json', null);
    $params_array = json_decode($json, true);

    if($checkToken && !empty($params_array)){

        //Sacar usuario identificado
        $user = $jwtAuth->checkToken($token,true);

        //Validar datos
        $validate = \Validator::make($params_array, [

                'name' => 'required|alpha',
                'lname' => 'required|alpha',
                'email' =>   'required|email|unique:users,'.$user->sub,
    
        ]);
    
        //Quitar datos que no quiero actualizar

        unset($params_array['id']);
        unset($params_array['password']);
        unset($params_array['created_at']);
        unset($params_array['remember_token']);

        //Actualizar usuario en BD

        $user_update = User::where('id', $user->sub)->update($params_array);

        //Devolver array con el resultado

        $data= array(
            'status' => 'success',
            'code' => 200,
            'user' => $user,
            'changes' => $params_array
        );
        
    }else{

        $data= array(
            'status' => 'error',
            'code' => 400,
            'message' => 'El usuario no se ha podido identificar'
        );

        }

    return response()->json($data, $data['code']);
}



    public function getusers(Request $request){

         $token = $request->header('Authorization');
         $jwtAuth = new \JwtAuth();
         $checkToken = $jwtAuth->checkToken($token);

         if($checkToken){

            $users = User::all();

            $data= array(
                'status' => 'success',
                'code' => 200,
                'users' => $users,
            );
            
        }else{
    
            $data= array(
                'status' => 'error',
                'code' => 400,
                'message' => 'No estás autorizado a realizar este proceso'
            );

        }
         
         return response()->json($data);

         
    }


    public function deleteusers($id, Request $request){

        $token = $request->header('Authorization');
         $jwtAuth = new \JwtAuth();
         $checkToken = $jwtAuth->checkToken($token);

         if($checkToken){

            $user = User::find($id)->delete();

            $data= array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Usuario borrado correctamente',
            );
            
        }else{
    
            $data= array(
                'status' => 'error',
                'code' => 400,
                'message' => 'No estás autorizado a realizar este proceso'
            );

        }
         
         return response()->json($data);
         
        }


        public function filterusers(Request $request){

            $search = $request->input('filter');

            $users = User::where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->get();

            if(count($users) > 0){
                $data= array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => $users,
                );
                
            }else{
    
                $data= array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Usuario no encontrado, por favor intentar nuevamente'
                );
    
            }
             
             return response()->json($data);
        }



           public function forgot_pwd(Request $request){

               $usr = User::where('email', $request->input('email'))->get();
                 if(count($usr) > 0)
                {

              $random_password = \Str::random(8);
              $usr[0]->pwd = hash('sha256', $random_password);
              $usr[0]->save();

              $maildata = ['email' => $usr[0]->email, 'name' => $usr[0]->name, 'pwd' => $random_password ];
              Mail::send('mail.reset', ['data' => $maildata], function($msg) use ($maildata){
                  $msg->from("test@kation.com");
                  $msg->to($maildata['email']);
                  $msg->subject('Password Reset');
              });
  
                $data= array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Correo enviado para reestablecer contraseña, por favor revisar el buzón de entrada del correo registrado.',
            );

          }
          else
          {
                    $data= array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Ha ocurrido un error enviando correo. Intentar nuevamente.",
                    );

                }

                return response()->json($data);
           }            
    }


        
