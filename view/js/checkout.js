const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const checkout = {
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

  handleRenderProduct() {
    const _this = this;
    const getDataCartStorage =
      JSON.parse(localStorage.getItem("dataFromCart")) ?? [];
    const ulRoot = $(".main__wrapper-list");
    if (getDataCartStorage.length > 0) {
      const htmls = getDataCartStorage.map((data) => {
        let sizeId = "";
        switch (data.sizeProduct) {
          case "38":
            sizeId = "1";
            break;
          case "39":
            sizeId = "2";
            break;
          case "40":
            sizeId = "3";
            break;
          case "41":
            sizeId = "4";
            break;

          default:
            break;
        }

        return `
                <li class="main__wrapper-item">
                    <input value="${data.idProduct}" name="idProduct" hidden />
                    <span class="main__id-product-from-cart" hidden name="id-product">${
                      data.idProduct
                    }</span>
                    <div class="main__wrapper-box-item">
                        <div class="main__wrapper-box-avatar">
                            <div class="main__wrapper-box-img" name="img-product" style="background-image: url(${
                              data.imgProduct
                            })"></div>
                        </div>
                        <div class="main__wrapper-box-detail">
                            <h3 class="main__wrapper-box-detail-title">
                                <span name="name-product" class="main__wrapper-box-detail-title-text">${
                                  data.nameProduct
                                }</span>
                                <button class="main__wrapper-box-detail-btn-remove">
                                    <i class="fa-regular fa-trash-can btn-remove-icon"></i>
                                </button>
                            </h3>
                            <input value="${sizeId}" name="sizeId" hidden />
                            <p class="main__wrapper-box-detail-desc" name="size-product" value="${sizeId}">Size: ${
          data.sizeProduct
        }</p>
                            <div class="main__wrapper-box-detail-footer">
                                <div class="main__wrapper-box-detail-price" name="price-product" default="${Number.parseInt(
                                  data.priceDefault
                                )}" value="${Number.parseInt(
          data.priceProduct
        )}">${_this.formatMoneyVND(data.priceProduct) + "đ"}</div>
                                <div class="main__wrapper-box-control-quantity">
                                    <button class="main__wrapper-box-quantity-discount">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <input type="text" name="amount-product" value="${
                                      data.amountProduct
                                    }" min="1" max="100" class="main__wrapper-box-quantity-input">
                                    <button class="main__wrapper-box-quantity-inscrease">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>  
                `;
      });
      ulRoot.innerHTML = htmls.join("");
    } else {
      const h3Message = document.createElement("h3");
      h3Message.innerText =
        "Chưa có sản phẩm nào trong trang thanh toán của bạn";
      h3Message.style = "color: #8c8b8e";
      h3Message.style.textAlign = "center";
      h3Message.style.padding = "20px";
      h3Message.style.fontSize = "1.5rem";
      ulRoot.appendChild(h3Message);
    }
  },

  localStorageFromCart(key) {
    const store = JSON.parse(localStorage.getItem("dataFromCart")) ?? [];

    const save = (data) => {
      localStorage.setItem(key, JSON.stringify(data));
    };

    const storage = {
      getItemByID(idProduct) {
        if (store.length > 0) {
          const itemProduct = store.find((item) => {
            return item.idProduct === idProduct;
          });
          return itemProduct;
        } else {
          throw new Error("is not data dataFormCart");
        }
      },

      set(idProduct, amountProduct, newPrice) {
        if (store.length > 0) {
          let flagIndex;
          const response = store.some((item, index) => {
            flagIndex = index;
            return item.idProduct === idProduct;
          });
          if (response) {
            store.forEach((element) => {
              if (element.idProduct === idProduct) {
                store.splice(flagIndex, 1, {
                  idProduct,
                  nameProduct: element.nameProduct,
                  sizeProduct: element.sizeProduct,
                  amountProduct,
                  priceProduct: newPrice,
                  imgProduct: element.imgProduct,
                  priceDefault: element.priceDefault,
                });
                save(store);
              }
            });
          }
        } else {
          throw new Error("is not data dataFormCart");
        }
      },

      remove() {},
    };

    return storage;
  },

  handleChangeAmount() {
    const _this = this;
    const parent = $$(".main__wrapper-item");
    const total = $(".main__order-total-price");
    const numberTotal = Number.parseInt(total.attributes.value.nodeValue);
    Array.from(parent).forEach((item) => {
      const btnIncrease = item.querySelector(
        ".main__wrapper-box-quantity-inscrease"
      );
      const btnDecrease = item.querySelector(
        ".main__wrapper-box-quantity-discount"
      );
      const input = item.querySelector(".main__wrapper-box-quantity-input");
      const idProduct = item.querySelector(".main__id-product-from-cart");
      const priceProduct = item.querySelector(
        ".main__wrapper-box-detail-price"
      );
      btnIncrease.onclick = function (e) {
        e.preventDefault();
        const numberInputValue = Number.parseInt(
          input.attributes.value.nodeValue
        );
        if (numberInputValue >= 100) {
          input.setAttribute("value", 100);
        } else {
          const sum = numberInputValue + 1;
          input.setAttribute("value", sum);

          const numberPriceProduct = Number.parseInt(
            priceProduct.attributes.value.nodeValue
          );
          const priceDefault = Number.parseInt(
            priceProduct.attributes.default.nodeValue
          );
          const sumPrice = numberPriceProduct + priceDefault;
          priceProduct.attributes.value.nodeValue = sumPrice;
          priceProduct.textContent = _this.formatMoneyVND(sumPrice);
          const sumRootTotal = Array.from(parent).reduce((acc, element) => {
            const valuePrice = element.querySelector(
              ".main__wrapper-box-detail-price"
            ).attributes.value.nodeValue;
            return acc + Number.parseInt(valuePrice);
          }, 0);
          $(".main__order-subtotal-price").textContent =
            _this.formatMoneyVND(sumRootTotal) + "đ";
          total.setAttribute("value", sumRootTotal);
          total.textContent = _this.formatMoneyVND(sumRootTotal) + "đ";
          const data = _this.localStorageFromCart("dataFromCart");
          data.set(idProduct.textContent, sum, sumPrice);
        }
      };

      btnDecrease.onclick = function (e) {
        e.preventDefault();
        const numberInputValue = Number.parseInt(
          input.attributes.value.nodeValue
        );
        if (numberInputValue > 1) {
          const minus = numberInputValue - 1;
          input.setAttribute("value", minus);
          const numberPriceProduct = Number.parseInt(
            priceProduct.attributes.value.nodeValue
          );
          const priceDefault = Number.parseInt(
            priceProduct.attributes.default.nodeValue
          );
          const sumPrice = numberPriceProduct - priceDefault;
          priceProduct.attributes.value.nodeValue = sumPrice;
          priceProduct.textContent = _this.formatMoneyVND(sumPrice);
          const numberTotalCurrent = Number.parseInt(
            total.attributes.value.nodeValue
          );
          const sumRootTotal = numberTotalCurrent - priceDefault;
          total.setAttribute("value", sumRootTotal);
          $(".main__order-subtotal-price").textContent =
            _this.formatMoneyVND(sumRootTotal) + "đ";
          total.textContent = _this.formatMoneyVND(sumRootTotal) + "đ";
          const data = _this.localStorageFromCart("dataFromCart");
          data.set(idProduct.textContent, minus, sumPrice);
        } else {
          input.setAttribute("value", 1);
          const priceDefault = Number.parseInt(
            priceProduct.attributes.default.nodeValue
          );
          priceProduct.attributes.value.nodeValue = priceDefault;
          priceProduct.textContent = _this.formatMoneyVND(priceDefault);
        }
      };
    });
  },

  sumTotal() {
    const _this = this;
    const total = $(".main__order-total-price");
    const subTotal = $(".main__order-subtotal-price");
    const priceEachProduct = $$(".main__wrapper-box-detail-price");
    const sumTotal = Array.from(priceEachProduct).reduce((acc, price) => {
      const numberPrice = Number.parseInt(price.attributes.value.nodeValue);
      return acc + numberPrice;
    }, 0);
    total.setAttribute("value", sumTotal);
    total.textContent = _this.formatMoneyVND(sumTotal) + "đ";
    subTotal.textContent = _this.formatMoneyVND(sumTotal) + "đ";
  },

  // handle Remove All Product
  removeAllProducts() {
    const _this = this;
    const btnRemoveAll = $(".main__wrapper-btn-remove-all");
    const modal = $(".modal");
    const btnAgree = $(".modal__actions-agree");
    const btnCancel = $(".modal__actions-cancel");

    function handleShowModal() {
      modal.classList.add("active");
    }

    function handleHideModal() {
      modal.classList.remove("active");
    }

    btnRemoveAll.onclick = function (e) {
      const textModal = $(".modal__content-text");
      textModal.innerText = `Bạn có muốn xoá hết tất cả sản phẩm không?`;
      e.preventDefault();
      handleShowModal();

      btnCancel.addEventListener("click", (e) => {
        handleHideModal();
        e.preventDefault();
      });

      btnAgree.onclick = function (e) {
        e.preventDefault();
        localStorage.setItem("dataFromCart", JSON.stringify([]));
        handleHideModal();
        window.location.reload();
      };
    };
  },

  // remove each product
  removeEachProduct() {
    const parents = $$(".main__wrapper-item");
    Array.from(parents).forEach((element) => {
      const idProduct = element.querySelector(
        ".main__id-product-from-cart"
      ).textContent;
      const btnRemove = element.querySelector(
        ".main__wrapper-box-detail-btn-remove"
      );
      const nameProduct = element.querySelector(
        ".main__wrapper-box-detail-title-text"
      );

      const modal = $(".modal");
      const btnAgree = $(".modal__actions-agree");
      const btnCancel = $(".modal__actions-cancel");
      const textModal = $(".modal__content-text");

      function handleShowModal() {
        textModal.innerText = `Bạn có muốn xoá ${nameProduct.textContent} này không?`;
        modal.classList.add("active");
      }

      function handleHideModal() {
        modal.classList.remove("active");
      }

      btnRemove.onclick = function (e) {
        e.preventDefault();
        handleShowModal();

        btnAgree.onclick = function (e) {
          e.preventDefault();
          const data = JSON.parse(localStorage.getItem("dataFromCart")) ?? [];

          if (data.length > 0) {
            console.log(idProduct);
            let flagIndex;
            const response = data.find((element, index) => {
              flagIndex = index;
              return element.idProduct === idProduct;
            });
            console.log(flagIndex);
            if (response) {
              data.forEach((element) => {
                if (element.idProduct === idProduct) {
                  data.splice(flagIndex, 1);
                  localStorage.setItem("dataFromCart", JSON.stringify(data));
                  handleHideModal();
                  window.location.reload();
                }
              });
            }
          } else {
            throw new Error("is not data dataFormCart");
          }
        };
      };

      btnCancel.onclick = function (e) {
        e.preventDefault();
        handleHideModal();
      };
    });
  },

  // handleSubmit
  handleSubmit() {
    const btnSubmit = $(".main__order-btn-total-price");

    btnSubmit.onclick = function (e) {
      const dataStorage =
        JSON.parse(localStorage.getItem("dataFromCart")) ?? [];
      if (dataStorage.length > 0) {
        if (sessionUserID) {
          e.submit;
        } else {
          e.preventDefault();
          const modal = $(".main__checkout-modal");
          const btnAgree = $(".main__checkout-message-agree");
          const btnCancel = $(".main__checkout-message-cancel");
          const authModal = $(".main__checkout-message");
          handleShowModal();

          function handleShowModal() {
            modal.classList.add("active");
          }

          function handleHideModal() {
            modal.classList.remove("active");
          }

          btnAgree.onclick = function () {
            handleHideModal();
            window.location.href = "./login_regin.php";
          };

          btnCancel.onclick = function () {
            handleHideModal();
          };

          modal.onclick = function () {
            handleHideModal();
          };

          authModal.onclick = function (e) {
            e.stopPropagation();
          };
        }
      } else {
        e.preventDefault();
        const modalNoActive = $(".main__checkout-note");
        modalNoActive.classList.add("active");
        setTimeout(() => {
          modalNoActive.classList.remove("active");
        }, 1800);
      }
    };
  },

  dataSubmit() {
    const inputListProductID = $(".data");
    const dataStorage = JSON.parse(localStorage.getItem("dataFromCart")) ?? [];
    const listProductID = Array.from(dataStorage).map((data, index) => {
      //   switch (data.sizeProduct) {
      //     case "38":
      //       data.sizeProduct = "1";
      //       break;
      //     case "39":
      //       data.sizeProduct = "2";
      //       break;
      //     case "40":
      //       data.sizeProduct = "3";
      //       break;
      //     case "41":
      //       data.sizeProduct = "4";
      //       break;

      //     default:
      //       break;
      //   }

      return [
        Number.parseInt(data.idProduct),
        Number.parseInt(data.priceProduct),
        Number.parseInt(data.sizeProduct),
        Number.parseInt(data.amountProduct),
      ];
    });
    inputListProductID.setAttribute("value", JSON.stringify(listProductID));
  },
};

checkout.handleRenderProduct();
checkout.sumTotal();
checkout.handleChangeAmount();
checkout.removeAllProducts();
checkout.removeEachProduct();
checkout.dataSubmit();
checkout.handleSubmit();
