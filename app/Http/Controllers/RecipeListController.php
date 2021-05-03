<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\RecipeList;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class RecipeListController extends Controller
{

    // gets current user
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
    // gets all saved lists by user 
    public function index()
    {
        return $this->user->recipeLists()->get(['title', 'id']);
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
    // saves new list to user 
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        $list = new RecipeList();
        $list->title = $request->title;

        if ($this->user->recipeLists()->save($list)) {
            return response()->json([
                'success' => true,
                'recipeList' => $list
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'sorry, recipe list could not be added'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RecipeList  $recipeList
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list = $this->user->recipeLists()->find($id);

        if (!$list) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, list with id ' . $id . ' cannot be found'
            ]);
        }
        return $list;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RecipeList  $recipeList
     * @return \Illuminate\Http\Response
     */
    public function edit(RecipeList $recipeList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RecipeList  $recipeList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $list = $this->user->recipeLists()->find($id);

        if (!$list) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }

        $updated = $list->fill($request->all())->save();

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product could not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RecipeList  $recipeList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $list = $this->user->recipeLists()->find($id);

        if (!$list) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, list with id ' . $id . ' cannot be found'
            ], 400);
        }

        if ($list->delete()) {
            return response()->json([
                'succes' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'List could not be deleted'
            ]);
        }
    }
}