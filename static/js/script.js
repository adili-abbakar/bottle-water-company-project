let tableRow = document.querySelectorAll(".sale-table tr");

tableRow.forEach((row) => {
  row.addEventListener("click", function () {
    let saleId = row.getAttribute("data-id");
    let url = "includes/sessions.php?id=" + saleId;

    window.location.href = url;
  });
});

function addProduct() {
  let formCtn = document.querySelector(".new-sale-form-products-ctn");
  let formFields = document.querySelector(".new-sale-form-products-fields").cloneNode(true);
  formCtn.appendChild(formFields);
}
