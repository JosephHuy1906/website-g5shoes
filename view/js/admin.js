const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const app = {
    tabCategory() {
        const tabs = $$('.category__item');
        const contents = $$('.js-tab-content');
        const tabsArray = Array.from(tabs);


        tabsArray.forEach((tab, index) => {
            const content = contents[index];
            tab.onclick = function () {
                $('.category__item.active').classList.remove('active');
                $('.js-tab-content.active').classList.remove('active');

                this.classList.add('active');
                content.classList.add('active');
            }
        });
    },

    // handle navigation content when click
    tabContent(tabs, contents, line) {
        const tabsNav = $$(tabs);
        const tabsContent = $$(contents);
        const tabsNavArray = Array.from(tabsNav);

        const tabLine = $(line);
        const tabIsActive = tabs + '.active';
        tabLine.style.left = $(tabIsActive).offsetLeft + 'px';
        tabLine.style.width = $(tabIsActive).offsetWidth + 'px';
        
        tabsNavArray.forEach((tab, index) => {
            const tabContent = tabsContent[index];
            tab.onclick = function () {
                const tabNavRemoveActive = tabs + '.active';
                const tabContentRemoveActive = contents + '.active';
                $(tabNavRemoveActive).classList.remove('active');
                $(tabContentRemoveActive).classList.remove('active');
                this.classList.add('active');
                tabContent.classList.add('active');
                tabLine.style.left = this.offsetLeft + 'px';
                tabLine.style.width = this.offsetWidth + 'px';
            }
        })
    },

    // handle Validator product
    validator(props) {
        const {classNameIsRequired, classNameFormError, classNameForm, classNameBtnSubmit, classNameIsPrice  } = props;
        const formElement = document.querySelector(classNameForm);
        const inputElements = formElement.querySelectorAll(classNameIsRequired);
        const btnSubmit = document.querySelector(classNameBtnSubmit);
        
        // handle Validate
        function validate (input) {
            let isError = false;
            const inputValue = input.value.trim();
            const error = input.parentElement.querySelector(classNameFormError);
            const formGroup = input.parentElement;
            const price = formElement.querySelector(classNameIsPrice);

            const priceValue = price.value;
            if (!inputValue) {
                error.innerText = 'Vui lòng nhập trường này!';
                formGroup.classList.add('error');
                isError = false;
            } else if (!isFinite(priceValue)) {
                const errorPrice = price.parentElement.querySelector(classNameFormError);
                const formGroupPrice = price.parentElement;
                errorPrice.innerText = 'Trường này phải là số!';
                formGroupPrice.classList.add('error');
                isError = false;
            } 
            else {
                error.innerText = '';
                formGroup.classList.remove('error');
                isError = true;
            }

            return isError;
        }

        if (inputElements) {
            // lặp qua để lấy từng input của form
            inputElements.forEach((input) => {
                // validate sự kiện blur
                input.onblur = () => {
                    validate(input);
                }
                // validate sự kiện onInput
                input.oninput = () => {
                    validate(input);
                }


                // đoạn code viết thêm để css input
                const inputImage = formElement.getByClassName('upload');
                const titleImage = formElement.querySelector('.file-upload');
                inputImage.onchange = () => {
                    titleImage.innerText = inputImage.value;
                }
            })

            // submit form
            btnSubmit.onclick = (e) => {
                inputElements.forEach(input => {
                    const isSusses = validate(input);
                    isSusses ? e.submit : e.preventDefault();
                    
                });
                
            }
        }
    },


    // handle click avatar user admin
    handleClickUserAdmin() {
        const btn = $('.header__admin-img');
        const tippy = $('.header__tippy');

        btn.addEventListener('click', () => {
            tippy.classList.toggle('active');
        })

        document.addEventListener('click', (e) => {
           if (e.target.className !== 'header__admin-img' && e.target.className !== 'header__tippy active') {
                tippy.classList.remove('active');
           }
        })
    },

    // handle feedback comment
    handleFeedbacks() {
        const wrapperFeedbacks = $$('.feedback-wrapper');
        
        wrapperFeedbacks.forEach((feedback) => {
            const btnFeedback = feedback.querySelector('.feedback-wrapper-content-actions');
            const icons = feedback.querySelectorAll('.feedback-wrapper-content-actions-icon');
            const formFeedback = feedback.querySelector('.form-feedback');
            const contentFeedback = feedback.querySelector('.form-feedback-text');

            btnFeedback.onclick = () => {
                icons.forEach((icon) => {
                    icon.classList.toggle('active');
                })
                formFeedback.classList.toggle('active');
                contentFeedback.focus();
            }

            //validate form feedback action 
            function validateFormFeedback() {
                const contentValue = contentFeedback.value.trim();
                const message = formFeedback.querySelector('.form-feedback-message');
                const errorMessage = formFeedback.querySelector('.form-feedback-error')
                let flag = false;
                if (!contentValue) {
                    message.classList.add('active');
                    errorMessage.innerText = 'Không thể gửi, vui lòng nhập phản hồi của bạn!';
                    contentFeedback.focus();
                    flag = false;
                }
                else {
                    message.classList.remove('active');
                    errorMessage.innerText = '';
                    flag = true;
                }

                return flag;
            }

            contentFeedback.oninput = () => {
                validateFormFeedback();
            }

            formFeedback.onsubmit = (e) => {
               const isSuccess = validateFormFeedback()
               isSuccess ? e.submit : e.preventDefault();
            }

        })
    },


    // handle modal
    handleModal() {
        const btnShowModal = $('.js-btn-modal');
        const modalProfile = $('.modal-profile');
        const btnCloseModal = $('.modal-wrapper-close');
        const authModal = $('.modal-wrapper');
        function handleShowModal() {
            modalProfile.classList.add('active');
        }

        function handleHideModal() {
            modalProfile.classList.remove('active');
        }

        btnShowModal.addEventListener('click', handleShowModal);
        btnCloseModal.addEventListener('click', handleHideModal);
        modalProfile.addEventListener('click', handleHideModal);
        authModal.addEventListener('click', e => {
            e.stopPropagation();
        })
    },


    // handle validate modal
    handleValidateModal() {
        const formId = $('#form-profile');
        const inputs = formId.querySelectorAll('.form-modal-input');
        
        
        function validate(input) {
            const inputValue = input.value.trim();
            const errorMessage = input.parentElement.querySelector('.form-modal-error');
            let flag = false;
            if (!inputValue) {
                errorMessage.innerText = 'Vui lòng nhập trường này!';
                flag = false;
            } else if (input.classList.contains('js-modal-password')) {
                const inputPassword = input.parentElement.querySelector('.js-modal-password');  
                if (inputPassword.value.length < 8) {
                    errorMessage.innerText = 'Vui lòng nhập mật khẩu tối thiểu 8 ký tự';
                    flag = false;
                } else {
                    errorMessage.innerText = '';
                    flag = true;
                }
                
            } else if (input.classList.contains('js-modal-enter-password')) {
                const inputPassword = formId.querySelector('.js-modal-password');
                if (inputPassword.value !== input.value) {
                    errorMessage.innerText = 'Mật khẩu không trùng khớp, xin vui lòng nhập lại';
                    flag = false;
                } else {
                    errorMessage.innerText = '';
                    flag = true;
                }
            }
            else {
                errorMessage.innerText = '';
                flag = true;
            }

            return flag;
        }

        inputs.forEach((input) => {

            input.onchange = () => {
                validate(input);
            }

            input.oninput = () => {
                validate(input);
            }

        });

        const inputImage = formId.querySelector('.input-modal-file');
        const titleInputFile = formId.querySelector('.sticker-file');
        inputImage.oninput = () => {
            if (inputImage.value.trim()) {
                titleInputFile.innerText = inputImage.value;
            }
        }

        formId.onsubmit = e => {
            inputs.forEach((input) => {
                const isSuccess = validate(input);
                isSuccess ? e.submit : e.preventDefault();
            })
            
        }
    },

    handleEditProduct() {
        const parents = $$('.product-items');
        Array.from(parents).forEach(parent => {
            const btnEdit = parent.querySelector('.edit-each-product');
            const modalEdit = parent.querySelector('.modal__edit-product');
            const btnCloseModal = parent.querySelector('.modal__edit-product-close');
            const authFormModal = parent.querySelector('.modal__edit-auth');

            function handleShowModal() {
                modalEdit.classList.add('active');
                
            }
            
            function handleHideModal() {
                modalEdit.classList.remove('active');
            }
            
            btnEdit.addEventListener('click', () => {
                handleShowModal();
            });
            btnCloseModal.addEventListener('click', handleHideModal);
            modalEdit.addEventListener('click', handleHideModal);
            authFormModal.addEventListener('click', e => e.stopPropagation());
            

            // handle change input
            function handleChangeInput() {
                const formGroups = $$('.form-group-edit');
                Array.from(formGroups).forEach((formGroup, index) => {
                    const btnEditInput = formGroup.querySelector('.form-group-edit-btn-edit');
                    const inputEdit = formGroup.querySelector('.form-group-edit-input');
                    btnEditInput.onclick = (e) => {
                        inputEdit.attributes.value.nodeValue = '';
                        inputEdit.focus();
                        inputEdit.style.pointerEvents = 'unset';
                    }
                })
            }

            // handle Validate form
            function handleValidateForm() {
                const formModal = parent.querySelector('.form__edit-product');
                const btnSubmit = formModal.querySelector('.form-group-actions-btn.submit')
                const btnCancel = formModal.querySelector('.form-group-actions-btn.cancel');
                
                
                const labelInputFileTitle = formModal.querySelector('.form-group-content-sticker-file-title');
                const inputFileImage = formModal.querySelector('.edit-input-file');
                const imageOld = parent.querySelector('.modal__edit-img');
                btnSubmit.classList.add('default');
                labelInputFileTitle.innerText = imageOld.attributes.src.nodeValue;
                inputFileImage.onchange = e => {
                    labelInputFileTitle.innerText = e.target.value;
                }
                
                
                btnCancel.addEventListener('click', e => {
                    e.preventDefault();
                    handleHideModal();
                });
                
                const inputs = formModal.querySelectorAll('.form-group-edit-input');
                function handleValidate(input, value) {
                const inputValue = value.trim();
                    const errorMessage = input.parentElement.querySelector('.form-group-edit-error');
                    let isSuccess = false;
                    if (!inputValue) {
                        errorMessage.innerText = 'Vui lòng nhập trường này!';
                        input.classList.add('error');
                        isSuccess = false;
                        btnSubmit.classList.add('default');
                    }
                    else {
                        errorMessage.innerText = '';
                        input.classList.remove('error');
                        btnSubmit.classList.remove('default');
                        isSuccess = true;
                    }
                    return isSuccess;
                }

                Array.from(inputs).forEach((input) => {
                    input.onblur = e => {
                        handleValidate(input, e.target.value);
                    }

                    input.oninput = e => {
                        handleValidate(input, e.target.value);
                    }
                });

                formModal.onsubmit = e => {
                    Array.from(inputs).forEach((input) => {
                        const isSuccess = handleValidate(input, input.value);
                        isSuccess ? e.submit : e.preventDefault();
                    })
                }
            }

            
            
            handleChangeInput();
            handleValidateForm();

        })
    
    },
    handleFormBill() {
        const parents = $$('.js-tab-bill');
        Array.from(parents).forEach(parent => {
            const btnAction = parent.querySelector('.bill-all__actions-btn');
            const contentForm = parent.querySelector('.form__bill-wrapper')
            btnAction.onclick = () => {
                contentForm.classList.toggle('active');
            }
        })
        
    }
}

    

app.tabCategory();
app.tabContent('.content__nav-item', '.manage-content-tab', '.nav__line');
app.tabContent('.content__nav-comment-item', '.manage-content-comment-tab', '.nav__line-comment');
app.tabContent('.content__nav-account-item', '.manage-content-account-tab', '.nav__line-account');
app.tabContent('.content__nav-category-item', '.manage-content-category-tab', '.nav__line-category');
app.tabContent('.content__nav-bill-item', '.manage-content-bill-tab', '.nav__line-bill');
app.validator({
    // form
    classNameForm: '#form-add-product',

    // rule
    classNameIsRequired: '.form-group__input',
    classNameIsPrice: '.form-group__input.isPrice',
    // error:
    classNameFormError: '.form-group__error',
    // action submit
    classNameBtnSubmit: '.btn-submit'
});

app.handleClickUserAdmin();
app.handleFeedbacks();
app.handleModal();
app.handleValidateModal();
app.handleEditProduct();
app.handleFormBill();
// hoàn thành!!!;