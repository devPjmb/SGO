$(document).ready(function(){
                carruselprincipal();
                carruselmarc();
                carruselnp();
                funcioncambio();
            });
carruselprincipal = function()
{
  $('.carruselprincipal').slick(
    {
      dots: true,
      infinite: true,
      arrows: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      responsive: [
                    {
                      breakpoint: 1024,
                      settings: {
                        slidesToShow:1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots:true
                      }
                    },
                    {
                      breakpoint: 600,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots:true
                      }
                    },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots:true
                      }
                    }
                  ]
  })
};
carruselmarc = function(){
    $('.carruselmarcas').slick({
      // lazyload:'ondemand',
      infinite: true,
      arrows: false,
      slidesToShow: 3,
      slidesToScroll: 2,
      autoplay: true,
      autoplaySpeed: 2000,
      responsive: [
                    {
                      breakpoint: 1024,
                      settings: {
                        slidesToShow:3,
                        slidesToScroll: 2,
                        infinite: true,
                      }
                    },
                    {
                      breakpoint: 600,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                      }
                    },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                      }
                    }
                  ]
    })
};
carruselnp = function()
{
  $('.carruselnp').slick({
    infinite: true,
    arrows: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    // autoplay: true,
    autoplaySpeed: 2000,
    responsive: [
                  {
                    breakpoint: 992,
                    settings: {
                      slidesToShow:1,
                      slidesToScroll: 1,
                      infinite: true,
                    }
                  },
                  {
                    breakpoint: 600,
                    settings: {
                      slidesToShow: 1,
                      slidesToScroll: 1
                    }
                  },
                  {
                    breakpoint: 480,
                    settings: {
                      slidesToShow: 1,
                      slidesToScroll: 1
                    }
                  }
                ]
  })
};
funcioncambio = function(a)
{
  if ($(window).width() < 993)
  {
      switch(a)
      {
        case '_fresh':
          $('#id-item1').addClass('show-on-medium-and-down');
          $('#id-item2').addClass('hide')
          $('#id-item1').removeClass('hide')
          break;
        case '_retail':
          $('#id-item1').addClass('hide');
          $('#id-item2').addClass('show-on-medium-and-down')
          $('#id-item2').removeClass('hide')
          break;
        case '_spMark':
          $('#id-item1').addClass('show-on-medium-and-down');
          $('#id-item2').addClass('hide')
          $('#id-item1').removeClass('hide')
          break;
        case '_mark':
          $('#id-item1').addClass('show-on-medium-and-down');
          $('#id-item2').addClass('hide')
          $('#id-item1').removeClass('hide')
          break;
      }
  }
};