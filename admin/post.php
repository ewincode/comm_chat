
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<h5>Count Of Post Per Barangay in Catbalogan</h5> 
<div id='divChart'>
  <canvas id="myChart" style="width:100%; height: 30px;"></canvas>
</div>

<div id='divDetails'></div>

<?php
include ('../conn.php'); 

$municipalities =[];
$post =[];
$datas = mysqli_query($conn," SELECT *
                              FROM(
                                  SELECT COUNT(t1.id) as pCount,t3.muni_desc
                                  FROM post_tb t1
                                  LEFT JOIN user_tbl t2 on t1.UserID=t2.id
                                  LEFT JOIN add_muni t3 on t2.muni=t3.id
                                  WHERE t1.IsDeleted=0
                                  GROUP BY t3.muni_desc
                                  )t1
                              ORDER BY pCount DESC");  
foreach($datas as $data){  
  //echo 123;
  $municipalities[] = $data['muni_desc'];
  $post[] = $data['pCount'];
} 
 
?>

 

<script>
  
const xValues = <?php echo json_encode($municipalities); ?>;
const yValues = <?php echo json_encode($post); ?>;

const myChart = new Chart("myChart", {
    type: "bar",
    data: {
        labels: xValues,
        datasets: [{
            data: yValues,
            borderColor: "red",
            //fill: false
        }]
    },
    options: {
        legend: {
            display: false
        },
        onClick: (event, chartElement) => {
            if (chartElement.length > 0) {
                const index = chartElement[0]._index;
                const value = myChart.data.datasets[0].data[index];
                const label = myChart.data.labels[index];
                console.log(`Clicked on ${label}: ${value}`);
                OpenDetails(label);
                //alert(label);
                // You can perform any action with the clicked value here
            }
        }
    }
});


  function OpenDetails(muni_name)
  {
    //chart_details 
      var xhr = new XMLHttpRequest();
        xhr.open('GET', 'chart_details.php?muni='+muni_name, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('divDetails').innerHTML = xhr.responseText; 
                //scrollDownSlowly();
            }
        };
        xhr.send();  
    }


</script>
 
 