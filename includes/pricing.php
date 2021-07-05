<?php 
include_once "db.php";
include_once "../Classes/Payment.php";
$Payment = new Payment($connection);
$pacakage_result = $Payment->getAllPackage();
$pacakage_row = mysqli_fetch_all($pacakage_result);
$monthly = $pacakage_row[0];
$quartely = $pacakage_row[1];
$half_yearly = $pacakage_row[2];
$annually = $pacakage_row[3];

echo "
<i class='fa fa-close' id='close-plans'></i>
    <div class='snip1265'>
<form method='post' action='checkout.php'>

    <header class='text-center h2'>Pricing plans</header>
      <div class='plan'>
        <header><i class='ion-ios-navigate-outline'></i>
          <h4 class='plan-title'>
            Starter
          </h4>
          <div class='plan-cost'><span class='plan-price'>&#8377;{$monthly[2]}</span><span class='plan-type'>/month</span></div>
        </header>
        <ul class='plan-features'>
          <li>5GB Linux Web Space
          </li>
          <li>5 MySQL Databases
          </li>
          <li>Unlimited Email
          </li>
          <li>250Gb mo Transfer
          </li>
          <li>24/7 Tech Support
          </li>
          <li>Daily Backups
          </li>
        </ul>
        <div class='plan-select'><button readonly name='package' value='1'>Select Plan</button></div>
      </div>
      <div class='plan'>
        <header><i class='ion-ios-world'></i>
          <h4 class='plan-title'>
            Basic
          </h4>
          <div class='plan-cost'><span class='plan-price'>&#8377;{$quartely[2]}</span><span class='plan-type'>/3 month</span></div>
        </header>
        <ul class='plan-features'>
          <li>10GB Linux Web Space
          </li>
          <li>10 MySQL Databases
          </li>
          <li>Unlimited Email
          </li>
          <li>500Gb mo Transfer
          </li>
          <li>24/7 Tech Support
          </li>
          <li>Daily Backups
          </li>
        </ul>
        <div class='plan-select'><button readonly name='package' value='2'>Select Plan</button></div>
      </div>
      <div class='plan'>
        <header><i class='ion-ios-people'></i>
          <h4 class='plan-title'>
            Pro
          </h4>
          <div class='plan-cost'><span class='plan-price'>&#8377;{$half_yearly[2]}</span><span class='plan-type'>/6 month</span></div>
        </header>
        <ul class='plan-features'>
          <li>25GB Linux Web Space
          </li>
          <li>25 MySQL Databases
          </li>
          <li>Unlimited Email
          </li>
          <li>2000Gb mo Transfer
          </li>
          <li>24/7 Tech Support
          </li>
          <li>Daily Backups
          </li>
        </ul>
        <div class='plan-select'><button readonly name='package' value='3'>Select Plan</button></div>
      </div>
      <div class='plan'>
        <header><i class='ion-ios-speedometer'></i>
          <h4 class='plan-title'>
            Ultra
          </h4>
          <div class='plan-cost'><span class='plan-price'>&#8377;{$annually[2]}</span><span class='plan-type'>/year</span></div>
        </header>
        <ul class='plan-features'>
          <li>100GB Linux Web Space
          </li>
          <li>Unlimited MySQL Databases
          </li>
          <li>Unlimited Email
          </li>
          <li>10000Gb mo Transfer
          </li>
          <li>24/7 Tech Support
          </li>
          <li>Daily Backups
          </li>
        </ul>
        <div class='plan-select'><button readonly name='package' value='4'>Select Plan</button></div>
      </div>
</form>

    </div>
<div id='skip-plan'>Skip</div>
";
