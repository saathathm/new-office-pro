<?php include 'header.php'; 
    if($_SESSION['userrole']=='user'){
    if($_SESSION['access_input'] != 1){
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
                <h1>Input Page</h1>
            </div>

            <div class="container">
                <div>
                    <center>
                        <div id="infomsg" class="alert alert-info" style="width:40%">
                            <p id="msgpart">Select csv file to convert.</p>
                            <p id="resultpart"></p>
                        </div>
                        <div>                          
                        <input type="search" id ="importfile" name="importfile" value="" placeholder="Enter the file name" />
                         <input type="file" name="file" id="file" class='uniform'>
                        </div>
                        
                    </center>
                </div>

                <hr class="bs-docs-separator">
                <div class = "container">
                    <center>
                        <table><tr><td>
                                    <b>Field to check uniquiness:</b>
                                    <table>

                                        <tr><td style="height:42px;"><input class="group1" type="checkbox" name="uniq0" value="name"> Name</td></tr>
                                        <tr><td style="height:42px;"><input class="group1" type="checkbox" name="uniq1" value="surname"> Surname</td></tr>
                                        <tr><td style="height:42px;"><input class="group1" type="checkbox" name="uniq2" value="address"> Address</td></tr>
                                        <tr><td style="height:42px;"><input class="group1" type="checkbox" name="uniq3" value="suburb"> Suburb</td></tr>
                                        <tr><td style="height:42px;"><input class="group1" type="checkbox" name="uniq4" value="state"> State</td></tr>
                                        <tr><td style="height:42px;"><input class="group1" type="checkbox" name="uniq5" value="zip"> ZIP</td></tr>
                                        <tr><td style="height:42px;"><input class="group1" type="checkbox" name="uniq6" value="mobile"> Mobile</td></tr>
                                        <tr><td style="height:42px;"><input class="group1" type="checkbox" name="uniq7" value="mobile2"> Mobile 2</td></tr>
                                        <tr><td style="height:42px;"><input class="group1" type="checkbox" name="uniq8" value="home_phone"> Home Phone</td></tr>
                                        <tr><td style="height:42px;"><input class="group1" type="checkbox" name="uniq9" value="home_phone2"> Home Phone 2 </td></tr>
                                        <tr><td style="height:42px;"><input class="group1" type="checkbox" name="uniq10" value="business_phone"> Business Phone </td></tr>
                                        <tr><td style="height:42px;"><input class="group1" type="checkbox" name="uniq11" value="alt_phone"> Alt Phone </td></tr>
                                    </table>
                                </td><td width=150>&nbsp;</td><td>
                                    <b>Field to check for similar records:</b>
                                    <table>
                                        <tr><td style="height:42px;" ><input type="checkbox" name="similar0" class="group2" value="name"> Name</td><td>
                                                Accept&nbsp;&nbsp;<select name="name" class="sensivity" id="sensivity" style="width:60px;"><option name="sfff">1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option></select>chracters difference.
                                            </td></tr>
                                        <tr><td style="height:42px;"><input type="checkbox" name="similar1" class="group2" value="surname"> Surname</td><td>
                                                Accept&nbsp;&nbsp;<select name="surname" id="sensivity" class="sensivity" style="width:60px;"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option></select>chracters difference.
                                            </td></tr>
                                        <tr><td style="height:42px;"><input type="checkbox" name="similar2" class="group2" value="address" > Address</td><td>
                                                Accept&nbsp;&nbsp;<select name="address" id="sensivity" class="sensivity" style="width:60px;"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option></select>chracters difference.
                                            </td></tr>
                                        <tr><td style="height:42px;"><input type="checkbox" name="similar3" class="group2" value="suburb"> Suburb</td><td>
                                                Accept&nbsp;&nbsp;<select name="suburb" id="sensivity" class="sensivity" style="width:60px;"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option></select>chracters difference.
                                            </td></tr>
                                        <tr><td style="height:42px;"><input type="checkbox" name="similar4" class="group2" value="state"> State</td><td>
                                                Accept&nbsp;&nbsp;<select name="state" id="sensivity" class="sensivity" style="width:60px;"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option></select>chracters difference.
                                            </td></tr>
                            </tr>
                            <tr><td style="height:42px;"><input type="checkbox" name="similar5" class="group2" value="zip" > ZIP</td><td>
                                    Accept&nbsp;&nbsp;<select name="zip" id="sensivity" class="sensivity" style="width:60px;"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option></select>chracters difference.
                                </td></tr>
                            </tr>
                            <tr><td style="height:42px;"><input type="checkbox" name="similar6" class="group2" value="mobile" > Mobile</td><td>
                                    Accept&nbsp;&nbsp;<select name="mobile" id="sensivity" class="sensivity" style="width:60px;"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option></select>chracters difference.
                                </td></tr>
                            </tr>
                            <tr><td style="height:42px;"><input type="checkbox" name="similar7" class="group2" value="mobile2"> Mobile 2</td><td>
                                    Accept&nbsp;&nbsp;<select name="mobile2" id="sensivity" class="sensivity" style="width:60px;"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option></select>chracters difference.
                                </td></tr>
                            </tr>
                            <tr><td style="height:42px;"><input type="checkbox" name="similar8" class="group2" value="home_phone"> Home Phone</td><td>
                                    Accept&nbsp;&nbsp;<select name="home_phone" id="sensivity" class="sensivity" style="width:60px;"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option></select>chracters difference.
                                </td></tr>
                            </tr>
                            <tr><td style="height:42px;"><input type="checkbox" name="similar9" class="group2" value="home_phone2"> Home Phone 2 </td><td>
                                    Accept&nbsp;&nbsp;<select name="home_phone2" id="sensivity" class="sensivity" style="width:60px;"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option></select>chracters difference.
                                </td></tr>
                            </tr>
                            <tr><td style="height:42px;"><input type="checkbox" name="similar10" class="group2" value="business_phone"> Business Phone </td><td>
                                    Accept&nbsp;&nbsp;<select name="business_phone" id="sensivity" class="sensivity" style="width:60px;"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option></select>chracters difference.
                                </td></tr>
                            </tr>
                            <tr><td style="height:42px;"><input type="checkbox" name="similar11" class="group2" value="alt_phone"> Alt Phone </td><td>
                                    Accept&nbsp;&nbsp;<select name="alt_phone" id="sensivity" class="sensivity" style="width:60px;"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option></select>chracters difference.
                                </td></tr>
                            </tr>
                        </table>
                        </td></tr></table>
                    </center>
                </div>
                <div class = "container">
                    <center>
                        <p id = "errormsg"></p>
                        <p id = "recordinfomsg" class = "text-info"></p>
                        <div class="progress progress-striped active" >
                            <div id="convertprogress" class="bar" style="width: 0%;"></div>
                        </div>
                        <div class = "container" style="margin-top: 10px">
                            <div id="leven_error"></div>
                            <p>sum of levenshtein distance
                            <input type="number" id="sum_leven" name="sum_leven"style="width:6%">
                            </p>
                        </div>
                        <button id="convertButton" class="btn btn-large btn-primary" type="button">Convert Now</button>
                        <button id="abortButton" class="btn btn-large btn-danger" type="button">Abort Now</button>
                    </center>			
                </div>

                <!--           <h2>Optional classes</h2>
                          <p>Add any of the following classes to the <code>.table</code> base class.</p>
                -->    </section>
    </div>
</div>
<!-- Footer
================================================== -->
<!--     <footer class="footer">
      <div class="container">
        <p>Designed for input data from csv file and manage the database manually.</p>
      </div>
    </footer>
-->


<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.js"></script>
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

<script src="js/papaparse.min.js"></script> 
<script src="js/inputapp.form.min.js"></script>

<script>

</script>
</body>
</html>
