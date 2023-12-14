const _detail = document.querySelector.bind(document);
const _details = document.querySelectorAll.bind(document);

const detail = {
  handleChangeImg() {
    const imagesBox = _details(".main__show-control-box");
    const showMainImage = _detail(".main__show-img");
    imagesBox.forEach((imgBox) => {
      imgBox.onclick = function () {
        _detail(".main__show-control-box.active").classList.remove("active");
        this.classList.add("active");
        const pathImg = this.children[0].attributes.src.nodeValue;
        showMainImage.attributes.style.nodeValue = `background-image: url(${pathImg})`;
      };
    });
  },

  // handle change size
  handleChangeSize() {
    const sizes = _details(".main__information-size-box");
    const errorMassage = _detail(".main__information-size");
    const errorText = errorMassage.querySelector(
      ".main__information-size-error-text"
    );

    sizes.forEach((size) => {
      size.onclick = function () {
        let actives = _details(".main__information-size-box.active");
        if (actives.length > 0) {
          actives[0].className = actives[0].className.replace(" active", "");
          actives[0].removeAttribute("name");
        }
        this.setAttribute("name", "size-value");
        this.className += " active";
        errorMassage.classList.remove("error");
        errorText.innerText = "";
      };
    });
  },

  // format money
  formatMoneyVND(str) {
    const toStringStr = str.toString();
    return toStringStr
      .split("")
      .reverse()
      .reduce((prev, next, index) => {
        return (index % 3 ? next : next + ".") + prev;
      });
  },

  handleChangeCount() {
    const _this = this;
    const btnIncrease = _detail(".main__information-amount-quantity-increase");
    const btnDecrease = _detail(".main__information-amount-quantity-decrease");
    const inputAmount = _detail(".main__information-amount-quantity-input");
    const priceProduct = _detail(".main__information-current-price");
    priceProduct.textContent =
      this.formatMoneyVND(
        Number.parseInt(priceProduct.attributes.value.nodeValue)
      ) + "đ";
    const defaultPrice = _detail(".price__store");

    function defaultAttributeValuePrice() {
      priceProduct.setAttribute("value", Number(defaultPrice.textContent));
    }
    defaultAttributeValuePrice();

    btnIncrease.onclick = () => {
      if (inputAmount.value >= 100) {
        inputAmount.value = 100;
        inputAmount.attributes.value.nodeValue = 100;
      } else {
        inputAmount.value = Number(inputAmount.value) + 1;
        inputAmount.attributes.value.nodeValue = inputAmount.value;
        const total =
          Number(defaultPrice.textContent) *
          inputAmount.attributes.value.nodeValue;
        priceProduct.setAttribute("value", total);
        priceProduct.textContent = _this.formatMoneyVND(total) + "đ";
      }
    };

    btnDecrease.onclick = () => {
      if (inputAmount.value > 1) {
        inputAmount.attributes.value.nodeValue = inputAmount.value;
        const total =
          Number(priceProduct.textContent) - Number(defaultPrice.textContent);
        priceProduct.setAttribute("value", total);
        priceProduct.textContent = _this.formatMoneyVND(total) + "đ";
        inputAmount.value = Number(inputAmount.value) - 1;
      } else {
        inputAmount.value = 1;
        inputAmount.attributes.value.nodeValue = 1;
      }
    };
  },

  handleSubmit() {
    const btnAddCart = _detail("#add-cart");
    const btnBuyNow = _detail("#buy-now");
    const boxSizes = _details(".main__information-size-box");
    const errorMassage = _detail(".main__information-size");
    const errorText = errorMassage.querySelector(
      ".main__information-size-error-text"
    );
    const formAction = _detail("#form-action-detail");

    btnAddCart.onclick = (e) => {
      let sizeID = "";
      const isSuccess = Array.from(boxSizes).some((box) => {
        if (box.className !== "main__information-size-box active") {
          errorMassage.classList.add("error");
          errorText.innerText = "Vui lòng chọn một size giày cụ thể";
        } else {
          errorMassage.classList.remove("error");
          errorText.innerText = "";
          sizeID = box.children[0].textContent;
        }

        return box.className === "main__information-size-box active";
      });
      function pathSubmit() {
        formAction.setAttribute("action", "./cart.php");
        e.submit;

        // start save localStorage
        const amountInput = _detail(".main__information-amount-quantity-input");
        const idProduct = _detail("#id-product");
        const imgProduct = _detail("#img-root");
        const nameProduct = _detail(".main__information-title");
        const priceProduct = _detail(".main__information-current-price");
        const defaultPrice = _detail(".main-information-price-default");
        const oldPriceProduct = _detail(".main__information-old-price");
        const salesProduct = _detail(".main__information-sale-number");
        console.log(
          oldPriceProduct.attributes.value.nodeValue,
          salesProduct.innerText
        );

        if (sizeID) {
          const getStorage =
            JSON.parse(localStorage.getItem("valueFromDetail")) ?? [];

          if (getStorage.length > 0) {
            const value = getStorage.some((store) => {
              return store.idProd === idProduct.textContent;
            });

            if (value) {
              getStorage.forEach((store, index) => {
                if (store.idProd === idProduct.textContent) {
                  getStorage.splice(index, 1, {
                    idProd: idProduct.textContent,
                    size: sizeID,
                    amount: amountInput.value,
                    nameProd: nameProduct.textContent,
                    priceProd: priceProduct.attributes.value.nodeValue,
                    defaultPrice: Number(defaultPrice.textContent),
                    imgProd: imgProduct.attributes.src.nodeValue,
                    oldPriceProduct: oldPriceProduct.attributes.value.nodeValue,
                    salesProduct: salesProduct.innerText,
                  });
                  const jsonArrayFrom = JSON.stringify(getStorage);
                  localStorage.setItem("valueFromDetail", jsonArrayFrom);
                }
              });
            } else {
              getStorage.unshift({
                idProd: idProduct.textContent,
                size: sizeID,
                amount: amountInput.value,
                nameProd: nameProduct.textContent,
                priceProd: priceProduct.attributes.value.nodeValue,
                defaultPrice: Number(defaultPrice.textContent),
                imgProd: imgProduct.attributes.src.nodeValue,
                oldPriceProduct: oldPriceProduct.attributes.value.nodeValue,
                salesProduct: salesProduct.innerText,
              });
              const jsonArrayFrom = JSON.stringify(getStorage);
              localStorage.setItem("valueFromDetail", jsonArrayFrom);
            }
          } else {
            getStorage.unshift({
              idProd: idProduct.textContent,
              size: sizeID,
              amount: amountInput.value,
              nameProd: nameProduct.textContent,
              priceProd: priceProduct.attributes.value.nodeValue,
              defaultPrice: Number(defaultPrice.textContent),
              imgProd: imgProduct.attributes.src.nodeValue,
              oldPriceProduct: oldPriceProduct.attributes.value.nodeValue,
              salesProduct: salesProduct.innerText,
            });
            const jsonArrayFrom = JSON.stringify(getStorage);
            localStorage.setItem("valueFromDetail", jsonArrayFrom);
          }
        } else {
          throw new Error("no value of size product");
        }

        // end save localStorage
      }

      isSuccess ? pathSubmit() : e.preventDefault();
    };

    btnBuyNow.onclick = (e) => {
      const isSuccess = Array.from(boxSizes).some((box) => {
        if (box.className !== "main__information-size-box active") {
          errorMassage.classList.add("error");
          errorText.innerText = "Vui lòng chọn một size giày cụ thể";
        } else {
          errorMassage.classList.remove("error");
          errorText.innerText = "";
        }

        return box.className === "main__information-size-box active";
      });

      function pathSubmit() {
        e.preventDefault();
        const idProduct = _detail("#id-product");
        const nameProduct = _detail(".main__information-title");
        const priceProduct = _detail(".main__information-current-price");
        const defaultPrice = _detail(".price__store");
        const amountProduct = _detail(
          ".main__information-amount-quantity-input"
        );
        const sizeProduct = _detail(".main__information-size-box.active");
        const imgProduct = _detail("#img-root");

        const storageDataFormCart =
          JSON.parse(localStorage.getItem("dataFromCart")) ?? [];
        function pathSubmit(data) {
          let flagIndex;
          const responses = data.some((response, index) => {
            flagIndex = index;
            return idProduct.textContent === response.idProduct;
          });

          console.log(responses);

          if (responses) {
            storageDataFormCart.forEach((currentData, index) => {
              if (currentData.idProduct === idProduct.innerText) {
                data.splice(flagIndex, 1, {
                  idProduct: idProduct.innerText,
                  nameProduct: nameProduct.innerText,
                  sizeProduct: sizeProduct.innerText,
                  amountProduct: amountProduct.attributes.value.nodeValue,
                  priceProduct: Number.parseInt(
                    priceProduct.attributes.value.nodeValue
                  ),
                  imgProduct: imgProduct.attributes.src.nodeValue,
                  priceDefault: Number.parseInt(defaultPrice.innerText),
                });
                const dataStringify = JSON.stringify(data);
                localStorage.setItem("dataFormCart", dataStringify);
              } else {
                data.unshift({
                  idProduct: idProduct.innerText,
                  nameProduct: nameProduct.innerText,
                  sizeProduct: sizeProduct.innerText,
                  amountProduct: amountProduct.attributes.value.nodeValue,
                  priceProduct: Number.parseInt(
                    priceProduct.attributes.value.nodeValue
                  ),
                  imgProduct: imgProduct.attributes.src.nodeValue,
                  priceDefault: Number.parseInt(defaultPrice.innerText),
                });
                const dataStringify = JSON.stringify(data);
                localStorage.setItem("dataFormCart", dataStringify);
              }
            });
          } else {
            data.unshift({
              idProduct: idProduct.innerText,
              nameProduct: nameProduct.innerText,
              sizeProduct: sizeProduct.innerText,
              amountProduct: amountProduct.attributes.value.nodeValue,
              priceProduct: Number.parseInt(
                priceProduct.attributes.value.nodeValue
              ),
              imgProduct: imgProduct.attributes.src.nodeValue,
              priceDefault: Number.parseInt(defaultPrice.innerText),
            });
            const dataStringify = JSON.stringify(data);
            localStorage.setItem("dataFromCart", dataStringify);
          }

          window.location.href = "./checkout.php";
        }
        pathSubmit(storageDataFormCart);
      }

      isSuccess ? pathSubmit() : e.preventDefault();
    };
  },

  // mai code phần cart;
};

detail.handleChangeImg();
detail.handleChangeSize();
detail.handleSubmit();
detail.handleChangeCount();
