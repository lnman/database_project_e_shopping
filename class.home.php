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
              <div class="item">
                <img alt="" src="./img/DeskWalls (4).jpg">
                <div class="carousel-caption">
                  <h4>First Thumbnail label</h4>
                  <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </div>
              </div>
              <div class="item active">
                <img alt="" src="./img/DeskWalls (5).jpg">
                <div class="carousel-caption">
                  <h4>Second Thumbnail label</h4>
                  <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </div>
              </div>
              <div class="item">
                <img alt="" src="./img/DeskWalls (6).jpg">
                <div class="carousel-caption">
                  <h4>Third Thumbnail label</h4>
                  <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </div>
              </div>
            </div>
            <a data-slide="prev" href="#myCarousel" class="left carousel-control">‹</a>
            <a data-slide="next" href="#myCarousel" class="right carousel-control">›</a>
          </div>
		</div>
		<?php

	}
}


?>