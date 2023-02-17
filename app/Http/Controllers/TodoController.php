<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{

    public function index()
    {
        //take the user Id
        $userId = Auth::user()->id;
        //getting the todos of that user
        $todos = Todo::where(['user_id' => $userId])->get();
        //returning the todos
        return view('todo.list', ['todos' => $todos]);
    }

    //creation of todos
    public function create()
    {
        //showing the todo/add.blade.php
        return view('todo.create');
    }
    //storing the todos

    public function store(Request $request)
    {
        //getting the user id
        $userId = Auth::user()->id;
        //getting the user entered input using $request
        $input = $request->input();
        //extracting the user_id from the input
        $input['user_id'] = $userId;
        //setting the todo status from the input 
        $todoStatus = Todo::create($input);
        //checking the todo status
        if ($todoStatus) {
            //if true the show a success message
            $request->session()->flash('success', 'Todo successfully added');
        } else {
            //if false show a error message
            $request->session()->flash('error', 'Oops something went wrong, Todo not saved');
        }
        //redirect to todo route
        return redirect('todo');
    }

    //show function
 
    public function show($id)
    {
        //user_id
        $userId = Auth::user()->id;
        //getting the specific todo created by the user
        $todo = Todo::where(['user_id' => $userId, 'id' => $id])->first();
        //checking the todo exist or not
        if (!$todo) {
            //if not show the not found message
            return redirect('todo')->with('error', 'Todo not found');
        }
        //return the todo/view.blade.php and pass the todo 
        return view('todo.view', ['todo' => $todo]);
    }
 

    //edit function
    public function edit($id)
    {
        //user_id
        $userId = Auth::user()->id;
        //getting the specific todo created by the user
        $todo = Todo::where(['user_id' => $userId, 'id' => $id])->first();
        if ($todo) {
            //if todo exists the show todo/edit.blade.php 
            return view('todo.edit', ['todo' => $todo]);
        } else {
            //if not then show not found
            return redirect('todo')->with('error', 'Todo not found');
        }
    }
    //update function
    public function update(Request $request, $id)
    {
        //user_id
        $userId = Auth::user()->id;
        //find todo by the id from the (url/params)
        $todo = Todo::find($id);

        //if checking the todo
        if (!$todo) {
            return redirect('todo')->with('error', 'Todo not found.');
        }
        //getting the inputs
        $input = $request->input();
        //extracting the user id
        $input['user_id'] = $userId;
        //updating the todo status
        $todoStatus = $todo->update($input);

        if ($todoStatus) {
            //if todoStatus is true then show success
            return redirect('todo')->with('success', 'Todo successfully updated.');
        } else {
            //if not the show error
            return redirect('todo')->with('error', 'Oops something went wrong. Todo not updated');
        }
    }

    
//delete
    public function destroy($id)
    {
        //user_id
        $userId = Auth::user()->id;
        //getting the specific todo created by the user
        $todo = Todo::where(['user_id' => $userId, 'id' => $id])->first();
        //response status = response message = ' '
        $respStatus = $respMsg = '';
        //if todo does not exists the set respStatus to error and response message to not found
        if (!$todo) {
            $respStatus = 'error';
            $respMsg = 'Todo not found';
        }
        //setting the todoDelStatus = taking the todo then calling delete function 
        $todoDelStatus = $todo->delete();
        //setting the respStatus according to the todoDelStatus
        if ($todoDelStatus) {
            $respStatus = 'success';
            $respMsg = 'Todo deleted successfully';
        } else {
            $respStatus = 'error';
            $respMsg = 'Oops something went wrong. Todo not deleted successfully';
        }
        //redirect to todo route with respStatus and respMsg
        return redirect('todo')->with($respStatus, $respMsg);
    }
}
