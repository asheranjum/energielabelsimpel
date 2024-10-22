   <footer id="footer">
    @if (Route::is('index')) <!-- For Home Page -->
      <div class="footer-top">
         <div class="container">
            <div class="row-footer align-item-center">
               <div class="footer-logo align-item-center ">
                  <img src="assets/img/logo.png" alt="Logo" class="img-responsive">
               </div>
            </div>
            <!-- <div class="social-links">
               <a href="https://wa.me/+31619027995" class="whatsapp">
                  <img src="assets/img/icons/whatsapp@3x.png" alt=" "></a>
            </div> -->
         </div>
      </div>
      @else
     <div class="footer-top">
         <div class="container">
            <div class="row-footer align-item-center">
               <div class="footer-logo align-item-center ">
                  <img src="assets/img/logo.png" alt="Logo" style="padding: 10px 100px;" class="img-responsive">
               </div>
            </div>
             <div class="social-links">
               <a href="https://wa.me/+31619027995" class="whatsapp">
                  <img src="assets/img/icons/whatsapp@3x.png" alt=" "></a>
            </div> 
         </div>
      </div>
      @endif
      <div class="footer-bottom">
         <div class="container">
            <p class="text-center" href="#"> Copyright Energielabel. All rights reserved </p>
         </div>
      </div>
   </footer>