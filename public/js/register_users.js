$(document).ready(function(){

toastr.options = {
"closeButton": false,
"debug": false,
"newestOnTop": false,
"progressBar": false,
"positionClass": "toast-top-right",
"preventDuplicates": false,
"onclick": null,
"showDuration": "300",
"hideDuration": "1000",
"timeOut": "5000",
"extendedTimeOut": "1000",
"showEasing": "swing",
"hideEasing": "linear",
"showMethod": "fadeIn",
"hideMethod": "fadeOut"
}
// console.log("toastr");
// toastr["error"]("Por favor completa los campos");


  var load_cities = function(){
    var state_id = document.getElementById('state_id').value;
    $.ajax({
      method:'GET',
      url:'/get_cities/',
      data:{'state_id':state_id},
      success: function(response){
        console.log(response);
        if (response == "") {
          $('#city_id').empty().append('vacio');
        }else {
          $('#city_id').empty().append('vacio');
          $.each(response, function(key, cities){
          $("#city_id").append('<option value='+cities.id+'>'+cities.city+'</option>');
          });
        }
      }
    });
  }
var load_suburbs = function(){
  var city_id = document.getElementById('city_id').value;
    $.ajax({
      method:'GET',
      url:'/get_suburbs',
      data:{'city_id':city_id},
      success: function(response){
        console.log(response);
        if (response == "") {
          $('#suburb_id').empty().append('vacio');
        }else {
          $('#suburb_id').empty().append('vacio');
          $.each(response, function(key, suburbs){
          $("#suburb_id").append('<option value='+suburbs.id+'>'+suburbs.suburb+'</option>');
          });
        }
      }
    });
}
var validate_curps = function(curp){
  var uppercurp = curp.toUpperCase(),
  resultado = document.getElementById("resultado"),
  valido = "No válido";
  var n = curp.length;
  console.log(n);
  if (curpValida(curp)) {

    	valido = "Válido";
      if(n == 18){
        toastr["warning"]("CURP Valida");
        console.log(curp);
        }
        //resultado.classList.add("ok");
    } else {
      if (n == 18) {
        toastr["error"]("Por favor ingresa una CURP valida");
        console.log("invalido");
        }
      // resultado.classList.remove("ok");
    }
    // resultado.innerText = "CURP: " + curp + "\nFormato: " + valido;

}

function curpValida(curp) {
	var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0\d|1[0-2])(?:[0-2]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
    	validado = curp.match(re);
      if (!validado)  //Coincide con el formato general?
    	return false;
      //Validar que coincida el dígito verificador
      function digitoVerificador(curp17) {
        //Fuente https://consultas.curp.gob.mx/CurpSP/
        var diccionario  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
            lngSuma      = 0.0,
            lngDigito    = 0.0;
        for(var i=0; i<17; i++)
            lngSuma= lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
        lngDigito = 10 - lngSuma % 10;
        if(lngDigito == 10)
            return 0;
        return lngDigito;
    }
    if (validado[2] != digitoVerificador(validado[1]))
    	return false;
    return true; //Validado
}

$('#state_id').change(function(){
load_cities();
});

$('#city_id').change(function(){
load_suburbs();
});

$('#curp').on('input',function(){
  var curp = $('#curp').val();
  console.log(curp);
  validate_curps(curp);
});

});
