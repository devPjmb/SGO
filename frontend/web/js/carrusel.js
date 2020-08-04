$(document).ready(function(){
                carruselmarc();
                carruselnp();
            });
carruselmarc = function(){
    $('.carruselmarcas').slick({
      // lazyload:'ondemand',
      dots:true,
      infinite: true,
      arrows: false,
      slidesToShow: 4,
      slidesToScroll: 2,
      autoplay: true,
      autoplaySpeed: 2000,
      responsive: [
                    {
                      breakpoint: 1024,
                      settings: {
                        slidesToShow:4,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: true
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
  console.log('chula')
  $('.carruselnp').slick({

    dots:true,
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
                      dots: true
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