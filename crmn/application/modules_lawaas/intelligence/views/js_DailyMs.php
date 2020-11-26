<script>
    var org = 1;
    var org1 = 1;
    var month = new Array(12);
    month[0] = "01";
    month[1] = "02";
    month[2] = "03";
    month[3] = "04";
    month[4] = "05";
    month[5] = "06";
    month[6] = "07";
    month[7] = "08";
    month[8] = "09";
    month[9] = "10";
    month[10] = "11";
    month[11] = "12";
    var initialmonth = new Array();
    initialmonth["01"] = "Jan";
    initialmonth["02"] = "Feb";
    initialmonth["03"] = "Mar";
    initialmonth["04"] = "Apr";
    initialmonth["05"] = "Mei";
    initialmonth["06"] = "Jun";
    initialmonth["07"] = "Jul";
    initialmonth["08"] = "Agu";
    initialmonth["09"] = "Sep";
    initialmonth["10"] = "Okt";
    initialmonth["11"] = "Nop";
    initialmonth["12"] = "Des";
    // var Chart;
    var d = new Date();
    var d = new Date();
    d.setMonth(d.getMonth());
    var tahun = d.getUTCFullYear();
    var bulan = month[d.getUTCMonth()];
    var hari = d.getDate();
    /*    
     var tahun = d.getUTCFullYear();
     var bulan = month[d.getUTCMonth() - 1];
     */

    //fungsi untuk menambahkan separator koma
    function formatAngka(n) {
        var num = parseFloat(n);
        return (num + '').replace(/(\d)(?=(\d{3})+$)/g, '$1,');
    }
    //fungsi untuk menambahkan separator titik
    function formatAngkaRibuan(n) {
        var num = parseFloat(n);
        return (num + '').replace(/(\d)(?=(\d{3})+$)/g, '$1.');
    }

    //fungsi untuk menentukan warna pencapaian market share di panel summary
    function formatWarnaMs(id, n) {
        if (n >= 2) { //jika selisih market share terhadap rkap lebih besar / sama dengan 2
            $(id).css('background-color', '#ff4545');
            $(id).css('color', '#fff');
        } else if (n < 2 && n > 0) { //jika selisih antara 2 - 0
            $(id).css('background-color', '#fef536');
            $(id).css('color', '#000');
        } else if (n < 0) { // jika selisih lebih kecil atau sama dengan 0
            $(id).css('background-color', '#49ff56');
            $(id).css('color', '#000');
        }
    }
    //fungsi untuk menampilkan peta
    function peta() {
        var ctx = document.getElementById("myChartTrend");
        var ctx2 = document.getElementById("myChartTrendDua");
        var lineChartData = {
            labels: ['1'],
            datasets: [
                {
                    label: "SMIG",
                    type: "line",
                    fill: false,
                    data: [1],
                    borderColor: 'rgba(255,99,132,1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 3,
                    spanGaps: false
                }
            ]
        };
        myChartTrend = new Chart(ctx, {
            type: 'line',
            data: lineChartData,
            options: {
                title: {
                    display: true,
                    text: 'Harga Jual'
                }
            }
        });
        myChartTrendDua = new Chart(ctx2, {
            type: 'line',
            data: lineChartData,
            options: {
                title: {
                    display: true,
                    text: 'Harga Jual'
                }
            }
        });
        var peta;
        var url = base_url + 'intelligence/DailyMs/getData/' + org + '/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
                $('#summary').hide();
            },
            success: function (data) {
                peta = new FusionCharts("maps/indonesia", "chartobject-1", "100%", "500", "chart1", "json");
                peta.setChartData(data);

                //event on mouse clik untuk menampilkan grafik box plot
                peta.addEventListener("entityClick", function (e, d) {
                    //alert(d.id);
                    //getDetail(d.id);
                    boxPlot(d.id, 0, type_semen);
                    grafik_trend(d.id, 0, 1, type_semen);
                });
                peta.render("chart1");
                $('#loading_purple').hide();
            }
        });
    }
    //fungsi untuk update peta
    function updatePeta(org) {
        var dataPeta;
        var url = base_url + 'intelligence/DailyMs/getData/' + org + '/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').show();
            },
            success: function (data) {
                $('#chart1').updateFusionCharts({"dataSource": data, "dataFormat": "json"});
                $('#loading_purple').hide();
            }
        });
    }

    //pembuatan tabel summary start
    function summaryDms(tahun, bulan) {
        var url = base_url + 'intelligence/DailyMs/summaryDMS/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            dataType: 'json',
            success: function (data) {
                $('#bulanini').html($('#bulan option:selected').text().toUpperCase());
                $('#realsmig').html(data['REAL']);
                $('#realsg').html(data['REALSG']);
                $('#realsp').html(data['REALSP']);
                $('#realst').html(data['REALST']);
                $('#targetsmig').html(data['TARGETSMIG'] + '%');
                $('#targetsg').html(data['TARGETSG'] + '%');
                $('#targetsp').html(data['TARGETSP'] + '%');
                $('#targetst').html(data['TARGETST'] + '%');
                $('#mssmig').html(data['MSSMIG'] + '%');
                $('#mssg').html(data['MSSG'] + '%');
                $('#mssp').html(data['MSSP'] + '%');
                $('#msst').html(data['MSST'] + '%');
                var selsmig = data['TARGETSMIG'].replace(',', '.') - data['MSSMIG'].replace(',', '.');
                var selsg = data['TARGETSG'].replace(',', '.') - data['MSSG'].replace(',', '.');
                var selsp = data['TARGETSP'].replace(',', '.') - data['MSSP'].replace(',', '.');
                var selst = data['TARGETST'].replace(',', '.') - data['MSST'].replace(',', '.');
                //pewarnaan mssmig
                formatWarnaMs('#mssmig', selsmig);
                //pewarnaan mssg
                formatWarnaMs('#mssg', selsg);
                //pewarnaan mssp
                formatWarnaMs('#mssp', selsp);
                //pewarnaan msst
                formatWarnaMs('#msst', selst);
            }
        });
    }
    //pembuatan tabel summary end

    var Chart1_popup, Chart2_popup;
    var ctx1_popup = document.getElementById("Chart1-popup");
    var ctx2_popup = document.getElementById("Chart2-popup");
    var lineChartDataVolume;
    //pembuatan chart ms harian start
    var myChart;
    var myChartakum;
    var myChartTrend;
    var myChartTrendDua;
    var Chart;
    var lineChartData;
    var lineChartData1;

    var kode_prov;
    var kode_kota;
    var j_kilo = 1;

    var type_semen;

    var tahun_awal, tahun_akhir, bulan_awal, bulan_akhir;

    //fungsi grafik MS harian
    function grafik_msH() {
        $('#tahun1').val(tahun);
        $('#bulan1').val(bulan);
//        $('#org1').val(org);
        var ctx = document.getElementById("myChart");
        var ctx1 = document.getElementById("myChartakum");
        var url = base_url + 'intelligence/DailyMs/grafik_msH/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#loading_purple').hide();
            },
            success: function (data) {
                var lineChartData = {
                    labels: data['TANGGAL'],
                    datasets: [
                        //inisialisasi dataset SMIG
                        {
                            label: "SMIG",
                            type: "line",
                            fill: false,
                            data: data['DATAMS'],
                            borderColor: 'rgba(255,99,132,1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 3,
                            spanGaps: false
                        },
                        //inisialisasi dataset SG
                        {
                            label: "SG",
                            type: "line",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(75,192,192,0.4)",
                            borderColor: "rgba(75,192,192,1)",
                            data: data['DATAMSSG'],
                            borderWidth: 3,
                            spanGaps: false
                        },
                        //inisialisasi dataset SP
                        {
                            label: "SP",
                            type: "line",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(153, 102, 255, 0.2)",
                            borderColor: "rgba(153, 102, 255, 1)",
                            data: data['DATAMSSP'],
                            borderWidth: 3,
                            spanGaps: false,
                        },
                        //inisialisasi dataset ST
                        {
                            label: "ST",
                            type: "line",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(255, 159, 64, 0.2)",
                            borderColor: "rgba(255, 159, 64, 1)",
                            data: data['DATAMSST'],
                            borderWidth: 3,
                            spanGaps: false,
                        }]
                };
//                myChart.destroy();
                //chart ms harian
                myChart = new Chart(ctx, {
                    type: 'line',
                    data: lineChartData,
                    options: {
                        title: {
                            display: true,
                            text: 'MS Harian'
                        },
                        legend: {
                            position: 'bottom',
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + formatAngka(tooltipItem.yLabel) + ' %';
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    scaleLabel: {
                                        display: false,
                                        labelString: 'Tanggal'
                                    }
                                }],
                            yAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Market Share (%)'
                                    },
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                        }
                    }
                });
                //chart ms akumulasi
                var lineChartData1 = {
                    labels: data['TANGGAL'],
                    datasets: [
                        {
                            label: "SMIG",
                            type: "line",
                            fill: false,
                            data: data['AKUMSMIG'],
                            borderColor: 'rgba(255,99,132,1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 3,
                            spanGaps: false,
                        },
                        {
                            label: "SG",
                            type: "line",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(75,192,192,0.4)",
                            borderColor: "rgba(75,192,192,1)",
                            data: data['AKUMSG'],
                            borderWidth: 3,
                            spanGaps: false,
                        },
                        {
                            label: "SP",
                            type: "line",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(153, 102, 255, 0.2)",
                            borderColor: "rgba(153, 102, 255, 1)",
                            data: data['AKUMSP'],
                            borderWidth: 3,
                            spanGaps: false,
                        },
                        {
                            label: "ST",
                            type: "line",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(255, 159, 64, 0.2)",
                            borderColor: "rgba(255, 159, 64, 1)",
                            data: data['AKUMST'],
                            borderWidth: 3,
                            spanGaps: false,
                        }]
                };
                myChartakum = new Chart(ctx1, {
                    type: 'line',
                    data: lineChartData1,
                    options: {
                        title: {
                            display: true,
                            text: 'MS Akumulasi'
                        },
                        legend: {
                            position: 'bottom',
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + formatAngka(tooltipItem.yLabel) + ' %';
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    scaleLabel: {
                                        display: false,
                                        labelString: 'Tanggal'
                                    }
                                }],
                            yAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Market Share (%)'
                                    },
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                        }
                    }
                });
                $("#myModal1").modal("show");
                $('#loading_purple').hide();
            }
        });

    }
    //fungsi update data gafik MS harian
    function updategrafik_msH(tahun, bulan) {
//        console.log('update');
        var url = base_url + 'intelligence/DailyMs/grafik_msH/' + tahun + '/' + bulan;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            success: function (datas) {
                myChart.data.datasets[0].data = datas['DATAMS']; //grafik harian SMIG
                myChart.data.datasets[1].data = datas['DATAMSSG']; //grafik harian SG
                myChart.data.datasets[2].data = datas['DATAMSSP']; //grafik harian SP
                myChart.data.datasets[3].data = datas['DATAMSST']; //grafik harian ST
                myChartakum.data.datasets[0].data = datas['AKUMSMIG']; //grafik harian SMIG kumulatif
                myChartakum.data.datasets[1].data = datas['AKUMSG']; //grafik harian SG kumulatif
                myChartakum.data.datasets[2].data = datas['AKUMSP']; //grafik harian SP kumulatif
                myChartakum.data.datasets[3].data = datas['AKUMST']; //grafik harian ST kumulatif
                myChart.update();
                myChartakum.update();
            }
        });
    }

    function grafik_trend(kd_prov, kd_kota, jenis_price, type_semen) {
        var ctx = document.getElementById("myChartTrend");
        var ctx2 = document.getElementById("myChartTrendDua");
        var url = base_url + 'intelligence/DailyMs/getTrendPrice';
        $.ajax({
            url: url,
            type: 'post',
            data: {
                kd_prov: kd_prov,
                kd_kota: kd_kota,
                tahun_awal: tahun,
                bulan_awal: '01',
                tahun_akhir: tahun,
                bulan_akhir: month[d.getUTCMonth()],
                jenis_price: jenis_price,
                type_semen: type_semen
            },
            dataType: 'json',
            success: function (data) {
                var lineChartData = {
                    labels: data['bulan'],
                    datasets: data['dataJual']
                };
                var lineChartData2 = {
                    labels: data['bulan'],
                    datasets: data['dataTebus']
                };
                myChartTrend.destroy();
                //chart ms harian
                myChartTrend = new Chart(ctx, {
                    type: 'line',
                    data: lineChartData,
                    options: {
                        title: {
                            display: true,
                            text: 'Harga Jual'
                        },
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                fontSize: 10,
                                boxWidth: 10
                            }
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + formatAngkaRibuan(tooltipItem.yLabel);
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Bulan'
                                    }
                                }],
                            yAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Price (Rp)'
                                    },
                                    ticks: {
                                        suggestedMin: 0,
                                        callback: function (value, index, values) {
                                            return formatAngkaRibuan(value);
                                        }
                                    }
                                }]
                        }
                    }
                });
                myChartTrendDua.destroy();
                myChartTrendDua = new Chart(ctx2, {
                    type: 'line',
                    data: lineChartData2,
                    options: {
                        title: {
                            display: true,
                            text: 'Harga Tebus'
                        },
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                fontSize: 10,
                                boxWidth: 10
                            }
                        },
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' : ' + formatAngkaRibuan(tooltipItem.yLabel);
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Bulan'
                                    }
                                }],
                            yAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Price (Rp)'
                                    },
                                    ticks: {
                                        suggestedMin: 0,
                                        callback: function (value, index, values) {
                                            return formatAngkaRibuan(value);
                                        }
                                    }
                                }]
                        }
                    }
                });
                $('#loading_purple').hide();
            }
        });
    }

    function updategrafik_trend(kd_prov, kd_kota, jenis_price, tahun_awal, tahun_akhir, bulan_awal, bulan_akhir) {
//        console.log('update');
        var url = base_url + 'intelligence/DailyMs/getTrendPrice';
        $.ajax({
            url: url,
            type: 'post',
            data: {
                kd_prov: kd_prov,
                kd_kota: kd_kota,
                tahun_awal: tahun_awal,
                bulan_awal: bulan_awal,
                tahun_akhir: tahun_akhir,
                bulan_akhir: bulan_akhir,
                jenis_price: jenis_price,
                type_semen: type_semen
            },
            dataType: 'json',
            success: function (datas) {
                myChartTrend.data.labels = datas['bulan'];
                myChartTrend.data.datasets = datas['dataJual'];
                myChartTrendDua.data.labels = datas['bulan'];
                myChartTrendDua.data.datasets = datas['dataTebus'];
                myChartTrend.update();
                myChartTrendDua.update();
            }
        });
    }

    function upload_modal() {
        $("#contain-upload").hide();
        $("#modalUpload").modal("show");
    }
    function uploadFiles()
    {
        // Create a formdata object and add the files
        var formData = new FormData($("#frmFile")[0]);
        var url = base_url + 'intelligence/DailyMs/upload';
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data) {
                $("#tabel-upload tbody").html(data);
                $("#contain-upload").show();
//                console.log(data);
            }
        });
//        console.log('upload');
    }
    // pembuatan box plot per provinsi
    function boxPlot(kd_prov, kd_kota, jenis_kilo) {
        kode_prov = kd_prov;
        var url = base_url + 'intelligence/DailyMs/getPrice';
        $.ajax({
            type: "POST",
            url: url,
            data: {
                kd_prov: kd_prov,
                kd_kota: kd_kota,
                tahun: tahun,
                bulan: bulan,
                tipe_semen: jenis_kilo
            },
            dataType: 'json',
            beforeSend: function () {
                $("#loading_purple").show();
            },
            success: function (data) {
                $("#myModal").modal("show");
                $("#prov").html(data["provinsi"]["NM_PROV"]);
                $(".pilih-kota").html(data["kota"]);
                var layout1 = {
                    title: 'Survey Harga Jual',
                    autosize: false,
                    width: 650,
                    height: 430,
                    xaxis: {
                        showticklabels: false
                    },
                    yaxis: {
                        title: 'Rupiah'
                    },
//                    paper_bgcolor: '#f8fafb',
                    legend: {
                        orientation: 'h'
                    },
                    type: 'box'
                };
                var layout2 = {
                    title: 'Survey Harga Tebus',
                    autosize: false,
                    width: 650,
                    height: 430,
                    xaxis: {
                        showticklabels: false
                    },
                    yaxis: {
                        title: 'Rupiah'
                    },
//                    paper_bgcolor: '#f8fafb',
                    legend: {
                        orientation: 'h'
                    },
                    type: 'box'
                };
                Plotly.newPlot('wadahBoxplotjual', data["jual"], layout1, {displayModeBar: false});
                Plotly.newPlot('wadahBoxplottebus', data["tebus"], layout2, {displayModeBar: false});
                $("#loading_purple").hide();
            }
        });

    }
    // update data box plot per provinsi
    function updateBoxplot(kd_prov, kd_kota, jenis_kilo) {
        kode_kota = kd_kota;
        j_kilo = jenis_kilo;
        var url = base_url + 'intelligence/DailyMs/getPrice';
        $.ajax({
            type: "POST",
            url: url,
            data: {
                kd_prov: kd_prov,
                kd_kota: kd_kota,
                tahun: tahun,
                bulan: bulan,
                tipe_semen: jenis_kilo
            },
            dataType: 'json',
            beforeSend: function () {
                $("#loading_purple").show();
            },
            success: function (data) {
                var layout1 = {
                    title: 'Survey Harga Jual',
                    autosize: false,
                    width: 650,
                    height: 450,
                    xaxis: {
                        showticklabels: false
                    },
                    yaxis: {
                        title: 'Rupiah'
                    },
//                    paper_bgcolor: '#f8fafb',
                    legend: {
                        orientation: 'h'
                    }
                };
                var layout2 = {
                    title: 'Survey Harga Tebus',
                    autosize: false,
                    width: 650,
                    height: 450,
                    xaxis: {
                        showticklabels: false
                    },
                    yaxis: {
                        title: 'Rupiah'
                    },
//                    paper_bgcolor: '#f8fafb',
                    legend: {
                        orientation: 'h'
                    }
                };
                Plotly.newPlot('wadahBoxplotjual', data["jual"], layout1, {displayModeBar: false});
                Plotly.newPlot('wadahBoxplottebus', data["tebus"], layout2, {displayModeBar: false});
                $("#loading_purple").hide();
            }
        });

    }
    $(function () {
//        boxplot();
//        $('#table-dialog').hide();
//        $('#summary').hide();

        peta();
        summaryDms(tahun, bulan);
//        summary();

        var jeniskilo = $(".pilihkilo").attr("value");
        type_semen = jeniskilo;
        /*
         * inisialisasi awal
         */
        $('#tahun').val(tahun);
        $('#bulan').val(bulan);
        $('#tahun-awal').val(tahun);
        $('#bulan-awal').val('01');
        $('#tahun-akhir').val(tahun);
        $('#bulan-akhir').val(bulan);
//        tahun_awal = tahun;
//        tahun_akhir = tahun;
//        bulan_awal = '01';
//        bulan_akhir = bulan;

        tanggal = $('#tahun').val() + '' + $('#bulan').val();
        $('#org').change(function () {
            org = $('#org').val();
            updatePeta(org);
        });
        var mmlalu = month[bulan - 2];
        var mmskrg = bulan;
        var tahunlalu = (tahun - 1).toString().substring(2);
        var tahunskrg = tahun.toString().substring(2);
        $('.mml').html(initialmonth[mmlalu]);
        $('.yyl').html(tahunlalu);
        $('.mms').html(initialmonth[mmskrg]);
        $('.yys').html(tahunskrg);
        $('#filter').click(function () {
            tahun = $('#tahun').val();
            bulan = $('#bulan').val();
            org = $('#org').val();
            updatePeta(org);
//            hari = getLastDate(tahun, bulan);
            summaryDms(tahun, bulan);
//            summary();
            mmlalu = month[bulan - 2];
            mmskrg = bulan;
            tahunlalu = (tahun - 1).toString().substring(2);
            tahunskrg = tahun.toString().substring(2);
            $('.mml').html(initialmonth[mmlalu]);
            $('.yyl').html(tahunlalu);
            $('.mms').html(initialmonth[mmskrg]);
            $('.yys').html(tahunskrg);
        });

        // Chart.defaults.global.defaultFontColor = '#000';
        $('#tahun1').val(tahun);
        $('#bulan1').val(bulan);
        tahun1 = $('#tahun1').val();
        bulan1 = $('#bulan1').val();
//        $('#org1').change(function () {
//            org1 = $('#org1').val();
//            updategrafik_msH(org1, tahun1, bulan1);
//        });
        // filter pada grafik ms harian
        $('#filter2').click(function () {
            tahun1 = $('#tahun1').val();
            bulan1 = $('#bulan1').val();
//            org1 = $('#org1').val();
            updategrafik_msH(tahun1, bulan1);
        });
        $('#chartkum').hide();
        // event radio button pada grafik ms harian
        $("input[type='radio']").click(function () {
            selected_value = $(this).attr("value");
            if (selected_value === 'harian') {
                $('#chartkum').hide();
                $('#charthar').show();
            } else if (selected_value === 'akumulasi') {
                $('#charthar').hide();
                $('#chartkum').show();
            }
        });

//        $('#pilih-kota-price').change(function () {
////            alert('berubah');
//            var kota = $('#pilih-kota-price').val();
//            updateBoxplot(kode_prov, kota, j_kilo);
//        });
        // end chart ms harian

        $(".pilihkilo").click(function () {
            var jeniskilo = $(this).attr("value");
            type_semen = jeniskilo;
            updateBoxplot(kode_prov, kode_kota, jeniskilo);
            var jenisprice = $(".pilihprice").val();
            var tahun_awal = $("#tahun-awal").val();
            var tahun_akhir = $("#tahun-akhir").val();
            var bulan_awal = $("#bulan-awal").val();
            var bulan_akhir = $("#bulan-akhir").val();
            var kode_kota = $("#pilih-kota-trend").val();
            updategrafik_trend(kode_prov, kode_kota, jenisprice, tahun_awal, tahun_akhir, bulan_awal, bulan_akhir);
        });

        $(".pilihprice").click(function () {
            var jenisprice = $(this).attr("value");
            var tahun_awal = $("#tahun-awal").val();
            var tahun_akhir = $("#tahun-akhir").val();
            var bulan_awal = $("#bulan-awal").val();
            var bulan_akhir = $("#bulan-akhir").val();
            var kode_kota = $("#pilih-kota-trend").val();
            updategrafik_trend(kode_prov, kode_kota, jenisprice, tahun_awal, tahun_akhir, bulan_awal, bulan_akhir);
        });
        $(".filterprice").change(function () {
            var jenisprice = $(".pilihprice").val();
            var tahun_awal = $("#tahun-awal").val();
            var tahun_akhir = $("#tahun-akhir").val();
            var bulan_awal = $("#bulan-awal").val();
            var bulan_akhir = $("#bulan-akhir").val();
            var kode_kota = $("#pilih-kota-trend").val();
            updateBoxplot(kode_prov, kode_kota, j_kilo);
            updategrafik_trend(kode_prov, kode_kota, jenisprice, tahun_awal, tahun_akhir, bulan_awal, bulan_akhir);
        });

        //======= FUNCTION FILTER, VIEW, UPDATE AND DELETE DATA PRICE=======\\ 
//        $('#tahun_fil').val(tahun);
//        $('#bulan_fil').val(bulan);
//        tahun_fil = $('#tahun_fil').val();
//        bulan_fil = $('#bulan_fil').val(bulan);
        table = $('#tabelprice').DataTable({
            "processing": true,
            "serverSide": false,
            "order": [],
            "Filter": true,
            "Dom": "lrtip",
            "ajax": {
                "url": base_url + 'intelligence/DailyMs/listprice/'+bulan+'/'+tahun,
                "type": "POST"
            }
        });
        // START filter select data price (provinsi-kota-bulan-tahun)
        var oTable = $('#tabelprice').dataTable();

        $('#provinsi').change(function () {
            oTable.fnFilter($("#provinsi option:selected").text(), 1);
        });

        $('#kota').change(function () {
            oTable.fnFilter($("#kota option:selected").text(), 2);
        });
        
        $('#bulan_fil').change(function () {
//            oTable.fnFilter($(this).val(), 5);
            bulan_fil = $('#bulan_fil').val();
            tahun_fil = $('#tahun_fil').val();
            var url_bul = base_url + 'intelligence/DailyMs/listprice/'+bulan_fil+'/'+tahun_fil;
            table.ajax.url(url_bul).load(); 
        });

        $('#tahun_fil').change(function () {
            bulan_fil = $('#bulan_fil').val();
            tahun_fil = $('#tahun_fil').val();
            var url_bul = base_url + 'intelligence/DailyMs/listprice/'+bulan_fil+'/'+tahun_fil;
            table.ajax.url(url_bul).load(); 
        });
        // END filter select data price (provinsi-kota-bulan-tahun)

    });

    var table;
    var base_url = '<?php echo base_url(); ?>';

    function edit_price(id)
    {

        //Ajax Load data from ajax
        $.ajax({
            url: base_url + 'intelligence/DailyMs/detail_price/' + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {

                $('[name="ID"]').val(data.ID);
                $('[name="HARGA_TEBUS"]').val(data.HARGA_TEBUS);
                $('[name="HARGA_JUAL"]').val(data.HARGA_JUAL);
                $('#modal_form').modal('show');
                $('.modal-title').text('Edit Data Price');

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error');
            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(null, false); //reload datatable ajax 
    }
    // proses simpan add new price atau edit price
    function save()
    {
        $('#btnSave').text('simpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        // ajax adding data to database
        var formData = new FormData($('#form')[0]);
        $.ajax({
            url: base_url + 'intelligence/DailyMs/update_price',
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (data)
            {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                } else
                {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error');
                $('#btnSave').text('simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }
    // proses delete price
    function delete_price(id)
    {
        if (confirm('Yakin ingin menghapus data ini?'))
        {
            // ajax delete data to database
            $.ajax({
                url: base_url + 'intelligence/DailyMs/delete_price/' + id,
                type: "POST",
                dataType: "JSON",
                success: function (data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error');
                }
            });

        }
    }

    function provinsi() {
        $.ajax({
            url: '<?php echo site_url(); ?>intelligence/DailyMs/cek_kota',
            type: 'POST',
            data: {"NM_PROV": $('#provinsi').val()},
            success: function (e) {
                $('#kota').html(JSON.parse(e).list_kota_dibawa);
            }
        });
    }
    // export excel price
    function downloadPrice(){
        var kd_prov, kd_kota, tahun, bulan;
        
        kd_prov = $('#provinsi').val();
        kd_kota = $('#kota').val();
        tahun = $('#tahun_fil').val();
        bulan = $('#bulan_fil').val();
        var url = base_url+'intelligence/DailyMs/downloadPrice/'+kd_prov+'/'+kd_kota+'/'+tahun+'/'+bulan;
        console.log(url);
        window.open(url); 
    }
</script>


