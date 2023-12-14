const _document = document.querySelector.bind(document);
const _documents = document.querySelectorAll.bind(document);

const index = {
    // format money
    formatMoneyVND(str) {
        const toStringStr = str.toString();
        return toStringStr.split('').reverse().reduce((prev, next, index) => {
            return ((index % 3) ? next : (next + '.')) + prev
        })
    },

    handleFormatPrice() {
        const priceElements = _documents('.main__product-box-current-price');
        Array.from(priceElements).forEach(price => {
            price.textContent = this.formatMoneyVND(price.textContent) + 'đ';
        })
    }
}

index.handleFormatPrice()