<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabelRequest;
use App\Http\Resources\LabelResource;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $labels = Label::all();

        return LabelResource::collection($labels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LabelRequest $request
     *
     * @return LabelResource
     */
    public function store(LabelRequest $request): LabelResource
    {
        $label = Label::create($request->all());

        return LabelResource::make($label);
    }

    /**
     * Display the specified resource.
     *
     * @param Label $label
     *
     * @return LabelResource
     */
    public function show(Label $label): LabelResource
    {
        return LabelResource::make($label);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Label $label
     *
     * @return LabelResource
     */
    public function edit(Label $label): LabelResource
    {
        return LabelResource::make($label);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LabelRequest $request
     * @param Label $label
     *
     * @return LabelRequest
     */
    public function update(LabelRequest $request, Label $label): LabelResource
    {
        $label->update($request->all());

        return LabelResource::make($label);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Label $label
     *
     * @return LabelResource
     */
    public function destroy(Label $label): LabelResource
    {
        $label->delete();

        return LabelResource::make($label);
    }
}
