<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{

    public function index(Request $request)
    {
        $studentsQuery = Student::query();

        $this->applySearch($studentsQuery, $request->search);

        $students = StudentResource::collection($studentsQuery->paginate(10));

        // dd($students);

        return Inertia('Students/Index', [
            'students' => $students,
            'search' => $request->search ?? '',
        ]);
    }

    protected function applySearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    public function create()
    {
        $classes = StudentResource::collection(Classes::all());
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
        $classes = StudentResource::collection(Classes::all());

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
