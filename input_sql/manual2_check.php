<?php include 'header.php'; 
if($_SESSION['userrole']=='user'){
    if($_SESSION['access_manual2'] != 1){
        header('Refresh: 0; URL=main.php?q=denied');
                exit();
    }
    }
?>


  <div class="container">

    <!-- Docs nav
    ================================================== -->
    <div class="row">

        <!-- Tables
        ================================================== -->
        <section id="tables">
          <div class="page-header">
            <h1>Manual2 Check</h1>
          </div>

          <p>
            <center>
              <button id="acceptButton" class="btn btn-large btn-success" type="button">Accept</button>
              <button id="rejectButton" class="btn btn-large btn-info" type="button">Reject</button>
              <button id="prevButton" class="btn btn-large btn-primary" type="button">Previous</button>
              <button id="nextButton" class="btn btn-large btn-primary" type="button">Next</button>
               <button id="undoButton" class="btn btn-large btn-primary" type="button">Undo</button>
<!--              <button id="deleteButton" class="btn btn-large btn-danger" type="button">Delete</button>-->
			  <a href="./main.php">
				<button id="abortButton" class="btn btn-large btn-inverse" type="button">Abort</button>
			  </a>
            </center>
          </p>
		  
		  <p id = "errormsg"></p> <p id = "leftcount"></p><b><p id = "undo_status"></p></b>
          <!-- <p>For basic styling&mdash;light padding and only horizontal dividers&mdash;add the base class <code>.table</code> to any <code>&lt;table&gt;</code>.</p> -->
          <div class="bs-docs-currentrow">
            <table class="table">
              <thead>
                <tr>
                    <th></th>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Surname</th>
                  <th>Address</th>
                  <th>Suburb</th>
                  <th>State</th>
                  <th>Zip</th>
                  <th>Mobile</th>
                  <th>Alt Phone</th>
                  <th>Home Phone</th>
                  <th>Business Phone</th>
                  <th>Status</th>
                  <th>Comments</th>
                  <th>Consultant</th>
                  <th>Action</th>
                </tr>
			  </thead>
			  <tbody>
				<tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
				  <td></td>
				</tr>
              </tbody>
            </table>
          </div>

          <hr class="bs-docs-separator">

<!--           <h2>Optional classes</h2>
          <p>Add any of the following classes to the <code>.table</code> base class.</p>
 -->
          <div class="bs-docs-candidates">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Surname</th>
                  <th>Address</th>
                  <th>Suburb</th>
                  <th>State</th>
                  <th>Zip</th>
                  <th>Mobile</th>
                  <th>Alt Phone</th>
                  <th>Home Phone</th>
                   <th>Business Phone</th>
                  <th>Status</th>
                  <th>Comments</th>
                  <th>Consultant</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  
                </tr>
              </tbody>
            </table>
          </div>
        </section>
      </div>
    </div>
  </div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h3 class="modal-title" id="myModalLabel"></h3>

            </div>
            <div class="modal-body">
                 

            </div>
            <!--/modal-body-collapse -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnDelteYes" href="#">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
            <!--/modal-footer-collapse -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h3 class="modal-title" id="myModalLabel"></h3>

            </div>
            <div class="modal-body">
                 

            </div>
            <!--/modal-body-collapse -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnParEditYes" href="#">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
            <!--/modal-footer-collapse -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


    <!-- Footer
    ================================================== -->
<!--     <footer class="footer">
      <div class="container">
        <p>Designed for input data from csv file and manage the database manually.</p>
      </div>
    </footer> -->



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
<!--    <script src="facebox/facebox.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('a[rel*=facebox]').facebox({
            loadingImage : 'facebox/loading.gif',
            closeImage   : 'facebox/closelabel.png'
        
        })
    })
</script>-->
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="js/bootstrap-affix.js"></script>

    <script src="js/holder/holder.js"></script>
    <script src="js/google-code-prettify/prettify.js"></script>

    <script src="js/application.js"></script>
    <script src="js/manualcheck2.form.min.js"></script>
<script>
$('body').on('hidden', '.modal', function () {
  $(this).removeData('modal');
});
</script>
  </body>
</html>
