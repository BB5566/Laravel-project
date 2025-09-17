<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Student::all();
        // dd($data);
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

        // 取得除了 CSRF 欄位 (_token) 以外的所有輸入資料
        // 這樣可以避免直接使用 $request->all() 帶入 _token
        // 造成不必要的資料注入到模型或資料庫
        $input = $request->except('_token');

        // 如果需要除錯，可以解除下面註解來檢視輸入內容
        // dd($input);

        // 建立一個新的 Student 模型實例，準備填入欄位並儲存
        $data = new Student;

        // 將輸入的 name 欄位指定給模型的 name 屬性
        // 假設前端表單有 <input name="name">，這裡會取出該值
        $data->name = $input['name'];

        // 呼叫 save() 將模型資料寫入資料庫（INSERT）
        // 如果模型有設定 timestamps，會自動填入 created_at/updated_at
        $data->save();

        // 儲存完成後導回學生列表頁面
        // 這裡使用硬編碼路徑 '/students'，也可以改為 route() 幫助函式
        return redirect('/students');
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
        $data = Student::find($id);

        return view('student.edit', ['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // dd('update ok');
        // dd($data);

        // form input
        $input = $request->except('_token');

        // 抓id 單筆資料
        $data = Student::find($id);
        $data->name = $input['name'];
        $data->save();

        return redirect()->route('students.index');
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
