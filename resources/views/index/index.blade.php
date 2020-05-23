<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Peta Sebaran Covid Provinsi Bali</title>

<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/index.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css')}}" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://pendataan.baliprov.go.id/assets/frontend/map/MarkerCluster.css" />
<link rel="stylesheet" href="https://pendataan.baliprov.go.id/assets/frontend/map/MarkerCluster.Default.css" />
<script src="https://unpkg.com/leaflet-kmz@latest/dist/leaflet-kmz.js"></script>
  <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
</head>

<body>
<style>
#map {
        height: 400px;
        width: 100%;
        padding: 0;
        margin: 0;
    }
</style>
<div class="container-fluid">
	<div class="row header">
    	<div class="col-lg-1">
			<img src="/image/Logo1.png" class="img-responsive">
        </div>
		<div class="col-lg-10 judul text-left">
    		<h2>Peta Sebaran Covid - 19 | Provinsi Bali</h2>
       	</div>

        <div class="row col-lg-1">
            <a class="admin" href="/pasien">ADMIN</a>
        </div>

   	</div><!-- End Header -->

    <div class="row info2">
    	Data Sebaran Kasus Covid -19 di Bali
    </div>


    <div class="row info">
		<div class="row col-lg-12">

        	<div class="box2">
            <h4>Filter Data</h4>

                <form action="/search" method="post" id="form">
                    @csrf
                  <div class="form-group">
                    <label for="from" >Tanggal Penyebaran :</label>
                    <input type="date" class="form-control" name="tanggal" id="tanggalSearch"  @if(isset($tanggal)) value="{{$tanggal}}" @endif>
                  </div>

                   <button type="submit" class="btn btn-primary mb-2">Cari</button>

                </form>

            </div>
        </div>



          </div>  <!-- End Info -->


        <div class="row info">
                <div class="box col-lg-2">
                    <h5 class="title">Positif</h5>
                    <p>Jumlah :</p>
                    <h3>{{$positif[0]->positif}} Orang</h3><br />
                    <img src="/image/Logo/Positif.png" />
                </div>


                <div class="box col-lg-2">
                    <h5 class="title3">Perawatan</h5>
                    <p>Jumlah :</p>
                    <h3>{{$rawat[0]->rawat}} Orang</h3><br />
                    <img src="/image/Logo/Dirawat.png" />
                </div>

            	<div class="box col-lg-2">
                    <h5 class="title2">Sembuh</h5>
                    <p>Jumlah :</p>
                    <h3>{{$sembuh[0]->sembuh}} Orang</h3><br />
                    <img src="/image/Logo/Sembuh.png" />
                </div>

    			<div class="box col-lg-2">
                    <h5 class="title4">Meninggal</h5>
                    <p>Jumlah :</p>
                    <h3>{{$meninggal[0]->meninggal}} Orang</h3><br />
                    <img src="/image/Logo/Meninggal.png" />
                </div>

        	<div class="card" style="width: 80rem;">

              <div class="card-body">
                    <h5 class="card-title">Peta Sebaran Kasus Covid - 19 di Bali</h5>
              </div>

              <div id="map"></div>
              <div class="card-footer" style="background: white">
              <div class="row">
                <div class="col-6">
                  Color Start
                  <input type="color" value="#E5000D" class="form-control" id="colorStart">
                </div>
                <div class="col-6">
                  Color End
                  <input type="color" value="#FFFFFF" class="form-control" id="colorEnd">
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-12">
                  <button class="btn btn-primary form-control" id="btnGenerateColor">Generate Color</button>
                </div>

              </div>
            </div>
        	</div><!-- End Card -->

    	<div class="row text col-lg-12">
        	<div class="col-lg-6">@Universitas Udayana</div>
            <div class="col-lg-6 text-right">Peta Sebaran Covid - 19 Provinsi Bali 2020</div>
        </div>


		</div><!-- End Info -->

	</div> <!-- End Container -->

</body>
<script src="https://pendataan.baliprov.go.id/assets/frontend/map/leaflet.markercluster-src.js"></script>
<script>
$(document).ready(function () {
    var dataMap=null;
    var colorMap=[
      "e5000d",
      "e71925",
      "ea333d",
      "ec4c55",
      "ef666d",
      "f27f68",
      "f4999e",
      "f7b2b6",
      "f9ccce"
    ];
    var tanggal = $('#tanggalSearch').val();
    console.log(tanggal);
    $.ajax({
      async:false,
      url:'getData',
      type:'get',
      dataType:'json',
      data:{date: tanggal},
      success: function(response){
        dataMap = response;
      }
    });
    console.log(dataMap);

    $.ajax({
      async:false,
      url:'getPositif',
      type:'get',
      dataType:'json',
      data:{date: tanggal},
      success: function(response){
        dataPos = response;
      }
    });
    console.log(dataPos);

    $('#btnGenerateColor').on('click',function(e){
      var colorStart = $('#colorStart').val();
      var colorEnd = $('#colorEnd').val();
      $.ajax({
        async:false,
        url:'/create-pallete',
        type:'get',
        dataType:'json',
        data:{start: colorStart, end:colorEnd},
        success: function(response){
          colorMap = response;
          setMapColor();
        }
      });

    });

    var map = L.map('map');
    map.setView(new L.LatLng(-8.374187,115.172922), 10);

    var OpenTopoMap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
      maxZoom: 17,
      attribution: 'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)',
      opacity: 0.90
    });

    OpenTopoMap.addTo(map);
    setMapColor();
    // define variables
    var lastLayer;
    var defStyle = {opacity:'1',color:'#000000',fillOpacity:'0',fillColor:'#CCCCCC'};
    var selStyle = {color:'#0000FF',opacity:'1',fillColor:'#00FF00',fillOpacity:'1'};

    function setMapColor(){
      var markerIcon = L.icon({
        iconUrl: '/mar.png',
        iconSize: [40, 40],
      });
      var BADUNG,BULELENG,BANGLI,DENPASAR,GIANYAR,JEMBRANA,KARANGASEM,KLUNGKUNG,TABANAN;
      dataPos.forEach(function(value,index){
        var colorKab = dataPos[index].kabupaten.toUpperCase();
        console.log(colorKab);
        if(colorKab == "BADUNG"){
          BADUNG = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="BANGLI"){
          BANGLI = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        } else if(colorKab=="BULELENG"){
          BULELENG = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="DENPASAR"){
          DENPASAR = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="GIANYAR"){
          GIANYAR = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab =="JEMBRANA"){
          JEMBRANA = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="KARANGASEM"){
          KARANGASEM = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab=="KLUNGKUNG"){
          KLUNGKUNG = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }else if(colorKab =="TABANAN"){
          TABANAN = {opacity:'1',color:'#000',fillOpacity:'1',fillColor: '#'+colorMap[index]};
        }

      });

    // Instantiate KMZ parser (async)
    var kmzParser = new L.KMZParser({
        onKMZLoaded: function (layer, name) {
          control.addOverlay(layer, name);
          var markers = L.markerClusterGroup();
          var layers = layer.getLayers()[0].getLayers();

            // fetching sub layer
      	  layers.forEach(function(layer, index){

          var kab  = layer.feature.properties.NAME_2;
          kab = kab.toUpperCase();
          var prov = layer.feature.properties.NAME_1;

          //
          if(!Array.isArray(dataMap) || !dataMap.length == 0 ){
            // set sub layer default style positif covid
            if(kab == 'BADUNG'){
              layer.setStyle(BADUNG);
            }else if(kab == 'BANGLI'){
              layer.setStyle(BANGLI);
            }else if(kab == 'BULELENG'){
              layer.setStyle(BULELENG);
            }else if(kab == 'DENPASAR'){
              layer.setStyle(DENPASAR);
            }else if(kab == 'GIANYAR'){
              layer.setStyle(GIANYAR);
            }else if(kab == 'JEMBRANA'){
              layer.setStyle(JEMBRANA);
            }else if(kab == 'KARANGASEM'){
              layer.setStyle(KARANGASEM);
            }else if(kab == 'KLUNGKUNG'){
              layer.setStyle(KLUNGKUNG);
            }else if(kab == 'TABANAN'){
              layer.setStyle(TABANAN);
            }



            // peparing data format
            var data = '<table width="300">';
                data +='  <tr>';
                data +='    <th colspan="2">Keterangan</th>';
                data +='  </tr>';


              data +='  <tr>';
              data +='    <td>Kabupaten</td>';
              data +='    <td>: '+kab+'</td>';
              data +='  </tr>';


              data +='  <tr style="color:red">';
              data +='    <td>Positif</td>';
              data +='    <td>: '+dataMap[index].positif+'</td>';
              data +='  </tr>';


              data +='  <tr style="color:green">';
              data +='    <td>Sembuh</td>';
              data +='    <td>: '+dataMap[index].sembuh+'</td>';
              data +='  </tr>';

              data +='  <tr style="color:black">';
              data +='    <td>Meninggal</td>';
              data +='    <td>: '+dataMap[index].meninggal+'</td>';
              data +='  </tr>';


              data +='  <tr style="color:blue">';
              data +='    <td>Dalam Perawatan</td>';
              data +='    <td>: '+dataMap[index].rawat+'</td>';
              data +='  </tr>';


            data +='</table>';

            if(kab == 'BANGLI'){
              markers.addLayer(
                L.marker([-8.254251, 115.366936] ,{
                  icon: markerIcon
                }).bindPopup(data).addTo(map)
              );
            }
            else if(kab == 'GIANYAR'){
              markers.addLayer(
                L.marker([-8.422739, 115.255700] ,{
                  icon: markerIcon
                }).bindPopup(data).addTo(map)
              );

            }else if(kab == 'KLUNGKUNG'){
              markers.addLayer(
                L.marker([-8.487338, 115.380029] ,{
                  icon: markerIcon
                }).bindPopup(data).addTo(map)
              );

            }else{
              markers.addLayer(
                L.marker(layer.getBounds().getCenter(),{
                  icon: markerIcon
                }).bindPopup(data).addTo(map)
              );
            }

          }else{
            var data = "Tidak ada Data pada tanggal tersebut"
            layer.setStyle(defStyle);
          }
          layer.bindPopup(data);
      	});
        map.addLayer(markers);
        layer.addTo(map);
        }
    });

    // Add remote KMZ files as layers (NB if they are 3rd-party servers, they MUST have CORS enabled)
    kmzParser.load('bali-kabupaten.kmz');
    // kmzParser.load('https://raruto.github.io/leaflet-kmz/examples/globe.kmz');

    var control = L.control.layers(null, null, {
        collapsed: false
    }).addTo(map);
    $('.leaflet-control-layers').hide();
    }
  });
</script>
</html>
