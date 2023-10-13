window.onload = miUbicacion;

function miUbicacion(){
		//Si los servicios de geolocalización están disponibles
		if(navigator.geolocation){
		// Para obtener la ubicación actual llama getCurrentPosition.
		navigator.geolocation.getCurrentPosition( muestraMiUbicacion );
		}else{ //de lo contrario
		alert("Los servicios de geolocalizaci\363n  no est\341n disponibles");
		}
}
function muestraMiUbicacion(posicion){
		var latitud = posicion.coords.latitude
		var longitud = posicion.coords.longitude
		var output = document.getElementById("ubicacion");
		output.setAttribute('value',latitud+', '+longitud);
		
}