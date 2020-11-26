<canvas id="myChart" width="100%" height="50"></canvas>
<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        // labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        labels: [<?php foreach($data->result() as $row){ ?>"<?=$row->TGL_STOK?>",<?php } ?>],
        datasets: [{
            label: '# of Votes',
            data: [<?php foreach($data->result() as $row){ ?>"<?=$row->QTY_STOK?>",<?php } ?>]
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>