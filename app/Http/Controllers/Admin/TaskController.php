<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class TaskController extends Controller
{
    //
    public function index()
    {
        return view('admin.tasks.index');
    }

//    function for yajra tables
    public function tasksListWithYajra(Request $request)
    {
        if($request->ajax()){
            $tasks=Task::orderBy('created_at', 'desc')->select('tasks.*');

            return DataTables::of($tasks)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex">';
                    $btn = $btn .'<button type="button" class="text-black border-0 bg-transparent" data-toggle="modal" data-target="#ViewTaskModal" data-action="view" data-id="'. $row->id . '"><i class="fas fa-eye"></i></button>';
                    $btn = $btn . '<button type="button" class="text-black border-0 bg-transparent" data-toggle="modal" data-target="#UpdateTaskModal" data-action="update" data-id="' . $row->id . '"><i class="fas fa-pen"></i></button>';
                    $btn = $btn . '<button type="button" class="text-black border-0 bg-transparent" id="delete-btn" data-task-id="' . $row->id . '"><i class="fas fa-trash"></i></button>';
                    $btn = $btn . '</div>';
                    return $btn;
                })
                ->make(true);
        }

    }

//    function create
    public  function create()
    {
        $users=User::usersLookup();

        return response()->json([
            'users'=> $users
        ]);
    }

    public  function store(Request $request)
    {
        $task=new Task();
        $task->name= $request->input('name');
        $task->description= $request->input('description');

        $task->save();

        $user_id= $request->input('user_id');
        $task->users()->attach($user_id);

        Session::flash('message', 'Task Created and Assigned!');

        return response()->json([
            'message'=>'Task Created and Assigned'
        ]);

    }
// function for update
    public function edit($id){
            $task=Task::with('users')->find($id);

            $users=User::usersLookup();

            return response()->json([
                'task'=> $task,
                'users'=> $users
            ]);

    }

    public function update(Request $request, $id)
    {
        $task=Task::with('users')->find($id);

        $task->name= $request->input('name');
        $task->description= $request->input('description');

        $task->save();

        if ($request->has('user_id')) {
            $task->users()->sync($request->input('user_id'));
        }

    }

//    function fo view
    public function show($id)
    {
        $task=Task::with('users')->find($id);
        return response()->json([
            'task'=> $task
        ]);
    }

//    function for delete
    public function destroy($id)
    {
        $task=Task::find($id);

        $task->delete();

        Session::flash('message',' Task deleted Successfully!');

        return response()->json([
            'message'=>'Task deleted Successfully!'
        ]);

    }
}
