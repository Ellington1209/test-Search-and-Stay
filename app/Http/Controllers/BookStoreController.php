<?php

namespace App\Http\Controllers;

use App\Models\BookStore;
use Illuminate\Http\Request;

class BookStoreController extends Controller
{
    public function __construct(BookStore $book){
        $this->bookStore = $book;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $books = BookStore::all();
        return response()->json($books);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = BookStore::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($book);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate($this->bookStore->rules());

        $book = new BookStore;
        $book->name = $request->name;
        $book->isbn = $request->isbn;
        $book->value = $request->value;
        $book->save();

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = $this->bookStore->find($id);

        if($book === null){
            return response()->json(['error' => 'impossible to update, book does not exist'], 404);
        }

        if($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($book->rules() as $input => $rule) {

                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())) {
                    $dynamicRule[$input] = $rule;
                }
            }


            $request->validate($dynamicRule);
        }else{

            $request->validate($book->rules());
        }

       $book->update($request->all());

       return $book;

    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = BookStore::find($id);
        if($book === null){
            return response()->json(['error' => 'impossible to delete, book does not exist'], 404);

        }
        $book->delete();
        return response()->json([
            'message' => 'Book deleted successfully',
        ]);
    }
}
