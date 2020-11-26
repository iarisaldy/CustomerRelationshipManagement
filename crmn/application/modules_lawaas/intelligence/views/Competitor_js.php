<script>
    // Jquery lightbox saat gambar perusahaan di klik 
    $(document).ready(function () {
        $('.slick_demo_1').slick({
            dots: true
        });
        $('.slick_demo_2').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            centerMode: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
        $('.slick_demo_3').slick({
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear',
            adaptiveHeight: true
        });
    });

    // Action check all checkbox nama perusahaan
    $("#checkAllPerusahaan").click(function () {
        var allChecked = $(this);
        $("#fListPerusahaan input[type=checkbox]").each(function () {
            $(this).prop("checked", allChecked.is(':checked'));
        })
    });
    
    // Action check all checkbox jenis fasilitas perusahaan
    $("#checkAllFasilitas").click(function () {
        var allChecked = $(this);
        $("#fListFasilitas input[type=checkbox]").each(function () {
            $(this).prop("checked", allChecked.is(':checked'));
        })
    });

    function formatNumb(n) {
        var rx = /(\d+)(\d{3})/;
        return String(n).replace(/^\d+/, function (w) {
            while (rx.test(w)) {
                w = w.replace(rx, '$1.$2');
            }
            return w;
        });
    }

    var Chart1;
    var Chart2;
    var ctx1 = document.getElementById("Chart1");
    var ctx2 = document.getElementById("Chart2");
    var map;
    var ctaLayer;
    var org;
    var plant;
    var idList;
    var pulau;
    var base_url;
    
    // Array bulan
    var month = new Array(12);
    month[1] = "01";
    month[2] = "02";
    month[3] = "03";
    month[4] = "04";
    month[5] = "05";
    month[6] = "06";
    month[7] = "07";
    month[8] = "08";
    month[9] = "09";
    month[10] = "10";
    month[11] = "11";
    month[12] = "12";
    var d = new Date();

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -7.11234440, lng: 112.41742430},
            zoom: 11
        });
    }


    $(function () {
        var kodeperusahaan = [];
        var kodefasilitas = [];
        var n = 0;
        $("#fListPerusahaan input:checkbox:checked").each(function () {
            kodeperusahaan[n] = this.value;
            n++;
        });
        var m = 0;
        $("#fListFasilitas input:checkbox:checked").each(function () {
            kodefasilitas[m] = this.value;
            m++;
        });
        var url = base_url + 'intelligence/Competitor/getData';
        var options = {
            zoom: 5, //level zoom
            //posisi tengah peta
            center: new google.maps.LatLng(-3.300923, 117.645717),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map;
        var markers = [];
        $.ajax({
            url: url,
            dataType: 'json',
            success: function (data) {

                map = new google.maps.Map(document.getElementById('gudang_canvas'), options);




                var infowindow = new google.maps.InfoWindow();
                function show(perusahaan, fasilitas) {
                    for (var i = 0; i < data.length; i++) {
                        console.log(perusahaan + " " + fasilitas);
                        if (data[i]['KODE_PERUSAHAAN'] == perusahaan && data[i]['KODE_FASILITAS'] == fasilitas) {
                            markers[i].setVisible(true);
                        }
                    }
                }
                function hide() {
                    for (var i = 0; i < data.length; i++) {
                        markers[i].setVisible(false);
                    }
                }
                $('#modal-list').on('hidden.bs.modal', function () {
                    var n = 0;
                    hide();
                    if (idList == "#fListPerusahaan") {
                        kodeperusahaan = [];
                    } else {
                        kodefasilitas = [];
                    }
                    $(idList + " input:checkbox:checked").each(function () {
                        //console.log(this.value); // do your staff with each checkbox
                        if (idList == "#fListPerusahaan") {
                            kodeperusahaan[n] = this.value;
                        } else {
                            kodefasilitas[n] = this.value;
                        }
                        n++;
                    });
                    $.each(kodeperusahaan, function (key, valper) {
                        $.each(kodefasilitas, function (k, valfas) {
                            show(valper, valfas);
                        });
                    });
                });
                $.each(data, function (key, val) {
                    var latitude = val.LATITUDE.replace(',', '.');
                    var longitude = val.LONGITUDE.replace(',', '.');

                    var icons;
                    var marker = val.MARKER;
                    
                    // Data marker
                    for (var i = 1; i < data.length; i++) {
                        if (data[i]['KODE_PERUSAHAAN'] !== "" && data[i]['KODE_FASILITAS'] !== "") {
                            icons = base_url + 'assets/marker/' + marker;
                        }

                    }

                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(latitude, longitude),
                        map: map,
                        icon: icons
                    });

                    markers.push(marker);
                    
                     //  Data file foto fasilitas perusahaan
                   google.maps.event.addListener(marker, 'click', (function (marker, key) {
                        return function () {
                            //Info window yang berisikan informasi tentang kompetitor
//                            var info = '<table class="info-window">' +
//                                    '<thead><tr><th class="judul" colspan="2" >' + val.NAMA_PERUSAHAAN.toUpperCase() + '</th></tr></thead>' +
//                                    '<tbody style="color: #000000;"><tr><td style="padding-left: 3px;font-weight: bold">Jenis Fasilitas</td><td style="font-weight: bold;">' + val.FASILITAS.toUpperCase() + '</td></tr><tr><td style="padding-left: 3px;font-weight: bold">Nama Fasilitas</td><td style="font-weight: bold;">' + val.NAMA_FASILITAS.toUpperCase() + '</td></tr><tr><td style="padding-left: 3px;font-weight: bold">Foto Fasilitas</td><td><div class="lightBoxGallery">';
//                            var no = 0;
//                            $.each(val.FOTO, function (keyF, valF) {
//
//
//                                if (no >= 1) {
//                                    info += '<a hidden style="cursor: -webkit-zoom-in;" class="a" data-gallery="" href="' + valF + '" title="' + val.NAMA_PERUSAHAAN + ' | ' + val.NAMA_FASILITAS + '">' +
//                                            '<img src="' + valF + '" id="imgSmall">' +
//                                            '</a>';
//                                } else {
//                                    info += '<a class="a" style="cursor: -webkit-zoom-in;" data-gallery="" href="' + valF + '" title="' + val.NAMA_PERUSAHAAN + ' | ' + val.NAMA_FASILITAS + '" >' +
//                                            '<img src="' + valF + '" id="imgSmall">' +
//                                            '</a>';
//                                }
//                                no++;
//                            });
//
//                            info += '</td></div></tr>';
//                            info += '<tr><td>&nbsp</td><td>&nbsp</td></tr>';
//                            $.each(val.INFO, function(keyInf, valInf){
//                                info += '<tr><td colspan="2" style="width:20px">'+valInf+'</td></tr>';
//                            });
//                            info += '</tbody><tfoot clas="footer"></tfoot></table>';
                            var info  = '<div class="infowindow" style="width:320px;overflow: hidden;">';
//                                info += '<div class="col-md-12" style="border-bottom: 3px solid #337ab7;"><h2><i class="fa fa-info-circle" style="color:#337ab7"></i>&nbsp;' + val.NAMA_PERUSAHAAN.toUpperCase() + '</h2></div>';
                                info += '<div class="col-md-12" style="border-bottom: 3px solid #337ab7;"><h3><i class="fa fa-info-circle" style="color:#337ab7"></i>&nbsp;' + val.NAMA_PERUSAHAAN.toUpperCase() + '</h3></div>';
                                info += '<div class="row">';
                                info += '<div class="col-md-12" style="margin-top:10px">';
                                info += '<div class="form-group"><label class="col-md-5 control-label">Jenis Fasilitas:</label><label class="col-md-7 control-label">' + val.FASILITAS.toUpperCase() + '</label></div>';
                                info += '<div class="form-group"><label class="col-md-5 control-label">Nama Fasilitas:</label><label class="col-md-7 control-label">' + val.NAMA_FASILITAS.toUpperCase() + '</label></div>';
                                info += '<div class="form-group"><label class="col-md-5 control-label">Foto Fasilitas:</label>';
                                info += '<div class="lightBoxGallery col-md-7">';
                                 var no = 0;
                                $.each(val.FOTO, function (keyF, valF) {
                                    if (no >= 1) {
                                        info += '<a hidden style="cursor: -webkit-zoom-in;" class="a" data-gallery="" href="' + valF + '" title="' + val.NAMA_PERUSAHAAN + ' | ' + val.NAMA_FASILITAS + '">' +
                                                '<img src="' + valF + '" id="imgSmall">' +
                                                '</a>';
                                    } else {
                                        info += '<a class="a" style="cursor: -webkit-zoom-in;" data-gallery="" href="' + valF + '" title="' + val.NAMA_PERUSAHAAN + ' | ' + val.NAMA_FASILITAS + '" >' +
                                                '<img src="' + valF + '" id="imgSmall">' +
                                                '</a>';
                                    }
                                    no++;
                                });
                                if(no!=0){
                                        info += '<div class="ket" style="float:right;margin-top:-7px;margin-right:43px"><font style="font-size:10px;font-style:italic;text-align:right">Klik untuk perbesar</font></div>';
                                }else{
                                info += '<label class="col-md-12 control-label" style="padding: 0px;font-weight: normal;">Tidak Ada Foto</label>';
                                }
                                info += '</div>';
                                info += '</div>';
                                $.each(val.INFO, function(keyInf, valinf){
                                info += '<div class="form-group"><label class="col-md-5 control-label" style="text-transform: capitalize;">'+valinf.HEADER+':</label>';
                                info += '<label class="col-md-7 control-label" style="font-weight: normal;text-transform: capitalize;">'+valinf.TEXT+'</label></div>';
                                });
//                                $.each(val.HEADER, function(keyInf, valhead){
//                                info += '<div class="form-group"><label class="col-md-5 control-label">'+valhead+'</label>';
//                                info += '<label class="col-md-7 control-label">' + val.NAMA_FASILITAS.toUpperCase() + '</label></div>';
//                                });
                                info += '</div>';
//                                info += '</div>';
//                                info += '<div class="col-md-4" style="margin-top:10px">';
//                                info += '<div class="col-md-12">';
//                                info += '</div>';
//                                info += '</div>';
                                info += '</div>';
                                info += '</div>';
                            infowindow.setContent(info);
                            infowindow.open(map, marker);
                        };

                    })(marker, key));
                // Zoom Pulau
                    $(function () {
                        $('#pulau').change(function () {
                            if ($("#pulau").val() === "") {

                            } else {
                                var koordinat = $('#pulau').val().split('|');
                                var x = koordinat[0];
                                var y = koordinat[1];
                                var lokasi = new google.maps.LatLng(x, y);
                                map.setCenter(lokasi);
                                map.setZoom(6);
                            }

                        })
                    });
                    // Zoom Provinsi
                    $(function () {
                        $('#prov').change(function () {
                            if ($("#prov").val() === "") {

                            } else {
                                var koordinat = $('#prov').val().split('|');
                                var x = koordinat[0];
                                var y = koordinat[1];
                                var lokasi = new google.maps.LatLng(x, y);
                                map.setCenter(lokasi);
                                map.setZoom(8);
                            }
                        })
                    });

                });

                // Memanggil data informasi perusahaan
                $.ajax({
                    type: 'GET',
                    url: base_url + 'intelligence/Competitor/listInformasi',
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function (data) {

                        for (var i = 0; i < data.length; i++) {
                            if (data[i]['TANGGAL'] === null) {
                                var dt_tgl = "-";
                            } else {
                                var dt_tgl = data[i]['TANGGAL'];

                            }
                            var user = '';
                           // if(data[i]['OTOMATIS'] == 1){
                                user = data[i]['CREATE_BY'].toString().toLowerCase();
                            //}
                            list = $('#info');
                            list.append('<li class="sidebar-message list-group-item news-info" data-category="' + dt_tgl + '">' +
                                    '<strong>' + data[i]['NAMA_PERUSAHAAN'] + '</strong>' +
                                    '<br>' +
                                    '<strong>' + data[i]['NAMA_FASILITAS'] + '</strong>' +
                                    '<br>' +
                                    '<small class="text-muted">' + dt_tgl + '</small>' +
                                    '<div class="small m-t-xs" id="zoom">' + '<p style="margin: 0 0 5px;width: 195px;">' + user + ' ' + data[i]['KALIMAT'].toString().toLowerCase() + '.' + '</p>' + '<a href="javascript:void(0)"  data-id="' + data[i]['LATITUDE'] + '|' + data[i]['LONGITUDE'] + '" >' + '<p class="m-b-none">' + '<i class="fa fa-map-marker"></i>' + ' ' + data[i]['JENIS_FASILITAS'] + '</p></a>' + '</div>' + '</li>'
                                    );
                            //  Zooming lokasi di notifikasi sidebar
                            $("#zoom a").click(function () {
                                var koordinat = $(this).data("id").split('|');
                                var x = koordinat[0];
                                var y = koordinat[1];
                                var lokasi = new google.maps.LatLng(x, y);
                                map.setCenter(lokasi);
                                map.setZoom(15);
                            });

                        }
                    }
                });


                //  Reset tanggal
                $("#reset-news").click(function () {
                    $('.date').val("");
                    var list = $(".news-list .news-info");
                    $(list).fadeOut("fast");
                    $(".news-list").find("li").each(function (p) {
                        $(this).delay(200).slideDown("fast");
                    }).on('changeDate', function (e) {
                    });
                });


            }
        });

        // Filter berdasarkan nama perusahaan
        $("#perusahaan").click(function () {
            $('#wadahPerusahaan').show();
            $('#wadahFasilitas').hide();
            $('#modal-list').modal('show');
            var title1 = "Pilih Perusahaan";
            $(".modal-header #myModalLabel").text(title1);
            idList = "#fListPerusahaan";
        });
        
         // Filter berdasarkan jenis fasilitas
        $("#fasilitas").click(function () {
            $('#wadahPerusahaan').hide();
            $('#wadahFasilitas').show();
            $('#modal-list').modal('show');
            var title2 = "Pilih Fasilitas";
            $(".modal-header #myModalLabel").text(title2);
            idList = "#fListFasilitas";
        });
    });

    // Memanggil proses filter
    $('#sort-news').change(function () {
        var filter = $(this).val();
        filterList(filter);
    });
    // Proses filter notifikasi sidebar berdasarkan tanggal
    function filterList(filter) {
        var list = $(".news-list .news-info");
        $(list).fadeOut("fast");
        if (filter === "") {
            $(".news-list").find("li").each(function (p) {
                $(this).delay(200).slideDown("fast");
            });
        } else {
            $(".news-list").find('li[data-category="' + filter + '"]').each(function (x) {
                $(this).delay(200).slideDown("fast");
            });
        }
    }


</script>

