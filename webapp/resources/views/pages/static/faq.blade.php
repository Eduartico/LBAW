@extends('layouts.app')

@section('title', 'FAQ')
  
@section('content')

<div class="infoPage">
   <br><br><br>
   <h1>FAQ</h1>
   <hr>
   <div class="accordion" id="FAQ">
       <div class="card">
           <div class="card-header" id="HOne">
               <h2 class="mb-0">
                   <button class="btn btn-link text-dark" type="button" data-toggle="collapse" data-target="#collapseOne"
                       aria-expanded="false" aria-controls="collapseOne">
                       What's the purpose of Helluva?
                   </button>
               </h2>
           </div>
           <div id="collapseOne" class="panel-collapse collapse in" aria-labelledby="HOne"
               data-parent="#FAQ">
               <div class="card-body">
               Helluva is a web platform where you can see, join and create events.
               </div>
           </div>
       </div>
       <br>
       <hr>
       <div class="card">
           <div class="card-header" id="HTwo">
               <h2 class="mb-0">
                   <button class="btn btn-link text-dark" type="button" data-toggle="collapse" data-target="#collapseTwo"
                       aria-expanded="false" aria-controls="collapseTwo">
                       How can I create an event?
                   </button>
               </h2>
           </div>

           <div id="collapseTwo" class="panel-collapse collapse in" aria-labelledby="HTwo"
               data-parent="#FAQ">
               <div class="card-body">
               First you will need to have an account. Register a new account if you don't have one already. From there you can go to the home page and click the "Create Your Event" button.
               </div>
           </div>
       </div>
       <br>
       <hr>
       <div class="card">
           <div class="card-header" id="HThree">
               <h2 class="mb-0">
                   <button class="btn btn-link text-dark" type="button" data-toggle="collapse" data-target="#collapseThree"
                       aria-expanded="false" aria-controls="collapseThree">
                       How can I search for events?
                   </button>
               </h2>
           </div>

           <div id="collapseThree" class="panel-collapse collapse in" aria-labelledby="HThree"
               data-parent="#FAQ">
               <div class="card-body">
               You can search for events in the general search tab, by keywords, at the home page.
               </div>
           </div>
       </div>
       <br>
       <hr>
       <div class="card">
           <div class="card-header" id="HFour">
               <h2 class="mb-0">
                   <button class="btn btn-link text-dark" type="button" data-toggle="collapse" data-target="#collapseFour"
                       aria-expanded="false" aria-controls="collapseFour">
                       What's the difference between public and private events?
                   </button>
               </h2>
           </div>

           <div id="collapseFour" class="panel-collapse collapse in" aria-labelledby="HFour"
               data-parent="#FAQ">
               <div class="card-body">
               Public events can be seen by everyone, while private events are only accessible to whom the owner has invited.
               </div>
           </div>
       </div>
       <br>
       <hr>
        <div class="card">
           <div class="card-header" id="HFive">
               <h2 class="mb-0">
                   <button class="btn btn-link text-dark" type="button" data-toggle="collapse" data-target="#collapseFive"
                       aria-expanded="false" aria-controls="collapseFive">
                       How can I see how many people are coming to an event?
                   </button>
               </h2>
           </div>

           <div id="collapseFive" class="panel-collapse collapse in" aria-labelledby="HFive"
               data-parent="#FAQ">
               <div class="card-body">
               The number of attenders can be seen at the event page.
               </div>
           </div>
       </div>
   </div>
</div>
<br><br><br>
   
@endsection