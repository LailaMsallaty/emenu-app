import 'jquery-validation'
import ls from 'local-storage'

const Forms = {
  init() {
    const _ = this

    _.Booking.init()
    _.Order.init()
    _.Newsletter.init()
    _.Validation.init()
  },
  Order: {
    $el: $('#order-submit'),
    init() {
      const _ = this

      if (_.$el.length > 0) {
        _.$el.on('click', function()  {

          if (true) {
            _.$el.prop('disabled', true)
            _.$el.addClass('loading')
            var formdata = {}
            var haserror = false
            $('.orderforminput').each(function(i, obj) {
                if (_.validate($('.orderforminput')[i]))
                {
                  formdata[$( this ).attr('id')]=$( this ).val();
                }
                else {
                  haserror=true
                  _.$el.prop('disabled', false)
                  return false;
                }
            });
            if (haserror)
            {
              _.$el.prop('disabled', false)
              return false
            }
            formdata.order = ls.get('cartItems')
            formdata.total = ls.get('orderTotal')
            formdata.op = 'placeorder'
            var url =  _.$el.data("url");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
              url: url,
              type: 'POST',
              data: formdata,
              error: function(err) {
                console.log(err);
                setTimeout(function() {
                  _.$el.addClass('error')
                }, 1200)
              },
              success: function(data) {
                try {
                  var obj = JSON.parse(data);
                  if (obj.result=='success')
                  {
                    ls.clear();
                    window.location.replace(obj.redirect);
                  } else {
                    if ('redirect' in obj)
                    {
                      ls.clear();
                      window.location.replace(obj.redirect);
                    } else {
                      _.$el.prop('disabled', false)
                      alert(obj.msg);
                    }

                  }
                } catch (e) {
                  _.$el.prop('disabled', false)
                  alert('Unexpected error');
                }
              },
              complete: function(data) {
                setTimeout(function() {
                  $btn.prop('disabled', false)
                  $btn.removeClass('loading error')
                }, 6000)
              }
            })
            return false
          }
          return false
        })
      }
    },
    validate(obj){
      if (obj.hasAttribute('required') && $(obj).val().trim()=='')
      {
        $(obj).addClass('error');
        return false;
      } if($(obj).attr('type')=='email' && $(obj).val().trim()!=''){
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!re.test(String($(obj).val().trim()).toLowerCase()))
        {
          return false;
        }
      }
      $(obj).removeClass('error');
      return true;
    }
  },
  Booking: {
    $el: $('.booking-form'),
    init() {
      const _ = this

      if (_.$el.length > 0) {
        _.$el.submit(function() {
          const $btn = $(this).find('.btn-submit')
          const $form = $(this)

          if ($form.valid()) {
            $btn.addClass('loading')
            $.ajax({
              type: 'POST',
              url: './php/booking-form.php',
              data: $form.serialize(),
              error: function(err) {
                setTimeout(function() {
                  $btn.addClass('error')
                }, 1200)
              },
              success: function(data) {
                if (data != 'success') {
                  $btn.addClass('error')
                } else {
                  $btn.addClass('success')
                }
              },
              complete: function(data) {
                setTimeout(function() {
                  $btn.removeClass('loading error success')
                }, 6000)
              }
            })
            return false
          }
          return false
        })
      }
    }
  },
  Newsletter: {
    $el: $('.sign-up-form'),
    init() {
      const _ = this

      if (_.$el.length > 0) {
        _.$el.submit(function() {
          const $btn = $(this).find('.btn-submit')
          const $form = $(this)

          if ($form.valid()) {
            $btn.addClass('loading')
            $.ajax({
              type: $form.attr('method'),
              url: $form.attr('action'),
              data: $form.serialize(),
              cache: false,
              dataType: 'jsonp',
              jsonp: 'c',
              contentType: 'application/json; charset=utf-8',
              error: function(err) {
                setTimeout(function() {
                  $btn.addClass('error')
                }, 1200)
              },
              success: function(data) {
                if (data.result != 'success') {
                  $btn.addClass('error')
                } else {
                  $btn.addClass('success')
                }
              },
              complete: function(data) {
                setTimeout(function() {
                  $btn.removeClass('loading error success')
                }, 6000)
              }
            })
            return false
          }
          return false
        })
      }
    }
  },
  Validation: {
    $el: $('[data-validate], .validate-form'),
    init() {
      const _ = this

      if (_.$el.length) {
        _.$el.each(function() {
          $(this).validate({
            validClass: 'valid',
            errorClass: 'error',
            onfocusout: function(element, event) {
              $(element).valid()
            },
            errorPlacement: function(error, element) {
              return true
            },
            rules: {
              email: {
                required: true,
                email: true
              }
            }
          })
        })
      }
    }
  }
}

export default Forms
