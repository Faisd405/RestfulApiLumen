<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Services\BookServices;

class BookController extends Controller
{

    protected $book;
    protected $bookServices;

    public function __construct(Book $book, BookServices $bookServices)
    {
        $this->book = $book;
        $this->bookServices = $bookServices;
    }

    public function checkAuth()
    {
        if (!auth()->check()) {
            return false;
        }
        return true;
    }

    public function index()
    {
        $books = $this->book->all();
        return response()->json([
            'status' => 'success',
            'message' => 'List All Books',
            'data' => $books
        ], 200);
    }

    public function store(Request $request)
    {

        if (!$this->checkAuth()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('image')){
            $this->bookServices->uploadImage($request);
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        } else {
            $book = $this->book->create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Book Created',
                'data' => $book
            ], 201);
        }
    }

    public function show($id)
    {
        $book = $this->book->find($id);
        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'Book Not Found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Book Found',
            'data' => $book
        ], 200);
    }

    public function update(Request $request, $id)
    {
        if (!$this->checkAuth()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $book = $this->book->find($id);
        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'Book Not Found'
            ], 404);
        }
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        } else {
            $book->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Book Updated',
                'data' => $book
            ], 200);
        }
    }

    public function destroy($id)
    {
        if (!$this->checkAuth()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $book = $this->book->find($id);
        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'Book Not Found'
            ], 404);
        }
        $book->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Book Deleted'
        ], 200);
    }
}
