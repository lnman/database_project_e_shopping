<?php
/**
* Home class
* For homepage 
*/
class Home
{
	
	function __construct()
	{
		# code...
	}
  public function show_home()
  {
    ?>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <!--Sidebar content-->
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                  <li class="nav-header">Top Categories</li>
                    <?php
                    $sidemenu = array('People','Model','Electronics');
                    foreach ($sidemenu as $value) 
            {
              if(strcmp($_SERVER['PHP_SELF'],'/search.php?type='.$value)==0)
              {
                echo '<li class="active">';
              }else{echo '<li class="">';}
              echo '<a href="./search.php?type='.$value.'">'.$value.'</a></li>';
            }
                    ?>
                </ul>
              </div>
        </div>
        <div class="span10">
            <form class="search pull-left" method="POST" action="./search.php">
          <div class="span9">
                    <div class='input-prepend'>
                        <select>
                          <?php
                          $category = array('All Category','People','Model','Electronics');
                          foreach ($category as $value) {
                            echo '<option>'.$value.'</option>';
                          }
                          ?>
                        </select>
                        <input type="text" class="input-xlarge" id="search" name="search" placeholder="Search">
                        <button type="submit" class="btn">Search</button>
                    </div>
                </div>
                <table class="table">
                  <tr>
                    <td class="control-group">
                  <label class="control-label">User type</label>
                  <div class="controls">
                      <select name='time'>
                        <?php
                            $time = array('Forever','1 day Old','1 week Old','1 month Old','6 month Old');
                            foreach ($time as $value) {
                              echo '<option value="'.$value.'">'.$value.'</option>';
                            }
                            ?>
                      </select>
                    </div>
                </td>

                <td class="control-group">
                      <label class="control-label">Manufacturer</label>
                  <div class="controls">
                      <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>
                      <input type="text" class="input" id="manufacturer" name="manufacturer" placeholder="manufacturer">
                    </div>
                  </td>
                  <td class="control-group">
                      <label class="control-label">Price From</label>
                  <div class="controls">
                      <div class="input">
                      <input type="number" class="input-small" id="price_from" name="price_from">
                    </div>
                  </td>
                  <td class="control-group">
                      <label class="control-label">Price To</label>
                  <div class="controls">
                      <div class="input">
                      <input type="number" class="input-small" id="price to" name="price_to">
                    </div>
                  </td>
                <td class="column-fluid control-group">
                  <label class="control-label">Shipping Area</label>
                  <div class="controls">
                      <select name='shipping_region'>
                        <?php
                            $time = array('global','local');
                            foreach ($time as $value) {
                              echo '<option value="'.$value.'">'.$value.'</option>';
                            }
                            ?>
                      </select>
                    </div>
                  </td>
              </tr>
                  
                </table>
            </form>
            <?php
            $this->home();
            ?>
        </div>
      </div>
    </div>
    <?php

  }

	private function home()
	{
		?>
		<div class="span9">
			<div class="carousel slide carousel-fade" id="myCarousel">
            <div class="carousel-inner">
              <?php
              $num=0;
              $aa = array('DeskWalls (4)' => 'First Thumbnail label','DeskWalls (5)' => 'Second Thumbnail label','DeskWalls (6)' => 'Third Thumbnail label' );
              $strings='Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.';
              foreach ($aa as $key => $value) {
                # code...
                echo '<div class="item ';
                if($num==1)echo 'active';
                echo '">';
                echo '<img alt="" src="./img/'.$key.'.jpg">';
                echo '<div class="carousel-caption">';
                echo '<h4>'.$value.'</h4>';
                echo '<p>'.$strings.'</p>';
                echo '</div>';
                echo '</div>';
                $num++;
              }
              ?>
            </div>
            <a data-slide="prev" href="#myCarousel" class="left carousel-control">‹</a>
            <a data-slide="next" href="#myCarousel" class="right carousel-control">›</a>
          </div>
		</div>
    <div class="span9">
      <?php
      $this->get_featured_product();
      ?>
    </div>
		<?php

	}


  private function get_featured_product()
  {
    echo '<table class="table">';
    require("database_config.inc.php");
    $conn = oci_connect(db_user, db_pass,db_service);
    if($conn) {
      $q = 'SELECT dname,fname,iblob from pdm';
      $query = oci_parse($conn, $q);
      oci_execute($query);
      $x=0;
      while($db_data=oci_fetch_array($query)){
        if($x!==0 and $x%3==0){echo '</tr>';}
        if($x%3==0){echo '<tr>';}
        $name=$db_data[0];
        $price=$db_data[1];
        $lob=$db_data[2]->load();
        echo '<td><img style="height :500px;width: 300px;"src="data:image/jpeg;base64,'.base64_encode($lob).'" alt=""/>';
        echo '<label>'.$name.'</label>'.'<label class="pull-left">'.$price.'</label></td>';
        $x++;
      }
      if($x%3!==0){echo '</tr>';}
      oci_close($conn);
      echo '</table>';
    }
    else {exit ('DB Connection failed contact Administrator');}

  }
}


?>