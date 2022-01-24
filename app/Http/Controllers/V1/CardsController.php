<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class CardsController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token != '')
            //En caso de que requiera autentifiación la ruta obtenemos el usuario y lo almacenamos en una variable, nosotros no lo utilizaremos.
            $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //to list all cards
        return Card::get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //to validate card data
        $data = $request->only('name', 'first_edition', 'code', 'type', 'sub_type', 'state', 'description', 'price', 'image');
        $validator = Validator::make($data, [
            'name' => 'required|max:50|string',
            'first_edition' => 'required|boolean',
            'code' => 'required|max:50|string',
            'type' => 'required|string',
            'sub_type' => 'required|max:50|string',
            'state' => 'required|integer',
            'description' => 'required|max:150|string',
            'price' => 'required|numeric',
            'image' => 'max:150|string'
        ]);

        //if the validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //To create for a new card
        $card = Card::create([
            'name' => $request->name,
            'first_edition' => $request->first_edition,
            'code' => $request->code,
            'type' => $request->type,
            'sub_type' => $request->sub_type,
            'state' => $request->state,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image
        ]);

        return response()->json([
            'message' => 'Card created',
            'data' => $card
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //to search for the card
        $card = Card::find($id);

        //if the card doesn´t exist we return an error
        if (!$card) {
            return response()->json([
                'message' => 'Card not found.'
            ], 404);
        }

        //If the card exist we return the card information
        return $card;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //to validate card data
        $data = $request->only('name', 'first_edition', 'code', 'type', 'sub_type', 'state', 'description', 'price', 'image');
        $validator = Validator::make($data, [
            'name' => 'required|max:50|string',
            'first_edition' => 'required|boolean',
            'code' => 'required|max:50|string',
            'type' => 'required|enum|string',
            'sub_type' => 'required|max:50|string',
            'state' => 'required|integer',
            'description' => 'required|max:150|string',
            'price' => 'required|float',
            'image' => 'max:150|string'
        ]);

        //if the validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //To search for card
        $card = Card::findOrfail($id);

        //To update for card
        $card->update([
            'name' => $request->name,
            'first_edition' => $request->first_edition,
            'code' => $request->code,
            'type' => $request->type,
            'sub_type' => $request->sub_type,
            'state' => $request->state,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image
        ]);

        return response()->json([
            'message' => 'Card updated successfully',
            'data' => $card
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //to search for the card
        $card = Card::findOrfail($id);

        //To delete the card
        $card->delete();

        return response()->json([
            'message' => 'Card deleted successfully'
        ], Response::HTTP_OK);
    }
}
