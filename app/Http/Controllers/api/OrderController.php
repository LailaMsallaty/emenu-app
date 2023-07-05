<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($request)
    {
        try{
            $orders = (isset($request->after_date)) ? Order::where('order_date','>',$request->after_date)->get() : Order::all();
            $order_list=[];
            if ($orders->count()>0) {
                foreach ($orders as $order) {
                    $order_list[] = array(
                        "order_id"=>$order->order_id,
                        "order_date"=>$order->order_date,
                        "client_name"=>$order->client_name,
                        "client_email"=>$order->client_email,
                        "tablecode"=>$order->tablecode,
                        "ordertotal"=>$order->ordertotal,
                        "orderdetail"=> json_decode($order->orderdetail)
                    );
                }
            }
            return $order_list;

        }catch (\Exception $e) {
            return  response()->json([
             'message'=>'Something Went Wrong',
             'errors'=>$e->getMessage()
         ]);
     }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
