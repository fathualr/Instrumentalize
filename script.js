function show_password(inputId) {
    var passwordInput = document.getElementById(inputId);
    var icon = document.getElementById('show_' + inputId);

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}



document.addEventListener("DOMContentLoaded", function () {
    // Temukan elemen-elemen yang dibutuhkan untuk setiap modal
    var modals = document.querySelectorAll('.product-modal');

    modals.forEach(function (modal) {
        var quantityInput = modal.querySelector("#product_quantity");
        var tambahButton = modal.querySelector("#tambah");
        var kurangButton = modal.querySelector("#kurang");

        tambahButton.addEventListener("click", function () {
            incrementQuantity(quantityInput);
        });

        kurangButton.addEventListener("click", function () {
            decrementQuantity(quantityInput);
        });

        modal.addEventListener('hidden.bs.modal', function () {
            resetQuantity(quantityInput);
        });
    });
});

function incrementQuantity(inputElement) {
    var currentValue = parseInt(inputElement.value, 10);
    var maxValue = parseInt(inputElement.getAttribute("max"), 10);

    if (!isNaN(currentValue) && currentValue < maxValue) {
        inputElement.value = currentValue + 1;
    }
}

function decrementQuantity(inputElement) {
    var currentValue = parseInt(inputElement.value, 10);
    var minValue = parseInt(inputElement.getAttribute("min"), 10);

    if (!isNaN(currentValue) && currentValue > minValue) {
        inputElement.value = currentValue - 1;
    }
}

function resetQuantity(inputElement) {
    // Reset nilai input ke nilai awal (misalnya, 1)
    inputElement.value = inputElement.getAttribute("min") || 1;
}



document.addEventListener("DOMContentLoaded", function () {
    var checkboxDelete = document.getElementById("checkbox_delete");
    var productCheckboxes = document.querySelectorAll('[id^="checkbox"]');
    var deleteSelectedButton = document.getElementById("delete_selected_button");

    checkboxDelete.addEventListener("change", function () {
        productCheckboxes.forEach(function (checkbox) {
            checkbox.checked = checkboxDelete.checked;
        });
    });

    deleteSelectedButton.addEventListener("click", function () {
        var selectedProducts = [];
        productCheckboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                selectedProducts.push(checkbox.value);
            }
        });

         // Periksa apakah ada produk yang dipilih sebelum mengarahkan pengguna
        if (selectedProducts.length > 0) {
            // Bangun URL dengan ID keranjang yang dipilih
            var deleteURL = "delete-data.php?cart_ids=" + selectedProducts.join(",");
            
            // Alihkan ke URL penghapusan
            window.location.href = deleteURL;
        } else {
            // Tampilkan pesan atau ambil tindakan lain jika tidak ada yang dipilih
            alert("Pilih setidaknya satu produk untuk dihapus.");
        }
    });
});



document.addEventListener('DOMContentLoaded', function () {
    // Mendapatkan elemen-elemen yang diperlukan
    var transferRadio = document.getElementById('payment-transfer');
    var codRadio = document.getElementById('payment-cod');
    var shippingCostElement = document.getElementById('shipping-cost');
    var shippingTotalInput = document.getElementById('shipping_total');
    var priceTotalInput = document.getElementById('price_total');
    var totalCostElement = document.getElementById('total-cost');
    var orderTotalInput = document.getElementById('order_total');

    // Function untuk memperbarui biaya pengiriman berdasarkan metode pembayaran yang dipilih
    function updateShippingCost(cost) {
        shippingCostElement.textContent = 'Rp. ' + cost.toLocaleString('id-ID');
        shippingTotalInput.value = cost;
        updateOrderTotal();
    }

    // Function untuk memperbarui total pembayaran
    function updateOrderTotal() {
        var priceTotal = parseFloat(priceTotalInput.value.replace(/\D/g, '')) || 0; // Remove non-numeric characters
        var shippingTotal = parseFloat(shippingTotalInput.value.replace(/\D/g, '')) || 0; // Remove non-numeric characters
        var orderTotal = priceTotal + shippingTotal;

        // Update total pembayaran di dalam elemen dan input yang sesuai
        totalCostElement.textContent = 'Rp. ' + orderTotal.toLocaleString('id-ID');
        orderTotalInput.value = orderTotal;
    }

    // Mendengarkan perubahan pada radio button transfer
    transferRadio.addEventListener('change', function () {
        if (transferRadio.checked) {
            updateShippingCost(500000); // Biaya pengiriman untuk transfer: Rp. 500.000
        }
    });

    // Mendengarkan perubahan pada radio button cod
    codRadio.addEventListener('change', function () {
        if (codRadio.checked) {
            updateShippingCost(1000000); // Biaya pengiriman untuk COD: Rp. 1.000.000
        }
    });

    // Mendengarkan perubahan pada input price_total
    priceTotalInput.addEventListener('input', updateOrderTotal);
});



document.addEventListener('DOMContentLoaded', function () {
    setupLiveSearch('inputSearchUser', 'boxTableUser', 'ajax/livesearch-user.php');
    setupLiveSearch('inputSearchProduct', 'boxTableProduct', 'ajax/livesearch-product.php');
    setupLiveSearch('inputSearchOrders', 'boxTableOrders', 'ajax/livesearch-orders.php');

    // Function untuk live search
    function performLiveSearch(inputId, resultBoxId, sourceUrl) {
        var inputElement = document.getElementById(inputId);
        var resultContainer = document.getElementById(resultBoxId);

        if (inputElement && resultContainer) {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        resultContainer.innerHTML = xhr.responseText;
                    } else {
                        console.error('Error: ' + xhr.status);
                    }
                }
            }

            xhr.open('GET', sourceUrl + '?' + inputId + '=' + encodeURIComponent(inputElement.value), true);
            xhr.send();
        }
    }

    // Function untuk setup live search di setiap halaman
    function setupLiveSearch(inputId, resultBoxId, sourceUrl) {
        var inputSearch = document.getElementById(inputId);

        if (inputSearch) {
            inputSearch.addEventListener('keyup', function () {
                performLiveSearch(inputId, resultBoxId, sourceUrl);
            });
        }
    }

    // Tambahan function atau event listener bisa ditambahkan di sini
    // ...
});