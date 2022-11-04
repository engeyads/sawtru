<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function notification(Request $request){
        $request->validate([
            'title'=>'required',
            'message'=>'required'
        ]);

        try{
            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

            //Notification::send(null,new SendPushNotification($request->title,$request->message,$fcmTokens));

            /* or */

            //auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));

            /* or */

            Larafirebase::withTitle($request->title)
                ->withBody($request->message)
                ->sendMessage($fcmTokens);

            return redirect()->back()->with('success','Notification Sent Successfully!!');

        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error','Something goes wrong while sending notification.');
        }
    }

    public function updateToken(Request $request){
        try{
            $request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }


    /**
     * Show the application dashboard.
     *
     *
     */
    public function notifications(request $request)
    {
        $msg ='';
        $cnt='';
        $id = auth()->user()->id;
        if(auth()->user()->getRoleNames() == 'Admin'){
            $msg = DB::table('notifications')->where(['toid','=',$id])->orWhere('toid', '=', '0')->orderBy('created_at', 'DESC');

        }else{
            $msg = DB::table('notifications')->where('toid','=',$id)->orderBy('created_at', 'DESC');

        }
        //$messages = DB::table('notifications')->Where('toid', '=', '0')->orderBy('created_at', 'DESC');


            return compact('msg');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->user()->can('list-all-project')){
            $projects = Project::orderBy('created_at', 'DESC')->paginate(10);
            return view('pages.main',compact('projects'));
        }
        if($request->user()->can('list-project')){
            $projects = Project::orderBy('created_at', 'DESC')->where('admin',$request->user()->id)->paginate(10);
            return view('pages.main',compact('projects'));
        }
        if($request->user()->can('list-self-project')){
            $projects = Project::orderBy('created_at', 'DESC')->where('uid',$request->user()->id)->paginate(10);
            return view('pages.main',compact('projects'));
        }
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function msgtest()
    {
        return view('msgtest');
    }
}
