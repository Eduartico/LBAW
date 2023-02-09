<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Location;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class EventController extends Controller
{

    public function show($id)
    {

        $event = Event::find((int)$id);
        if (!Auth::check()){
            if ($event->status != 'public'){
                abort(403,'unauthorised');
            }else{
                return view('pages.event', ['event' => $event]);
            }
        }

        if (Auth::user()->cannot('show', $event))
            abort(403,'unauthorised');

        return view('pages.event', ['event' => $event]);
    }

    public function search(Request $request){
        $request->validate([
            'query'=>'required|min:3',
        ]);

        $query = $request->input('query');

        $events = Event::whereRaw('name_fts || description_fts @@ plainto_tsquery(?)', [$query])->get();



        return view('pages.search_results')->with('events', $events);
    }

    public function create()
    {
        Auth::user()->can('create', Event::class);

        return view('pages.event_create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:256',
            'address' => 'required|string|max:2048',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'event_date' => 'required|date|after_or_equal:now',
            'upload-image' => 'nullable|file|mimes:png,jpeg,gif|max:2048',
        ]);

        if ($validator->fails()){
            return $validator->errors();
        }

        $location = Location::create([
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);


        if ($request->has('upload-image')){
            $path = $request->file('upload-image')->store('/public/event_image');
        }

        $event = new Event;

        $event->name = $request->input('title');
        $event->description = $request->input('description');
        $event->event_date = $request->input('event_date');
        $event->status = boolval($request->input('isprivate')) ? 'public' : 'private';
        $event->owner_id = Auth::user()->id;
        $event->location_id = $location->id;
        $event->category = 'normal';
        $event->publish_date = now();
        if ($request->has('upload-image'))
            $event->image = $path;

        $event->save();

        /*
        if($request['tag_festival']) $this->addTag('Festival', $event->id);
        if($request['tag_concert']) $this->addTag('Concert', $event->id);
        if($request['tag_conference']) $this->addTag('Conference', $event->id);
        if($request['tag_expo']) $this->addTag('Expo', $event->id);
        if($request['tag_workshops']) $this->addTag('Workshop', $event->id);
        if($request['tag_politics']) $this->addTag('Politics', $event->id);
        if($request['tag_live_tv']) $this->addTag('Live TV', $event->id);
        if($request['tag_protest']) $this->addTag('Protest', $event->id);
        if($request['tag_exercise']) $this->addTag('Exercise', $event->id);
        if($request['tag_auction']) $this->addTag('Auction', $event->id);
        if($request['tag_others']) $this->addTag('Others', $event->id);
        */
        return redirect('/event/'. $event->id);
    }

    public function edit($id){
        $event = Event::find($id);

        $this->authorize('update', $event);

        return view('pages.event_edit', ['event' => $event]);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|exists:event',
            'title' => 'nullable|string|max:256',
            'address' => 'nullable|string|required_if:latitude,longitude|max:2048',
            'latitude' => 'nullable|numeric|required_if:address,longitude|between:-90,90',
            'longitude' => 'nullable|numeric|required_if:latitude,address|between:-180,180',
            'event_date' => 'nullable|date',
            'description' => 'nullable|string|max:256',
            'upload-image' => 'nullable|file|mimes:png,jpeg,gif|max:2048',
        ]);

        if ($validator->fails()){
            return $validator->errors();
        }

        $event = Event::find($request['id']);
        if (!$event->owner()->is(Auth::user())){
            return redirect()->back()->withErrors(['title' => 'you cannot edit this event']);
        }


        if(!is_null($request->input('title'))){
            $event->name = $request->input('title');
        }

        if(!is_null($request->input('address'))){
            $location = Location::create([
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            $old_location = $event->location();
            $event->location_id = $location->id;

        }

        if(!is_null($request->input('event_date'))){
            $event->event_date = $request->input('event_date');
        }


        if(!is_null($request->input('description'))){
            $event->description = $request->input('description');
        }

        /*
        if($request['tag_festival']) $this->addTag('Festival', $event->id);
        else $this->removeTag('Festival', $event->id);

        if($request['tag_concert']) $this->addTag('Concert', $event->id);
        else $this->removeTag('Concert', $event->id);

        if($request['tag_conference']) $this->addTag('Conference', $event->id);
        else $this->removeTag('Conference', $event->id);

        if($request['tag_expo']) $this->addTag('Expo', $event->id);
        else $this->removeTag('Expo', $event->id);

        if($request['tag_workshops']) $this->addTag('Workshop', $event->id);
        else $this->removeTag('Workshop', $event->id);

        if($request['tag_politics']) $this->addTag('Politics', $event->id);
        else $this->removeTag('Politics', $event->id);

        if($request['tag_live_tv']) $this->addTag('Live TV', $event->id);
        else $this->removeTag('Live TV', $event->id);

        if($request['tag_protest']) $this->addTag('Protest', $event->id);
        else $this->removeTag('Protest', $event->id);

        if($request['tag_exercise']) $this->addTag('Exercise', $event->id);
        else $this->removeTag('Exercise', $event->id);

        if($request['tag_auction']) $this->addTag('Auction', $event->id);
        else $this->removeTag('Auction', $event->id);

        if($request['tag_others']) $this->addTag('Others', $event->id);
        else $this->removeTag('Others', $event->id);
        */

        $event->save();
        if(!is_null($request->input('address'))){
            $old_location->delete();
        }

        return redirect('/event/'. $event->id);
    }

    public function attendees($event_id){
        $event = Event::find($event_id);
        $attenders = $event->attenders()->simplepaginate(20);

        return View::make('pages.event-attenders', ['users' => $attenders,'event' => $event]);
    }

    public function delete(Request $request){
        $event = Event::find($request['id']);

        try{
            $event->is_active = false;
            $event->save();
            Log::info('Event ' . $event->title . ' with id:' . $event->id . ' deleted');
            $request->session()->flash('success', 'Event was removed');
            return response()->json($event, 200);
        } catch(ModelNotFoundException $e){
            $request->session()->flash('error', 'Event couldnt be removed');

            Log::error('Could not delete event' . $event->title . ' with id:' . $event->id . ' - not found');
            return response()->json($event, 404);
        }
    }

    public function addLocation($location_name){
        $idLocation = DB::table('location')->insertGetId(
            ['name' => $location_name]
        );

        return $idLocation;
    }

    public function addTag($tag_name, $event_id){
        $tag = Tag::where('name', 'like', $tag_name)->get();

        DB::table('event_tag')->updateOrInsert(
            ['event_id' => $event_id, 'tag_id' => $tag[0]->id]
        );
    }

    public function removeTag($tag_name, $event_id){
        $tag = Tag::where('name', 'like', $tag_name)->first();

        $x = DB::table('event_tag')->where(
             ['event_id' => $event_id, 'tag_id' => $tag->id]
         )->first();


         if($x) {
             DB::table('event_tag')->where(
                 ['event_id' => $event_id, 'tag_id' => $tag->id]
             )->delete();
         }
     }

    //todo
    public function manage(){
        return View::make(RouteServiceProvider::HOME);
    }

}
