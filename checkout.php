<?php include_once "includes/header.php"; ?>

<?php

$MERCHANT_KEY = "---Check the merchant key---";
$SALT = "---Check the salt---";
    // Merchant Key and Salt as provided by Payu.
    $PAYU_BASE_URL = "https://sandboxsecure.payu.in";		// For Sandbox Mode
    // $PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode
    $action = '';
    $posted = array();
    if(!empty($_POST)) {
        //print_r($_POST);
    foreach($_POST as $key => $value) {     
        $posted[$key] = $value; 
    }
    }
    if(empty($posted['txnid'])) {
        // Generate random transaction id
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
      } else {
        $txnid = $posted['txnid'];
      }
    $formError = 0;

    $hash = '';
    // Hash Sequence
    $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
    if(empty($posted['hash']) && sizeof($posted) > 0) {
    if(
            empty($posted['key'])
            || empty($posted['txnid'])
            || empty($posted['amount'])
            || empty($posted['firstname'])
            || empty($posted['email'])
            || empty($posted['phone'])
            || empty($posted['productinfo'])
            || empty($posted['surl'])
            || empty($posted['furl'])
            || empty($posted['service_provider'])
    ) {
        $formError = 1;
    } else {
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';	
        foreach($hashVarsSeq as $hash_var) {
        $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
        $hash_string .= '|';
        }

        $hash_string .= $SALT;


        $hash = strtolower(hash('sha512', $hash_string));
        $action = $PAYU_BASE_URL . '/_payment';
    }
    } else if(!empty($posted['hash'])) {
    $hash = $posted['hash'];
    $action = $PAYU_BASE_URL . '/_payment';
    }

?>

<script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
    if(hash == '') {
        return;
    }
    var payuForm = document.forms.payuForm;
    payuForm.submit();
    }
</script>
</head>
    <body onload="submitPayuForm()">
    <div class="full-size" >

    <?php
    if(!(isset($_SESSION['user_id']))){
        header("Location: signin.php");
    }else if(!isset($_POST['package'])){
        header("Location: index.php");
    }else{
        include "includes/nav.php";
        $user_id = $_SESSION['user_id'];
        include 'Classes/Payment.php';
        $Payment = new Payment($connection);
        $total_to_be_paid = 0;
        $package_plan = '';
        $package_days = '';
        $package_id = $_POST['package'];
        if($package_id == 1){
            $total_to_be_paid = $Payment->getPackageById('price',$package_id);
            $package_plan = "Starter pack";
            $package_days = "1 month";
        }else if($package_id == 2){
            $total_to_be_paid = $Payment->getPackageById('price',$package_id);
            $package_plan = "Basic pack";
            $package_days = "3 month";
        }else if($package_id == 3){
            $total_to_be_paid = $Payment->getPackageById('price',$package_id);
            $package_plan = "Professional pack";
            $package_days = "6 month";
        }else if($package_id == 4){
            $total_to_be_paid = $Payment->getPackageById('price',$package_id);
            $package_plan = "Ultra pack";
            $package_days = "1 year";
        }
    }
    ?>
    <div class="d-flex flex-column align-items-center">
        <div class="card p-3 my-3">
            <div><div class='badge badge-dark'>Name:</div><?php echo "&nbsp;&nbsp;".$username; ?></div>
            <div><div class='badge badge-dark'>Email:</div><?php echo "&nbsp;&nbsp;".$User->get_user_detail_by_id('email',$user_id); ?></div>
            <div><div class='badge badge-dark'>Plan:</div><?php echo "&nbsp;&nbsp;".$package_plan; ?></div>
            <div><div class='badge badge-dark'>Plan duration:</div><?php echo "&nbsp;&nbsp;".$package_days; ?></div>
            <div><div class='badge badge-dark'>Amount to pay:</div><?php echo "&nbsp;&nbsp;&#8377;".$total_to_be_paid; ?></div>
        </div>
        <form action="javascript:check();" method="post" id='frm' name="payuForm">
            <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
            <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
            <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
            <input type="hidden" name="user_id" id='user_id' value="<?php echo $user_id; ?>" />
                <input name="amount" type='hidden' id='amount' readonly value='<?php echo $total_to_be_paid; ?>' />
                <input name="firstname" type="hidden"id="firstname" value="<?php echo $User->get_user_detail_by_id('username',$user_id); ?>" />
                <input name="email" type="hidden" id="email" value="<?php echo $User->get_user_detail_by_id('email',$user_id); ?>" />
                <input name="phone" type="hidden" id='phone' value="<?php echo $User->get_user_detail_by_id('mobile_number',$user_id); ?>"  />
                <input name="productinfo" type="hidden" id='productinfo' value="<?php echo $user_id."*".$package_id;?>"  />
                <input type='hidden' name="surl" value="http://localhost/php/vodi-internship/includes/success.php" size="64" />
                <input type='hidden' name="furl" value="http://localhost/php/vodi-internship/includes/failure.php" size="64" />
                <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
                    <?php if(!$hash) { ?>
                        <input type="submit" class="btn btn-warning" value="Pay now" />
                    <?php } ?>
        </form>
    </div>

</div>


<script>
    function check(){
        var f = document.getElementById("frm");
        f.setAttribute('method',"post");
        f.setAttribute('action',"card-checkout.php");
        f.submit();
    }

</script>

</body>
</html>