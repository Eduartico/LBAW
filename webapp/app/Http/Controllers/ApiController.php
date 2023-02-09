<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Invite;
use App\Models\Post;
use App\Models\User;
use Doctrine\DBAL\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function report(Request $request){
        return $this->a($request,['post','comment','event'],'report',null, Auth::id());
    }

    public function attend(Request $request){
        $validator = Validator::make($request->all(),['is_private' => 'required|string']);
        if ($validator->fails()) return $validator->errors();

        if ($request->input('command') == 'create'){
            if ($request->user()->cannot('create',[Attend::class,Event::find($request->input('id'))])){
                return response()->json([
                    'error' => 'user cannot attend this event'
                ]);
            }
        }
        $request->request->add(['is_private' => $request->is_private == 'true']);
        $request->request->add(['type' => 'event']);
        return $this->a($request,['event'],'attend','is_private', Auth::id(),useType: false);
    }


    public function invite(Request $request){
        $validator = Validator::make($request->all(),['username' => 'required|string']);
        if ($validator->fails()) return $validator->errors();

        if ($request->input('command') == 'create'){
            if ($request->user()->cannot('create',[Invite::class,Event::find($request->input('id'))])){
                return response()->json([
                    'error' => 'user cannot invite to this event'
                ]);
            }
        }
        $invited = trim(strtolower($request->input('username')));
        $user = User::where('username',$invited)->first();
        if (!$user){
            return response()->json([
                'error' => $invited.' not found'
            ]);
        }


        $request->request->add([
            'invited' => $user->id,
            'type' => 'event'
        ]);
        $table = 'invite';
         $types = ['event'];
         $additional = 'invited';
         $user = Auth::id();
         $useType = false;
         $user_column_name = 'inviter';

        $validated = Validator::make($request->all(),[
            'command' => 'bail|required|',
            'id' => 'bail|required|integer'
        ]);

        if ($validated->fails()){
            return $validated->errors();
        }

        if (!in_array($request->input('type'),$types) || empty($types)) {
            return response()->json(['error' => 'invalid type']);
        }

        if ($request->input('command') == 'create') {

            DB::table($useType ? $request->input('type') . $table : $table)
                ->upsert([
                    $request->input('type') . '_id' => $request->input('id'),
                    $user_column_name => $user,
                    $additional => $request->input($additional)
                ], [
                    'invited', $user_column_name,'event_id'
                ]);

            return response()->json(['success' => 'successful']);

        } elseif ($request->input('command') == 'delete') {

            DB::table($useType ? $request->input('type') . $table : $table)
                ->where($request->input('type').'_id', '=', $request->input('id'))
                ->where($user_column_name,'=',$user)
                ->delete();
            return response()->json(['success' => 'delete successful']);

        }

        return response()->json([
            'error' => 'invalid command'
        ]);
    }

    public function vote(Request $request){
        $validator = Validator::make($request->all(),['is_positive' => 'required|string']);
        if ($validator->fails()) return $validator->errors();

        if ($request->input('type') == 'poll'){
            return $this->a($request, ['post','poll','comment'], 'vote', 'option_id', Auth::id());
        }
        $request->request->add(['is_positive' => $request->is_positive == 'true']);
        return $this->a($request, ['post','poll','comment'], 'vote', 'is_positive', Auth::id());
    }

    public function organizer(Request $request){
        $validator = Validator::make($request->all(),['user' => 'required|integer']);
        if ($validator->fails()) return $validator->errors();

        $request->request->add(['type' => 'event']);
        return $this->a($request,['event'],'Organize','user',$request->input('user'),false);
    }

    private function a(Request $request, $types, $table, $additional,$user, $useType = true, $user_column_name = 'user_id' ){

        $validated = Validator::make($request->all(),[
            'command' => 'bail|required|',
            'id' => 'bail|required|integer'
        ]);

        if ($validated->fails()){
            return $validated->errors();
        }

        if (!in_array($request->input('type'),$types) || empty($types)) {
            return response()->json(['error' => 'invalid type']);
        }

        if ($request->input('command') == 'create') {

            if ($additional != null) {
                DB::table($useType ? $request->input('type') . $table : $table)
                    ->upsert([
                        $request->input('type') . '_id' => $request->input('id'),
                        $user_column_name => $user,
                        $additional => $request->input($additional)
                    ], [
                        $request->input('type') . '_id', $user_column_name
                    ], [
                        $additional
                    ]);
            }else{
                DB::table($useType ? $request->input('type') . $table : $table)
                    ->upsert([
                        $request->input('type') . '_id' => $request->input('id'),
                        $user_column_name => $user
                    ], [
                        $request->input('type') . '_id', $user_column_name
                    ]);
            }
            return response()->json(['success' => 'successful']);

        } elseif ($request->input('command') == 'delete') {

            DB::table($useType ? $request->input('type') . $table : $table)
                ->where($request->input('type').'_id', '=', $request->input('id'))
                ->where($user_column_name,'=',$user)
                ->delete();
            return response()->json(['success' => 'delete successful']);

        }

        return response()->json([
            'error' => 'invalid command'
        ]);
    }
}
