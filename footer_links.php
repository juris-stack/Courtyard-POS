    <script src="asset/js/jquery-1.11.1.min.js"></script>
    <script src="asset/bootstrap/js/bootstrap.min.js"></script>
    <script src="asset/js/jquery.backstretch.min.js"></script>
    <script src="asset/js/scripts.js"></script>
    <script type="text/javascript" src="asset/js/datatables.min.js"></script>
    <script src="js/jquery.freezeheader.js"></script>
    <script>
      $('#tableCart').freezeHeader({
        height: "355px"
      })
    </script>
    <script>
      $(document).ready(function () {
      $('#dtTable').DataTable();
      $('.dataTables_length').addClass('bs-select');
    });
    </script>
    <script>
      $(document).ready(function () {
      $('#dtStock').DataTable();
      $('.dataTables_length').addClass('bs-select');
    });
    </script>
    <script>
      $(document).ready(function () {
      $('#dtPrice').DataTable();
      $('.dataTables_length').addClass('bs-select');
    });
    </script>

    <script>  
         $(document).ready(function(){  
              $('#employee_data').DataTable();  
         });  
    </script>
    <script>
      document.getElementById("fileToUpload").onchange = function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("image").style.display = '';
            document.getElementById("image").src = e.target.result;
            document.getElementById("imageSamp").style.display = 'none';
        };
        reader.readAsDataURL(this.files[0]);
        };
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
      </script>
  <?php if(isset($script)){ echo $script; } ?>
        <script>
        $(function(){
              var IMG = $('#media').val();
              $('#imageSamp').attr("src",IMG);
              $('#size').on('change', function() {
              var size = $("#size").val();
              $("#sizeFinal").val(size);
            })
        });
          document.getElementById("fileToUpload").onchange = function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("image").style.display = '';
                document.getElementById("image").src = e.target.result;
                document.getElementById("imageSamp").style.display = 'none';
            };
        reader.readAsDataURL(this.files[0]);
        };
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>
    <script>
    $(document).ready(function(){
     
     function load_unseen_notification(view = '')
     {
      $.ajax({
       url:"fetch_notif.php",
       method:"POST",
       data:{view:view},
       dataType:"json",
       success:function(data)
       {
        $('.dropdown-menu').html(data.notification);
        if(data.unseen_notification > 0)
        {
         $('.count').html(data.unseen_notification);
        }
       }
      });
     }
     
     load_unseen_notification();
     

     $(document).on('click', '.dropdown-toggle', function(){
      $('.count').html('');
      load_unseen_notification('yes');
     });
     
     setInterval(function(){ 
      load_unseen_notification();; 
     }, 5000);
     
    });
    </script>
