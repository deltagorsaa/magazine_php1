'use strict';
(function () {
  const changeGoodsHtml = function (newHtml, changedClassName, baseElement = 'div') {
    const newElm = document.createElement(baseElement);
    newElm.innerHTML = newHtml;
    document.getElementsByClassName(changedClassName)[0].replaceWith(newElm.querySelector(`.${changedClassName}`));
  };

  const sendFormData = async function (url, method, data, okAction, errorAction) {
    await fetch(url, {
      method: method,
      body: data
    }).then((res) => {
      if (res.status === 200) {
        okAction(res);
      } else {
        errorAction(res);
      }
    });
  };

  let filterAndSortingElements;

  const activateGoodsEvents = function () {

    filterAndSortingElements = {
      category: [...document.querySelectorAll('.filter__list .filter__list-item')],
      sort: [...document.querySelectorAll('.shop__sorting .custom-form__select')],
      filter: document.querySelector('.filter__form'),
      paginator: document.querySelectorAll('.shop__paginator.paginator .paginator__item')
    };

    filterAndSortingElements.sort.forEach((elm) => {
      elm.addEventListener('change', (evt) => {
        if([...filterAndSortingElements.sort].find((elm1) => elm1.selectedIndex === 0) == undefined) {
          filterOrSortingChangedEventHandler(evt);
        }
      });
    });

    filterAndSortingElements.paginator.forEach((elm) => {
      elm.addEventListener('click', (evt)=> {
        filterOrSortingChangedEventHandler(evt, evt.target.attributes.getNamedItem('href').value.split('?')[1]);
      });
    });

    const shopList = document.querySelector('.shop__list');
    if (shopList) {

      shopList.addEventListener('click', (evt) => {
        const prod = evt.path || (evt.composedPath && evt.composedPath());;

        if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {
          const shopOrder = document.querySelector('.shop-page__order');

          toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

          window.scroll(0, 0);

          shopOrder.classList.add('fade');
          setTimeout(() => shopOrder.classList.remove('fade'), 1000);

          const form = shopOrder.querySelector('.custom-form');
          labelHidden(form);

          toggleDelivery(shopOrder);

          const buttonOrder = shopOrder.querySelector('.button');
          const popupEnd = document.querySelector('.shop-page__popup-end');

          buttonOrder.addEventListener('click', (evt) => {
            form.noValidate = true;

            const inputs = Array.from(shopOrder.querySelectorAll('[required]'));

            inputs.forEach(inp => {

              if (!!inp.value) {

                if (inp.classList.contains('custom-form__input--error')) {
                  inp.classList.remove('custom-form__input--error');
                }

              } else {

                inp.classList.add('custom-form__input--error');

              }
            });

            if (inputs.every(inp => !!inp.value)) {
              evt.preventDefault();

              //Вот здесь будет обработчик


              toggleHidden(shopOrder, popupEnd);

              popupEnd.classList.add('fade');
              setTimeout(() => popupEnd.classList.remove('fade'), 1000);

              window.scroll(0, 0);

              const buttonEnd = popupEnd.querySelector('.button');

              buttonEnd.addEventListener('click', () => {


                popupEnd.classList.add('fade-reverse');

                setTimeout(() => {

                  popupEnd.classList.remove('fade-reverse');

                  toggleHidden(popupEnd, document.querySelector('.intro'), document.querySelector('.shop'));

                }, 1000);

              });

            } else {
              window.scroll(0, 0);
              evt.preventDefault();
            }
          });

        }
      });
    }
  };
  const activateOrderEvents = function () {
    const orderOfficeDeliveryChangedEventHandler = async function (evt) {
      evt.preventDefault();

      const okSendCallback = function(res) {
        res.text().then((text) => {
          changeGoodsHtml(text, 'shop-page__delivery__time-info', 'table');
          changeGoodsHtml(text, 'shop-page__delivery__payment-info', 'table');
          changeGoodsHtml(text, 'shop-page__delivery__delivery-time-info', 'table');
        })
      };

      const selectedOfficeId = evt.target.querySelector('option:checked').value;
      sendFormData(
          `/delivery/office/?part=yes&id=${selectedOfficeId}`,
          'GET',
          null,
          okSendCallback,
          ()=>{});
    }
    const deliveryOffices = document.querySelector('.order__delivery-offices__sorting-item .custom-form__select');
    if (deliveryOffices != null) {
      deliveryOffices.addEventListener('change', orderOfficeDeliveryChangedEventHandler);
    }
  }

  const filterOrSortingChangedEventHandler = async (evt, pageNumber) => {
    const getRangeFilterUrlPath = function () {
      let rangeFilterUrl = '';
      filterAndSortingElements.filter.querySelectorAll('.filter__wrapper .filter__range.range').forEach((elm) => {
        const slider = elm.querySelector('.range__line');
        const values = elm.querySelectorAll('.range__res-item');

        rangeFilterUrl += `&${[...values[0].classList].find((className) => className != 'min-value' && className != 'range__res-item')}=${$(slider).slider( "values", 0 )}`;
        rangeFilterUrl += `&${[...values[1].classList].find((className) => className != 'min-value' && className != 'range__res-item')}=${$(slider).slider( "values", 1 )}`;
      });

      return rangeFilterUrl;
    };
    const getCheckedFilterUrlPath = function () {
      let checkedFilterUrl = '';
      let flag = false;
      filterAndSortingElements.filter.querySelectorAll('.custom-form__group input[type="checkbox"]:checked').forEach((elm) => {
        if (!flag) {
          checkedFilterUrl = '&checked=';
          flag = true;
        }
        checkedFilterUrl += `${elm.attributes.getNamedItem('name').value}%`;
      });

      return checkedFilterUrl;
    };
    const getSortFilterUrlPath = function () {
      let sortFilterUrl = '';

      if([...filterAndSortingElements.sort].find((elm1) => elm1.selectedIndex === 0) == undefined) {
        filterAndSortingElements.sort.forEach((elm) => {
          sortFilterUrl += `&${elm.attributes.getNamedItem('name').value}=${elm.options[elm.selectedIndex].value}`;
        });
      }

      return sortFilterUrl;
    };
    const getFilterFullUrl = function (pageNumber) {
      const checkedFilterUrl = getCheckedFilterUrlPath();
      const rangeFilterUrl = getRangeFilterUrlPath();
      const sortFilterUrl = getSortFilterUrlPath();
      let url ='?part=true&' +
          (rangeFilterUrl !== '' ? `${rangeFilterUrl.substring(1)}&` : '') +
          (sortFilterUrl !== '' ? `${sortFilterUrl.substring(1)}&` : '') +
          (checkedFilterUrl !== `` ? `${checkedFilterUrl.substring(1,checkedFilterUrl.length - 1)}&` : '');

      if(typeof pageNumber === 'string'){
        url += `${pageNumber}&`;
      }

      return url.substring(0,url.length - 1);
    }

    const okSendCallback = function(res) {
      res.text().then((text) => {
        changeGoodsHtml(text, 'shop__wrapper');
        activateGoodsEvents();
      })
    };

    const errorSendCallback = function(res) {
    };
    evt.preventDefault();
    sendFormData(getFilterFullUrl(pageNumber), 'GET', null, okSendCallback, errorSendCallback);
  };

  const toggleHidden = (...fields) => {

    fields.forEach((field) => {

      if (field.hidden === true) {

        field.hidden = false;

      } else {

        field.hidden = true;

      }
    });
  };

  const labelHidden = (form) => {
    form.addEventListener('focusout', (evt) => {

      const field = evt.target;
      const label = field.nextElementSibling;

      if (field.tagName === 'INPUT' && field.value && label) {

        label.hidden = true;

      } else if (label) {

        label.hidden = false;

      }
    });
  };

  const toggleDelivery = (elem) => {

    const delivery = elem.querySelector('.js-radio');
    const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
    const deliveryNo = elem.querySelector('.shop-page__delivery--no');
    const fields = deliveryYes.querySelectorAll('.custom-form__input');

    delivery.addEventListener('change', (evt) => {

      if (evt.target.id === 'dev-no') {

        fields.forEach(inp => {
          if (inp.required === true) {
            inp.required = false;
          }
        });


        toggleHidden(deliveryYes, deliveryNo);

        deliveryNo.classList.add('fade');
        setTimeout(() => {
          deliveryNo.classList.remove('fade');
        }, 1000);

      } else {

        fields.forEach(inp => {
          if (inp.required === false) {
            inp.required = true;
          }
        });

        toggleHidden(deliveryYes, deliveryNo);

        deliveryYes.classList.add('fade');
        setTimeout(() => {
          deliveryYes.classList.remove('fade');
        }, 1000);
      }
    });
  };

  const filterWrapper = document.querySelector('.filter__list');
  if (filterWrapper) {

    filterWrapper.addEventListener('click', evt => {

      const filterList = filterWrapper.querySelectorAll('.filter__list-item');

      filterList.forEach(filter => {

        if (filter.classList.contains('active')) {

          filter.classList.remove('active');

        }

      });

      const filter = evt.target;

      filter.classList.add('active');
    });

  }

  const pageOrderList = document.querySelector('.page-order__list');
  if (pageOrderList) {

    pageOrderList.addEventListener('click', evt => {

      if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
        var path = evt.path || (evt.composedPath && evt.composedPath());
        Array.from(path).forEach(element => {

          if (element.classList && element.classList.contains('page-order__item')) {

            element.classList.toggle('order-item--active');

          }

        });

        evt.target.classList.toggle('order-item__toggle--active');

      }

      if (evt.target.classList && evt.target.classList.contains('order-item__btn')) {

        const status = evt.target.previousElementSibling;

        if (status.classList && status.classList.contains('order-item__info--no')) {
          status.textContent = 'Выполнено';
        } else {
          status.textContent = 'Не выполнено';
        }

        status.classList.toggle('order-item__info--no');
        status.classList.toggle('order-item__info--yes');

      }

    });

  }

  const checkList = (list, btn) => {

    if (list.children.length === 1) {

      btn.hidden = false;

    } else {
      btn.hidden = true;
    }

  };
  const addList = document.querySelector('.add-list');
  if (addList) {

    const form = document.querySelector('.custom-form');
    labelHidden(form);

    const addButton = addList.querySelector('.add-list__item--add');
    const addInput = addList.querySelector('#product-photo');

    checkList(addList, addButton);
    let isPhotoChanged = false;
    const changePhotoEventHandler = (evt) => {
      const template = document.createElement('LI');
      const img = document.createElement('IMG');

      template.className = 'add-list__item add-list__item--active';
      template.addEventListener('click', evt => {
        addList.removeChild(evt.target);
        addInput.value = '';
        checkList(addList, addButton);
      });

      const file = evt.target.files[0];
      const reader = new FileReader();

      reader.onload = (evt) => {
        img.src = evt.target.result;
        template.appendChild(img);
        addList.appendChild(template);
        checkList(addList, addButton);
      };

      reader.readAsDataURL(file);
      isPhotoChanged = true;
    };

    addInput.addEventListener('change', changePhotoEventHandler);

    const button = document.querySelector('.button');
    const popupEnd = document.querySelector('.page-add__popup-end');

    button.addEventListener('click', (evt) => {
      evt.preventDefault();

      const name = form.querySelector('#product-name').value ?? null;
      const price = form.querySelector('#product-price').value ?? null;
      const photo = form.querySelector('#product-photo').files[0] ?? null;
      const group = form.querySelector('.custom-form__select > option:checked').attributes.getNamedItem('value').value ?? null;
      const isNew = form.querySelector('#new:checked');
      const isSale = form.querySelector('#sale:checked');

      if (name != null && price != null && photo != null && group != null) {
        const data = new FormData();
        if (form.id != null) {
          data.append('id', form.id)
        }

        data.append('name', name);
        data.append('price', price);
        const groups = [group];
        isNew !== null ? groups.push('new') : null;
        isSale !== null ? groups.push('sale') : null;

        data.append('groups', JSON.stringify(groups));

        if (isPhotoChanged) {
          data.append('photo', photo, photo.name);
        }
        console.log(data);
        sendFormData(
            `/admin/products/${form.id != null ? 'change/' : 'add/'}`
            ,'POST'
            ,data
            ,(res) => {
              form.hidden = true;
              popupEnd.hidden = false;
            },
            ()=> {}
        )
      }
      

    })

  }

  const productsList = document.querySelector('.page-products__list');
  if (productsList) {

    productsList.addEventListener('click', evt => {

      const target = evt.target;

      if (target.classList && target.classList.contains('product-item__delete')) {
        sendFormData(
            ''
            ,'DELETE'
            ,target.parentElement.querySelector('.product-item__field.product-item__id').innerHTML
            ,(res)=>{
              productsList.removeChild(target.parentElement);
            }
            ,() => {});
      }
    });
  }

  // Generate jquery range maxmin
  document.querySelectorAll('.shop-page .filter__range.range').forEach((elm) => {
    const minElm = elm.querySelector('.range__res-item.min-value');
    const maxElm = elm.querySelector('.range__res-item.max-value');
    const minValue = parseInt(minElm.innerHTML.trim().split(' ')[0]);
    const maxValue = parseInt(maxElm.innerHTML.trim().split(' ')[0]);
    const dimension = minElm.innerHTML.trim().split(' ')[1];
    const rangeLineElm = elm.querySelector('.range__line');

    $(rangeLineElm).slider({
      min: minValue,
      max: maxValue,
      values: [minValue, maxValue],
      range: true,
      stop: function(event, ui) {
        $(minElm).text($(rangeLineElm).slider('values', 0) + ` ${dimension}`);
        $(maxElm).text($(rangeLineElm).slider('values', 1) + ` ${dimension}`);

      },
      slide: function(event, ui) {
        $(minElm).text($(rangeLineElm).slider('values', 0) + ` ${dimension}`);
        $(maxElm).text($(rangeLineElm).slider('values', 1) + ` ${dimension}`);
      }
    });
  });

  activateGoodsEvents();
  activateOrderEvents();

  if (filterAndSortingElements.filter) {
    filterAndSortingElements.filter.addEventListener('submit', filterOrSortingChangedEventHandler);
  }

  const shopOrder = document.querySelector('.shop-page__order');
  const orderCloseButton = document.querySelector('.shop-page__order__close-button');
  if (orderCloseButton){
    orderCloseButton.addEventListener('click' , () => toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder));
  }
/*
  const goodPhotoField = document.querySelector('#product-photo')
  if ( goodPhotoField!= null) {
    const src = goodPhotoField.attributes.getNamedItem('value').value;
    if (src != null) {
      console.log('xxx');
      goodPhotoField.files[0] = src;

      const evt = document.createEvent("HTMLEvents");
      evt.initEvent("change", false, true);
      goodPhotoField.dispatchEvent(evt);
    }
  }
 */
})();


