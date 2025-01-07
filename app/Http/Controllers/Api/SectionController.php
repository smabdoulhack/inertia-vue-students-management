<?php

namespace App\Http\Controllers\Api;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Http\Requests\Api\ListSectionRequest;

class SectionController extends Controller
{
    public function __invoke(ListSectionRequest $request)
    {
        $sections = Section::where('class_id', $request->class_id)->get();

        return SectionResource::collection($sections);
    }
}
