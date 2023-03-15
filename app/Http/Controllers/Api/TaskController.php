<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id',Auth::user()->id)->get();

        return response(['data'=>$tasks],Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $task = Task::create($request->all());

        return response(['data'=>$task],Response::HTTP_CREATED);
    }

    public function searchByName(Request $request)
    {
        $name = $request->name;
        if(trim($name) !== ''){
            $tasks = Task::where('user_id',Auth::user()->id)->where('name','like',"%$name%")->get();
        }else{
            $tasks = Task::where('user_id',Auth::user()->id)->get();
        }
        return response(['data'=>$tasks],Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $task = Task::where('id',$id)->where('user_id',Auth::user()->id)->first();

        if(!isset($task)) return response(['msg'=>'Task not found'],Response::HTTP_NOT_FOUND);

        return response(['data'=>$task],Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, int $id)
    {
        $task = Task::where('id',$id)->where('user_id',Auth::user()->id)->first();

        if(!isset($task)) return response(['msg'=>'Task not found'],Response::HTTP_NOT_FOUND);

        $task->update($request->all());

        return response(['data'=>$task],Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $task = Task::where('id',$id)->where('user_id',Auth::user()->id)->first();

        if(!isset($task)) return response(['msg'=>'Task not found'],Response::HTTP_NOT_FOUND);

        $task->delete();

        return response(['msg'=>'Task deleted correctly'],Response::HTTP_OK);
    }
}
