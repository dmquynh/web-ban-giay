function checkBox() {
  var checkboxes = document.querySelectorAll(
    'input[name="selected_products[]"]:checked'
  );
  var selectedProductIds = Array.from(checkboxes).map(function (checkbox) {
    return checkbox.value;
  });

  if (selectedProductIds.length > 0) {
    var url = "index.php?act=checkout&idpro=" + selectedProductIds.join(",");
    window.location.href = url;
  } else {
    Swal.fire({
      title: "Thông báo",
      text: "Bạn vẫn chưa chọn sản phẩm nào để mua.",
      icon: "error",
      confirmButtonText: "OK",
    });
  }
}

function decrease(id) {
  var quantityField = document.getElementById("quantity_" + id);
  var currentValue = parseInt(quantityField.value);
  if (!isNaN(currentValue) && currentValue > 1) {
    quantityField.value = currentValue - 1;
  }
}

function increase(id) {
  var quantityField = document.getElementById("quantity_" + id);
  var currentValue = parseInt(quantityField.value);
  if (!isNaN(currentValue)) {
    quantityField.value = currentValue + 1;
  }
}

document.getElementById("checkall1").addEventListener("change", function () {
  var checkboxes = document.getElementsByClassName("product-checkbox");
  // console.log(checkboxes);
  for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = this.checked;
  }
});

var clicksizes = document.querySelectorAll(".clicksize");

clicksizes.forEach(function (e) {
  e.addEventListener("click", function () {
    var formsize = this.nextElementSibling;

    if (formsize.style.display === "none") {
      formsize.style.display = "block";
    } else {
      // duyệt qua các form-size khi click vào form-size khác thì cho nó ẩn đi
      document.querySelectorAll(".form-size").forEach(function (forms) {
        forms.style.display = "none";
      });
      // formsize.style.display = "block";
    }
  });
});
