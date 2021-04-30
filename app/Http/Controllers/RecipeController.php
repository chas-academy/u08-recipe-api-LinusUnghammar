<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class RecipeController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user->recipes()->get(['id', 'label', 'image', 'recipelist_id', 'user_id']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'label' => 'required',
            'image' => 'required',
            'recipelist_id' => 'required',
        ]);

        $recipe = new Recipe();
        $recipe->label = $request->label;
        $recipe->image = $request->image;
        $recipe->recipelist_id = $request->recipelist_id;
        $recipe->user_id = $request->user_id;

        if ($this->user->recipes()->save($recipe)) {
            return response()->json([
                'success' => true,
                'recipe' => $recipe
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'sorry, recipe could not be added'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = $this->user->recipes()->find($id);

        if(!$recipe){
            return response()->json([
                'success' => false,
                'message' => 'Sorry, recipe with id '. $id . ' cannot be found'
            ]);
        }
        return $recipe;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe = $this->user->recipes()->find($id);

        if (!$recipe) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, recipe with id ' . $id . ' cannot be found'
            ], 400);
        }

        if ($recipe->delete()) {
            return response()->json([
                'succes' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'recipe could not be deleted'
            ]);
        }
    }
}