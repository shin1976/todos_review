<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFolder;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Folder;

class FolderController extends Controller
{
    public function showCreateForm()
    {
      return view('folders/create');
    }

    public function create(CreateFolder $request)
    {
      $folder = new Folder();
      $folder->title = $request->title;

      Auth::user()->folders()->save($folder);

      return redirect()->route('tasks.index', [
        'id' => $folder->id,
      ]);
    }
}
