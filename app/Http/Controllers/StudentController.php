<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index()
    {
        // $students = Student::all();
        $students = StudentResource::collection(Student::paginate(10));

        // dd($students);

        return Inertia('Students/Index', [
            'students' => $students,
        ]);
    }

    public function create()
    {
        $classes = StudentResource::collection(Classes::all());
        return Inertia('Students/Create', [
            'classes' => $classes,
        ]);
    }

    public function store(Request $request) {}
}
