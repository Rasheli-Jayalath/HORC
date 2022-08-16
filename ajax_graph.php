<script>


function reportgenPageLoad() {

  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("table_report").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","test.php",true);
  xmlhttp.send();
}


      window.onload = function() {
   
          reportgenPageLoad();

      };



  </script>
  <html>
  <body>
  <div id="table_report" >
  </div>
  </body>
  </html>