<?php

namespace App\Http\Controllers;

use App\Helper\ApiMessage;
use App\Models\Task;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;

class TaskController extends Controller
{

    private $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function index()
    {
        try {

            $tasks = auth('api')->user()->task()->paginate('10');

            return response()->json(['data' => $tasks], 200);

        } catch (\Exception $e) {
            $errorMessage = new ApiMessage($e->getMessage());
            return response()->json(['Error' => $errorMessage->sendMessage()], 401);
        }
    }


    public function store(Request $request)
    {
        $data = $request->all();

        if($request->has('due_in') && $request->get('due_in'))
        {
            $dateString = $data['due_in'];
            $date = new DateTime($dateString);

            $data['due_in'] = $date;
        }

        if($data['completed'] == true)
        {
            $data['completion_date'] = date('d-m-Y');
        }

        try {

            $data['user_id'] = auth('api')->user()->id;
            $task = $this->task->create($data);

            return response()->json(['data' => $task], 201);

        } catch (\Exception $e) {
            $errorMessage = new ApiMessage($e->getMessage());
            return response()->json(['Error' => $errorMessage->sendMessage()], 401);
        }
    }


    public function show(string $id)
    {
        try {

            $task = $this->task->findOrFail($id);

            return response()->json(['data' => $task], 200);

        } catch (\Exception $e) {
            $errorMessage = new ApiMessage($e->getMessage());
            return response()->json(['Error' => $errorMessage->sendMessage()], 401);
        }
    }


    public function update(Request $request, string $id)
    {
        $data = $request->all();

        if($request->has('due_in') && $request->get('due_in'))
        {
            $dateString = $data['due_in'];
            $date = strtotime($dateString);

            $data['due_in'] = $date;
        }

        if($data['completed'] == true)
        {
            $data['completion_date'] = new DateTime();
        }

        try {

            $user_id = auth('api')->user()->id;
            $task = $this->task->findOrFail($id);

            if($user_id == $task['user_id'])
            {
                $task->update($data);

                return response()->json(['data' => $task], 200);
            }

            return response()->json(['data' => 'User unauthorized'], 401);

        } catch (\Exception $e) {
            $errorMessage = new ApiMessage($e->getMessage());
            return response()->json(['Error' => $errorMessage->sendMessage()], 401);
        }
    }


    public function destroy(string $id)
    {
        try {

            $user_id = auth('api')->user()->id;
            $task = $this->task->findOrFail($id);

            if($user_id == $task['user_id'])
            {
                $task->delete();
                return response()->json(['data' => 'task deleted'], 200);
            }

            return response()->json(['data' => 'User unauthorized'], 401);

        } catch (\Exception $e) {
            $errorMessage = new ApiMessage($e->getMessage());
            return response()->json(['Error' => $errorMessage->sendMessage()], 401);
        }
    }


    public function markTaskAsCompleted(string $id)
    {
        $task = $this->task->findOrFail($id);
        $user_id = auth('api')->user()->id;

        try {

            if($user_id == $task['user_id'])
            {
                $task['completed'] = !$task['completed'];
                $task->save();

                if($task['completed'] == true) {
                    $timezone = new DateTimeZone('America/Sao_Paulo');
                    $task['completion_date'] = new DateTime(null, $timezone);
                }else {
                    $task['completion_date'] = null;
                }

                return response()->json(['data' => $task]);
            }

            return response()->json(['data' => 'Unauthorized user'], 401);

        } catch (\Exception $e) {
            $errorMessage = new ApiMessage($e->getMessage());
            return response()->json(['Error' => $errorMessage->sendMessage()], 401);
        }
    }
}
