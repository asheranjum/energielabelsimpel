@extends('layouts.master')
@section('title', 'Home')
@section('content')


   <!---------------hero section------------->
   <section id="hero-section" class="home-section featured-section">
      <div class="container h-100">
         <div class="row h-100 align-items-center text-center">
            <div class="hero-content mx-auto text-center align-items-center">
               <a href="#Offerte" class="gotoForm">Binnen 24 uur offerte </a>
               <h1>Intro </h1>
               <p>
                  Welkom bij Energielabelsimpel. Wij maken het aanvragen van een energielabel en het verzorgen van de
                  benodigde stukken voor uw omgevingsvergunning simpel. Met onze snelle en betrouwbare service krijgt u
                  onafhankelijk advies en bent u verzekerd van een zorgeloos proces.
               </p>
               <p>
                  Bekijk hieronder wat we voor u kunnen betekenen: </p>
               <!-- <div class="hero-buttons">
                     <a href="#forms">
                     <button class="btn btn-light btn-sm">Vraag een energielabel aan</button>
                     </a>
                  </div>
                  <a href="#whyus" class="top-bottm-btn">
                  <img src="assets/img/icon@4x.png">
                  </a> -->
            </div>
         </div>
      </div>
   </section>

   <section id="whyus" class="home-section whyus-section service-section">
      <div class="container">
         <div class="row  h-100 ">
            <div class="col-lg-6 ">
               <div class="card" onclick="location.href='/bestaand'">
                  <h5 class="card-title text-center">Bestaande bouw</h5>
                  <div class=" card-overlay" style="background-image: url('/assets/img/Bestaand.jpeg');">
                     <div class="content">
                         <ul class="list">
                             <li> <a href="/bestaand#energielabel"> Energielabel</a></li>
                             <li> <a href="/bestaand#quickscan"> Quickscan</a></li>
                             <li> <a href="/bestaand#energielabel-verbeteradvies"> Energielabel verbeteradvies</a></li>
                             <li> <a href="/bestaand#energiebesparingsadvies"> Energiebesparingsadvies</a></li>
                         </ul>
                     </div>
                 </div>
               </div>
          

            </div>
            <div class="col-lg-6 ">
               <div class="card" onclick="location.href='/nieuwbouw'">
                  <h5 class="card-title text-center">Nieuwbouw</h5>
                  <div class=" card-overlay" style="background-image: url('/assets/img/Nieuwbouw.jpg');">
                     <div class="content">
                         <ul class="list">
                             <li> <a href="/nieuwbouw#BENG-berekening"> BENG-berekening  </a> </li>
                             <li> <a href="/nieuwbouw#Daglicht"> Daglicht en ventilatieberekening  </a> </li>
                             <li> <a href="/nieuwbouw#MPG-berekening"> MPG-berekening  </a> </li>
                             <li> <a href="/nieuwbouw#Energielabel"> Energielabel bij oplevering  </a> </li>
                             <li> <a href="/nieuwbouw#Koellastberekening"> Koellastberekening  </a> </li>
                         </ul>
                     </div>
                 </div>
               </div>
            </div>
         </div>
      </div>
   </section>

   <!----------------whyus section------------------------>

   <section id="Offerte" class=" form-section">
      <div class="container align-item-center formstyle ">
         <div class="row">
            <div class="form-content align-items-center">
               <h1>Doe een aanvraag:</h1>
               <br>
               <form class="row form-style" style="background-color: white;" method="POST" action="{{ route('contact.submit') }}">
                  @csrf <!-- Add CSRF protection -->
                   @if (session('success'))
                      <div class="alert alert-success">
                          {{ session('success') }}
                      </div>
                    @endif
                
                  <div class="col-12 col-md-6">
                      <label for="first_name" class="form-label">Voornaam</label>
                      <input type="text" class="form-control w-100" id="first_name" name="first_name" placeholder="Voornaam" required>
                  </div>
                  <div class="col-12 col-md-6">
                      <label for="last_name" class="form-label">Achternaam</label>
                      <input type="text" class="form-control w-100" id="last_name" name="last_name" placeholder="Achternaam" required>
                  </div>
                  <div class="col-12 col-md-12">
                      <label for="address_1" class="form-label">Woon of bedrijfsadres (met plaats en postcode)</label>
                      <input type="text" class="form-control w-100" id="address_1" name="address_1" placeholder="Straatnaam 1, 1111 AA, Plaatsnaam" required>
                  </div>
                  <div class="col-12 col-md-12">
                      <label for="address_2" class="form-label">Projectadres (met plaats en postcode)</label>
                      <input type="text" class="form-control w-100" id="address_2" name="address_2" placeholder="Straatnaam 1, 1111 AA, Plaatsnaam">
                  </div>
                  <div class="col-12 col-md-6">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control w-100" id="email" name="email" placeholder="Naam@email.nl" required>
                  </div>
                  <div class="col-12 col-md-6">
                      <label for="phone" class="form-label">Telefoonnummer</label>
                      <input type="text" class="form-control w-100" id="phone" name="phone" placeholder="0612345678" required>
                  </div>
                  <div class="mb-3">
                      <label for="question" class="form-label">Uw vraag</label>
                      <textarea type="text" class="form-control" id="question" name="question" rows="5" required>Beste Energielabelsimpel,</textarea>
                  </div>

  <!-- Include Google reCAPTCHA script (ensure it's at the end) -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- reCAPTCHA inside the form -->
<div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
@if ($errors->has('g-recaptcha-response'))
    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
@endif

                  <div class="form-button d-grid gap-2 col-12">
    <button class="form-btn btn-primary" type="submit">
        <span>Dien de aanvraag in!</span>
    </button>
</div>

                </form>


            </div>
         </div>
      </div>
   </section>


   <!---------------About section------------->
   <section id="about" class="home-section about-section">
      <div class="container">
         <div class="row">
            <div class="col-lg-6">
               <div class="about-text">
                  <h1 class="mb-9">Wie ben ik</h1>
                  <p class="pb-2">Mijn naam is Jilles Haverkort en ben opgeleid als bouwkundig ingenieur aan de Hanzehogeschool in Groningen. Met energielabelsimpel voorzie ik bouwprofessionals zoals architecten,
ingenieursbureaus en projectontwikkelaars van de vereiste stukken voor de aanvraag van de omgevingsvergunning. Ook help ik bedrijven en particulieren met het in kaart brengen van de energetische prestatie van gebouwen en geef ik hierover met veel plezier advies. 
                  <p class="pb-3">
                     Energielabelsimpel maakt verduurzaming mogelijk!
                  </p>
               </div>
            </div>
            <div class="col-lg-2"></div>
            <div class=" col-lg-4">
               <div class="about-images">
                  <img src="assets/img/owner@4x.png" alt="owner" class="img-responsive">
               </div>
               <div class="name-text">
                  <h4>Ing. Jilles Haverkort</h4>
               </div>
              
            </div>
         </div>
      </div>
   </section>

   <section id="Contact" class="home-section contact-section">
      <div class="container">
         <div class="row">
            <div class="col-lg-6">
               <div class="about-text">
                  <h1 class="mb-4">Contact</h1>
                  <p class="mb-4">Email:  <a href="mailto:info@energielabelsimpel.nl">info@energielabelsimpel.nl</a></p>
                 <p>Tel.: <span id="phone-number"></span></p>
               </div>
               <div class="contact-icons">

                 <div class="icon-social">
                  <a href="https://wa.me/+31619027995" class="whatsapp" target="_blank" rel="noopener noreferrer">
                     <img src="assets/img/icons/whatsapp@3x.png" alt="WhatsApp">
                  </a>
                  </div>
             
                  <div class="icon-social">
                     <a href="#" class="whatsapp">
                        <img src="assets/img/icons/linkin@3x.png" alt=" "></a>
                  </div>
             
               </div>
            </div>
           
         </div>
      </div>
   </section>


@endsection