        <!-- BEGIN: lt_ie9 -->
        <p class="chromeframe">{LANG.chromeframe}</p><!-- END: lt_ie9 -->
        <!-- BEGIN: cookie_notice -->
        <div class="cookie-notice">
            <div><button data-toggle="cookie_notice_hide">&times;</button>{COOKIE_NOTICE}</div>
        </div><!-- END: cookie_notice -->
        <div id="timeoutsess" class="chromeframe">
            {LANG.timeoutsess_nouser}, <a data-toggle="timeoutsesscancel" href="#">{LANG.timeoutsess_click}</a>.
            {LANG.timeoutsess_timeout}: <span id="secField"> 60 </span> {LANG.sec}
        </div>
        <div id="openidResult" class="nv-alert" style="display:none"></div>
        <div id="openidBt" data-result="" data-redirect=""></div>
        <!-- BEGIN: crossdomain_listener -->
        <script type="text/javascript">
            function nvgSSOReciver(event) {
                if (event.origin !== '{SSO_REGISTER_ORIGIN}') {
                return false;
            }
            if (event.data == 'nv.reload') {
                location.reload();
            }
            }
            window.addEventListener('message', nvgSSOReciver, false);
        </script>
        <!-- END: crossdomain_listener -->
        <script src="{NV_STATIC_URL}themes/{TEMPLATE}/js/jquery-v371.min.js"></script>
        <script src="{NV_STATIC_URL}themes/{TEMPLATE}/js/bootstrap_petshop.js"></script>
        <script src="{NV_STATIC_URL}themes/{TEMPLATE}/js/slick.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.b-products-tabs-item a').on('click', function(event) {
                    var currentAttrValue = $(this).attr('href');

                    $(this).parent('li').addClass('b-products-tabs-item-active').siblings().removeClass(
                        'b-products-tabs-item-active');
                    $(currentAttrValue).fadeIn(1500).siblings().hide();

                    event.preventDefault();
                });
            });

            $(document).ready(function() {
                $('.b-banner-slick').slick({
                    slidesToShow: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    arrows: true,
                    prevArrow: "<button type='button' class='slick-prev'><i class='fa-solid fa-arrow-left'></i></button>",
                    nextArrow: "<button type='button' class='slick-next'><i class='fa-solid fa-arrow-right'></i></button>",
                });
            });

            $(document).ready(function() {
                $('.b-knowledges-slick').slick({
                    slidesToShow: 3,
                    arrows: false,
                    draggable: true,
                    swipeToSlide: true,
                    infinite: false,
                });
            });
            $(document).ready(function() {
                localStorage.clear();
                document.querySelectorAll('.b-card-info-atc-btn').forEach(addToCartBtn => {
                    addToCartBtn.addEventListener('click', function(event) {
                        event.preventDefault();

                        const productInfo = {
                            img: this.closest('.b-card').querySelector(
                                '.b-card-thumb-img img').getAttribute('src'),
                            id: this.closest('.b-card').querySelector(
                                '.b-card-info-title-id').innerText,
                            name: this.closest('.b-card').querySelector(
                                '.b-card-info-title-name').innerText,
                            price: this.closest('.b-card').querySelector(
                                '.b-card-info-now-price-number').innerText,
                        };

                        let productsInCart = JSON.parse(localStorage.getItem('products')) || [];

                        productsInCart.push(productInfo);

                        localStorage.setItem('products', JSON.stringify(productsInCart));
                    });
                });
            });
        </script>

        </body>

</html>