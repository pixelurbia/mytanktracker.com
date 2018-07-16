///////////////////
// add user photo workflow JS File
// by Andy 
///////////////////


$(document).ready(function() {
      

Object.entries = function( obj ){ 
    var ownProps = Object.keys( obj ),
        i = ownProps.length,
        resArray = new Array(i); // preallocate the Array
    while (i--)
      resArray[i] = [ownProps[i], obj[ownProps[i]]];

    return resArray;
};
     



  

//Add Tank register
    $( '#photo-img' ).change( function( event ) {
            
      event.preventDefault(); // Prevent the defau
      console.log('hello from the other side');
      //form validation 
      // var tank_name = $('#tank-form .tank-name').val();

      var data = new FormData();
      
      //Form data
      var form_data = $('#photo-form').serializeArray();
      $.each(form_data, function (key, input) {
          data.append(input.name, input.value);
      });
      
      //File data
      var file = $('#photo-img')[0].files[0];
      data.append("file", file);
      
      for (var pair of data.entries()) {
          console.log(pair[0]+ ', ' + pair[1]); 
      }
      //Custom data
      // data.append('key', 'value');
      $.ajax({
          url: ajaxurl,
          method: "post",
          processData: false,
          contentType: false,
          data: data,
          success: function (data) {
              //success
          console.log(data);
          console.log('working');
          // location.reload();
          },
          error: function (e) {
              //error
        console.log(data);
        console.log('error');
          }
      });

      // $.post( 
   //              ajaxurl,
   //              data,
   //              function(data) { 
   //                // location.reload();
   //                  console.log(data);
   //              })
            });


// function tankForm(){
//   // console.log('reg and login work');
//   $('.frost').fadeOut();
//   $('.step-three').delay( 400 ).fadeIn();
//   var delay = 1500; 
//   setTimeout(function(){ window.location = '/tanks/'; }, delay);
// }




});
