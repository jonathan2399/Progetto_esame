<?php
class PhpGoogleMap{
	private $apikey;
    private $dimx;
    private $dimy;
    private $latitudine;
    private $longitudine;
    private $indirizzo;
    private $latitudini;
    private $longitudini;
    private $nomi;
    private $n;
    
	function __construct($_apikey){
    	$this->apikey = $_apikey; //assegna la chiave dell'api di google map 
        $this->dimx = 100;
        $this->dimy = 300;
        $this->latitudine = 0;
        $this->longitudine = 0;
        $this->indirizzo = "";
    }
    
    //funzione per dichiarare mappa tramite codice javascript
    function set_map1(){
      //setta chiave api nella composizione dell'url
      echo "
          <script src=\"http://maps.google.com/maps?file=api&v=2&key=". $this->apikey ."&sensor=false\" type=\"text/javascript\">
          </script>
      ";
      
      //assegna il contenuto alla variabile JScenterMap la quale permette di geolocalizzare un punto sulla mappa tramite indirizzo
      
      if($this->indirizzo!=""){
    	$JScenterMap = "
        	var geocoder = new GClientGeocoder();
        	geocoder.getLatLng('".$this->indirizzo."',function(point) {
                if (!point) {
                    alert('".$this->indirizzo."' + \" not found\");
                } else {
                    map.setCenter(point, 13);
                    var marker = createMarker(point, 'Ciao');
                    map.addOverlay(marker);                         
                }
            });
    	";
	  } else {
    		//$JScenterMap = "map.setCenter(new GLatLng(".$this->latitudini[0].", ".$this->longitudini[0]."),14);";
    		$JScenterMap = "map.setCenter(new GLatLng(".$this->latitudine.", ".$this->longitudine."),10);";
        }
      
	  
      //inizializza il punto sulla mappa in base al contenuto della variabile JScenterMap
      //window.onload permette di richiamare il metodo initialize e Gunload (per svuotare la memoria) direttamente da qui senza specificarlo nel body
      echo "
          <script type=\"text/javascript\">
          	  function createMarker(point,html) {
				var marker = new GMarker(point);
				GEvent.addListener(marker, \"mouseover\", function() { marker.openInfoWindowHtml(html); });
				//GEvent.addListener(marker, \"click\", function() { marker.openInfoWindowHtml(html); });
				return marker;
			  }
              
          	  window.onload = initialize;  
              window.onunload = GUnload;
              function initialize() {
                  if (GBrowserIsCompatible()) {
                      var map = new GMap2(document.getElementById(\"map_canvas\")); ";
                      echo $JScenterMap; 
                      //CREAZIONE MARKER DINAMICAMENTE
                      //alert(\"ciao\" + $i);
                      
                      for ($i=0;$i<($this->n);$i++){
						$nom = addslashes($this->nomi[$i]);
                        echo "
                        var marker1 = createMarker(new GLatLng(".$this->latitudini[$i].", ".$this->longitudini[$i]."), '$nom');
            			map.addOverlay(marker1); ";
            		  }
                      echo "map.setUIToDefault();
                 }
               }
          </script>
      ";
	}
	
	
	function set_map2(){
      //setta chiave api nella composizione dell'url
      echo "
          <script src=\"http://maps.google.com/maps?file=api&v=2&key=". $this->apikey ."&sensor=false\" type=\"text/javascript\">
          </script>
      ";
      
      //assegna il contenuto alla variabile JScenterMap la quale permette di geolocalizzare un punto sulla mappa tramite indirizzo
      
      if($this->indirizzo!=""){
    	$JScenterMap = "
        	var geocoder = new GClientGeocoder();
        	geocoder.getLatLng('".$this->indirizzo."',function(point) {
                if (!point) {
                    alert('".$this->indirizzo."' + \" not found\");
                } else {
                    map.setCenter(point, 13);
                    var marker = createMarker(point, 'Ciao');
                    map.addOverlay(marker);                         
                }
            });
    	";
	  } else {
    		//$JScenterMap = "map.setCenter(new GLatLng(".$this->latitudini[0].", ".$this->longitudini[0]."),14);";
    		$JScenterMap = "map.setCenter(new GLatLng(".$this->latitudine.", ".$this->longitudine."),15);";
        }
      
	  
      //inizializza il punto sulla mappa in base al contenuto della variabile JScenterMap
      //window.onload permette di richiamare il metodo initialize e Gunload (per svuotare la memoria) direttamente da qui senza specificarlo nel body
      echo "
          <script type=\"text/javascript\">
          	  function createMarker(point,html) {
				var marker = new GMarker(point);
				GEvent.addListener(marker, \"mouseover\", function() { marker.openInfoWindowHtml(html); });
				//GEvent.addListener(marker, \"click\", function() { marker.openInfoWindowHtml(html); });
				return marker;
			  }
              
          	  window.onload = initialize;  
              window.onunload = GUnload;
              function initialize() {
                  if (GBrowserIsCompatible()) {
                      var map = new GMap2(document.getElementById(\"map_canvas\")); ";
                      echo $JScenterMap; 
						
            		  echo "  var marker1 = createMarker(new GLatLng(".$this->latitudine.", ".$this->longitudine."), '".$this->nomi ."');
            		  map.addOverlay(marker1);  ";
                      echo "map.setUIToDefault();
                 }
               }
          </script>
      ";
	}
	
    function renderHTML(){
    	echo "<div id=\"map_canvas\" style=\"width:100%;height:335px;\"></div>";
	}
    
    function set_dimensioni($x,$y){
    	$this->dimx = $x;
        $this->dimy = $y;
    }
    
    function set_coordinate($lat,$long){
    	$this->latitudine = $lat;
        $this->longitudine = $long;
        $this->indirizzo = "";
    }
    
    function set_indirizzo($ind){
    	$this->indirizzo=$ind;
    }
    
    function set_arraycoordinate($lat,$long){
    	$this->latitudini = $lat;
        $this->longitudini = $long;
    } 
    
    function set_text($t){
    	$this->nomi = $t;
    }
    
    function set_nmarkers($num){
    	$this->n = $num;
    }
}
?>
