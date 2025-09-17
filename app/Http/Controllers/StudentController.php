<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = [
        //     [
        //         'id' => 1,
        //         'name' => 'John Doe',
        //         'age' => 25,
        //         'email' => 'john@example.com',
        //     ],
        //     [
        //         'id' => 2,
        //         'name' => 'Jane Smith',
        //         'age' => 22,
        //         'email' => 'jane@example.com',
        //     ],
        //     [
        //         'id' => 3,
        //         'name' => 'Alice Lee',
        //         'age' => 24,
        //         'email' => 'alice@example.com',
        //     ],
        //     [
        //         'id' => 4,
        //         'name' => 'Bob Chen',
        //         'age' => 23,
        //         'email' => 'bob@example.com',
        //     ],
        //     [
        //         'id' => 5,
        //         'name' => 'Charlie Wang',
        //         'age' => 26,
        //         'email' => 'charlie@example.com',
        //     ],
        // ];
        // $data = DB::select('select * from stu；dents');
        // get()  feachAll 多筆 array foreach
        // first() feach 單筆
        $data = DB::table('students')->where('id', 1)->get();
        $data = DB::table('students')->get();
        dd($data);

        // $data->id
        // $data['id']
        // $data.id
        return view('student.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // dd("student edit " . $id);
        return view('student.edit', ['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function excel()
    {
        dd('students excel ok');
        // return view('student.excel');
    }

    public function test()
    {
        $data = [
            [
                'name' => 'John Doe',
                'age' => 25,
                'email' => 'john@example.com',
            ],
            [
                'name' => 'Jane Smith',
                'age' => 22,
                'email' => 'jane@example.com',
            ],
            [
                'name' => 'Alice Lee',
                'age' => 24,
                'email' => 'alice@example.com',
            ],
            [
                'name' => 'Bob Chen',
                'age' => 23,
                'email' => 'bob@example.com',
            ],
            [
                'name' => 'Charlie Wang',
                'age' => 26,
                'email' => 'charlie@example.com',
            ],
        ];
        return view('student.test', ['data' => $data]);
    }

    public function child()
    {
        // dd('students child ok');
        return view('student.child');
    }

    public function html()
    {
        // dd('students child ok');
        return view('page.html');
    }

    public function js()
    {
        // dd('students child ok');
        return view('page.js');
    }

    public function php()
    {
        // dd('students child ok');
        return view('page.php');
    }

    public function python()
    {
        // dd('students child ok');
        return view('page.python');
    }



    public function list()
    {
        return view('student.list');
    }
}
