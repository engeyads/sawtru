<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Notification;
use App\Models\Comments;
use App\Models\purchases;
use App\Models\project_orders;
use Illuminate\Http\Request;
use DB;

class PurchasesController extends Controller
{
    /**
     * Defining Roles.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:list-purchases|create-purchases|edit-purchases|delete-purchases|delete-self-purchases|edit-self-purchases|list-self-purchases', ['only' => ['index','show','PDFDownload','addCmment']]);
        $this->middleware('permission:create-purchases', ['only' => ['create','store']]);
        $this->middleware('permission:edit-purchases|edit-self-purchases', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-purchases', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->cannot('list-purchases') && auth()->user()->can('list-self-purchases')) {
            $purchases = purchases::orderBy('created_at', 'DESC')->paginate(10);
            return view('pages.purchase_requests', compact('purchases'));
        }else if(auth()->user()->can('list-purchases')){
            $purchases = purchases::orderBy('created_at', 'DESC')->paginate(10);
            return view('pages.purchase_requests', compact('purchases'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        if($num = purchases::latest('ID')->first()){
            $num = str_pad(($num->id+1), 5, '0', STR_PAD_LEFT);
        }else{
            $num = 0;
            $num = str_pad(($num+1), 5, '0', STR_PAD_LEFT);
        }
        $number = 'PO'.date('y').''.$num;

        $data = User::orderBy('id','DESC')->paginate(100);
        return view('pages.purchases.create',compact('project','data','number'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function edit(purchases $purchases)
    {
        return view('pages.purchases.edit',compact('purchases'));
    }

    /**
     * Show the form for updating a new resource.
     *
     * @param  \App\purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, purchases $purchase)
    {
        $number = $purchase->serial_no;

        foreach($request->item as $val){
            if(array_key_exists('total', $val)){
                project_orders::where([['purchases_serial_no','=',$number],['id','=',$val['itm']]])->update([
                    "qty" => $val['qty'],
                    "price" => $val['price'],
                    "total" => $val['total'],
                ]);
            }
            if(array_key_exists('cancel', $val)){
                project_orders::where([['purchases_serial_no','=',$number],['id','=',$val['itm']]])->update([
                    "description" => $val['clarification'],
                    "canceled" => $val['cancel'],
                ]);
            }
            if(array_key_exists('done', $val)){
                project_orders::where([['purchases_serial_no','=',$number],['id','=',$val['itm']]])->update([
                    "status" => $val['done'],
                ]);
                $purchase->update([
                    "status" => $purchase->status+1,
                ]);
            }
        }

        return redirect()->route('purchases.show')
                        ->with('success','Order updated successfully');
    }

    /**
     * Show the form for updating a new resource.
     *
     * @param  \App\purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function update_order(Request $request)
    {
        $purchase = purchases::find($request->purchases);
        $number = $purchase->serial_no;
        $success = "fail";
        $message = "Nothing Changed!";

        foreach($request->item as $val){

            if(array_key_exists('total', $val)){
                project_orders::where([['purchases_serial_no','=',$number],['id','=',$val['itm']]])->update([
                    //"qty" => $val['qty'],
                    "price" => $val['price'],
                    "total" => $val['total'],
                ]);
            }
            if(array_key_exists('cancel', $val)){
                project_orders::where([['purchases_serial_no','=',$number],['id','=',$val['itm']]])->update([
                    "description" => $val['clarification'],
                    "canceled" => $val['cancel'],
                ]);
            }
            if(array_key_exists('done', $val)){
                project_orders::where([['purchases_serial_no','=',$number],['id','=',$val['itm']]])->update([
                    "status" => $val['done'],
                ]);
                $purchase->update([
                    "status" => $purchase->status+1,
                ]);
            }
            $success = "success";
            $message = "Order updated successfully";
        }
        return redirect()->route('purchases.index_order')
                        ->with($success,$message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function show(purchases $purchases)
    {
        return view('pages.purchases.show',compact('purchases'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        purchases::where('id', $id)->delete();
        return redirect()->route('purchases.index')
                        ->with('success','Order deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\project_orders  $project_orders
     * @return \Illuminate\Http\Response
     */
    public function destroy_Item($id)
    {
        project_orders::where('id', $id)->delete();
        return Redirect::back()
                        ->with('success','Order deleted successfully');
    }

    /**
     * pdf the specified resource from storage.
     *
     * @param  \App\purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function getPurchase($id){
        $po = purchases::find($id);
        return response()->json(json_encode($po->project_orders));
    }
}
