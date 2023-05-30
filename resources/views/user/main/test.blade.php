
//from home
<script>
$(document).ready(function(){
    // $.ajax({
    //     type : 'get',
    //     url : "http://localhost:8000/user/ajax/pizza/list",
    //     dataType : 'json',
    //     success : function(response){
    //         console.log(response)
    //     }
    // })

        $('#sortingOption').change(function(){
            $eventOption = $('#sortingOption').val();
            console.log($eventOption);

            if($eventOption == 'asc'){
                $.ajax({
                        type : 'get',
                        url : "/user/ajax/pizza/list",
                        data : {'status': 'asc',
                                'message' : 'this is testing message'
                    },
                        dataType : 'json',
                        success : function(response){
                            $list = '';
                            for ($i = 0; $i <response.length;$i++){
                              $list +=  `
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1" >
                            <div class="product-item bg-light mb-4 "id="myForm">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" style = 'height: 210px;' src="{{asset('storage/${response[$i].image}' )}}" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5${response[$i].price}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                            `;
                            console.log($list);
                            }
                            $('#dataList').html($list);
                        }
                    })
            }else if ($eventOption == 'desc'){
                $.ajax({
                            type : 'get',
                            url : "/user/ajax/pizza/list",
                            data : {'status': 'desc'},
                            dataType : 'json',
                            success : function(response){
                                $list = '';
                            for ($i = 0; $i <response.length;$i++){
                              $list +=  `
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1" >
                            <div class="product-item bg-light mb-4 "id="myForm">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" style = 'height: 210px;' src="{{asset('storage/${response[$i].image}' )}}" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5${response[$i].price}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                            `;
                            console.log($list);
                            }
                            $('#dataList').html($list);
                        }
                    })
                }
            })
        });
</script>




//cart.js
$(document).ready(function(){
    $('.btn-plus').click(function(){
        $parentNode = $(this).parents('tr');
        $price = Number($parentNode.find('#price').text());
        $qty = Number($parentNode.find('#qty').val());

        $total = $price * $qty;
        $parentNode.find("#total").html(`${$total} Kyats`)

        summaryCalculation ();

    })

    $('.btn-minus').click(function(){
        $parentNode = $(this).parents('tr');
        $price = Number($parentNode.find('#price').text());
        $qty = Number($parentNode.find('#qty').val());

        $total = $price * $qty;
        $parentNode.find("#total").html(`${$total} Kyats`)
        summaryCalculation ();

    })

    $('.btnRemove').click(function(){
        $parentNode= $(this).parents('tr');
        $parentNode.remove();

        countCalculation();
        summaryCalculation ();
    })
    function countCalculation(){
        $parentNode = $(this).parents('tr');
        $price = Number($parentNode.find('#price').text());
        $qty = Number($parentNode.find('#qty').val());

        $total = $price * $qty;
        $parentNode.find("#total").html(`${$total} Kyats`)
    }

    function summaryCalculation (){

        $totalPrice = 0
         $('#dataTable tbody tr').each(function(index,row){
         $totalPrice += Number ($(row).find('#total').text().replace('Kyats',''))

        });
        $('#subTotalPrice').html(`${$totalPrice} kyats`)
        $('#finalPrice').html(`${$totalPrice + 3000} kyats`)

    }
})
