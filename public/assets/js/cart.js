window.addEventListener('load', () => {
    cart.init();
});

const cart = {
    init: () => {
        let btnColor = document.querySelectorAll('.btn-color');
        btnColor.forEach((elem) => {
            
            elem.addEventListener('click', () => {
                btnColor.forEach((elem2) => {
                    elem2.classList.add('btn-success');
                });

                if (elem.classList.contains('btn-success'))
                {
                    elem.classList.remove('btn-success');
                    elem.classList.add('btn-secondary');
                }

                console.log(elem.innerHTML);
                document.querySelector('[name="product-color"]').value = elem.innerHTML;
            });
        });

        let btnQuantityPlus = document.querySelector('#btn-plus');
        btnQuantityPlus.addEventListener('click', () => {
            setTimeout(() => { cart.calculateTotalPrice() }, 100);
        });

        let btnQuantityMinus = document.querySelector('#btn-minus');
        btnQuantityMinus.addEventListener('click', () => {
            setTimeout(() => { cart.calculateTotalPrice() }, 100);
        });
    },
    calculateTotalPrice: () => {
        let quantity = document.querySelector('#product-quanity').value;
        let defaultPrice = document.querySelector('[name="default-price"]').value;
        let totalPrice = defaultPrice * quantity

        document.querySelector('.price').innerHTML = cart.separator( totalPrice.toFixed(2) )
        document.querySelector('[name="total-price"]').value = totalPrice.toFixed(2);

        return totalPrice.toFixed(2);
    },
    separator: (numb) => {
        var str = numb.toString().split(".");
        str[0] = str[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return str.join(".");
    }
}