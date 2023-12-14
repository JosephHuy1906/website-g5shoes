const query = document.querySelector.bind(document);
const queries = document.querySelectorAll.bind(document);

const header = {

    // format money
    formatMoneyVND(str) {
        const toStringStr = str.toString();
        return toStringStr.split('').reverse().reduce((prev, next, index) => {
            return ((index % 3) ? next : (next + '.')) + prev
        })
    },

    handleShowNotification() {
        const btnNotification = query('.header__information-link.ting');
        const modalNotification = query('.header__notification');
        btnNotification.addEventListener('click', () => {
            modalNotification.classList.toggle('active');
        })
        document.addEventListener('click', (e) => {
            if (e.target.className !== 'header__information-link ting' && e.target.className !== 'header__notification active' && e.target.className !== 'fa-regular fa-bell' && e.target.className !== 'header__information-count-information') {
                modalNotification.classList.remove('active');
            }
        })
        modalNotification.addEventListener('click', e => {
            e.stopPropagation();
        })
    },

    // handle show hide cart
    handleShowCart() {
        const _this = this;
        const btn = query('.header__information-link.cart');
        const headerCart = query('.header__cart');
        const listProductFormCart = JSON.parse(localStorage.getItem('valueFromDetail')) ?? [];
        const ulRoot = query('.header__cart-list');

        if (listProductFormCart.length > 0) {
            const html = listProductFormCart.map((product) => {
                return `
                    <li class="header__cart-item">
                        <a class="header__cart-link">
                            <div class="header__cart-info">
                                <div class="header__cart-info-avatar">
                                    <img src="${product.imgProd}" alt="" class="header__cart-info-img">
                                </div>
                                <div class="header__cart-info-text">
                                    <h3 class="header__cart-info-name">${product.nameProd}</h3>
                                    <p class="header__cart-info-desc">Size: ${product.size}</p>
                                    <p class="header__cart-info-desc">Số lượng: ${product.amount}</p>
                                </div>
                            </div>
                            <!-- price -->
                            <div class="header__cart-component">
                                <span class="header__cart-total-component">${_this.formatMoneyVND(product.priceProd) + 'đ'}</span>
                            </div>
                        </a>
                    </li>
                `
            });
            ulRoot.innerHTML = html.join('');
            const cartLink = query('.header__cart-link-navigation');
            cartLink.style.display = 'inline-block';
        }
        else {
            const cartLink = query('.header__cart-link-navigation');
            const imgMessage = document.createElement('img');
            const h4Message = document.createElement('h4');
            imgMessage.setAttribute('src', 'http://bepharco.com/no-products-found.png');
            imgMessage.style.width = '160px';
            imgMessage.style.height = '160px';
            imgMessage.style.objectFit = 'contain';
            h4Message.innerText = 'Chưa có sản phẩm nào trong giỏ hàng của bạn';
            h4Message.style.fontSize = '1.5rem';
            h4Message.style.color = '#999';
            h4Message.style.textAlign = 'center';

            cartLink.style.display = 'none';
            ulRoot.appendChild(imgMessage);
            ulRoot.appendChild(h4Message);
            ulRoot.style.display = 'flex';
            ulRoot.style.alignItems = 'center';
            ulRoot.style.JustifyContent = 'center';
            ulRoot.style.flexDirection = 'column';
        }
        

        
        
        const countCart = query('.header__information-count-cart');
        if (listProductFormCart.length > 0) {
            countCart.innerText = listProductFormCart.length;
            countCart.style.display = 'flex';
        }
        else {
            countCart.style.display = 'none';
        }



        btn.onclick = () => {
            headerCart.classList.toggle('active');
        }

        document.addEventListener('click', e => {
            if (e.target.className !== 'header__information-link cart' && e.target.className !== 'header__information-link-cart' && e.target.className !== 'header__information-count-cart' && e.target.className !== 'header__information-link-cart' && e.target.className.baseVal !== 'header__information-link-cart'&& e.target.className.baseVal !== '') {
                headerCart.classList.remove('active');
            }
        })
        
        headerCart.onclick = e => {
            e.stopPropagation();
        }
    },

    handleSearch() {
        const _this = this;
        const parents = queries('.data-parent');
        let arrayData = [];
        parents.forEach((parent) => {
            const idProduct = parent.querySelector('.data-id').textContent;
            const nameProductNode = parent.querySelector('.data-name').textContent;
            const sizeProduct = parent.querySelector('.data-size').textContent;
            const priceProduct = parent.querySelector('.data-price').textContent;
            const imgProduct = parent.querySelector('.data-img').textContent;
            const objectData = {
                idProduct,
                nameProductNode,
                sizeProduct,
                priceProduct,
                imgProduct,
            }
            arrayData.push(objectData);
        });

        const inputNode = query('.header__actions-search-input');
        const listSearch = query('.header__list-search');
        function handleShowResultsSearch() {
            listSearch.classList.add('active');
        }

        function handleHideResultsSearch() {
            listSearch.classList.remove('active');
        }
        inputNode.onfocus = function() {
            handleShowResultsSearch();
        }

        document.addEventListener('click', e => {
            if (e.target.className !== 'header__actions-search' && e.target.className !== 'header__list-search active' && e.target.className !=='header__actions-search-input' && e.target.className !== 'fa-solid fa-magnifying-glass search-icon') {
                handleHideResultsSearch();
            }
        });

        listSearch.addEventListener('click', e => {
            e.stopPropagation();
        })

        inputNode.oninput = function (e) {
            if ((e.target.value).startsWith(' ') || !(e.target.value).trim()) {
                const noResult = query('.header__no-result');
                noResult.style.display = 'flex';
                const listRenderProduct = query('.header__list-search-ul');
                listRenderProduct.style.display = 'none';
            }
            else {
                const searchResults = arrayData.filter((data) => {
                    const dataNameProduct = data.nameProductNode.toLowerCase();
                    return dataNameProduct.includes(e.target.value.toLowerCase());
                })
                
                if (searchResults.length > 0) {
                    const listRenderProduct = query('.header__list-search-ul');
                    const htmlSearchResult = searchResults.map((result) => {
                        switch (result.sizeProduct) {
                            case '1':
                                result.sizeProduct = '38';
                                break;
                            case '2':
                                result.sizeProduct = '39';
                                break;
                            case '3':
                                result.sizeProduct = '40';
                                break;
                            case '4':
                                result.sizeProduct = '40';
                                break;
                            default:
                                break;
                        }
                        return `
                            <li class="header__list-search-item">
                                <a href="./detail.php?id=${result.idProduct}" class="header__result-search-link">
                                    <div class="header__result-search-box-left">
                                        <div class="header__result-search-avatar">
                                            <img src="${result.imgProduct}" alt="" class="header__result-search-img">
                                        </div>
                                        <div class="header__result-search-text">
                                            <h4 class="header__result-search-name">${result.nameProductNode}</h4>
                                            <p class="header__result-search-size">Size: ${result.sizeProduct}</p>
                                        </div>
                                    </div>
                                    <div class="header__result-search-box-right">
                                        <span class="header__result-search-price">${_this.formatMoneyVND(result.priceProduct) + 'đ'}</span>
                                    </div>
                                </a>
                            </li>
                        `;
                    });
                    const noResult = query('.header__no-result');
                    noResult.style.display = 'none';
                    listRenderProduct.innerHTML = htmlSearchResult.join('');
                    listRenderProduct.style.display = 'block';

                }
                else {
                    const noResult = query('.header__no-result');
                    noResult.style.display = 'flex';
                    const listRenderProduct = query('.header__list-search-ul');
                    listRenderProduct.style.display = 'none';
                }
            }
        }
        
    }

}

header.handleShowNotification()
header.handleShowCart();
header.handleSearch();  

      