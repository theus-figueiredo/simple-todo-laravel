<?php

namespace App\Http\Controllers;

use App\Helper\ApiMessage;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->paginate('10');

        return response()->json($users, 200);
    }


    public function store(Request $request)
    {
        $data = $request->all();

        if(!$request->has('password') || !$request->get('password'))
        {
            $message = new ApiMessage('User requires a password');
            return response()->json(['Error' => $message->sendMessage()], 401);
        }

        try 
        {
            $data['password'] = bcrypt($data['password']);

            $user = $this->user->create($data);

            return response()->json(['data' => $user], 201);

        } catch(\Exception $e)
        {
            $errorMessage = new ApiMessage($e->getMessage());
            return response()->json(['Error' => $errorMessage->sendMessage()], 401);
        }
    }


    public function show(string $id)
    {
        try {

            $user = $this->user->findOrFail($id);

            return response()->json(['data' => $user], 200);

        } catch(\Exception $e) {
            $errorMessage = new ApiMessage($e->getMessage());
            return response()->json(['Error' => $errorMessage->sendMessage()], 401);
        }
    }


    public function update(Request $request, string $id)
    {
        $data = $request->all();

        if($request->has('password') && $request->get('password'))
        {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        try {

            $user = $this->user->findOrFail($id);
            $user->update($data);

            return response()->json(['data' => $user], 200);

        } catch(\Exception $e) {
            $errorMessage = new ApiMessage($e->getMessage());
            return response()->json(['Error' => $errorMessage->sendMessage()], 401);
        } 
    }


    public function destroy(string $id)
    {
        try {

            $user = $this->user->findOrFail($id);
            $user->delete();

            return response()->json(['data' => 'user deleted'], 200);

        } catch(\Exception $e) {
            $errorMessage = new ApiMessage($e->getMessage());
            return response()->json(['Error' => $errorMessage->sendMessage()], 401);
        } 
    }
}
