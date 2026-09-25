<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Notificationtb;
use Notification;
use App\Notifications\ProjectsNotification;
use App\Models\Comments;
use App\Models\project_metals;
use App\Models\project_motors;
use App\Models\project_others;
use App\Models\project_lasers;
use App\Models\project_assembling_photos;
use App\Models\project_diagram_photos;
use App\Models\project_horizontal_photos;
use App\Models\project_vertical_photos;
use App\Models\Purchases;
use App\Models\project_orders;
use Illuminate\Http\Request;
use DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:list-project|create-project|edit-projects|delete-projects|assembling-projects|list-all-project', ['only' => ['index','show','PDFDownload','addCmment']]);
        $this->middleware('permission:create-project', ['only' => ['create','store','assembling']]);
        $this->middleware('permission:edit-projects|assembling-projects', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-projects', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Admin
        if($request->user()->can('list-all-project')){
            $projects = Project::orderBy('created_at', 'DESC')->paginate(10);
            return view('pages.requests', compact('projects'));
        }
        // Normal Manager
        if($request->user()->can('list-project')){
            $projects = Project::orderBy('created_at', 'DESC')->where('admin',$request->user()->id)->paginate(10);
            return view('pages.requests', compact('projects'));
        }
        //  Employee
        if ($request->user()->can('list-self-project')) {
            $projects = Project::orderBy('created_at', 'DESC')->where('UID',$request->user()->id)->paginate(10);
            return view('pages.requests', compact('projects'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function purchases()
    {
        if (auth()->user()->cannot('list-purchases') && auth()->user()->can('list-self-purchases')) {
            $projects = Purchases::select('*')->paginate(10);
            //$project = $orders->project_orders('created_at', 'DESC')->paginate(10);
            return view('pages.purchase_requests', compact('project'));
        }else if(auth()->user()->can('list-purchases')){
            $projects = Purchases::select('*')->paginate(10);
            //$project = $orders->project_orders()->where('project.admin',auth()->user()->id)->orderBy('created_at', 'DESC')->paginate(10);
            return view('pages.purchase_requests', compact('projects'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // create a serial number for the new project init 0000000001
        if($num = Project::latest('ID')->first()){
            $num = str_pad(($num->id+1), 5, '0', STR_PAD_LEFT);
        }else{
            $num = 0;
            $num = str_pad(($num+1), 5, '0', STR_PAD_LEFT);
        }
        $number = date('y').''.$num;
        // gets users to show only admins in the select admin
        $data = User::orderBy('id','DESC')->paginate(100);
        return view('pages.projects.create',compact('data','number'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function assembling(Project $project)
    {
        $data = User::orderBy('id','DESC')->paginate(100);
        return view('pages.projects.assembling',compact('project','data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Only allow safe image uploads (type and size).
        $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        //$userSchema = User::first();
        $id = auth()->user()->id;
        $dtnow = date('Y-m-d');
        //$inDate = date('Y-m-d', strtotime($dtnow. ' + ' . $request->dtime . ' days'));

        if($num = Project::latest('ID')->first()){
            $num = str_pad(($num->id+1), 5, '0', STR_PAD_LEFT);
        }else{
            $num = 0;
            $num = str_pad(($num+1), 5, '0', STR_PAD_LEFT);
        }
        $number = date('y').''.$num;

        $rb = $request->get('torp');
        if($rb == 'traditional'){
            $rb = 0;
        }
        else{
            $rb = 1;
        }

        // upload the photo for the given project
        if($request->hasfile('photo')){
            $name=$request->photo->getClientOriginalName();
            $newName = date('dmYHis') . '.'.$request->photo->getClientOriginalExtension();
            $request->photo->move(public_path().'/uploads/', $newName);
            $newpht = $newName;
        }

        // inserts new record to projects database

        $dts =
        [
            'NE' => $dtnow,
            'AS' => '',
            'PO' => '',
            'PU' => ''
        ];

        $pid = Project::create([
            'serial_no' => $number,
            'uid' => $id,
            'admin' => $request->adminselect,
            'pname' => $request->pname,
            'photo' => $newpht,
            'length' => $request->L,
            'width' => $request->W,
            'height' => $request->H,
            'unit' => $request->units1,
            'volume' => $request->volume,
            'cubic_unit' => $request->units2,
            'type' => $rb,
            'machine_voltage' => $request->voltage,
            'details' => $request->edetails,
            'totlal' => 0,
            'phases_times' => $dts,
            'daysneed' => $request->dtime,
            'isApproved' => 0,
        ]);

        foreach($request->metals as $key){
            project_metals::create([
                'project_serial_no' => $number,
                'metal_type' => $key['metal'],
                'thickness' => $key['thickness'],
                'unit' => $key['unit'],
                'title' => $key['title'],
            ]);
        }

        foreach($request->motors as $key){
            project_motors::create([
                'project_serial_no' => $number,
                'motor' => $key['motor'],
                'power' => $key['power'],
                'unit' => $key['unit'],
                'title' => $key['title'],
            ]);
        }

        foreach($request->others as $key){
            project_others::create([
                'project_serial_no' => $number,
                'title' => $key['title'],
                'info' => $key['info'],
                'details' => $key['details'],
            ]);
        }

        project_lasers::create([
            'project_serial_no' => $number ,
            'laser_cutting' => null ,
            'cnc' => null ,
            'torna' => null ,
            'assembling' => null ,
            'electric_and_automation' => null ,
            'total' => null,
        ]);


        $msg = [
            'greeting' => 'Hi '. auth()->user()->name . ',',
            'body' => 'This is the project assigned to you.',
            'thanks' => 'Thank you this is from sawtru.com.tr',
            'actionText' => 'View Project',
            'actionURL' => url('dashboard/projects/'.$pid->id),
            'id' => $pid->id
        ];

        $admin = User::where('id',$request->adminselect)->get();

        // Notify by Email
        Notification::send(auth()->user(), new ProjectsNotification($msg));
        Notification::send($admin, new ProjectsNotification($msg));

        // dd('Task completed!');
        Notificationtb::create([
            'type' => "success",
            'data' => "new Project with SN: ".$number." Has been Created by: ". auth()->user()->name,
            'tousr' => "0",
            'byusr' => $id,
        ]);

        return redirect()->route('projects.create')
                        ->with('success','Project created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addComment(Request $request)
    {
        // $userSchema = User::first();
        $id = auth()->user()->id;
        $dtnow = date('Y-m-d H:i:s');
        $inDate = date('Y-m-d', strtotime($dtnow. ' + ' . $request->dtime . ' days'));

        $input = Comments::create([
            'project_serial_no' => $request->serial,
            'byid' => $id,
            'toid' => $request->toid,
            'content' => $request->content,
            'created_at' => $dtnow,
        ]);

        $project = Project::where('serial_no',$request->serial)->get();

        $byusr = User::where('id',$project[0]->uid)->get();
        $tousr = User::where('id',$project[0]->admin)->get();

        $msg = [
            'greeting' => 'Hi '. $byusr[0]->name . ',',
            'body' => auth()->user()->name . ' has Commented ' . $request->content . ' on Project you are assigned on ' . $project[0]->pname,
            'thanks' => 'Thank you this is from sawtru.com.tr',
            'actionText' => 'View Project',
            'actionURL' => url('dashboard/projects/' . $project[0]->id . '/#cmnt' . $input->id),
            'id' => $project[0]->id
        ];
        Notification::send($byusr, new ProjectsNotification($msg));
        Notification::send($tousr, new ProjectsNotification($msg));
        if(auth()->user()->id != $byusr[0]->id && auth()->user()->id != $tousr[0]->id){
            Notification::send(auth()->user(), new ProjectsNotification($msg));
        }

        // dd('Task completed!');
        Notificationtb::create([
            'type' => "success",
            'data' => "new Project with SN: ".$request->serial." Has been Created by: ". auth()->user()->name,
            'tousr' => "0",
            'byusr' => $id,
        ]);

        return response()->json([
            "status" => true,
            "data" => $input
        ]);



    }

    public function destroyComment($id)
    {
        $uid = auth()->user()->id;
        $dt = date('Y-m-d H:i:s');
        $input = Comments::find($id)->update([
            'available' => 0,
            'removed_at' => $dt,
            'removed_by' => $uid
        ]);
        return response()->json([
            "status" => $input,
            "data" => ["id" => $id]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $endTimeStamp = $project->drawing_time;
        //$endTimeStamp = strtotime($project->drawing_time);
        //$timeDiff = abs($endTimeStamp - strtotime(date('Y-m-d')));
        //$numberDays = $timeDiff/86400;
        //$numberDays = intval($numberDays);

        return view('pages.projects.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('pages.projects.edit',compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        if(auth()->user()->isAdmin()){
            $dtnow = date('Y-m-d');
            $inDate = date('Y-m-d', strtotime($dtnow. ' + ' . $project->daysneed . ' days'));

            $phs = 'NE';
            switch($project->phase){
                case 0: $phs = 'NE';
                break;
                case 1: $phs = 'AS';
                break;
                case 2: $phs = 'PO';
                break;
                case 3: $phs = 'PU';
                break;
            }

            if($request->approval == 1){
                $dts = $project->phases_times;
                $dts[$phs] = $dtnow;
                $project->update([
                    'due_time' => $inDate,
                    'isApproved' => $request->approval,
                    'phases_times' => $dts,
                ]);
            }elseif($request->approval == -1){
                $project->update([
                    'phase' => ($project->phase-1),
                    'isApproved' => 1,
                ]);
            }
        }elseif ($request->has('assembling')) {
            // Only allow safe image uploads for the assembling photo sets.
            $request->validate([
                'motors.*.motorreal' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
                'asd.*'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
                'mtd.*'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
                'Horizontal.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
                'Vertical.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            ]);

            $id = auth()->user()->id;
            $dtnow = date('Y-m-d');
            $inDate = date('Y-m-d', strtotime($dtnow. ' + ' . $request->dtime . ' days'));

            $serialno = $project->serial_no;

            if($project->phase == 0){
                $newpht='';
                $i=0;

                foreach($request['motors'] as $key){
                    // upload the photo for the given project

                    if(array_key_exists('motorreal', $key)){

                        $name=$key['photo']->getClientOriginalName();
                        $newName = date('dmYHis') . 'mtr' . $i++ . '.'.$key['photo']->getClientOriginalExtension();
                        $key['photo']->move(public_path().'/uploads/', $newName);
                        $newpht = $newName;

                        project_motors::where([
                            ['project_serial_no' ,'=', $serialno],
                            ['motor' ,'=', $key['motorreal']],
                        ])->update([
                            'price' => $key['price'],
                            'qty' => $key['qty'],
                            'total' => $key['total'],
                            'photo' => $newpht,
                            'updated_at' => $dtnow,
                        ]);
                    }else{

                        $name=$key['photo']->getClientOriginalName();
                        $newName = date('dmYHis') . 'mtr' . $i++ . '.'.$key['photo']->getClientOriginalExtension();
                        $key['photo']->move(public_path().'/uploads/', $newName);
                        $newpht = $newName;

                        project_motors::create([
                            'project_serial_no' => $serialno,
                            'motor' => $key['motor'],
                            'power' => $key['power'],
                            'unit' => $key['unit'],
                            //'title' => $key['title'],
                            'price' => $key['price'],
                            'qty' => $key['qty'],
                            'total' => $key['total'],
                            'photo' => $newpht,
                        ]);

                    }

                }

                foreach($request->metals as $key){
                    if(array_key_exists('metalreal',$key) &&  project_metals::where([['project_serial_no' ,'=', $serialno],['metal_type', '=', $key['metalreal']]])){
                        project_metals::where([
                            ['project_serial_no' ,'=', $serialno],
                            ['metal_type' ,'=', $key['metalreal']],
                        ])->update([
                            //'thickness' => $key['thickness'],
                            //'title' => $key['title'],
                            'price' => $key['price'],
                            'qty' => $key['qty'],
                            'total' => $key['total'],
                            'updated_at' => $dtnow,
                        ]);
                    }else{
                        project_metals::create([
                            'project_serial_no' => $serialno,
                            'metal_type' => $key['metal'],
                            'thickness' => $key['thickness'],
                            'unit' => $key['unit'],
                            //'title' => $key['title'],
                            'price' => $key['price'],
                            'qty' => $key['qty'],
                            'total' => $key['total'],
                        ]);
                    }
                }

                foreach($request->others as $key){
                    if(array_key_exists('titlereal',$key)){
                        project_others::where([
                            ['project_serial_no' ,'=', $serialno],
                            ['title' ,'=', $key['titlereal']],
                        ])->update([
                            'price' => $key['price'],
                            'qty' => $key['qty'],
                            'total' => $key['total'],
                            'updated_at' => $dtnow,
                        ]);
                    }else{
                        project_others::create([
                            'project_serial_no' => $serialno,
                            'title' => $key['title'],
                            'info' => $key['info'],
                            //'details' => $key['details'],
                            'price' => $key['price'],
                            'qty' => $key['qty'],
                            'total' => $key['total'],
                        ]);
                    }
                }

                project_assembling_photos::where([
                    ['project_serial_no' ,'=', $serialno],
                ])->delete();

                project_diagram_photos::where([
                    ['project_serial_no' ,'=', $serialno],
                ])->delete();

                project_horizontal_photos::where([
                    ['project_serial_no' ,'=', $serialno],
                ])->delete();

                project_vertical_photos::where([
                    ['project_serial_no' ,'=', $serialno],
                ])->delete();

                $newpht='';
                $i=0;
                foreach($request->file('asd') as $key){
                    // upload the photo for the given project

                    $name=$key->getClientOriginalName();
                    $newName = date('dmYHis') . 'asd' . $i++ . '.'.$key->getClientOriginalExtension();
                    $key->move(public_path().'/uploads/', $newName);
                    $newpht = $newName;

                    project_assembling_photos::create([
                        'project_serial_no' => $serialno,
                        'name' => $newpht,
                    ]);
                }

                $newpht='';
                $i=0;
                foreach($request->file('mtd') as $key){
                    // upload the photo for the given project

                    $name=$key->getClientOriginalName();
                    $newName = date('dmYHis') . 'mtd' . $i++ . '.'.$key->getClientOriginalExtension();
                    $key->move(public_path().'/uploads/', $newName);
                    $newpht = $newName;

                    project_diagram_photos::create([
                        'project_serial_no' => $serialno,
                        'name' => $newpht,
                    ]);
                }

                $newpht='';
                $i=0;
                foreach($request->file('Horizontal') as $key){
                    // upload the photo for the given project

                    $name=$key->getClientOriginalName();
                    $newName = date('dmYHis') . 'Horizontal' . $i++ . '.'.$key->getClientOriginalExtension();
                    $key->move(public_path().'/uploads/', $newName);
                    $newpht = $newName;

                    project_horizontal_photos::create([
                        'project_serial_no' => $serialno,
                        'name' => $newpht,
                    ]);
                }

                $newpht='';
                $i=0;
                foreach($request->file('Vertical') as $key){
                    // upload the photo for the given project

                    $name=$key->getClientOriginalName();
                    $newName = date('dmYHis') . 'Vertical' . $i++ . '.'.$key->getClientOriginalExtension();
                    $key->move(public_path().'/uploads/', $newName);
                    $newpht = $newName;

                    project_vertical_photos::create([
                        'project_serial_no' => $serialno,
                        'name' => $newpht,
                    ]);
                }

                $sum = $request->laserCutting+$request->CNC+$request->Torna+$request->Assembling+$request->eanda;
                project_lasers::where([
                    ['project_serial_no' ,'=', $serialno],
                ])->update([
                    'laser_cutting' => $request->laserCutting ,
                    'cnc' => $request->CNC ,
                    'torna' => $request->Torna ,
                    'assembling' => $request->Assembling ,
                    'electric_and_automation' => $request->eanda ,
                    'total' => $sum,
                ]);
                $project->update([
                    'daysneed' => $request->dtime,
                    'due_time' => null,
                    'phase'=>1,
                    'isApproved' => 0,
                ]);
                Notificationtb::create([
                    'type' => "success",
                    'data' => "new Project with SN: ".$request->serialno." Has been Created by: ". auth()->user()->name,
                    'tousr' => "0",
                    'byusr' => $id,
                ]);


            }elseif($project->phase == 1){

                // Only allow safe image uploads for purchase-order item photos.
                $request->validate([
                    'motors.*.photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
                    'others.*.photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
                ]);

                if($num = Purchases::latest('ID')->first()){
                    $num = str_pad(($num->id+1), 5, '0', STR_PAD_LEFT);
                }else{
                    $num = 0;
                    $num = str_pad(($num+1), 5, '0', STR_PAD_LEFT);
                }
                $number = 'PO'.date('y').''.$num;

                Purchases::create([
                    'serial_no' => $number,
                    'project_serial_no' => $project['serial_no'],
                    'items' => count($project->motors)+count($project->metals)+count($project->others),
                    'status' => 0,
                ]);

                $i=0;
                foreach($request->motors as $motor){
                    $img = '';

                    if(array_key_exists('photo',$motor)){
                        $name=$motor['photo']->getClientOriginalName();
                        $newName = date('dmYHis') . 'mtrpo' . $i++ . '.'.$motor['photo']->getClientOriginalExtension();
                        $motor['photo']->move(public_path().'/uploads/', $newName);
                        $img = $newName;
                    }

                    $id = null;
                    if(array_key_exists('cnti',$motor)){
                        $id = $motor['cnti'];
                    }else{
                        $newmtr = project_motors::create([
                            'project_serial_no' => $project['serial_no'],
                            'motor' => $motor['item'],
                            'power' => 0,
                            'unit' => 'cm',
                            'title' => null,
                            'price' => 0,
                            'qty' => $motor['qty'],
                            'total' => 0,
                            'photo' => $img,
                        ]);
                        $id = $newmtr->id;
                    }

                    project_orders::create([
                        'purchases_serial_no' => $number,
                        'project_serial_no' => $project['serial_no'],
                        'item' => $motor['item'],
                        'item_id' => $id,
                        'Code' => $motor['code'],
                        'details' => $motor['details'],
                        'qty' => $motor['qty'],
                        'photo' => $img,
                        'delivery' => $motor['delivery'] ,
                        'status' => 0,
                    ]);
                    $i++;
                }

                $i=0;
                foreach($request->metals as $metal){

                    $id = null;
                    if(array_key_exists('cnti',$metal)){
                        $id = $metal['cnti'];
                    }else{
                        $newmtl = project_metals::create([
                            'project_serial_no' => $project['serial_no'],
                            'metal_type' => $metal['item'],
                            'thickness' => 0,
                            'unit' => 'cm',
                            'title' => $metal['item'],
                            'price' => 0,
                            'qty' => $metal['qty'],
                            'total' => 0,
                        ]);

                        $id = $newmtl->id;
                    }

                    project_orders::create([
                        'purchases_serial_no' => $number,
                        'project_serial_no' => $project['serial_no'],
                        'item_id' => $id,
                        'item' => $metal['item'],
                        'Code' => $metal['code'],
                        'details' => $metal['details'],
                        'qty' => $metal['qty'],
                        'delivery' => $metal['delivery'] ,
                        'status' => 0,
                    ]);
                    $i++;
                }

                $i=0;
                foreach($request->others as $other){
                    $img = '';
                    if(array_key_exists('photo',$other)){
                        $name=$other['photo']->getClientOriginalName();
                        $newName = date('dmYHis') . 'mtrpo' . $i++ . '.'.$other['photo']->getClientOriginalExtension();
                        $other['photo']->move(public_path().'/uploads/', $newName);
                        $img = $newName;
                    }

                    $id = null;
                    if(array_key_exists('cnti',$other)){
                        $id = $other['cnti'];
                    }else{
                        $newmtr = project_others::create([
                            'project_serial_no' => $project['serial_no'],
                            'title' => $motor['item'],
                            'info' => $motor['item'],
                            'details' => $motor['item'],
                            'price' => 0,
                            'qty' => $motor['qty'],
                            'total' => 0,
                        ]);
                        $id = $newmtr->id;
                    }

                    project_orders::create([
                        'purchases_serial_no' => $number,
                        'project_serial_no' => $project['serial_no'],
                        'item' => $other['item'],
                        'item_id' => $id,
                        'Code' => $other['code'],
                        'details' => $other['details'],
                        'qty' => $other['qty'],
                        'photo' => $img,
                        'delivery' => $other['delivery'] ,
                        'status' => 0,
                    ]);
                    $i++;
                }

                $project->update([
                    'phase'=>2,
                    'isApproved' => 0,
                ]);
            }elseif($project->phase == 2){
                $project->update([
                    'phase'=>3,
                    'isApproved' => 0,
                ]);
            }elseif($project->phase == 3){
                $project->update([
                    'phase'=>4,
                    'isApproved' => 0,
                ]);
            }
        }
        return redirect()->route('projects.index')
                        ->with('success','Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Project::where('id', $id)->delete();
        return redirect()->route('projects.index')
                        ->with('success','Project deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\project_motors  $project_motors
     * @return \Illuminate\Http\Response
     */
    public function destroy_motor($id)
    {
        $motor = project_motors::find($id);
        project_motors::where('id', $id)->delete();
        return redirect()->route('purchases.create',$motor->project_serial_no)->with('message','motor deleted successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\project_metals  $project_metals
     * @return \Illuminate\Http\Response
     */
    public function destroy_metal($id)
    {
        $metal = project_metals::find($id);
        project_metals::where('id', $id)->delete();
        return redirect()->route('purchases.create',$metal->project_serial_no)
                        ->with('success','metal deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\project_others  $project_others
     * @return \Illuminate\Http\Response
     */
    public function destroy_other($id)
    {
        $other = project_others::find($id);
        project_others::where('id', $id)->delete();
        return redirect()->route('purchases.create',$other->project_serial_no)
                        ->with('success','other deleted successfully');
    }

    /**
     * pdf the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function PDFDownload($id){
        $po = Project::find($id);

        $items['project'] = json_decode(json_encode($po));
        $items['metals'] = json_decode(json_encode($po->metals));
        $items['motors'] = json_decode(json_encode($po->motors));
        $items['others'] = json_decode(json_encode($po->others));
        $items['assemblingphts'] = json_decode(json_encode($po->assemblingphts));
        $items['diagramphts'] = json_decode(json_encode($po->diagramphts));
        $items['horizontalphts'] = json_decode(json_encode($po->horizontalphts));
        $items['verticalphts'] = json_decode(json_encode($po->verticalphts));
        $items['lasers'] = json_decode(json_encode($po->lasers));
        return response()->json(json_encode($items));
    }
}
