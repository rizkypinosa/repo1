<!DOCTYPE html>
<html lang="en">
<head>
    <title id='Description'>Bitcoin Indonesia</title>
    <link rel="stylesheet" href="file.css">

</head>
<body class='default'>

<p><b>Update data dalam: <span id="timer">0</span> Detik</b></p>
<table id="coins">
  <tr>
    <th>Pairs</th>
    <th>Harga</th>
    <th>Beli</th>
    <th>jual</th>
    <th>Tertinggi 24h</th>
    <th>Terendah 24h</th>
  </tr>
</table>
<script>
var reloadData = 30; // dalam detik

var timer;

function updateDataAPI() {

  $.ajax({
    url: 'https://indodax.com/api/summaries',
    success: function(data) {
      var row;

      $('#coins').html('<tr><th>Pairs</th><th>Harga</th> <th>Beli</th> <th>jual</th> <th>Tertinggi 24h</th><th>Terendah 24h</th></tr>')
      for (var key in data.tickers) {
        row = `<tr>
              <td>` + key.toUpperCase() + `</td>
              <td>` + formatNumber(data.tickers[key].last) + `</td>
              <td>` + formatNumber(data.tickers[key].buy) + `</td>
              <td>` + formatNumber(data.tickers[key].sell) + `</td>
              <td>` + formatNumber(data.tickers[key].high) + `</td>
              <td>` + formatNumber(data.tickers[key].low) + `</td>
            </tr>`
        $('#coins tr:last').after(row);
      }

      clearTimeout(timer)
      $('#timer').html(reloadData)
      setTimeout(updateDataAPI, reloadData * 1000)
      updateTimer()
    },
    error: function(err) {
      alert("Tidak bisa mengambil data API")
    }
  })
}

function formatNumber(n) {
  if (n.indexOf('.') > -1)
    return parseFloat(n).toFixed(8);
  else
    return parseInt(n).toLocaleString("id-ID")
}

function updateTimer() {
  a = parseInt($('#timer').html())
  $('#timer').html(a - 1)
  if (a > 0)
    timer = setTimeout(updateTimer, 1000)
}
updateDataAPI()
</script>

 
</body>
</html>
