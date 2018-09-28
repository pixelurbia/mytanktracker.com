<?php
/*
Template Name: Parameters table
*/
?>


<?php get_template_part('templates/header');      ?>

<?php 
//get vars
$tank_id = $_GET['tank_id'];


//init classes
$user_tanks = new Tanks();


$tank = $user_tanks->get_tank_data($tank_id);
$tank_id = $tank[0]->tank_id;
$user = $user_tanks->user_info();


     

?>
    
    <section class="frame"> 

      <div class="tank_header">
            <h2><?php echo  $tank[0]->tank_name ?></h2>
            <p>
            <?php
                if ($tank[0]->tank_volume) {
                    echo  '<span>Volume: '.stripslashes($tank[0]->tank_volume).' Gallons </span>';
                } 
                if ($tank[0]->tank_dimensions){
                    echo '<span>Dimensions: '.stripslashes($tank[0]->tank_dimensions).'</span>';
                }
                if ($tank[0]->tank_model){
                    echo '<span>Model: '.stripslashes($tank[0]->tank_model).'</span>';
                }
                if ($tank[0]->tank_make){
                    echo '<span>Make: '.stripslashes($tank[0]->tank_make).'</span>'; 
                }
            ?> 
            </p>
   <!--  
        <a class="option-btn track-btn" >
            <i class="fas fa-flask"></i> 
            <i class="text">Track</i>
        </a> -->
      <!--   <a class="option-btn">
            <i class="fas fa-cog"></i> 
            <i class="text">Filter</i>
        </a> -->
        <a href="<?php echo '/parameters?tank_id='.$tank_id;?>" class="option-btn">
            <i class="fas fa-search"></i>
            <i class="text">Parameter Breakout</i>
        </a>
         <a class="option-btn" id="export" param_type="<?php echo $param_type; ?>"
                curuser="<?php echo $curuser; ?>" tank_id="<?php echo $tank_id; ?>">
            <i class="fas fa-download"></i> 
            <i class="text" >Export</i>
        </a>
    </div>
 <?php 
        $cal = new Calendar();
        $cal->days_with_events();
        echo'<br>';

         $date_end = date('Y-m-31');
         $date_start = date('Y-m-01');  
        
         ?>
             <div class="filters">
            <input type="text" id="datepicker-from" placeholder="<?php echo  $date_start;?>">
            <input type="text" id="datepicker-to" placeholder="<?php echo  $date_end;?>">
            <a class="option-btn param-table-filters">
                <i class="fas fa-arrow-right"></i>
            </a> 
        </div>
        </section>
       
    
        <section class="params">

            <?php get_template_part('param-table-que');  ?>
        </section>
        <script type="text/javascript">
            var inputRow = $("<div />").append($('#input-row').clone()).html();

        </script>
        <div class="tank_img_bg" style="background:url(<?php echo $tank[0]->tank_image ?>)"></div>        
<?php get_template_part('templates/footer'); ?>
