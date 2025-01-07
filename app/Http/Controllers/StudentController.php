<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\StudentResource;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{

    public function index(Request $request)
    {
        $studentsQuery = Student::search($request);

        $classes = StudentResource::collection(Classes::all());

        if ($request->class_id) {
            $studentsQuery->where('class_id', $request->class_id);
        }

        $students = StudentResource::collection($studentsQuery->paginate(10));

        return Inertia('Students/Index', [
            'students' => $students,
            'classes' => $classes,
            'class_ids' => $request->class_id ?? '',
            'search' => $request->search ?? '',
        ]);
    }

    protected function applySearch($query, $search)
    {

    }

    public function create()
    {
        $classes = ClassesResource::collection(Classes::all());
        return Inertia('Students/Create', [
            'classes' => $classes,
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        Student::create($request->validated());

        return redirect()->route('students.index');
    }

    public function edit(Student $student)
    {
        $classes = ClassesResource::collection(Classes::all());

        return Inertia('Students/Edit', [
            'classes' => $classes,
            'student' => StudentResource::make($student),
        ]);

    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());
        return redirect()->route('students.index');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index');
    }
}
