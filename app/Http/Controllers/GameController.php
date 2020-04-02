<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests\GameRequest;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Game::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GameRequest $request)
    {
        $day = Game::create($request->validate());
        return $day;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        return Game::findOrFail($game);
    }

    /**
     * Update the specified resource in storage.
     * @param GameRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GameRequest $request, $id)
    {
        $game = Game::findOrFail($id);
        $game->fill($request->except(['game_id']));
        $game->save();
        return response()->json($game);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameRequest $request, $id)
    {
        $game = Game::findOrFail($id);
        if ($game->delete()) return response(null, 204);
    }
}
