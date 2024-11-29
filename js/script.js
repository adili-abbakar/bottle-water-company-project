



let tableRow = document.querySelectorAll('.sale-table tr');


tableRow.forEach((row) => {
    row.addEventListener('click', function () {
        let saleId = row.getAttribute('data-id');
        let url = "includes/sessions.php?id=" + saleId;

        window.location.href = url;
    });
});