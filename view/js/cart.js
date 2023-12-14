const _cart = document.querySelector.bind(document);
const _carts = document.querySelectorAll.bind(document);

const cart = {
  // handle render product
  handleRenderProduct() {
    // format money
    function formatMoneyVND(str) {
      const toStringStr = str.toString();
      return toStringStr
        .split("")
        .reverse()
        .reduce((prev, next, index) => {
          return (index % 3 ? next : next + ".") + prev;
        });
    }

    const stores = JSON.parse(localStorage.getItem("valueFromDetail")) ?? [];
    if (stores) {
      const parent = _cart(".main-render-product");

      const data = stores
        .map((store) => {
          return `
                <div class="main__wrapper-product">
                <span class="idProd__store" hidden>${store.idProd}</span>
                <div class="main__wrapper-product-main">
                    <!-- active là class khi checkbox được check -->
                    <label for="#checkbox-item" class="main__wrapper-product-label">
                        <input id="checkbox-item" type="checkbox" class="main__wrapper-product-input">
                        <div class="main__wrapper-product-wrapper-checkbox">
                            <i class="fa-solid fa-check main__wrapper-product-checkbox-icon"></i>
                        </div>
                    </label>
                    <div class="main__wrapper-product-info">
                        <a class="main__wrapper-product-info-avatar">
                            <img src="${
                              store.imgProd
                            }" alt="" class="main__wrapper-product-info-img">
                        </a>
                        <div class="main__wrapper-product-info-text">
                            <h3 class="main__wrapper-product-info-name">${
                              store.nameProd
                            }</h3>
                            <div class="main__wrapper-product-info-desc">
                                <span class="main__wrapper-product-info-sale">${
                                  store.salesProduct
                                }<span> Giảm</span></span>
                                <span class="main__wrapper-product-info-freeship">Free ship</span>
                            </div>
                        </div>
                    </div>
                    <!-- product size -->
                    <div class="main__wrapper-product-size">${store.size}</div>
                    <!-- product quantity -->
                    <div class="main__wrapper-product-quantity">
                        <div class="main__wrapper-product-quantity-box">
                            <button class="main__wrapper-product-quantity-discount">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <input type="text" value="${
                              store.amount
                            }" min="1" max="99" class="main__wrapper-product-quantity-input">
                            <button class="main__wrapper-product-quantity-increase">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- product price -->
                    <div class="main__wrapper-product-quantity-price">
                        <span class="main__wrapper-product-quantity-price-old">${
                          formatMoneyVND(store.oldPriceProduct) + "đ"
                        }</span>
                        <span class="main__wrapper-product-quantity-price-current" value="${
                          store.priceProd
                        }">${formatMoneyVND(store.priceProd) + "đ"}</span>
                    </div>
                </div>
                <div class="main__wrapper-product-manipulation">
                    <div class="main__wrapper-product-favourite">
                        <i class="fa-regular fa-heart"></i>
                        <span class="main__wrapper-product-text">Yêu thích</span>
                    </div>
                    <div class="main__wrapper-product-remove">
                        <i class="fa-regular fa-trash-can"></i>
                        <span class="main__wrapper-product-text">Xoá</span>
                    </div>
                </div>
                <div class="modal">
                    <div class="modal__message">
                        <div class="modal__header">
                            <i class="fa-regular fa-circle-question"></i>
                            <span class="modal__header-title">G5 Thông Báo</span>
                        </div>
                        <div class="modal__content">
                            <h3 class="modal__content-text">Bạn có muốn xoá sản phẩm có tên là ${
                              store.nameProd
                            } này không?</h3>
                        </div>
                        <div class="modal__actions">
                            <button class="modal__actions-agree">
                                <i class="fa-solid fa-check modal__icon"></i>
                                <span class="modal__actions-agree-title">Đồng Ý</span>
                            </button>
                            <button class="modal__actions-cancel">
                                <i class="fa-solid fa-xmark modal__icon"></i>
                                <span class="modal__actions-agree-title">Huỷ Bỏ</span>
                            </button>
                        </div>
                        </div>
                    </div>
                </div>
                `;
        })
        .join("");

      parent.innerHTML = data;
    } else {
      throw new Error("localStorage is not data");
    }
  },

  handleActions() {
    // Local Storage
    function localStorageProduct(key) {
      const stores = JSON.parse(localStorage.getItem(key)) ?? [];

      const save = (data) => {
        localStorage.setItem(key, JSON.stringify(data));
      };

      const store = {
        get(idProduct) {
          const response = stores.find((store) => store.idProd === idProduct);
          return response;
        },
        set(idProduct, amount, newPrice) {
          if (stores.length > 0) {
            const response = stores.find((store) => store.idProd === idProduct);
            if (response) {
              stores.forEach((store, index) => {
                if (store.idProd === idProduct) {
                  stores.splice(index, 1, {
                    idProd: store.idProd,
                    size: store.size,
                    amount: amount,
                    nameProd: store.nameProd,
                    priceProd: newPrice,
                    defaultPrice: store.defaultPrice,
                    imgProd: store.imgProd,
                  });
                  save(stores);
                }
              });
            }
          } else {
            throw new Error(
              `Can't get the product because there are no products`
            );
          }
        },

        remove(idProduct) {
          if (stores.length > 0) {
            const response = stores.find((store) => store.idProd === idProduct);
            if (response) {
              stores.forEach((store, index) => {
                if (store.idProd === idProduct) {
                  stores.splice(index, 1);
                  save(stores);
                }
              });
            }
          } else {
            throw new Error(
              `Can't remove the product because there are no products`
            );
          }
        },

        removeAllOrEachProduct(props) {
          if (Array.isArray(props)) {
            if (stores.length > 0) {
              props.forEach((prop, index) => {
                const response = stores.find((store) => store.idProd === prop);
                if (response) {
                  stores.forEach((store, index) => {
                    if (store.idProd === prop) {
                      stores.splice(index, 1);
                      save(stores);
                    }
                  });
                }
              });
            } else {
              throw new Error(
                `Can't remove the product because there are no products`
              );
            }
          } else {
            throw new Error("The argument must be an array data type");
          }
        },
      };

      return store;
    }
    // handle on change price each product item and set to localStorage(key = "valueFormDetail");
    function handleActionsPriceChange(condition, amount, idPro, currentPrice) {
      const numberAmount = Number(amount);
      const numberCurrentPrice = Number(currentPrice);

      if (arguments.length > 4) {
        throw new Error("arguments cannot be more than 4 arguments");
      } else {
        if (condition === "increase" || condition === "decrease") {
          if (condition === "increase") {
            const dataStore = localStorageProduct("valueFromDetail");
            const priceStore = dataStore.get(idPro);
            const numberPriceDefaultStore = Number(priceStore.defaultPrice);
            const total = numberCurrentPrice + numberPriceDefaultStore;
            dataStore.set(idPro, numberAmount, total);
            return total;
          } else {
            const dataStore = localStorageProduct("valueFromDetail");
            const priceStore = dataStore.get(idPro);
            const numberPriceDefaultStore = Number(priceStore.defaultPrice);
            if (numberAmount === 1) {
              const total = numberPriceDefaultStore;
              dataStore.set(idPro, numberAmount, total);
              return total;
            } else {
              const total = numberCurrentPrice - numberPriceDefaultStore;
              dataStore.set(idPro, numberAmount, total);
              return total;
            }
          }
        } else {
          throw new Error(
            'The first argument has a name of "increase" or "decrease"'
          );
        }
      }
    }

    // format money
    function formatMoneyVND(str) {
      const toStringStr = str.toString();
      return toStringStr
        .split("")
        .reverse()
        .reduce((prev, next, index) => {
          return (index % 3 ? next : next + ".") + prev;
        });
    }

    // handle calculate total checkout
    const totalCheckOutView = _cart(".main__checkout-right-total-price");
    function handleToTalCheckOut() {
      const listProduct = _carts(
        ".main__wrapper-product-quantity-price-current"
      );
      const totalCheckOut = Array.from(listProduct).reduce((acc, product) => {
        const numberPriceProduct = Number(product.attributes.value.nodeValue);
        return acc + numberPriceProduct;
      }, 0);
      totalCheckOutView.setAttribute("value", totalCheckOut);
      totalCheckOutView.innerText = formatMoneyVND(totalCheckOut) + "đ";
    }

    // get All list product
    const parents = _carts(".main__wrapper-product");

    Array.from(parents).forEach((parent) => {
      const btnIncrease = parent.querySelector(
        ".main__wrapper-product-quantity-increase"
      );
      const btnDecrease = parent.querySelector(
        ".main__wrapper-product-quantity-discount"
      );
      const inputAmount = parent.querySelector(
        ".main__wrapper-product-quantity-input"
      );
      const priceProduct = parent.querySelector(
        ".main__wrapper-product-quantity-price-current"
      );
      const idProductStore = parent.querySelector(".idProd__store");

      // handle on increase each product item
      btnIncrease.onclick = () => {
        if (inputAmount.value >= 100) {
          inputAmount.value = 100;
          inputAmount.attributes.value.nodeValue = 100;
        } else {
          inputAmount.value = Number(inputAmount.value) + 1;
          inputAmount.attributes.value.nodeValue = inputAmount.value;
          const totalPrice = handleActionsPriceChange(
            "increase",
            inputAmount.attributes.value.nodeValue,
            idProductStore.textContent,
            priceProduct.attributes.value.nodeValue
          );
          priceProduct.textContent = formatMoneyVND(totalPrice) + "đ";
          priceProduct.attributes.value.nodeValue = totalPrice;
          // if has active, will set price to rootTotal view
          if (btnCheckEachProduct.classList.contains("active")) {
            const productHasCheck = Array.from(parents).filter(
              (product, index) => {
                const labelCheck = product.querySelector(
                  ".main__wrapper-product-label.active"
                );
                return labelCheck;
              }
            );
            if (productHasCheck.length > 1) {
              const productPrices = Array.from(parents).reduce(
                (acc, product) => {
                  const price = product.querySelector(
                    ".main__wrapper-product-quantity-price-current"
                  );
                  const numberPrice = Number.parseInt(
                    price.attributes.value.nodeValue
                  );
                  return acc + numberPrice;
                },
                0
              );
              totalView.setAttribute("value", productPrices);
              totalView.textContent = formatMoneyVND(productPrices) + "đ";
            } else {
              totalView.setAttribute("value", totalPrice);
              totalView.textContent = formatMoneyVND(totalPrice) + "đ";
            }
          }
        }
      };
      // handle on decrease each product item
      btnDecrease.onclick = () => {
        if (inputAmount.value > 1) {
          inputAmount.value = Number(inputAmount.value) - 1;
          inputAmount.attributes.value.nodeValue = inputAmount.value;
          const totalPrice = handleActionsPriceChange(
            "decrease",
            inputAmount.attributes.value.nodeValue,
            idProductStore.textContent,
            priceProduct.attributes.value.nodeValue
          );
          priceProduct.textContent = formatMoneyVND(totalPrice) + "đ";
          priceProduct.attributes.value.nodeValue = totalPrice;

          // if has active, will set price to rootTotal view
          if (btnCheckEachProduct.classList.contains("active")) {
            const productHasCheck = Array.from(parents).filter(
              (product, index) => {
                const labelCheck = product.querySelector(
                  ".main__wrapper-product-label.active"
                );
                return labelCheck;
              }
            );
            if (productHasCheck.length > 1) {
              const dataStorage = localStorageProduct("valueFromDetail");
              const response = dataStorage.get(idProductStore.textContent);
              const numberTotalView = Number.parseInt(
                totalView.attributes.value.nodeValue
              );
              const minus = numberTotalView - response.defaultPrice;
              totalView.setAttribute("value", minus);
              totalView.textContent = formatMoneyVND(minus) + "đ";
            } else {
              totalView.setAttribute("value", totalPrice);
              totalView.textContent = formatMoneyVND(totalPrice) + "đ";
            }
          }
        } else {
          inputAmount.value = 1;
          const totalPrice = handleActionsPriceChange(
            "decrease",
            (inputAmount.attributes.value.nodeValue = 1),
            idProductStore.textContent,
            priceProduct.attributes.value.nodeValue
          );
          inputAmount.attributes.value.nodeValue = inputAmount.value;
          priceProduct.textContent = formatMoneyVND(totalPrice) + "đ";
          priceProduct.attributes.value.nodeValue = totalPrice;
        }
      };

      // handle Remove each Product item
      function removeProduct() {
        const btnRemoveProduct = parent.querySelector(
          ".main__wrapper-product-remove"
        );
        // actions remove
        const modal = parent.querySelector(".modal");
        const authModal = parent.querySelector(".modal__message");
        const btnAgree = parent.querySelector(".modal__actions-agree");
        const btnCancel = parent.querySelector(".modal__actions-cancel");

        // handle remove
        function handleShowModal() {
          modal.classList.add("active");
        }

        function handleHideModal() {
          modal.classList.remove("active");
        }

        btnRemoveProduct.addEventListener("click", handleShowModal);
        btnCancel.addEventListener("click", handleHideModal);
        modal.addEventListener("click", handleHideModal);
        authModal.addEventListener("click", (e) => e.stopPropagation());

        btnAgree.onclick = function () {
          const dataStore = localStorageProduct("valueFromDetail");
          dataStore.remove(idProductStore.textContent);
          handleHideModal();
          window.location.reload();
        };
      }
      removeProduct();

      // handle check each product
      const btnCheckEachProduct = parent.querySelector(
        ".main__wrapper-product-label"
      );
      const totalView = _cart(".main__checkout-right-total-price");
      btnCheckEachProduct.onclick = function () {
        this.classList.toggle("active");
        let numberTotal = Number.parseInt(totalView.attributes.value.nodeValue);
        if (this.classList.contains("active")) {
          const numberCurrentPrice = Number.parseInt(
            priceProduct.attributes.value.nodeValue
          );
          const sum = numberTotal + numberCurrentPrice;
          totalView.setAttribute("value", sum);
          totalView.textContent = formatMoneyVND(sum) + "đ";
          const parentHasActive = _carts(".main__wrapper-product-label.active");
          const selectedText = _cart(".main__checkout-selected");
          const textTotal = _cart(".main__checkout-total-title");
          textTotal.innerText = `Tổng thanh toán(${
            Array.from(parentHasActive).length
          } sản phẩm)`;
          selectedText.innerText = `${
            Array.from(parentHasActive).length
          } sản phẩm đã chọn`;
        } else {
          const numberCurrentPrice = Number.parseInt(
            priceProduct.attributes.value.nodeValue
          );
          const minus = numberTotal - numberCurrentPrice;
          totalView.setAttribute("value", minus);
          totalView.textContent = formatMoneyVND(minus) + "đ";
          const parentHasActive = _carts(".main__wrapper-product-label.active");
          const selectedText = _cart(".main__checkout-selected");
          const textTotal = _cart(".main__checkout-total-title");
          textTotal.innerText = `Tổng thanh toán(${
            Array.from(parentHasActive).length
          } sản phẩm)`;
          selectedText.innerText = `${
            Array.from(parentHasActive).length
          } sản phẩm đã chọn`;
        }
      };
    });

    // handle on checkAll
    function handleCheckAll() {
      btnCheckAll.classList.toggle("active");
      btnCheckAllFooter.classList.toggle("active");

      if (btnCheckAll.classList.contains("active")) {
        Array.from(parents).forEach((product, index) => {
          const productItemCheck = product.querySelector(
            ".main__wrapper-product-label"
          );
          productItemCheck.classList.add("active");
        });
        const textTotal = _cart(".main__checkout-total-title");
        const selectedText = _cart(".main__checkout-selected");
        selectedText.innerText = `${
          Array.from(parents).length
        } sản phẩm đã chọn`;
        textTotal.innerText = `Tổng thanh toán(${
          Array.from(parents).length
        } sản phẩm):`;
        handleToTalCheckOut();
      } else {
        Array.from(parents).forEach((product, index) => {
          const productItemCheck = product.querySelector(
            ".main__wrapper-product-label"
          );
          productItemCheck.classList.remove("active");
        });
        const textTotal = _cart(".main__checkout-total-title");
        textTotal.innerText = `Tổng thanh toán(0 sản phẩm):`;
        _cart(".main__checkout-right-total-price").setAttribute("value", 0);
        _cart(".main__checkout-right-total-price").textContent = "0đ";
        const selectedText = _cart(".main__checkout-selected");
        selectedText.innerText = `0 sản phẩm đã chọn`;
      }
    }
    const btnCheckAll = _cart(".main__wrapper-stardust");
    btnCheckAll.onclick = function () {
      handleCheckAll();
    };

    // btnCheckAll footer
    const btnCheckAllFooter = _cart(".js-checkAll-footer");
    btnCheckAllFooter.onclick = function () {
      handleCheckAll();
    };

    // btn selected all
    const btnSelectedAll = _cart(".main__checkout-btn-select-all");
    btnSelectedAll.onclick = function () {
      handleCheckAll();
    };

    // btn remove footer
    const btnRemoveFooter = _cart(".main__checkout-btn-remove");
    btnRemoveFooter.onclick = function () {
      const parentMain = _carts(".main__wrapper-product");
      const labelHasActive = Array.from(parentMain).filter((element, index) => {
        const hasActive = element.querySelector(
          ".main__wrapper-product-label.active"
        );
        return hasActive;
      });
      if (labelHasActive.length > 0) {
        const modalHasActive = _cart(".main__checkout-modal");
        const btnAgree = _cart(".main__checkout-message-agree");
        const btnCancel = _cart(".main__checkout-message-cancel");
        const authModal = _cart(".main__checkout-message");
        handleShowModal();
        _cart(
          ".ain__checkout-message-content-title"
        ).textContent = `Bạn có muốn xoá ${labelHasActive.length} sản phẩm không?`;
        function handleShowModal() {
          modalHasActive.classList.add("active");
        }

        function handleHideModal() {
          modalHasActive.classList.remove("active");
        }

        btnAgree.addEventListener("click", () => {
          const idArray = [];
          labelHasActive.forEach((hasActive) => {
            const idHasActive = hasActive.querySelector(".idProd__store");
            idArray.push(idHasActive.textContent);
          });
          const dataStore = localStorageProduct("valueFromDetail");
          dataStore.removeAllOrEachProduct(idArray);
          handleHideModal();
          window.location.reload();
        });
        btnCancel.addEventListener("click", handleHideModal);
        authModal.addEventListener("click", (e) => e.stopPropagation());
      } else {
        const modalNoActive = _cart(".main__checkout-note");
        modalNoActive.classList.add("active");
        setTimeout(() => {
          modalNoActive.classList.remove("active");
        }, 1000);
      }
    };
  },

  //   // handle Submit
  //   handleSubmit() {
  //     const btnSubmit = _cart(".main__checkout-right-link-checkout");
  //     btnSubmit.onclick = function (e) {
  //       const _this = this;
  //       const listProducts = _carts(".main__wrapper-product");
  //       const listProductHasActive = Array.from(listProducts).filter(
  //         (product, index) => {
  //           const hasActive = product.querySelector(
  //             ".main__wrapper-product-label.active"
  //           );
  //           return hasActive;
  //         }
  //       );
  //       if (listProductHasActive.length > 0) {
  //         this.setAttribute("href", "./checkout.php");
  //         listProductHasActive.forEach((product) => {
  //           const idProduct = product.querySelector(".idProd__store").textContent;
  //           const nameProduct = product.querySelector(
  //             ".main__wrapper-product-info-name"
  //           ).textContent;
  //           const sizeProduct = product.querySelector(
  //             ".main__wrapper-product-size"
  //           ).textContent;
  //           const amountProduct = product.querySelector(
  //             ".main__wrapper-product-quantity-input"
  //           ).attributes.value.nodeValue;
  //           const priceProduct = product.querySelector(
  //             ".main__wrapper-product-quantity-price-current"
  //           ).attributes.value.nodeValue;
  //           const imgProduct = product.querySelector(
  //             ".main__wrapper-product-info-img"
  //           ).attributes.src.nodeValue;
  //           const storeFromCart =
  //             JSON.parse(localStorage.getItem("dataFromCart")) ?? [];

  //           // Remove item from 'valueFromDetail'
  //           const dataFromDetail =
  //             JSON.parse(localStorage.getItem("valueFromDetail")) ?? [];
  //           const indexToRemove = dataFromDetail.findIndex(
  //             (item) => item.idProd === idProduct
  //           );
  //           if (indexToRemove !== -1) {
  //             dataFromDetail.splice(indexToRemove, 1);
  //             localStorage.setItem(
  //               "valueFromDetail",
  //               JSON.stringify(dataFromDetail)
  //             );
  //           }

  //           // Add item to 'dataFromCart'
  //           if (storeFromCart.length > 0) {
  //             let flagIndex;
  //             const duplicateID = storeFromCart.find((store, index) => {
  //               flagIndex = index;
  //               return store.idProduct === idProduct;
  //             });
  //             if (duplicateID) {
  //               // ... (your existing logic for updating existing item in cart)
  //             } else {
  //               // ... (your existing logic for adding new item to cart)
  //             }
  //           } else {
  //             // ... (your existing logic for adding new item to cart)
  //           }
  //         });
  //       } else {
  //         e.preventDefault();
  //         const modalNoActive = $(".main__checkout-note");
  //         modalNoActive.classList.add("active");
  //         setTimeout(() => {
  //           modalNoActive.classList.remove("active");
  //         }, 1000);
  //       }
  //     };
  //   },

  // handle Submit
  handleSubmit() {
    const btnSubmit = _cart(".main__checkout-right-link-checkout");
    btnSubmit.onclick = function (e) {
      const _this = this;
      const listProducts = _carts(".main__wrapper-product");
      const listProductHasActive = Array.from(listProducts).filter(
        (product, index) => {
          const hasActive = product.querySelector(
            ".main__wrapper-product-label.active"
          );
          return hasActive;
        }
      );
      if (listProductHasActive.length > 0) {
        this.setAttribute("href", "./checkout.php");
        listProductHasActive.forEach((product) => {
          const idProduct = product.querySelector(".idProd__store").textContent;
          const nameProduct = product.querySelector(
            ".main__wrapper-product-info-name"
          ).textContent;
          const sizeProduct = product.querySelector(
            ".main__wrapper-product-size"
          ).textContent;
          const amountProduct = product.querySelector(
            ".main__wrapper-product-quantity-input"
          ).attributes.value.nodeValue;
          const priceProduct = product.querySelector(
            ".main__wrapper-product-quantity-price-current"
          ).attributes.value.nodeValue;
          const imgProduct = product.querySelector(
            ".main__wrapper-product-info-img"
          ).attributes.src.nodeValue;
          const storeFromCart =
            JSON.parse(localStorage.getItem("dataFromCart")) ?? [];

          // Remove item from 'valueFromDetail'
          const dataFromDetail =
            JSON.parse(localStorage.getItem("valueFromDetail")) ?? [];
          const indexToRemove = dataFromDetail.findIndex(
            (item) => item.idProd === idProduct
          );
          if (indexToRemove !== -1) {
            const removedItem = dataFromDetail.splice(indexToRemove, 1)[0];
            localStorage.setItem(
              "valueFromDetail",
              JSON.stringify(dataFromDetail)
            );

            // Add removed item to 'dataFromCart'
            storeFromCart.unshift({
              idProduct: removedItem.idProd,
              nameProduct: removedItem.nameProd,
              sizeProduct: removedItem.size,
              amountProduct: removedItem.amount,
              priceProduct: removedItem.priceProd,
              imgProduct: removedItem.imgProd,
              priceDefault: removedItem.defaultPrice,
            });
            localStorage.setItem("dataFromCart", JSON.stringify(storeFromCart));
          }
        });
      } else {
        e.preventDefault();
        const modalNoActive = $(".main__checkout-note");
        modalNoActive.classList.add("active");
        setTimeout(() => {
          modalNoActive.classList.remove("active");
        }, 1000);
      }
    };
  },
};

cart.handleRenderProduct();
cart.handleActions();
cart.handleSubmit();
