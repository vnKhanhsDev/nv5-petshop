<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/default/css/home.css">
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/default/css/style-custom.css">
<div class="main">
    <div class="b-banner-wrap">
        <div class="b-banner b-slick b-banner-slick">
            <div class="b-banner-item">
                <img src="./themes/default/images/baner-1.png" alt="">
            </div>
            <div class="b-banner-item">
                <img src="./themes/default/images/baner-2.png" alt="">
            </div>
            <div class="b-banner-item">
                <img src="./themes/default/images/baner-3.png" alt="">
            </div>
        </div>
    </div>

    <div class="b-products-wrap">
        <div class="container">
            <div class="b-products-title">new items</div>
            <div class="b-products">
                <div class="b-products-tabs-wrap">
                    <ul class="b-products-tabs">
                        <li class="b-products-tabs-item js-products-tab--new b-products-tabs-item-active"><a href="#b-products-tabs__list-item--new-1">thú cưng</a></li>
                        <li class="b-products-tabs-item js-products-tab--new"><a href="#b-products-tabs__list-item--new-2">phụ kiện</a></li>
                        <li class="b-products-tabs-item js-products-tab--new"><a href="#b-products-tabs__list-item--new-3">dịch vụ</a></li>
                    </ul>
                </div>
                <ul class="b-products-tabs__list-wrap">
                    <li class="b-products-tabs__list-item b-products-tabs__list-item-active" id="b-products-tabs__list-item--new-1">
                        <div class="row">
                        <!-- BEGIN: pet -->
                            <div class="col-3">
                                <div class="b-card b-card-pet">
                                    <div class="b-card-thumb">
                                        <a href="#" class="b-card-thumb-img">
                                            <img src="{PET.image}" alt="product">
                                            <div class="b-card-thumb-img-overlay"></div>
                                        </a>
                                        <ul class="b-card-thumb-badge-wrap">
                                            <li class="b-card-thumb-badge b-card-thumb-badge--top b-hidden">top</li>
                                            <li class="b-card-thumb-badge b-card-thumb-badge--new b-hidden">new</li>
                                            <li class="b-card-thumb-badge b-card-thumb-badge--sale">-{PET.discount}%</li>
                                            <li class="b-card-thumb-badge b-card-thumb-badge--oos b-hidden">oos</li>
                                        </ul>
                                        <div class="b-card-thumb-extra-link-wrap">
                                            <a href="#" class="b-card-thumb-extra-link">
                                                <i class="fa-regular fa-heart"></i>
                                                <span class="b-card-thumb-extra-link-text">yêu thích</span>
                                            </a>
                                            <a href="#" class="b-card-thumb-extra-link">
                                                <i class="fa-regular fa-magnifying-glass"></i>
                                                <span class="b-card-thumb-extra-link-text">xem thêm</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="b-card-info">
                                        <a href="./pages/product-detail.html" class="b-card-info-title">
                                            <p class="b-card-info-title-id">TC{PET.id}</p><span> - </span><p class="b-card-info-title-name">{PET.name}</p>
                                        </a>
                                        <div class="b-card-info-short-desc-wrap">
                                            <p class="b-card-info-short-desc">Giới tính: <span>{PET.gender}</span></p>
                                            <i class="fa-solid fa-circle-small"></i>
                                            <p class="b-card-info-short-desc">Tuổi: <span>{PET.age}</span></p>
                                        </div>
                                        <div class="b-card-info-star-rating">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                        <div class="b-card-info-price">
                                            <div class="b-card-info-original-price"><p class="b-card-info-original-price-number">{PET.price}</p><span class="b-card-info-price-currency">đ</span></div>
                                            <div class="b-card-info-now-price"><p class="b-card-info-now-price-number">{PET.price_discount}</p><span class="b-card-info-price-currency">đ</span></div>
                                        </div>
                                        <button class="b-card-info-atc-btn">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            <span class="b-card-info-atc-btn-text">thêm vào giỏ hàng</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <!-- END: pet -->
                        </div>
                    </li>
                    <li class="b-products-tabs__list-item" id="b-products-tabs__list-item--new-2">
                        <div class="row">
                        <!-- BEGIN: accessory -->
                            <div class="col-3">
                                <div class="b-card b-card-pet">
                                    <div class="b-card-thumb">
                                        <a href="#" class="b-card-thumb-img">
                                            <img src="{ACCESSORY.image}" alt="product">
                                            <div class="b-card-thumb-img-overlay"></div>
                                        </a>
                                        <ul class="b-card-thumb-badge-wrap">
                                            <li class="b-card-thumb-badge b-card-thumb-badge--top b-hidden">top</li>
                                            <li class="b-card-thumb-badge b-card-thumb-badge--new b-hidden">new</li>
                                            <li class="b-card-thumb-badge b-card-thumb-badge--sale">-{ACCESSORY.discount}%</li>
                                            <li class="b-card-thumb-badge b-card-thumb-badge--oos b-hidden">oos</li>
                                        </ul>
                                        <div class="b-card-thumb-extra-link-wrap">
                                            <a href="#" class="b-card-thumb-extra-link">
                                                <i class="fa-regular fa-heart"></i>
                                                <span class="b-card-thumb-extra-link-text">yêu thích</span>
                                            </a>
                                            <a href="#" class="b-card-thumb-extra-link">
                                                <i class="fa-regular fa-magnifying-glass"></i>
                                                <span class="b-card-thumb-extra-link-text">xem thêm</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="b-card-info">
                                        <a href="./pages/product-detail.html" class="b-card-info-title">
                                            <p class="b-card-info-title-id">SP{ACCESSORY.id}</p><span> - </span><p class="b-card-info-title-name">{ACCESSORY.name}</p>
                                        </a>
                                        <div class="b-card-info-short-desc-wrap">
                                            <p class="b-card-info-short-desc">Màu sắc: <span>{ACCESSORY.color}</span></p>
                                            <i class="fa-solid fa-circle-small"></i>
                                            <p class="b-card-info-short-desc">Kích cỡ: <span>{ACCESSORY.size}</span></p>
                                        </div>
                                        <div class="b-card-info-star-rating">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                        <div class="b-card-info-price">
                                            <div class="b-card-info-original-price"><p class="b-card-info-original-price-number">{ACCESSORY.price}</p><span class="b-card-info-price-currency">đ</span></div>
                                            <div class="b-card-info-now-price"><p class="b-card-info-now-price-number">{ACCESSORY.price_discount}</p><span class="b-card-info-price-currency">đ</span></div>
                                        </div>
                                        <button class="b-card-info-atc-btn">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            <span class="b-card-info-atc-btn-text">thêm vào giỏ hàng</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <!-- END: accessory -->
                        </div>
                    </li>
                    <li class="b-products-tabs__list-item" id="b-products-tabs__list-item--new-3">
                        <div class="row">
                        <!-- BEGIN: service -->
                                <div class="col-3">
                                <div class="b-card b-card-pet">
                                    <div class="b-card-thumb">
                                        <a href="#" class="b-card-thumb-img">
                                            <img src="{SERVICE.image}" alt="product">
                                            <div class="b-card-thumb-img-overlay"></div>
                                        </a>
                                        <ul class="b-card-thumb-badge-wrap">
                                            <li class="b-card-thumb-badge b-card-thumb-badge--top b-hidden">top</li>
                                            <li class="b-card-thumb-badge b-card-thumb-badge--new b-hidden">new</li>
                                            <li class="b-card-thumb-badge b-card-thumb-badge--sale">-{SERVICE.discount}%</li>
                                            <li class="b-card-thumb-badge b-card-thumb-badge--oos b-hidden">oos</li>
                                        </ul>
                                        <div class="b-card-thumb-extra-link-wrap">
                                            <a href="#" class="b-card-thumb-extra-link">
                                                <i class="fa-regular fa-heart"></i>
                                                <span class="b-card-thumb-extra-link-text">yêu thích</span>
                                            </a>
                                            <a href="#" class="b-card-thumb-extra-link">
                                                <i class="fa-regular fa-magnifying-glass"></i>
                                                <span class="b-card-thumb-extra-link-text">xem thêm</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="b-card-info">
                                        <a href="./pages/product-detail.html" class="b-card-info-title">
                                            <p class="b-card-info-title-id">DV{SERVICE.id}</p><span> - </span><p class="b-card-info-title-name">{SERVICE.name}</p>
                                        </a>
                                        <div class="b-card-info-short-desc-wrap">
                                            <p class="b-card-info-short-desc">Thời gian: <span>{SERVICE.estimated_time} phút</span></p>
                                            <i class="fa-solid fa-circle-small"></i>
                                            <p class="b-card-info-short-desc">Đặt trước:<span>{SERVICE.requires_appointment_text}</span></p>
                                        </div>
                                        <div class="b-card-info-star-rating">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                        <div class="b-card-info-price">
                                            <div class="b-card-info-original-price"><p class="b-card-info-original-price-number">{SERVICE.price}</p><span class="b-card-info-price-currency">đ</span></div>
                                            <div class="b-card-info-now-price"><p class="b-card-info-now-price-number">{SERVICE.price_discount}</p><span class="b-card-info-price-currency">đ</span></div>
                                        </div>
                                        <button class="b-card-info-atc-btn">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            <span class="b-card-info-atc-btn-text">thêm vào giỏ hàng</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <!-- END: service -->
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="b-discoverUs-wrap">
        <div class="container">
             <div class="b-discoverUs">
                <div class="b-discoverUs-img">
                    <img src="./themes/default/images/discoverUs.png" alt="Discover">
                </div>
                <div class="b-discoverUs-detail">
                    <div class="b-discoverUs-title">beso pet shop</div>
                    <div class="b-discoverUs-sub-title">lý do bạn nên chọn chúng tôi!</div>
                    <p class="b-discoverUs-short-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo, asperiores reiciendis distinctio officiis amet nisi nulla debitis voluptates, rerum tenetur dolores! Iure in aspernatur esse?</p>
                    <div class="b-discoverUs-button-list">
                        <a href="#" class="b-btn b-btn-line">xem video <i class="fa-regular fa-circle-play"></i></a>
                        <a href="#" class="b-btn">Khám phá <i class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="b-products-wrap">
        <div class="container">
            <div class="b-products-title">bestsellers</div>
            <div class="b-products">
                <div class="b-products-tabs-wrap">
                    <ul class="b-products-tabs">
                        <li class="b-products-tabs-item b-products-tabs-item-active"><a href="#b-products-tabs__list-item--bestsellers-1">sản phẩm</a></li>
                        <li class="b-products-tabs-item"><a href="#b-products-tabs__list-item--bestsellers-2">dịch vụ</a></li>
                    </ul>
                </div>
                <ul class="b-products-tabs__list-wrap">
                    <li class="b-products-tabs__list-item b-products-tabs__list-item-active" id="b-products-tabs__list-item--bestsellers-1">
                        <div class="row">
                            <!-- BEGIN: hotPet -->
                                <div class="col-3">
                                    <div class="b-card b-card-pet">
                                        <div class="b-card-thumb">
                                            <a href="#" class="b-card-thumb-img">
                                                <img src="{HOT_PET.image}" alt="product">
                                                <div class="b-card-thumb-img-overlay"></div>
                                            </a>
                                            <ul class="b-card-thumb-badge-wrap">
                                                <li class="b-card-thumb-badge b-card-thumb-badge--top b-hidden">top</li>
                                                <li class="b-card-thumb-badge b-card-thumb-badge--new b-hidden">new</li>
                                                <li class="b-card-thumb-badge b-card-thumb-badge--sale">-{HOT_PET.discount}%</li>
                                                <li class="b-card-thumb-badge b-card-thumb-badge--oos b-hidden">oos</li>
                                            </ul>
                                            <div class="b-card-thumb-extra-link-wrap">
                                                <a href="#" class="b-card-thumb-extra-link">
                                                    <i class="fa-regular fa-heart"></i>
                                                    <span class="b-card-thumb-extra-link-text">yêu thích</span>
                                                </a>
                                                <a href="#" class="b-card-thumb-extra-link">
                                                    <i class="fa-regular fa-magnifying-glass"></i>
                                                    <span class="b-card-thumb-extra-link-text">xem thêm</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="b-card-info">
                                            <a href="./pages/product-detail.html" class="b-card-info-title">
                                                <p class="b-card-info-title-id">TC{HOT_PET.id}</p><span> - </span><p class="b-card-info-title-name">{HOT_PET.name}</p>
                                            </a>
                                            <div class="b-card-info-short-desc-wrap">
                                                <p class="b-card-info-short-desc">Giới tính: <span>{HOT_PET.gender}</span></p>
                                                <i class="fa-solid fa-circle-small"></i>
                                                <p class="b-card-info-short-desc">Tuổi: <span>{HOT_PET.age}</span></p>
                                            </div>
                                            <div class="b-card-info-star-rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <div class="b-card-info-price">
                                                <div class="b-card-info-original-price"><p class="b-card-info-original-price-number">{HOT_PET.price}</p><span class="b-card-info-price-currency">đ</span></div>
                                                <div class="b-card-info-now-price"><p class="b-card-info-now-price-number">{HOT_PET.price_discount}</p><span class="b-card-info-price-currency">đ</span></div>
                                            </div>
                                            <button class="b-card-info-atc-btn">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                                <span class="b-card-info-atc-btn-text">thêm vào giỏ hàng</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <!-- END: hotPet -->
                        </div>
                    </li>
                    <li class="b-products-tabs__list-item" id="b-products-tabs__list-item--bestsellers-2">
                        <div class="row">
                            <!-- BEGIN: hotService -->
                            <div class="col-3">
                                <div class="b-card b-card-pet">
                                    <div class="b-card-thumb">
                                        <a href="#" class="b-card-thumb-img">
                                            <img src="{HOT_SERVICE.image}" alt="product">
                                            <div class="b-card-thumb-img-overlay"></div>
                                        </a>
                                        <ul class="b-card-thumb-badge-wrap">
                                            <li class="b-card-thumb-badge b-card-thumb-badge--top b-hidden">top</li>
                                            <li class="b-card-thumb-badge b-card-thumb-badge--new b-hidden">new</li>
                                            <li class="b-card-thumb-badge b-card-thumb-badge--sale">-{HOT_SERVICE.discount}%</li>
                                            <li class="b-card-thumb-badge b-card-thumb-badge--oos b-hidden">oos</li>
                                        </ul>
                                        <div class="b-card-thumb-extra-link-wrap">
                                            <a href="#" class="b-card-thumb-extra-link">
                                                <i class="fa-regular fa-heart"></i>
                                                <span class="b-card-thumb-extra-link-text">yêu thích</span>
                                            </a>
                                            <a href="#" class="b-card-thumb-extra-link">
                                                <i class="fa-regular fa-magnifying-glass"></i>
                                                <span class="b-card-thumb-extra-link-text">xem thêm</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="b-card-info">
                                        <a href="./pages/product-detail.html" class="b-card-info-title">
                                            <p class="b-card-info-title-id">DV{HOT_SERVICE.id}</p><span> - </span><p class="b-card-info-title-name">{HOT_SERVICE.name}</p>
                                        </a>
                                        <div class="b-card-info-short-desc-wrap">
                                            <p class="b-card-info-short-desc">Thời gian: <span>{HOT_SERVICE.estimated_time} phút</span></p>
                                            <i class="fa-solid fa-circle-small"></i>
                                            <p class="b-card-info-short-desc">Đặt trước:<span>{HOT_SERVICE.requires_appointment_text}</span></p>
                                        </div>
                                        <div class="b-card-info-star-rating">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                        <div class="b-card-info-price">
                                            <div class="b-card-info-original-price"><p class="b-card-info-original-price-number">{HOT_SERVICE.price}</p><span class="b-card-info-price-currency">đ</span></div>
                                            <div class="b-card-info-now-price"><p class="b-card-info-now-price-number">{HOT_SERVICE.price_discount}</p><span class="b-card-info-price-currency">đ</span></div>
                                        </div>
                                        <button class="b-card-info-atc-btn">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            <span class="b-card-info-atc-btn-text">thêm vào giỏ hàng</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- END: hotService -->
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="b-knowledges-wrap">
        <div class="container">
            <div class="b-heading">
                <div class="b-heading-title">
                    <p class="b-heading-sub-title">Bạn đã sẵn sàng để biết ?</p>
                    <h3 class="b-heading-main-title">Những kiến thức hữu ích cho thú cưng</h3>
                </div>
                <div class="b-heading-button">
                    <a href="#" class="b-btn b-btn-line">Xem thêm <i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
            <div class="b-knowledges b-slick b-knowledges-slick">
                <!-- BEGIN: post -->
                <div class="b-knowledge-item-wrap">
                    <a href="#" class="b-knowledge-item">
                        <div class="b-knowledge-item-thumb">
                            <img src="{POST.image}" alt="test">
                        </div>
                        <div class="b-knowledge-info">
                            <p class="b-knowledge-type">Pet knowledge</p>
                            <p class="b-knowledge-title">{POST.title}</p>
                            <p class="b-knowledge-short-desc">{POST.short_description}</p>
                        </div>
                    </a>
                </div>
                <!-- END: post -->
            </div>
        </div>
    </div>
</div>
<!-- END: main -->