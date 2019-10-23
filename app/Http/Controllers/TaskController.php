<?php

namespace App\Http\Controllers;

use App\Folder;

use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
  public function index(Folder $folder)
  {
    $folders = Auth::user()->folders()->get();

    $tasks = $folder->tasks()->get();

    // $current_folder = Folder::find($id);
    //
    // if(is_null($current_folder))
    // {
    //   abort(404);
    // }
    //
    // $tasks = $current_folder->tasks()->get();

    return view('tasks/index', [
      'folders'=> $folders,
      'current_folder_id'=> $folder->id,
      'tasks' => $tasks,
    ]);
  }

  public function showCreateForm(Folder $folder)
  {
    return view('tasks/create', [
      'folder_id' => $folder->$id,
    ]);
  }

  public function create(Folder $folder, CreateTask $request)
  {
    // $current_folder = Folder::find($id);

    $task = new Task();
    $task->title = $request->title;
    $task->due_date = $request->due_date;

    $folder->tasks()->save($task);

    return redirect()->route('tasks.index', [
      'id' => $folder->id,
    ]);
  }
  public function showEditForm(Folder $folder, Task $task)
  {
    // $task = Task::find($task_id);

    $this->checkRelation($folder, $task);

    return view('tasks/edit', [
      'task' => $task,
    ]);
  }

  public function edit(Folder $folder, Task $task, EditTask $request)
  {
    // $task = Task::find($task_id);
    $this->checkRelation($folder, $task);

    $task->title = $request->title;
    $task->status = $request->status;
    $task->due_date = $request->due_date;
    $task->save();

    return redirect()->route('tasks.index', [
      'id' => $task->folder_id,
    ]);
  }

  private function checkRelation(Folder $folder, Task $task)
  {
    if($folder->id !== $task->folder_id){
      abort(404);
    }
  }
}
