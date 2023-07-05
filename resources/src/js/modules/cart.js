import 'bootstrap/js/dist/modal'
import { $body, $bodyOverlay } from '../globals'
import CustomControl from './custom-control'
import ls from 'local-storage'


const JSON_CATEGORIES =  './?data=cats'
const JSON_MENU = './?data=menu'
const JSON_DELIVERY = './?data=delivery'
const AVAILABLETABLECODES = './?data=availabletablecode'
//

const Cart = {
  activeItem: null,
  activeItemAdditionsTotal: 0,
  activeCategory: null,
  activeAdditions: [],
  categories: null,
  menu: null,
  items: ls.get('cartItems') || [],
  deliveryPrice: 0,
  activatedelivery: false,
  activatetables: true,
  tablecode: ls.get('tablecode') || '_',
  availabletablecode:[],
  currencysymbol:$,
  orderTotal: ls.get('orderTotal') || 0,
  init: function(opts,currenttable) {
    const _ = this
    $('[data-action="open-cart-modal"]').show();
    $('[data-toggle="panel-cart"]').show();
    _.deliveryPrice= opts.deliveryPrice
    _.activatedelivery= opts.activatedelivery=="1"
    _.activatetables= opts.activatetables=="1"
    _.currencysymbol=opts.currencysymbol
    if (currenttable!='_' && currenttable!='')
    {
      _.tablecode = currenttable
      ls('tablecode', _.tablecode)
    }
    _.getData()

    _.Panel.init()
    _.Modal.init()
  },
  numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  },
  getData() {
    const _ = this

    $.getJSON(JSON_CATEGORIES, data => {
      _.categories = data
    })

    if (_.activatetables){
      var request2 = $.ajax({
        url: AVAILABLETABLECODES,
        method: "GET",
        async : false,
        dataType: "html"
      });
      request2.done(function( data ) {
        _.availabletablecode = data
      });


    }

    $.getJSON(JSON_MENU, data => {
      _.menu = data
    })

  },
  addActiveItemToCart(quantity,note) {
    const _ = this
    _.activeItem.note = note
    _.activeItem.quantity = quantity
    const item = {
      _ref: new Date().getTime(),
      ..._.activeItem
    }

    _.items.push(item)
    _.Panel.update()
    ls('cartItems', _.items)
  },
  updateActiveItemInCart(quantity,note) {
    const _ = this
    const index = _.items.findIndex(item => item._ref === _.activeItem._ref)
    _.activeItem.note = note
    _.activeItem.quantity = quantity
    _.items[index] = _.activeItem
    _.Panel.update()
    ls('cartItems', _.items)
  },
  removeItem(payload) {
    const _ = this

    const index = _.items.findIndex(item => item._ref === payload.ref)
    _.items.splice(index, 1)
    _.Panel.update()
    ls('cartItems', _.items)
  },
  setActiveAdditions($item, payload) {
    const _ = this

    if ($item.is(':checked')) {
      _.activeItemAdditionsTotal += payload.price
      _.activeAdditions.push(payload)
    } else {
      const index = _.activeAdditions.findIndex(o => o.id === payload.id)
      _.activeItemAdditionsTotal -= payload.price
      _.activeAdditions.splice(index, 1)
    }

    _.activeItem.additions = _.activeAdditions
    _.activeItem.totalPrice = _.activeItem.sizes.find(o => o.active === true).price + _.activeItemAdditionsTotal

    _.Modal.updatePrice()
  },
  setActiveSize($item, payload) {
    const _ = this

    const oldSize = _.activeItem.sizes.find(o => o.active === true)
    if (oldSize) oldSize.active = false
    const newSize = _.activeItem.sizes.find(o => o.id === payload.id)
    newSize.active = true
    _.activeItem.totalPrice = _.activeItem.totalPrice - oldSize.price + newSize.price

    _.Modal.updatePrice()
  },
  setActiveItem(id) {
    const _ = this

    if (_.Modal.mode === 'EDIT') {
      _.activeItem = _.items.find(o => o._ref === id)
    } else {
      _.activeItem = _.menu.find(o => o.id === id)
      _.activeItem.totalPrice = _.activeItem.price
    }
    _.activeCategory = _.categories.find(o => o.id === _.activeItem.categoryId)
  },
  Panel: {
    DOM: {
      $panel: $('#panel-cart'),
      $panelToggler: $('[data-toggle="panel-cart"]'),
      $headerNotification: $('.module-cart .notification'),
      $headerValue: $('.module-cart .value'),
      $details: $('.cart-details'),
      $table: $('.cart-details .cart-table'),
      $productsTotal: $('.cart-details .cart-products-total'),
      $delivery: $('.cart-details .cart-delivery'),
      $orderTotal: $('.cart-details .cart-total'),
      $empty: $('.cart-details .cart-empty'),
      $summary: $('.cart-details .cart-summary'),
      $cartdeliverycontainer: $('#cart-delivery-container'),
      $carttitle: $('.panel-cart-container .titlecaption'),
      $cartproductstotalcontainer: $('#cart-products-total-container'),
      $cartsummaryline: $('#cart-summary-line')
    },
    init() {
      const _ = this

      _.DOM.$panelToggler.on('click', function() {
        if (_.DOM.$panel.hasClass('show')) {
          _.hidePanel()
        } else {
          _.showPanel()
        }
        return false
      })
      if(Cart.activatetables)
      {
        _.DOM.$carttitle.text('Table '+Cart.tablecode)
      }
      if (_.DOM.$details.length) {
        this.update()
      }
    },
    update() {
      const _ = this

      let productsTotal = 0
      const countItems = Cart.items.length

      _.DOM.$table.html('')

      Cart.items.forEach(item => {
        productsTotal += item.totalPrice * item.quantity
        const size = item.sizes.find(o => o.active)
        const $item = $(`
          <tr>
              <td class="title">
                  <span class="name"><a href="#product-modal" data-toggle="modal">${item.name}</a></span>
              </td>
              <td class="quantity">${item.quantity}</td>
              <td class="price">${Cart.currencysymbol} ${Cart.numberWithCommas(item.totalPrice.toFixed(2))}</td>
              <td class="actions">
                  <button data-toggle="modal" class="action-icon" data-action="open-cart-modal" data-id="${item._ref}" data-edit="true"><i class="ti ti-pencil"></i></button>
                  <button class="action-icon" data-action="remove-from-cart"><i class="ti ti-close"></i></button>
              </td>
          </tr>
        `)
        $item.find('[data-action="remove-from-cart"]').on('click', function() {
          Cart.removeItem(item)
          $item.remove()
        })
        $item.appendTo(_.DOM.$table)
      })

      _.DOM.$productsTotal.text(Cart.numberWithCommas(productsTotal.toFixed(2)))
      if (_.activatedelivery){
        _.DOM.$delivery.text(Cart.numberWithCommas(parseFloat(Cart.deliveryPrice).toFixed(2)))
      } else {
        _.DOM.$cartdeliverycontainer.hide();
        _.DOM.$cartproductstotalcontainer.hide();
        _.DOM.$cartsummaryline.hide();
      }
      _.DOM.$orderTotal.text(Cart.numberWithCommas((parseFloat(Cart.deliveryPrice) + productsTotal).toFixed(2)))
      if (countItems === 0) {
        _.DOM.$headerNotification.hide()
        _.DOM.$empty.show()
        _.DOM.$summary.hide()
        _.DOM.$table.hide()
      } else {
        _.DOM.$headerNotification.show()
        _.DOM.$headerNotification.text(countItems)
        _.DOM.$empty.hide()
        _.DOM.$summary.show()
        _.DOM.$table.show()
      }

      _.DOM.$headerValue.text(Cart.numberWithCommas(productsTotal.toFixed(2)))
      ls('orderTotal', productsTotal)
    },
    showPanel() {
      const _ = this

      _.DOM.$panel.addClass('show')
      $bodyOverlay.fadeIn(400)
    },
    hidePanel() {
      const _ = this

      _.DOM.$panel.removeClass('show')
      $bodyOverlay.fadeOut(400)
    },
    handleClick(e) {
      const _ = this

      if (_.DOM.$panel.length && e.target.id == 'body-overlay') {
        _.hidePanel()
      }
    }
  },
  Modal: {
    DOM: {
      $modal: $('#product-modal'),
      $modalToggler: $('[data-action="open-cart-modal"]'),
      $addToCart: $('[data-action="add-to-cart"]'),
      $updateCart: $('[data-action="update-cart"]'),
      $details: $('#product-modal .panel-details'),
      $name: $('#product-modal .product-modal-name'),
      $ingredients: $('#product-modal .product-modal-ingredients'),
      $price: $('#product-modal .product-modal-price'),
      $sizes: $('#product-modal .panel-details-size'),
      $sizesList: $('#product-modal .product-modal-sizes'),
      $additions: $('#product-modal .panel-details-additions'),
      $additionsList: $('#product-modal .product-modal-additions'),
      $noteother: $('#product-modal #mynote'),
      $quantity:$('#product-modal #quantity')
    },
    mode: 'ADD',
    init() {
      const _ = this

      $body.on('click', '[data-action="open-cart-modal"]', function() {
        if ($(this).data('edit')) {
          _.mode = 'EDIT'
        } else {
          _.mode = 'ADD'
        }
        _.showProductModal($(this).data('id'))
      })

      _.DOM.$addToCart.on('click', function() {
        Cart.addActiveItemToCart(_.DOM.$quantity.val(),_.DOM.$noteother.val())
        _.hideProductModal()
      })

      _.DOM.$updateCart.on('click', function() {
        Cart.updateActiveItemInCart(_.DOM.$quantity.val(),_.DOM.$noteother.val())
        _.hideProductModal()
      })

      _.DOM.$modal.on('show.bs.modal', function() {
        if (_.mode === 'EDIT') {
          _.DOM.$addToCart.hide()
          _.DOM.$updateCart.show()
        } else {
          _.DOM.$addToCart.show()
          _.DOM.$updateCart.hide()
        }
        _.build()
      })

      _.DOM.$modal.on('hidden.bs.modal', function() {
        _.reset()
      })

      _.reset()
    },
    build() {
      const _ = this

      try {
        // Header
        _.DOM.$name.text(Cart.activeItem.name)
        _.DOM.$ingredients.text(Cart.activeItem.ingredients.join(', '))
        _.DOM.$price.text(Cart.numberWithCommas(Cart.activeItem.totalPrice.toFixed(2)))

        // Sizes
        if (Cart.activeItem.sizes && Cart.activeItem.sizes.length > 1) {
          _.DOM.$sizesList.html('')
          Cart.activeItem.sizes.forEach(item => {
            const $item = $(`
            <div class="form-group">
                <label class="custom-control custom-radio">
                    <input name="radio_size" value="${item.id}" type="radio" class="custom-control-input" ${item.active ? 'checked' : ''}>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">${item.name} <span>(${Cart.currencysymbol} ${Cart.numberWithCommas(item.price.toFixed(2))})</span></span>
                </label>
            </div>
          `)
            $item.find('input').on('change', function() {
              Cart.setActiveSize($(this), item)
            })
            $item.appendTo(_.DOM.$sizesList)
          })
          _.DOM.$sizes.show()
          _.DOM.$sizes.find('.collapse').addClass('show')
        } else {
          _.DOM.$sizes.hide()
        }

        // Additions
        var myadd = [];
        if (Cart.activeItem.itemadditions && Cart.activeItem.itemadditions.length >= 1)
        {
          myadd=Cart.activeItem.itemadditions;
        } else if (Cart.activeCategory.additions && Cart.activeCategory.additions.length >= 1) {
          myadd=Cart.activeCategory.additions;
        }
        if (myadd.length >= 1) {
          _.DOM.$additionsList.html('')
          myadd.forEach(item => {
            const $item = $(`
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" value="${item.id}" class="custom-control-input" ${Cart.activeItem.additions && Cart.activeItem.additions.findIndex(o => o.id === item.id) !== -1 ? 'checked' : ''}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">${item.name} <span>(${Cart.currencysymbol} ${Cart.numberWithCommas(item.price.toFixed(2))})</span></span>
                    </label>
                </div>
            </div>
          `)
            $item.find('input').on('change', function() {
              Cart.setActiveAdditions($(this), item)
            })
            $item.appendTo(_.DOM.$additionsList)
          })
          _.DOM.$additions.show()
          if (!Cart.activeItem.sizes || Cart.activeItem.sizes.length <= 1) {
            _.DOM.$additions.find('.collapse').addClass('show')
          }
        } else {
          _.DOM.$additions.hide()
        }
        if (_.mode== 'ADD')
        {
          _.DOM.$noteother.val('')
          _.DOM.$quantity.val('1')
        }
        else {
          _.DOM.$noteother.val(Cart.activeItem.note)
          _.DOM.$quantity.val(Cart.activeItem.quantity)
        }

        CustomControl.init(_.$modal)
      } catch (error) {
        console.error('[CART_MODAL] Please check a JSON data source and data-id attribute on the button.')
      }
    },
    showProductModal(id) {
      const _ = this
      Cart.setActiveItem(id)
      _.DOM.$modal.modal('show')
    },
    hideProductModal() {
      const _ = this

      _.DOM.$modal.modal('hide')
    },
    updatePrice() {
      const _ = this

      _.DOM.$price.text(Cart.numberWithCommas(Cart.activeItem.totalPrice.toFixed(2)))
    },
    reset() {
      const _ = this

      _.DOM.$details.each(function() {
        const $self = $(this)
        const $title = $self.find('.panel-details-title')
        const $content = $self.find('.panel-details-content').children()

        $self.find('.collapse').removeClass('show')
        $title.find('input').prop('checked', false)

        if (!$self.hasClass('panel-details-form')) {
          $content.html('')
        }
      })
    }
  }
}

export default Cart
