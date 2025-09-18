<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Phone;
use App\Models\Hobby;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = Student::all();
        $data = Student::with('phoneRelation', 'hobbiesRelation')->get();
        // $studentHobbies = $data[0]->hobbiesRelation;
        // dd($studentHobbies);
        // dd($data);

        // $data = [
        //     [
        //         'id' => 1,
        //         'name' => 'amy',
        //         'phone' => '09123',
        //         'hobbies' => ['php','python'],
        //         'hobbyString' => 'PHP, Python'
        //     ],
        //     [
        //         'id' => 2,
        //         'name' => 'bob',
        //         'phone' => '0922',
        //         'hobbies' => []
        //     ]
        // ];

        // 我在前端foreach many
        // 我在後端foreach many

        foreach ($data as $key => $value) {
            $dataHobbies = $value->hobbiesRelation;

            // $hobbyString = '';
            $hobbyArray = [];
            foreach ($dataHobbies as $keyHobby => $valueHobby) {
                array_push($hobbyArray, $valueHobby->hobby);
            };

            $hobbyString = join(',', $hobbyArray);
            //  dd($hobbyString);
            $data[$key]['hobbyString'] = $hobbyString;
            // dd($data[$key']
        }

        // dd($data);
        return view('student.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd('hello students create');
        return view('student.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $input = $request->all();

        //   array:3 [▼ // app\Http\Controllers\StudentController.php:87
        //   "name" => "amy"
        //   "phone" => "123"
        //   "hobbies" => "PHP,PYTHON"
        // ]

        $input = $request->except('_token');

        // dd($input);
        // ps. 主表存檔 才會有id


        // 主表
        $data = new Student;
        $data->name = $input['name'];
        $data->save();


        // phone子表 也要存檔
        // phone子表
        $dataPhone = new Phone;
        $dataPhone->student_id = $data->id;
        $dataPhone->phone = $input['phone'];
        $dataPhone->save();

        // 新增hobby子表
        // "hobbies" => "PHP,JS"
        // string to array
        $hobbyArray = explode(',', $input['hobbies']);
        // dd($hobbyArray);

        foreach ($hobbyArray as $key => $value) {
            $dataHobby = new Hobby;
            $dataHobby->student_id = $data->id;
            $dataHobby->hobby = $value;
            $dataHobby->save();
        }

        // return redirect('/students');
        return redirect()->route('students.index');
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
        // dd("students id = $id edit ok");
        // $data = [
        //     'id' => $id
        // ];
        $data = Student::with('phoneRelation', 'hobbiesRelation')->find($id);
        // dd($data);

        $dataHobbies = $data->hobbiesRelation;

        // $hobbyString = '';
        $hobbyArray = [];
        foreach ($dataHobbies as $keyHobby => $valueHobby) {
            array_push($hobbyArray, $valueHobby->hobby);
        };

        $hobbyString = join(',', $hobbyArray);
        //  dd($hobbyString);
        $data['hobbyString'] = $hobbyString;
        // dd($data[$key']

        // dd($data);
        return view('student.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd('update ok');
        // dd($data);

        // array:3 [▼ // app\Http\Controllers\StudentController.php:158
        //   "name" => "amy"
        //   "phone" => "0911"
        //   "hobbies" => "PHP,JS"
        // ]

        // form input
        $input = $request->except('_token', '_method');
        // dd($input);



        // 抓主表資料
        $data = Student::find($id);
        $data->name = $input['name'];
        $data->save();

        // 刪除phone子表
        Phone::where('student_id', $id)->delete();

        // 新增phone子表
        $dataPhone = new Phone;
        $dataPhone->student_id = $data->id;
        $dataPhone->phone = $input['phone'];
        $dataPhone->save();

        // 刪除hobby子表
        Hobby::where('student_id', $id)->delete();

        // 新增hobby子表
        // "hobbies" => "PHP,JS"
        // string to array
        $hobbyArray = explode(',', $input['hobbies']);
        // dd($hobbyArray);

        foreach ($hobbyArray as $key => $value) {
            $dataHobby = new Hobby;
            $dataHobby->student_id = $data->id;
            $dataHobby->hobby = $value;
            $dataHobby->save();
        }

        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd("students destroy ok $id");

        // 先刪除子表
        Phone::where('student_id', $id)->delete();
        Hobby::where('student_id', $id)->delete();
        Student::where('id', $id)->delete();
        // $data = Student::find($id);
        // $data->delete();
        return redirect()->route('students.index');
    }

    public function excel()
    {
        dd('students excel ok');
        // return view('student.excel');
    }

    public function test()
    {
        // dd('students excel ok');

        $data = 'test ok';

        $data = [
            [
                'id' => 1,
                'name' => 'amy',
            ],
            [
                'id' => 2,
                'name' => 'bob',
            ],
            [
                'id' => 3,
                'name' => 'cat',
            ]
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
}
