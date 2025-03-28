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
                            $('#c_number').val(customerPhone);
                            $('#addCustomerModal').modal('show');
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

    $(document).on('click','.saveCustomer', function()
    {
        var c_name = $('#c_name').val();
        var c_phone = $('#c_number').val();
        var c_email = $('#c_email').val();

        console.log(c_name, c_email, c_phone);

        if (c_name != '' && c_phone != '')
        {
            if($.isNumeric(c_phone))
                {
                    var data = {
                        'saveCustomerBtn':true,
                        'name': c_name,
                        'phone':c_phone,
                        'email':c_email
                    };

                    $.ajax({
                        type: "POST",
                        url: "order-code.php",
                        data: data,
                        success: function(response)
                        {
                            var res = JSON.parse(response);

                            if(res.status == 200)
                            {
                               swal(res.message, res.message,res.status_type);
                               $('#addCustomerModal').modal('hide');

                            }
                            else if(res.status == 500)
                            {
                                swal(res.message, res.message,res.status_type);
                            }
                            else
                            {
                                swal(res.message, res.message, res.status_type);
                                
                            }
                        }

                    });
                }
            else
            {
                swal("Please Enter a valid Phone number", "Warning");
            }
        }
        else
        {
            swal("Please fill required fields", "Warning");
        }
    })


    $(document).on('click', '#saveOrder', function()
    {
            $.ajax({
                type: "POST",
                url: "order-code.php",
                data:{
                    'saveOrder': true
                },
                success:function(response)
                {
                    var res = JSON.parse(response);

                    if(res.status == 200)
                        {
                           swal(res.message, res.message,res.status_type);
                           $('#orderPlaceSuccessMessage').text(res.message);
                           $('#orderSuccessModal').modal('show');
                        }
                        else if(res.status == 500)
                        {
                            swal(res.message, res.message,res.status_type);
                        }
                        else
                        {
                            swal(res.message, res.message, res.status_type);
                            
                        }
                }
            });
        }
    );

})