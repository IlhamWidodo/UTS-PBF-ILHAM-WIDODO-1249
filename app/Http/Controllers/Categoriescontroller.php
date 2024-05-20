<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categories;

class CategoriesController extends Controller
{
    //
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(422);
        }

        $payload = $validator->validated();

        Categories::create([
            'name'=> $payload['name']
        ]);

        return response()->json([
            'msg' => 'Categories successfully created'
        ]);
    }

    public function update(Request $request, $id){
        try {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
        
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(422);
        }

        $payload = $validator->validated();;
        $categories = Categories::findOrFail($id);

        Categories::where('id', $id)->update([
            'name' => $payload['name'],
        
        ]);
        
        return response()->json([
            'msg' => 'Product data is saved succesfully'
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg'=> $e->getMessage()
                ]);
        }
    }
    function showAll(){
        $categories = Categories::all();

        return response()->json([
            'msg' => 'Data Produk Keseluruhan',
            'data' => $categories
        ],201);
    }
    public function delete($id){
        // Cari produk berdasarkan ID
        $product = Categories::where('id', $id)->first();
    
        // Jika produk ditemukan, hapus produk tersebut
        if($product){
            Categories::where('id', $id)->delete();
    
            return response()->json([
                'msg'=> 'Data dengan product ID: '.$id.' berhasil dihapus'
            ], 200);
        } else {
            // Jika produk tidak ditemukan, kembalikan respons error
            return response()->json([
                'msg'=> 'Produk dengan ID: '.$id.' tidak ditemukan'
            ], 404);
        }
    }
}
