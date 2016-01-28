<?php

//A Function to spin the roulette wheel
function spin($color){
  
    $num=rand(1, 38);

    //they are putting bet on either red or black
    if($num==1 || $num==3 || $num==5 || $num==7 || $num==9 || $num==12 || $num==14 || $num==16 || $num==18 || $num==19 || $num==21 || $num==23 || $num==25 || $num==27 || $num==30 || $num==32 || $num==34 || $num==36){
      //red
      $winningcolor="red";
    }else if($num==37 || $num==38){
      //green
      $winningcolor="green";
    }else{
      //black
      $winningcolor="black";
    }

    if($color==$winningcolor){
      return true;
    }else{
      return false;
    }

}

//If the form is being posted process it below
if(isset($_POST['task'])){
    $moneypot = $_POST['moneypot'];
    $startingpot =  $moneypot;
    $wonlast = true;
    $base_bet = $_POST['base_bet'];
    $maximumbet = $_POST['maximumbet'];
    $color = $_POST['color'];
    $numspins = $_POST['numspins'];
    $result_text = "";
    
    
    for($i=0;$i<$numspins;$i++){
      

      
      if($color=="random"){
        //choose a random color (red or black)
        $myrand = rand(1,2);
        $color = "black";
        if($myrand==2){
          $color = "red";
        }
      }
      
      if($wonlast){
          $current_bet = $base_bet;
      }else{
          if($current_bet<$maximumbet || $maximumbet==0){
              $current_bet = $current_bet*2;
          }
      }
      
      //make sure there is enough money for bet
      if($moneypot<$current_bet){
          
        $result_text .= "not enough money left in your pot to place bet of: ".$current_bet;
        break;
      }
    
      $result_text .= "your moneypot: ".$moneypot.". your bet: $" . $current_bet . " on ".$color." => ";
      
      if(spin($color)){  
        $wonlast = true;
        $moneypot +=  $current_bet;
        $result_text .= "Winner!<br/>";
      }else{
        $result_text.= "Loser<br/>";
        $wonlast = false;
        $moneypot -=  $current_bet;
      }
    
    }
    ?>
    
    Starting Money Pot: <?php echo $startingpot; ?><br/>
    Base Bet: <?php echo $base_bet; ?><br/>
    Maximum Bet: <?php echo $maximumbet; ?><br/>
    Color choosen: <?php echo $color; ?><br/>
    Number of Spins: <?php echo $numspins ?><br/><br/>
    <strong style="font-size:14px">Money after the bets: $<?php echo $moneypot; ?></strong><br/><br/>
    Summary of spins: <br/>
    <?php echo $result_text; ?>
    
<?php 
}else{
//If the form data has not been submitted just show the form in HTML
?>

    <form name="rform" method="post">
        Starting Money Pot: <input type="text" value="600" name="moneypot"> *<br/><br/>
        Base Bet: <input type="text" value="10" name="base_bet"> *<br/><br/>
        Maximum Bet: <input type="text" value="0" name="maximumbet"> (leave at 0 to keep doubling down)<br/><br/>
        Color choosen: <select name="color">
                         <option value="red">Red</option>
                         <option value="black">Black</option>
                         <option value="random">Random</option>
                       </select>
        <br/><br/>
        Number of Spins to do: <input type="text" value="100" name="numspins"> *<br/><br/>
      <input type="hidden" value="spin" name="task">
      <input type="submit" value="Spin the wheel!">
    </form>

<?php
}
?>
