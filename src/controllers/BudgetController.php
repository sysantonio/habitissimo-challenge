<?php
namespace App\Controller;
require (__DIR__ . '/../src/models/Budget.php');

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Controller\Controller;

class BudgetController extends Controller
{

    public function list($request, $response, $args){
        return Budget::all();
        return $response;
    }
    public function listByEmail($email){
        $user = User::where('email', $email)->get();
        return Budget::where('user', $user->id)->get();
    }

    public function get($id) {
        return Budget::find($id);
    }

    public function delete($id){
        $budget = Budget::find($id);
        return $budget->delete();
    }

    public function create($request, $args){
        $data = $request->getParsedBody();
        $budget = new Budget();
        $budget->fill($data);
        return $budget->save();
    }

    public function update($request, $args){
        $data = $request->getParsedBody();
        $id = $args['id'];
        $budget = Budget::find($id);
        $budget->fill($data);
        return $budget->save();
    }

    public function modify($args, $status) {
        $id = $args['id'];
        $budget = Budget::find($id);
        $budget->status = $status;
        $budget->save();
    }


}