<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Paymente_Product;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function pay(Request $request)
    {
        try {
            DB::beginTransaction();
            $value = 0;
            $type = $request->query('tipo');
            if (!is_null($type) && $type == 'cartao'){
                foreach ($request->products as $productJson){
                    $product = json_decode($productJson);
                    if($this->checkQuantity($product->id, $product->quantity)[0]){
                        $value += $this->summation($product->id);
                    }else{
                        return response()->json('quantidade insdisponivel de '.$this->checkQuantity($product->id, $product->quantity)[1]['name'], 400);
                    }
                }
                $pay = $this->create($request->all(), $value);
                $this->paymentProduct($request->products, $pay);

                DB::commit();

            }
        }catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage());
        }
    }

    private function checkQuantity($id, $quantity)
    {
        try {
            $product = Product::findOrFail($id);
            if($product->quantity >= $quantity) {
                $this->withdraw($product, $quantity);
                return [true];
            }
            return [false,$product];
        }catch (\Exception $exception){
            return [false];
        }
    }

    private function withdraw($product, $quantity){
        $product->quantity -= $quantity;
        $product->update();
    }

    private function create($pay, $value){
        $payment = Payment::create([
            'card' => $pay['card'],
            'document' => $pay['document'],
            'type' => $pay['type'],
            'buy_date' => date('Y-m-d', strtotime($pay['buy_date'])),
            'value' => $value
        ]);
        return $payment;
    }

    private function summation($id){
        $product = Product::findOrFail($id);
        return $product->value;
    }

    private function paymentProduct($productsjson, $pay){
        foreach ($productsjson as $product){
            $product = json_decode($product);
            Paymente_Product::create([
                'payment_id' => $pay->id,
                'product_id' => $product->id
            ]);
        }
    }
}
