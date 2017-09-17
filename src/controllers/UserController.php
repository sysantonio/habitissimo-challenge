<?php
/**
 * Created by PhpStorm.
 * User: aym14
 * Date: 17/09/2017
 * Time: 18:00
 */

namespace App\Controller;

require (__DIR__ . '/../src/models/User.php');

class UserController
{
    public function list(){
        return User::all();
    }

    public function get($id) {
        return User::find($id);
    }

    public function delete($id){
        $user = User::find($id);
        return $user->delete();
    }

    public function update($request, $args){
        $data = $request->getParsedBody();
        $id = $args['id'];
        $user = User::find($id);
        $user->fill($data);
        return $user->save();
    }

    public function updateOrCreate($request) {
        $data = $request->getParsedBody();
        return User::updateOrCreate($data);
    }


}