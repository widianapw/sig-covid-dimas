<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>

<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css')}}" />

</head>

<body>
	<div class="container-fluid">

        <div class="row header">
            <div class="col-lg-1">
                <img src="/image/Logo1.png" class="img-responsive">
            </div>
            <div class="col-lg-9 judul">
                <h2>Peta Sebaran Covid - 19 | Provinsi Bali</h2>
            </div>

            <div class="row col-lg-2">
                <a class="admin" href="/">LOG OUT</a>
            </div>
         </div>   <!--- End Header --->

    	<div class="row info">

        	<div class="col-lg-12">
                <div class="box">
                <h4>Input Data Kasus Covid - 19 di Bali</h4>

                    <form action="/pasien" method="post" id="form">
                    @csrf
                      <div class="form-group">
                        <label for="from" >Pilih Kabupaten :</label>
                        <select class="form-control" name="kabupaten">
                        @foreach ($kabupaten as $item)
                                <option value="{{$item->id}}">{{ucfirst($item->kabupaten)}}</option>
                            @endforeach
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="from" >Tanggal :</label>
                        <input type="date" class="form-control" name="tgl_data" >
                      </div>

                      <div class="form-group">
                        <label for="from" >Sembuh :</label>
                        <input type="number" class="form-control" name="sembuh" >
                      </div>

                      <div class="form-group">
                        <label for="from" >Dalam Perawatan :</label>
                        <input type="number" class="form-control" name="rawat" >
                      </div>

                      <div class="form-group">
                        <label for="from" >Meninggal :</label>
                        <input type="number" class="form-control" name="meninggal" id="from">
                      </div>

                       <button type="submit" class="btn btn-primary mb-2">Submit</button>

                    </form>
                </div><!--- End Box --->
             </div><!--- End Col-lg-12 --->

         	<div class="row text col-lg-12">
                <div class="col-lg-6">@Universitas Udayana</div>
                <div class="col-lg-6 text-right">Peta Sebaran Covid - 19 Provinsi Bali 2020</div>
        	</div>

        </div><!--- End info --->
    </div><!--- End container --->

</body>
</html>
