<!DOCTYPE html>
<html>
    <title><?=WEBSITE_NAME?></title>
    <body>

    <button id="rzp-button1" style="display:none;">Pay with Razorpay</button>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>

    <form name='razorpayform' action="<?=base_url()?>Welcome/checkout_success/<?=$hash?>" method="POST">
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >	
    </form>

    <script>
    var options = <?php echo json_encode($data);?>;
    options.handler = function (response){ 
        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        document.getElementById('razorpay_signature').value = response.razorpay_signature;
        document.razorpayform.submit();
    };

    options.modal = {
        ondismiss: function() {
            console.log("This code runs when the popup is closed");
            location.replace("<?=base_url()?>");
        },
        escape: true,
        backdropclose: false
        
    };

    var rzp = new Razorpay(options);
    $(document).ready(function(){
        $("#rzp-button1").click();
        rzp.open();
        e.preventDefault();
    });
    </script>

    </body>
</html>