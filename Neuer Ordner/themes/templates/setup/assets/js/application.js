// NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
// IT'S ALL JUST JUNK FOR OUR DOCS!
// ++++++++++++++++++++++++++++++++++++++++++

!function ($) {

  $(function(){

    var $window = $(window)
    var $body   = $(document.body)

    var navHeight = $('.navbar').outerHeight(true) + 10

    $body.scrollspy({
      target: '.bs-sidebar',
      offset: navHeight
    })

    $window.on('load', function () {
      $body.scrollspy('refresh')
    })

    $('.bs-docs-container [href=#]').click(function (e) {
      e.preventDefault()
    })

    // back to top
    setTimeout(function () {
      var $sideBar = $('.bs-sidebar')

      $sideBar.affix({
        offset: {
          top: function () {
            var offsetTop      = $sideBar.offset().top
            var sideBarMargin  = parseInt($sideBar.children(0).css('margin-top'), 10)
            var navOuterHeight = $('.bs-docs-nav').height()

            return (this.top = offsetTop - navOuterHeight - sideBarMargin)
          }
        , bottom: function () {
            return (this.bottom = $('.bs-footer').outerHeight(true))
          }
        }
      })
    }, 100)

    setTimeout(function () {
      $('.bs-top').affix()
    }, 100)

    // tooltip demo
    $('.tooltip-demo').tooltip({
      selector: "[data-toggle=tooltip]",
      container: "body"
    })

    $('.tooltip-test').tooltip()
    $('.popover-test').popover()

    $('.bs-docs-navbar').tooltip({
      selector: "a[data-toggle=tooltip]",
      container: ".bs-docs-navbar .nav"
    })

    // popover demo
    $("[data-toggle=popover]")
      .popover()

    // button state demo
    $('#fat-btn')
      .click(function () {
        var btn = $(this)
        btn.button('loading')
        setTimeout(function () {
          btn.button('reset')
        }, 3000)
      })

    // carousel demo
    $('.bs-docs-carousel-example').carousel()



    $('input.pretty').prettyCheckable();
    $('.selectpicker').selectpicker();
    $('tbody.rowlink').rowlink();
    $('input#defaultconfig').maxlength();
    $('input#thresholdconfig').maxlength({
       threshold: 20
    });
    $('input#moreoptions').maxlength({
      alwaysShow: true,
      warningClass: "label label-success",
      limitReachedClass: "label label-important"
    });
    $('input#alloptions').maxlength({
      alwaysShow: true,
      warningClass: "label label-success",
      limitReachedClass: "label label-important",
      separator: ' of ',
      preText: 'You have ',
      postText: ' chars remaining.',
      validate: true
    });
    $('textarea#textarea').maxlength({
        alwaysShow: true
    });
    $('input#placement').maxlength({
      alwaysShow: true,
      placement: 'top-left'
    });

    $('.flickr-gallery').each(function(){
      $(this).jflickrfeed({
        limit: 12,
        qstrings: {
            id: $(this).data('flickr-id')
        },
        itemTemplate: '<li><a href="{{image_b}}"><img alt="{{title}}" src="{{image_s}}" /></a></li>'
      });
    });


    $('.gmap').each(function(){
      var d = $(this).data('markers').split(';'),
          m = [];
      for(a in d) { m.push({'address' : d[a]}) }
      $(this).gMap({
        zoom: $(this).data('zoom'),
        markers: m
      });
    });

    $('.date').datepicker();   
    $('.colorpicker').colorpicker();
    $('.colorpickerbtn').colorpicker().on('changeColor', function(ev){
       $(this)[0].style.background = ev.color.toHex();
    });
    
})

}(window.jQuery)
