<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class ProductController extends BaseController {

    public function storeProduct(Request $request) {

        $validator = \Validator::make($request->all(), [
            'product_name' => 'required|string|min:3|max:255',
            'product_quantity' => 'required|numeric',
            'product_price' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fails',
                'message' => 'input validation failed',
                'data' => $validator->errors()
            ]);
        }

        try {

            $payload = [
                'product_name' => $request->input('product_name'),
                'product_quantity' => $request->input('product_quantity'),
                'product_price' => $request->input('product_price'),
                'price_total' => number_format(($request->input('product_quantity') * $request->input('product_price')), 2, '.', ','),
                'date_time' => date('jS M, Y h:ia')
            ];

            if (!Storage::disk('local')->exists('datastore.json')) {
                Storage::disk('local')->put('datastore.json','{}');
            }

            $datastore = Storage::disk('local')->get('datastore.json');

            $data = json_decode($datastore, true); \Log::info($data);

            $data[] = $payload; 
            
            $updated = json_encode($data);
            $datastore = Storage::disk('local')->put('datastore.json', $updated);

            return response()->json([
                'status' => 'success',
                'message' => 'The data was updated',
                'data' => $data
            ]);

        } catch(\Exception $e) { \Log::error($e);

            return response()->json([
                'status' => 'error',
                'message' => 'the request failed',
                'data' => null
            ]);

        }

    }

    public function getProducts() {

        try {
            $datastore = Storage::disk('local')->get('datastore.json');

            $data = json_decode($datastore, true); 

            if (count($data) > 0) {
                $collection =   \collect($data)
                                ->values();
            } else {
                $collection = [];
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'The data was updated',
                'data' => $collection
            ]);

        } catch(\Except $e) { \Log::info($e);

            return response()->json([
                'status' => 'error',
                'message' => 'the request failed',
                'data' => null
            ]);

        }
    }


}