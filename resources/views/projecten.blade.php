@extends('layouts.master')
@section('title', 'Home')
@section('content')

   <!---------------hero section------------->




      @if($projects)
   @foreach ($projects as $index =>  $project )
       
       @if($loop->even)
       <div class="project-section" 
         @if($index == 0) 
            {{-- No style for the first project --}}
         @else
               style="background-color: white; margin-top: 0px;"
         @endif
       >
         <div class="container">
            <div class="row h-100 align-items-center">
               <div class="col-md-4 h-100 d-flex justify-content-center">
                  <div class="project-image">
                      <img src="{{ asset('storage/' . $project->image) }}" class="w-100" alt="{{ $project->title }}">
                  </div>
               </div>
               <div class="col-md-8">
                  <div class="content">
                     <p>{{$project->title}} </p>

                     {!! $project->sdesc !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
      @else
         <div class="project-section" 
         
         @if($index == 0) 
            {{-- No style for the first project --}}
         @else
               style="margin-top: 0px;"
         @endif
         >
         
         <div class="container">
            <div class="row h-100 align-items-center">
               <div class="col-md-8">
                  <div class="content">

                   @if($index == 0) <h3>Projecten</h3>  @endif

                    <p>{{$project->title}} </p>
                     
                     {!! $project->sdesc !!}
                  </div>
               </div>
               <div class="col-md-4 h-100 d-flex justify-content-center">
                  <div class="project-image">
                     
                     <img src="{{ asset('storage/' . $project->image) }}" class="w-100" alt="{{ $project->title }}">

                  </div>
               </div>
            </div>
         </div>
      </div>
       @endif

     
     

   @endforeach
   @else
      <div>
      </div>
   @endif


@endsection