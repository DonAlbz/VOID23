AOS.init({
    duration: 900,
    once: true,
    easing: "ease-out-cubic"
});
document.addEventListener("click", function (event) {
    if (event.target.classList.contains("plus")) {
        const control = event.target.closest(".quantity-control");
        const input = control.querySelector(".cart-quantity-input");

        input.value = parseInt(input.value) + 1;
    }

    if (event.target.classList.contains("minus")) {
        const control = event.target.closest(".quantity-control");
        const input = control.querySelector(".cart-quantity-input");

        let value = parseInt(input.value);

        if (value > 1) {
            input.value = value - 1;
        }
    }
});