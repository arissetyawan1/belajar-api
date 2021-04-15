<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataProducts = Products::all();
        return response()->json([
            'Message' => 'Success Get All Datas',
            'Product' => ProductsResource::collection($dataProducts)
        ], 200);
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
        // validate data product
        $dataValidation = $request->validate(
            [
                'nama' => 'required|min:2',
                'description' => 'required|max:255|min:1',
                'price' => 'required|numeric'
            ],
            [
                'required' => 'Field ini harus diisi',
                'numeric' => 'Field ini harus diisi dengan angka',
                'nama.min' => 'Isi dengan minimal 2 karakter',
                'description.min' => 'Isi dengan minimal 1 karakter'
            ]
        );

        // insert data product
        Products::create($dataValidation);

        return response()->json([
            'Message' => 'Data Berhasil ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getProduct = Products::find($id);
        if (is_null($getProduct)) {
            return response()->json([
                'Message' => "The product not found"
            ]);
        } else {
            return response()->json([
                "Product Data" => new ProductsResource($getProduct)
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // get data by Id
        $getData = Products::find($id);
        $getData->update($request->all());
        return response()->json([
            'Message' => 'Update Successfully',
            'Data Update' => new ProductsResource($getData)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getData = Products::find($id);
        $getData->delete();
        return response()->json([
            "Message" => "Congrats You had deleted 1 data"
        ]);
    }
}
