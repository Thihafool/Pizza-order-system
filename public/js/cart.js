$(document).ready(function() {
    $('.btn-plus').click(function() {
        $parentNode = $(this).parents('tr');
        $price = Number($parentNode.find('#price').html().replace('Kyats', ''));
        $qty = $parentNode.find('#qty').val();
        $total = $price * $qty;

        $parentNode.find('#total').html($total + 'Kyats')

        summaryCalculation()

    })


    $('.btn-minus').click(function() {
        $parentNode = $(this).parents('tr');
        $price = Number($parentNode.find('#price').html().replace('Kyats', ''));
        $qty = $parentNode.find('#qty').val();
        $total = $price * $qty;

        $parentNode.find('#total').html($total + 'Kyats')

        summaryCalculation()

    })

    function summaryCalculation() {
        $totalPrice = 0;
        $('#dataTable tr').each(function(index, row) {
            $totalPrice += Number($(row).find('#total').text().replace('Kyats', ''));
        })
        $('#subTotalPrice').html(`${$totalPrice} Kyats`);
        $('#finalPrice').html(`${$totalPrice + 3000} Kyats`);
    }

})