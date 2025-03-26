$(document).ready(function()
{
    alertify.set('notifier','position', 'top-right');

    $(document).on("click", '.increment', function(){
        var $quantityInput = $(this).closest('.qtyBox').find('.qty');
        var productId = $(this).closest('.qtyBox').find('.prodId').val();

        var currentValue = parseInt($quantityInput.val());

        if(!isNaN(currentValue))
        {
            var qtyVal = currentValue + 1;
            $quantityInput.val(qtyVal);
            quantityIncDec(productId, qtyVal);
        }

    })


    $(document).on("click", '.decrement', function(){


        var $quantityInput = $(this).closest('.qtyBox').find('.qty');
        var productId = $(this).closest('.qtyBox').find('.prodId').val();

        var currentValue = parseInt($quantityInput.val());

        if(!isNaN(currentValue) && currentValue > 1)
        {
            var qtyVal = currentValue - 1
            $quantityInput.val(qtyVal);
            quantityIncDec(productId, qtyVal);
        }

    })

    
    function quantityIncDec($prodId, $qty){

        $.ajax({
            type: "POST",
            url: "order-code.php",
            data: {
                'productIncDec': true,
                'product_id':$prodId,
                'quantity': $qty
            },
            success: function (response){
                console.log(response);

                var res = JSON.parse(response);

                if(res.status == 200)
                {
                    // window.location.reload();
                    $('#productArea').load(' #productContent')
                    alertify.success(res.message);
                }
                else
                {
                    alaertify.error('res.message');
                    
                }
            }

        })
    }


    $(document).on('click','.proceedToPlaceOrder', function()
    {
        var paymentMode = $('#payment').val();
        var customerPhone = $('#number').val();


        if(paymentMode == " ")
        {
            swal("Select Payment Mode", "Warning");

            return false;
        }

        if(customerPhone == "" || !$.isNumeric(customerPhone))
        {
            swal("Enter customer's phone number","Enter valid number", "Warning");

            return false;
        }

        var data ={
            'proceedToPlaceOrderBtn': true,
            'cphone':customerPhone,
            'payment_mode': paymentMode,
        }

        $.ajax({
            type: "POST",
            url: "order-code.php",
            data: data,
            success: function (response) {

                console.log(response);

                var res = JSON.parse(response);

                if(res.status == 200)
                {
                    window.location.href = "order-summary.php";
                }

                else if(res.status == 404)
                {
                    swal("404", res.message, res.status_type,{

                        buttons:{
                            catch:{
                                text:"Add customer",
                                value: "catch"
                            },
                            cancel: "Cancel"
                        }

                        
                    })

                    .then((value) => {
                        switch(value){

                           case "catch":
                              console.log('Pop the customer add model');
                              break;
                              
                           default:
                        }
                    })
                    
                }
                else
                {
                    swal(res.status, res.message, res.status_type);
                }
            }

        })


    })

})