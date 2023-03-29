<html>
<head>
    <title>Test Google Map API</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@200&family=Ubuntu&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <style>
        #map {
            height: 100%;
        }


        html,
        body {
            font-family: 'Sarabun', sans-serif;

            height: 100%;
            margin: 0;
            padding: 0;
        }
        #infowindow-content .title {
            font-weight: bold;
        }

        #infowindow-content {
            display: none;
        }

        #map #infowindow-content {
            display: inline;
        }

        .pac-card {
            background-color: #fff;
            border: 0;
            border-radius: 2px;
            box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
            margin: 10px;
            overflow: hidden;
            font-family: 'Sarabun', sans-serif;
            padding: 0;
        }

        #pac-container {
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-controls {
            display: inline-block;
            padding: 5px 11px;
        }

        .pac-controls label {
            font-family: 'Sarabun', sans-serif;
            font-size: 13px;
            font-weight: 300;
        }

        #searchbox {
            margin-top: 1%;
            background-color: #fff;
            font-family: 'Sarabun', sans-serif;
            font-size: 18px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 800px;
        }

        #searchbox:focus {
            border-color: #4d90fe;
        }

        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }

        #target {
            width: 345px;
        }


    </style>
</head>
<body>
<div class="container-fluid">

    <div class="input-group">
        <input  id="searchbox"  class="controls form-control border-end-0 border rounded-pill" type="search"  value="Bang Sue, Bangkok, Thailand"  placeholder="ค้นหา" >
        <span class="input-group-append">
                    <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="button">

                    </button>
                </span>
    </div>


{{-- DIV สร้าง map --}}
    <div id="map"></div>



</div>


<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8-LpT49AYzLnqRUMItRe_hEwVPtFxnU4&callback=initAutocomplete&libraries=places&v=weekly"
    defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
<script>

    function initAutocomplete() {
        //  สร้าง map โดยแสดงที่ ID map จาก HTML และ set ค่าเริ่มต้นการค้นหา บางซื่อ และกำหนดค่าเริ่มต้นของ viewmap เป็น mapTypeId
        const map = new google.maps.Map(document.getElementById("map"), {
            center: {lat: 13.829961525566818, lng: 100.52845069795059},
            zoom: 15,
            mapTypeId: "roadmap",
        });
       // สร้าง Marker ของละติจูด ลองติจูด บางซื่อ
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(13.829961525566818, 100.52845069795059),
            map: map,
            title: 'เขตบางซื่อ'
        });

        //สร้างตัวแปล ชื่อ Input และ set ค่าจาก id pac-input ที่ได้มาจาก input val
        const input = document.getElementById("searchbox");
        const searchBox = new google.maps.places.SearchBox(input);

        //จัดปุ่มค้นหาไว้ที่ข้างบน ชิดมุมขวา
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);


        let markers = [];


        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }


            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];


            const bounds = new google.maps.LatLngBounds();

            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {

                    return;
                }

                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };

                //สร้าง Marker ตาม ค่าที่ค้นหา และ นำค่า เข้ากล่อง Array
                markers.push(
                    new google.maps.Marker({
                        map,
                        icon,
                        title: place.name,
                        position: place.geometry.location,
                    })
                );
                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }

    window.initAutocomplete = initAutocomplete;
</script>
</body>
</html>
