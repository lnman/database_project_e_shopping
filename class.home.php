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
                    $sidemenu = array('People'=>1,'Model'=>2,'Accesories'=>3,'Home Decor'=>4,'Electronics'=>5,'Entertainment'=>6,'Art'=>7,'Jewelry'=>8);
                    foreach ($sidemenu as $key => $value) 
                    {
                      if(strcmp($_SERVER['PHP_SELF'],'/search.php?type='.$value)==0)
                      {
                        echo '<li class="active">';
                      }else{echo '<li class="">';}
                      echo '<a href="./search.php?type='.$value.'">'.$key.'</a></li>';
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
                          $category = array('People'=>1,'Model'=>2,'Accesories'=>3,'Home Decor'=>4,'Electronics'=>5,'Entertainment'=>6,'Art'=>7,'Jewelry'=>8);
                          foreach ($category as $key=>$value) {
                            echo '<option value='.$value.'>'.$key.'</option>';
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
                  <label class="control-label">Product Age</label>
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
		<div class="span12">
			<div class="carousel slide carousel-fade" id="myCarousel">
            <div class="carousel-inner">
              <?php
              $num=0;
              $aa = array('feature_1' => 'First Thumbnail label','feature_2' => 'Second Thumbnail label','feature_3' => 'Third Thumbnail label' );
              $strings='We just launched this site with some cool features. Hope you like it.And We are open to suggestions.';
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
    <div class="span12">
      <?php
      $this->get_featured_product();
      ?>
    </div>
		<?php

	}


  private function get_featured_product()
  {
    echo '<table class="table"><legend><strong>Featured Product</strong></legend>';
    $name=array('','','','','','','','','','','','','','','');
    $price=array('','','','','',130,130,130,130,100,100,100,70);
    if(true) {
      $x=4;
      while($x<12){
        if($x!==4 and $x%4==0){echo '</tr>';}
        if($x%4==0){echo '<tr>';}
        $x++;
        echo '<td><a href="index.php"><img style="height :500px;width: 300px;"src="img/product_'.$x.'.png" alt=""/>';
        echo '<label>'.$name[$x].'</label>'.'<label class="pull-left">'.$price[$x].'$</label></a></td>';
      }
      if($x%4!==0){echo '</tr>';}
      echo '</table>';
    }
    else {exit ('DB Connection failed contact Administrator');}

  }
}


?>